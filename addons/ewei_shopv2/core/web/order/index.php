<?php
if (!defined('IN_IA')) {
  exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
  public function main()
  {
    global $_W;
    $set = m('common')->getSysset('template');

    if (!empty($set['style_v3'])) {
      if (cv('order.list.status1')) {
        header('location: ' . webUrl('order.list.status1'));
      }
      else if (cv('order.list.status2')) {
        header('location: ' . webUrl('order.list.status2'));
      }
      else if (cv('order.list.status3')) {
        header('location: ' . webUrl('order.list.status3'));
      }
      else if (cv('order.list.status0')) {
        header('location: ' . webUrl('order.list.status0'));
      }
      else if (cv('order.list.status_1')) {
        header('location: ' . webUrl('order.list.status_1'));
      }
      else if (cv('order.list.status4')) {
        header('location: ' . webUrl('order.list.status4'));
      }
      else if (cv('order.list.status5')) {
        header('location: ' . webUrl('order.list.status5'));
      }
      else if (cv('order.export')) {
        header('location: ' . webUrl('order.export'));
      }
      else if (cv('order.batchsend')) {
        header('location: ' . webUrl('order.batchsend'));
      }
      else {
        header('location: ' . webUrl());
      }
    }
    else {
      include $this->template();
    }
  }
  //订单合并
  public function combine_order()
  {
        global $_W;
        global $_GPC;

        $idstr = rtrim($_GPC['idstr'],',');
        $ids = array_unique(explode(',', $idstr));

        // if(empty($_GPC['start']) ||empty($_GPC['end']))
        // {
        //     if(count($ids)<=1)
        //     {
        //         show_json(0,"至少需要两个订单才能合并");
        //     }
        // }
        
        $date_condition = array(
          ':start'=>strtotime($_GPC['start']),
          ':end'=>strtotime($_GPC['end'])
        );

        $sql = "SELECT id FROM ".tablename('ewei_shop_order')." WHERE status=1 and createtime >= :start and createtime <= :end";

        $time_ids_ = pdo_fetchall($sql,$date_condition);

        foreach ($ids as $key=>$val) 
        {
           if(!$val)unset($ids[$key]);  
        }

        foreach ($time_ids_ as &$val)
        {
           $ids_[] = $val['id'];
        }
        
        if(empty($ids))
        {
           if(empty($ids_))
           {
              show_json(0,'所选时间段内没有可以合并的订单');
           }
        }
      
        $ids = array_merge($ids,$ids_);
         
        $ids_string = implode(',', array_values($ids)); //key值从0开始
       
        $sql = "SELECT id,openid FROM ".tablename('ewei_shop_order')." WHERE id in(".$ids_string.")";   
        $orders = pdo_fetchall($sql);

        $list = $this->groupByopenid($orders);

        foreach ($list as $key => $val) 
        {
            $ret[] = $this->mergeOrder($val);
        }

        if($ret){
           show_json(1,'合并成功');
        }
        
  }
  //按openid分类
  public function groupByopenid($list)
  {
    $arr = array();
    foreach ($list as $key => $val)
    {
       if(isset($list[$key]['openid']))
       {
          $arr[$list[$key]['openid']][] = $val['id'];
       }
    }
    return $arr;
  }

  //合并订单 写入数据库
  public function mergeOrder($ids)
  { 
      if(empty($ids))
      {
         return false;   
      }
      $ids = array_unique($ids); //key从0开始
      //启用事务
      pdo_begin();
      $price = 0;
      $postdata = array();
      //重新计算各个商品数量和商品价格
      foreach ($ids as $key => $val) 
      {
         $sql ="SELECT og.goodsid,og.orderid,og.price,og.total FROM ".tablename('ewei_shop_order')." o 
                 left join".tablename('ewei_shop_order_goods')." og on og.orderid=o.id
                 WHERE o.id=:id order by o.createtime DESC";
                 
         $goods[] = pdo_fetchall($sql,array(':id'=>$val));
         
         foreach ($goods as &$goods) 
         {
            foreach ($goods as $k => $v) 
            {
                //print_r($v);
                if(isset($v['goodsid']))
                {  
                    $postdata[$v['goodsid']]['goodsid'] = $v['goodsid'];
                    $postdata[$v['goodsid']]['price'] += $v['price'];
                    $postdata[$v['goodsid']]['total'] += $v['total'];
                }
            }
         }
         $price +=pdo_get("ewei_shop_order",array('id'=>$val),'price')['price'];
      }

      $order = pdo_fetch("SELECT * FROM ".tablename('ewei_shop_order')." WHERE id=:id and status=1", array(':id' => $ids[0]));

      //生成新订单
      $arr = array('uniacid'=> $order['uniacid'],'openid'=>$order['openid'],'agentid'=>$order['agentid'],'ordersn'=>m("common")->createNO("order", "ordersn", "SH"),'goodsprice'=>$price,'price'=>$price,'grprice'=>$price,'oldprice'=>$price,'paytime'=>$order['paytime'],'addressid'=>$order['addressid'],'remark'=>$order['remark'],'transid'=>$order['transid'],'paytype'=>$order['paytype'],'status'=>$order['status'],'deliveryman_id'=>$order['deliveryman_id'],'address'=>$order['address'],'virtual_str'=>$order['virtual_str'],'virtual_info'=>$order['virtual_info'],'virtual'=>$order['virtual'],'deductenough'=>$order['deductenough'],'deductcredit2'=>$order['deductcredit2'],'deductcredit'=>$order['deductcredit'],'deductprice'=>$order['deductprice'],'verifystoreid'=>$order['verifystoreid'],'verifycode'=>$order['verifycode'],'verifytime'=>$order['verifytime'],'verifyopenid'=>$order['verifyopenid'],'verified'=>$order['verified'],'isverify'=>$order['isverify'],'refundtime'=>$order['refundtime'],'cancelpaytime'=>$order['cancelpaytime'],'canceltime'=>$order['canceltime'],'cash'=>$order['cash'],'fetchtime'=>$order['fetchtime'],'sendtime'=>$order['sendtime'],'express'=>$order['express'],'expresssn'=>$order['expresssn'],'expresscom'=>$order['expresscom'],'finishtime'=>$order['finishtime'],'userdeleted'=>$order['userdeleted'],'deleted'=>$order['deleted'],'creditadd'=>$order['creditadd'],'iscomment'=>$order['iscomment'],'refundid'=>$order['refundid'],'carrier'=>$order['carrier'],'dispatchtype'=>$order['dispatchtype'],'createtime'=>$order['createtime'],'dispatchid'=>$order['dispatchid'],'dispatchprice'=>$order['dispatchprice'],'discountprice'=>$order['discountprice'],'dividend_content'=>$order['dividend_content'],'dividend_status'=>$order['dividend_status'],'dividend_deletetime'=>$order['dividend_deletetime'],'dividend_invalidtime'=>$order['dividend_invalidtime'],'dividend_paytime'=>$order['dividend_paytime'],'dividend_checktime'=>$order['dividend_checktime'],'dividend_applytime'=>$order['dividend_applytime'],'dividend'=>$order['dividend'],'headsid'=>$order['headsid'],'invoice_img'=>$order['invoice_img'],'cycelbuy_periodic'=>$order['cycelbuy_periodic'],'cycelbuy_predict_time'=>$order['cycelbuy_predict_time'],'iscycelbuy'=>$order['iscycelbuy'],'commissionmoney'=>$order['commissionmoney'],'is_cashier'=>$order['is_cashier'],'city_express_state'=>$order['city_express_state'],'print_template'=>$order['print_template'],'random_code'=>$order['random_code'],'cashtime'=>$order['cashtime'],'iswxappcreate'=>$order['iswxappcreate'],'wxapp_prepay_id'=>$order['wxapp_prepay_id'],'officcode'=>$order['officcode'],'isshare'=>$order['isshare'],'betweenprice'=>$order['betweenprice'],'dowpayment'=>$order['dowpayment'],'tradepaytime'=>$order['tradepaytime'],'tradepaytype'=>$order['tradepaytype'],'tradestatus'=>$order['tradestatus'],'ordersn_trade'=>$order['ordersn_trade'],'liveid'=>$order['liveid'],'isnewstore'=>$order['isnewstore'],'istrade'=>$order['istrade'],'quickid'=>$order['quickid'],'dispatchkey'=>$order['dispatchkey'],'isabonus'=>$order['isabonus'],'merchapply'=>$order['merchapply'],'isglobonus'=>$order['isglobonus'],'couponmerchid'=>$order['couponmerchid'],'couponmerchid'=>$order['couponmerchid'],'merchdeductenough'=>$order['merchdeductenough'],'merchshow'=>$order['merchshow'],'isparent'=>$order['isparent'],'isparent'=>$order['isparent'],'parentid'=>$order['parentid'],'ismerch'=>$order['ismerch'],'invoicename'=>$order['invoicename'],'merchid'=>$order['merchid'],'verifycodes'=>$order['verifycodes'],'wxcode'=>$order['wxcode'],'wxcardid'=>$order['wxcardid'],'wxid'=>$order['wxid'],'contype'=>$order['contype'],'lotterydiscountprice'=>$order['lotterydiscountprice'],'sendtype'=>$order['sendtype'],'willcancelmessage'=>$order['willcancelmessage'],'verifyendtime'=>$order['verifyendtime'],'seckilldiscountprice'=>$order['seckilldiscountprice'],'merchisdiscountprice'=>$order['merchisdiscountprice'],'taskdiscountprice'=>$order['taskdiscountprice'],'packageid'=>$order['packageid'],'ispackage'=>$order['ispackage'],'isauthor'=>$order['isauthor'],'authorid'=>$order['authorid'],'buyagainprice'=>$order['buyagainprice'],'coupongoodprice'=>$order['coupongoodprice'],'apppay'=>$order['apppay'],'borrowopenid'=>$order['borrowopenid'],'isborrow'=>$order['isborrow'],'verifytype'=>$order['verifytype'],'verifyinfo'=>$order['verifyinfo'],'virtualsend_info'=>$order['virtualsend_info'],'isvirtualsend'=>$order['isvirtualsend'],'isdiscountprice'=>$order['isdiscountprice'],'ismr'=>$order['ismr'],'remarksend'=>$order['remarksend'],'remarkclose'=>$order['remarkclose'],'refundstate'=>$order['refundstate'],'address_send'=>$order['address_send'],'printstate2'=>$order['printstate2'],'printstate'=>$order['printstate'],'remarksaler'=>$order['remarksaler'],'closereason'=>$order['closereason'],'storeid'=>$order['storeid'],'diyformid'=>$order['diyformid'],'diyformfields'=>$order['diyformfields'],'diyformdata'=>$order['diyformdata'], 'couponprice'=>$order['couponprice'], 'couponid'=>$order['couponid'], 'isvirtual'=>$order['isvirtual'], 'olddispatchprice'=>$order['olddispatchprice'], 'changedispatchprice'=>$order['changedispatchprice'], 'changeprice'=>$order['changeprice'], 'ordersn2'=>$order['ordersn2'],
    );

      pdo_insert("ewei_shop_order", $arr);

      $orderid = pdo_insertid();

      $postdata = array_values($postdata);

      $order_goods_data = pdo_get('ewei_shop_order_goods',array('orderid'=>$ids[0],'goodsid'=>$postdata[0]));

      //如果有相同的商品goodsid需要合并商品数量
      foreach ($postdata as &$val) 
      {
        $goodsname = pdo_get('ewei_shop_goods',array('id'=>$val['goodsid']),array('title'))['title'];
        pdo_insert("ewei_shop_order_goods", array(
            'uniacid'=>$order_goods_data['uniacid'],'openid'=>$order_goods_data['openid'],'orderid'=>$orderid,'goodsid'=>$val['goodsid'],'price'=>$val['price'],'total'=>$val['total'],'optionid'=>$order_goods_data['optionid'],'createtime'=>time(),'realprice'=>$val['price'],'goodssn'=>$order_goods_data['goodssn'],'productsn'=>$order_goods_data['productsn'],'changeprice'=>$order_goods_data['changeprice'],'oldprice'=>$val['price'],'commissions'=>$order_goods_data['commissions'],'diyformdata'=>$order_goods_data['diyformdata'],'diyformfields'=>$order_goods_data['diyformfields'],'diyformdataid'=>$order_goods_data['diyformdataid'],'diyformid'=>$order_goods_data['diyformid'],'title'=>$goodsname
        ));
        $ordergoodsid[] = pdo_insertid();
      }

      //删除所有原订单
      foreach ($ids as $key => $val)
      {
        $del[]=pdo_delete('ewei_shop_order',array('id'=>$val));
      }

      //删除所有原订单下面商品
      foreach ($ids as $key => $val)
      {
         $del_[]=pdo_delete('ewei_shop_order_goods', array('orderid'=>$val));
      }

      if(empty($orderid)||empty($del)||empty($del_)||empty($ordergoodsid))
      {
          pdo_rollback();
          return false;
      }
      else
      {
          pdo_commit();
          return true;
      }

  }

  //订单汇总
  public function summary()
  {
      global $_W;
      global $_GPC;
      //print_r($_GPC);exit;


      if( empty($_GPC['time']['start']) || empty($_GPC['time']['end']) ) 
      {
        $starttime = strtotime("-1 month");
        $endtime = time();  

      }else{

        $starttime = strtotime($_GPC['time']['start']);
        $endtime = strtotime($_GPC['time']['end']);
      
      }

      $pindex = max(1, intval($_GPC["page"]));
      $psize =100;
      $params = array(':starttime'=>$starttime,':endtime'=>$endtime);

      $condition = ' o.status >0 AND o.status<4 AND o.createtime BETWEEN :starttime AND :endtime';

      $sql = "select og.goodsid,o.openid,og.total,g.pcate,g.marketprice,g.discounts,g.title as goods_name,g.unit,s.name as supplier_name,s.id as supplierid from " . tablename("ewei_shop_order") . " o left join " . tablename("ewei_shop_order_goods") . " og on og.orderid =o.id left join" .tablename("ewei_shop_goods") . " g on g.id=og.goodsid left join " . tablename("supplier") . " s on s.id=g.supplier_id where " . $condition;
  
      if( empty($_GPC["export"]) )
      {
        $sql .= " limit " . ($pindex - 1) * $psize . "," . $psize;
      }
      else
      {
        ini_set("memory_limit", "-1");
      }

      $data = pdo_fetchall($sql, $params);
     
      foreach ($data as &$val)
      {
          if(empty($val['unit']))
          {
            $val['goods_name'] =  $val['goods_name'].'/单位';
          }
          else
          {
            $val['goods_name'] =  $val['goods_name'].'/'.$val['unit'];
          }
        
          $val['cname'] = pdo_getcolumn('ewei_shop_category', array('id' => $val['pcate']), 'name',1);
          $val['cname'] = $val['cname']==''?'未分类':$val['cname'];
          $val['_total'] = $val['total'].$val['unit'];
          //折后价格
          //$val['marketprice'] = m('common')->getmarketprice($val['openid'],$val['marketprice'],$val['discounts']);
      }

      $data_ = $this->cal_arr($data,1);

      if($_GPC['export']==1)
      {    
          plog("order.summary", "导出订单汇总数据");
          $list = $this->cal_arr($data,1);
          m("excel")->export($list, array(
            "title" => "订单汇总数据-" . date("Y-m-d-H-i", time()), 
            "columns" => array(
              array( "title" => "商品名称", "field" => "goods_name", "width" => 12 ), 
              array( "title" => "品类", "field" => "cname", "width" => 12 ), 
              array( "title" => "总数量（单位）", "field" => "_total", "width" => 12 ), 
              array( "title" => "分包单位", "field" => "fenbao", "width" => 24 )
            )
          ));
      }
      else if($_GPC['export']==2)
      {
        foreach ($list as &$val) 
         {
            if(!$val['supplierid'])
            {
               echo "<script>alert(\"导出失败,商品".$val['goods_name']."没有关联供货商\");
                     window.location.href='".webUrl('order/summary')."'</script>";
               exit;
            }
         }

         plog("order.summary", "导出分单数据");
         $title = "蔬菜商城-分单数据";
         $list_fendan = $this->cal_arr($data,2);
         $this->fendan_export($list_fendan,$title);
      }
      else if($_GPC['export']==3)
      {
         $list_ = $this->cal_arr($data,3);

         $time = date('Y年m月d日 H:i:s',time());
         $template_id = '7Bn5k6D4QJZa7JrX60tGQsMD_U1cIJNiI4HcPr3Vmio';
       
         foreach ($list_ as &$val) 
         {
              foreach ($val['goods'] as &$v) 
              {
                 $val['fenbao'] .=' '.$v['goods_name'].' '.$v['total'].$v['unit'];
              }

              $supplier = pdo_get('supplier',array('id'=>$val['supplierid']),array('mid'));
              $supplier_openid = pdo_get('ewei_shop_member',array('id'=>$supplier['mid']),'openid')['openid'];
              $postdata = array(
                'first'=>array('value'=>'您好,您有新的配货单。',"color"=>"#173177"),
                'keyword1'=>array('value'=>$val['fenbao'],'color'=>'#173177'),
                'keyword2'=>array('value'=>$time,'color'=>'#173177'),
                "remark"  =>array("value"=>"点击'详情'查看完整配货单信息,有问题请联系客服。","color"=>"#173177")
              );
              
              //写入配货详情数据库
              $result = pdo_insert('supplier_distribution',array(
                'openid'=>$supplier_openid,
                'supplierid'=>$val['supplierid'],
                'content'=>$val['fenbao'],
                'createtime'=>$time
              ));

              if (!empty($result))
              {
                  $sdid = pdo_insertid();
                  $url = $_SERVER['SERVER_NAME'].'/app/index.php?i=1&c=entry&m=ewei_shopv2&do=mobile&r=gonghuo.supplier_dist&id='.$sdid;
                  $ret = m('message')->sendTplNotice($supplier_openid,$template_id,$postdata,$url,null,array());
                   if($ret['errno']==-1)
                  {
                    show_json(0,$ret['message']);
                  }
              }
          }

          show_json(1,"推送成功");
      }

      $sql_ = "SELECT COUNT(*) as total FROM " . tablename("ewei_shop_order") . " o left join " . tablename("ewei_shop_order_goods") . " og on og.orderid =o.id where " . $condition .' group by og.goodsid ';
    
      $total_ = pdo_fetchall($sql_, $params);

      $pager = pagination2(count($total_), $pindex, $psize);

      include($this->template());

    }
    //数组整合
    public function cal_arr($list=array(),$fendan='')
    {
      //print_r($list);exit;
      if(empty($fendan)){
         return false;
      }
      $data = array();
      switch ($fendan) {
        case '1':
            foreach ($list as &$value)
            {
                if(isset($data[$value['goodsid']]))
                {
                  $data[$value['goodsid']]['total'] += $value['total'];
                  $data[$value['goodsid']]['_total'] = $data[$value['goodsid']]['total'].$value['unit'];

                  if(isset($data[$value['goodsid']]['fenbao'][$value['total']]))
                  {
                        $data[$value['goodsid']]['fenbao'][$value['total']] += 1;
                  }
                  else{
                    $data[$value['goodsid']]['fenbao'][$value['total']] = 1;
                  }
              }
              else{
                  $data[$value['goodsid']] = $value;
                  $data[$value['goodsid']]['_total'] = $data[$value['goodsid']]['total'].$value['unit'];
                  $data[$value['goodsid']]['fenbao'] = [$value['total']=>1];
              }
          }
          foreach ($data as &$value)
          {
              if(!empty($value['fenbao']))
              {
                $str = '';
                  foreach ($value['fenbao'] as $shuliang=>$geshu)
                  {
                        $str .= $shuliang.$value['unit'].'('.$geshu.')';
                        $value['fenbao'] = $str;
                  }
              }
          }
          return array_values($data);
          break;
        case '2':
          foreach ($list  as &$item)
          {
              if(isset($data[$item['supplier_name']]))
              {
                  if(isset($data[$item['supplier_name']]['goods'][$item['goodsid']]))
                  {
                      $data[$item['supplier_name']]['goods'][$item['goodsid']]['total'] += $item['total'];
                      $data[$item['supplier_name']]['goods'][$item['goodsid']]['_total'] = $data[$item['supplier_name']]['goods'][$item['goodsid']]['total'].$item['unit'];
                      $data[$item['supplier_name']]['goods'][$item['goodsid']]['total_price'] += round($item['marketprice'] * $item['total'],2);
                      if(isset($data[$item['supplier_name']]['goods'][$item['goodsid']]['fenbao'][$item['total']]))
                      {
                          $data[$item['supplier_name']]['goods'][$item['goodsid']]['fenbao'][$item['total']] += 1;
                      }
                      else 
                      {
                          $data[$item['supplier_name']]['goods'][$item['goodsid']]['fenbao'][$item['total']] = 1;
                      }
                  }
                  else
                  {
                      $data[$item['supplier_name']]['goods'][$item['goodsid']]['goodsid'] = $item['goodsid'];
                      $data[$item['supplier_name']]['goods'][$item['goodsid']]['total'] = $item['total'];
                      $data[$item['supplier_name']]['goods'][$item['goodsid']]['_total'] = $item['_total'];
                      $data[$item['supplier_name']]['goods'][$item['goodsid']]['goods_name'] = $item['goods_name'];
                      $data[$item['supplier_name']]['goods'][$item['goodsid']]['cname'] = $item['cname'];
                      $data[$item['supplier_name']]['goods'][$item['goodsid']]['unit'] = $item['unit'];
                      $data[$item['supplier_name']]['goods'][$item['goodsid']]['marketprice'] = $item['marketprice'];
                      $data[$item['supplier_name']]['goods'][$item['goodsid']]['total_price'] = round($item['marketprice'] * $item['total'],2);
                      $data[$item['supplier_name']]['goods'][$item['goodsid']]['fenbao'] = [$item['total']=>1];
                  }
              }
              else
              {
                  $data[$item['supplier_name']]['supplier_name'] = $item['supplier_name'];
                  $data[$item['supplier_name']]['supplierid'] = $item['supplierid'];

                  $data[$item['supplier_name']]['goods'][$item['goodsid']]['goodsid'] = $item['goodsid'];
                  $data[$item['supplier_name']]['goods'][$item['goodsid']]['total'] = $item['total'];
                  $data[$item['supplier_name']]['goods'][$item['goodsid']]['_total'] = $item['_total'];
                  $data[$item['supplier_name']]['goods'][$item['goodsid']]['goods_name'] = $item['goods_name'];
                  $data[$item['supplier_name']]['goods'][$item['goodsid']]['cname'] = $item['cname'];
                  $data[$item['supplier_name']]['goods'][$item['goodsid']]['unit'] = $item['unit'];
                  $data[$item['supplier_name']]['goods'][$item['goodsid']]['marketprice'] = $item['marketprice'];
                  $data[$item['supplier_name']]['goods'][$item['goodsid']]['total_price'] = round($item['marketprice'] * $item['total'],2);
                  $data[$item['supplier_name']]['goods'][$item['goodsid']]['fenbao'] = [$item['total']=>1];
              }
          }
          foreach ($data as &$value)
          {
              if(!empty($value['goods'])){
                  foreach ($value['goods'] as &$v)
                  {
                      if(!empty($v['fenbao']))
                      {
                          $str = '';
                          foreach ($v['fenbao'] as $shuliang=>$geshu)
                          {
                              $str .= $shuliang.$v['unit'].'('.$geshu.')';
                          }
                          $v['fenbao'] = $str;
                      }
                  }
              }
          }
          array_walk($data,function(&$value, $key)
          {
              $value['goods'] = array_values($value['goods']);
          });
          return $data;
          break;
        case '3':
            foreach ($list  as &$item)
            {
                if(isset($data[$item['supplierid']]))
                {
                    if(isset($data[$item['supplierid']]['goods'][$item['goodsid']]))
                    {
                        $data[$item['supplierid']]['goods'][$item['goodsid']]['total'] += $item['total'];
                        $data[$item['supplierid']]['goods'][$item['goodsid']]['_total'] = $data[$item['supplierid']]['goods'][$item['goodsid']]['total'].$item['unit'];
                        $data[$item['supplierid']]['goods'][$item['goodsid']]['total_price'] += round($item['marketprice'] * $item['total'],2);
                        if(isset($data[$item['supplierid']]['goods'][$item['goodsid']]['fenbao'][$item['total']]))
                        {
                            $data[$item['supplierid']]['goods'][$item['goodsid']]['fenbao'][$item['total']] += 1;
                        }
                        else 
                        {
                            $data[$item['supplierid']]['goods'][$item['goodsid']]['fenbao'][$item['total']] = 1;
                        }
                    }
                    else
                    {
                        $data[$item['supplierid']]['goods'][$item['goodsid']]['goodsid'] = $item['goodsid'];
                        $data[$item['supplierid']]['goods'][$item['goodsid']]['total'] = $item['total'];
                        $data[$item['supplierid']]['goods'][$item['goodsid']]['_total'] = $item['_total'];
                        $data[$item['supplierid']]['goods'][$item['goodsid']]['goods_name'] = $item['goods_name'];
                        $data[$item['supplierid']]['goods'][$item['goodsid']]['cname'] = $item['cname'];
                        $data[$item['supplierid']]['goods'][$item['goodsid']]['unit'] = $item['unit'];
                        $data[$item['supplierid']]['goods'][$item['goodsid']]['marketprice'] = $item['marketprice'];
                        $data[$item['supplierid']]['goods'][$item['goodsid']]['total_price'] = round($item['marketprice'] * $item['total'],2);
                        $data[$item['supplierid']]['goods'][$item['goodsid']]['fenbao'] = [$item['total']=>1];
                    }
                }
                else
                {
                    $data[$item['supplierid']]['supplierid'] = $item['supplierid'];
                    $data[$item['supplierid']]['goods'][$item['goodsid']]['goodsid'] = $item['goodsid'];
                    $data[$item['supplierid']]['goods'][$item['goodsid']]['total'] = $item['total'];
                    $data[$item['supplierid']]['goods'][$item['goodsid']]['_total'] = $item['_total'];
                    $data[$item['supplierid']]['goods'][$item['goodsid']]['goods_name'] = $item['goods_name'];
                    $data[$item['supplierid']]['goods'][$item['goodsid']]['cname'] = $item['cname'];
                    $data[$item['supplierid']]['goods'][$item['goodsid']]['unit'] = $item['unit'];
                    $data[$item['supplierid']]['goods'][$item['goodsid']]['marketprice'] = $item['marketprice'];
                    $data[$item['supplierid']]['goods'][$item['goodsid']]['total_price'] = round($item['marketprice'] * $item['total'],2);
                    $data[$item['supplierid']]['goods'][$item['goodsid']]['fenbao'] = [$item['total']=>1];
                }
            }
            foreach ($data as &$value)
            {
                if(!empty($value['goods'])){
                    foreach ($value['goods'] as &$v)
                    {
                        if(!empty($v['fenbao']))
                        {
                            $str = '';
                            foreach ($v['fenbao'] as $shuliang=>$geshu)
                            {
                                $str .= $shuliang.$v['unit'].'('.$geshu.')';
                            }
                            $v['fenbao'] = $str;
                        }
                    }
                }
            }
            array_walk($data,function(&$value, $key)
            {
                $value['goods'] = array_values($value['goods']);
            });
          return $data;
          break;
        default:
          # code...
          break;
      }
    }
    //导出分单excel
    public function fendan_export($list=array(),$title="")
    {

      //print_r($list);exit;
      if (PHP_SAPI == 'cli')
      {
        exit('This example should only be run from a Web Browser');
      }
    
      require_once IA_ROOT . '/framework/library/phpexcel/PHPExcel.php';

      $excel = new PHPExcel();

      if(empty($title)){
         $title = "蔬菜商城-分单数据"; 
      }
      
        $excel->getActiveSheet(0)->setTitle($title);
        //横向单元格标识
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

        $_row = 1;

        if($list)
        {
          //$excel->getActiveSheet(0)->mergeCells('A'.$_row.':'.$cellName[$_cnt-1].$_row);
          $excel->setActiveSheetIndex(0)->setCellValue('A'.$_row, date('Y-m-d H:i:s'));  
          $excel->setActiveSheetIndex(0)->setCellValue('B'.$_row, '品类');
          $excel->setActiveSheetIndex(0)->setCellValue('C'.$_row, '总数量(单位)');
          $excel->setActiveSheetIndex(0)->setCellValue('D'.$_row, '分包单位');
          $excel->setActiveSheetIndex(0)->setCellValue('E'.$_row, '单价');
          $excel->setActiveSheetIndex(0)->setCellValue('F'.$_row, '总价');
          $excel->setActiveSheetIndex(0)->setCellValue('G'.$_row, '送货单位');
          $excel->setActiveSheetIndex(0)->setCellValue('H'.$_row, '收货单位');

          // $styleThinBlackBorderOutline = array(
          //   'borders' => array(
          //       'allborders' => array(
          //           'style' => PHPExcel_Style_Border::BORDER_THIN
          //       ),
          //   ),
          // );

          //填写数据  
          $i = 0;

          foreach($list as $key=>$_v)
          {
               
              $excel->createSheet();
              $col = count($_v)+5;
              $excel->setactivesheetindex($i)->getStyle('A1:H'.$col);
              //->applyFromArray($styleThinBlackBorderOutline);
              $excel->getActiveSheet()->getColumnDimension()->setAutoSize(true);
              $excel->getActiveSheet($i)->setTitle($key); 
              $excel->setActiveSheetIndex($i)->setCellValue('A'.$_row, date('Y-m-d H:i:s'));
              $excel->setActiveSheetIndex($i)->setCellValue('B'.$_row, '品类');
              $excel->setActiveSheetIndex($i)->setCellValue('C'.$_row, '总数量(单位)');
              $excel->setActiveSheetIndex($i)->setCellValue('D'.$_row, '分包单位');
              $excel->setActiveSheetIndex($i)->setCellValue('E'.$_row, '单价');
              $excel->setActiveSheetIndex($i)->setCellValue('F'.$_row, '总价');
              $excel->setActiveSheetIndex($i)->setCellValue('G'.$_row, '送货单位');
              $excel->setActiveSheetIndex($i)->setCellValue('H'.$_row, '收货单位');

              $j = 0;
              foreach($_v['goods'] as $_k => $_cell){
                
                $excel->getActiveSheet($i)->setCellValue('A'.($_k+$_row+1), $_cell['goods_name']);
                $excel->getActiveSheet($i)->setCellValue('B'.($_k+$_row+1), $_cell['cname']);
                $excel->getActiveSheet($i)->setCellValue('C'.($_k+$_row+1), $_cell['_total']);
                $excel->getActiveSheet($i)->setCellValue('D'.($_k+$_row+1), $_cell['fenbao']);
                $excel->getActiveSheet($i)->setCellValue('E'.($_k+$_row+1), $_cell['marketprice']);
                $excel->getActiveSheet($i)->setCellValue('F'.($_k+$_row+1), $_cell['total_price']);
                $excel->getActiveSheet($i)->setCellValue('G'.($_k+$_row+1), $_cell['songhuo']);
                $excel->getActiveSheet($i)->setCellValue('H'.($_k+$_row+1), $_cell['shouhuo']);

                  $j++;
              }

              $i++;
          }

      }

      $excel->setactivesheetindex(0);
      $filename = $title . '-' . date('Y年m月d日His', time());
      $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
      header('pragma:public');
      ob_end_clean();
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
      header('Cache-Control: max-age=0');
      
      m('excel')->SaveViaTempFile($writer);
      exit();
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

    if (!empty($is_avg)) {
      $time = 'paytime';
      $where = ' and (status >0 and (paytime between :createtime1 and :createtime2))';
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

    if (!empty($is_avg)) {
      $member_num = count(array_unique($member));
      $avg = empty($member_num) ? 0 : round($price / $member_num, 2);
    }

    $result = array('price' => $price, 'count' => count($pdo_res), 'avg' => $avg, 'fetchall' => $pdo_res);
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
  protected function selectTransaction(array $pdo_fetchall, $days = 7, $is_all = false)
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

  public function ajaxorder()
  {
    global $_GPC;
    $day = (int) $_GPC['day'];
    $order = $this->selectOrderPrice($day);
    unset($order['fetchall']);
    $allorder = $this->selectOrderPrice($day, true);
    unset($allorder['fetchall']);
    $avg = $this->selectOrderPrice($day, true, true);
    unset($allorder['fetchall']);
    $orders = array('order_count' => $order['count'], 'order_price' => number_format($order['price'], 2), 'allorder_count' => $allorder['count'], 'allorder_price' => number_format($allorder['price'], 2), 'avg' => number_format($avg['avg'], 2));
    show_json(1, array('order' => $orders));
  }

  /**
     * ajax return 七日交易记录.近7日交易时间,交易金额,交易数量
     */
  public function ajaxtransaction()
  {
    $orderPrice = $this->selectOrderPrice(7);
    $transaction = $this->selectTransaction($orderPrice['fetchall'], 7);

    if (empty($transaction)) {
      $i = 7;

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

    $allorderPrice = $this->selectOrderPrice(7, true);
    $alltransaction = $this->selectTransaction($allorderPrice['fetchall'], 7, true);

    if (empty($alltransaction)) {
      $i = 7;

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

    echo json_encode(array('price_key' => array_keys($transaction['price']), 'price_value' => array_values($transaction['price']), 'count_value' => array_values($transaction['count']), 'allprice_value' => array_values($alltransaction['price']), 'allcount_value' => array_values($alltransaction['count'])));
  }
}

?>
