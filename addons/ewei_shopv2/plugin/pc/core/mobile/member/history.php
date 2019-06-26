<?php
if (!(defined("IN_IA"))) 
{
	exit("Access Denied");
}
require EWEI_SHOPV2_PLUGIN . "pc/core/page_login_mobile.php";
class History_EweiShopV2Page extends PcMobileLoginPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		$nav_link_list = array( array('link' => mobileUrl('pc'), 'title' => '首页'), array('link' => mobileUrl('pc.member'), 'title' => '我的商城'), array('title' => '我的足迹') );
		$ice_menu_array = array( array('menu_key' => 'index', 'menu_name' => '我的足迹', 'menu_url' => mobileUrl('pc.member.history')) );
		$all_list = $this->get_list();
		$list = $all_list['list'];
		$pindex = max(1, intval($_GPC['page']));
		$pager = fenye($all_list['total'], $pindex, $all_list['psize']);
		include $this->template();
	}
	public function get_list() 
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and f.uniacid = :uniacid and f.openid=:openid and f.deleted=0';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']);
		$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_member_history') . ' f where 1 ' . $condition;
		$total = pdo_fetchcolumn($sql, $params);
		$sql = 'SELECT f.id,f.goodsid,g.title,g.thumb,g.marketprice,g.productprice,f.createtime,g.merchid FROM ' . tablename('ewei_shop_member_history') . ' f ' . ' right join ' . tablename('ewei_shop_goods') . ' g on f.goodsid = g.id ' . ' where 1 ' . $condition . ' ORDER BY f.`id` DESC LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
		$list = pdo_fetchall($sql, $params);
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if (!(empty($list)) && $merch_plugin && $merch_data['is_openmerch']) 
		{
			$merch_user = $merch_plugin->getListUser($list, 'merch_user');
		}
		foreach ($list as &$row ) 
		{
			$row['createtime'] = date('Y-m-d H:i:s', $row['createtime']);
			$row['thumb'] = tomedia($row['thumb']);
			$row['merchname'] = (($merch_user[$row['merchid']]['merchname'] ? $merch_user[$row['merchid']]['merchname'] : $_W['shopset']['shop']['name']));
		}
		unset($row);
		return array("list" => $list, 'total' => $total, 'psize' => $psize);
	}
	public function remove() 
	{
		global $_W;
		global $_GPC;
		$ids = $_GPC['ids'];
		if (empty($ids) || !(is_array($ids))) 
		{
			show_json(0, '参数错误');
		}
		$sql = 'update ' . tablename('ewei_shop_member_history') . ' set deleted=1 where openid=:openid and id in (' . implode(',', $ids) . ')';
		pdo_query($sql, array(':openid' => $_W['openid']));
		show_json(1);
	}
}
?>