<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
load()->model('wxapp');

$dos = array('home', 'version_display');
$do = in_array($do, $dos) ? $do : 'home';

if ($do == 'home') {
	$last_uniacid = uni_account_last_switch();
	$url = url('account/display', array('type' => WXAPP_TYPE_SIGN));
	if (empty($last_uniacid)) {
		itoast('', $url, 'info');
	}
	if (!empty($last_uniacid) && $last_uniacid != $_W['uniacid']) {
		uni_account_switch($last_uniacid, '', WXAPP_TYPE_SIGN);
	}
	$permission = permission_account_user_role($_W['uid'], $last_uniacid);
	if (empty($permission)) {
		itoast('', $url, 'info');
	}
	$last_version = wxapp_fetch($last_uniacid);
	if (!empty($last_version)) {
		$url = url('wxapp/version/home', array('version_id' => $last_version['version']['id']));
	}
	itoast('', $url, 'info');
}

if ($do == 'version_display') {
	$wxapp_version_list = wxapp_version_all($_W['uniacid']);
	template('wxapp/version-display');
}
