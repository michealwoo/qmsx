<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type='text/css'>
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
        padding: 10px 20px;
    }
     .table > tbody>.trbody > td{
         border-top:none !important;
     }
    .trhead td {  background:#efefef;text-align: center}
    .trbody td {  text-align: center; vertical-align:top;border-left:1px solid #f2f2f2;overflow: hidden; font-size:12px;}
    .trorder { background:#f8f8f8;border:1px solid #f2f2f2;text-align:left;}
    .ops { border-right:1px solid #f2f2f2; text-align: center;}
    .paytype span{
        vertical-align: middle;
    }
</style>

<div class="page-header">
    当前位置：<span class="text-primary">分销订单
<span>订单数:  <span class='text-danger'><?php  echo $total;?></span> 订单金额:  <span class='text-danger'><?php  echo $totalmoney;?></span> <?php  if(!empty($magent['nickname'])) { ?>订单推广人:  <span class='text-danger'><?php  echo $magent['nickname'];?></span><?php  } ?></span>
</span>
</div>

<div class="page-content">
    <form action="./index.php" method="get" class="form-horizontal table-search" role="form">
        <input type="hidden" name="c" value="site" />
        <input type="hidden" name="a" value="entry" />
        <input type="hidden" name="m" value="ewei_shopv2" />
        <input type="hidden" name="do" value="web" />
        <input type="hidden" name="r" value="commission.statistics.order" />
        <input type="hidden" name="status" value="<?php  echo $status;?>" />
        <input type="hidden" name="agentid" value="<?php  echo $_GPC['agentid'];?>" />
        <input type="hidden" name="refund" value="<?php  echo $_GPC['refund'];?>" />
        <div class="page-toolbar m-b-sm m-t-sm">
                <div class="input-group">
                    <div class="input-group-btn">
                        <?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d H:i', $starttime),'endtime'=>date('Y-m-d H:i', $endtime)),true);?>
                    </div>
                    <div class="input-group-select">
                        <select name="paytype" class="form-control" style="">
                            <option value="" <?php  if($_GPC['paytype']=='') { ?>selected<?php  } ?>>支付方式</option>
                            <?php  if(is_array($paytype)) { foreach($paytype as $key => $type) { ?>
                            <option value="<?php  echo $key;?>" <?php  if($_GPC['paytype'] == "$key") { ?> selected="selected" <?php  } ?>><?php  echo $type['name'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                    <div class="input-group-select">
                        <select name='searchtime'  class='form-control'   style=""  >
                            <option value=''>不按时间</option>
                            <option value='create' <?php  if($_GPC['searchtime']=='create') { ?>selected<?php  } ?>>下单时间</option>
                            <option value='pay' <?php  if($_GPC['searchtime']=='pay') { ?>selected<?php  } ?>>付款时间</option>
                            <option value='send' <?php  if($_GPC['searchtime']=='send') { ?>selected<?php  } ?>>发货时间</option>
                            <option value='finish' <?php  if($_GPC['searchtime']=='finish') { ?>selected<?php  } ?>>完成时间</option>
                        </select>
                    </div>
                    <div class="input-group-select">
                        <select name='searchfield'  class='form-control'   style=""  >
                            <option value='ordersn' <?php  if($_GPC['searchfield']=='ordersn') { ?>selected<?php  } ?>>订单号</option>
                            <option value='member' <?php  if($_GPC['searchfield']=='member') { ?>selected<?php  } ?>>会员信息</option>
                            <option value='address' <?php  if($_GPC['searchfield']=='address') { ?>selected<?php  } ?>>收件人信息</option>
                            <option value='location' <?php  if($_GPC['searchfield']=='location') { ?>selected<?php  } ?>>地址信息</option>
                            <option value='expresssn' <?php  if($_GPC['searchfield']=='expresssn') { ?>selected<?php  } ?>>快递单号</option>
                            <option value='goodstitle' <?php  if($_GPC['searchfield']=='goodstitle') { ?>selected<?php  } ?>>商品名称</option>
                            <option value='goodssn' <?php  if($_GPC['searchfield']=='goodssn') { ?>selected<?php  } ?>>商品编码</option>
                            <option value='saler' <?php  if($_GPC['searchfield']=='saler') { ?>selected<?php  } ?>>核销员</option>
                            <option value='store' <?php  if($_GPC['searchfield']=='store') { ?>selected<?php  } ?>>核销门店</option>
                            <?php  if($merch_plugin) { ?>
                            <option value='merch' <?php  if($_GPC['searchfield']=='merch') { ?>selected<?php  } ?>>商户名称</option>
                            <?php  } ?>
                        </select>
                    </div>
                    <input type="text" class="form-control"  name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词"/>
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"> 搜索</button>
                        <button type="submit" name="export" value="1" class="btn btn-success">导出</button>
                    </span>
                </div>
        </div>

    </form>


    <?php  if(count($list)>0) { ?>
    <table class='table table-responsive' style='table-layout: fixed;'>
        <tr style='background:#f8f8f8'>
            <td style='width:100px;border-left:1px solid #f2f2f2;'>商品</td>
            <td ></td>
            <td style='width:100px;text-align: right;;'>单价/数量</td>
            <td  style='text-align: center;'>买家</td>
            <td style='text-align: center;'>支付/配送</td>
            <td style='text-align: center;'>价格</td>
            <td style='text-align: center;'>操作</td>
            <td style='text-align: center'>分销商</td>
            <td style='text-align: center'>状态</td>

        </tr>
        <?php  if(is_array($list)) { foreach($list as $item) { ?>
        <tr ><td colspan='9' style='height:20px;padding:0;border-top:none;'>&nbsp;</td></tr>
        <tr class='trorder'>
            <td colspan='4' >
                <span style="font-weight: bold;"><?php  echo date('Y-m-d',$item['createtime'])?> <?php  echo date('H:i:s',$item['createtime'])?></span>
                订单编号:  <?php  echo $item['ordersn'];?>
                <?php  if(!empty($item['refundstate'])) { ?><label class='label label-danger'><?php  echo $r_type[$item['rtype']];?>申请</label><?php  } ?>
                <?php  if(!empty($item['refundstate']) && $item['rstatus'] == 4) { ?><label class='label label-default'>客户退回物品</label><?php  } ?>
            </td>
            <td colspan='5' style='text-align:right;font-size:12px;' class=''>

                <?php  if($item['merchid'] == 0) { ?>
                    <?php  if(empty($item['statusvalue'])) { ?>
                        <?php  if($item['ismerch'] == 0) { ?>
                            <?php if(cv('order.op.close')) { ?>
                            <!--a class='op'  data-toggle='ajaxModal' href="<?php  echo webUrl('order/op/close',array('id'=>$item['id']))?>" >关闭订单</a-->
                            <?php  } ?>
                        <?php  } ?>
                        <?php if(cv('order.op.changeprice')) { ?>
                        <!--a class='op'  data-toggle='ajaxModal' href="<?php  echo webUrl('order/op/changeprice',array('id'=>$item['id']))?>">订单改价</a-->
                        <?php  } ?>
                    <?php  } ?>
                <?php  } ?>

                <?php  if(!empty($item['refundid'])) { ?>
                <!--a class='op'  href="<?php  echo webUrl('order/op/refund', array('id' => $item['id']))?>" >维权<?php  if($item['refundstate']>0) { ?>处理<?php  } else { ?>详情<?php  } ?></a-->
                <?php  } ?>

                <?php  if($item['merchid'] == 0) { ?>
                    <?php  if($item['statusvalue'] == 2 && !empty($item['addressid'])) { ?>
                        <?php if(cv('order.op.send')) { ?>
                        <!--a class="op" data-toggle="ajaxModal"  href="<?php  echo webUrl('order/op/changeexpress', array('id' => $item['id']))?>">修改物流</a-->
                        <?php  } ?>
                    <?php  } ?>
                <?php  } ?>


                <?php  if($item['merchid'] == 0) { ?>
                <?php if(cv('order.op.remarksaler')) { ?>
                <a class='op'  data-toggle="ajaxModal" href="<?php  echo webUrl('order/op/remarksaler', array('id' => $item['id']))?>"  >
                    <?php  if(!empty($item['remarksaler'])) { ?>
                        <i class="icow icow-yibiaoji"></i>
                        备注
                    <?php  } else { ?>
                    <i class="icow icow icow-flag-o text-danger"></i>
                    备注
                    <?php  } ?>
                </a>
                <?php  } ?>
                <?php  } ?>

                <!--<a class='op'   href="<?php  echo webUrl('order', array('op' => 'detail', 'id' => $item['id']))?>" >标记</a>-->
            </td>
        </tr>
        <?php  if(is_array($item['goods'])) { foreach($item['goods'] as $k => $g) { ?>
        <tr class='trbody'>
            <td style='overflow:hidden;'><img src="<?php  echo tomedia($g['thumb'])?>" style='width:70px;height:70px;border:1px solid #ccc; padding:1px;' onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'"></td>
            <td style='text-align: left;overflow:hidden;border-left:none;'  ><?php  echo $g['title'];?><?php  if(!empty($g['optiontitle'])) { ?><br/><?php  echo $g['optiontitle'];?><?php  } ?><br/><?php  echo $g['goodssn'];?></td>
            <td style='text-align:right;border-left:none;'><?php  echo number_format($g['realprice']/$g['total'],2)?><br/>x<?php  echo $g['total'];?></td>

            <?php  if($k==0) { ?>
            <td rowspan="<?php  echo count($item['goods'])?>"  style='text-align: center;' >
                <?php if(cv('member.member.edit')) { ?>
                <a href="<?php  echo webUrl('member/list/detail',array('id'=>$item['mid']))?>"> <?php  echo $item['nickname'];?></a>
                <?php  } else { ?>
                <?php  echo $item['nickname'];?>
                <?php  } ?>

                <br/>
                <?php  echo $item['addressdata']['realname'];?><br/><?php  echo $item['addressdata']['mobile'];?></td>
            <td rowspan="<?php  echo count($item['goods'])?>" style='text-align:center;' class="paytype">

                <?php  if($item['statusvalue'] > 0) { ?>
                <!--<label class='label label-<?php  echo $item['css'];?>'><?php  echo $item['paytype'];?></label>-->
                <?php  } else if($item['statusvalue'] == 0) { ?>
                <?php  if($item['paytypevalue']!=3) { ?>
                <!--<label class='label label-default'>未支付</label>-->
                <?php  } else { ?>
                <!--<label class='label label-primary'>货到付款</label>-->
                <?php  } ?>
                <?php  } else if($item['statusvalue'] == -1) { ?>
                <!--<label class='label label-default'><?php  echo $item['paytype'];?></label>-->
                <?php  } ?>
                <?php  if($item['statusvalue'] > 0) { ?>
                <?php  if($item['paytypevalue']==1) { ?>
                <span> <i class="icow icow-yue text-warning" style="font-size: 17px;"></i><span>余额支付</span></span>
                <?php  } else if($item['paytypevalue']==11) { ?>
                <span> <i class="icow icow-kuajingzhifuiconfukuan text-danger" style="font-size: 17px"></i>后台付款</span>
                <?php  } else if($item['paytypevalue']==21) { ?>
                <span> <i class="icow icow-weixinzhifu text-success" style="font-size: 17px"></i>微信支付</span>
                <?php  } else if($item['paytypevalue']==22) { ?>
                <span><i class="icow icow-zhifubaozhifu text-primary" style="font-size: 17px"></i>支付宝支付</span>
                <?php  } ?>
                <?php  } else if($item['statusvalue'] == 0) { ?>
                <!-- 未支付 -->
                <?php  if($item['paytypevalue']!=3) { ?>
                <span>
                     <i class="icow icow-shibai text-danger"></i>未支付
                </span>
                <?php  } else { ?>
                <span> <i class="text-primary icow icow-icon" style="font-size: 17px"></i>货到付款</span>
                <?php  } ?>
                <?php  } else if($item['statusvalue'] == -1) { ?>
                <?php  if($item['paytypevalue']==1) { ?>
                <span> <i class="icow icow-yue text-warning" style="font-size: 17px;"></i><span>余额支付</span></span>
                <?php  } else if($item['paytypevalue']==11) { ?>
                <span> <i class="icow icow-kuajingzhifuiconfukuan text-danger" style="font-size: 17px"></i>后台付款</span>
                <?php  } else if($item['paytypevalue']==21) { ?>
                <span> <i class="icow icow-weixin text-success" style="font-size: 17px"></i>微信支付</span>
                <?php  } else if($item['paytypevalue']==22) { ?>
                <span><i class="icow icow-zhifubao text-primary" style="font-size: 17px"></i>支付宝支付</span>
                <?php  } ?>
                <?php  } ?>
                <br/>


                <span style='margin-top:5px;display:block;'><?php  echo $item['dispatchname'];?></span>

            </td>
            <td  rowspan="<?php  echo count($item['goods'])?>"  >
                <div style="width: 100%;height: 100%;cursor: pointer" data-toggle='popover' data-html='true' data-placement='right' data-trigger="hover"
                                                               data-content="<table style='width:100%;'>
                    <tr>
                        <td  style='border:none;text-align:right;'>商品小计：</td>
                        <td  style='border:none;text-align:right;;'>￥<?php  echo number_format( $item['goodsprice'] ,2)?></td>
                    </tr>
                    <tr>
                        <td  style='border:none;text-align:right;'>运费：</td>
                        <td  style='border:none;text-align:right;;'>￥<?php  echo number_format( $item['olddispatchprice'],2)?></td>
                    </tr>
                    <?php  if($item['discountprice']>0) { ?>
                    <tr>
                        <td  style='border:none;text-align:right;'>会员折扣：</td>
                        <td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['discountprice'],2)?></td>
                    </tr>
                    <?php  } ?>
                    <?php  if($item['deductprice']>0) { ?>
                    <tr>
                        <td  style='border:none;text-align:right;'>积分抵扣：</td>
                        <td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['deductprice'],2)?></td>
                    </tr>
                    <?php  } ?>
                    <?php  if($item['deductcredit2']>0) { ?>
                    <tr>
                        <td  style='border:none;text-align:right;'>余额抵扣：</td>
                        <td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['deductcredit2'],2)?></td>
                    </tr>
                    <?php  } ?>
                    <?php  if($item['deductenough']>0) { ?>
                    <tr>
                        <td  style='border:none;text-align:right;'>商城满额立减：</td>
                        <td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['deductenough'],2)?></td>
                    </tr>
                    <?php  } ?>
                    <?php  if($item['merchdeductenough']>0) { ?>
                    <tr>
                        <td  style='border:none;text-align:right;'>商户满额立减：</td>
                        <td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['merchdeductenough'],2)?></td>
                    </tr>
                    <?php  } ?>
                    <?php  if($item['couponprice']>0) { ?>
                    <tr>
                        <td  style='border:none;text-align:right;'>优惠券优惠：</td>
                        <td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['couponprice'],2)?></td>
                    </tr>
                    <?php  } ?>
                    <?php  if($item['isdiscountprice']>0) { ?>
                    <tr>
                        <td  style='border:none;text-align:right;'>促销优惠：</td>
                        <td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['isdiscountprice'],2)?></td>
                    </tr>
                    <?php  } ?>

                    <?php  if(intval($item['changeprice'])!=0) { ?>
                    <tr>
                        <td  style='border:none;text-align:right;'>卖家改价：</td>
                        <td  style='border:none;text-align:right;;'><span style='<?php  if(0<$item['changeprice']) { ?>color:green<?php  } else { ?>color:red<?php  } ?>'><?php  if(0<$item['changeprice']) { ?>+<?php  } else { ?>-<?php  } ?>￥<?php  echo number_format(abs($item['changeprice']),2)?></span></td>
                    </tr>
                    <?php  } ?>
                    <?php  if(intval($item['changedispatchprice'])!=0) { ?>
                    <tr>
                        <td  style='border:none;text-align:right;'>卖家改运费：</td>
                        <td  style='border:none;text-align:right;;'><span style='<?php  if(0<$item['changedispatchprice']) { ?>color:green<?php  } else { ?>color:red<?php  } ?>'><?php  if(0<$item['changedispatchprice']) { ?>+<?php  } else { ?>-<?php  } ?>￥<?php  echo abs($item['changedispatchprice'])?></span></td>
                    </tr>
                    <?php  } ?>
                    <tr>
                        <td style='border:none;text-align:right;'>应收款：</td>
                        <td  style=`'border:none;text-align:right;color:green;'>￥<?php  echo number_format($item['price'],2)?></td>
                    </tr>

                </table>
    "
                    > ￥<?php  echo number_format($item['price'],2)?> </div>
                <?php  if($item['dispatchprice']>0) { ?>
                <br/>(含运费:￥<?php  echo number_format( $item['dispatchprice'],2)?>)
                <?php  } ?>


            </td>

            <td  rowspan="<?php  echo count($item['goods'])?>" style='text-align:center' >
                <a class='op text-primary'  href="<?php  echo webUrl('order/detail', array('id' => $item['id']))?>" >查看详情</a><br/>
                <?php  if($item['addressid']!=0 && $item['statusvalue']>=2) { ?>
                <a class='op text-primary'  data-toggle="ajaxModal" href="<?php  echo webUrl('util/express', array('id' => $item['id'],'express'=>$item['express'],'expresssn'=>$item['expresssn']))?>"   >物流信息</a>
                <?php  } ?>
            </td>

            <td  rowspan="<?php  echo count($item['goods'])?>" style='text-align:center' >
                <?php if(cv('member.member.edit')) { ?>
                <a href="<?php  echo webUrl('member/list/detail',array('id'=>$item['m1']['id']))?>"> <?php  echo $item['m1']['nickname'];?></a>
                <?php  } else { ?>
                <?php  echo $item['m1']['nickname'];?>
                <?php  } ?>

                <br/>
                <?php  echo $item['m1']['realname'];?><br/><?php  echo $item['m1']['mobile'];?></td>
            </td>

            <td   rowspan="<?php  echo count($item['goods'])?>" class='ops' style='line-height:20px;text-align:center' ><span class='text-<?php  echo $item['statuscss'];?>'><?php  echo $item['status'];?></span><br />
            </td>

            <?php  } ?>
        </tr>
        <?php  } } ?>












        <?php  if(!empty($item['remark'])) { ?>
        <tr ><td colspan='9' style='background:#fdeeee;color:red;'>买家备注: <?php  echo $item['remark'];?></td></tr>
        <?php  } ?>

        <?php  if(!empty($level) || (!empty($item['merchname']) && $item['merchid'] > 0)) { ?>
        <tr style=";border-bottom:none;background:#f9f9f9;">
            <td colspan='4' style='text-align:left'>
                <?php  if(!empty($item['merchname']) && $item['merchid'] > 0) { ?>
                商户名称:<span class="text-info"><?php  echo $item['merchname'];?></span>
                <?php  } ?>

            </td>
            <td colspan='5' style='text-align:right'>
                <?php  if(!empty($item['agentid'])) { ?>
                <?php  if($item['commission1']!=-1) { ?><b>1级佣金:</b> <?php  echo $item['commission1'];?> 元 <?php  } ?>
                <?php  if($item['commission2']!=-1) { ?><b>2级佣金:</b> <?php  echo $item['commission2'];?> 元 <?php  } ?>
                <?php  if($item['commission3']!=-1) { ?><b>3级佣金:</b> <?php  echo $item['commission3'];?> 元 <?php  } ?>
                <?php  } ?>

                <?php  if(!empty($item['agentid']) && !$is_merch[$item['id']]) { ?>
                <?php if(cv('commission.apply.changecommission')) { ?>
                <!--a data-toggle="ajaxModal"  href="<?php  echo webUrl('commission/apply/changecommission', array('id' => $item['id']))?>">修改佣金</a-->
                <?php  } ?>
                <?php  } ?>
            </td></tr>
        <?php  } ?>
        <?php  } } ?>
    </table>
    <div style="text-align:right;width:100%;">
        <?php  echo $pager;?>
    </div>
    <?php  } else { ?>

    <div class='panel panel-default'>
        <div class='panel-body' style='text-align: center;padding:30px;'>
            暂时没有任何订单!
        </div>
    </div>
    <?php  } ?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
