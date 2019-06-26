<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Batchsend_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$express = trim($_GPC['express']);
			$expresscom = trim($_GPC['expresscom']);
			$rows = m('excel')->import('excelfile');
			$num = count($rows);
			$time = time();
			$i = 0;
			$err_array = array();

			foreach ($rows as $rownum => $col) {
				if ($rownum == 0) {
					continue;
				}

				$ordersn = trim($col[0]);
				$expresssn = trim($col[1]);
				$refund_flag = 0;

				if (empty($ordersn)) {
					continue;
				}

				if (empty($expresssn)) {
					$err_array[] = $ordersn;
					continue;
				}

				$sql = 'select id,status,refundid from ' . tablename('ewei_shop_order') . ' where ordersn=:ordersn and uniacid=:uniacid and isparent=0 and merchid = :merchid';
				$sql .= ' and status in (1,2) and isverify=0 and isvirtual=0 and `virtual`=0 and addressid >0 limit 1';
				$order = pdo_fetch($sql, array(':ordersn' => $ordersn, ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));

				if (!empty($order)) {
					$status = $order['status'];

					if (!empty($order['refundid'])) {
						$refund = pdo_fetch('select id from ' . tablename('ewei_shop_order_refund') . ' where id=:id limit 1', array(':id' => $order['refundid']));

						if (!empty($refund)) {
							$refund_flag = 1;
							pdo_update('ewei_shop_order_refund', array('status' => -1, 'endtime' => $time), array('id' => $order['refundid']));
						}
					}

					$data = array();
					$data['status'] = 2;
					$data['express'] = $express;
					$data['expresscom'] = $expresscom;
					$data['expresssn'] = $expresssn;

					if ($status == 1) {
						$data['sendtime'] = $time;
					}

					if ($refund_flag == 1) {
						$data['refundstate'] = 0;
					}

					pdo_update('ewei_shop_order', $data, array('id' => $order['id']));

					if ($status == 1) {
						m('notice')->sendOrderMessage($order['id']);
						plog('order.op.send', '订单发货 ID: ' . $order['id'] . ' 订单号: ' . $ordersn . ' <br/>快递公司: ' . $expresscom . ' 快递单号: ' . $expresssn);
					}

					++$i;
				}
				else {
					$err_array[] = $ordersn;
				}
			}

			$tip = '';
			$msg = $i . '个订单发货成功！';

			if ($i < $num) {
				$url = '';

				if (!empty($err_array)) {
					$j = 1;
					$tip .= '<br>' . count($err_array) . '个订单发货失败,失败的订单编号: <br>';

					foreach ($err_array as $k => $v) {
						$tip .= $v . ' ';

						if ($j % 2 == 0) {
							$tip .= '<br>';
						}

						++$j;
					}
				}
			}
			else {
				$url = webUrl('order/batchsend');
			}

			$this->message($msg . $tip, $url, '');
		}

		$express_list = m('express')->getExpressList();
		include $this->template();
	}

	public function import()
	{
		$columns = array();
		$columns[] = array('title' => '订单编号', 'field' => '', 'width' => 32);
		$columns[] = array('title' => '快递单号', 'field' => '', 'width' => 32);
		m('excel')->temp('批量发货数据模板', $columns);
	}
}

?>
