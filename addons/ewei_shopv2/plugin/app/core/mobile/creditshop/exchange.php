<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Exchange_EweiShopV2Page extends AppMobilePage
{
	public function check()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$log = pdo_fetch('select id,status from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $id, ':uniacid' => $uniacid, ':openid' => $openid));
		if (!empty($log) && $log['status'] == 3) {
			app_json();
		}

		app_error(AppError::$logNotFound, '未找到记录');
	}

	public function qrcode()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$log = pdo_fetch('select id,eno from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $id, ':uniacid' => $uniacid, ':openid' => $openid));

		if (empty($log)) {
			app_error(AppError::$logNotFound, '未找到记录');
		}

		$qrcode = p('creditshop')->createQrcode($id);
		app_json(array('qrcode' => $qrcode, 'eno' => $log['eno']));
	}

	public function exchange()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$saler = pdo_fetch('select * from ' . tablename('ewei_shop_saler') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));

		if (empty($saler)) {
			app_error(AppError::$NoExchangeAuthority, '您无兑换权限！');
		}

		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $uniacid));

		if (empty($log)) {
			app_error(AppError::$ExchangeRecordNotFound, '未找到兑换记录！');
		}

		if (empty($log['status'])) {
			app_error(AppError::$UselessExchangeRecord, '无效兑换记录！');
		}

		if (3 <= $log['status']) {
			app_error(AppError::$RecordUsed, '此记录已兑换过了!');
		}

		$member = m('member')->getMember($log['openid']);
		$goods = $this->model->getGoods($log['goodsid'], $member);
		if ($goods['isendtime'] == 1 && $goods['endtime'] < time()) {
			app_error(AppError::$BeyondUsefulLife, '超出使用有效期，无法进行兑换!');
		}

		if (empty($goods['id'])) {
			app_error(AppError::$ExchangeRecordNotFound, '商品记录不存在!');
		}

		if (empty($goods['isverify'])) {
			app_error(AppError::$NonsupportOfflineConversion, '此商品不支持线下兑换！');
		}

		if (!empty($goods['type'])) {
			if ($log['status'] <= 1) {
				app_error(AppError::$Losing_Lottery, '未中奖，不能兑换！');
			}
		}

		if (0 < $goods['money'] && empty($log['paystatus'])) {
			app_error(AppError::$NonPayment, '未支付，无法进行兑换！');
		}

		if (0 < $goods['dispatch'] && empty($log['dispatchstatus'])) {
			app_error(AppError::$NonPaymentFreight, '未支付运费，无法进行兑换！');
		}

		if ($goods['isendtime'] == 1 && $goods['endtime'] < $goods['currenttime']) {
			app_error(AppError::$Expire, '超出使用有效期，无法进行兑换！');
		}

		$stores = explode(',', $goods['storeids']);

		if (!empty($storeids)) {
			if (!empty($saler['storeid'])) {
				if (!in_array($saler['storeid'], $storeids)) {
					app_error(AppError::$NoExchangeAuthority, '您无此门店的兑换权限！');
				}
			}
		}

		$time = time();
		pdo_update('ewei_shop_creditshop_log', array('status' => 3, 'usetime' => $time, 'verifyopenid' => $openid), array('id' => $log['id']));
		$this->model->sendMessage($id);
		app_json('【' . $goods['title'] . '】兑换成功!');
	}
}

?>
