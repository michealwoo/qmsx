<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Sale_pricelog_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

        $pindex = max(1, intval($_GPC["page"]));
		$psize = 10;
        $params = array();

        $condition = '';
		
		if( !empty($_GPC["title"]) )
		{
			$_GPC["title"] = trim($_GPC["title"]);
			$condition .= " name like :title or phone like :title or id like :title";
			$params[":name"] = "%" . $_GPC["title"] . "%";
		}
    
		$sql = "select id,title,marketprice,status,createtime from " . tablename("ewei_shop_goods") . " where 1" . $condition . "  ORDER BY id DESC,createtime DESC ";

		if( empty($_GPC["export"]) ) 
		{
			$sql .= " limit " . ($pindex - 1) * $psize . "," . $psize;
		}
		else 
		{
			ini_set("memory_limit", "-1");
		}
	
		$list = pdo_fetchall($sql, $params);
        
        foreach ($list as &$val) {
        	$val['status'] =  $val['status']==0?'<i style="color:red;">未上架</i>':'<i style="color:green;">已上架</i>';
        }

		$total = pdo_fetchcolumn("select count(*) from" . tablename("ewei_shop_goods") . " where 1" . $condition . " ", $params);

		$pager = pagination2($total, $pindex, $psize);

		include $this->template('statistics/list');
	}

	//商品价格走势图
	public function detail($id='')
	{
		global $_W;
		global $_GPC;

		$goodsid = $_GPC['id'];

		if( empty($_GPC['time']['start']) || empty($_GPC['time']['end']) ) 
		{
			$starttime = strtotime("-1 month");
			$endtime = time();	
		}else{
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
		}
      
		$sql = " SELECT * FROM " . tablename('price_log') . ' WHERE goodsid='.$goodsid.' and createtime >= '.$starttime.' and createtime<='.$endtime.' order by createtime ASC';

		$list = pdo_fetchall($sql);
        
        $goodsname = pdo_get('ewei_shop_goods',array('id'=>$goodsid),array('title'))['title'];

		foreach ($list as &$val) {
			 $info['date'][] = date('Y-m-d H:i:s',$val['createtime']);
			 $info['prices'][] = $val['quotedprice'];
		}
        
        $id = $_GPC['id'];

        if ($_GPC['export'] == 1) 
        {

			m('excel')->export($info, array(

				'title'   => '价格变动统计-' . date('Y-m-d-H-i', time()),

				'columns' => array(

					array('title' => '日期', 'field' => 'date', 'width' => 24),

					array('title' => '价格', 'field' => 'prices', 'width' => 12),

					)

				));

			plog('statistics.sale_pricelog.detail.export', '价格变动统计');

		}

		$data = json_encode($info,JSON_UNESCAPED_UNICODE);

      	include $this->template('statistics/sale_pricelog');
	}
}

?>
