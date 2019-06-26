<?php  if( !defined("IN_IA") ) 
{
	exit( "Access Denied" );
}

class Index_EweiShopV2Page extends WebPage 
{
	public function main()
	{
		global $_W;
		global $_GPC;

		$pindex = max(1, intval($_GPC["page"]));
		$psize = 10;
        $params = array();

        $condition = '1';
		
		if( !empty($_GPC["title"]) )
		{
			$_GPC["title"] = trim($_GPC["title"]);
			$condition .= " and name like :title or phone like :title";
			$params[":title"] = "%" . $_GPC["title"] . "%";
		}

		$sql = "SELECT * FROM " . tablename("delivery_staff") . " where " . $condition . "  ORDER BY id DESC,add_time DESC ";

		if( empty($_GPC["export"]) ) 
		{
			$sql .= " limit " . ($pindex - 1) * $psize . "," . $psize;
		}
		else 
		{
			ini_set("memory_limit", "-1");
		}
	   
		$list = pdo_fetchall($sql, $params);

		foreach ($list as &$val) 
		{
			$minfo = pdo_get('ewei_shop_member',array('id'=>$val['mid']),array('openid','nickname'));
			$val['openid'] = $minfo['openid'];
			$val['nickname'] = $minfo['nickname'];
		}

		$total = pdo_fetchcolumn("select count(*) from" . tablename("delivery_staff") . " where " . $condition . " ", $params);
		$pager = pagination2($total, $pindex, $psize);

		include($this->template());
	}

	//新增
	public function add()
	{
	    $this->post();
	}

	//修改
	public function edit()
	{
        $this->post();
	}

	public function post(){
		global $_W;
		global $_GPC;

		$id = intval($_GPC['id']);
		
		if( $_W["ispost"] )
		{
			$data["name"] =trim($_GPC["name"]); 
        	$data["mid"] = intval($_GPC["mid"]);
        	$data["openid"] = pdo_get('ewei_shop_member',array('id'=>$_GPC['mid']),array('openid'))['openid'];
        	$data["phone"] = intval($_GPC["phone"]);
        	$data["delivery_range"] = trim($_GPC["delivery_range"]);
        	$data["workstate"] = intval($_GPC["workstate"]);

            if(!empty($id))
            {
            	$data["update_time"] = time();
			    pdo_update("delivery_staff",$data,array('id'=>$id));
			}
			else{
			 	if(empty($_GPC["mid"])||$_GPC["mid"]==0)
				{
	                show_json(0,'请关联账号');
				}
				if(pdo_get('delivery_staff',array('mid'=>$_GPC["mid"]),'id'))
				{
	                show_json(0,'该账号已关联,请切换其他账号');
				}

	        	$data["add_time"] = time();
				pdo_insert("delivery_staff",$data);
			}

			show_json(1,array('url' => webUrl('peisong')));
		
		}

        $info = pdo_fetch('SELECT * FROM ' . tablename('delivery_staff') . ' WHERE workstate=1 and id=:id', array(':id' => $id));

        $members = pdo_getall('ewei_shop_member', array(), array('id','openid','nickname'));

        include($this->template('peisong/post')); 
	}

	//删除
	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);

		if (empty($id)) {
			$id = is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0;
		}

        $items = pdo_fetchall('SELECT id,name FROM ' . tablename('delivery_staff') . (' WHERE id in( ' . $id . ' )') );
        
        foreach ($items as $item) {

			pdo_delete('delivery_staff', array('id' => $item['id']));

			plog('shop.peisong.delete', '删除配送员 ID: ' . $item['id'] . ' 配送员名称: ' . $item['name'] . ' ');

		}

		show_json(1, array('url' => referer()));
		
	}

}

?>