<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<style type='text/css'>

    .trhead td {  background:#efefef;text-align: center}

    .trbody td {  text-align: center; vertical-align:top;border-left:1px solid #f2f2f2;overflow: hidden; font-size:12px;}

    .trorder { background:#f8f8f8;border:1px solid #f2f2f2;text-align:left;}

    .ops { border-right:1px solid #f2f2f2; text-align: center;}

    .ops a,.ops span{

        margin: 3px 0;

    }

    .table-top .op:hover{

        color: #000;

    }

    .tables{

        border:1px solid #e5e5e5;

        font-size: 12px;

        line-height: 18px;

    }

    .tables:hover{

        border:1px solid #b1d8f5;

    }

    .table-row,.table-header,.table-footer,.table-top{

        display: -webkit-box;

        display: -webkit-flex;

        display: -ms-flexbox;

        display: flex;

        justify-content: center;

        -webkit-justify-content: center;

        -webkit-align-content: space-around;

        align-content: space-around;

    }

    .tables  .table-row>div{

        padding: 14px 0 !important;

    }

    .tables  .table-row.table-top>div{

        padding: 11px 0;

    }

    .tables    .table-row .ops.list-inner{

        border-right:none;

    }

    .tables .list-inner{

       border-right: 1px solid #efefef;

        vertical-align: middle;

    }

    .table-row .goods-des .title{

        width:180px;

        overflow: hidden;

        text-overflow: ellipsis;

        white-space: nowrap;

    }

    .table-row .goods-des{

        width:300px;

        border-right: 1px solid #efefef;

        vertical-align: middle;

    }

    .table-row .list-inner{

        -webkit-box-flex: 1;

        -webkit-flex: 1;

        -ms-flex: 1;

        flex: 1;

        text-align: center;

        display: -webkit-box;

        display: -webkit-flex;

        display: -ms-flexbox;

        display: flex;

        -webkit-align-items: center;

        align-items: center;

        -webkit-justify-content: center;

        justify-content: center;

        -webkit-flex-direction: column;

        flex-direction: column;

    }

    .saler>div{

        width:130px;

        overflow: hidden;

        text-overflow: ellipsis;

        white-space: nowrap;

    }

    .table-row .list-inner.ops,  .table-row .list-inner.paystyle{

        -webkit-flex-direction: column;

        flex-direction: column;

       -webkit-justify-content: center;

       justify-content: center;

    }

    .table-header .others{

        -webkit-box-flex: 1;

        -webkit-flex: 1;

        -ms-flex: 1;

        flex: 1;

        text-align: center;

    }

    .table-footer{

        border-top: 1px solid #efefef;

    }

    .table-footer>div, .table-top>div{

        -webkit-box-flex: 1;

        -webkit-flex: 1;

        -ms-flex: 1;

        flex: 1;

        height:100%;

    }

    .fixed-header div{

        padding:0;

    }

    .fixed-header.table-header{

        display: none;

    }

    .fixed-header.table-header.active{

        display: -webkit-box;

        display: -webkit-flex;

        display: -ms-flexbox;

        display: flex;

    }

    .shop{

        display: inline-block;

        width:48px;

        height:18px;

        text-align: center;

        border:1px solid #1b86ff;

        color: #1b86ff;

        margin-right: 10px;

    }

    .min_program{

        display: inline-block;

        width:48px;

        height:18px;

        text-align: center;

        border:1px solid #ff5555;

        color: #ff5555;

        margin-right: 10px;

    }

</style>

<div class="page-header">

    当前位置：<span class="text-primary">订单管理</span>
    <span>
    订单数:  <span class='text-danger'><?php  echo $total;?></span> 
    订单金额:  <span class='text-danger'><?php  echo $totalmoney;?></span> 
    <?php  if(!empty($magent['nickname'])) { ?>
      订单推广人:  <span class='text-danger'><?php  echo $magent['nickname'];?></span>
    <?php  } ?>
    </span>

</div>

<div class="page-content">

    <div class="fixed-header table-header" style="padding: 0 50px;">

        <div style='border-left:1px solid #f2f2f2;width: 400px;text-align: left;'>商品</div>

        <div class="others">买家</div>

        <div class="others">支付/配送</div>

        <div class="others">价格</div>

        <div class="others">操作</div>

        <div class="others">状态</div>

    </div>

    <form action="./index.php" method="get" class="form-horizontal table-search" role="form"  id="search">

        <input type="hidden" name="c" value="site" />

        <input type="hidden" name="a" value="entry" />

        <input type="hidden" name="m" value="ewei_shopv2" />

        <input type="hidden" name="do" value="web" />

        <input type="hidden" name="r" value="order.list<?php  echo $st;?>" />

        <input type="hidden" name="status" value="<?php  echo $status;?>" />

        <input type="hidden" name="agentid" value="<?php  echo $_GPC['agentid'];?>" />

        <input type="hidden" name="refund" value="<?php  echo $_GPC['refund'];?>" />

        <div class="page-toolbar">

            <div class="input-group">
            
                <span class="input-group-btn"> 

                   <button type="button" id="all" class="btn btn-success"> 全选/反选 </button>
                   <button type="button" id="print" class="btn btn-primary"> 批量打印 </button>
                   <button type="button" id="print_tag" class="btn btn-primary"> 打印标签 </button>
                   <button type="button" id="combine_order" class="btn btn-primary"> 合并订单 </button>
                   
                </span>
                
                <span class="input-group-select">

                    <select name="paytype" class="form-control" style="width:100px;padding:0 5px;">

                        <option value="" <?php  if($_GPC['paytype']=='') { ?>selected<?php  } ?>>支付方式</option>

                        <?php  if(is_array($paytype)) { foreach($paytype as $key => $type) { ?>

                        <option value="<?php  echo $key;?>" <?php  if($_GPC['paytype'] == "$key") { ?> selected="selected" <?php  } ?>><?php  echo $type['name'];?></option>

                        <?php  } } ?>

                    </select>

                </span>

                <span class="input-group-select">

                    <select name='searchtime'  class='form-control'   style="width:100px;padding:0 5px;"  id="searchtime">

                        <option value=''>不按时间</option>

                        <option value='create' <?php  if($_GPC['searchtime']=='create') { ?>selected<?php  } ?>>下单时间</option>

                        <option value='pay' <?php  if($_GPC['searchtime']=='pay') { ?>selected<?php  } ?>>付款时间</option>

                        <option value='send' <?php  if($_GPC['searchtime']=='send') { ?>selected<?php  } ?>>发货时间</option>

                        <option value='finish' <?php  if($_GPC['searchtime']=='finish') { ?>selected<?php  } ?>>完成时间</option>

                    </select>

                </span>

                <span class="input-group-btn">

                    <?php  echo tpl_form_field_daterange('time',array('starttime'=>date('Y-m-d H:i', $starttime),'endtime'=>date('Y-m-d H:i', $endtime)),true);?>

                </span>

                <span class="input-group-select">

                    <select name='searchfield'  class='form-control'   style="width:110px;padding:0 5px;"  >

                        <option value='ordersn' <?php  if($_GPC['searchfield']=='ordersn') { ?>selected<?php  } ?>>订单号</option>

                        <option value='member' <?php  if($_GPC['searchfield']=='member') { ?>selected<?php  } ?>>会员信息</option>

                        <option value='address' <?php  if($_GPC['searchfield']=='address') { ?>selected<?php  } ?>>收件人信息</option>

                        <option value='location' <?php  if($_GPC['searchfield']=='location') { ?>selected<?php  } ?>>地址信息</option>

                        <option value='expresssn' <?php  if($_GPC['searchfield']=='expresssn') { ?>selected<?php  } ?>>快递单号</option>

                        <option value='goodstitle' <?php  if($_GPC['searchfield']=='goodstitle') { ?>selected<?php  } ?>>商品名称</option>

                        <option value='goodssn' <?php  if($_GPC['searchfield']=='goodssn') { ?>selected<?php  } ?>>商品编码</option>

                        <option value='saler' <?php  if($_GPC['searchfield']=='saler') { ?>selected<?php  } ?>>核销员</option>

                        <option value='store' <?php  if($_GPC['searchfield']=='store') { ?>selected<?php  } ?>>核销门店</option>

                        <option value='selfget' <?php  if($_GPC['searchfield']=='selfget') { ?>selected<?php  } ?>>自提门店</option>

                        <?php  if($merch_plugin) { ?>

                        <option value='merch' <?php  if($_GPC['searchfield']=='merch') { ?>selected<?php  } ?>>商户名称</option>

                        <?php  } ?>

                    </select>

                </span>

                <input type="text" class="form-control input-sm"  name="keyword" id="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词"/>

                <input type="hidden" name="export" id="export" value="0">

                <span class="input-group-btn">

                    <button type="button" data-export="0" class="btn btn-primary btn-submit"> 搜索</button>
                    
                    <button type="button" data-export="1" class="btn btn-success btn-submit">导出</button>

                </span>

            </div>

        </div>

    </form>

    <?php  if(count($list)>0) { ?>

    <div class="row">

        <div class="col-md-12">

            <div  class="">

                <div class="table-header" style='background:#f8f8f8;height: 35px;line-height: 35px;padding: 0 20px'>

                    <div style='border-left:1px solid #f2f2f2;width: 400px;text-align:left;'>商品</div>

                    <div class="others">买家</div>

                    <div class="others">支付/配送</div>

                    <div class="others">价格</div>

                    <div class="others">操作</div>

                    <div class="others">状态</div>

                </div>

            <?php  if(is_array($list)) { foreach($list as $item) { ?>

            <div class="table-row"><div style='height:20px;padding:0;border-top:none;'>&nbsp;</div></div>

                <div class="tables">

                    <div class='table-row table-top' style="padding:0  20px;background: #f7f7f7">

                        <div style="text-align: left;color: #8f8e8e;">

                            <span style="font-weight: bold;margin-right: 10px;color: #2d2d31">

                                <?php  if($item['iswxappcreate']==0) { ?><span class="shop">商城</span><?php  } else { ?><span class="min_program">小程序</span><?php  } ?><?php  if($item['is_cashier'] == 1) { ?><span class="shop">收银台</span><?php  } ?><?php  echo date('Y-m-d',$item['createtime'])?>&nbsp <?php  echo date('H:i:s',$item['createtime'])?>

                            </span>

                            订单编号:  <?php  echo $item['ordersn'];?><?php  if($item['ispackage']) { ?>&nbsp;<span class="label label-success">套餐</span><?php  } ?>

                            <?php  if(!empty($item['refundstate'])) { ?><label class='label label-danger'><?php  echo $r_type[$item['rtype']];?>申请</label><?php  } ?>

                            <?php  if(!empty($item['refundstate']) && $item['rstatus'] == 4) { ?><label class='label label-default'>客户退回物品</label><?php  } ?>

                        </div>

                        <div style='text-align:right;font-size:12px;' class='aops'>

                            <?php  if($item['merchid'] == 0) { ?>

                                <?php if(cv('order.op.remarksaler')) { ?>

                                <a class='op'  data-toggle="ajaxModal" href="<?php  echo webUrl('order/op/remarksaler', array('id' => $item['id']))?>" >

                                    <?php  if(!empty($item['remarksaler'])) { ?>

                                    <i class="icow icow-flag-o" style="color: #df5254;display: inline-block;vertical-align: middle" title="  查看备注"></i>

                                    备注

                                    &nbsp

                                    <?php  } else { ?>

                                    <i class="icow icow-yibiaoji" style="color: #999;display: inline-block;vertical-align: middle" title="  添加备注" ></i>

                                    备注

                                    &nbsp

                                    <?php  } ?>

                                </a>

                                <?php  } ?>

                            <?php  } ?>

                            <?php  if($item['merchid'] == 0) { ?>

                                <?php  if(($item['statusvalue']>=2 || $item['sendtype']>0) && !empty($item['addressid']) && $item['statusvalue']!=3 &&$item['city_express_state']==0) { ?>

                                    <?php if(cv('order.op.send')) { ?>

                                    <a class="op" data-toggle="ajaxModal"  href="<?php  echo webUrl('order/op/changeexpress', array('id' => $item['id']))?>">

                                        <i class="icow icow-wuliu" title="修改物流" style="color: #999;display: inline-block;vertical-align: middle"></i>

                                        修改物流

                                        &nbsp

                                    </a>

                                    <?php  } ?>

                                <?php  } ?>

                            <?php  } ?>

                            <?php  if($item['merchid'] == 0) { ?>

                                <?php  if(empty($item['statusvalue'])) { ?>

                                    <?php if(cv('order.op.changeprice')) { ?>

                                        <?php  if($item['ispackage'] ==0) { ?>

                                        <a class='op'  data-toggle='ajaxModal' href="<?php  echo webUrl('order/op/changeprice',array('id'=>$item['id']))?>">
                                        
                                            <i class="icow icow-gaijia" title="订单改价"  style="color: #999;display: inline-block;vertical-align: middle"></i>

                                            订单改价

                                            &nbsp

                                        </a>

                                        <?php  } ?>

                                    <?php  } ?>

                            <?php  if($item['ismerch'] == 0) { ?>

                                <?php if(cv('order.op.close')) { ?>

                                <a class='op'  data-toggle='ajaxModal' href="<?php  echo webUrl('order/op/close',array('id'=>$item['id']))?>" >

                                    <i class="icow icow-shutDown" title="关闭订单"  style="color: #999;margin-right: 3px;display: inline-block;vertical-align: middle"></i>

                                    关闭订单

                                    &nbsp

                                </a>

                                <?php  } ?>

                            <?php  } ?>

                            <?php  } ?>

                            <?php  } ?>

                            <!--<a class='op'   href="<?php  echo webUrl('order', array('op' => 'detail', 'id' => $item['id']))?>" >标记</a>-->

                        </div>

                    </div>

                    <div class='table-row' style="margin:0  20px">

                        <div class="goods-des" style='width:400px;text-align: left'>

                            <?php  if(is_array($item['goods'])) { foreach($item['goods'] as $k => $g) { ?>

                            <div style="display: -webkit-box;display: -webkit-flex;display: -ms-flexbox;display: flex;margin: 10px 0">
                                <div style="padding:22px 5px 0 0;">
                                   <input type="checkbox" name="id" value="<?php  echo $item['id']?>" />
                                </div>
                            
                                <img src="<?php  echo tomedia($g['thumb'])?>" style='width:70px;height:70px;border:1px solid #efefef; padding:1px;'onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'">

                                <div style="-webkit-box-flex: 1;-webkit-flex: 1;-ms-flex: 1;flex: 1;margin-left: 5px;text-align: left;display: flex;align-items: center">

                                    <div >

                                       <div class="title">

                                           <?php  if($g['ispresell']==1) { ?>

                                           <label class="fui-tag fui-tag-danger">预</label>

                                           <?php  } ?>

                                           <?php  echo $g['title'];?><br/>

                                           <span style="color: #999"> <?php  if(!empty($g['optiontitle'])) { ?><?php  echo $g['optiontitle'];?><?php  } ?><?php  echo $g['goodssn'];?></span>

                                       </div>

                                            <?php  if($g['seckill_task']) { ?>

                                        <div>

                                                <span class="label label-danger"><?php  echo $g['seckill_task']['tag'];?></span>

                                                <?php  if($g['seckill_room']) { ?>

                                                    <span class="label label-primary">

                                                        <?php echo $g['seckill_room']['tag']?:$g['seckill_room']['title']?>

                                                    </span>

                                                <?php  } ?>

                                        </div>

                                           <?php  } ?>

                                    </div>

                                    <span style="float: right;text-align: right;display: inline-block;width:100px;">

                                        ￥<?php  echo number_format($g['realprice']/$g['total'],2)?><br/>

                                    x<?php  echo $g['total'];?>

                                    </span>

                                </div>

                            </div>

                            <?php  } } ?>

                        </div>

                        <div class="list-inner saler"   style='text-align: center;' >

                            <div>

                                <?php if(cv('member.list.edit')) { ?>

                                <a href="<?php  echo webUrl('member/list/detail',array('id'=>$item['mid']))?>"> <?php  echo $item['nickname'];?></a>

                                <?php  } else { ?>

                                <?php  echo $item['nickname'];?>

                                <?php  } ?>

                                <br/>

                                <?php  echo $item['addressdata']['realname'];?><br/><?php  echo $item['addressdata']['mobile'];?>

                            </div>

                        </div>

                        <div class="list-inner paystyle"  style='text-align:center;' >

                            <!-- 已支付 -->

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

                                    <label class='label label-default'>未支付</label>

                                <?php  } else { ?>

                                       <span> <i class="text-primary icow icow-icon" style="font-size: 17px"></i>货到付款</span>

                                <?php  } ?>

                            <?php  } else if($item['statusvalue'] == -1) { ?>

                                <?php  if($item['paytypevalue']==1) { ?>

                                <span> <i class="icow icow-yue text-warning" style="font-size: 17px;display:inline-block;height: 17px;width: 17px;padding-top: 3px"></i><span>余额支付</span></span>

                                <?php  } else if($item['paytypevalue']==11) { ?>

                                <span> <i class="icow icow-kuajingzhifuiconfukuan text-danger" style="font-size: 17px"></i>后台付款</span>

                                <?php  } else if($item['paytypevalue']==21) { ?>

                                <span> <i class="icow icow-weixin text-success" style="font-size: 17px"></i>微信支付</span>

                                <?php  } else if($item['paytypevalue']==22) { ?>

                                <span><i class="icow icow-zhifubao text-primary" style="font-size: 17px"></i>支付宝支付</span>

                                <?php  } ?>

                            <?php  } ?>


                            <?php  if($item['paytypevalue'] == 3 && $item['is_cashier'] == 1) { ?>

                                <span style='margin-top:5px;display:block;'>收银台现金收款</span>

                            <?php  } else { ?>

                                <span style='margin-top:5px;display:block;'><?php  echo $item['dispatchname'];?></span>

                            <?php  } ?>

                        </div>

                            <a  class="list-inner" data-toggle='popover' data-html='true' data-placement='right' data-trigger="hover"  data-content="<table style='width:100%;'>

                                    <tr>

                                        <td  style='border:none;text-align:right;'>商品小计：</td>

                                        <td  style='border:none;text-align:right;;'>￥<?php  echo number_format( $item['goodsprice'] ,2)?></td>

                                    </tr>

                                    <tr>

                                        <td  style='border:none;text-align:right;'>运费：</td>

                                        <td  style='border:none;text-align:right;;'>￥<?php  echo number_format( $item['olddispatchprice'],2)?></td>

                                    </tr>

                                    <?php  if($item['taskdiscountprice']>0) { ?>

                                    <tr>

                                        <td  style='border:none;text-align:right;'>任务活动优惠：</td>

                                        <td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['taskdiscountprice'],2)?></td>

                                    </tr>

                                    <?php  } ?>

                                    <?php  if($item['lotterydiscountprice']>0) { ?>

                                    <tr>

                                        <td  style='border:none;text-align:right;'>游戏活动优惠：</td>

                                        <td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['lotterydiscountprice'],2)?></td>

                                    </tr>

                                    <?php  } ?>

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

                                    <?php  if($item['buyagainprice']>0) { ?>

                                    <tr>

                                        <td  style='border:none;text-align:right;'>重复购买优惠：</td>

                                        <td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['buyagainprice'],2)?></td>

                                    </tr>

                                    <?php  } ?>

                                      <?php  if($item['seckilldiscountprice']>0) { ?>

                                    <tr>

                                        <td  style='border:none;text-align:right;'>秒杀优惠：</td>

                                        <td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['seckilldiscountprice'],2)?></td>

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

                                </table>"> 

                                <div style='text-align:center'>

                                    ￥<?php  echo number_format($item['price'],2)?>

                                    <?php  if($item['dispatchprice']>0) { ?>

                                    <br/>(含运费:￥<?php  echo number_format( $item['dispatchprice'],2)?>)

                                    <?php  } ?>

                                </div>

                          </a>

                        <div  class="list-inner" style='text-align:center'>

                            <a class='op text-primary'  href="<?php  echo webUrl('order/detail', array('id' => $item['id']))?>" >查看详情</a>

                            <?php if(cv('order.op.refund')) { ?>

                            <?php  if(!empty($item['refundid'])) { ?>

                            <a class='op  text-primary'  href="<?php  echo webUrl('order/op/refund', array('id' => $item['id']))?>" >维权<?php  if($item['refundstate']>0) { ?>处理<?php  } else { ?>详情<?php  } ?></a>

                            <?php  } ?>

                            <?php  } ?>

                            <?php  if($item['addressid']!=0 && $item['statusvalue']>=2 && $item['sendtype']==0 && $item['city_express_state']==0) { ?>

                            <a class='op  text-primary'  data-toggle="ajaxModal" href="<?php  echo webUrl('util/express', array('id' => $item['id'],'express'=>$item['express'],'expresssn'=>$item['expresssn']))?>">物流信息</a>

                            <?php  } ?>

                            <?php  if($item['city_express_state']==1) { ?>

                                <a class='op  text-primary' href="javascript:tip.msgbox.err('同城配送暂不支持物流信息查询');">物流信息</a>

                            <?php  } ?>

                            <?php  if($item['invoicename'] && $item['status_id']>0 ) { ?>

                                <?php  $invoice_info = m('sale')->parseInvoiceInfo($item['invoicename']);?>

                                <?php  if($invoice_info['title'] && $invoice_info['entity'] === false) { ?>

                                <a class='<?php  if($item['invoice_img']) { ?>text-success<?php  } else { ?>text-danger<?php  } ?>' data-toggle="ajaxModal"

                                href="<?php  echo webUrl('order.op.upload_invoice',array('order_id'=>$item['id']));?>">

                                <?php  if($item['invoice_img']) { ?>查看发票<?php  } else { ?>上传发票<?php  } ?></a>

                                <?php  } ?>

                            <?php  } ?>

                        </div>

                        <div  class='ops list-inner' style='line-height:20px;text-align:center' >

                            <span class='text-<?php  echo $item['statuscss'];?>'><?php  echo $item['status'];?></span>

                            <?php  if($item['merchid'] == 0) { ?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('order/ops', TEMPLATE_INCLUDEPATH)) : (include template('order/ops', TEMPLATE_INCLUDEPATH));?><?php  } ?>

                        </div>
                    </div>

            <?php  if(!empty($item['remark'])) { ?>

            <div class="table-row"><div  style='background:#fdeeee;color:red;flex: 1;;'>买家备注: <?php  echo $item['remark'];?></div></div>

            <?php  } ?>

            <?php  if((!empty($level)&&!empty($item['agentid'])) || (!empty($item['merchname']) && $item['merchid'] > 0)) { ?>

            <div class="table-footer table-row" style="margin:0 20px">

                <div  style='text-align:left'>

                    <?php  if(!empty($item['merchname']) && $item['merchid'] > 0) { ?>

                    商户名称：<span class="text-info"><?php  echo $item['merchname'];?></span>

                    <?php  } ?>

                    <?php  if(!empty($agentid)) { ?>

                    <b>分销订单级别:</b> <?php  echo $item['level'];?>级 <b>分销佣金:</b> <?php  echo $item['commission'];?> 元

                    <?php  } ?>

                </div>

                <div  style='text-align:right'>

                    <?php  if(empty($agentid)) { ?>

                    <?php  if($item['commission1']!=-1) { ?><b>1级佣金:</b> <?php  echo $item['commission1'];?> 元 <?php  } ?>

                    <?php  if($item['commission2']!=-1) { ?><b>2级佣金:</b> <?php  echo $item['commission2'];?> 元 <?php  } ?>

                    <?php  if($item['commission3']!=-1) { ?><b>3级佣金:</b> <?php  echo $item['commission3'];?> 元 <?php  } ?>

                    <?php  } ?>

                    <?php  if(!empty($item['agentid']) && !$is_merch[$item['id']]) { ?>

                    <?php if(cv('commission.apply.changecommission')) { ?>

                    <a class="text-primary" data-toggle="ajaxModal"  href="<?php  echo webUrl('commission/apply/changecommission', array('id' => $item['id']))?>">修改佣金</a>

                    <?php  } ?>

                    <?php  } ?>

                </div>

            </div>

            <?php  } ?>

            </div>

            <?php  } } ?>

                <div style="padding: 20px;text-align: right" >

                        <?php  echo $pager;?>

                </div>

            </div>

        </div>

    </div>

    <?php  } else { ?>

    <div class="panel panel-default">

        <div class="panel-body empty-data">暂时没有任何订单!</div>

    </div>

    <?php  } ?>

</div>

<script>
 //全选反选
    window.onload=function(){
        var ids=document.getElementsByName("id");
        // 全选/反选
        var btn2=document.getElementById("all");
        btn2.onclick=function(){
            for(var i=0; i<ids.length; i++){
            ids[i].checked = !ids[i].checked;
            }
        }
        //取出所选值
        var btn3=document.getElementById("print");
        btn3.onclick=function(){
            var idstr="";
            for(var i=0; i<ids.length; i++){
                if( ids[i].checked ){
                 idstr +=ids[i].value+","
                }
            }

            if(idstr==""){
                tip.msgbox.suc('请选择要打印的订单!');
                return false;
            }

            // var idarr = new Array();
            // check.each(function(i){ idarr[i] = $(this).val(); });
            window.open("./index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=order.printer&idstr="+idstr);
        }
        //打印标签
        var btn4=document.getElementById("print_tag");
        btn4.onclick=function(){
            var idstr="";
            for(var i=0; i<ids.length; i++){
                if( ids[i].checked ){
                 idstr +=ids[i].value+","
                }
            }

            if(idstr==""){
                tip.msgbox.suc('请选择要打印的标签!');
                return false;
            }

            // var idarr = new Array();
            // check.each(function(i){ idarr[i] = $(this).val(); });
            window.open("./index.php?c=site&a=entry&m=ewei_shopv2&do=web&r=order.printer.print_tag&idstr="+idstr);

        }

        //订单合并
        var btn5=document.getElementById("combine_order");
        btn5.onclick=function(){
            var start = $("input[name='time[start]']").val();
            var end = $("input[name='time[end]']").val();
            if(start==null || !start)
            {
                tip.msgbox.err("选择订单合并开始时间");
                return false;
            }
            if(end==null || !end)
            {
                tip.msgbox.err("选择订单合并结束时间");
                return false;
            }

            var idstr="";
            for(var i=0; i<ids.length; i++){
                if( ids[i].checked ){
                 idstr +=ids[i].value+","
                }
            }

            // if(idstr==""){
            //     tip.msgbox.suc('请选择要合并的订单!');
            //     return false;
            // }
            
            $.ajax({

                type: "GET",

                url: "<?php  echo webUrl('order/combine_order')?>",
                
                data: {idstr:idstr,start:start,end:end},
                
                dataType: "json",

                success: function (data) { 
                   
                    if(data.status==0){
                       tip.msgbox.err(data.result.message);
                    }else{
                       tip.msgbox.suc(data.result.message);

                    }
                    
                    setTimeout(function () {                        
                        location.reload();                    
                    },1000);

                }

            });

        }
    }

    //没有选中时间段不能导出

    $(function () {

        $('.btn-submit').click(function () {

            var e = $(this).data('export');

            if(e==1 ){

                if($('#keyword').val() !='' ){

                    $('#export').val(1);

                    $('#search').submit();

                }else if($('#searchtime').val()!=''){

                    $('#export').val(1);

                    $('#search').submit();

                }else{

                    tip.msgbox.err('请选择按时间导出!');

                    return;
                }

            }else{

                $('#export').val(0);

                $('#search').submit();

            }

        })

    });
   
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

