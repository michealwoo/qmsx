<?php  if( !defined("IN_IA") ) 
{
	exit( "Access Denied" );
}
class Newrelease_EweiShopV2Page extends PluginWebPage 
{
	private $key = "asdf734JH3464tr56GJ";
	public function main() 
	{
		global $_W;
		$error = NULL;
		$auth = $this->model->getAuth();
		if( is_error($auth) ) 
		{
			$error = $auth["message"];
		}
		else 
		{
			$is_auth = (is_array($auth) ? $auth["is_auth"] : false);
			$authUrl = EWEI_SHOPV2_AUTH_WXAPP . "auth/auth?id=" . $auth["id"];
			if( $is_auth ) 
			{
				$release = $this->model->getRelease($auth["id"]);
			}
			$list = $this->model->getReleaseList();
			if( is_error($list) ) 
			{
				$error = $list["message"];
			}
			else 
			{
				if( empty($list) ) 
				{
					$error = "未查询到授权小程序";
				}
			}
			$log = pdo_fetchall("select * from " . tablename("ewei_shop_upwxapp_log") . " where uniacid=:uniacid and type=1 order by id desc", array( ":uniacid" => $_W["uniacid"] ));
			$lasttime = $log[0]["version_time"] + 1490;
			if( !empty($log[0]["version_time"]) && $lasttime < time() ) 
			{
				$is_expire = 1;
			}
			$wxcode = IA_ROOT . "/addons/ewei_shopv2/plugin/app/static/images/wxcode_" . $_W["uniacid"] . ".jpg";
			if( !filemtime($wxcode) || filemtime($wxcode) + 7200 < time() ) 
			{
				$accessToken = $this->model->getAccessToken();
				if( is_error($accessToken) ) 
				{
					$error = $accessToken["message"];
				}
				else 
				{
					load()->func("communication");
					$result = ihttp_post("https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . $accessToken, json_encode(array( "scene" => "index", "path" => "pages/index/index" )));
					file_put_contents($wxcode, $result["content"]);
				}
			}
		}
		include($this->template());
	}
	public function upload() 
	{
		global $_W;
		global $_GPC;
		$sets = m("common")->getSysset(array( "app" ));
		$appid = $sets["app"]["appid"];
		if( empty($appid) ) 
		{
			header("location: " . webUrl("app/setting"));
		}
		$last_log = pdo_fetch("select * from " . tablename("ewei_shop_upwxapp_log") . " where uniacid=:uniacid and type=1 order by id desc limit 1", array( ":uniacid" => $_W["uniacid"] ));
		@session_start();
		$ticket = $_SESSION["wxapp_new_ticket"];
		if( empty($ticket) ) 
		{
			$need_scan = 1;
			load()->func("communication");
			$res = ihttp_get(EWEI_SHOPV2_AUTH_WXAPP . "generate/getqrcode");
			$content = json_decode($res["content"], true);
			if( !empty($content) ) 
			{
				$uuid = $content["uuid"];
				$qrcode = $content["qrcode"];
			}
		}
		else 
		{
			$need_scan = 0;
		}
		include($this->template());
	}
	public function getstatus() 
	{
		global $_W;
		global $_GPC;
		load()->func("communication");
		$uuid = $_GPC["uuid"];
		if( empty($uuid) ) 
		{
			show_json(0);
		}
		$res = ihttp_get(EWEI_SHOPV2_AUTH_WXAPP . "generate/getstatus?uuid=" . $uuid);
		$content = json_decode($res["content"], true);
		if( empty($content["status"]) ) 
		{
			show_json(0);
		}
		show_json(1, array( "wx_errcode" => $content["wx_errcode"], "wx_code" => $content["wx_code"] ));
	}
	public function getticket() 
	{
		global $_W;
		global $_GPC;
		load()->func("communication");
		$code = $_GPC["code"];
		if( empty($code) ) 
		{
			show_json(0);
		}
		$res = ihttp_get(EWEI_SHOPV2_AUTH_WXAPP . "generate/getticket?code=" . $code);
		$content = json_decode($res["content"], true);
		if( !empty($content["status"]) && !empty($content["new_ticket"]) ) 
		{
			@session_start();
			$_SESSION["wxapp_new_ticket"] = $content["new_ticket"];
		}
		else 
		{
			show_json(0, "ticket获取失败");
		}
		show_json(1, array( "new_ticket" => $content["new_ticket"] ));
	}
	public function submit() 
	{
		global $_W;
		global $_GPC;
		$version = $_GPC["version"];
		if( empty($version) ) 
		{
			show_json(0, "版本号不能为空！");
		}
		$describe = $_GPC["describe"];
		if( empty($describe) ) 
		{
			show_json(0, "版本描述不能为空！");
		}
		@session_start();
		$ticket = $_SESSION["wxapp_new_ticket"];
		if( empty($ticket) ) 
		{
			show_json(0, "ticket为空，请刷新后重试！");
		}
		$auth = $this->model->getAuth();
		if( is_error($auth) ) 
		{
			show_json(0, "未查询到授权信息！");
		}
		$tabBar = "";
		$app_set = m("common")->getSysset("app");
		if( !empty($app_set) && !empty($app_set["tabbar"]) ) 
		{
			$app_set["tabbar"] = iunserializer($app_set["tabbar"]);
			if( !empty($app_set["tabbar"]) ) 
			{
				$tabBar = $app_set["tabbar"];
			}
		}
		if( is_array($tabBar) ) 
		{
			if( is_array($tabBar["list"]) ) 
			{
				foreach( $tabBar["list"] as $index => &$item ) 
				{
					$item["pagePath"] = ltrim($item["pagePath"], "/");
				}
				unset($index);
				unset($item);
			}
			$tabBar = json_encode($tabBar);
		}
		$request = ihttp_post(EWEI_SHOPV2_AUTH_WXAPP . "generate/upload?id=" . $auth["id"], array( "version" => $version, "describe" => $describe, "tabBar" => $tabBar, "ticket" => $ticket ));
		if( $request["code"] != 200 ) 
		{
			show_json(0, "信息查询失败！稍后重试(" . $request["code"] . ")");
		}
		if( empty($request["content"]) ) 
		{
			show_json(0, "信息查询失败！稍后重试(nodata)");
		}
		$content = json_decode($request["content"], true);
		if( !is_array($content) ) 
		{
			show_json(0, "信息查询失败！稍后重试(dataerror)");
		}
		if( $content["status"] == 402 || $content["status"] == 403 ) 
		{
			@session_start();
			$_SESSION["wxapp_new_ticket"] = NULL;
		}
		if( $content["status"] != 1 ) 
		{
			show_json(0, $content["errmsg"]);
		}
		else 
		{
			$data["uniacid"] = $_W["uniacid"];
			$data["type"] = 1;
			$data["version"] = $version;
			$data["describe"] = $describe;
			$data["version_time"] = time();
			pdo_insert("ewei_shop_upwxapp_log", $data);
			$wxcode = IA_ROOT . "/addons/ewei_shopv2/plugin/app/static/images/test_code_" . $_W["uniacid"] . ".jpg";
			file_put_contents($wxcode, base64_decode($content["testcode"]));
			show_json(1);
		}
	}
	public function deletes() 
	{
		global $_W;
		global $_GPC;
		@session_start();
		$_SESSION["wxapp_new_ticket"] = NULL;
	}
	public function wechatset() 
	{
		include($this->template());
	}
}
?>