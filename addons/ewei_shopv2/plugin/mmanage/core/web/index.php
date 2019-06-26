<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		include $this->template();
	}

	public function setting()
	{
		global $_W;
		global $_GPC;
		$data = m('common')->getPluginset('mmanage');

		if ($_W['ispost']) {
			$arr = array('keyword' => trim($_GPC['keyword']), 'title' => trim($_GPC['title']), 'thumb' => trim($_GPC['thumb']), 'desc' => trim($_GPC['desc']), 'status' => intval($_GPC['status']), 'open' => intval($_GPC['open']));

			if (!empty($arr['keyword'])) {
				if ($arr['keyword'] != $data['keyword']) {
					$result = m('common')->keyExist($arr['keyword']);

					if (!empty($result)) {
						show_json(0, '关键字已存在');
					}
				}

				$rule = pdo_fetch('select * from ' . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name  limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':name' => 'ewei_shopv2:mmanage'));

				if (!empty($rule)) {
					pdo_update('rule_keyword', array('content' => $arr['keyword']), array('rid' => $rule['id']));
				}
				else {
					$rule_data = array('uniacid' => $_W['uniacid'], 'name' => 'ewei_shopv2:mmanage', 'module' => 'ewei_shopv2', 'displayorder' => 0, 'status' => 1);
					pdo_insert('rule', $rule_data);
					$rid = pdo_insertid();
					$keyword_data = array('uniacid' => $_W['uniacid'], 'rid' => $rid, 'module' => 'ewei_shopv2', 'content' => $arr['keyword'], 'type' => 1, 'displayorder' => 0, 'status' => 1);
					pdo_insert('rule_keyword', $keyword_data);
				}
			}
			else {
				if (!empty($data['keyword'])) {
					$this->delKey($data['keyword']);
				}
			}

			m('common')->updatePluginset(array('mmanage' => $arr));
			plog('mmanage.setting.save', '保存基本设置');
			show_json(1);
		}

		$qrcode = m('qrcode')->createQrcode(mobileUrl('mmanage', array(), true));
		include $this->template();
	}

	protected function delKey($keyword)
	{
		global $_W;

		if (empty($keyword)) {
			return NULL;
		}

		$keyword = pdo_fetch('SELECT * FROM ' . tablename('rule_keyword') . ' WHERE content=:content and module=:module and uniacid=:uniacid limit 1 ', array(':content' => $keyword, ':module' => 'ewei_shopv2', ':uniacid' => $_W['uniacid']));

		if (!empty($keyword)) {
			pdo_delete('rule_keyword', array('id' => $keyword['id']));
			pdo_delete('rule', array('id' => $keyword['rid']));
		}
	}
}

?>
