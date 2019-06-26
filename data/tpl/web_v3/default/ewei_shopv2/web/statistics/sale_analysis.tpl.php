<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<style type="text/css">
	.num { position:absolute; left:10px;color:#000;font-weight:bold;}
	.progress { position: relative; }
</style>
 <div class="page-header"> 当前位置：<span class="text-primary">销售指标</span></div>
 
<div class="page-content">
    <form action="" class="form-horizontal">
        <div class='panel-body'>
            <div class="form-group">
                <div class="col-sm-12">
                    <table class="table table-hover" >
                        <thead>
                        <tr>
                            <th  style='width:150px;'>订单总金额</th>
                            <th  style='width:150px;'>总会员数</th>
                            <th style="width: 100px">会员人均消费</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php  echo $orderprice;?></td>
                            <td><?php  echo $member_count;?></td>
                            <?php $percent=round( $orderprice/($member_count==0?1:$member_count),2);?>
                            <td><span class='progress-num'><?php echo empty($percent)?'':$percent?></span></td>
                            <td>
                                <?php  if($percent>1) { ?><?php  $percent+=100?><?php  } else { ?><?php  $percent*=100?><?php  } ?>
                                <div class="progress">
                                    <div style="width: <?php  echo $percent;?>%;" class="progress-bar progress-bar-success"></div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <table class="table table-hover" >
                        <thead>
                        <tr>
                            <th style='width:150px;'>订单总金额</th>
                            <th style='width:150px;'>总访问次数</th>
                            <th style="width: 80px;">访问转化率</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php  echo $orderprice;?></td>
                            <td><?php  echo $viewcount;?></td>
                            <?php $percent=round( $orderprice/($viewcount==0?1:$viewcount),2);?>
                            <td><span class='progress-num'><?php echo empty($percent)?'':($percent*100).'%'?></span></td>
                            <td>
                                <?php  if($percent>1) { ?><?php  $percent+=100?><?php  } else { ?><?php  $percent*=100?><?php  } ?>
                                <div class="progress">
                                    <div style="width: <?php  echo $percent;?>%;" class="progress-bar progress-bar-info"></div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th style='width:150px;'>总订单数</th>
                            <th style='width:150px;'>总访问次数</th>
                            <th style="width: 80px">订单转化率</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php  echo $ordercount;?></td>
                            <td><?php  echo $viewcount;?></td>
                            <?php $percent=round( $ordercount/($viewcount==0?1:$viewcount),2);?>
                            <td><span class='progress-num'><?php echo empty($percent)?'':($percent*100).'%'?></span></td>
                            <td>
                                <?php  if($percent>1) { ?><?php  $percent+=100?><?php  } else { ?><?php  $percent*=100?><?php  } ?>
                                <div class="progress">
                                    <div style="width: <?php  echo $percent;?>%;" class="progress-bar progress-bar-danger"></div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <table class="table table-hover" >
                        <thead>
                        <tr>
                            <th style='width:150px;'>消费会员数</th>
                            <th style='width:150px;'>总会员数</th>
                            <th style="width: 80px">会员消费率</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php  echo $member_buycount;?></td>
                            <td><?php  echo $member_count;?></td>
                            <?php $percent=round( $member_buycount/($member_count==0?1:$member_count),2);?>
                            <td><span class='progress-num'><?php echo empty($percent)?'':($percent*100).'%'?></span></td>
                            <td>
                                <?php  if($percent>1) { ?><?php  $percent+=100?><?php  } else { ?><?php  $percent*=100?><?php  } ?>
                                <div class="progress">
                                    <div style="width: <?php  echo $percent;?>%;" class="progress-bar progress-bar-striped"></div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-8 col-lg-9 col-xs-12">
                    <table class="table table-hover" >
                        <thead>
                        <tr>
                            <th style='width:150px;'>总订单数</th>
                            <th style='width:150px;'>总会员数</th>
                            <th style="width: 80px">订单购买率</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php  echo $ordercount;?></td>
                            <td><?php  echo $member_count;?></td>
                            <?php $percent=round( $ordercount/($member_count==0?1:$member_count),2);?>
                            <td><span class='progress-num'><?php echo empty($percent)?'':($percent*100).'%'?></span></td>
                            <td>
                                <?php  if($percent>1) { ?><?php  $percent+=100?><?php  } else { ?><?php  $percent*=100?><?php  } ?>
                                <div class="progress">
                                    <div style="width: <?php  echo $percent;?>%;" class="progress-bar progress-bar-warning"></div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>