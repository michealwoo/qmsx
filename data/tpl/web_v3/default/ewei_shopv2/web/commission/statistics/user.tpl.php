<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type='text/css'>
    .moresearch { padding:0px 10px;}
    .moresearch .col-sm-2 {
        padding:0 5px
    }
    .popover{
        width:150px;
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
    当前位置：<span class="text-primary">分销关系</span>
</div>
<div class="page-content">
<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
    <input type="hidden" name="c" value="site" />
    <input type="hidden" name="a" value="entry" />
    <input type="hidden" name="m" value="ewei_shopv2" />
    <input type="hidden" name="do" value="web" />
    <input type="hidden" name="r" value="commission.statistics.user" />
    <input type="hidden" name="id" value="<?php  echo $agentid;?>" />
    <input type="hidden" name="searchstart" value="1" />

    <div class="page-toolbar ">
        <div class="col-sm-12 ">
            <span class='pull-left' style="margin-right: 10px">
            <a class="btn btn-default  btn-sm" href="<?php  echo referer()?>">返回列表</a>
            </span>
            <div class="pull-left">
                <?php  echo tpl_daterange('createtime', array('sm'=>true, 'placeholder'=>'会员注册时间'),true);?>
            </div>
            <div class="pull-left">
                <?php  echo tpl_daterange('time', array('sm'=>true, 'placeholder'=>'成为分销商时间'),true);?>
            </div>
            <div class="input-group">
                <div class="input-group-select">
                    <select name='isagent'  class='form-control  input-sm'  >
                        <option value=''>是否分销商</option>
                        <option value='0' <?php  if($_GPC['isagent']=='0') { ?>selected<?php  } ?>>不是</option>
                        <option value='1' <?php  if($_GPC['isagent']=='1') { ?>selected<?php  } ?>>是</option>
                    </select>
                </div>
                <div class="input-group-select">
                    <select name='level' class='form-control  input-sm' >
                        <option value=''>下线层级</option>
                        <?php  if($this->set['level']>=1) { ?><option value='1' <?php  if($_GPC['level']=='1') { ?>selected<?php  } ?>>一级下线</option><?php  } ?>
                        <?php  if($this->set['level']>=2) { ?><option value='2' <?php  if($_GPC['level']=='2') { ?>selected<?php  } ?>>二级下线</option><?php  } ?>
                        <?php  if($this->set['level']>=3) { ?><option value='3' <?php  if($_GPC['level']=='3') { ?>selected<?php  } ?>>三级下线</option><?php  } ?>
                    </select>
                </div>
                <div class="input-group-select">
                    <select name='followed' class='form-control  input-sm'>
                        <option value=''>关注</option>
                        <option value='0' <?php  if($_GPC['followed']=='0') { ?>selected<?php  } ?>>未关注</option>
                        <option value='1' <?php  if($_GPC['followed']=='1') { ?>selected<?php  } ?>>已关注</option>
                        <option value='2' <?php  if($_GPC['followed']=='2') { ?>selected<?php  } ?>>取消关注</option>
                    </select>
                </div>
                <input type="text" class="form-control "  name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="粉丝昵称/姓名/手机号"/>
                 <span class="input-group-btn">
                     <button class="btn btn-primary" type="submit"> 搜索</button>
                     <button type="submit" name="export" value="1" class="btn btn-success">导出</button>

                </span>
            </div>

        </div>
    </div>

</form>

    <?php  if(count($list)>0) { ?>

    <table class="table table-hover table-responsive">
        <thead class="navbar-inner" >
        <tr>
            <th>上级</th>
            <th>上级ID<br/>上级姓名</th>
            <th>粉丝</th>
            <th>层级</th>
            <th>姓名<br/>手机号码<br/>等级</th>
            <th>累计佣金<br/>打款佣金</th>
            <th>下级分销商</th>

            <th>注册时间<br/>审核时间</th>
            <th>状态<br/>关注</th>
            <th style="width: 80px;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php  if(is_array($list)) { foreach($list as $row) { ?>
        <tr>
            <td style="overflow: visible">
               <div style="display: flex"  rel="pop" data-content="
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
                            <span>状态:</span>  <?php  if($row['agentblack']==1) { ?>黑名单<?php  } else { ?>正常<?php  } ?>
					   ">
                   <?php if(cv('member.list.view')) { ?>
                   <a href="<?php  echo webUrl('member/list/detail',array('id' => $row['pagent']['id']));?>" title='会员信息' target='_blank' style="display: flex">
                   <?php  if(!empty($row['pagent']['avatar'])) { ?>
                   <img class="radius50" src='<?php  echo $row['pagent']['avatar'];?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc'  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'"/>
                   <?php  } ?>
               <span style="display: flex;flex-direction: column;justify-content: center;align-items: flex-start;padding-left: 5px">
                    <span class="nickname">
                   <?php  if(empty($row['pagent']['nickname'])) { ?>未更新<?php  } else { ?><?php  echo $row['pagent']['nickname'];?><?php  } ?>
                    </span>
                   <?php  if($row['agentblack']==1) { ?>
                   <span class="text-danger">黑名单<i class="icow icow-heimingdan1"style="color: #db2228;margin-left: 2px;font-size: 13px;"></i></span>
                   <?php  } ?>
               </span>
                   </a>
                   <?php  } else { ?>
                   <?php  if(!empty($row['pagent']['avatar'])) { ?>
                   <img class="radius50" src='<?php  echo $row['pagent']['avatar'];?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc'  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'"/>
                   <?php  } ?>
                   <?php  if(empty($row['pagent']['nickname'])) { ?>未更新<?php  } else { ?><?php  echo $row['pagent']['nickname'];?><?php  } ?>
                   <?php  } ?>
                   <?php  if($row['agentblack']==1) { ?>
                   <span class="text-danger">黑名单<i class="icow icow-heimingdan1"style="color: #db2228;margin-left: 2px;font-size: 13px;"></i></span>
                   <?php  } ?>
               </div>
            </td>

            <td><?php  echo $row['pagent']['id'];?> <br/> <?php  echo $row['pagent']['realname'];?>
            </td>

            <td >
                <a href="<?php  echo webUrl('member/list/detail',array('id' => $row['id']));?>" title='会员信息' target='_blank' style="display: flex">
                    <span data-toggle='tooltip' title='<?php  echo $row['nickname'];?>'>
                    <?php  if(!empty($row['avatar'])) { ?>
                    <img class="radius50" src='<?php  echo $row['avatar'];?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc'  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'"/>
                    <?php  } ?>
                    <?php  if(empty($row['nickname'])) { ?>未更新<?php  } else { ?><?php  echo $row['nickname'];?><?php  } ?>
                    </span>
                </a>
            </td>
            <td><?php  if($row['level'] == 1) { ?>
                一级下线
                <?php  } else if($row['level'] == 2) { ?>
                二级下线
                <?php  } else if($row['level'] == 3) { ?>
                三级下线
                <?php  } ?>

            </td>
            <td><?php  echo $row['realname'];?> <br/> <?php  echo $row['mobile'];?><br/><?php  if($row['isagent']==1) { ?>
                <?php  if(empty($row['levelname'])) { ?> <?php echo empty($this->set['levelname'])?'普通等级':$this->set['levelname']?><?php  } else { ?><?php  echo $row['levelname'];?><?php  } ?></td>
            <?php  } else { ?>
            -<?php  } ?>

            <td><?php  if($row['isagent']==1) { ?>
                <?php  echo $row['commission_total'];?><br/><?php  echo $row['commission_pay'];?>
                <?php  } else { ?>
                -<?php  } ?>
            </td>
            <td >
                <?php if(cv('commission.agent.user')) { ?>
                <a  href="<?php  echo webUrl('commission/agent/user',array('id' => $row['id']));?>"  target='_blank' data-toggle='popover' data-placement='right' data-html="true" data-trigger='hover' data-content='查看推广下线'>
                    <?php  echo $row['levelcount'];?>
                </a>
                <?php  } else { ?>
                <?php  echo $row['levelcount'];?>
                <?php  } ?>

            </td>
            <td><?php  echo date('Y-m-d H:i',$row['createtime'])?><br/>
                <?php  if(!empty($row['agenttime']) && $row['isagent']==1) { ?>
                <?php  echo date('Y-m-d H:i',$row['agenttime'])?>
                <?php  } else { ?>
                -
                <?php  } ?>
            </td>
            <td>

                <?php  if($row['isagent']==1) { ?>
                <span class='label <?php  if($row['status']==1) { ?>label-primary<?php  } else { ?>label-default<?php  } ?>'>
                <?php  if($row['status']==1) { ?>已审核<?php  } else { ?>未审核<?php  } ?></span>
                <?php  } else { ?>
                -
                <?php  } ?>

                <br/>
            </td>

            <td  style="overflow:visible;">

                <div class="btn-group">
                        <?php  if($row['isagent']==1) { ?>
                            <?php if(cv('order.list')) { ?>
                            <a class="btn  btn-op btn-operation" href="<?php  echo webUrl('order/list',array('agentid' => $row['id']));?>" title='推广订单'  target='_blank'>
                                            <span data-toggle="tooltip" data-placement="top" title="" data-original-title="推广订单">
                                                <i class='icow icow-tuiguang'></i>
                                            </span>
                            </a>
                            <?php  } ?>
                        <?php  } ?>
                        <?php if(cv('order.list')) { ?>
                            <a class="btn  btn-op btn-operation" href="<?php  echo webUrl('order/list', array('op' => 'display','searchfield'=>'member', 'keyword'=>$row['nickname']))?>" title='会员订单' target='_blank'>
                                <span data-toggle="tooltip" data-placement="top" title="" data-original-title="会员订单">
                                    <i class='icow icow-dingdan2'></i>
                                </span>
                            </a>
                    <?php  } ?>
                    </ul>
                </div>


            </td>
        </tr>
        <?php  } } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="10" class="text-right"><?php  echo $pager;?></td>
            </tr>
        </tfoot>
    </table>
    <?php  } else { ?>
    <div class='panel panel-default'>
        <div class='panel-body' style='text-align: center;padding:30px;'>
            暂时没有任何信息!
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