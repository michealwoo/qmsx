<?php  if( !defined("IN_IA") ) 
{
	exit( "Access Denied" );
}
require(EWEI_SHOPV2_PLUGIN . "app/core/page_mobile.php");
class Op_EweiShopV2Page extends AppMobilePage 
{
	public function cancel() 
	{
		global $_W;
		global $_GPC;
		$orderid = intval($_GPC["id"]);
		if( empty($orderid) ) 
		{
			app_error(AppError::$ParamsError);
		}
		$order = pdo_fetch("select id,ordersn,openid,status,deductcredit,deductcredit2,deductprice,couponid,`virtual`,`virtual_info`,merchid  from " . tablename("ewei_shop_order") . " where id=:id and uniacid=:uniacid and openid=:openid limit 1", array( ":id" => $orderid, ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"] ));
		if( empty($order) ) 
		{
			app_error(AppError::$OrderNotFound);
		}
		if( 0 < $order["status"] ) 
		{
			app_error(AppError::$OrderCannotCancel);
		}
		if( $order["status"] < 0 ) 
		{
			app_error(AppError::$OrderCannotCancel);
		}
		if( !empty($order["virtual"]) && $order["virtual"] != 0 ) 
		{
			$goodsid = pdo_fetch("SELECT goodsid FROM " . tablename("ewei_shop_order_goods") . " WHERE uniacid = " . $_W["uniacid"] . " AND orderid = " . $order["id"]);
			$typeid = $order["virtual"];
			$vkdata = ltrim($order["virtual_info"], "[");
			$vkdata = rtrim($vkdata, "]");
			$arr = explode("}", $vkdata);
			foreach( $arr as $k => $v ) 
			{
				if( !$v ) 
				{
					unset($arr[$k]);
				}
			}
			$vkeynum = count($arr);
			pdo_query("update " . tablename("ewei_shop_virtual_data") . " set openid=\"\",usetime=0,orderid=0,ordersn=\"\",price=0,merchid=" . $order["merchid"] . " where typeid=" . intval($typeid) . " and orderid = " . $order["id"]);
			pdo_query("update " . tablename("ewei_shop_virtual_type") . " set usedata=usedata-" . $vkeynum . " where id=" . intval($typeid));
		}
		m("order")->setStocksAndCredits($orderid, 2);
		if( 0 < $order["deductprice"] ) 
		{
			m("member")->setCredit($order["openid"], "credit1", $order["deductcredit"], array( "0", $_W["shopset"]["shop"]["name"] . "购物返还抵扣积分 积分: " . $order["deductcredit"] . " 抵扣金额: " . $order["deductprice"] . " 订单号: " . $order["ordersn"] ));
		}
		m("order")->setDeductCredit2($order);
		if( com("coupon") && !empty($order["couponid"]) ) 
		{
			com("coupon")->returnConsumeCoupon($orderid);
		}
		pdo_update("ewei_shop_order", array( "status" => -1, "canceltime" => time(), "closereason" => trim($_GPC["remark"]) ), array( "id" => $order["id"], "uniacid" => $_W["uniacid"] ));
		m("notice")->sendOrderMessage($orderid);
		app_json();
	}
	public function finish() 
	{
		global $_W;
		global $_GPC;
		$orderid = intval($_GPC["id"]);
		if( empty($orderid) ) 
		{
			app_error(AppError::$ParamsError);
		}
		$order = pdo_fetch("select id,status,openid,couponid,refundstate,refundid from " . tablename("ewei_shop_order") . " where id=:id and uniacid=:uniacid and openid=:openid limit 1", array( ":id" => $orderid, ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"] ));
		if( empty($order) ) 
		{
			app_error(AppError::$OrderNotFound);
		}
		if( $order["status"] != 2 ) 
		{
			app_error(AppError::$OrderCannotFinish);
		}
		if( 0 < $order["refundstate"] && !empty($order["refundid"]) ) 
		{
			$change_refund = array( );
			$change_refund["status"] = -2;
			$change_refund["refundtime"] = time();
			pdo_update("ewei_shop_order_refund", $change_refund, array( "id" => $order["refundid"], "uniacid" => $_W["uniacid"] ));
		}
		pdo_update("ewei_shop_order", array( "status" => 3, "finishtime" => time(), "refundstate" => 0 ), array( "id" => $order["id"], "uniacid" => $_W["uniacid"] ));
		m("order")->setStocksAndCredits($orderid, 3);
		m("order")->fullback($orderid);
		m("member")->upgradeLevel($order["openid"], $orderid);
		m("order")->setGiveBalance($orderid, 1);
		if( com("coupon") ) 
		{
			com("coupon")->sendcouponsbytask($orderid);
		}
		if( com("coupon") && !empty($order["couponid"]) ) 
		{
			com("coupon")->backConsumeCoupon($orderid);
		}
		m("notice")->sendOrderMessage($orderid);
		if( p("commission") ) 
		{
			p("commission")->checkOrderFinish($orderid);
		}
		app_json();
	}
	public function delete() 
	{
		global $_W;
		global $_GPC;
		$orderid = intval($_GPC["id"]);
		$userdeleted = intval($_GPC["userdeleted"]);
		if( empty($orderid) ) 
		{
			app_error(AppError::$ParamsError);
		}
		$order = pdo_fetch("select id,status,refundstate,refundid from " . tablename("ewei_shop_order") . " where id=:id and uniacid=:uniacid and openid=:openid limit 1", array( ":id" => $orderid, ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"] ));
		if( empty($order) ) 
		{
			app_error(AppError::$OrderNotFound);
		}
		if( $userdeleted == 0 ) 
		{
			if( $order["status"] != 3 ) 
			{
				app_error(AppError::$OrderCannotRestore);
			}
		}
		else 
		{
			if( $order["status"] != 3 && $order["status"] != -1 ) 
			{
				app_error(AppError::$OrderCannotDelete);
			}
			if( 0 < $order["refundstate"] && !empty($order["refundid"]) ) 
			{
				$change_refund = array( );
				$change_refund["status"] = -2;
				$change_refund["refundtime"] = time();
				pdo_update("ewei_shop_order_refund", $change_refund, array( "id" => $order["refundid"], "uniacid" => $_W["uniacid"] ));
			}
		}
		pdo_update("ewei_shop_order", array( "userdeleted" => $userdeleted, "refundstate" => 0 ), array( "id" => $order["id"], "uniacid" => $_W["uniacid"] ));
		app_json();
	}
}
?>