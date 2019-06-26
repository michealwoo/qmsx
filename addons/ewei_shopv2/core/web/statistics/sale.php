<?php
if (!defined('IN_IA')) {

	exit('Access Denied');

}
class Sale_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

        if( empty($_GPC['time']['start']) || empty($_GPC['time']['end']) ) 
		{
			$starttime = strtotime("-1 month");
			$endtime = time();	
		    //相差天数
			$days = round(($endtime-$starttime)/3600/24);
		}else{
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
		    //相差天数
			$days = round(($endtime-$starttime)/3600/24)+1;
		}

     
        $data = $this->ajaxdata($days);

        $info['ajaxdata'] = json_encode($data,JSON_UNESCAPED_UNICODE);

        if ($_GPC['export'] == 1) 
        {

			m('excel')->export($data, array(

				'title'   => '销售统计报告-' . date('Y-m-d-H-i', time()),

				'columns' => array(

					array('title' => '日期', 'field' => 'price_key', 'width' => 24),

					array('title' => '交易额', 'field' => 'price_value', 'width' => 12),

					)

				));

			plog('statistics.sale.export', '导出销售统计');

		}

        $allcount_value = $data['allcount_value'];     //所有交易量 
        $totalcount = array_sum($data['count_value']); //销售量
        $maxcount = max($data['count_value']);         //最大销售量

		include $this->template('statistics/sale');

	}
   /**
    * ajax return 七日交易记录.近7日交易时间,交易数量
    */
	public function ajaxdata($days='')
	{
        global $_W;
		global $_GPC;
         
        if(empty($days)) $days=1;

        $orderPrice = $this->selectOrderPrice($days);
		$transaction = $this->selectTransaction($orderPrice['fetchall'], $days);

		if (empty($transaction)) {
			$i = $days;

			while (1 <= $i) {
				$transaction['price'][date('Y-m-d', time() - $i * 3600 * 24)] = 0;
				$transaction['count'][date('Y-m-d', time() - $i * 3600 * 24)] = 0;
				--$i;
			}
		}
		else {
			foreach ($transaction['price'] as &$item) {
				$item = round($item, 2);
			}

			unset($item);
		}

		$allorderPrice = $this->selectOrderPrice($days, true);
		$alltransaction = $this->selectTransaction($allorderPrice['fetchall'], $days, true);

		if (empty($alltransaction)) {
			$i = $days;

			while (1 <= $i) {
				$alltransaction['price'][date('Y-m-d', time() - $i * 3600 * 24)] = 0;
				$alltransaction['count'][date('Y-m-d', time() - $i * 3600 * 24)] = 0;
				--$i;
			}
		}
		else {
			foreach ($alltransaction['price'] as &$item) {
				$item = round($item, 2);
			}

			unset($item);
		}

        return array(
        	'price_key' => array_keys($transaction['price']), 
        	'price_value' => array_values($transaction['price']), 
        	'count_value' => array_values($transaction['count']), 
        	'allprice_value' => array_values($alltransaction['price']), 
        	'allcount_value' => array_values($alltransaction['count'])
        );

	}
	/**
     * 查询订单金额
     * @param int $day 查询天数
     * @param bool $is_all 是否是全部订单
     * @param bool $is_avg 是否是查询付款平均数
     * @return bool
     */
	protected function selectOrderPrice($day = 0, $is_all = false, $is_avg = false)
	{
		global $_W;
		$day = (int) $day;

		if ($day != 0) {
			if ($day == 30) {
				$yest = date('Y-m-d');
				$createtime1 = strtotime(date('Y-m-d', strtotime('-30 day')));
				$createtime2 = strtotime($yest . ' 23:59:59');
			}
			else if ($day == 7) {
				$yest = date('Y-m-d');
				$createtime1 = strtotime(date('Y-m-d', strtotime('-7 day')));
				$createtime2 = strtotime($yest . ' 23:59:59');
			}
			else {
				$yesterday = strtotime('-1 day');
				$yy = date('Y', $yesterday);
				$ym = date('m', $yesterday);
				$yd = date('d', $yesterday);
				$createtime1 = strtotime($yy . '-' . $ym . '-' . $yd . ' 00:00:00');
				$createtime2 = strtotime($yy . '-' . $ym . '-' . $yd . ' 23:59:59');
			}
		}
		else {
			$createtime1 = strtotime(date('Y-m-d', time()));
			$createtime2 = strtotime(date('Y-m-d', time())) + 3600 * 24 - 1;
		}

		$time = 'paytime';
		$where = ' and (( status > 0 and (paytime between :createtime1 and :createtime2)) or ((createtime between :createtime1 and :createtime2 ) and status>=0 and paytype=3))';

		if (!empty($is_all)) {
			$time = 'createtime';
			$where = ' and createtime between :createtime1 and :createtime2';
		}

		$sql = 'select id,price,openid,' . $time . ' from ' . tablename('ewei_shop_order') . ' where uniacid = :uniacid and ismr = 0 and isparent = 0 and deleted=0 ' . $where;
		$param = array(':uniacid' => $_W['uniacid'], ':createtime1' => $createtime1, ':createtime2' => $createtime2);
		$pdo_res = pdo_fetchall($sql, $param);
		$price = 0;
		$avg = 0;
		$member = array();

		foreach ($pdo_res as $arr) {
			$price += $arr['price'];
			$member[] = $arr['openid'];
		}

		$result = array(
			'price' => $price, 
			'count' => count($pdo_res), 
			//'avg' => $avg, 
			'fetchall' => $pdo_res
			);

		return $result;
	}
	/**
     * 查询近七天交易记录
     * @param array $pdo_fetchall 查询订单的记录
     * @param int $days 查询天数默认7
     * @param int $is_all 是否是全部订单
     * @return $transaction["price"] 七日 每日交易金额
     * @return $transaction["count"] 七日 每日交易订单数
     */
	protected function selectTransaction(array $pdo_fetchall, $days = 30, $is_all = false)
	{
		$transaction = array();
		$days = (int) $days;

		if (!empty($pdo_fetchall)) {
			$i = $days;

			while (1 <= $i) {
				$transaction['price'][date('Y-m-d', time() - $i * 3600 * 24)] = 0;
				$transaction['count'][date('Y-m-d', time() - $i * 3600 * 24)] = 0;
				--$i;
			}

			if (empty($is_all)) {
				foreach ($pdo_fetchall as $key => $value) {
					if (array_key_exists(date('Y-m-d', $value['paytime']), $transaction['price'])) {
						$transaction['price'][date('Y-m-d', $value['paytime'])] += $value['price'];
						$transaction['count'][date('Y-m-d', $value['paytime'])] += 1;
					}
				}
			}
			else {
				foreach ($pdo_fetchall as $key => $value) {
					if (array_key_exists(date('Y-m-d', $value['createtime']), $transaction['price'])) {
						$transaction['price'][date('Y-m-d', $value['createtime'])] += $value['price'];
						$transaction['count'][date('Y-m-d', $value['createtime'])] += 1;
					}
				}
			}

			return $transaction;
		}

		return array();
	}

}



?>

