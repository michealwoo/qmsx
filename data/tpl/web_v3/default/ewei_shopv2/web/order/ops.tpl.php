<?php defined('IN_IA') or exit('Access Denied');?>
<?php  if(empty($item['statusvalue'])) { ?>
<!--未付款-->

<?php if(cv('order.op.pay')) { ?>
<?php  if($item['paytypevalue']==3) { ?>
<a class="btn btn-primary btn-xs" data-toggle="ajaxModal"  href="<?php  echo webUrl('order/op/send', array('id' => $item['id']))?>">确认发货</a>
<?php  } else { ?>
    <?php  if($item['ismerch'] == 0) { ?>
    <a class="btn btn-primary btn-xs" data-toggle="ajaxPost" href="<?php  echo webUrl('order/op/pay', array('id' => $item['id']))?>" data-confirm="确认此订单已付款吗？">确认付款</a>
    <?php  } ?>
<?php  } ?>
<?php  } ?>

<?php  } else if($item['statusvalue'] == 1) { ?>
<!--已付款-->

<?php  if(!empty($item['addressid']) ) { ?>
<!--快递 发货-->
<?php if(cv('order.op.send')) { ?>
<a class="btn btn-primary btn-xs" data-toggle="ajaxModal"  href="<?php  echo webUrl('order/op/send', array('id' => $item['id']))?>">确认发货</a>
<?php  } ?>
<?php  } else { ?>
<?php  if($item['isverify']==1) { ?>
<!--核销 确认核销-->
<?php if(cv('order.op.verify')) { ?>
<a class="btn btn-primary btn-xs" data-toggle='ajaxPost' href="<?php  echo webUrl('order/op/fetch', array('id' => $item['id']))?>" data-confirm="确认使用吗？">确认使用</a>
<?php  } ?>
<?php  } else { ?>
<!--自提 确认取货-->
<?php if(cv('order.op.fetch')) { ?>
<a class="btn btn-primary btn-xs" data-toggle='ajaxPost'  href="<?php  echo webUrl('order/op/fetch', array('id' => $item['id']))?>" data-confirm="确认<?php  if(!empty($item['ccard'])) { ?>充值<?php  } else { ?>取货<?php  } ?>吗？">确认<?php  if(!empty($item['ccard'])) { ?>充值<?php  } else { ?>取货<?php  } ?></a>
<?php  } ?>
<?php  } ?>

<?php  } ?>

<?php  if($item['sendtype'] > 0) { ?>
    <?php if(cv('order.op.sendcancel')) { ?>
    <a class="text-primary" data-toggle='ajaxModal'  href="<?php  echo webUrl('order/op/sendcancel', array('id' => $item['id']))?>" >取消发货</a>
    <?php  } ?>
<?php  } ?>
<?php  } else if($item['statusvalue'] == 2 ) { ?>
<!--已发货-->
<?php  if(!empty($item['addressid'])) { ?>
<!--快递 取消发货-->


<?php if(cv('order.op.finish')) { ?><?php  if(strexists($_W['action'],'order.list')) { ?><?php  } ?><a class="btn btn-primary btn-xs" data-toggle='ajaxPost'  href="<?php  echo webUrl('order/op/finish', array('id' => $item['id']))?>" data-confirm="确认订单收货吗？">确认收货</a><br /><?php  } ?>
<?php  if($detial_flag == 1 && $item['status']!=3) { ?>
<?php if(cv('order.op.send')) { ?><a class="text-primary" data-toggle="ajaxModal"  href="<?php  echo webUrl('order/op/changeexpress', array('id' => $item['id']))?>">修改物流</a><?php  } ?>
<?php  } ?>
<?php if(cv('order.op.sendcancel')) { ?><?php  if(strexists($_W['action'],'order.list')) { ?><?php  } ?>
<a class="text-primary" data-toggle='ajaxModal'  href="<?php  echo webUrl('order/op/sendcancel', array('id' => $item['id']))?>" >取消发货</a><?php  } ?>
<?php  } else { ?>
    <?php if(cv('order.op.finish')) { ?>
        <?php  $isonly = m('order')->checkisonlyverifygoods($item['id'])?>
        <?php  if($isonly) { ?>
           <?php  if(strexists($_W['action'],'order.list')) { ?><?php  } ?>
            <a class="btn btn-primary btn-xs" data-toggle='ajaxPost'  href="<?php  echo webUrl('order/op/finish', array('id' => $item['id']))?>" data-confirm="确认完成订单吗？">确认完成</a><?php  } ?>
        <?php  } ?>
    <?php  } ?>

<?php  } else if($item['statusvalue'] == 3) { ?>

<?php  } ?>




<!--<div class="tables">-->





<!--</div>-->
<!--913702023503242914-->