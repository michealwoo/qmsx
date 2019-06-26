<?php
if (!(defined('IN_IA'))) 
{
	exit('Access Denied');
}
class GrantModel extends PluginModel 
{
	public function checkplugin($identity) 
	{
		global $_W;
		$uniacid = $_W['uniacid'];
		$setting = pdo_fetch('select * from ' . tablename('ewei_shop_system_plugingrant_setting') . ' where 1 = 1 limit 1 ');
		if (!(strstr($setting['plugin'], $identity)) && !(strstr($setting['com'], $identity))) 
		{
			$plugin = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_system_plugingrant_log') . ' WHERE uniacid = ' . $uniacid . ' and `identity` = \'' . $identity . '\'order by permendtime desc ');
			if (($plugin['month'] == 0) && ($plugin['isperm'] == 1)) 
			{
				return true;
			}
			if ((0 < $plugin['month']) && ($plugin['isperm'] == 1)) 
			{
				if ($plugin['permendtime'] < time()) 
				{
					return false;
				}
			}
			else 
			{
				return false;
			}
		}
		return true;
	}
	public function pluginGrant($id) 
	{
		$item = pdo_fetch('SELECT uniacid,pluginid,`month` FROM ' . tablename('ewei_shop_system_plugingrant_log') . ' WHERE id = ' . $id . ' and isperm = 0  ');
		if (empty($item)) 
		{
			message('抱歉，该记录不存在！', '', 'error');
		}
		$data = array('isperm' => 1);
		$lastitem = pdo_fetch('SELECT MAX(permendtime) as permendtime,permlasttime FROM ' . tablename('ewei_shop_system_plugingrant_log') . ' ' . "\r\n" . '                            WHERE uniacid = ' . $item['uniacid'] . ' and pluginid = ' . $item['pluginid'] . ' and isperm = 1 limit 1');
		if (!(empty($lastitem)) && (0 < $lastitem['permendtime'])) 
		{
			$data['permendtime'] = strtotime('+' . $item['month'] . ' month', $lastitem['permendtime']);
			$data['permlasttime'] = $lastitem['permendtime'];
		}
		else 
		{
			$data['permendtime'] = strtotime('+' . $item['month'] . ' month');
		}
		pdo_update('ewei_shop_system_plugingrant_log', $data, array('id' => $id));
	}
	public function wechat_native_build($params, $wechat, $type = 0) 
	{
		global $_W;
		$package = array();
		$package['appid'] = $wechat['appid'];
		$package['mch_id'] = $wechat['mchid'];
		$package['nonce_str'] = random(32);
		$package['body'] = $params['title'];
		$package['device_info'] = ((isset($params['device_info']) ? 'ewei_shopv2:' . $params['device_info'] : 'ewei_shopv2'));
		$package['attach'] = ((isset($params['uniacid']) ? $params['uniacid'] : $_W['uniacid'])) . ':' . $type;
		$package['out_trade_no'] = $params['tid'];
		$package['total_fee'] = $params['fee'] * 100;
		$package['spbill_create_ip'] = CLIENT_IP;
		$package['product_id'] = $params['tid'];
		if (!(empty($params['goods_tag']))) 
		{
			$package['goods_tag'] = $params['goods_tag'];
		}
		$package['time_start'] = date('YmdHis', TIMESTAMP);
		$package['time_expire'] = date('YmdHis', TIMESTAMP + 3600);
		$package['notify_url'] = ((empty($params['notify_url']) ? $_W['siteroot'] . 'addons/ewei_shopv2/payment/wechat/notify.php' : $params['notify_url']));
		$package['trade_type'] = 'NATIVE';
		ksort($package, SORT_STRING);
		$string1 = '';
		foreach ($package as $key => $v ) 
		{
			if (empty($v)) 
			{
				continue;
			}
			$string1 .= $key . '=' . $v . '&';
		}
		$string1 .= 'key=' . $wechat['apikey'];
		$package['sign'] = strtoupper(md5($string1));
		$dat = array2xml($package);
		load()->func('communication');
		$response = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);
		if (is_error($response)) 
		{
			return $response;
		}
		libxml_disable_entity_loader(true);
		$xml = simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
		if (strval($xml->return_code) == 'FAIL') 
		{
			return error(-1, strval($xml->return_msg));
		}
		if (strval($xml->result_code) == 'FAIL') 
		{
			return error(-1, strval($xml->err_code) . ': ' . strval($xml->err_code_des));
		}
		$result = json_decode(json_encode($xml), true);
		return $result;
	}
	public function aliconfig() 
	{
		global $_W;
		$setting = pdo_fetch('select * from ' . tablename('ewei_shop_system_plugingrant_setting') . ' where 1 = 1 limit 1 ');
		$alipay_gateway_new = 'https://mapi.alipay.com/gateway.do?';
		$https_verify_url = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';
		$http_verify_url = 'http://notify.alipay.com/trade/notify_query.do?';
		$config = array('partner' => $setting['partner'], 'seller_id' => $setting['partner'], 'key' => $setting['secret'], 'notify_url' => $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/pluginverify.php', 'return_url' => webUrl('plugingrant/success', array(), true), 'sign_type' => 'MD5', 'input_charset' => 'UTF-8', 'transport' => 'https', 'payment_type' => '1', 'service' => 'create_direct_pay_by_user', 'anti_phishing_key' => '', 'exter_invoke_ip' => '');
		return array('alipay_gateway_new' => $alipay_gateway_new, 'https_verify_url' => $https_verify_url, 'http_verify_url' => $http_verify_url, 'config' => $config);
	}
	public function build(array $params) 
	{
		$aliconfig = $this->aliconfig();
		$config = $aliconfig['config'];
		$parameter = array('service' => $config['service'], 'partner' => $config['partner'], 'seller_id' => $config['seller_id'], 'payment_type' => $config['payment_type'], 'notify_url' => $config['notify_url'], 'return_url' => $config['return_url'], 'anti_phishing_key' => $config['anti_phishing_key'], 'exter_invoke_ip' => $config['exter_invoke_ip'], 'out_trade_no' => $params['tid'], 'subject' => $params['title'], 'total_fee' => $params['price'], 'body' => $params['body'], 'it_b_pay' => '30m', '_input_charset' => $config['input_charset']);
		unset($params['tid'], $params['title'], $params['price'], $params['body']);
		$parameter = array_merge($parameter, $params);
		$prepares = array();
		foreach ($parameter as $key => $value ) 
		{
			if (($key == 'sign') || ($key == 'sign_type') || ($value == '')) 
			{
				continue;
			}
			$prepares[$key] = $parameter[$key];
		}
		$prepares = $this->argSort($prepares);
		$prestr = $this->createLinkstring($prepares);
		$my_sign = $this->md5Sign($prestr, $config['key']);
		$prepares['sign'] = $my_sign;
		$prepares['sign_type'] = strtoupper(trim($config['sign_type']));
		return $aliconfig['alipay_gateway_new'] . http_build_query($prepares, '', '&');
	}
	public function createLinkstring($para) 
	{
		$arg = '';
		while (list($key, $val) = each($para)) 
		{
			$arg .= $key . '=' . $val . '&';
		}
		$arg = substr($arg, 0, count($arg) - 2);
		if (get_magic_quotes_gpc()) 
		{
			$arg = stripslashes($arg);
		}
		return $arg;
	}
	public function md5Sign($prestr, $key) 
	{
		$prestr = $prestr . $key;
		return md5($prestr);
	}
	public function argSort($para) 
	{
		ksort($para);
		reset($para);
		return $para;
	}
	public function verifyNotify($post) 
	{
		if (empty($post)) 
		{
			return false;
		}
		$isSign = $this->getSignVeryfy($post, $post['sign']);
		$responseTxt = 'false';
		if (!(empty($post['notify_id']))) 
		{
			$responseTxt = $this->getResponse($post['notify_id']);
		}
		if (preg_match('/true$/i', $responseTxt) && $isSign) 
		{
			return true;
		}
		return false;
	}
	public function getSignVeryfy($para_temp, $sign) 
	{
		$aliconfig = $this->aliconfig();
		$config = $aliconfig['config'];
		$para_filter = array();
		foreach ($para_temp as $key => $value ) 
		{
			if (($key == 'sign') || ($key == 'sign_type') || ($value == '')) 
			{
				continue;
			}
			$para_filter[$key] = $para_temp[$key];
		}
		$para_sort = $this->argSort($para_filter);
		$prestr = $this->createLinkstring($para_sort);
		$isSgin = false;
		$isSgin = $this->md5Verify($prestr, $sign, $config['key']);
		return $isSgin;
	}
	public function md5Verify($prestr, $sign, $key) 
	{
		$prestr = $prestr . $key;
		$mysgin = md5($prestr);
		if ($mysgin == $sign) 
		{
			return true;
		}
		return false;
	}
	public function getResponse($notify_id) 
	{
		$aliconfig = $this->aliconfig();
		$config = $aliconfig['config'];
		$transport = strtolower(trim($config['transport']));
		$partner = trim($config['partner']);
		$veryfy_url = '';
		if ($transport == 'https') 
		{
			$veryfy_url = $aliconfig['https_verify_url'];
		}
		else 
		{
			$veryfy_url = $aliconfig['https_verify_url'];
		}
		$veryfy_url = $veryfy_url . 'partner=' . $partner . '&notify_id=' . $notify_id;
		$responseTxt = $this->getHttpResponseGET($veryfy_url, $config['cacert']);
		return $responseTxt;
	}
	public function getHttpResponseGET($url, $cacert_url) 
	{
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		$responseText = curl_exec($curl);
		curl_close($curl);
		return $responseText;
	}
	public function verifyReturn($get) 
	{
		if (empty($get)) 
		{
			return false;
		}
		$isSign = $this->getSignVeryfy($get, $get['sign']);
		$responseTxt = 'false';
		if (!(empty($get['notify_id']))) 
		{
			$responseTxt = $this->getResponse($get['notify_id']);
		}
		if (preg_match('/true$/i', $responseTxt) && $isSign) 
		{
			return true;
		}
		return false;
	}
}
?>