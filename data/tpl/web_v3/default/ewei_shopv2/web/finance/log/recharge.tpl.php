<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .style i{
        vertical-align: middle;
    }
</style>
<div class="page-header">当前位置：<span class="text-primary">充值记录</span></div>
<div class="page-content">
    <form action="./index.php" method="get" class="form-horizontal table-search" role="form" id="form1">
        <input type="hidden" name="c" value="site" />
        <input type="hidden" name="a" value="entry" />
        <input type="hidden" name="m" value="ewei_shopv2" />
        <input type="hidden" name="do" value="web" />
        <input type="hidden" name="r" value="finance.log.recharge" />
        <div class="page-toolbar">
            <span class="pull-left">
                    <?php  echo tpl_daterange('time', array('sm'=>true,'placeholder'=>'充值时间'),true);?>
                </span>
            <div class="input-group">
                <span class="input-group-select">
                    <select name="status" class="form-control"   style="width:75px;"  >
                        <option value="" <?php  if($_GPC['status']=='') { ?>selected<?php  } ?>>状态</option>
                            <option value="1" <?php  if($_GPC['status']=='1') { ?>selected<?php  } ?>><?php  if($_GPC['type']==0) { ?>充值成功<?php  } else { ?>完成<?php  } ?></option>
                            <option value="0" <?php  if($_GPC['status']=='0') { ?>selected<?php  } ?>><?php  if($_GPC['type']==0) { ?>未充值<?php  } else { ?>申请中<?php  } ?></option>
                            <?php  if($_GPC['type']==1) { ?><option value="-1" <?php  if($_GPC['status']=='-1') { ?>selected<?php  } ?>>失败</option><?php  } ?>
                    </select>
                </span>
                <span class="input-group-select">
                    <select name="groupid" class="form-control" style="width:100px;"  >
                        <option value="">会员分组</option>
                        <?php  if(is_array($groups)) { foreach($groups as $group) { ?>
                        <option value="<?php  echo $group['id'];?>" <?php  if($_GPC['groupid']==$group['id']) { ?>selected<?php  } ?>><?php  echo $group['groupname'];?></option>
                        <?php  } } ?>
                    </select>
                </span>
                <span class="input-group-select">
                    <select name="level" class="form-control" style="width:100px;"  >
                        <option value="">会员等级</option>
                        <?php  if(is_array($levels)) { foreach($levels as $level) { ?>
                        <option value="<?php  echo $level['id'];?>" <?php  if($_GPC['level']==$level['id']) { ?>selected<?php  } ?>><?php  echo $level['levelname'];?></option>
                        <?php  } } ?>
                    </select>
                </span>
                <span class="input-group-select">
                    <?php  if($_GPC['type']==0) { ?>
                    <select name="rechargetype" class="form-control" style="width:100px;"  >
                        <option value='' <?php  if($_GPC['rechargetype']=='') { ?>selected<?php  } ?>>充值方式</option>
                        <option value='wechat' <?php  if($_GPC['rechargetype']=='wechat') { ?>selected<?php  } ?>>微信</option>
                        <option value='alipay' <?php  if($_GPC['rechargetype']=='alipay') { ?>selected<?php  } ?>>支付宝</option>
                        <option value='system' <?php  if($_GPC['rechargetype']=='system') { ?>selected<?php  } ?>>后台</option>
                        <option value='system1' <?php  if($_GPC['rechargetype']=='system1') { ?>selected<?php  } ?>>后台扣款</option>
                        <?php  if(p('ccard')) { ?><option value='ccard' <?php  if($_GPC['rechargetype']=='ccard') { ?>selected<?php  } ?>>充值卡返佣</option><?php  } ?>
                    </select>
                    <?php  } ?>
                </span>
                <span class="input-group-select">
                    <select name="searchfield"  class="form-control"   style="width:100px;"  >
                        <option value="logno" <?php  if($_GPC['searchfield']=='logno') { ?>selected<?php  } ?>>充值单号</option>
                        <option value="member" <?php  if($_GPC['searchfield']=='member') { ?>selected<?php  } ?>>会员信息</option>
                    </select>
                </span>
                <input type="text" class="form-control"  name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词" />
                <span class="input-group-btn">
                    <button class="btn  btn-primary" type="submit"> 搜索</button>
                    <?php if(cv('finance.log.recharge.export')) { ?>
                        <button type="submit" name="export" value="1" class="btn btn-success ">导出</button>
                    <?php  } ?>
                </span>
            </div>
        </div>
    </form>
    <?php  if(empty($list)) { ?>
    <div class="panel panel-default">
        <div class="panel-body empty-data">未查询到相关数据</div>
    </div>
    <?php  } else { ?>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th style='width:200px;'>充值单号</th>
                    <th>粉丝</th>
                    <th>会员信息</th>
                    <th>充值金额</th>
                    <th style='width:100px;'>充值时间</th>
                    <th style='width:100px;text-align: center;'>充值方式</th>
                    <th style='width:100px;text-align: center;'>状态</th>
                    <th style="text-align: center;">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
                    <td><?php  if(!empty($row['logno'])) { ?>
                        <?php  if(strlen($row['logno'])<=22) { ?>
                        <?php  echo $row['logno'];?>
                        <?php  } else { ?>
                        recharge<?php  echo $row['id'];?>
                        <?php  } ?>
                        <?php  } else { ?>
                        recharge<?php  echo $row['id'];?>
                        <?php  } ?>
                    </td>
                    <td data-toggle='tooltip' title='<?php  echo $row['nickname'];?>'>
                    <?php if(cv('member.list.edit')) { ?>
                    <a  href="<?php  echo webUrl('member/list/detail',array('id' => $row['mid']));?>" target='_blank'>
                        <img class="radius50" src='<?php  echo tomedia($row['avatar'])?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' / onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'"> <?php  echo $row['nickname'];?>
                    </a>
                    <?php  } else { ?>
                    <img src='<?php  echo tomedia($row['avatar'])?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' /> <?php  echo $row['nickname'];?>
                    <?php  } ?>

                    </td>
                    <td><?php  if(!empty($row['realname'])) { ?><?php  echo $row['realname'];?><?php  } else { ?>匿名<?php  } ?><br/><?php  if(!empty($row['mobile'])) { ?><?php  echo $row['mobile'];?><?php  } else { ?>暂无<?php  } ?></td>
                    <td><?php  echo $row['money'];?></td>
                    <td><?php  echo date('Y-m-d',$row['createtime'])?><br/><?php  echo date('H:i',$row['createtime'])?></td>
                    <td style="text-align: center;" class="style">
                        <?php  if($row['rechargetype']=='alipay') { ?>
                        <i class="icow icow-zhifubao text-primary"></i>支付宝
                        <?php  } else if($row['rechargetype']=='wechat') { ?>
                       <i class="icow icow-weixin text-success"></i> 微信
                        <?php  } else if($row['rechargetype']=='system') { ?>
                        <?php  if($row['money']>0) { ?>
                       <i class="icow icow-yue text-warning" ></i>后台
                        <?php  } else { ?>
                      <i class="icow icow-youqiatuikuanxiecha text-danger"></i>扣款
                        <?php  } ?>
                        <?php  } else if($row['rechargetype']=='ccard') { ?>
                        <span class='label label-primary'>充值卡返佣</span>
                        <?php  } ?>
                    </td>
                    <td style="text-align: center;">
                        <?php  if($row['status']==0) { ?>
                        <span class='text-default'><?php  if($row['type']==1) { ?>申请中<?php  } else { ?>未充值<?php  } ?></span>
                        <?php  } else if($row['status']==1) { ?>
                        <span class='text-success'>成功</span>
                        <?php  } else if($row['status']==-1) { ?>
                        <span class='text-default'><?php  if($row['type']==1) { ?>拒绝<?php  } else { ?>失败<?php  } ?></span>
                        <?php  } else if($row['status']==3) { ?>
                        <span class='text-danger'><?php  if($row['type']==0) { ?>退款<?php  } ?></span>
                        <?php  } ?>
                    </td>
                    <td style="text-align: center;">
                        <?php  if($row['status']==1) { ?>
                        <?php  if($row['rechargetype']=='alipay' || $row['rechargetype']=='wechat') { ?>
                        <?php if(cv('finance.log.refund')) { ?>
                        <a class='btn btn-sm btn-danger' data-toggle='ajaxPost' data-confirm="确认退款到<?php  if($row['rechargetype']=='alipay') { ?>支付宝<?php  } else { ?>微信钱包<?php  } ?>?" href="<?php  echo webUrl('finance/log/refund',array('id' => $row['id']));?>">
                            退款
                        </a>
                        <?php  } ?>
                        <?php  } ?>
                        <?php  } ?>
                    </td>
                </tr>
                <?php  if(!empty($row['remark'])) { ?>
                <tr style=";border-bottom:none;background:#f9f9f9;">
                    <td colspan='8' style='text-align:left'>
                        备注:<span class="text-info"><?php  echo $row['remark'];?></span>
                    </td>
                </tr>
                <?php  } ?>
                <?php  } } ?>
                </tbody>
                <tfoot>
                <tr>
                    </td>
                    <td colspan="8" style="text-align: right">
                        <?php  echo $pager;?>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <?php  } ?>

</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>