<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .popover{
        width:170px;
        font-size:12px;
        line-height: 21px;
        color: #0d0706;
    }
    .popover span{
        color: #b9b9b9;
    }
    .nickname{
        display: inline-block;
        max-width:200px;
        overflow: hidden;
        text-overflow:ellipsis;
        white-space: nowrap;
        vertical-align: middle;
    }

    .tooltip-inner{
        border:none;
    }
</style>
<div class="page-header">
    当前位置：<span class="text-primary">分销商统计 </span>
</div>
<div class="page-content">
<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
    <input type="hidden" name="c" value="site" />
    <input type="hidden" name="a" value="entry" />
    <input type="hidden" name="m" value="ewei_shopv2" />
    <input type="hidden" name="do" value="web" />
    <input type="hidden" name="r" value="commission.statistics.agent" />

    <div class="page-toolbar">
        <div class="col-sm-12">
        <div style="float: left;">
            <?php  echo tpl_daterange('ordertime', array('sm'=>true, 'placeholder'=>'下单时间'),true);?>
            <?php  echo tpl_daterange('time', array('sm'=>true, 'placeholder'=>'成为分销商时间'),true);?>
        </div>


            <div class="input-group">
                <div class="input-group-select">

                </div>
                <div class="input-group-select">
                    <select name='searchfield'  class='form-control   '   style="width:88px;"  >
                        <option value='member' <?php  if($_GPC['searchfield']=='member') { ?>selected<?php  } ?>>分销商</option>
                        <option value='parent' <?php  if($_GPC['searchfield']=='parent') { ?>selected<?php  } ?>>推荐人</option>
                    </select>
                </div>
                <div class="input-group-select" >
                    <select name='followed' class='form-control   ' style="width:75px;" >
                        <option value=''>关注</option>
                        <option value='0' <?php  if($_GPC['followed']=='0') { ?>selected<?php  } ?>>未关注</option>
                        <option value='1' <?php  if($_GPC['followed']=='1') { ?>selected<?php  } ?>>已关注</option>
                        <option value='2' <?php  if($_GPC['followed']=='2') { ?>selected<?php  } ?>>取消关注</option>
                    </select>
                </div>
                <div class="input-group-select">
                    <select name='agentlevel' class='form-control'   style="width:75px;">
                        <option value=''>等级</option>
                        <?php  if(is_array($agentlevels)) { foreach($agentlevels as $level) { ?>
                        <option value='<?php  echo $level['id'];?>' <?php  if($_GPC['agentlevel']==$level['id']) { ?>selected<?php  } ?>><?php  echo $level['levelname'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
                <div class="input-group-select">
                    <select name='isagentblack'  class='form-control'    style="width:88px;">
                        <option value=''>黑名单</option>
                        <option value='0' <?php  if($_GPC['isagentblack']=='0') { ?>selected<?php  } ?>>否</option>
                        <option value='1' <?php  if($_GPC['isagentblack']=='1') { ?>selected<?php  } ?>>是</option>
                    </select>
                </div>
                <input type="text" class="form-control input-sm"  name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="昵称/姓名/手机号"/>
				 <span class="input-group-btn">
                                
                                        <button class="btn btn-primary" type="submit"> 搜索</button>

                                                                                	    <?php if(cv('commission.agent.export')) { ?>
                        <button type="submit" name="export" value="1" class="btn btn-success">导出</button>
                        <?php  } ?>
				</span>
            </div>

        </div>
    </div>


</form>
<?php  if(count($list)>0) { ?>

<table class="table table-hover table-responsive">
    <thead class="navbar-inner" >
    <tr>
        <th style="width:25px;"></th>

        <th>粉丝</th>
        <th>姓名<br/>手机号码<br/>等级</th>
        <th>分销金额<br/>分销订单数量</th>
        <th>累计佣金<br/>打款佣金</th>
        <th>下级累计佣金<br/>下级分销商</th>
        <th>注册时间<br/>审核时间</th>
        <th>状态<br/>关注</th>
        <th style="width: 125px;">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php  if(is_array($list)) { foreach($list as $row) { ?>
    <tr>

        <td>
            <input type='checkbox'   value="<?php  echo $row['id'];?>"/>
        </td>

        <td style="overflow: visible">
            <div style="display: flex;" rel="pop"  data-content="
            <span>ID: </span><?php  echo $row['id'];?> </br>
           <span>推荐人：</span> <?php  if(empty($row['agentid'])) { ?>
				  <?php  if($row['isagent']==1) { ?>
				     总店
				      <?php  } else { ?>
				       暂无
				      <?php  } ?>
				<?php  } else { ?>
                    	<?php  if(!empty($row['parentavatar'])) { ?>
                         <img class='radius50' src='<?php  echo $row['parentavatar'];?>' style='width:20px;height:20px;padding1px;border:1px solid #ccc' onerror='this.src='../addons/ewei_shopv2/static/images/noface.png''/>
                       <?php  } ?>
                       [<?php  echo $row['agentid'];?>]<?php  if(empty($row['parentname'])) { ?>未更新<?php  } else { ?><?php  echo $row['parentname'];?><?php  } ?>
					   <?php  } ?></br>
					   <span>是否关注：</span>
                         <?php  if(empty($row['followed'])) { ?>
                            <?php  if(empty($row['uid'])) { ?>
                          未关注
                            <?php  } else { ?>
                           取消关注
                            <?php  } ?>
                            <?php  } else { ?>
                            已关注
                            <?php  } ?></br>
                            <span>状态:</span>  <?php  if($row['isblack']==1) { ?>黑名单<?php  } else { ?>正常<?php  } ?>
					   ">

                        <?php if(cv('member.list.view')) { ?>
                        <a href="<?php  echo webUrl('member/list/detail',array('id' => $row['id']));?>" title='会员信息' target='_blank' style="display: flex">
                            <img class="radius50" src='<?php  echo $row['avatar'];?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' onerror="this.src='../addons/ewei_shopv2/static/images/face.png'"/>
                              <span style="display: flex;flex-direction: column;justify-content: center;align-items: flex-start;padding-left: 5px">
                                  <span class="nickname">
                                    <?php  if(empty($row['nickname'])) { ?>未更新<?php  } else { ?><?php  echo $row['nickname'];?><?php  } ?>
                                    </span>
                                    <?php  if($row['isblack']==1) { ?>
                                    <span class="text-danger">黑名单<i class="icow icow-heimingdan1"style="color: #db2228;margin-left: 2px;font-size: 13px;"></i></span>
                                    <?php  } ?>
                              </span>
                        </a>
                        <?php  } else { ?>
                            <img class="radius50" src='<?php  echo $row['avatar'];?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' onerror="this.src='../addons/ewei_shopv2/static/images/face.png'"/>

                              <span style="display: flex;flex-direction: column;justify-content: center;align-items: flex-start;padding-left: 5px">
                                  <span class="nickname">
                                    <?php  if(empty($row['nickname'])) { ?>未更新<?php  } else { ?><?php  echo $row['nickname'];?><?php  } ?>
                              </span>
                                <?php  if($row['isblack']==1) { ?>
                                <span class="text-danger">黑名单<i class="icow icow-heimingdan1"style="color: #db2228;margin-left: 2px;font-size: 13px;"></i></span>
                                <?php  } ?>
                              </span>
                        <?php  } ?>


            </div>

        </td>

        <td><?php  echo $row['realname'];?> <br/> <?php  echo $row['mobile'];?> <br/> <?php  if(empty($row['levelname'])) { ?> <?php echo empty($this->set['levelname'])?'普通等级':$this->set['levelname']?><?php  } else { ?><?php  echo $row['levelname'];?><?php  } ?></td>



        <td>
            <span class="text-warning"><?php  echo $row['ordermoney'];?></span>
            <br/>
            <?php  echo $row['level_ordercount'];?>
            <?php  if($row['level_ordercount']>0) { ?>
            <a data-trigger="hover" data-toggle='popover' data-placement='bottom' data-html="true" data-content='一级：<?php  echo $row['level1_ordercount'];?> 个订单<br/> 二级：<?php  echo $row['level2_ordercount'];?> 个订单<br/>三级：<?php  echo $row['level3_ordercount'];?> 个订单'>
                <i class='fa fa-question-circle'></i>
            </a>
            <?php  } ?>
        </td>
        <td>
           <span class="text-danger"> <?php  echo $row['commission_total'];?></span><br/>
            <span class="text-warning"><?php  echo $row['commission_pay'];?></span>
        </td>

        <td >
           <span class="text-danger"> <?php  echo $row['level_commission_total'];?></span>
            <br/>

            <?php if(cv('commission.agent.user')) { ?>
            <a href="<?php  echo webUrl('commission/agent/user',array('id' => $row['id']));?> data-toggle='popover' data-placement='bottom' data-html="true" data-content='查看推广下线'>
                <?php  echo $row['levelcount'];?>
            </a>
            <?php  } else { ?>
            <?php  echo $row['levelcount'];?>
            <?php  } ?>

        </td>
        <td><?php  echo date('Y-m-d H:i',$row['createtime'])?>
            <br/>
            <?php  if(!empty($row['agenttime'])) { ?>
            <?php  echo date('Y-m-d H:i',$row['agenttime'])?>
            <?php  } else { ?>
            -
            <?php  } ?>
        </td>

        <td>
            <span class='label <?php  if($row['status']==1) { ?>label-primary<?php  } else { ?>label-default<?php  } ?>'>
            <?php  if($row['status']==1) { ?>已审核<?php  } else { ?>未审核<?php  } ?></span>



        </td>

        <td  style="overflow:visible;">

            <div class="btn-group ">
                    <?php if(cv('order.list')) { ?>
                        <a class="btn btn-op btn-operation" href="<?php  echo webUrl('order/list',array('agentid' => $row['id']));?>"   target='_blank'>
                            <span data-toggle="tooltip" data-placement="top" title="" data-original-title="推广订单">
                                <i class='icow icow-tuiguang'></i>
                            </span>
                        </a>
                    <?php  } ?>
                    <?php if(cv('order')) { ?>
                        <a class="btn btn-op btn-operation" href="<?php  echo webUrl('order/list', array('searchfield'=>'member', 'keyword'=>$row['nickname']))?>"  target='_blank'>
                            <span data-toggle="tooltip" data-placement="top" title="" data-original-title="会员订单">
                                <i class='icow icow-dingdan2'></i>
                            </span>
                        </a>
                    <?php  } ?>
                    <?php if(cv('finance.recharge.credit1|finance.recharge.credit2')) { ?>
                        <a class="btn btn-op btn-operation" data-toggle="ajaxModal" href="<?php  echo webUrl('finance/recharge', array('type'=>'credit1','id'=>$row['id']))?>">
                            <span data-toggle="tooltip" data-placement="top" title="" data-original-title="充值">
                                   <i class='icow icow-31'></i>
                                </span>
                        </a>
                    <?php  } ?>
                    <?php if(cv('commission.agent.delete')) { ?>
                    <a class="btn btn-op btn-operation" data-toggle='ajaxRemove' href="<?php  echo webUrl('commission/agent/delete',array('id' => $row['id']));?>" data-confirm="确定要删除该分销商吗？">
                                <span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除分销商">
                                       <i class='icow icow-shanchu1'></i>
                                    </span>
                    </a>
                    <?php  } ?>
            </div>


        </td>
    </tr>
    <?php  } } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="9" class="text-right">
                <?php  echo $pager;?>
            </td>
        </tr>
    </tfoot>
</table>

<?php  } else { ?>
<div class='panel panel-default'>
    <div class='panel-body' style='text-align: center;padding:30px;'>
        暂时没有任何分销商!
    </div>
</div>
<?php  } ?>
</div>
<script language="javascript">
    require(['bootstrap'],function(){
        $("[rel=pop]").popover({
            trigger:'manual',
            placement : 'right',
            title : $(this).data('title'),
            html: 'true',
            content : $(this).data('content'),
            animation: false
        }).on("mouseenter", function () {
            var _this = this;
            $(this).popover("show");
            $(this).siblings(".popover").on("mouseleave", function () {
                $(_this).popover('hide');
            });
        }).on("mouseleave", function () {
            var _this = this;
            setTimeout(function () {
                if (!$(".popover:hover").length) {
                    $(_this).popover("hide")
                }
            }, 100);
        });


    });


</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--4000097827-->