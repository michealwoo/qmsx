<?php  if( !defined("IN_IA") ) 
{
	exit( "Access Denied" );
}
require(EWEI_SHOPV2_PLUGIN . "merch/core/inc/page_merch.php");
class Index_EweiShopV2Page extends MerchWebPage 
{
	public function main() 
	{
		global $_W;
		include($this->template());
	}
	protected function selectOrderPrice($day = 0, $is_all = false, $is_avg = false) 
	{
		global $_W;
		$day = (int) $day;
		if( $day != 0 ) 
		{
			if( $day == 30 ) 
			{
				$yest = date("Y-m-d");
				$createtime1 = strtotime(date("Y-m-d", strtotime("-30 day")));
				$createtime2 = strtotime((string) $yest . " 23:59:59");
			}
			else 
			{
				if( $day == 7 ) 
				{
					$yest = date("Y-m-d");
					$createtime1 = strtotime(date("Y-m-d", strtotime("-7 day")));
					$createtime2 = strtotime((string) $yest . " 23:59:59");
				}
				else 
				{
					$yesterday = strtotime("-1 day");
					$yy = date("Y", $yesterday);
					$ym = date("m", $yesterday);
					$yd = date("d", $yesterday);
					$createtime1 = strtotime((string) $yy . "-" . $ym . "-" . $yd . " 00:00:00");
					$createtime2 = strtotime((string) $yy . "-" . $ym . "-" . $yd . " 23:59:59");
				}
			}
		}
		else 
		{
			$createtime1 = strtotime(date("Y-m-d", time()));
			$createtime2 = (strtotime(date("Y-m-d", time())) + 3600 * 24) - 1;
		}
		$time = "paytime";
		$where = " and (( status > 0 and (paytime between :createtime1 and :createtime2)) or ((createtime between :createtime1 and :createtime2 ) and status>=0 and paytype=3))";
		if( !empty($is_all) ) 
		{
			$time = "createtime";
			$where = " and createtime between :createtime1 and :createtime2";
		}
		if( !empty($is_avg) ) 
		{
			$time = "paytime";
			$where = " and (status >0 and (paytime between :createtime1 and :createtime2))";
		}
		$sql = "select id,price,openid," . $time . "  from " . tablename("ewei_shop_order") . " where uniacid = :uniacid and merchid = :merchid and ismr=0 and isparent=0  and deleted=0 " . $where;
		$param = array( ":uniacid" => $_W["uniacid"], ":merchid" => $_W["merchid"], ":createtime1" => $createtime1, ":createtime2" => $createtime2 );
		$pdo_res = pdo_fetchall($sql, $param);
		$price = 0;
		$avg = 0;
		$member = array( );
		foreach( $pdo_res as $arr ) 
		{
			$price += $arr["price"];
			$member[] = $arr["openid"];
		}
		if( !empty($is_avg) ) 
		{
			$member_num = count(array_unique($member));
			$avg = (empty($member_num) ? 0 : round($price / $member_num, 2));
		}
		$result = array( "price" => round($price, 2), "count" => count($pdo_res), "avg" => $avg, "fetchall" => $pdo_res );
		return $result;
	}
	protected function selectTransaction(array $pdo_fetchall, $days = 7, $is_all = false) 
	{
		$transaction = array( );
		$days = (int) $days;
		if( !empty($pdo_fetchall) ) 
		{
			for( $i = $days; 1 <= $i; $i-- ) 
			{
				$transaction["price"][date("Y-m-d", time() - $i * 3600 * 24)] = 0;
				$transaction["count"][date("Y-m-d", time() - $i * 3600 * 24)] = 0;
			}
			if( empty($is_all) ) 
			{
				foreach( $pdo_fetchall as $key => $value ) 
				{
					if( array_key_exists(date("Y-m-d", $value["paytime"]), $transaction["price"]) ) 
					{
						$transaction["price"][date("Y-m-d", $value["paytime"])] += $value["price"];
						$transaction["count"][date("Y-m-d", $value["paytime"])] += 1;
					}
				}
			}
			else 
			{
				foreach( $pdo_fetchall as $key => $value ) 
				{
					if( array_key_exists(date("Y-m-d", $value["createtime"]), $transaction["price"]) ) 
					{
						$transaction["price"][date("Y-m-d", $value["createtime"])] += $value["price"];
						$transaction["count"][date("Y-m-d", $value["createtime"])] += 1;
					}
				}
			}
			return $transaction;
		}
		else 
		{
			return array( );
		}
	}
	public function ajaxorder() 
	{
		global $_GPC;
		$day = (int) $_GPC["day"];
		$order = $this->selectOrderPrice($day);
		unset($order["fetchall"]);
		$allorder = $this->selectOrderPrice($day, true);
		unset($allorder["fetchall"]);
		$avg = $this->selectOrderPrice($day, true, true);
		unset($allorder["fetchall"]);
		$order = array( "order_count" => $order["count"], "order_price" => $order["price"], "allorder_count" => $allorder["count"], "allorder_price" => $allorder["price"], "avg" => $avg["avg"] );
		show_json(1, array( "order" => $order ));
	}
	public function ajaxtransaction() 
	{
		$orderPrice = $this->selectOrderPrice(7);
		$transaction = $this->selectTransaction($orderPrice["fetchall"], 7);
		if( empty($transaction) ) 
		{
			for( $i = 7; 1 <= $i; $i-- ) 
			{
				$transaction["price"][date("Y-m-d", time() - $i * 3600 * 24)] = 0;
				$transaction["count"][date("Y-m-d", time() - $i * 3600 * 24)] = 0;
			}
		}
		$allorderPrice = $this->selectOrderPrice(7, true);
		$alltransaction = $this->selectTransaction($allorderPrice["fetchall"], 7, true);
		if( empty($transaction) ) 
		{
			for( $i = 7; 1 <= $i; $i-- ) 
			{
				$alltransaction["price"][date("Y-m-d", time() - $i * 3600 * 24)] = 0;
				$alltransaction["count"][date("Y-m-d", time() - $i * 3600 * 24)] = 0;
			}
		}
		echo json_encode(array( "price_key" => array_keys($transaction["price"]), "price_value" => array_values($transaction["price"]), "count_value" => array_values($transaction["count"]), "allprice_value" => array_values($alltransaction["price"]), "allcount_value" => array_values($alltransaction["count"]) ));
	}
}
?>