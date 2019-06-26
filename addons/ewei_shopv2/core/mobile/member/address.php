<?php  if( !defined("IN_IA") ) 
{
	exit( "Access Denied" );
}
class Address_EweiShopV2Page extends MobileLoginPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		global $_S;
		$area_set = m("util")->get_area_config_set();
		$new_area = intval($area_set["new_area"]);
		$address_street = intval($area_set["address_street"]);
		$pindex = intval($_GPC["page"]);
		$psize = 20;
		$condition = " and openid=:openid and deleted=0 and  `uniacid` = :uniacid  ";
		$params = array( ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"] );
		$sql = "SELECT COUNT(*) FROM " . tablename("ewei_shop_member_address") . " where 1 " . $condition;
		$total = pdo_fetchcolumn($sql, $params);
		$sql = "SELECT * FROM " . tablename("ewei_shop_member_address") . " where 1 " . $condition . " ORDER BY `id` DESC";
		if( $pindex != 0 ) 
		{
			$sql .= "LIMIT " . ($pindex - 1) * $psize . "," . $psize;
		}
		$list = pdo_fetchall($sql, $params);
		include($this->template());
	}
	public function post() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC["id"]);
		$area_set = m("util")->get_area_config_set();
		$new_area = intval($area_set["new_area"]);
		$address_street = intval($area_set["address_street"]);
		if( !empty($id) ) 
		{
			$address = pdo_fetch("select * from " . tablename("ewei_shop_member_address") . " where id=:id and openid=:openid and uniacid=:uniacid limit 1 ", array( ":id" => $id, ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"] ));
			if( empty($address["datavalue"]) ) 
			{
				$provinceName = $address["province"];
				$citysName = $address["city"];
				$countyName = $address["area"];
				$province_code = 0;
				$citys_code = 0;
				$county_code = 0;
				$path = EWEI_SHOPV2_PATH . "static/js/dist/area/AreaNew.xml";
				$xml = file_get_contents($path);
				$array = xml2array($xml);
				$newArr = array( );
				if( is_array($array["province"]) ) 
				{
					foreach( $array["province"] as $i => $v ) 
					{
						if( 0 < $i && $v["@attributes"]["name"] == $provinceName && !is_null($provinceName) && $provinceName != "" ) 
						{
							$province_code = $v["@attributes"]["code"];
							if( is_array($v["city"]) ) 
							{
								if( !isset($v["city"][0]) ) 
								{
									$v["city"] = array( $v["city"] );
								}
								foreach( $v["city"] as $ii => $vv ) 
								{
									if( $vv["@attributes"]["name"] == $citysName && !is_null($citysName) && $citysName != "" ) 
									{
										$citys_code = $vv["@attributes"]["code"];
										if( is_array($vv["county"]) ) 
										{
											if( !isset($vv["county"][0]) ) 
											{
												$vv["county"] = array( $vv["county"] );
											}
											foreach( $vv["county"] as $iii => $vvv ) 
											{
												if( $vvv["@attributes"]["name"] == $countyName && !is_null($countyName) && $countyName != "" ) 
												{
													$county_code = $vvv["@attributes"]["code"];
												}
											}
										}
									}
								}
							}
						}
					}
				}
				if( $province_code != 0 && $citys_code != 0 && $county_code != 0 ) 
				{
					$address["datavalue"] = $province_code . " " . $citys_code . " " . $county_code;
					pdo_update("ewei_shop_member_address", $address, array( "id" => $id, "uniacid" => $_W["uniacid"], "openid" => $_W["openid"] ));
				}
			}
			$show_data = 1;
			if( !empty($new_area) && empty($address["datavalue"]) || empty($new_area) && !empty($address["datavalue"]) ) 
			{
				$show_data = 0;
			}
		}
		include($this->template());
	}
	public function setdefault() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC["id"]);
		$data = pdo_fetch("select id from " . tablename("ewei_shop_member_address") . " where id=:id and deleted=0 and uniacid=:uniacid limit 1", array( ":uniacid" => $_W["uniacid"], ":id" => $id ));
		if( empty($data) ) 
		{
			show_json(0, "地址未找到");
		}
		pdo_update("ewei_shop_member_address", array( "isdefault" => 0 ), array( "uniacid" => $_W["uniacid"], "openid" => $_W["openid"] ));
		pdo_update("ewei_shop_member_address", array( "isdefault" => 1 ), array( "id" => $id, "uniacid" => $_W["uniacid"], "openid" => $_W["openid"] ));
		show_json(1);
	}
	private function extractNumber($string) 
	{
		$string = preg_replace("# #", "", $string);
		preg_match("/\\d{11}/", $string, $result);
		return (string) $result[0];
	}
	public function submit() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC["id"]);
		$data = $_GPC["addressdata"];
		$data["mobile"] = $this->extractNumber($data["mobile"]);
		$areas = explode(" ", $data["areas"]);
		list($data["province"], $data["city"], $data["area"]) = $areas;
		$data["street"] = trim($data["street"]);
		$data["datavalue"] = trim($data["datavalue"]);
		$data["streetdatavalue"] = trim($data["streetdatavalue"]);
		$isdefault = intval($data["isdefault"]);
		unset($data["isdefault"]);
		unset($data["areas"]);
		$data["openid"] = $_W["openid"];
		$data["uniacid"] = $_W["uniacid"];
		if( empty($id) ) 
		{
			$addresscount = pdo_fetchcolumn("SELECT count(*) FROM " . tablename("ewei_shop_member_address") . " where openid=:openid and deleted=0 and `uniacid` = :uniacid ", array( ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"] ));
			if( $addresscount <= 0 ) 
			{
				$data["isdefault"] = 1;
			}
			pdo_insert("ewei_shop_member_address", $data);
			$id = pdo_insertid();
		}
		else 
		{
			$data["lng"] = "";
			$data["lat"] = "";
			pdo_update("ewei_shop_member_address", $data, array( "id" => $id, "uniacid" => $_W["uniacid"], "openid" => $_W["openid"] ));
		}
		if( !empty($isdefault) ) 
		{
			pdo_update("ewei_shop_member_address", array( "isdefault" => 0 ), array( "uniacid" => $_W["uniacid"], "openid" => $_W["openid"] ));
			pdo_update("ewei_shop_member_address", array( "isdefault" => 1 ), array( "id" => $id, "uniacid" => $_W["uniacid"], "openid" => $_W["openid"] ));
		}
		show_json(1, array( "addressid" => $id ));
	}
	public function delete() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC["id"]);
		$data = pdo_fetch("select id,isdefault from " . tablename("ewei_shop_member_address") . " where  id=:id and openid=:openid and deleted=0 and uniacid=:uniacid  limit 1", array( ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"], ":id" => $id ));
		if( empty($data) ) 
		{
			show_json(0, "地址未找到");
		}
		pdo_update("ewei_shop_member_address", array( "deleted" => 1 ), array( "id" => $id ));
		if( $data["isdefault"] == 1 ) 
		{
			pdo_update("ewei_shop_member_address", array( "isdefault" => 0 ), array( "uniacid" => $_W["uniacid"], "openid" => $_W["openid"], "id" => $id ));
			$data2 = pdo_fetch("select id from " . tablename("ewei_shop_member_address") . " where openid=:openid and deleted=0 and uniacid=:uniacid order by id desc limit 1", array( ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"] ));
			if( !empty($data2) ) 
			{
				pdo_update("ewei_shop_member_address", array( "isdefault" => 1 ), array( "uniacid" => $_W["uniacid"], "openid" => $_W["openid"], "id" => $data2["id"] ));
				show_json(1, array( "defaultid" => $data2["id"] ));
			}
		}
		show_json(1);
	}
	public function selector() 
	{
		global $_W;
		global $_GPC;
		$area_set = m("util")->get_area_config_set();
		$new_area = intval($area_set["new_area"]);
		$address_street = intval($area_set["address_street"]);
		$condition = " and openid=:openid and deleted=0 and  `uniacid` = :uniacid  ";
		$params = array( ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"] );
		$sql = "SELECT * FROM " . tablename("ewei_shop_member_address") . " where 1 " . $condition . " ORDER BY isdefault desc, id DESC ";
		$list = pdo_fetchall($sql, $params);
		include($this->template());
		exit();
	}
	public function getselector() 
	{
		global $_W;
		global $_GPC;
		$condition = " and openid=:openid and deleted=0 and  `uniacid` = :uniacid  ";
		$params = array( ":uniacid" => $_W["uniacid"], ":openid" => $_W["openid"] );
		$keywords = $_GPC["keywords"];
		if( !empty($keywords) ) 
		{
			$condition .= " AND (`realname` LIKE :keywords OR `mobile` LIKE :keywords OR `province` LIKE :keywords OR `city` LIKE :keywords OR `area` LIKE :keywords OR `address` LIKE :keywords OR `street` LIKE :keywords)";
			$params[":keywords"] = "%" . trim($keywords) . "%";
		}
		$sql = "SELECT *  FROM " . tablename("ewei_shop_member_address") . " where 1 " . $condition . " ORDER BY isdefault desc, id DESC ";
		$list = pdo_fetchall($sql, $params);
		foreach( $list as &$item ) 
		{
			$item["editurl"] = mobileUrl("member/address/post", array( "id" => $item["id"] ));
		}
		unset($item);
		if( 0 < count($list) ) 
		{
			show_json(1, array( "list" => $list ));
		}
		else 
		{
			show_json(0);
		}
	}
}
?>