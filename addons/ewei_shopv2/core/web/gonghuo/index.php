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

        $condition = '';
		
		if( !empty($_GPC["title"]) )
		{
			$_GPC["title"] = trim($_GPC["title"]);
			$condition .= " and name like :title or phone like :title";
			$params[":title"] = "%" . $_GPC["title"] . "%";
		}

		$sql = "select * from " . tablename("supplier") . " where 1 " . $condition . "  ORDER BY id DESC,add_time DESC ";

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

		$total = pdo_fetchcolumn("select count(*) from" . tablename("supplier") . " where 1 " . $condition . " ", $params);
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
    public function post()
    {
        global $_W;
		global $_GPC;

		$id = intval($_GPC['id']);
		if( $_W["ispost"] )
		{
			$data["name"] = trim($_GPC['name']);
			$data["mid"] = intval($_GPC['mid']);
			$data["openid"] = pdo_get('ewei_shop_member',array('id'=>$_GPC['mid']),array('openid'))['openid'];
			$data["phone"] = trim($_GPC['phone']);
			$data["company"] = trim($_GPC['company']);
			$data["address"] = trim($_GPC['address']);
			$data["content"] = trim($_GPC['content']);
			$data["is_dps"] = intval($_GPC['is_dps']);

	        if(!empty($id))
	        {   
			 	$data["update_time"] = time();
			    pdo_update("supplier",$data,array('id'=>$id));
			}
			else{
				if(empty($_GPC["mid"])||$_GPC["mid"]==0)
				{
	                show_json(0,'请关联账号');
				}
				if(pdo_get('supplier',array('mid'=>$_GPC["mid"]),'id'))
				{
	                show_json(0,'该账号已关联,请切换其他账号');
				}
		     	$data["add_time"] = time();
				pdo_insert("supplier",$data);
			}
			show_json(1,array('url' => webUrl('gonghuo')));
		}

		$info = pdo_fetch('SELECT * FROM ' . tablename('supplier') . ' WHERE id=:id', array(':id' => $_GPC['id']));

		$members = pdo_getall('ewei_shop_member', array(), array('id','openid','nickname'));
        
        include($this->template('gonghuo/post')); 
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
        
        $items = pdo_fetchall('SELECT id,name FROM ' . tablename('supplier') . (' WHERE id in( ' . $id . ' )') );
        
        foreach ($items as &$item) 
        {
        	pdo_delete('supplier', array('id' => $item['id']));
			plog('shop.gonghuo.delete', '删除供货商 ID: ' . $item['id'] . ' 供货商名称: ' . $item['name'] . ' ');
		}

		show_json(1, array('url' => referer()));

	}	
	//供货商报价
	public function quote()
	{
		global $_W;
		global $_GPC;

		$pindex = max(1, intval($_GPC["page"]));
		$psize = 10;
        $params = array(':supplierid'=>$_GPC['id']);

		if( !empty($_GPC["title"]) )
		{
			$condition = 'q.supplierid=:supplierid';
			$_GPC["title"] = trim($_GPC["title"]);
			$condition .= " and g.title like :title";
			$params[":title"] = "%" . $_GPC["title"] . "%";

			$sql = "SELECT * FROM " . tablename("quote") ." q ". 
		       "left join" . tablename('ewei_shop_goods').' g on g.id=q.goodsid'.
		       " where " . $condition . 
		       " ORDER BY q.id DESC,q.createtime DESC";
		}
		else{
			$condition = 'supplierid=:supplierid';
			$sql = "SELECT * FROM " . tablename("quote") .
		       " where " . $condition . 
		       " ORDER BY id DESC,createtime DESC";
		}

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
	        $val['suppliername'] = pdo_get('supplier',array('id'=>$val['supplierid']),array('name'))['name'];
	        $goods = pdo_get('ewei_shop_goods',array('id'=>$val['goodsid']),array('title','marketprice'));
	        $val['goodsname'] = $goods['title'];
	        $val['marketprice'] = $goods['marketprice'];
	        $val['verify_num'] = $val['verify']; 
	        $val['verify'] = $val['verify']==1?'<i style="color:green;">已审核</i>':'未审核';
	        if(!$val['updatetime'])
	        {
	            $val['updatetime']='未修改';
	        }else{
	        	$val['updatetime'] = date('Y-m-d',$row['updatetime'])."<br/>".date('H:i:s',$row['updatetime']);
	        }
		}

		$total = pdo_fetchcolumn("select count(*) from" . tablename("quote") . " where 1 " . $condition . " ", $params);
		$pager = pagination2($total, $pindex, $psize);

        $id = intval($_GPC['id']);
        
        include($this->template('gonghuo/quote')); 
	}
	//已读未读
	public function isread()
	{
		global $_W;
		global $_GPC;
   
        if($_GPC['type']=='quote') 
        {
            $result = pdo_update('quote',array('isread'=>$_GPC['isread'],'updatetime'=>time()),array('id'=>$_GPC['id']));
	        if(!empty($result))
	        {
	            show_json(1);
	        }
        }elseif ($_GPC['type']=='bid') 
        {
        	$result = pdo_update('bid',array('isread'=>$_GPC['isread'],'updatetime'=>time()),array('id'=>$_GPC['id']));
	        if(!empty($result))
	        {
	            show_json(1);
	        }
        }
       
	}
    //修改报价价格
	public function change()
	{
		global $_W;
		global $_GPC;
   
        if($_GPC['type']=='quotedprice') 
        {
            $result = pdo_update('quote',array('quotedprice'=>$_GPC['value'],'updatetime'=>time()),array('id'=>$_GPC['id']));
        
	        if(!empty($result)){
	            show_json(1);
	        }
        }elseif ($_GPC['type']=='bidprice') 
        {
        	$result = pdo_update('bid',array('bidprice'=>$_GPC['value'],'updatetime'=>time()),array('id'=>$_GPC['id']));
	        if(!empty($result)){
	            show_json(1);
	        }
        }
	}
	//供货商报价审核通过
	public function verify()
	{
		global $_W;
		global $_GPC;

        if(empty($_GPC['id'])){
           	show_json(0,"缺少参数");
        }

        //竞价
        if(!empty($_GPC['verify']))
        {
        	if($_GPC['verify']==1) 
        	{   //0-未审核 1-审核通过 2-拒绝
                $result = pdo_update('bid',array('verify'=>$_GPC['verify'],'updatetime'=>time()),array('id'=>$_GPC['id']));
		        if (!empty($result)) 
		        {
		        	//修改价格和供货商
		        	$info = pdo_get('bid',array('id'=>$_GPC['id']),array('goodsid','bidprice','supplierid','marketprice'));
		        	$goods = pdo_update('ewei_shop_goods',array(
	        		   'marketprice'=>$info['bidprice'],
	        		   'supplier_id'=>$info['supplierid'],
	        	       'updatetime'=>time()),
	        		array('id'=>$info['goodsid']));
		            //写入价格变动日志
		            pdo_insert('price_log',array(
	        		   'quotedprice'=>$info['bidprice'],
	        		   'supplierid'=>$info['supplierid'],
	                   'goodsid'=>$info['goodsid'],
	                   'marketprice'=>$info['marketprice'],
	                   'createtime'=>time())
		            );
				}
        	}
        	else
        	{
        		pdo_update('bid',array('verify'=>$_GPC['verify'],'updatetime'=>time()),array('id'=>$_GPC['id']));

        	}
        	show_json(1,'操作成功');
        }
        //报价
        else
        {
        	$result = pdo_update('quote',array('verify'=>1,'updatetime'=>time()),array('id'=>$_GPC['id']));
	        if (!empty($result)) 
	        {
	        	//修改价格和供货商
	        	$info = pdo_get('quote',array('id'=>$_GPC['id']),array('goodsid','quotedprice','supplierid','marketprice'));
	        	pdo_update('ewei_shop_goods',array(
        		   'marketprice'=>$info['quotedprice'],
        		   'supplier_id'=>$info['supplierid'],
        	       'updatetime'=>time()),
        		array('id'=>$info['goodsid']));
	            //写入价格变动日志
	            pdo_insert('price_log',array(
        		   'quotedprice'=>$info['quotedprice'],
        		   'supplierid'=>$info['supplierid'],
                   'goodsid'=>$info['goodsid'],
                   'marketprice'=>$info['marketprice'],
                   'createtime'=>time())
	            );
				show_json(1,'审核通过');
			}
        }
	}
	//供货商报价详情
	public function quote_info()
	{
		global $_W;
		global $_GPC;

        if($id == $_GPC['id']){
           	show_json(0,"缺少参数");
        }

        $info = pdo_get('quote',array('id'=>$_GPC['id']),array());

        $info['suppliername'] = pdo_get('supplier',array('id'=>$info['supplierid']),'name')['name'];
        $info['goodsname'] = pdo_get('ewei_shop_goods',array('id'=>$info['goodsid']),'title')['title'];

        include($this->template('gonghuo/quote_info')); 
	}
	
	//竞价供货商管理
	public function bid_supplier()
	{
		global $_W;
		global $_GPC;

		$pindex = max(1, intval($_GPC["page"]));
		$psize = 10;
        $params = array();

        $condition = 'is_dps = 1';
		
		if( !empty($_GPC["title"]) )
		{
			$condition .= " and name like :title ";
			$params[":title"] = "%" . trim($_GPC["title"]) . "%";
		}

	    $sql = "SELECT * FROM " . tablename("supplier") . " where " . $condition . "  
		         ORDER BY id DESC,add_time DESC ";

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

		$total = pdo_fetchcolumn("select count(*) from" . tablename("supplier") . " where " . $condition . " ", $params);
		$pager = pagination2($total, $pindex, $psize);

        include($this->template('gonghuo/bid_supplier')); 
	}

	//添加竞价供货商
	public function bid_supplier_add()
	{
        global $_W;
		global $_GPC;
        
		if($_W["ispost"])
		{    
			//已经是竞价供货商
			if(pdo_update('supplier',array('is_dps'=>1),array('id'=>$_GPC['id'])))
			{
				show_json(1,'添加成功');
			}
		}
        
        $list = pdo_fetchall("SELECT id,name,company FROM ".tablename('supplier')."  where is_dps=0", array(), array());
       
		foreach ($list as &$val) 
		{
			$val['name'] = $val['company'].' '.$val['name'];
		}

		include($this->template('gonghuo/bid_supplier_add')); 

	}

    //删除竞价供货商
	public function del_bid_supplier()
	{
        global $_W;
		global $_GPC;

		if($_W["ispost"])
		{
	        //已经是竞价供货商
			if(pdo_update('supplier',array('is_dps'=>0),array('id'=>$_GPC['id'])))
			{
				show_json(1,'删除成功');
			}
		}
	}
	
	//供货商竞价列表
	public function bid()
	{
		global $_W;
		global $_GPC;

        $pindex = max(1, intval($_GPC["page"]));
		$psize = 10;

        $params = array(':supplierid'=>$_GPC['id']);

		if( !empty($_GPC["title"]) )
		{
			$condition = 'b.supplierid=:supplierid';
			$_GPC["title"] = trim($_GPC["title"]);
			$condition .= " and g.title like :title";
			$params[":title"] = "%" . $_GPC["title"] . "%";

			$sql = "SELECT * FROM " . tablename("bid") ." b ". 
		       " left join" . tablename('ewei_shop_goods').' g on g.id=b.goodsid'.
		       " where " . $condition . 
		       " ORDER BY b.id DESC,b.createtime DESC";
		}
		else{
			$condition = 'supplierid=:supplierid';
			$sql = "SELECT * FROM " . tablename("bid") .
		       " where " . $condition . 
		       " ORDER BY id DESC,createtime DESC";
		}

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
	        $val['suppliername'] = pdo_get('supplier',array('id'=>$val['supplierid']),array('name'))['name'];
	        $goods = pdo_get('ewei_shop_goods',array('id'=>$val['goodsid']),array('title','marketprice'));
	        $val['goodsname'] = $goods['title'];
	        $val['marketprice'] = $goods['marketprice'];
	        switch ($val['verify']) {
	        	case '0':
	        		$val['verify'] = '未审核';
	        		break;
	        	case '1':
	        		$val['verify'] = '<i style="color:green;">已通过</i>';
	        		break;
	            case '2':
	        		$val['verify'] = '<i style="color:red;">已拒绝</i>';
	        		break;
	        }

	        if(!$val['updatetime'])
	        {
	            $val['updatetime']='未修改';
	        }else{
	        	$val['updatetime'] = date('Y-m-d',$row['updatetime'])."<br/>".date('H:i:s',$row['updatetime']);
	        }
	    
		}

		$total = pdo_fetchcolumn("select count(*) from" . tablename("bid") . " where 1 " . $condition . " ", $params);
		$pager = pagination2($total, $pindex, $psize);

        $id = intval($_GPC['id']);
        
        include($this->template('gonghuo/bid')); 
	}

   //供货商竞价价详情
	public function bid_info()
	{
		global $_W;
		global $_GPC;

        if($id == $_GPC['id']){
           	show_json(0,"缺少参数");
        }

        $info = pdo_get('bid',array('id'=>$_GPC['id']),array());

        switch ($info['verify']) 
        {
        	case '0':
        		$info['verify'] = '未审核';
        		break;
        	case '1':
        		$info['verify'] = '<i style="color:green;">已通过</i>';
        		break;
            case '2':
        		$info['verify'] = '<i style="color:red;">已拒绝</i>';
        		break;
        }

        $info['suppliername'] = pdo_get('supplier',array('id'=>$info['supplierid']),array('name'))['name'];
        $goods = pdo_get('ewei_shop_goods',array('id'=>$info['goodsid']),array('title','marketprice'));
        $info['goodsname'] = $goods['title'];
        $info['marketprice'] = $goods['marketprice'];
  
        include($this->template('gonghuo/bid_info'));
	}

	//竞价供货商申请
	public function bid_apply()
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
			$condition .= " name like :title or phone like :title or company like :title";
			$params[":title"] = "%" . $_GPC["title"] . "%";
		}

		$sql = "select * from " . tablename("bid_apply") . " where 1 " . $condition . " ORDER BY id DESC,createtime DESC ";

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
          $val['createtime'] = date('Y-m-d H:i:s',$val['createtime']);
          if(!$val['telephone']) $val['telephone']='未填写';
          if(!$val['msg']) $val['msg']='未填写'; 
        }
		$total = pdo_fetchcolumn("select count(*) from" . tablename("bid_apply") . " where 1 " . $condition . " ", $params);
		$pager = pagination2($total, $pindex, $psize);

        include($this->template('gonghuo/bid_apply')); 
	}

	//竞价供货商详情
    public function bid_apply_info()
	{
		global $_W;
		global $_GPC;

        if($id == $_GPC['id'])
        {
           	show_json(0,"缺少参数");
        }

        $info = pdo_get('bid_apply',array('id'=>$_GPC['id']),array());
         
        $info['createtime'] = date('Y-m-d H:i:s',$info['createtime']);
        if(!$info['telephone']) $info['telephone']='未填写';
        if(!$info['msg']) $info['msg']='未填写'; 

        include($this->template('gonghuo/bid_apply_info')); 
	}

}

?>