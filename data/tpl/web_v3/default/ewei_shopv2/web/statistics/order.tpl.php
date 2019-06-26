<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<style>

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

    .popover-content table{

        margin-bottom: 0;

        width:145px;

    }

    .popover-content table tr td, .popover-content table tr th{

        padding: 0;

        height:20px;

        border:none;

    }

</style>

<div class="page-header"> 当前位置：<span class="text-primary">订单统计</span></div>

<div class="page-content">

    <form action="./index.php" method="get" class="form-horizontal"  id="form1">

        <input type="hidden" name="c" value="site" />

        <input type="hidden" name="a" value="entry" />

        <input type="hidden" name="m" value="ewei_shopv2" />

        <input type="hidden" name="do" value="web" />

        <input type="hidden" name="r"  value="statistics.order" />

        <div class="page-toolbar">

            <div class="col-sm-5">

                <?php  echo tpl_daterange('datetime', array('sm'=>true,'placeholder'=>'下单时间'),true);?>

            </div>

            <div class="col-sm-6 pull-right">

                <div class="input-group">

                    <div class="input-group-select">

                        <select name='searchfield'  class='form-control'   style="width:120px;">

                            <option value='ordersn' <?php  if($_GPC['searchfield']=='ordersn') { ?>selected<?php  } ?>>订单号</option>

                            <option value='member' <?php  if($_GPC['searchfield']=='member') { ?>selected<?php  } ?>>会员信息</option>

                            <option value='address' <?php  if($_GPC['searchfield']=='address') { ?>selected<?php  } ?>>收件人信息</option>

                        </select>

                    </div>

                    <input type="text" class="form-control"  name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词"/>

                    <span class="input-group-btn">

                        <button class="btn btn-primary " type="submit"> 搜索</button>

       <?php if(cv('statistics.order.export')) { ?>

                        <button type="submit" name="export" value="1" class="btn btn-success ">导出</button>

                        <?php  } ?>

                    </span>

                </div>



            </div>

        </div>

    </form>



    <?php  if(empty($list)) { ?>

    <div class="panel panel-default">

        <div class="panel-body empty-data">未查询到相关数据</div>

    </div>

    <?php  } else { ?>

    <table class="table">

        <tr  style='background:#f8f8f8'>

            <!--<th style="width:220px">订单号</th>-->

            <!--<th>总金额</th>-->



            <!--<th>付款方式</th>-->

            <!--<th>会员名称</th>-->

            <!--<th>收货人</th>-->

            <!--<th style="width:160px">下单时间</th>-->

            <td style='width:60px;border-left:1px solid #f2f2f2;'>商品</td>

            <td style='width:150px;'></td>

            <td style='width:70px;text-align: right;'>单价/数量</td>

            <td  style='width:100px;text-align: center;'>会员名称</td>

            <td style='width:90px;text-align: center;'>支付/配送</td>

            <td style='width:100px;text-align: center;'>价格</td>

            <td style='width:100px;text-align: center;'>收货人</td>

        </tr>

        <tbody>



        <?php  if(is_array($list)) { foreach($list as $row) { ?>

        <tr ><td colspan='7' style='height:20px;padding:0;border-top:none;'>&nbsp;</td></tr>

        <tr class='trorder'>

            <td colspan='7' >

                <span style="font-weight: bold;"><?php  echo date('Y-m-d H:i',$row['createtime'])?></span>

                订单编号:<?php  echo $row['ordersn'];?>

            </td>

            </td>

        </tr>

        <?php  if(is_array($row['goods'])) { foreach($row['goods'] as $g) { ?>

        <tr class="trbody" style="border: 1px solid #efefef;">

            <td><img src="<?php  echo tomedia($g['thumb'])?>" style="width: 50px; height: 50px;border:1px solid #ccc;padding:1px;"  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" ></td>

            <td style="text-align: left;border-left:none;"><?php  echo $g['title'];?></td>

            <td style='text-align:right;border-left:none;'><?php  echo $g['realprice']?><br/>x <?php  echo $g['total'];?></td>

            <td><?php  echo $row['realname'];?></td>

            <td><?php  if($row['paytype'] == 1) { ?>

                <span> <i class="icow icow-yue text-warning" style="font-size: 17px;"></i><span>余额支付</span></span>

                <?php  } else if($row['paytype'] == 11) { ?>

                <span> <i class="icow icow-kuajingzhifuiconfukuan text-danger" style="font-size: 17px"></i>后台付款</span>

                <?php  } else if($row['paytype'] == 2) { ?>

                <span> <i class="icow icow-zaixianzhifu text-info" style="font-size: 17px"></i>在线支付</span>

                <?php  } else if($row['paytype'] == 21) { ?>

                <span> <i class="icow icow-weixinzhifu text-success" style="font-size: 17px"></i>微信支付</span>

                <?php  } else if($row['paytype'] == 22) { ?>

                <span><i class="icow icow-zhifubaozhifu text-primary" style="font-size: 17px"></i>支付宝支付</span>

                <?php  } else if($row['paytype'] == 23) { ?>

                <span class="label label-primary">银联支付</span>

                <?php  } else if($row['paytype'] == 3) { ?>

                <span> <i class="text-primary icow icow-icon" style="font-size: 17px"></i>货到付款</span>

                <?php  } ?>

            </td>

            <td> <a  data-toggle='popover' data-placement='bottom' data-html='true' data-trigger='hover' style="width: 100%;height: 100;cursor: pointer;"

                                           data-content="<table class='table table-hover'>



                        <tr><th>总金额</th><td><?php  echo $row['price'];?></td></tr>

                        <tr><th>商品小计</th><td><?php  echo $row['goodsprice'];?></td></tr>

                        <tr><th>运费</th><td><?php  echo $row['dispatchprice'];?></td></tr>

                        <tr><th>会员折扣</th><td><?php  if($row['discountprice']>0) { ?>-<?php  echo $row['discountprice'];?><?php  } ?></td></tr>

                        <tr><th>积分抵扣</th><td><?php  if($row['deductprice']>0) { ?>-<?php  echo $row['deductprice'];?><?php  } ?></td></tr>

                        <tr><th>余额抵扣</th><td><?php  if($row['deductcredit2']>0) { ?>-<?php  echo $row['deductcredit2'];?><?php  } ?></td></tr>

                        <tr><th>满额立减</th><td><?php  if($row['deductenough']>0) { ?>-<?php  echo $row['deductenough'];?><?php  } ?></td></tr>

                        <tr><th>优惠券优惠</th><td><?php  if($row['couponprice']>0) { ?>-<?php  echo $row['couponprice'];?><?php  } ?></td></tr>

                        <tr><th>卖家改价</th><td><?php  if(0<$item['changeprice']) { ?>+<?php  } else { ?>-<?php  } ?><?php  echo number_format(abs($item['changeprice']),2)?></td></tr>

                        <tr><th>卖家改运费</th><td><?php  if(0<$item['changedipatchpriceprice']) { ?>+<?php  } else { ?>-<?php  } ?><?php  echo number_format(abs($item['changedipatchpriceprice']),2)?></td></tr>

                        </table>"><?php  echo $row['price'];?></a></td>

            <td><?php  echo $row['addressname'];?></td>

        </tr>

        <?php  } } ?>

        <?php  } } ?>

        </tbody>

        <tfoot>

            <tr>

                <td colspan="7" style="text-align: right">

                    <?php  echo $pager;?>

                </td>

            </tr>

        </tfoot>

    </table>

    <?php  } ?>

</div>





<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--NDAwMDA5NzgyNw==-->