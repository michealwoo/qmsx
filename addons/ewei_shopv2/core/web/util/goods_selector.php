<?php
if (!(defined('IN_IA'))) 
{
	exit('Access Denied');
}
class Goods_selector_EweiShopV2Page extends WebPage 
{
	public function main($page = 0) 
	{
		global $_GPC;
		global $_W;
		$page = ((empty($page) ? max(1, (int) $_GPC['page']) : $page));
		$page_size = 8;
		$page_start = ($page - 1) * $page_size;
		$condition = '';
		if (!(empty($_GPC['condition']))) 
		{
			$condition = base64_decode(trim($_GPC['condition']));
		}
		$params = array(':uniacid' => $_W['uniacid']);
		$keywords = trim($_GPC['keywords']);
		if (!(empty($keywords))) 
		{
			$params[':title'] = '%' . $keywords . '%';
			$keywords = 'and title like :title ';
		}
		$goodsgroup = intval($_GPC['goodsgroup']);
		$goodsgroup_where = '';
		if (!(empty($goodsgroup))) 
		{
			$goodsgroup_where = ' and (find_in_set(\'' . $goodsgroup . '\',ccates) or find_in_set(\'' . $goodsgroup . '\',pcates) or find_in_set(\'' . $goodsgroup . '\',tcates)) ';
		}
		if ($_GPC['platform'] == 'wxapp') 
		{
			$condition .= ' and type != 4 ';
		}
		if ((int) $_GPC['merchid']) 
		{
			$condition .= ' and merchid = ' . (int) $_GPC['merchid'];
		}
		$limit = 'limit ' . $page_start . ',' . $page_size;
		if (trim($_GPC['creditshop']) == 1) 
		{
			$query_field = 'id,title,hasoption,price as marketprice,thumb,total, credit';
			$tablename = tablename('ewei_shop_creditshop_goods');
			$condition .= ' AND deleted=0 ';
		}
		else if (trim($_GPC['group']) == 1) 
		{
			$query_field = 'id,title,stock as total,groupsprice as marketprice,thumb';
			$tablename = tablename('ewei_shop_groups_goods');
		}
		else 
		{
			$query_field = 'id,title,total,hasoption,marketprice,thumb,minprice,bargain,sales';
			$tablename = tablename('ewei_shop_goods');
			$condition .= ' AND status=1  AND deleted=0 AND bargain=0 AND checked=0';
		}
		if (($_GPC['pagetype'] != 2) && (trim($_GPC['group']) != 1)) 
		{
			$condition .= ' AND type<>9';
		}
		if (intval($_GPC['quick']) == 1) 
		{
			$condition .= ' AND type<>4';
		}
		$query_sql = 'select ' . $query_field . ' from ' . $tablename . ' where uniacid = :uniacid ' . $condition . ' ' . $goodsgroup_where . $keywords;
		$count_field = 'count(*)';
		$count_sql = str_replace($query_field, $count_field, $query_sql);
		$query_sql .= $limit;
		$list = pdo_fetchall($query_sql, $params);
		if (!(empty($list))) 
		{
			foreach ($list as &$li ) 
			{
				$li['thumb'] = tomedia($li['thumb']);
			}
		}
		$count = pdo_fetchcolumn($count_sql, $params);
		$page_num = ceil($count / $page_size);
		$total = $page_num;
		$i = 1;
		while ($page_num) 
		{
			$page_num_arr[] = $i++;
			--$page_num;
		}
		$slice = 0;
		if (6 < $page) 
		{
			$slice = $page - 6;
		}
		is_array($page_num_arr) && ($page_num_arr = array_slice($page_num_arr, $slice, 10));
		if (empty($list) && ($page !== 1)) 
		{
			$this->main(1);
		}
		else 
		{
			include $this->template('util/goods_selector');
		}
	}
	public function op() 
	{
		global $_GPC;
		global $_W;
		$column = json_decode(htmlspecialchars_decode(urldecode(trim($_GPC['column']))), 1);
		if (is_array($column)) 
		{
			foreach ($column as $ck => &$c ) 
			{
				if (is_string($c)) 
				{
					$c = array('name' => $ck, 'title' => $c);
				}
				else 
				{
					if (is_array($c) && !(empty($c['title']))) 
					{
						if (empty($c['name'])) 
						{
							$c['name'] = $ck;
						}
						continue;
					}
					show_json(0, 'column参数不合法');
				}
			}
		}
		$id = intval($_GPC['id']);
		$sql = 'select * from ' . tablename('ewei_shop_goods') . ' where id = ' . $id;
		$goods = pdo_fetch($sql);
		if (empty($goods)) 
		{
			show_json(0, '此商品已经不存在,请移除');
		}
		if (empty($_GPC['nooption'])) 
		{
			$sql = 'select * from ' . tablename('ewei_shop_goods_option') . ' where goodsid = ' . $id;
			$options = pdo_fetchall($sql);
		}
		include $this->template('util/goods_selector_op');
	}
	public function js() 
	{
		global $_W;
		include $this->template('util/goods_selector_js');
	}
	public function getcate() 
	{
		$category = m('shop')->getAllCategory();
		header('Content-type: application/json');
		exit(json_encode($category));
	}
}
?>