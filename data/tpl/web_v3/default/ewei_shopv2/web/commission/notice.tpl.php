<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .select2{
        margin:0;
        width:100%;
        height:34px;
        border-radius: 3px;
        border-color: rgb(229, 230, 231);
    }
    .select2 .select2-choice{
        height: 34px;
        line-height: 32px;
        border-radius: 3px;
        border-color: rgb(229, 230, 231);
    }
    .select2 .select2-choice .select2-arrow{
        background: #fff;
    }
    .checkbox-inline, .radio-inline{
        vertical-align: baseline;
    }
    .is_sms {display: <?php  if(!empty($opensms)) { ?>table-block<?php  } else { ?>none<?php  } ?>;}
    /*.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {*/
        /*border:none ;*/
    /*}*/
</style>
<div class="page-header">
    当前位置：<span class="text-primary">通知设置</span>
    <div class="pull-right" >
        <strong>高级模式</strong>
        <?php if(cv('commission.notice.edit')) { ?>
        <input class="js-switch small advanced" type="checkbox" <?php  if(!empty($data['tm']['is_advanced'])) { ?>checked<?php  } ?>/>
        <?php  } else { ?>
        <?php  if(!empty($data['tm']['is_advanced'])) { ?>开启<?php  } else { ?>关闭<?php  } ?>
        <?php  } ?>
    </div>
</div>
<div class="page-content">
    <form id="setform"  <?php if(cv('commission.notice.edit')) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate">

        <input type="hidden" value="<?php  echo intval($data['tm']['is_advanced'])?>" name='data[is_advanced]' />
        <?php if(cv('commission.notice.edit')) { ?>
        <div class='alert alert-warning' id="advanced_alert">
            <h3>注意：</h3>
            <p>请将公众平台模板消息所在行业选择为：<b> IT科技/互联网|电子商务 其他|其他</b>，所选行业不一致将会导致模板消息不可用。</p>
            <p>点击模板消息后方的开关按钮<img src="../addons/ewei_shopv2/static/images/on-off.png"  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'"  />即可<b>开启模板消息</b>，无需进行额外设置。</p>
            <p>如需进行消息推送<b>个性化消息</b>，<a href="<?php  echo webUrl('sysset/tmessage')?>" title="模板消息库">点击进入自定义消息库</a><?php  if($opensms) { ?>，<a href="<?php  echo webUrl('sysset/sms')?>" title="短信消息库">点击进入短信消息库</a><?php  } ?></p>
        </div>
        <div class='alert alert-primary' id="normal_alert">
            默认为全部开启， 模板消息自动替换变量 <?php  if($opensms) { ?><span class="text-danger"><a href="<?php  echo webUrl('sysset/sms/temp')?>">短信模板库(点击进入)</a></span><?php  } ?>
        </div>
        <?php  } ?>
        <div id="normal">
            <div class="form-group">
                <label class="col-lg control-label">业务处理通知</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <input type="text" name="data[templateid]" class="form-control" value="<?php  echo $data['tm']['templateid'];?>" />
                    <div class="help-block">公众平台模板消息编号: OPENTM207574677 </div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['templateid'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group-title">分销商提现通知</div>

            <div class="form-group">
                <label class="col-lg control-label">标题</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <input type="text" name="data[commission_applymoney_title]" class="form-control" value="<?php  echo $data['tm']['commission_applymoney_title'];?>" />
                    <div class="help-block">标题，默认"您有分销商申请提现了"</div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['commission_applymoney_title'];?></div>
                    <?php  } ?>
                </div>
            </div>
            <div  class="form-group">
                <label class="col-lg control-label">选择通知人-<br/>分销商提现通知</label>
                <div class="colstd">
                    <?php  echo tpl_selector('openids2',array('key'=>'openid','text'=>'nickname', 'thumb'=>'avatar','multi'=>1,'placeholder'=>'昵称/姓名/手机号','buttontext'=>'选择通知人', 'items'=>$salers2,'url'=>webUrl('member/query') ))?>
                    <div style="margin-left: 8%"><span class='help-block'>分销商提现后以模板消息的方式商家通知，可以指定多个人，如果不填写则不通知</span></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg control-label">内容</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <textarea  name="data[commission_applymoney]" class="form-control" rows="5" ><?php  echo $data['tm']['commission_applymoney'];?></textarea>
                    模板变量: [昵称] [时间] [金额] [提现方式]
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['commission_applymoney'];?></div>
                    <?php  } ?>

                </div>
            </div>

            <div class="form-group is_sms">
                <label class="col-lg control-label">短信提醒</label>
                <div class="col-sm-9 col-xs-12">
                    <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_become_sms]"<?php  } else { ?>disabled<?php  } ?>>>
                    <option value=''>从短信消息库中选择</option>
                    <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                    <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_become_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                    <?php  } } ?>
                    </select>
                </div>
            </div>
            <div class="form-group-title">成为分销商通知</div>

            <div class="form-group">
                <label class="col-lg control-label">标题</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <input type="text" name="data[commission_becometitle]" class="form-control" value="<?php  echo $data['tm']['commission_becometitle'];?>" />
                    <div class="help-block">标题，默认"恭喜您成为分销商"</div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['commission_becometitle'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg control-label">内容</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <textarea  name="data[commission_become]" class="form-control" rows="5" ><?php  echo $data['tm']['commission_become'];?></textarea>
                    模板变量: [昵称] [时间]
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['commission_become'];?></div>
                    <?php  } ?>

                </div>
            </div>

            <div class="form-group is_sms">
                <label class="col-lg control-label">短信提醒</label>
                <div class="col-sm-9 col-xs-12">
                    <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_become_sms]"<?php  } else { ?>disabled<?php  } ?>>>
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_become_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
            </div>

            <div class="form-group-title">新增下级通知</div>

            <div class="form-group">
                <label class="col-lg control-label">标题</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <input type="text" name="data[commission_agent_newtitle]" class="form-control" value="<?php  echo $data['tm']['commission_agent_newtitle'];?>" />
                    <div class="help-block">
                        标题，默认"恭喜您新增下级成员"&nbsp;&nbsp;&nbsp; 默认通知等级 :
                        <label class="radio-inline">
                            <input type="radio" value="0" name="data[commission_agent_new_notice]" <?php  if(empty($data['tm']['commission_agent_new_notice'])) { ?>checked=""<?php  } ?>> <?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>[默认]
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="1" name="data[commission_agent_new_notice]" <?php  if(strexists($data['tm']['commission_agent_new_notice'],'1')) { ?>checked=""<?php  } ?>> <?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>+<?php echo empty($data['texts']['c2'])?'二级':$data['texts']['c2']?>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="2" name="data[commission_agent_new_notice]" <?php  if(strexists($data['tm']['commission_agent_new_notice'],'2')) { ?>checked=""<?php  } ?>> <?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>+<?php echo empty($data['texts']['c2'])?'二级':$data['texts']['c2']?>+<?php echo empty($data['texts']['c3'])?'三级':$data['texts']['c3']?>
                        </label>
                    </div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['commission_agent_newtitle'];?></div>
                    <?php  } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg control-label">内容</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <textarea  name="data[commission_agent_new]" class="form-control" rows="5"><?php  echo $data['tm']['commission_agent_new'];?></textarea>
                    <div class='help-block'>模板变量: [下级昵称] [时间] [下线层级]</div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['commission_agent_new'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group is_sms">
                <label class="col-lg control-label">短信提醒</label>
                <div class="col-sm-9 col-xs-12">
                    <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_agent_sms]"<?php  } else { ?>disabled<?php  } ?>>>
                    <option value=''>从短信消息库中选择</option>
                    <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                    <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_agent_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                    <?php  } } ?>
                    </select>
                </div>
            </div>

            <div class="form-group-title">下级付款通知</div>

            <div class="form-group">
                <label class="col-lg control-label">标题</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <input type="text" name="data[commission_order_paytitle]" class="form-control" value="<?php  echo $data['tm']['commission_order_paytitle'];?>" />
                    <div class="help-block">
                        标题，默认"您有下级付款了"&nbsp;&nbsp;&nbsp;默认通知等级 :
                        <label class="radio-inline">
                            <input type="radio" value="0" name="data[commission_order_pay_notice]" <?php  if(empty($data['tm']['commission_order_pay_notice'])) { ?>checked=""<?php  } ?>> <?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>[默认]
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="1" name="data[commission_order_pay_notice]" <?php  if(strexists($data['tm']['commission_order_pay_notice'],'1')) { ?>checked=""<?php  } ?>> <?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>+<?php echo empty($data['texts']['c2'])?'二级':$data['texts']['c2']?>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="2" name="data[commission_order_pay_notice]" <?php  if(strexists($data['tm']['commission_order_pay_notice'],'2')) { ?>checked=""<?php  } ?>> <?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>+<?php echo empty($data['texts']['c2'])?'二级':$data['texts']['c2']?>+<?php echo empty($data['texts']['c3'])?'三级':$data['texts']['c3']?>
                        </label>
                    </div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['commission_order_paytitle'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg control-label">内容</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <textarea  name="data[commission_order_pay]" class="form-control" rows="5"><?php  echo $data['tm']['commission_order_pay'];?></textarea>
                    <div class="help-block">模板变量 [下级昵称] [订单编号] [订单金额] [商品详情] [佣金金额] [时间] [下线层级]</div>
                    <div class="help-block">注意: 此 [佣金金额] ，不代表上级用户会立即获得，为可能获得的佣金金额</div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['commission_order_pay'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group is_sms">
                <label class="col-lg control-label">短信提醒</label>
                <div class="col-sm-9 col-xs-12">
                    <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_order_pay_sms]"<?php  } else { ?>disabled<?php  } ?>>>
                    <option value=''>从短信消息库中选择</option>
                    <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                    <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_order_pay_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                    <?php  } } ?>
                    </select>
                </div>
            </div>

            <div class="form-group-title">下级确认收货通知</div>

            <div class="form-group">
                <label class="col-lg control-label">标题</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <input type="text" name="data[commission_order_finishtitle]" class="form-control" value="<?php  echo $data['tm']['commission_order_finishtitle'];?>" />
                    <div class="help-block">
                        标题，默认"您有下级确认收货了"&nbsp;&nbsp;&nbsp;默认通知等级 :
                        <label class="radio-inline">
                            <input type="radio" value="0" name="data[commission_order_finish_notice]" <?php  if(empty($data['tm']['commission_order_finish_notice'])) { ?>checked=""<?php  } ?>> <?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>[默认]
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="1" name="data[commission_order_finish_notice]" <?php  if(strexists($data['tm']['commission_order_finish_notice'],'1')) { ?>checked=""<?php  } ?>><?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>+<?php echo empty($data['texts']['c2'])?'二级':$data['texts']['c2']?>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" value="2" name="data[commission_order_finish_notice]" <?php  if(strexists($data['tm']['commission_order_finish_notice'],'2')) { ?>checked=""<?php  } ?>><?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>+<?php echo empty($data['texts']['c2'])?'二级':$data['texts']['c2']?>+<?php echo empty($data['texts']['c3'])?'三级':$data['texts']['c3']?>
                        </label>
                    </div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['commission_order_finishtitle'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg control-label">内容</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <textarea  name="data[commission_order_finish]" class="form-control" rows="5"><?php  echo $data['tm']['commission_order_finish'];?></textarea>
                    <div class="help-block">模板变量 [下级昵称] [订单编号] [订单金额] [商品详情] [佣金金额] [时间] [下线层级]</div>
                    <div class="help-block">注意: 此 [佣金金额] ，不代表上级用户会立即获得，为可能获得的佣金金额</div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['commission_order_finish'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group is_sms">
                <label class="col-lg control-label">短信提醒</label>
                <div class="col-sm-9 col-xs-12">
                    <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_order_finish_sms]"<?php  } else { ?>disabled<?php  } ?>>>
                    <option value=''>从短信消息库中选择</option>
                    <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                    <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_order_finish_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                    <?php  } } ?>
                    </select>
                </div>
            </div>

            <div class="form-group-title">提现申请提交通知</div>

            <div class="form-group">
                <label class="col-lg control-label">标题</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <input type="text" name="data[commission_applytitle]" class="form-control" value="<?php  echo $data['tm']['commission_applytitle'];?>" />
                    <div class="help-block">标题，默认"您的提现申请已经提交"</div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['commission_applytitle'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg control-label">内容</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <textarea  name="data[commission_apply]" class="form-control" rows="5"><?php  echo $data['tm']['commission_apply'];?></textarea>
                    模板变量 [昵称] [时间] [金额] [提现方式]
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['commission_apply'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group is_sms">
                <label class="col-lg control-label">短信提醒</label>
                <div class="col-sm-9 col-xs-12">
                    <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_apply_sms]"<?php  } else { ?>disabled<?php  } ?>>>
                    <option value=''>从短信消息库中选择</option>
                    <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                    <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_apply_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                    <?php  } } ?>
                    </select>
                </div>
            </div>

            <div class="form-group-title">提现申请审核完成通知</div>

            <div class="form-group">
                <label class="col-lg control-label">标题</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <input type="text" name="data[commission_checktitle]" class="form-control" value="<?php  echo $data['tm']['commission_checktitle'];?>" />
                    <div class="help-block">标题，默认"您的提现申请已完成审核"</div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['commission_checktitle'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg control-label">内容</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <textarea  name="data[commission_check]" class="form-control" rows="5"><?php  echo $data['tm']['commission_check'];?></textarea>
                    模板变量 [昵称] [提现方式]  [金额] [时间]
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['commission_check'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group is_sms">
                <label class="col-lg control-label">短信提醒</label>
                <div class="col-sm-9 col-xs-12">
                    <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_check_sms]"<?php  } else { ?>disabled<?php  } ?>>>
                    <option value=''>从短信消息库中选择</option>
                    <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                    <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_check_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                    <?php  } } ?>
                    </select>
                </div>
            </div>

            <div class="form-group-title">佣金打款通知</div>

            <div class="form-group">
                <label class="col-lg control-label">标题</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <input type="text" name="data[commission_paytitle]" class="form-control" value="<?php  echo $data['tm']['commission_paytitle'];?>" />
                    <div class="help-block">标题，默认"您的佣金已打款"</div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['commission_paytitle'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg control-label">内容</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <textarea  name="data[commission_pay]" class="form-control" rows="5"><?php  echo $data['tm']['commission_pay'];?></textarea>
                    模板变量 [昵称] [提现方式] [金额] [时间]
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['commission_pay'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group is_sms">
                <label class="col-lg control-label">短信提醒</label>
                <div class="col-sm-9 col-xs-12">
                    <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_pay_sms]"<?php  } else { ?>disabled<?php  } ?>>>
                    <option value=''>从短信消息库中选择</option>
                    <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                    <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_pay_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                    <?php  } } ?>
                    </select>
                </div>
            </div>

            <div class="form-group-title">分销商等级升级通知</div>

            <div class="form-group">
                <label class="col-lg control-label">标题</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <input type="text" name="data[commission_upgradetitle]" class="form-control" value="<?php  echo $data['tm']['commission_upgradetitle'];?>" />
                    <div class="help-block">标题，默认"恭喜您升级了"</div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['commission_upgradetitle'];?></div>
                    <?php  } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg control-label">内容</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.notice.edit')) { ?>
                    <textarea  name="data[commission_upgrade]" class="form-control" rows="5"><?php  echo $data['tm']['commission_upgrade'];?></textarea>
                    模板变量: [昵称] [旧等级]  [旧一级分销比例] [旧二级分销比例] [旧三级分销比例] [新等级] [新一级分销比例] [新二级分销比例] [新三级分销比例]  [时间]
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $data['tm']['commission_upgrade'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group is_sms">
                <label class="col-lg control-label">短信提醒</label>
                <div class="col-sm-9 col-xs-12">
                    <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_upgrade_sms]"<?php  } else { ?>disabled<?php  } ?>>>
                    <option value=''>从短信消息库中选择</option>
                    <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                    <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_upgrade_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                    <?php  } } ?>
                    </select>
                </div>
            </div>

        </div>

        <div id="advanced">

            <table class="table table-responsive">
                <thead style="background: #ededed">
                <th>卖家通知-分销商提现</th>
                <th class="w200">模板消息</th>
                <th class="w60 is_advanced"><!--<input class="js-switch small checkall" data-type="tpl-advanced" type="checkbox" />--></th>
                <th class="w200 is_sms">短信模板</th>
                <th class="w60 is_sms" style="text-align: right"><input class="js-switch small checkall" data-type="sms" type="checkbox" /></th>
                <th style="width:350px">默认通知等级</th>
                </thead>
                <tbody>

                <tr>
                    <td>分销商提现通知</td>

                    <td>
                        <select class="select2"<?php if(cv('commission.notice.edit')) { ?>name="data[commission_applymoney_advanced]"<?php  } else { ?>disabled<?php  } ?>>
                        <option value=''>[默认]分销商提现通知</option>
                        <?php  if(is_array($template_list['commission_applymoney'])) { foreach($template_list['commission_applymoney'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_applymoney_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                        </select>
                    </td>
                    <td style="text-align: right;" class="is_advanced">
                        <label class="notice-default">
                            <input type="hidden" name="data[commission_applymoney_notice]" value="<?php  echo intval($data['tm']['commission_applymoney_notice'])?>" />
                            <input class="js-switch small checkone" data-type="tpl-advanced"   data-tag="commission_applymoney" type="checkbox" value="<?php  echo intval($data['tm']['commission_applymoney_notice'])?>" <?php  if(empty($data['tm']['commission_applymoney_notice'])) { ?>checked<?php  } ?>/>
                        </label>
                        <label style="display: none;">
                            <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt="" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                        </label>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">选择通知人-<br/>分销商提现通知</td>
                    <td colspan="<?php  if(!empty($salers)) { ?>4<?php  } else { ?>2<?php  } ?>" class="colstd">
                        <?php  echo tpl_selector('openids1',array('key'=>'openid','text'=>'nickname', 'thumb'=>'avatar','multi'=>1,'placeholder'=>'昵称/姓名/手机号','buttontext'=>'选择通知人', 'items'=>$salers1,'url'=>webUrl('member/query') ))?>
                        <span class='help-block'>分销商提现通知后以模板消息的方式商家通知，可以指定多个人，如果不填写则不通知</span>
                    </td>
                </tr>


                </tbody>
            </table>

            <div class="form-group splitter"></div>




            <table class="table table-responsive">
                <thead style="background: #ededed">
                    <th>买家通知-成为分销商</th>
                    <th class="w200">模板消息</th>
                    <th class="w60 is_advanced"><!--<input class="js-switch small checkall" data-type="tpl-advanced" type="checkbox" />--></th>
                    <th class="w200 is_sms">短信模板</th>
                    <th class="w60 is_sms" style="text-align: right"><input class="js-switch small checkall" data-type="sms" type="checkbox" /></th>
                    <th style="width:350px">默认通知等级</th>
                </thead>
                <tbody>
                <tr>
                    <td>成为分销商通知</td>
                    <td>
                        <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_become_advanced]"<?php  } else { ?>disabled<?php  } ?>>
                        <option value=''>[默认]成为分销商通知</option>
                        <?php  if(is_array($template_list['commission_become'])) { foreach($template_list['commission_become'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_become_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                        </select>
                    </td>
                    <td style="text-align: right;" class="is_advanced">
                        <label class="notice-default">
                            <input type="hidden" name="data[commission_become_close_advanced]" value="<?php  echo intval($data['tm']['commission_become_close_advanced'])?>" />
                            <input class="js-switch small checkone" data-type="tpl-advanced"   data-tag="commission_become" type="checkbox" value="<?php  echo intval($data['tm']['commission_become_close_advanced'])?>" <?php  if(empty($data['tm']['commission_become_close_advanced'])) { ?>checked<?php  } ?>/>
                        </label>
                        <label style="display: none;">
                            <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt="" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                        </label>
                    </td>
                    <!--<td class="is_sms">-->
                        <!--<select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_become_sms_advanced]"<?php  } else { ?>disabled<?php  } ?>>-->
                        <!--<option value=''>从短信消息库中选择</option>-->
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <!--<option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_become_sms_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>-->
                        <?php  } } ?>
                        <!--</select>-->
                    <!--</td>-->
                    <!--<td style="text-align: right;" class="is_sms">-->
                        <!--<input type="hidden" name="data[carrier_close_sms]" value="<?php  echo intval($data['carrier_close_sms'])?>" />-->
                        <!--<input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['carrier_close_sms'])?>" <?php  if(empty($data['carrier_close_sms'])) { ?>checked<?php  } ?>/>-->
                    <!--</td>-->
                </tr>
                <tr>

                    <td>新增下级通知</td>
                    <td>
                        <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_agent_new_advanced]"<?php  } else { ?>disabled<?php  } ?>>
                        <option value=''>[默认]新增下级通知</option>
                        <?php  if(is_array($template_list['commission_agent_new'])) { foreach($template_list['commission_agent_new'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_agent_new_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                        </select>
                    </td>
                    <td style="text-align: right;" class="is_advanced">
                        <label class="notice-default">
                            <input type="hidden" name="data[commission_agent_new_close_advanced]" value="<?php  echo intval($data['tm']['commission_agent_new_close_advanced'])?>" />
                            <input class="js-switch small checkone" data-type="tpl-advanced"   data-tag="commission_agent_new" type="checkbox" value="<?php  echo intval($data['tm']['commission_agent_new_close_advanced'])?>" <?php  if(empty($data['tm']['commission_agent_new_close_advanced'])) { ?>checked<?php  } ?>/>
                        </label>
                        <label style="display: none;">
                            <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt="" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                        </label>
                    </td>
                    <td class="is_sms">
                        <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_agent_new_sms_advanced]"<?php  } else { ?>disabled<?php  } ?>>
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_agent_new_sms_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                        </select>
                         </td>
                    <td style="text-align: right;" class="is_sms">
                        <input type="hidden" name="data[carrier_close_sms]" value="<?php  echo intval($data['carrier_close_sms'])?>" />
                        <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['carrier_close_sms'])?>" <?php  if(empty($data['carrier_close_sms'])) { ?>checked<?php  } ?>/>
                    </td>
                    <td>
                        <label class="radio-inline"><input type="radio" value="0" name="data[commission_agent_new_advanced_notice]" <?php  if(empty($data['tm']['commission_agent_new_advanced_notice'])) { ?>checked=""<?php  } ?>> <?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>[默认]</label>
                        <label class="radio-inline"><input type="radio" value="1" name="data[commission_agent_new_advanced_notice]" <?php  if(strexists($data['tm']['commission_agent_new_advanced_notice'],'1')) { ?>checked=""<?php  } ?>> <?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>+<?php echo empty($data['texts']['c2'])?'二级':$data['texts']['c2']?></label>
                        <label class="radio-inline"><input type="radio" value="2" name="data[commission_agent_new_advanced_notice]" <?php  if(strexists($data['tm']['commission_agent_new_advanced_notice'],'2')) { ?>checked=""<?php  } ?>> <?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>+<?php echo empty($data['texts']['c2'])?'二级':$data['texts']['c2']?>+<?php echo empty($data['texts']['c3'])?'三级':$data['texts']['c3']?></label>
                    </td>
                </tr>
                </tbody>
             </table>

            <div class="form-group splitter"></div>

            <table class="table table-responsive">
                <thead style="background: #ededed">
                <th>买家通知-下级通知</th>
                <th class="w200">模板消息</th>
                <th class="w60 is_advanced"><!--<input class="js-switch small checkall" data-type="tpl-advanced" type="checkbox" />--></th>
                <th class="w200 is_sms">短信模板</th>
                <th class="w60 is_sms" style="text-align: right"><input class="js-switch small checkall" data-type="sms" type="checkbox" /></th>
                <th style="width:350px">默认通知等级</th>
                </thead>
                <tbody>
                <tr>
                    <td>下级付款通知</td>
                    <td>
                        <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_order_pay_advanced]"<?php  } else { ?>disabled<?php  } ?>>
                        <option value=''>[默认]下级付款通知</option>
                        <?php  if(is_array($template_list['commission_order_pay'])) { foreach($template_list['commission_order_pay'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_order_pay_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                        </select>
                    </td>
                    <td style="text-align: right;" class="is_advanced">
                        <label class="notice-default">
                            <input type="hidden" name="data[commission_order_pay_close_advanced]" value="<?php  echo intval($data['tm']['commission_order_pay_close_advanced'])?>" />
                            <input class="js-switch small checkone" data-type="tpl-advanced"   data-tag="commission_order_pay" type="checkbox" value="<?php  echo intval($data['tm']['commission_order_pay_close_advanced'])?>" <?php  if(empty($data['tm']['commission_order_pay_close_advanced'])) { ?>checked<?php  } ?>/>
                        </label>
                        <label style="display: none;">
                            <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt="" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                        </label>
                    </td>
                    <td class="is_sms">
                        <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_order_pay_sms_advanced]"<?php  } else { ?>disabled<?php  } ?>>
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_order_pay_sms_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                        </select>
                    </td>
                    <td style="text-align: right;" class="is_sms">
                        <input type="hidden" name="data[carrier_close_sms]" value="<?php  echo intval($data['carrier_close_sms'])?>" />
                        <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['carrier_close_sms'])?>" <?php  if(empty($data['carrier_close_sms'])) { ?>checked<?php  } ?>/>
                    </td>
                    <td>
                        <label class="radio-inline"><input type="radio" value="0" name="data[commission_order_pay_advanced_notice]" <?php  if(empty($data['tm']['commission_order_pay_advanced_notice'])) { ?>checked=""<?php  } ?>> <?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>[默认]</label>
                        <label class="radio-inline"><input type="radio" value="1" name="data[commission_order_pay_advanced_notice]" <?php  if(strexists($data['tm']['commission_order_pay_advanced_notice'],'1')) { ?>checked=""<?php  } ?>> <?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>+<?php echo empty($data['texts']['c2'])?'二级':$data['texts']['c2']?></label>
                        <label class="radio-inline"><input type="radio" value="2" name="data[commission_order_pay_advanced_notice]" <?php  if(strexists($data['tm']['commission_order_pay_advanced_notice'],'2')) { ?>checked=""<?php  } ?>> <?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>+<?php echo empty($data['texts']['c2'])?'二级':$data['texts']['c2']?>+<?php echo empty($data['texts']['c3'])?'三级':$data['texts']['c3']?></label>
                    </td>
                </tr>
                <tr>
                    <td>下级确认收货通知</td>
                    <td>
                        <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_order_finish_advanced]"<?php  } else { ?>disabled<?php  } ?>>
                        <option value=''>[默认]下级确认收货通知</option>
                        <?php  if(is_array($template_list['commission_order_finish'])) { foreach($template_list['commission_order_finish'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_order_finish_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                        </select>
                    </td>
                    <td style="text-align: right;" class="is_advanced">
                        <label class="notice-default">
                            <input type="hidden" name="data[commission_order_finish_close_advanced]" value="<?php  echo intval($data['tm']['commission_order_finish_close_advanced'])?>" />
                            <input class="js-switch small checkone" data-type="tpl-advanced"   data-tag="commission_order_finish" type="checkbox" value="<?php  echo intval($data['tm']['commission_order_finish_close_advanced'])?>" <?php  if(empty($data['tm']['commission_order_finish_close_advanced'])) { ?>checked<?php  } ?>/>
                        </label>
                        <label style="display: none;">
                            <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt="" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                        </label>
                    </td>
                    <td class="is_sms">
                        <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_order_finish_sms_advanced]"<?php  } else { ?>disabled<?php  } ?>>
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_order_finish_sms_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                        </select>
                    </td>
                    <td style="text-align: right;" class="is_sms">
                        <input type="hidden" name="data[carrier_close_sms]" value="<?php  echo intval($data['carrier_close_sms'])?>" />
                        <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['carrier_close_sms'])?>" <?php  if(empty($data['carrier_close_sms'])) { ?>checked<?php  } ?>/>
                    </td>
                    <td>
                        <label class="radio-inline"><input type="radio" value="0" name="data[commission_order_finish_advanced_notice]" <?php  if(empty($data['tm']['commission_order_finish_advanced_notice'])) { ?>checked=""<?php  } ?>> <?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>[默认]</label>
                        <label class="radio-inline"><input type="radio" value="1" name="data[commission_order_finish_advanced_notice]" <?php  if(strexists($data['tm']['commission_order_finish_advanced_notice'],'1')) { ?>checked=""<?php  } ?>><?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>+<?php echo empty($data['texts']['c2'])?'二级':$data['texts']['c2']?></label>
                        <label class="radio-inline"><input type="radio" value="2" name="data[commission_order_finish_advanced_notice]" <?php  if(strexists($data['tm']['commission_order_finish_advanced_notice'],'2')) { ?>checked=""<?php  } ?>><?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>+<?php echo empty($data['texts']['c2'])?'二级':$data['texts']['c2']?>+<?php echo empty($data['texts']['c3'])?'三级':$data['texts']['c3']?></label>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="form-group splitter"></div>

            <table class="table table-responsive">
                <thead style="background: #ededed">
                <th>买家通知-提现通知</th>
                <th class="w200">模板消息</th>
                <th class="w60 is_advanced"><!--<input class="js-switch small checkall" data-type="tpl-advanced" type="checkbox" />--></th>
                <th class="is_sms">短信模板</th>
                <th class="w60 is_sms" style="text-align: right"><input class="js-switch small checkall" data-type="sms" type="checkbox" /></th>
                <th class="" style="width:350px"></th>
                </thead>
                <tbody>
                <tr>
                    <td>提现申请提交通知</td>
                    <td>
                        <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_apply_advanced]"<?php  } else { ?>disabled<?php  } ?>>
                        <option value=''>[默认]提现申请提交通知</option>
                        <?php  if(is_array($template_list['commission_apply'])) { foreach($template_list['commission_apply'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_apply_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                        </select>
                    </td>
                    <td style="text-align: right;" class="is_advanced">
                        <label class="notice-default">
                            <input type="hidden" name="data[commission_apply_close_advanced]" value="<?php  echo intval($data['tm']['commission_apply_close_advanced'])?>" />
                            <input class="js-switch small checkone" data-type="tpl-advanced"   data-tag="commission_apply" type="checkbox" value="<?php  echo intval($data['tm']['commission_apply_close_advanced'])?>" <?php  if(empty($data['tm']['commission_apply_close_advanced'])) { ?>checked<?php  } ?>/>
                        </label>
                        <label style="display: none;">
                            <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt="" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                        </label>
                    </td>
                    <td class="is_sms">
                        <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_apply_sms_advanced]"<?php  } else { ?>disabled<?php  } ?>>
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_apply_sms_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                        </select>
                    </td>
                    <td style="text-align: right;" class="is_sms">
                        <input type="hidden" name="data[carrier_close_sms]" value="<?php  echo intval($data['carrier_close_sms'])?>" />
                        <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['carrier_close_sms'])?>" <?php  if(empty($data['carrier_close_sms'])) { ?>checked<?php  } ?>/>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>提现申请审核完成通知</td>
                    <td>
                        <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_check_advanced]"<?php  } else { ?>disabled<?php  } ?>>
                        <option value=''>[默认]提现申请审核完成通知</option>
                        <?php  if(is_array($template_list['commission_check'])) { foreach($template_list['commission_check'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_check_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                        </select>
                    </td>
                    <td style="text-align: right;" class="is_advanced">
                        <label class="notice-default">
                            <input type="hidden" name="data[commission_check_close_advanced]" value="<?php  echo intval($data['tm']['commission_check_close_advanced'])?>" />
                            <input class="js-switch small checkone" data-type="tpl-advanced"   data-tag="commission_check" type="checkbox" value="<?php  echo intval($data['tm']['commission_check_close_advanced'])?>" <?php  if(empty($data['tm']['commission_check_close_advanced'])) { ?>checked<?php  } ?>/>
                        </label>
                        <label style="display: none;">
                            <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt="" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                        </label>
                    </td>
                    <td class="is_sms">
                        <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_check_sms_advanced]"<?php  } else { ?>disabled<?php  } ?>>
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_check_sms_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                        </select>
                    </td>
                    <td style="text-align: right;" class="is_sms">
                        <input type="hidden" name="data[carrier_close_sms]" value="<?php  echo intval($data['carrier_close_sms'])?>" />
                        <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['carrier_close_sms'])?>" <?php  if(empty($data['carrier_close_sms'])) { ?>checked<?php  } ?>/>
                    </td>
                    <td></td>
                </tr>
                </tbody>
            </table>

            <div class="form-group splitter"></div>

            <table class="table table-responsive">
                <thead style="background: #ededed">
                <th>买家通知-佣金通知</th>
                <th class="w200">模板消息</th>
                <th class="w60 is_advanced"><!--<input class="js-switch small checkall" data-type="tpl-advanced" type="checkbox" />--></th>
                <th class="is_sms">短信模板</th>
                <th class="w60 is_sms" style="text-align: right"><input class="js-switch small checkall" data-type="sms" type="checkbox" /></th>
                <th class="" style="width:350px"></th>
                </thead>
                <tbody>
                <tr>
                    <td>佣金打款通知</td>
                    <td>
                        <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_pay_advanced]"<?php  } else { ?>disabled<?php  } ?>>
                        <option value=''>[默认]佣金打款通知</option>
                        <?php  if(is_array($template_list['commission_pay'])) { foreach($template_list['commission_pay'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_pay_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                        </select>
                    </td>
                    <td style="text-align: right;" class="is_advanced">
                        <label class="notice-default">
                            <input type="hidden" name="data[commission_pay_close_advanced]" value="<?php  echo intval($data['tm']['commission_pay_close_advanced'])?>" />
                            <input class="js-switch small checkone" data-type="tpl-advanced"   data-tag="commission_pay" type="checkbox" value="<?php  echo intval($data['tm']['commission_pay_close_advanced'])?>" <?php  if(empty($data['tm']['commission_pay_close_advanced'])) { ?>checked<?php  } ?>/>
                        </label>
                        <label style="display: none;">
                            <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt="" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                        </label>
                    </td>
                    <td class="is_sms">
                        <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_pay_sms_advanced]"<?php  } else { ?>disabled<?php  } ?>>
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_pay_sms_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                        </select>
                    </td>
                    <td style="text-align: right;" class="is_sms">
                        <input type="hidden" name="data[carrier_close_sms]" value="<?php  echo intval($data['carrier_close_sms'])?>" />
                        <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['carrier_close_sms'])?>" <?php  if(empty($data['carrier_close_sms'])) { ?>checked<?php  } ?>/>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>分销商等级升级通知</td>
                    <td>
                        <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_upgrade_advanced]"<?php  } else { ?>disabled<?php  } ?>>
                        <option value=''>[默认]分销商等级升级通知</option>
                        <?php  if(is_array($template_list['commission_upgrade'])) { foreach($template_list['commission_upgrade'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_upgrade_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                        </select>
                    </td>
                    <td style="text-align: right;" class="is_advanced">
                        <label class="notice-default">
                            <input type="hidden" name="data[commission_upgrade_close_advanced]" value="<?php  echo intval($data['tm']['commission_upgrade_close_advanced'])?>" />
                            <input class="js-switch small checkone" data-type="tpl-advanced"   data-tag="commission_upgrade" type="checkbox" value="<?php  echo intval($data['tm']['commission_upgrade_close_advanced'])?>" <?php  if(empty($data['tm']['commission_upgrade_close_advanced'])) { ?>checked<?php  } ?>/>
                        </label>
                        <label style="display: none;">
                            <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt="" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                        </label>
                    </td>
                    <td class="is_sms">
                        <select class="select2" <?php if(cv('commission.notice.edit')) { ?>name="data[commission_upgrade_sms_advanced]"<?php  } else { ?>disabled<?php  } ?>>
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['tm']['commission_upgrade_sms_advanced'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                        </select>
                    </td>
                    <td style="text-align: right;" class="is_sms">
                        <input type="hidden" name="data[carrier_close_sms]" value="<?php  echo intval($data['carrier_close_sms'])?>" />
                        <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['carrier_close_sms'])?>" <?php  if(empty($data['carrier_close_sms'])) { ?>checked<?php  } ?>/>
                    </td>
                    <td></td>
                </tr>
                </tbody>
            </table>



        </div>
    <div class="form-group splitter"></div>
    <?php if(cv('commission.notice.edit')) { ?>
    <div class="form-group">
        <div class="col-sm-12 col-xs-12">
            <input type="submit" value="提交" class="btn btn-primary" />
        </div>
    </div>
    <?php  } ?>
    </form>
    </div>
<script>
    $(function () {

        $(".advanced").click(function(){
            $(":input[name='data[is_advanced]']").val( this.checked ?1:0);
            var next = $(this).next();
            if(next.hasClass('checked')){
                $("#advanced,#advanced_alert").show();
                $("#normal,#normal_alert").hide();
            }else{
                $("#advanced,#advanced_alert").hide();
                $("#normal,#normal_alert").show();
            }
        });

        $(".js-switch").click(function () {
            var next = $(this).next();
            if(next.hasClass('checked')){
                $(this).val("1").prev().val("0");
            }else{
                $(this).val("0").prev().val("1");
            }
            return false;
        });

        if($(":input[name='data[is_advanced]']").val() == 1)
        {
            $("#advanced,#advanced_alert").show();
            $("#normal,#normal_alert").hide();
        }
        else
        {
            $("#advanced,#advanced_alert").hide();
            $("#normal,#normal_alert").show();
        }

        //开启通知
        $(".checkone").click(function () {
            var _this =$(this);
            var type = _this.data('type');
            var val = _this.val();

            var tag = _this.data('tag');
            var stop = _this.data('stop');

            if(stop==1)
            {
                return;
            }

            //判断是否开启模板通知
            if(tag != '' && val==1&&type=='tpl-advanced') {
                $(this).data('stop', 1);
                $(this).parent().hide().next().show();

                var data = {
                    'tag': tag,
                    checked:val
                };

                //申请微信模板,并将模板ID更新至数据库.
                $.ajax({
                    url: "<?php  echo webUrl('sysset/settemplateid')?>",
                    type:'get',
                    dataType:'json',
                    timeout : 3000, //超时时间设置，单位毫秒
                    data:data,
                    success:function(ret){
                        var _this = $(".checkone[data-tag='"+ret.result.tag+"']");
                        if (ret.result.status == '0') {
                            this.value=0;
                            _this.prev().val(1);
                            _this.next().removeClass('checked');

                            console.log(ret.result.messages);
                            alert(ret.result.messages);
                        }

                        $(_this).data('stop', 0);
                        $(_this).parent().show().next().hide();
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $(".table").each(function () {
                            var _this = $(this);
                            _this.find(".checkone[data-type='tpl-advanced']").each(function () {
                                $(this).data('stop', 0);
                                $(this).parent().show().next().hide();
                            });
                        });
                    }
                });
            }


            var type = $(this).data('type');
            var val = $(this).val();
            if(val==0){
                $(this).attr("checked","false").val("1").next().removeClass("checked");
                $(this).closest(".table").find(".checkall[data-type='"+type+"']").val("1").attr("checked","false").next().removeClass("checked");
            }else{
                $(this).attr("checked","true").val("0").next().addClass("checked");
                var all = true;
                $(this).closest(".table").find(".checkone[data-type='"+type+"']").each(function () {
                    var val = $(this).val();
                    if(val!='on' && val==1){
                        all = false;
                        return;
                    }
                });
                if(all){
                    $(this).closest(".table").find(".checkall[data-type='"+type+"']").val("0").attr("checked","true").next().addClass("checked");
                }
            }
        });

        $(".table").each(function () {
            var _this = $(this);
            var all_tpl_normal = true;
            var all_tpl_advanced = true;
            var all_sms = true;
            _this.find(".checkone[data-type='tpl-advanced']").each(function () {
                var val = $(this).val();
                if(val!='on' && val==1){
                    all_tpl_advanced = false;
                    return;
                }
            });
            _this.find(".checkone[data-type='sms']").each(function () {
                var val = $(this).val();
                if(val!='on' && val==1){
                    all_sms = false;
                    return;
                }
            });
            if(all_tpl_normal){
                _this.find(".checkall[data-type='tpl-normal']").val("0").attr("checked","true").next().addClass("checked");
            }
            if(all_tpl_advanced){
                _this.find(".checkall[data-type='tpl-advanced']").val("0").attr("checked","true").next().addClass("checked");
            }
            if(all_sms){
                _this.find(".checkall[data-type='sms']").val("0").attr("checked","true").next().addClass("checked");
            }
        });
    })
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>