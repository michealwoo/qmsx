<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type='text/css'>    
.ordertable { width:100%;position: relative;margin-bottom:10px}    
.ordertable tr td:first-child { text-align: right }   
 .ordertable tr td {padding:10px 5px 0;vertical-align: top}    
 .ordertable1 tr td { text-align: right; }    
 .ops .btn { padding:5px 10px;}    
 .order-container{       
  display: -webkit-box;        
  display: -webkit-flex;       
  display: -ms-flexbox;        
  display: flex;    }    
 .order-container-left{        
   -webkit-box-flex: 1;        
   -webkit-flex: 1;        
   -ms-flex: 1;        
   flex: 1;    
   }    
   .order-container-static{        
      -webkit-box-flex: 1;        
      -webkit-flex: 1;        
      -ms-flex: 1;        
      flex: 1;        
      padding: 30px 50px 20px;    
      }    
   .font18{        
      font-size:20px;        
      font-weight:bold;;    
   }    
   .trbagpack span{        
      margin: 0 10px;        
      display: inline-block;        
      vertical-align: middle;    
   }    
   .trbagpack span.address{        
      width:150px;        
      overflow: hidden;        
      text-overflow:ellipsis;        
      white-space: nowrap;    
   }    
   tfoot .price{        
      float: right;    
   }    
   tfoot .price-inner{        
      display: inline-block;        
      vertical-align: middle;        
      width:100px;        
      text-align: right;    
   }    
   .packbag-group{        
      border:1px solid #efefef;    
   }    
   .packbag{        
      padding: 0 30px;    
   }    
   .packbag-title{    
      line-height: 33px;    
   }    
   .packbag-group .packbag-list{        
      padding: 20px 33px;        
      border-bottom: 1px solid #efefef;        
      display: flex;       
      align-items: center;    
   }    
   .packbag-list .packbag-media{        
      width:100px;    
   }    
   .packbag-list .packbag-inner{        
      border-left:1px solid #efefef;        
      -webkit-box-flex: 1;        
      -webkit-flex: 1;        
      -ms-flex: 1;        
      flex: 1;    
   }    
   .packbag-goods-list{        
      display: flex;        
      flex-wrap: wrap;        
      width:100%;    
   }    
   .packbag-goods{        
      width:25%;        
      display: flex;        
      display: -webkit-flex;        
      margin: 10px 0 5px;    
   }    
   .packbag-goods-media{        
      width:52px;        
      height: 52px;       
      margin-right: 10px;    
   }  
   .packbag-goods-media img{       
      width:52px;       
      height: 52px;       
      border: 1px solid #efefef;    
   }    
  .packbag-goods-inner{        
      flex:1;        
      -webkit-box-flex: 1;        
      -webkit-flex: 1;        
      -ms-flex: 1;        
      flex: 1;        
      overflow: hidden;    
   }    
   .packbag-goods-inner p{    
      color: #999;    
   }   
  .packbag-goods-inner .title{        
      width:100%;        
      overflow: hidden;        
      text-overflow: ellipsis;       
      white-space: nowrap;    
   }    
   .table .trorder td{
      border-right:1px solid #efefef;    
   }
   .table .trorder td:nth-of-type(1){
      border:none;    
   }
   </style>
   <div class="page-header">当前位置：<span class="text-primary">订单详情</span></div>
   <div class="page-content">    
   <?php  if($item['status']!=-1) { ?>    
      <div class="step-region" >        
            <ul class="ui-step ui-step-4" >            
               <li <?php  if(0<=$item['status']) { ?>class="ui-step-done"<?php  } ?>>            
                  <div class="ui-step-number" >1</div>            
                  <div class="ui-step-title" >买家下单</div>            
                  <div class="ui-step-meta" ><?php  if(0<=$item['status']) { ?><?php  echo date('Y-m-d',$item['createtime'])?><br/>
                  <?php  echo date('H:i:s',$item['createtime'])?><?php  } ?></div>            
               </li>            
               <li <?php  if(!empty($item['paytime']) || $item['paytype']==3) { ?>class="ui-step-done"<?php  } ?>>            
                  <div class="ui-step-number">2</div>            
                  <div class="ui-step-title"><?php  if($item['paytype']==3) { ?>货到付款<?php  } else { ?>买家付款<?php  } ?></div>            
                  <div class="ui-step-meta"><?php  if($item['paytype']==3) { ?><?php  $item['paytime'] = $item['cashtime']?><?php  } ?><?php  if(1<=$item['status'] || $item['paytype']==3) { ?><?php  echo date('Y-m-d',$item['paytime'])?><br/><?php  echo date('H:i:s',$item['paytime'])?><?php  } ?>
                  </div>            
               </li>            
               <li <?php  if(2<=$item['status'] || ($item['status']==1 && $item['sendtype'] > 0)) { ?>class="ui-step-done"<?php  } ?>>            
                  <div class="ui-step-number" >3</div>            
                  <div class="ui-step-title">                
                     <?php  if($isonlyverifygoods) { ?>                
                     <!--核销时间-->订单完成                
                     <?php  } else if($item['isverify'] == 1) { ?>确认使用<?php  } else if(!empty($item['addressid'])) { ?>商家发货
                     <?php  } else if(!empty($item['isvirtualsend']) || !empty($item['virtual'])) { ?>
                     自动发货<?php  } else { ?>确认取货<?php  } ?>
                  </div>            
                  <div class="ui-step-meta" >                
                     <?php  if($isonlyverifygoods) { ?>                    
                     <?php  if(3<=$item['status']) { ?><?php  echo date('Y-m-d',$item['finishtime'])?><br/><?php  echo date('H:i:s',$item['finishtime'])?><?php  } ?>                
                     <?php  } else { ?>                    
                     <?php  if(2<=$item['status'] || ($item['status']==1 && $item['sendtype'] > 0)) { ?><?php  echo date('Y-m-d',$item['sendtime'])?><br/><?php  echo date('H:i:s',$item['sendtime'])?><?php  } ?>                <?php  } ?>            
                  </div>            
               </li>            
               <?php  if(empty($isonlyverifygoods)) { ?>                
                  <li <?php  if(3<=$item['status']) { ?>class="ui-step-done"<?php  } ?>>                
                     <div class="ui-step-number" >4</div>                
                     <div class="ui-step-title">订单完成</div>                
                     <div class="ui-step-meta"><?php  if(3<=$item['status']) { ?><?php  echo date('Y-m-d',$item['finishtime'])?><br/>
                     <?php  echo date('H:i:s',$item['finishtime'])?><?php  } ?></div>                
                  </li>
               <?php  } ?>
            </ul>    
      </div>    
   <?php  } ?>    
   <form class="form-horizontal form" action="" method="post">        
   <input type="hidden" name="id" value="<?php  echo $item['id'];?>" />        
   <input type="hidden" name="dispatchid" value="<?php  echo $dispatch['id'];?>" />        
   <!--<h3 class="order-title">订单信息</h3>-->        
   <div class="row order-container">            
   <div class="order-container-left" style="border-right: 1px solid #efefef">                
   <div class="row">                    
   <div class="col-md-12">                        
   <ul class="">                            
   <li class="text">
      <span class="col-sm">订单编号：</span>
      <span class="text-default"><?php  echo $item['ordersn'];?></span>
   </li>                            
   <?php  if(!empty($item['transid'])) { ?>                            
   <li class="text">
      <span class="col-sm">平台单号：</span>
      <span class="text-default"><?php  echo $item['transid'];?></span>
   </li>                            
   <?php  } ?>                            
   <?php  if(!empty($coupon)) { ?>                            
   <li class="text">                                
   <span class="col-sm">优惠券：</span>                                
   <span class="text-default"><?php  if($coupon['merchid'] == 0) { ?><a href="<?php  echo webUrl('sale/coupon/edit',array('id'=>$coupon['id']))?>" target='_blank'><?php  echo $coupon['couponname'];?></a><?php  } else { ?><?php  echo $coupon['couponname'];?><?php  } ?> &nbsp;&nbsp;<a data-toggle='popover' data-html='true' data-placement='right' data-content="<table style='width:100%;'>                    
   <tr><td style='border:none;text-align:right;'>优惠方式：</td>                        
   <td style='border:none;text-align:right;'>                        
   <?php  if($coupon['backtype']==0) { ?>立减 <?php  echo $coupon['deduct'];?> 元
   <?php  } else if($coupon['backtype']==1) { ?>                            
   打 <?php  echo $coupon['discount'];?> 折
   <?php  } else if($coupon['backtype']==2) { ?>                            
   <?php  if($coupon['backmoney']>0) { ?>返 <?php  echo $coupon['backmoney'];?> 余额<?php  } ?>                            
   <?php  if($coupon['backcredit']>0) { ?>返 <?php  echo $coupon['backcredit'];?> 积分<?php  } ?>                            
   <?php  if($coupon['backredpack']>0) { ?>返 <?php  echo $coupon['backredpack'];?> 红包<?php  } ?>                        
   <?php  } ?>                        
   </td>                    
   </tr>                    
   <?php  if($coupon['backtype']==2) { ?>                        
   <tr>                            
   <td style='border:none;text-align:right;'>返利方式：</td>                            
   <td style='border:none;text-align:right;'>                            
   <?php  if($item['backwhen']==0) { ?>
   交易完成后(过退款期限)                            
   <?php  } else if($item['backwhen']==1) { ?>                                
   订单完成后(收货后)                            
   <?php  } else { ?>                                
   订单付款后                            
   <?php  } ?>                            
   </td>                        
   </tr>                        
   <tr>                            
   <td style='border:none;text-align:right;'>返利情况：</td>                            
   <td style='border:none;text-align:right;'>                            
   <?php  if(empty($coupon['back'])) { ?>                                
   未返利                            
   <?php  } else { ?>                                
   已返利                            
   <?php  } ?>                            
   </td>                        
   </tr>                        
   <?php  if(!empty($coupon['back'])) { ?>                        
   <tr>                            
   <td style='border:none;text-align:right;'>返利时间：</td>                            
   <td style='border:none;text-align:right;'><?php  echo date('Y-m-d H:i',$coupon['backtime'])?></td>                       
   </tr>                        
   <?php  } ?>                    
   <?php  } ?>                
   </table>    
   "><i class='fa fa-question-circle'></i></a>
   </span></li>                            
   <?php  } ?>                            
   <li class="text">                                
   <span class="col-sm">付款方式：</span>                                
   <span class="text-default">
      <?php  if($item['paytype'] == 0) { ?>未支付<?php  } ?>
      <?php  if($item['paytype'] == 1) { ?>余额支付<?php  } ?>
      <?php  if($item['paytype'] == 11) { ?>后台付款<?php  } ?>
      <?php  if($item['paytype'] == 21) { ?>微信支付<?php  } ?>
      <?php  if($item['paytype'] == 22) { ?>支付宝支付<?php  } ?>
      <?php  if($item['paytype'] == 23) { ?>银联支付<?php  } ?>
      <?php  if($item['paytype'] == 3) { ?>货到付款<?php  } ?>
   </span>
   </li>
   <li class="text">
   <span class="col-sm">买家：</span>
   <span class="text-default">
      <a href="<?php  echo webUrl('member/list/detail',array('id'=>$member['id']))?>" target='_blank' class="text-primary"><?php  echo $member['nickname'];?></a> &nbsp;&nbsp;
      <a data-toggle='popover' data-html='true' data-trigger='hover' data-placement='right' data-content="<table style='width:100%;'>
      <tr><td style='border:none;text-align:right;' colspan='2'>
      <img src='<?php  echo $member['avatar'];?>' style='width:100px;height:100px;padding:1px;border:1px solid #ccc'  onerror='this.src='../addons/ewei_shopv2/static/images/noface.png''/></td></tr>
      <tr><td  style='border:none;text-align:right;'>ID：</td>
      <td style='border:none;text-align:right;'><?php  echo $member['id'];?></td></tr>
      <tr><td style='border:none;text-align:right;'>昵称</td>
      <td style='border:none;text-align:right;'>
      <?php  if(empty($member['nickname'])) { ?>未填写<?php  } else { ?> 
      <?php  echo $member['nickname'];?><?php  } ?></td></tr>                    
      <tr>                        
      <td style='border:none;text-align:right;'>姓名：</td>
      <td style='border:none;text-align:right;'>                         
      <?php  if(empty($member['realname'])) { ?>未填写
      <?php  } else { ?>
      <?php  echo $member['realname'];?>
      <?php  } ?>                        
      </td>
      </tr>
      <tr>                        
      <td  style='border:none;text-align:right;'>手机号：</td>                        
      <td  style='border:none;text-align:right;'> <?php  if(empty($member['mobile'])) { ?>未填写<?php  } else { ?><?php  echo $member['mobile'];?><?php  } ?></td></tr>
      <tr><td  style='border:none;text-align:right;'>微信号：</td>
      <td  style='border:none;text-align:right;'><?php  if(empty($member['weixin'])) { ?>未填写<?php  } else { ?><?php  echo $member['weixin'];?><?php  } ?></td></tr></table>">
      <i class='icow icow-help' style="font-size: 13px;color: #2f3434;margin-left: -3px"></i></a>
   </span>
   </li>
   <?php  if(!empty($item['invoicename'])) { ?>                            
   <?php  $invoice_info = m('sale')->parseInvoiceInfo($item['invoicename'])?>                                
   <?php  if($invoice_info['title']) { ?>                                    
   <li class="text">
      <span class="col-sm">发票类型：</span>                                       
      <span class="text-default"><?php echo $invoice_info['entity']?'纸质':'电子'?></span>                                        
      <?php  if($invoice_info['title'] && $invoice_info['entity'] === false && $item['status']>0) { ?>                                        
      <a class="<?php  if($item['invoice_img']) { ?>text-success<?php  } else { ?>text-danger<?php  } ?>" href="<?php  echo webUrl('order.op.upload_invoice',array('order_id'=>$item['id']));?>" data-toggle="ajaxModal"> 
      <?php  if($item['invoice_img']) { ?>查看已上传的电子发票<?php  } else { ?>需要上传电子发票<?php  } ?></a>                                        
      <?php  } ?>                                    
   </li>                                    
   <li class="text">                                        
      <span class="col-sm">抬头类型：</span>                                        
      <span class="text-default"><?php echo $invoice_info['company']?'单位':'个人'?></span>                                    
   </li>                                
   <?php  } ?>                                
   <li class="text">                                    
      <span class="col-sm">发票抬头：</span>                                    
      <span class="text-default">                                        
         <?php  if($invoice_info['title']) { ?>
         <?php  echo $invoice_info['title'];?>                                        
         <?php  } else { ?><?php  echo $item['invoicename'];?><?php  } ?>
      </span>                                
   </li>                                
   <?php  if($invoice_info['company']) { ?>                                    
      <li class="text">                                        
         <span class="col-sm">纳税号：</span>                                        
         <span class="text-default"><?php  echo $invoice_info['number'];?></span>                                    
      </li>
   <?php  } ?>
   <?php  } ?>                            
   <li class="text">                                
      <span class="col-sm">配送方式：</span>                                
      <span class="text-default">
      <?php  if($item['isverify'] == 1) { ?>
      <?php  if($isonlyverifygoods) { ?>记次/时核销                                        
      <?php  } else { ?>线下核销<?php  } ?>
      <?php  } else if(!empty($item['addressid']) && $item['city_express_state']==0) { ?>快递
      <?php  if(!empty($dispatch['dispatchname'])) { ?>
      (<?php  echo $dispatch['dispatchname'];?>)
      <?php  } ?>
      <?php  } else if(!empty($item['isvirtualsend']) || !empty($item['virtual'])) { ?>
      自动发货
      <?php  if(!empty($item['isvirtualsend'])) { ?>(虚拟物品)<?php  } else { ?>(虚拟卡密)<?php  } ?>
      <?php  } else if($item['dispatchtype']) { ?>自提
      <?php  } else if($item['city_express_state']==1) { ?>同城配送
      <?php  } else { ?>其他<?php  } ?>
      </span>
   </li>
   <?php  if($item['isverify']==1 && !empty($goodsstore)) { ?>
   <li class="text">
      <span class="col-sm">指定门店：</span>
      <span class="text-default"><?php  echo $goodsstore['storename'];?></span>
   </li>
   <?php  } ?>
   <?php  if($item['isverify']==1 && !$isonlyverifygoods) { ?>
   <li class="text">
      <span class="col-sm">核销方式：</span>
      <span class="text-default">
      <?php  if($item['verifytype']==0) { ?>
      整单核销
      <?php  } else if($item['verifytype']==1) { ?>
      按次核销
      <?php  } else if($item['verifytype']==2) { ?>按消费码核销
      <?php  } ?>
      </span>
   </li>
   <?php  if($item['verifytype']==0) { ?>                            
   <li class="text">                                
      <span class="col-sm">消费码：</span>                                
      <span class="text-default"><?php  echo $item['verifycode'];?></span>                            
   </li>                            
   <?php  if($item['verified']) { ?>
      <li class="text">
         <span class="col-sm">核销时间：</span>                                
         <span class="text-default"><?php  echo date('Y-m-d H:i:s', $item['verifytime'])?></span> 
      </li>

      <?php  if(!empty($saler)) { ?>                            
      <li class="text">                                
         <span class="col-sm">核销人：</span>                                
         <span class="text-default"><?php  echo $saler['nickname'];?>( <?php  echo $saler['salername'];?> )</span>
      </li>                            
      <?php  } ?>

      <?php  if(!empty($store)) { ?>
      <li class="text">
         <span class="col-sm">核销门店：</span>
         <span class="text-default"><?php  echo $store['storename'];?></span>
      </li>
   <?php  } ?>
   <?php  } ?>
   <?php  } else if($item['verifytype']==1) { ?>
   <li class="text">
      <span class="col-sm">消费记录：</span>
      <span class="text-default">                                    
      <a href='javascript:;' onclick='$("#verify-modal").modal()'><i class="fa fa-question-circle"></i> 查看</a>
         <div id="verify-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style='width:850px'>
               <div class="modal-content">
                  <div class="modal-header">
                     <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                     <h3>核销记录</h3>                                                
                  </div>
                  <div class="modal-body" >                                                    
                     <div style='max-height:500px;overflow:auto;min-width:800px;'>
                        <table style='width:100%;' class='table'>
                           <tr><td style='width:150px'>时间</td><td style='width:100px'>核销员</td><td>门店</td></tr>
                           <?php  if(is_array($verifyinfo)) { foreach($verifyinfo as $v) { ?>
                            <tr>
                                <td><?php  echo date('Y-m-d H:i',$v['verifytime'])?></td>
                                <td><?php  echo $v['salername'];?><br/>
                                  <small><?php  echo $v['nickname'];?></small>
                                </td>
                                <td><?php  echo $v['storename'];?></td>
                            </tr>
                           <?php  } } ?>
                        </table>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a>
                  </div>
               </div>
            </div>
         </div>
      </span>
   </li>                            
   <?php  } else if($item['verifytype']==2) { ?>                            
   <li class="text">                                
      <span class="col-sm">消费码：</span>                                
      <span class="text-default"><?php  echo $item['verifycode'];?></span>                            
   </li>                            
   <?php  if(is_array($verifyinfo)) { foreach($verifyinfo as $v) { ?>                            
      <?php  if($v['verified']) { ?>                            
      <li class="text">                                
         <span class="col-sm"><?php  echo $v['verifycode'];?></span>                                
         <span class="text-default">                                    
            <a data-toggle='popover' data-html='true' data-placement='right' data-content="<table style='width:100%;'>
            <tr>
               <td style='border:none;text-align:right;'>核销员：</td>                        
               <td style='border:none;text-align:right;'><?php  echo $v['salername'];?>/<?php  echo $v['nickname'];?></td>                    
            </tr>
            <tr>
               <td style='border:none;text-align:right;'>门店：</td>                        
               <td style='border:none;text-align:right;'><?php  echo $v['storename'];?></td>                    
            </tr>                    
            <tr>                        
               <td  style='border:none;text-align:right;'>时间：</td>                        
               <td  style='border:none;text-align:right;'><?php  echo date('Y-m-d H:i',$v['verifytime'])?>
            </td>                    
            </tr>                    
            </table>"><i class="fa fa-question-circle"></i> 使用信息 </a>                                
         </span>
      </li>
      <?php  } ?>
   <?php  } } ?>
   <?php  } ?>
   <?php  } ?>
   <?php  if(!empty($item['addressid'])) { ?>                            
   <li class="text">                                
      <span class="col-sm">收货人：</span>                                
      <span class="text-default">                                    
      <?php  echo $user['address'];?>, <?php  echo $user['realname'];?>, <?php  echo $user['mobile'];?> 
      <a class='text-primary op js-clip' data-url="<?php  echo $user['address'];?>, <?php  echo $user['realname'];?>, <?php  echo $user['mobile'];?>">复制</a>
      </span>
   </li>
   <?php  } else if($item['isverify']==1 || !empty($item['virtual']) ||!empty($item['isvirtual'])) { ?>                            
   <?php  if($item['status']>=2 && !empty($item['virtual']) ) { ?>                            
   <li class="text">                                
      <span class="col-sm">发货信息：</span>                                
      <span class="text-default"><?php  echo str_replace("\n","<br/>", $item['virtual_str'])?></span>
   </li>
   <?php  } ?>                            
   <li class="text">                                
      <span class="col-sm">联系人：</span>                                
      <span class="text-default"><?php  echo $user['carrier_realname'];?>, <?php  echo $user['carrier_mobile'];?></span>
   </li>                            
   <?php  } else if(!$isonlyverifygoods) { ?>                            
   <li class="text">                                
      <span class="col-sm">自提码：</span>                                
      <span class="text-default"><?php  echo $item['verifycode'];?></span>                            
   </li>                            
   <li class="text">                                
      <span class="col-sm">自提人：</span>                                
      <span class="text-default"><?php  echo $user['carrier_realname'];?> <?php  echo $user['carrier_mobile'];?> </span>
   </li>                            
   <li class="text">                                
      <span class="col-sm">门店名称：</span>                                
      <?php  if($item['ismerch'] == 0) { ?>                                
      <span class="text-default"><?php  echo $user['storename']['storename'];?></span>                                <?php  } else { ?>                                
      <span class="text-default"><?php  echo $user['storename'];?></span>                                
      <?php  } ?>                            
   </li>                            
   <li class="text">                                
      <span class="col-sm">自提点：</span>                                
      <span class="text-default">
      <?php  echo html_entity_decode($user['address'])?>,  <?php  echo $user['realname'];?>, <?php  echo $user['mobile'];?></span>
   </li>
   <?php  if($item['verified']) { ?>                                    
   <?php  if(!empty($saler)) { ?>                                        
   <li class="text">                                            
      <span class="col-sm">核销人：</span>                                            
      <span class="text-default"><?php  echo $saler['nickname'];?>( <?php  echo $saler['salername'];?> )</span>
   </li>                                    
   <?php  } ?>                                
   <?php  } ?>                            
   <?php  } ?>                            
   <?php  if(!empty($item['remark'])) { ?>                            
   <li class="text"><span class="col-sm">买家备注：</span>
   <span class="text-default"><?php  echo $item['remark'];?></span></li>                            
   <?php  } ?>
   </ul>
   </div>
   <?php  if(!empty($item['addressid'])) { ?>
   <?php if(cv('order.op.changeaddress')) { ?>
   <div class="col-md-12 ops">
   <?php  if($item['merchid'] == 0) { ?>
   <a class="btn btn-primary" style="margin-left: 10px" data-toggle="ajaxModal" href="<?php  echo webUrl('order/op/changeaddress', array('id' => $item['id']))?>">修改订单收货信息</a><?php  } ?>                    
   </div>                    
   <?php  } ?>                    
   <?php  } ?>                   
   <?php  if(!empty($order_data)) { ?>                    
   <div class="col-md-12 order-container-footer">                        
      <span class="text" style="width: 85px;display: block"> 统一下单信息：</span>                        
      <?php  $datas = $order_data?>                        
      <?php  $ii = 0;?>                       
      <div style="flex: 1;">                           
         <table style="width: 100%;">                               
            <?php  if(is_array($order_fields)) { foreach($order_fields as $key => $value) { ?>                               
            <tr <?php  if($ii>1) { ?>class="diymore2" style="display:none;"<?php  } ?>>                                  
               <td style='width:60px'><?php  echo $value['tp_name']?>：</td>                                   
               <td style="white-space: normal;">                                       
               <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('diyform/diyform', TEMPLATE_INCLUDEPATH)) : (include template('diyform/diyform', TEMPLATE_INCLUDEPATH));?>                                   
               </td>                               
            </tr>                               
            <?php  if($ii==2) { ?>                               
            <tr class="diymore22">                                   
               <td colspan="2"><a href="javascript:void(0);" style="padding-right: 100px;" id="showdiymore2">查看完整信息</a></td>
            </tr>                               
            <?php  } ?>                               
            <?php  $ii++;?>                               
            <?php  } } ?>                           
         </table>                      
      </div>                    
   </div>                    
   <?php  } ?>                
   </div>            
   </div>            
   <div class=" order-container-static">                
   <div class=" status">                    
   <span class="text"> 订单状态：</span>                    
   <?php  if($item['status'] == 0) { ?>                    
   <?php  if($item['paytype']==3) { ?>                    
   <span class="text-warning font18">待发货</span>                    
   <?php  } else { ?>                    
   <span class="text-danger font18">待付款</span>                    
   <?php  } ?>                    
   <?php  } ?>                    
   <?php  if($item['status'] == 1) { ?>                    
   <span class="text-warning font18">                    
   <?php  if($item['isverify'] == 1) { ?>待使用
   <?php  } else if(empty($item['addressid'])) { ?>待取货<?php  } else { ?><?php  if($item['sendtype'] > 0) { ?>部分发货<?php  } else { ?>待发货<?php  } ?><?php  } ?>
   </span>                    
   <?php  } ?>                    
   <?php  if($item['status'] == 2) { ?><span class="text-warning font18">待收货</span><?php  } ?>                    
   <?php  if($item['status'] == 3) { ?><span class="text-success font18">交易完成</span><?php  } ?>                    
   <?php  if($item['status'] == -1) { ?>                    <span class="text-default font18">已关闭</span>                    
   <?php  } ?>                    <i><?php  if($item['status'] == 0) { ?>                        
   <?php  if($item['paytype']==3) { ?>                        
   （此订单为货到付款订单，请商家尽快发货）                        
   <?php  } else { ?>                       
   （ 等待买家付款）                        
   <?php  } ?>                        
   <?php  } ?>                        
   <?php  if($item['status'] == 1 && $item['sendtype'] == 0) { ?>（买家已经付款，请商家尽快发货）<?php  } ?>
   <?php  if($item['status'] == 2 || ($item['status']==1 && $item['sendtype'] > 0)) { ?>（商家已发货，等待买家收货并交易完成）
   <?php  } ?>
   <?php  if($item['status'] == -1) { ?>
   <?php  if(!empty($refund) && $refund['status']==1) { ?>
   （  <span class="label label-default">已维权</span> 
   <?php  if(!empty($refund['refundtime'])) { ?>维权时间: <?php  echo date('Y-m-d H:i:s',$refund['refundtime'])?><?php  } ?>）
   <?php  } ?>                        
   <?php  } ?>                    
   </i>                
   </div>                
   <?php  if(empty($order_goods)) { ?>               
   <?php  if(!empty($item['expresssn']) && $item['status']>=2 && !empty($item['addressid'])) { ?>
   <div>
   <ul>
   <li class="text">快递公司：<span class="text-default"><?php  if(empty($item['expresscom'])) { ?>其他快递<?php  } else { ?><?php  echo $item['expresscom'];?><?php  } ?></span></li>                        
   <li class="text">快递单号：<span class="text-default"><?php  echo $item['expresssn'];?></span>&nbsp;<a class="text-primary op" data-toggle="ajaxModal" href="<?php  echo webUrl('util/express', array('id' => $item['id'],'express'=>$item['express'],'expresssn'=>$item['expresssn']))?>">查看物流</a></li>                        
   <li class="text">发货时间：<span class="text-default"><?php  echo date('Y-m-d H:i:s',$item['sendtime'])?></span></li>
   </ul>                
   </div>                
   <?php  } ?>                
   <?php  } ?>
   <div class="ops  col-md-12" style="padding: 0;">
      <?php  if($item['merchid'] == 0 ) { ?>
      <?php  $detial_flag = 1?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('order/ops', TEMPLATE_INCLUDEPATH)) : (include template('order/ops', TEMPLATE_INCLUDEPATH));?>                    
         <?php  if($item['status'] ==0 && $item['ispackage']==0) { ?>                    
            <?php if(cv('order.op.changeprice')) { ?>
            <a class='text-primary'  data-toggle='ajaxModal' href="<?php  echo webUrl('order/op/changeprice',array('id'=>$item['id']))?>">订单改价</a>
            <?php  } ?>
         <?php  } ?>
      <?php  if(!empty($item['agentid'])) { ?>                   
      <?php if(cv('commission.changecommission')) { ?>                    
      <a class="text-primary" data-toggle="ajaxModal" href="<?php  echo webUrl('commission/apply/changecommission', array('id' => $item['id']))?>">修改佣金</a>                    
      <?php  } ?>
      <?php  } ?><?php if(cv('order.op.remarksaler')) { ?>                    
      <a class="text-primary" data-toggle="ajaxModal" href="<?php  echo webUrl('order/op/remarksaler', array('id' => $item['id']))?>">
      <?php  if(!empty($item['remarksaler'])) { ?>查看备注
      <?php  } else { ?>添加备注
      <?php  } ?>
      </a>
      <?php  } ?>
      <?php  } ?>
   </div>                
   <?php  if($item['status'] >0) { ?>                
   <div class="order-container-footer text col-md-12" style="border:none;padding: 0">                    友情提示：                    
   <?php  if($item['status'] == 0) { ?>                    
   <?php  if($item['paytype']==3) { ?>
   订单为货到付款，请您务必联系买家确认后再进行发货
   <?php  } else { ?>                    
   您可以联系买家进行付款，否则订单会根据设置自动关闭                    
   <?php  } ?>                    
   <?php  } ?>                    
   <?php  if($item['status'] == 1) { ?>                    
   如果无法进行发货，请及时联系买家进行妥善处理;                    
   <?php  } ?>                    
   <?php  if($item['status'] == 2) { ?>                    
   请及时关注物流状态，确保买家及时收到商品;                    如果买家未收到货物或有退换货请求，请及时联系买家妥善处理                    
   <?php  } ?>                    
   <?php  if($item['status']==3) { ?>                    
   交易成功，如买家有售后申请，请与买家进行协商，妥善处理                    
   <?php  } ?>                
   </div>                
   <?php  } ?>            
   </div>            
   <?php  if(p('commission') && count($agents)>0) { ?>            
   <div class="distribution col-sm-4 col-md-3">                
   <div class="row">                    
   <?php  if(is_array($agents)) { foreach($agents as $key => $value) { ?>                    
   <?php  if(!empty($value)) { ?>                    
   <div class="">                        
   <label for="">                            
   <?php  if($key == 0) { ?>一级分销商<?php  } else if($key == 1) { ?>二级分销商<?php  } else if($key == 2) { ?>三级分销商<?php  } ?>
   </label>                        
   <ul class="">                            
   <li class="text">                                
   <span style="display:inline-block;width: 45px;">姓名：</span>                                            
   <span class="text-primary" >                                                
   <a href="<?php  echo webUrl('member/list/detail',array('id'=>$value['id']))?>" target='_blank' class="text-primary"> 
   <?php  if(empty($value['realname'])) { ?>未填写<?php  } else { ?><?php  echo $value['realname'];?><?php  } ?></a>                                                
   <a data-toggle='popover' data-trigger='hover'  data-html='true' data-placement='right' data-content="<table style='width:100%;'>
   <tr><td style='border:none;text-align:right;' colspan='2'><img src='<?php  echo tomedia($value['avatar'])?>' style='width:100px;height:100px;padding:1px;border:1px solid #ccc' /></td>                                
   </tr>                                 
   <tr>                                    
   <td style='border:none;text-align:right;'>ID：</td>                                    
   <td style='border:none;text-align:right;'><?php  echo $value['id'];?></td>                                
   </tr>                                
   <tr>
   <td style='border:none;text-align:right;'>昵称</td>                                    
   <td style='border:none;text-align:right;'><?php  if(empty($value['nickname'])) { ?>未填写<?php  } else { ?> <?php  echo $value['nickname'];?><?php  } ?>
   </td>
   </tr>
   <tr>                                    
   <td style='border:none;text-align:right;'>姓名：</td><td  style='border:none;text-align:right;'><?php  if(empty($value['realname'])) { ?>未填写<?php  } else { ?><?php  echo $value['realname'];?><?php  } ?>
   </td>                                
   </tr>                                
   <tr>                                    
   <td style='border:none;text-align:right;'>手机号：</td>                                    
   <td style='border:none;text-align:right;'> <?php  if(empty($value['mobile'])) { ?>未填写<?php  } else { ?><?php  echo $value['mobile'];?><?php  } ?></td>                                </tr>                                <tr>                                    <td  style='border:none;text-align:right;'>微信号：</td>                                    <td  style='border:none;text-align:right;'><?php  if(empty($value['weixin'])) { ?>未填写<?php  } else { ?><?php  echo $value['weixin'];?><?php  } ?></td>                                </tr>                                </table>                ">
   <i class='icow icow-help' style="font-size: 13px;color: #2f3434"></i></a></span></li>
   <li class="text"><span style="display:inline-block;width: 50px;">手机号：</span>
   <span class="text-default"><?php  echo $value['mobile'];?></span></li>                            
   <li class="text"><span style="display:inline-block;width: 50px;">佣金：</span>
   <span class='text-default'><?php  echo $value['commission'];?></span></li>                        
   </ul>                    
   </div>                    
   <?php  } ?>                    
   <?php  } } ?>                    
   <!----分红-------->                    
   <?php  if(!empty($heads)) { ?>
   <div>                        
   <label >团长分红</label>                        
   <ul>                            
   <li class="text">                                
   <span style="display:inline-block;width: 45px;">姓名：</span>                                
   <span class="text-primary" >                                   
   <a href="<?php  echo webUrl('member/list/detail',array('id'=>$heads['id']))?>" target='_blank' class="text-primary"> 
   <?php  if(empty($heads['realname'])) { ?>未填写<?php  } else { ?><?php  echo $heads['realname'];?><?php  } ?></a>
   <a data-toggle='popover' data-trigger='hover'  data-html='true' data-placement='right' data-content="<table style='width:100%;'>
   <tr>
   <td  style='border:none;text-align:right;' colspan='2'><img src='<?php  echo tomedia($heads['avatar'])?>' style='width:100px;height:100px;padding:1px;border:1px solid #ccc' />
   </td>                                
   </tr>                                 
   <tr>                                    
   <td  style='border:none;text-align:right;'>ID：</td>                                    
   <td  style='border:none;text-align:right;'><?php  echo $heads['id'];?></td>                                
   </tr>                                <tr>                                    
   <td  style='border:none;text-align:right;'>昵称</td>                                    
   <td  style='border:none;text-align:right;'>                                    
   <?php  if(empty($heads['nickname'])) { ?>未填写<?php  } else { ?> <?php  echo $heads['nickname'];?><?php  } ?>                                    
   </td>                                
   </tr>                                
   <tr>                                    
   <td  style='border:none;text-align:right;'>姓名：</td>                                    
   <td  style='border:none;text-align:right;'>                                     
   <?php  if(empty($heads['realname'])) { ?>未填写<?php  } else { ?><?php  echo $heads['realname'];?><?php  } ?>                                    
   </td>                                
   </tr>                                
   <tr>                                    
   <td  style='border:none;text-align:right;'>手机号：</td>                                    
   <td  style='border:none;text-align:right;'>                                     
   <?php  if(empty($heads['mobile'])) { ?>未填写<?php  } else { ?><?php  echo $heads['mobile'];?><?php  } ?></td>                               
   </tr>                                
   <tr>                                    
   <td  style='border:none;text-align:right;'>微信号：</td>                                    
   <td  style='border:none;text-align:right;'><?php  if(empty($heads['weixin'])) { ?>未填写<?php  } else { ?><?php  echo $heads['weixin'];?><?php  } ?></td>                                
   </tr>                                
   </table>">
   <i class='icow icow-help' style="font-size: 13px;color: #2f3434"></i></a>                                
   </span>                            
   </li>                            
   <li class="text"><span style="display:inline-block;width: 50px;">手机号：</span>
   <span class="text-default"><?php  echo $heads['mobile'];?></span></li>                            
   <li class="text"><span style="display:inline-block;width: 50px;">分红：</span>
   <span class='text-default'><?php  echo $dividend_price;?></span></li>                        
   </ul>                    
   </div>                
   <?php  } ?>                
   <!----分红结束-------->                
   </div>            
   </div>            
   <?php  } ?>        
   </div>        
   <?php  if(!empty($order_goods)) { ?>            
   <h3 class="order-title">包裹信息</h3>            
   <div class="packbag-group">                
     <?php  if(is_array($order_goods)) { foreach($order_goods as $index => $og) { ?>                    
     <div class="packbag-list">                        
        <div class="packbag-media">
         <i class="icow icow-baoguo" style="display: inline-block;vertical-align: middle;font-size: 22px"></i>包裹<?php  echo chr($index+65)?>
        </div>
         <div class="packbag-inner">
              <div class="packbag">                                
              <div class="packbag-title">                                    
                 <span style="margin-right: 90px">快递：
                 <?php  if(empty($og['expresscom'])) { ?>其他快递<?php  } else { ?><?php  echo $og['expresscom'];?><?php  } ?></span>
                 <span style="margin-right: 15px">快递单号：<?php  echo $og['expresssn'];?></span><span style="margin-right: 90px"><a class="text-primary op" data-toggle="ajaxModal" href="<?php  echo webUrl('util/express', array('id' => $og['id'],'express'=>$og['express'],'expresssn'=>$og['expresssn']))?>">查看物流</a></span><span>发货时间：<?php  echo date('Y-m-d H:i:s', $og['sendtime'])?></span>
              </div>                                
              <?php  if(is_array($og['goods'])) { foreach($og['goods'] as $i => $goods) { ?>                                    
              <div class="packbag-goods-list">                                        
                 <div class="packbag-goods">                                            
                    <div class="packbag-goods-media">                                                
                    <img src="<?php  echo tomedia($goods['thumb'])?>" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />                                            
                    </div>                                            
                    <div class="packbag-goods-inner">                                                
                       <p class="title">                                                    
                       <a target="_blank" href="<?php  echo webUrl('goods/edit', array('id' => $goods['id']))?>" title="查看" style="display: block;line-height: 22px;max-width: 250px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><?php  echo $goods['title'];?></a>                                                
                       </p>                                                
                       <p>&yen;<?php  echo $goods['realprice'];?></p>                                            
                    </div>                                        
                 </div>                                    
              </div>                                
              <?php  } } ?>                            
              </div>                        
           </div>                    
        </div>                
        <?php  } } ?>            
    </div>        
    <?php  } ?>        
        <h3 class="order-title">商品信息
           <a class="btn btn-primary" style="margin-left: 10px" data-toggle="ajaxModal" href="<?php  echo webUrl('order/detail/ordergoods_add', array('id' => $item['id']))?>">添加商品</a>
           <!-- <a class="btn btn-primary" style="margin-left: 10px" id="save_goods">保存订单商品信息</a> -->
        </h3>
        <table class="table table-responsive">
        <thead>
           <tr class="trorder" style="background: #fff">                
              <th class="" style="width: 10%;text-align: right;padding-right: 0">商品标题</th>                
              <th style=""></th>                
              <th style="padding-left: 10px">规格、编号、条码</th>                
              <th style="text-align: center;width: 10%">价格</th> 
             <!--  <th style="text-align: center;width: 15%;">折扣后</th>     -->            
              <th style="text-align: center;width: 10%">数量</th> 
              <th style="text-align: center;width: 10%;">总价</th>
              <!-- <?php  if($item['ispackage']) { ?>
              <th  style="text-align: center;width: 10%;">总价</th>                
              <?php  } else { ?>
              <th  style="text-align: center;width: 15%;">原价</th>                
              <th  style="text-align: center;width: 15%;">折扣后</th>                
              <?php  } ?> -->
              <?php  if($showdiyform) { ?>                    
              <th style="text-align: center;">自定义信息</th>                
              <?php  } ?>
              <th style="text-align: center;width: 10%">操作</th>            
           </tr>            
        </thead>            
        <tbody>
        <form action="" method="post" id="form" class="form-horizontal form-validate">            
        <?php  $i=0;?>
        <?php  if(is_array($item['goods'])) { foreach($item['goods'] as $goods) { ?>
        <tr class="trorder" style="background:#fff">
        <td style="text-align: right;padding-right:0">
           <img src="<?php  echo tomedia($goods['thumb'])?>" style='width:52px;height:52px;border:1px solid #efefef; padding:1px;'onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'">
        </td>
        <td style="min-width: 300px">
           <a target="_blank" href="<?php  echo webUrl('goods/edit', array('id' => $goods['id']))?>"title="查看" style="display: block;line-height: 22px;max-width: 250px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><?php  echo $goods['title'];?></a>
           <?php  if(!empty($goods['invoice'])) { ?><label class='label label-danger'>支持开票</label><?php  } ?>
           <?php  if($goods['seckill_task']) { ?>
           <span class="label label-danger"><?php  echo $goods['seckill_task']['tag'];?></span>                        
           <?php  if($goods['seckill_room']) { ?>
              <span class="label label-primary">
                 <?php echo $goods['seckill_room']['tag']?:$goods['seckill_room']['title']?>
              </span>
           <?php  } ?>
           <br/>
           <?php  } ?>
           <?php  if($category[$goods['pcate']]['name']) { ?>
           <span class="text-error">[<?php  echo $category[$goods['pcate']]['name'];?>]</span><?php  } ?>
           <?php  if($children[$goods['pcate']][$goods['ccate']]['1']) { ?>
           <span class="text-info">[<?php  echo $children[$goods['pcate']][$goods['ccate']]['1'];?>]</span>
           <?php  } ?>
        </td>
        <td style="padding: 10px 20px">
           <p style="white-space:normal;">规格：<?php  if(!empty($goods['optionname'])) { ?>
              <span class="label label-primary" data-container="body" data-toggle="popover" data-placement="right" data-content="<?php  echo $goods['optionname'];?>"><?php  echo $goods['optionname'];?>
              </span><?php  } else { ?>无<?php  } ?>                        
           </p>
           <p>
           编码：<?php  if(!empty($goods['goodssn'])) { ?><span><?php  echo $goods['goodssn'];?></span><?php  } else { ?>无<?php  } ?>
           </p>
           <p>条码：<?php  if(!empty($goods['productsn'])) { ?><span><?php  echo $goods['productsn'];?></span> 
           <?php  } else { ?>无<?php  } ?>
           </p>
        </td>
       <!--  <td  style="text-align: center">
            <p>￥<?php  echo number_format($goods['marketprice'],2)?></p>        
        </td>  -->                    
        <td style="text-align: center">                        
            <p>￥<?php  echo bcdiv($goods['orderprice'],$goods['total'],2);?></p>       
        </td>
        <td style="text-align: center">
           <p style="display:block;width:100%;"><?php  echo $goods['total'];?></p> 
        </td>
        <!-- <td style="text-align: center">
           <p style="display:block;width:100%;"><input type="number" name="goods_num[]" class="form-control" value="<?php  echo $goods['total'];?>"/></p> 
           <input type="hidden" name="goods_id[]" class="form-control" value="<?php  echo $goods['id'];?>"/>
        </td> -->
        <td style="text-align: center">&yen;<?php  echo number_format($goods['orderprice'],2)?></td>  
      <!--   <?php  if($item['ispackage']) { ?>                        
        <td style="text-align: center">&yen;<?php  echo number_format($goods['marketprice'],2)?></td>                    <?php  } else { ?>        <td style="text-align: center">&yen;<?php  echo $goods['orderprice'];?></td>
        <td style="text-align: center">&yen;<?php  echo $goods['realprice'];?>
        </td>
        <?php  } ?>-->
        <?php  if(!empty($goods['diyformdata']) && $goods['diyformdata'] != 'false') { ?>                        
        <td style="text-align: center;">
        <a href="javascript:;" class="text-primary" hide="1" data="<?php  echo $i;?>" onclick="showDiyInfo(this)">点击展开</a>
        </td>
        <?php  } ?>
        <td style="text-align: center">
        <p>
           <a class='btn btn-op btn-operation' data-toggle='ajaxRemove' href="<?php  echo webUrl('order/detail/ordergoods_delete', array('goodsid' => $goods['id'],'id'=>$item['id']))?>" data-confirm='确认彻底删除此商品？'>
                <span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">
                     <i class='icow icow-shanchu1'></i>
                </span>
           </a>
        </p>
        </td>
        </tr>
        <?php  if(!empty($goods['diyformdata']) && $goods['diyformdata'] != 'false') { ?>
        <tr class="trorder" style='display: none;' id="diyinfo_<?php  echo $i;?>">
           <td colspan='8'>
              <table class='ordertable'>
                 <?php  $datas = $goods['diyformdata']?>
                 <?php  if(is_array($goods['diyformfields'])) { foreach($goods['diyformfields'] as $key => $value) { ?>
                 <tr>
                 <td style='width:80px'><?php  echo $value['tp_name']?>：</td>
                 <td style="border: 0;">
                 <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('diyform/diyform', TEMPLATE_INCLUDEPATH)) : (include template('diyform/diyform', TEMPLATE_INCLUDEPATH));?>
                 </td>
                 </tr>
                 <?php  } } ?>
              </table>
           </td>
        </tr>
        <?php  } ?>                
        <?php  $i++;?>            
        <?php  } } ?>            
        </tbody>
        </form>
        <tfoot style="padding-top: 20px">            
        <tr class="trorder">                
        <td colspan="3" style="padding-left: 20px"> <?php  if($item['ispackage']) { ?>                    
          <span class="text-danger" style="color:red;">（套餐优惠价：&yen;<?php  echo number_format($item['price'],2)?><?php  if($item['dispatchprice'] ) { ?>，含运费：&yen;<?php  echo number_format($item['dispatchprice'],2)?><?php  } ?>）</span>                    
        <?php  } ?>
        </td>
        <?php //$colspan=$item['ispackage']?4:5;?>
        <?php  $colspan = 4;?>
        <?php  if($showdiyform) { ?>
        <?php  $colspan++?>
        <?php  } ?>
        <td colspan="<?php  echo $colspan;?>" style="padding-right: 60px">                    
        <div class="price">                        
        <p><span class="price-inner">商品小计：</span>
        <span style="font-weight: bold">￥<?php  echo $item['goodsprice'];?></span></p>
        <p><span class="price-inner">运费：</span>￥<?php  echo $item['olddispatchprice'];?></p>                        
        <?php  if(!$item['ispackage']) { ?>                        <?php  if($item['taskdiscountprice']>0 ) { ?>                        
        <p><span class="price-inner">任务活动优惠：</span>
        <span class="text-danger">-￥<?php  echo $item['taskdiscountprice'];?></span></p>                        
        <?php  } ?>                        
        <?php  if($item['lotterydiscountprice']>0 ) { ?>                        
        <p>
        <span class="price-inner">游戏活动优惠：</span>
        <span class="text-danger">-￥<?php  echo $item['lotterydiscountprice'];?></span></p>                        
        <?php  } ?>                        
        <?php  if($item['discountprice']>0 ) { ?>                        
        <p><span class="price-inner">会员折扣：</span>
        <span class="text-danger">-￥<?php  echo $item['discountprice'];?></span></p>                        
        <?php  } ?>                        
        <?php  if($item['deductprice']>0 ) { ?>                        
        <p><span class="price-inner">积分抵扣：</span>
        <span class="text-danger">-￥<?php  echo $item['deductprice'];?></span></p>
        <?php  } ?>                        
        <?php  if($item['deductcredit2']>0 ) { ?>                        
        <p><span class="price-inner">余额抵扣：</span>
        <span class="text-danger">-￥<?php  echo $item['deductcredit2'];?></span></p>                        
        <?php  } ?>                        <?php  if($item['deductenough']>0 ) { ?>                        
        <p><span class="price-inner">商城满额立减：</span>
        <span class="text-danger">-￥<?php  echo $item['deductenough'];?></span></p>                        
        <?php  } ?>                        <?php  if($item['merchdeductenough']>0 ) { ?>                        
        <p><span class="price-inner">商户满额立减：</span>
        <span class="text-danger">-￥<?php  echo $item['merchdeductenough'];?></span></p>                        
        <?php  } ?>                        <?php  if($item['couponprice']>0 ) { ?>                        
        <p><span class="price-inner">优惠券优惠：</span>
        <span class="text-danger">-￥<?php  echo $item['couponprice'];?></span></p>
        <?php  } ?>                        
        <?php  if($use_membercard) { ?>                        
        <p><span class="price-inner">会员卡优惠：</span><span class="text-danger"> -&yen; <?php  echo $card_dec_price;?></span></p>
        <?php  } ?>
        <?php  if($item['isdiscountprice']>0 ) { ?>                        
        <p><span class="price-inner">促销优惠：</span>
        <span class="text-danger">-￥<?php  echo $item['isdiscountprice'];?></span></p>
        <?php  } ?>
         <?php  if($item['buyagainprice']>0 ) { ?>
         <p><span class="price-inner">重复购买优惠：</span>
         <span class="text-danger">-￥<?php  echo $item['buyagainprice'];?></span></p>                        
         <?php  } ?><?php  if($item['seckilldiscountprice']>0 ) { ?>                        
         <p><span class="price-inner">秒杀优惠：</span>
         <span class="text-danger">-￥<?php  echo $item['seckilldiscountprice'];?></span></p>
         <?php  } ?><?php  } ?><?php  if(intval($item['changeprice'])!=0) { ?><p><span class="price-inner">卖家改价：</span>                            
         <span style='<?php  if(0<$item['changeprice']) { ?>color:green<?php  } else { ?>color:red<?php  } ?>'><?php  if(0<$item['changeprice']) { ?>+<?php  } else { ?>-<?php  } ?>￥<?php  echo number_format(abs($item['changeprice']),2)?></span></p><?php  } ?><?php  if(intval($item['changedispatchprice'])!=0) { ?>
         <p>                            
         <span class="price-inner">卖家改运费：</span>                            
         <span style='<?php  if(0<$item['changedispatchprice']) { ?>color:green<?php  } else { ?>color:red<?php  } ?>'><?php  if(0<$item['changedispatchprice']) { ?>+<?php  } else { ?>-<?php  } ?>￥<?php  echo abs($item['changedispatchprice'])?></span></p>                        
         <?php  } ?>                        
         <p><span class="price-inner">实付款：</span>
         <span style="font-size: 14px;font-weight: bold;color: #e4393c">￥<?php  echo $item['price'];?></span></p>                    
         </div>                
         </td>            
         </tr>            
         </tfoot>        
         </table>       
          <?php  if(count($verifygoods_list)>0) { ?>        
          <h3 class="order-title">记次/时核销记录            
          <?php  if($verifygoods_times_total>0) { ?>
          <small>剩余 <?php  echo $verifygoods_times_total - $verifygoods_times?> / 总数 
          <span class="text-danger"><?php  echo $verifygoods_times_total;?></span> </small></h3>          
          <?php  } ?>        
          <table class="table table-responsive">            
             <thead class="navbar-inner">            
                <tr>
                <th >核销时间</th>                
                <th >核销次数</th>                
                <th >核销人</th>                
                <th >核销门店</th>                
                <th >备注信息</th>            
                </tr>            
             </thead>            
             <tbody>            
                <?php  if(is_array($verifygoods_list)) { foreach($verifygoods_list as $row) { ?>            
                <tr>                
                <td><?php  echo date('Y-m-d H:i:s',$row['verifydate'])?></td>                
                <td><?php  echo $row['verifynum'];?></td>                
                <td>                    
                <?php  echo $row['salername'];?>                
                </td>                
                <td>                   
                <?php  echo $row['storename'];?>                
                </td>                
                <td>                    
                <?php  echo $row['remarks'];?>                
                </td>            
                </tr>            
                <?php  } } ?>            
            </tbody>        
          </table>        
          <?php  } else { ?>        
          <?php  if($isonlyverifygoods) { ?>        
          <h3 class="order-title">暂时无任何核销记录</h3>        
          <?php  } ?>       
          <?php  } ?>    
          </form>
          </div>
<script language='javascript'>    
$(function () {
   $("#showdiymore1").click(function () {            
      $(".diymore1").show();            
      $(".diymore11").hide();        
   });        
   $("#showdiymore2").click(function () {            
      $(".diymore2").show();           
      $(".diymore22").hide();        
      });    
   });    
function showDiyInfo(obj){
   var data = $(obj).attr('data');        
   var id = "diyinfo_" + data;        
   var hide = $(obj).attr('hide');        
   if(hide=='1'){
      $("#"+id).show();           
      $(obj).text('点击收起');        
   }else{
      $("#"+id).hide();            
      $(obj).text('点击展开');        
   }
   $(obj).attr('hide',hide=='1'?'0':'1');    
}

<?php  //echo webUrl('order/detail/ordergoods_edit', array('id' => $item['id']))?>


$('#save_goods').click(function(){

    var goods_id =[];
    var goods_num =[];
    $("input[name='goods_id[]']").each(function(){
        goods_id.push($(this).val());
    });
   
    $("input[name='goods_num[]']").each(function(){
        goods_num.push($(this).val());
    });
 console.log(goods_id);
    // $.post("<?php  echo webUrl('order/detail/ordergoods_edit')?>", {start:start,end:end,tips:tips}, function (data) 
    // {
    //     //console.log(data);
    //     if(data.result.status==0)
    //     {
    //        tip.msgbox.suc("修改失败");
    //     }else{
    //        tip.msgbox.suc("修改成功");
    //     }
     
    // }, "json");

});

</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>