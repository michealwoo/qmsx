<?php

if (!defined('IN_IA')) {

	exit('Access Denied');

}

class Printer_EweiShopV2Page extends WebPage
{
	public function main()
	{

		global $_W;
		global $_GPC;

       // echo print_r($_GPC['idstr']);
        $idstr = rtrim($_GPC['idstr'],',');
        // echo $idstr;exit;
        // $ids = explode(',', $idstr);
        // print_r($ids);exit;
        $orderbuy = "o.id";
        $statuscondition = "";
        $condition = "o.id in(".$idstr.")";

		$sql = "select o.* ,a.realname as arealname,a.mobile as amobile,a.province as aprovince ,a.city as acity , a.area as aarea, a.street as astreet,a.address as aaddress,d.dispatchname,\r\n                  r.rtype,r.status as rstatus,o.sendtype,o.city_express_state from " . tablename("ewei_shop_order") . " o" . " left join " . tablename("ewei_shop_order_refund") . " r on r.id =o.refundid " . " left join " . tablename("ewei_shop_member_address") . " a on a.id=o.addressid " . " left join " . tablename("ewei_shop_dispatch") . " d on d.id = o.dispatchid " . " where " . $condition . " " . $statuscondition . " ORDER BY " . $orderbuy . " DESC  ";

		$params = array(':uniacid' => $_W['uniacid']);

		$list = pdo_fetchall($sql,$params);
        
        foreach ($list as $key => $value) 
        {
        	$list[$key]['goods'] = pdo_fetchall("select g.id,g.title,og.title as gtitle,g.thumb,g.invoice,g.goodssn,og.goodssn as option_goodssn, g.productsn,g.marketprice,og.productsn as option_productsn, og.total,\r\n                    og.price,og.optionname as optiontitle, og.realprice,og.changeprice,og.oldprice,og.commission1,og.commission2,og.commission3,og.commissions,og.diyformdata,\r\n og.diyformfields,op.specs,g.merchid,og.seckill,og.seckill_taskid,og.seckill_roomid,g.ispresell,g.costprice,op.costprice as option_costprice,og.expresssn,og.expresscom,og.express,og.sendtype from " . tablename("ewei_shop_order_goods") . " og " . " left join " . tablename("ewei_shop_goods") . " g on g.id=og.goodsid " . " left join " . tablename("ewei_shop_goods_option") . " op on og.optionid = op.id " . " where og.uniacid=:uniacid and og.orderid=:orderid ", array( ":uniacid" => $_W['uniacid'], ":orderid" => $value["id"] ));
        	$list[$key]['delivery'] = pdo_fetchall("select * from ".tablename("delivery_staff")." where id=".$value['deliveryman_id']." limit 1")[0];
        	$list[$key]['goods_num'] = count($list[$key]['goods']);
        }
		
		$printer_title = $_W['shopset']['shop']['name'];

		include $this->template();
	}

    public function print_tag()
    {
        global $_W;
        global $_GPC;

        $idstr = rtrim($_GPC['idstr'],',');       
        $orderbuy = "o.id";
        $condition = "o.id in(".$idstr.")";

        $sql = "select o.id,o.ordersn,o.price,o.goodsprice,og.total,
            g.unit,concat(ifnull(g.title,''),'/',ifnull(g.unit,'')) as goods_name,
            a.realname as arealname,a.mobile as amobile, a.province as aprovince,
            a.city as acity , a.area as aarea,
            a.street as astreet,a.address as aaddress,
            o.sendtype,o.city_express_state from " . 
            tablename("ewei_shop_order") . " o" . " left join " . 
            tablename("ewei_shop_order_goods") . " og on og.orderid=o.id " . " left join " . 
            tablename("ewei_shop_goods") . " g on g.id=og.goodsid " . " left join " . 
            tablename("ewei_shop_member_address") . " a on a.id=o.addressid " . " where " . $condition . " ORDER BY " . $orderbuy . " DESC  ";

        $params = array(':uniacid' => $_W['uniacid']);

        $list = pdo_fetchall($sql,$params);
        $printer_title = $_W['shopset']['shop']['name'];

        foreach ($list as &$val) 
        {
           $val['fendan'] = $val['total'].$val['unit'];
        }

        include $this->template('order/print_tag');
    }
}

?>

