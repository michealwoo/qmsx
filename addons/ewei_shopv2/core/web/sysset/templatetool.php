<?php 
if( !defined("IN_IA") ) 
{
	exit( "Access Denied" );
}
class Templatetool_EweiShopV2Page extends WebPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		include($this->template());
	}
	public function gettypecodes() 
	{
		$items = pdo_fetchall("select typecode from " . tablename("ewei_shop_member_message_template_type") . " where templatecode is not null");
		$typecode = array( );
		foreach( $items as $item ) 
		{
			$typecode[] = $item["typecode"];
		}
		$typecode = json_encode($typecode);
		$this->setoldtemplateid();
		show_json(1, array( "length" => count($items), "typecodes" => $typecode ));
	}
	public function setoldtemplateid() 
	{
		load()->func("communication");
		$account = m("common")->getAccount();
		$token = $account->fetch_token();
		$url = "https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=" . $token;
		$c = ihttp_request($url);
		$result = json_decode($c["content"], true);
		if( !is_array($result) ) 
		{
			show_json(1, array( "status" => 0, "messages" => "微信接口错误.", "tag" => $tag ));
		}
		if( !empty($result["errcode"]) ) 
		{
			show_json(1, array( "status" => 0, "messages" => $result["errmsg"], "tag" => $tag ));
		}
		$content = "{{first.DATA}}业务类型：{{keyword1.DATA}}业务状态：{{keyword2.DATA}}业务内容：{{keyword3.DATA}}{{remark.DATA}}";
		$content = str_replace(array( "\r\n", "\r", "\n", " " ), "", $content);
		$content = str_replace(array( "：" ), ":", $content);
		$templatenum = count($result["template_list"]);
		$issnoet = true;
		$template_id = "";
		foreach( $result["template_list"] as $key => $value ) 
		{
			$valuecontent = str_replace(array( "\r\n", "\r", "\n", " " ), "", $value["content"]);
			$valuecontent = str_replace(array( "：" ), ":", $valuecontent);
			if( $valuecontent == $content ) 
			{
				$issnoet = false;
				$template_id = $value["template_id"];
			}
		}
		if( $issnoet ) 
		{
			if( 25 <= $templatenum ) 
			{
				return false;
			}
			$bb = "{\"template_id_short\":\"OPENTM207574677\"}";
			$account = m("common")->getAccount();
			$token = $account->fetch_token();
			$url = "https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=" . $token;
			$ch1 = curl_init();
			curl_setopt($ch1, CURLOPT_URL, $url);
			curl_setopt($ch1, CURLOPT_POST, 1);
			curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch1, CURLOPT_POSTFIELDS, $bb);
			$c = curl_exec($ch1);
			$result = @json_decode($c, true);
			if( !is_array($result) ) 
			{
				return false;
			}
			if( !empty($result["errcode"]) ) 
			{
				if( strstr($result["errmsg"], "template conflict with industry hint") ) 
				{
					return false;
				}
				if( strstr($result["errmsg"], "system error hint") ) 
				{
					return false;
				}
				if( strstr($result["errmsg"], "invalid industry id hint") ) 
				{
					return false;
				}
				if( strstr($result["errmsg"], "access_token is invalid or not latest hint") ) 
				{
					return false;
				}
				return false;
			}
			$template_id = $result["template_id"];
		}
		if( p("commission") ) 
		{
			$data1 = m("common")->getPluginset("commission", false);
			$data1 = $data1["tm"];
			if( !empty($data1["templateid"]) ) 
			{
				$data1["templateid"] = $template_id;
				m("common")->updatePluginset(array( "commission" => array( "tm" => $data1 ) ));
			}
		}
		if( p("globonus") ) 
		{
			$data2 = m("common")->getPluginset("globonus");
			$data2 = $data2["tm"];
			if( !empty($data2["templateid"]) ) 
			{
				$data2["templateid"] = $template_id;
				m("common")->updatePluginset(array( "globonus" => array( "tm" => $data2 ) ));
			}
		}
		if( p("abonus") ) 
		{
			$data3 = m("common")->getPluginset("abonus");
			$data3 = $data3["tm"];
			if( !empty($data3["templateid"]) ) 
			{
				$data3["templateid"] = $template_id;
				m("common")->updatePluginset(array( "abonus" => array( "tm" => $data3 ) ));
			}
		}
		if( p("merch") ) 
		{
			$data4 = m("common")->getPluginset("merch");
			$data4 = $data4["tm"];
			if( !empty($data4["templateid"]) ) 
			{
				$data4["templateid"] = $template_id;
				m("common")->updatePluginset(array( "merch" => array( "tm" => $data4 ) ));
			}
		}
		$data5 = m("common")->getPluginset("coupon");
		if( !empty($data5["sendtemplateid"]) ) 
		{
			$data5["sendtemplateid"] = $template_id;
		}
		if( !empty($data5["templateid"]) ) 
		{
			$data5["templateid"] = $template_id;
		}
		m("common")->updatePluginset(array( "coupon" => $data5 ));
	}
	public function settemplateid() 
	{
		global $_W;
		global $_GPC;
		$tag = $_GPC["tag"];
		load()->func("communication");
		$account = m("common")->getAccount();
		$token = $account->fetch_token();
		$url = "https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=" . $token;
		$c = ihttp_request($url);
		$result = json_decode($c["content"], true);
		if( !is_array($result) ) 
		{
			show_json(1, array( "status" => 0, "messages" => "微信接口错误.", "tag" => $tag ));
		}
		if( !empty($result["errcode"]) ) 
		{
			show_json(1, array( "status" => 0, "messages" => $result["errmsg"], "tag" => $tag ));
		}
		$error_message = "";
		$templatenum = count($result["template_list"]);
		$templatetype = pdo_fetch("select `name`,templatecode,content  from " . tablename("ewei_shop_member_message_template_type") . " where typecode=:typecode  limit 1", array( ":typecode" => $tag ));
		if( empty($templatetype) ) 
		{
			show_json(1, array( "status" => 0, "messages" => "默认模板信息错误", "tag" => $tag ));
		}
		$content = str_replace(array( "\r\n", "\r", "\n", " " ), "", $templatetype["content"]);
		$content = str_replace(array( "：" ), ":", $content);
		$issnoet = true;
		foreach( $result["template_list"] as $key => $value ) 
		{
			$valuecontent = str_replace(array( "\r\n", "\r", "\n", " " ), "", $value["content"]);
			$valuecontent = str_replace(array( "：" ), ":", $valuecontent);
			if( $valuecontent == $content ) 
			{
				$issnoet = false;
				$defaulttemp = pdo_fetch("select 1  from " . tablename("ewei_shop_member_message_template_default") . " where typecode=:typecode and uniacid=:uniacid  limit 1", array( ":typecode" => $tag, ":uniacid" => $_W["uniacid"] ));
				if( empty($defaulttemp) ) 
				{
					pdo_insert("ewei_shop_member_message_template_default", array( "typecode" => $tag, "uniacid" => $_W["uniacid"], "templateid" => $value["template_id"] ));
				}
				else 
				{
					pdo_update("ewei_shop_member_message_template_default", array( "templateid" => $value["template_id"] ), array( "typecode" => $tag, "uniacid" => $_W["uniacid"] ));
				}
				show_json(1, array( "status" => 1, "tag" => $tag ));
			}
		}
		if( $issnoet ) 
		{
			if( 25 <= $templatenum ) 
			{
				show_json(1, array( "status" => 0, "messages" => "开启" . $templatetype["name"] . "失败！！您的可用微信模板消息数量达到上限，请删除部分后重试！！", "tag" => $tag ));
			}
			$bb = "{\"template_id_short\":\"" . $templatetype["templatecode"] . "\"}";
			$account = m("common")->getAccount();
			$token = $account->fetch_token();
			$url = "https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=" . $token;
			$ch1 = curl_init();
			curl_setopt($ch1, CURLOPT_URL, $url);
			curl_setopt($ch1, CURLOPT_POST, 1);
			curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch1, CURLOPT_POSTFIELDS, $bb);
			$c = curl_exec($ch1);
			$result = @json_decode($c, true);
			if( !is_array($result) ) 
			{
				show_json(1, array( "status" => 0, "messages" => "微信接口错误.", "tag" => $tag ));
			}
			if( !empty($result["errcode"]) ) 
			{
				if( strstr($result["errmsg"], "template conflict with industry hint") ) 
				{
					show_json(1, array( "status" => 0, "messages" => "默认模板与公众号所属行业冲突,请将公众平台模板消息所在行业选择为： IT科技/互联网|电子商务， 其他/其他", "tag" => $tag ));
				}
				else 
				{
					if( strstr($result["errmsg"], "system error hint") ) 
					{
						show_json(1, array( "status" => 0, "messages" => "微信接口系统繁忙,请稍后再试!", "tag" => $tag ));
					}
					else 
					{
						if( strstr($result["errmsg"], "invalid industry id hint") ) 
						{
							show_json(1, array( "status" => 0, "messages" => "微信接口系统繁忙,请稍后再试!", "tag" => $tag ));
						}
						else 
						{
							if( strstr($result["errmsg"], "access_token is invalid or not latest hint") ) 
							{
								show_json(1, array( "status" => 0, "messages" => "微信证书无效，请检查平台access_token设置", "tag" => $tag ));
							}
							else 
							{
								show_json(1, array( "status" => 0, "messages" => $result["errmsg"], "tag" => $tag ));
							}
						}
					}
				}
			}
			else 
			{
				$defaulttemp = pdo_fetch("select 1  from " . tablename("ewei_shop_member_message_template_default") . " where typecode=:typecode and uniacid=:uniacid  limit 1", array( ":typecode" => $tag, ":uniacid" => $_W["uniacid"] ));
				if( empty($defaulttemp) ) 
				{
					pdo_insert("ewei_shop_member_message_template_default", array( "typecode" => $tag, "uniacid" => $_W["uniacid"], "templateid" => $result["template_id"] ));
				}
				else 
				{
					pdo_update("ewei_shop_member_message_template_default", array( "templateid" => $result["template_id"] ), array( "typecode" => $tag, "uniacid" => $_W["uniacid"] ));
				}
			}
		}
		show_json(1, array( "status" => 1, "tag" => $tag ));
	}
}
?>