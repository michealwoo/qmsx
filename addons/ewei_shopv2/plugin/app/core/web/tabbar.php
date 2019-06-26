<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Tabbar_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		$data = m('common')->getSysset('app');

		if (!empty($data)) {
			if (!empty($data['tabbar'])) {
				$tabbar = iunserializer($data['tabbar']);
			}
		}

		$tabbar = json_encode($tabbar);
		include $this->template();
	}

	public function submit()
	{
		global $_W;
		global $_GPC;

		if (!$_W['ispost']) {
			show_json(0, '错误的请求');
		}

		$tabbar = $_GPC['tabbar'];

		if (empty($tabbar)) {
			show_json(0, '提交数据不能为空');
		}

		$data = m('common')->getSysset('app');
		$data['tabbar'] = iserializer($tabbar);
		m('common')->updateSysset(array('app' => $data));
		plog('app.tabbar.main', '保存底部导航');
		show_json(1);
	}
}

?>
