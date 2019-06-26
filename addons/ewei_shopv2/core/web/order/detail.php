<?php  if( !defined("IN_IA") )

{

	exit( "Access Denied" );

}

class Detail_EweiShopV2Page extends WebPage

{
	public function main()

	{
		global $_W;

		global $_GPC;

		$id = intval($_GPC["id"]);

		$p = p("commission");

		$item = pdo_fetch("SELECT * FROM " . tablename("ewei_shop_order") . " WHERE id = :id and uniacid=:uniacid", array( ":id" => $id, ":uniacid" => $_W["uniacid"] ));
        //print_r($item);exit;
		$item["statusvalue"] = $item["status"];

		$item["paytypevalue"] = $item["paytype"];

		$isonlyverifygoods = m("order")->checkisonlyverifygoods($item["id"]);

		$order_goods = array( );

		if( 0 < $item["sendtype"] )
		{

			$order_goods = pdo_fetchall("SELECT orderid,goodsid,sendtype,expresssn,expresscom,express,sendtime FROM " . tablename("ewei_shop_order_goods") . "\r\n            WHERE orderid = " . $id . " and sendtime > 0 and uniacid=" . $_W["uniacid"] . " and sendtype > 0 group by sendtype order by sendtime desc ");

			foreach( $order_goods as $key => $value )
			{

				$order_goods[$key]["goods"] = pdo_fetchall("select g.id,g.title,g.thumb,og.sendtype,g.ispresell,og.realprice from " . tablename("ewei_shop_order_goods") . " og " . " left join " . tablename("ewei_shop_goods") . " g on g.id=og.goodsid " . " where og.uniacid=:uniacid and og.orderid=:orderid and og.sendtype=" . $value["sendtype"] . " ", array( ":uniacid" => $_W["uniacid"], ":orderid" => $id ));

			}

			$item["sendtime"] = $order_goods[0]["sendtime"];
		}

		$shopset = m("common")->getSysset("shop");

		if( empty($item) )
		{

			$this->message("抱歉，订单不存在!", referer(), "error");

		}

		if( $_W["ispost"] )
		{
             
			pdo_update("ewei_shop_order", array( "remark" => trim($_GPC["remark"]) ), array( "id" => $item["id"], "uniacid" => $_W["uniacid"] ));

			plog("order.op.remarksaler", "订单保存备注  ID: " . $item["id"] . " 订单号: " . $item["ordersn"]);

			$this->message("订单备注保存成功！", webUrl("order", array( "op" => "detail", "id" => $item["id"] )), "success");

		}

		$member = m("member")->getMember($item["openid"]);
		
		$dispatch = pdo_fetch("SELECT * FROM " . tablename("ewei_shop_dispatch") . " WHERE id = :id and uniacid=:uniacid and merchid=0", array( ":id" => $item["dispatchid"], ":uniacid" => $_W["uniacid"] ));

		if( empty($item["addressid"]) )

		{

			$user = unserialize($item["carrier"]);

			if( $item["storeid"] != 0 && $item["ismerch"] == 0 )

			{

				$user["storename"] = pdo_fetch("SELECT storename FROM " . tablename("ewei_shop_store") . " WHERE id = :id and uniacid=:uniacid and status=1", array( ":id" => $item["storeid"], ":uniacid" => $_W["uniacid"] ));

			}

		}

		else

		{

			$user = iunserializer($item["address"]);

			if( !is_array($user) )

			{

				$user = pdo_fetch("SELECT * FROM " . tablename("ewei_shop_member_address") . " WHERE id = :id and uniacid=:uniacid", array( ":id" => $item["addressid"], ":uniacid" => $_W["uniacid"] ));

			}

			$address_info = $user["address"];

			$user["address"] = $user["province"] . " " . $user["city"] . " " . $user["area"] . " " . $user["street"] . " " . $user["address"];

			$item["addressdata"] = array( "realname" => $user["realname"], "mobile" => $user["mobile"], "address" => $user["address"] );

		}

		$refund = pdo_fetch("SELECT * FROM " . tablename("ewei_shop_order_refund") . " WHERE orderid = :orderid and uniacid=:uniacid order by id desc", array( ":orderid" => $item["id"], ":uniacid" => $_W["uniacid"] ));

		$diyformfields = "";

		$showdiyform = false;

		if( p("diyform") )

		{

			$diyformfields = ",o.diyformfields,o.diyformdata";

		}

		$goods = pdo_fetchall("SELECT op.specs,g.*,o.title as gtitle, o.goodssn as option_goodssn, o.productsn as option_productsn,o.total,g.type,o.optionname,o.optionid,o.price as orderprice,o.realprice,o.changeprice,o.oldprice,o.commission1,o.commission2,o.commission3,o.commissions,o.seckill,o.seckill_taskid,o.seckill_roomid" . $diyformfields . " FROM " . tablename("ewei_shop_order_goods") . " o left join " . tablename("ewei_shop_goods") . " g on o.goodsid=g.id " . " left join " . tablename("ewei_shop_goods_option") . " op on o.optionid=op.id " . " WHERE o.orderid=:orderid and o.uniacid=:uniacid", array( ":orderid" => $id, ":uniacid" => $_W["uniacid"] ));

		$is_merch = false;
// print_r($goods);exit;
		foreach( $goods as &$r )

		{

			$r["seckill_task"] = false;

			if( $r["seckill"] )

			{

				$r["seckill_task"] = plugin_run("seckill::getTaskInfo", $r["seckill_taskid"]);

				$r["seckill_room"] = plugin_run("seckill::getRoomInfo", $r["seckill_taskid"], $r["seckill_roomid"]);

			}

			if( !empty($r["option_goodssn"]) )

			{

				$r["goodssn"] = $r["option_goodssn"];

			}

			if( !empty($r["option_productsn"]) )

			{

				$r["productsn"] = $r["option_productsn"];

			}

			if( p("diyform") )

			{

				$r["diyformfields"] = iunserializer($r["diyformfields"]);

				$r["diyformdata"] = iunserializer($r["diyformdata"]);

			}

			if( !empty($r["merchid"]) )

			{

				$is_merch = true;

			}

			if( !empty($r["diyformdata"]) && $r["diyformdata"] != "false" && !$showdiyform )

			{

				$showdiyform = true;

			}

			if( empty($r["optionname"]) && !empty($r["specs"]) )

			{

				$r["optionname"] = $this->option_title($id);

			}

			if( empty($r["gtitle"]) != true )

			{

				$r["title"] = $r["gtitle"];

			}

		}

		unset($r);

		$item["goods"] = $goods;

		$agents = array( );

		if( $p )

		{

			$agents = $p->getAgents($id);

			$m1 = (isset($agents[0]) ? $agents[0] : false);

			$m2 = (isset($agents[1]) ? $agents[1] : false);

			$m3 = (isset($agents[2]) ? $agents[2] : false);

			$commission1 = 0;

			$commission2 = 0;

			$commission3 = 0;

			foreach( $goods as &$og )

			{

				$oc1 = 0;

				$oc2 = 0;

				$oc3 = 0;

				$commissions = iunserializer($og["commissions"]);

				if( !empty($m1) )

				{

					if( is_array($commissions) )

					{

						$oc1 = (isset($commissions["level1"]) ? floatval($commissions["level1"]) : 0);

					}

					else{

						$c1 = iunserializer($og["commission1"]);

						$l1 = $p->getLevel($m1["openid"]);

						$oc1 = (isset($c1["level" . $l1["id"]]) ? $c1["level" . $l1["id"]] : $c1["default"]);

					}

					$og["oc1"] = $oc1;

					$commission1 += $oc1;

				}

				if( !empty($m2) )
				{

					if( is_array($commissions) )
					{

						$oc2 = (isset($commissions["level2"]) ? floatval($commissions["level2"]) : 0);

					}

					else{

						$c2 = iunserializer($og["commission2"]);

						$l2 = $p->getLevel($m2["openid"]);

						$oc2 = (isset($c2["level" . $l2["id"]]) ? $c2["level" . $l2["id"]] : $c2["default"]);

					}

					$og["oc2"] = $oc2;

					$commission2 += $oc2;

				}

				if( !empty($m3) )
				{

					if( is_array($commissions) )
					{

						$oc3 = (isset($commissions["level3"]) ? floatval($commissions["level3"]) : 0);

					}

					else{

						$c3 = iunserializer($og["commission3"]);

						$l3 = $p->getLevel($m3["openid"]);

						$oc3 = (isset($c3["level" . $l3["id"]]) ? $c3["level" . $l3["id"]] : $c3["default"]);

					}

					$og["oc3"] = $oc3;

					$commission3 += $oc3;

				}

			}

			unset($og);

			$commission_array = array( $commission1, $commission2, $commission3 );

			foreach( $agents as $key => $value )
			{

				$agents[$key]["commission"] = $commission_array[$key];

				if( 2 < $key )

				{

					unset($agents[$key]);

				}

			}

		}

		$condition = " o.uniacid=:uniacid and o.deleted=0";

		$paras = array( ":uniacid" => $_W["uniacid"] );

		$totals = array( );

		$coupon = false;

		if( com("coupon") && !empty($item["couponid"]) )
		{

			$coupon = com("coupon")->getCouponByDataID($item["couponid"]);

		}

		$order_fields = false;

		$order_data = false;

		if( p("diyform") )
		{

			$diyform_set = p("diyform")->getSet();

			foreach( $goods as $g )
			{
				if( !empty($g["diyformdata"]) )
				{
					break;
				}
			}

			if( !empty($item["diyformid"]) )
			{
				$orderdiyformid = $item["diyformid"];
				if( !empty($orderdiyformid) )
				{

					$order_fields = iunserializer($item["diyformfields"]);
					$order_data = iunserializer($item["diyformdata"]);
				}
			}
		}

		if( com("verify") )
		{
			$verifyinfo = iunserializer($item["verifyinfo"]);

			if( !empty($item["verifyopenid"]) )
			{
				$saler = m("member")->getMember($item["verifyopenid"]);

				if( empty($item["merchid"]) )
				{
					$saler["salername"] = pdo_fetchcolumn("select salername from " . tablename("ewei_shop_saler") . " where openid=:openid and uniacid=:uniacid limit 1 ", array( ":uniacid" => $_W["uniacid"], ":openid" => $item["verifyopenid"] ));
				}
				else{
					$saler["salername"] = pdo_fetchcolumn("select salername from " . tablename("ewei_shop_merch_saler") . " where openid=:openid and merchid=:merchid and uniacid=:uniacid limit 1 ", array( ":uniacid" => $_W["uniacid"], ":openid" => $item["verifyopenid"], ":merchid" => $item["merchid"] ));
				}
			}

			if( !empty($item["verifystoreid"]) )
			{
				if( empty($item["merchid"]) )
				{
					$store = pdo_fetch("select * from " . tablename("ewei_shop_store") . " where id=:storeid limit 1 ", array( ":storeid" => $item["verifystoreid"] ));
				}
				else{
					$store = pdo_fetch("select * from " . tablename("ewei_shop_merch_store") . " where id=:storeid limit 1 ", array( ":storeid" => $item["verifystoreid"] ));
				}
			}

			if( !empty($item["storeid"]) )
			{
				if( empty($item["merchid"]) )
				{
					$goodsstore = pdo_fetch("select * from " . tablename("ewei_shop_store") . " where id=:storeid limit 1 ", array( ":storeid" => $item["storeid"] ));
				}
				else{
					$goodsstore = pdo_fetch("select * from " . tablename("ewei_shop_merch_store") . " where id=:storeid limit 1 ", array( ":storeid" => $item["storeid"] ));
				}
			}

			if( $item["isverify"] && is_array($verifyinfo) && empty($item["dispatchtype"]) )
			{

				foreach( $verifyinfo as &$v )
				{

					if( $v["verified"] || $item["verifytype"] == 1 )
					{

						if( empty($item["merchid"]) )
						{
							$v["storename"] = pdo_fetchcolumn("select storename from " . tablename("ewei_shop_store") . " where id=:id limit 1", array( ":id" => $v["verifystoreid"] ));
						}
						else{
							$v["storename"] = pdo_fetchcolumn("select storename from " . tablename("ewei_shop_merch_store") . " where id=:id limit 1", array( ":id" => $v["verifystoreid"] ));
						}

						if( empty($v["storename"]) )
						{
							$v["storename"] = "总店";
						}

						$v["nickname"] = pdo_fetchcolumn("select nickname from " . tablename("ewei_shop_member") . " where openid=:openid and uniacid=:uniacid limit 1", array( ":openid" => $v["verifyopenid"], ":uniacid" => $_W["uniacid"] ));

						if( empty($item["merchid"]) )
						{
							$v["salername"] = pdo_fetchcolumn("select salername from " . tablename("ewei_shop_saler") . " where openid=:openid and uniacid=:uniacid limit 1", array( ":openid" => $v["verifyopenid"], ":uniacid" => $_W["uniacid"] ));
						}
						else {

							$v["salername"] = pdo_fetchcolumn("select salername from " . tablename("ewei_shop_merch_saler") . " where openid=:openid and merchid=:merchid and uniacid=:uniacid limit 1", array( ":openid" => $v["verifyopenid"], ":uniacid" => $_W["uniacid"], ":merchid" => $item["merchid"] ));
						}
					}
				}
				unset($v);
			}

		}

		$verifygoods_list = array( );

		$isonlyverifygoods = m("order")->checkisonlyverifygoods($item["id"]);

		if( $isonlyverifygoods )

		{

			$sql = "select vg.*,vgl.verifydate,vgl.verifynum,s.storename,sa.salername,vgl.remarks  from " . tablename("ewei_shop_verifygoods_log") . "   vgl\r\n                 left join " . tablename("ewei_shop_verifygoods") . " vg on vg.id = vgl.verifygoodsid\r\n                 left join " . tablename("ewei_shop_store") . " s  on s.id = vgl.storeid\r\n                 left join " . tablename("ewei_shop_saler") . " sa  on sa.id = vgl.salerid\r\n                 where  vg.orderid=:orderid ORDER BY vgl.verifydate DESC ";

			$verifygoods_list = pdo_fetchall($sql, array( ":orderid" => $item["id"] ));

			$verifygood = pdo_fetch("select *  from " . tablename("ewei_shop_verifygoods") . "    where orderid =:orderid limit 1  ", array( ":orderid" => $item["id"] ));

			$verifynum = 0;

			foreach( $verifygoods_list as $verifygoodlog )

			{

				$verifynum += intval($verifygoodlog["verifynum"]);

			}

			$verifygoods_times = $verifynum;

			$verifygoods_times_total = intval($verifygood["limitnum"]);

			if( empty($verifygood["limittype"]) )

			{

				$limitdate = date("Y-m-d H:i:s", intval($verifygood["starttime"]) + intval($verifygood["limitdays"]) * 86400);

			}else{

				$limitdate = date("Y-m-d H:i:s", $verifygood["limitdate"]);

			}

			$verifygoods_times_endtime = $limitdate;

		}

		if( !empty($item["headsid"]) && !empty($item["dividend"]) )

		{

			$dividend = iunserializer($item["dividend"]);

			if( !empty($dividend) )

			{

				$dividend_price = (isset($dividend["dividend_price"]) ? floatval($dividend["dividend_price"]) : 0);

			}

			$heads = pdo_fetch("select * from " . tablename("ewei_shop_member") . " where id=:id and uniacid=:uniacid limit 1", array( ":id" => $item["headsid"], ":uniacid" => $_W["uniacid"] ));

		}

		$use_membercard = false;

		$membercard_info = array( );

		if( p("membercard") )

		{

			$ifuse = p("membercard")->if_order_use_membercard($id);

			if( $ifuse )

			{

				$use_membercard = true;

				$card_text = $ifuse["name"] . "优惠";

				$card_dec_price = $ifuse["dec_price"];

			}

		}
        //print_r($item);exit;
		load()->func("tpl");

		include($this->template());

		exit();

	}
	//添加订单商品
	public function ordergoods_add()
	{
		global $_W;
		global $_GPC;
        
		$id = intval($_GPC['id']);  //orderid
		$goodsid = intval($_GPC['goodsid']);

		if($_W["ispost"])
		{
			//print_r($_GPC);exit;
            //会员折扣
        	$goods = pdo_get('ewei_shop_goods', array('id' => $goodsid), array('marketprice','discounts','title','goodssn','productsn','total'));

            $order = pdo_get('ewei_shop_order', array('id' => $id), array('openid','uniacid','price'));
            //会员折扣
            $goods['marketprice'] = m('common')->getmarketprice($order['openid'],$goods['marketprice'],$goods['discounts']);
            
			$data["goodsid"] = $goodsid; 
			$data["openid"] = $order['openid'];
			$data['uniacid'] = $order['uniacid'];
			$data['goodssn'] = $goods['goodssn'];
			$data['productsn'] = $goods['productsn'];
			$data["title"] = $goods['title'];
        	$data["orderid"] = intval($_GPC["id"]);
        	$data['oldprice'] = $order["price"];
        	$data["createtime"] = time();

            $is_order_goods_has = pdo_get('ewei_shop_order_goods', 
            	array('orderid' => $id,'goodsid'=>$goodsid), 
            	array('id','total','price'));

            if(!empty($is_order_goods_has))
            {     
                //总数量
              	$data['total'] = bcadd($is_order_goods_has['total'],intval($_GPC["goods_num"]),2);
              	//单价
              	$price = bcdiv($is_order_goods_has['price'],$is_order_goods_has['total'],2);
              	//单个商品的总价
              	$data["price"] = bcmul($data['total'],$price,2); 
              	//新增的商品新增的差价
              	$offset_price = bcmul(intval($_GPC['goods_num']),floatval($price),2);
              	
                //现在的真实价格
              	$data['realprice'] = $data["price"];
			    
			    pdo_update("ewei_shop_order_goods",$data,array('orderid'=>$id,'goodsid'=>$goodsid));
			   
        	}
        	else
        	{

        		$data['total'] = intval($_GPC["goods_num"]);
        		//单个商品的总价
        		$data["price"] = bcmul(intval($data['total']),floatval($goods['marketprice']),2); 
        		$data['realprice'] = floatval($data["price"]);
                //新增商品的差价
                $offset_price = bcmul(intval($_GPC['goods_num']),floatval($goods['marketprice']),2);

        		pdo_insert("ewei_shop_order_goods",$data);
               
        	}
            //订单总价
        	$oldorderprice = pdo_get('ewei_shop_order',array('id'=>$id),array('goodsprice'))['goodsprice'];
            $orderprice = bcadd($oldorderprice,$offset_price,2);

    		pdo_update("ewei_shop_order",array(
		    	'price' => $orderprice,
		    	'goodsprice' => $orderprice,
		    	'grprice'=>$orderprice,
		    	'oldprice'=>$orderprice
		    ),array('id'=>$id));

		    //减库存
          	$goods['total'] = intval($goods['total'])-intval($_GPC["goods_num"]);
          	if($goods['total']>=0)
               pdo_update("ewei_shop_goods",array('total'=>$goods['total']),array('id'=>$goodsid)); 
          	else
          	    show_json(0,'该商品库存数量不足');
            //扣除预存款
            m('member')->setCredit($order['openid'],"credit2",-$offset_price,$log=array());

        	show_json(1);

        }

        $goods_list = pdo_fetchall('SELECT id as goodsid,title FROM ' . tablename('ewei_shop_goods') . ' WHERE status=1 and total>0 and deleted=0 order by createtime DESC',array());

		include($this->template("order/ordergoods_add"));
	}

	//添加订单商品
	public function ordergoods_edit()
	{
		global $_W;
		global $_GPC;
	}

	//删除订单商品
	public function ordergoods_delete()
	{
        global $_W;
		global $_GPC;
	
        $orderid = intval($_GPC['id']);
		$goodsid = intval($_GPC['goodsid']);

        $order =  pdo_get('ewei_shop_order', array('id' => $_GPC['id']), array('openid','price','goodsprice'));
        $order_goods = pdo_get('ewei_shop_order_goods', array('orderid' => $orderid,'goodsid'=>$goodsid), array('price','total','realprice','title'));
        $goods = pdo_get('ewei_shop_goods',array('id'=>$goodsid),array('total'));

        //订单总金额修改
        $total_price = bcsub(floatval($order['price']),floatval($order_goods['price']),2);

    	pdo_update("ewei_shop_order",array(
    		'price' => $total_price,
	    	'goodsprice' => $total_price,
	    	'grprice'=>$total_price,
	    	'oldprice'=>$total_price
        ),array('id'=>$orderid));

        //加回库存
      	$goods['total'] = intval($goods['total'])+intval($order_goods["total"]);
        pdo_update("ewei_shop_goods",array('total'=>$goods['total']),array('id'=>$goodsid)); 

        //返回预存款
        m('member')->setCredit($order['openid'],"credit2",$order_goods['price'],$log = array());

        pdo_delete('ewei_shop_order_goods', array('orderid'=>$orderid,'goodsid' => $goodsid));
		
		plog('shop.detail.ordergoods_delete', '删除订单商品 订单ID: ' . $orderid . ' 商品名称: ' . $order_goods['title'] . ' ');

		show_json(1, array('url' => referer()));
	}

	public function option_title($orderid)
	{
		global $_W;

		$orderid = intval($orderid);

		$sql = "select o.specs from " . tablename("ewei_shop_order_goods") . " g join " . tablename("ewei_shop_goods_option") . " o on o.id = g.optionid where g.orderid = :orderid";

		$specs = pdo_fetchcolumn($sql, array( ":orderid" => $orderid ));

		$specs_arr = explode("_", $specs);

		$specs = implode(",", $specs_arr);

		$table = tablename("ewei_shop_goods_spec_item");

		$sql = "select title from " . $table . " where id in (" . $specs . ")";

		$title_arr = pdo_fetchall($sql);

		foreach( $title_arr as &$arr )
		{
			$arr = $arr["title"];
		}

		$title = implode("+", $title_arr);

		return $title;

	}

}

?>