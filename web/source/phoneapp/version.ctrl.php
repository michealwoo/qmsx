<?php
defined('IN_IA') or exit('Access Denied');

load()->model('phoneapp');
load()->model('welcome');

$do = safe_gpc_belong($do, array('home'), 'home');

$_W['page']['title'] = 'APP - 管理';

$version_id = intval($_GPC['version_id']);
$phoneapp_info = phoneapp_fetch($_W['uniacid']);

if (!empty($version_id)) {
	$version_info = phoneapp_version($version_id);
}

if ($do == 'home') {
	$role = permission_account_user_role($_W['uid'], $wxapp_info['uniacid']);
	$notices = welcome_notices_get();
	template('phoneapp/version-home');
}