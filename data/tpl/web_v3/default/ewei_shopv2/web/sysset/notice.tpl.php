<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .select2 {width: 100%;}
    .form-horizontal .form-group {margin-left: 0; margin-right: 0;}
    .table > thead > tr > th {border:none;}
    .is_advanced {display: table-block;}
    #openids_selector .input-group {width: 100%;}
    #openids2_selector .input-group {width: 100%;}
    .is_sms {display: <?php  if(!empty($opensms)) { ?>table-block<?php  } else { ?>none<?php  } ?>;}
</style>

<div class="page-header">
    当前位置：<span class="text-primary">消息提醒设置</span>
</div>

<div class="page-content">
    <div class="alert alert-warning">
        <h3>注意：</h3>
        <p>请将公众平台模板消息所在行业选择为：<b> IT科技/互联网|电子商务 其他|其他</b>，所选行业不一致将会导致模板消息不可用。</p>
        <p>点击模板消息后方的开关按钮<img src="../addons/ewei_shopv2/static/images/on-off.png"  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'"  />即可<b>开启模板消息</b>，无需进行额外设置。</p>
        <p>如需进行消息推送<b>个性化消息</b>，<a href="<?php  echo webUrl('sysset/tmessage')?>" title="模板消息库">点击进入自定义消息库</a><?php  if($opensms) { ?>，<a href="<?php  echo webUrl('sysset/sms')?>" title="短信消息库">点击进入短信消息库</a><?php  } ?></p>
        <p>当您的卖家通知人超过5人时，建议您开启消息通知列队。</p>
    </div>

    <form action="" method="post" class="form-horizontal  form-validate" enctype="multipart/form-data" >

        <table class="table table-responsive">
            <thead style="background: #eee;">
            <th style="width: 150px; color: #333;">卖家通知</th>
            <th style="color: #333;">模板消息</th>
            <th style="width: 50px;color: #333;"></th>
            <?php  if(!empty($opensms)) { ?>
            <th style="color: #333;">短信模板</th>
            <th width="50px;color: #333;"></th>
            <?php  } ?>
            </thead>
            <tbody>
            <tr>
                <td>订单付款通知</td>
                <td>
                    <select class="select2 is_advanced" name="data[saler_pay_template]">
                        <option value=''>[默认]订单付款通知</option>
                        <?php  if(is_array($template_group['saler_pay'])) { foreach($template_group['saler_pay'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['saler_pay_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[saler_pay_close_advanced]" value="<?php  echo intval($data['saler_pay_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="saler_pay"  type="checkbox"   value="<?php  echo intval($data['saler_pay_close_advanced'])?>" <?php  if(empty($data['saler_pay_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[saler_pay_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['saler_pay_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[saler_pay_close_sms]" value="<?php  echo intval($data['saler_pay_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['saler_pay_close_sms'])?>" <?php  if(empty($data['saler_pay_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">选择通知人-<br/>订单付款通知</td>
                <td colspan="<?php  if(!empty($opensms)) { ?>4<?php  } else { ?>2<?php  } ?>" class="colstd">
                    <?php  echo tpl_selector('openids',array('key'=>'openid','text'=>'nickname', 'thumb'=>'avatar','multi'=>1,'placeholder'=>'昵称/姓名/手机号','buttontext'=>'选择通知人', 'items'=>$salers,'url'=>webUrl('member/query') ))?>
                    <span class='help-block'>订单生成后以模板消息的方式商家通知，可以指定多个人，如果不填写则不通知</span>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">填写通知人-<br/>订单付款短信</td>
                <td colspan="<?php  if(!empty($opensms)) { ?>4<?php  } else { ?>2<?php  } ?>" class="colstd">
                    <textarea class="form-control" name="data[mobile]" style="resize: none; padding: 6px;" rows="3"><?php  echo $data['mobile'];?></textarea>
                    <span class='help-block'>订单生成后以短信的方式商家通知，如果不填写则不通知(11位手机号，多个请以英文逗号隔开)</span>
                </td>
            </tr>
            <tr>
                <td>订单收货通知</td>
                <td>
                    <select class="select2 is_advanced" name="data[saler_finish_template]">
                        <option value=''>[默认]订单收货通知</option>
                        <?php  if(is_array($template_group['saler_finish'])) { foreach($template_group['saler_finish'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['saler_finish_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[saler_finish_close_advanced]" value="<?php  echo intval($data['saler_finish_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="saler_finish"  type="checkbox"   value="<?php  echo intval($data['saler_finish_close_advanced'])?>" <?php  if(empty($data['saler_finish_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt="" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[saler_finish_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['saler_finish_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[saler_finish_close_sms]" value="<?php  echo intval($data['saler_finish_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['saler_finish_close_sms'])?>" <?php  if(empty($data['saler_finish_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">选择通知人-<br/>订单收货通知</td>
                <td colspan="<?php  if(!empty($opensms)) { ?>4<?php  } else { ?>2<?php  } ?>" class="colstd">
                    <?php  echo tpl_selector('openids2',array('key'=>'openid','text'=>'nickname', 'thumb'=>'avatar','multi'=>1,'placeholder'=>'昵称/姓名/手机号','buttontext'=>'选择通知人', 'items'=>$salers2,'url'=>webUrl('member/query') ))?>
                    <span class='help-block'>订单收货后以模板消息的方式商家通知，可以指定多个人，如果不填写则不通知</span>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">填写通知人-<br/>订单收货短信</td>
                <td colspan="<?php  if(!empty($opensms)) { ?>4<?php  } else { ?>2<?php  } ?>" class="colstd">
                    <textarea class="form-control" name="data[mobile2]" style="resize: none; padding: 6px;" rows="3"><?php  echo $data['mobile2'];?></textarea>
                    <span class='help-block'>订单收货后以短信的方式商家通知，如果不填写则不通知(11位手机号，多个请以英文逗号隔开)</span>
                </td>
            </tr>
            <tr>
                <td>库存预警通知</td>
                <td>
                    <select class="select2 is_advanced" name="data[saler_stockwarn_template]">
                        <option value=''>[默认]库存预警通知</option>
                        <?php  if(is_array($template_group['saler_stockwarn'])) { foreach($template_group['saler_stockwarn'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['saler_stockwarn_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[saler_stockwarn_close_advanced]" value="<?php  echo intval($data['saler_stockwarn_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="saler_stockwarn"  type="checkbox"   value="<?php  echo intval($data['saler_stockwarn_close_advanced'])?>" <?php  if(empty($data['saler_stockwarn_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""/>
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[saler_stockwarn_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['saler_stockwarn_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[saler_stockwarn_close_sms]" value="<?php  echo intval($data['saler_stockwarn_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['saler_stockwarn_close_sms'])?>" <?php  if(empty($data['saler_stockwarn_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">选择通知人-<br/>库存预警通知</td>
                <td colspan="<?php  if(!empty($opensms)) { ?>4<?php  } else { ?>2<?php  } ?>" class="colstd">
                    <?php  echo tpl_selector('openids3',array('key'=>'openid','text'=>'nickname', 'thumb'=>'avatar','multi'=>1,'placeholder'=>'昵称/姓名/手机号','buttontext'=>'选择通知人', 'items'=>$salers3,'url'=>webUrl('member/query') ))?>
                    <span class='help-block'>商品库存不足时以模板消息的方式商家通知，可以指定多个人，如果不填写则不通知</span>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">填写通知人-<br/>库存预警通知</td>
                <td colspan="<?php  if(!empty($opensms)) { ?>4<?php  } else { ?>2<?php  } ?>" class="colstd">
                    <textarea class="form-control" name="data[mobile3]" style="resize: none; padding: 6px;" rows="3"><?php  echo $data['mobile3'];?></textarea>
                    <span class='help-block'>订单收货后以短信的方式商家通知，如果不填写则不通知(11位手机号，多个请以英文逗号隔开)</span>
                </td>
            </tr>








            <tr>
                <td>维权订单通知</td>
                <td>
                    <select class="select2 is_advanced" name="data[saler_refund_template]">
                        <option value=''>[默认]]维权订单通知</option>
                            <?php  if(is_array($template_group['saler_refund'])) { foreach($template_group['saler_refund'] as $template_val) { ?>
                                <option value="<?php  echo $template_val['id'];?>" <?php  if($data['saler_refund_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                            <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[saler_refund_close_advanced]" value="<?php  echo intval($data['saler_refund_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="saler_refund"  type="checkbox"   value="<?php  echo intval($data['saler_refund_close_advanced'])?>" <?php  if(empty($data['saler_refund_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[saler_refund_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['saler_refund_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[saler_refund_close_sms]" value="<?php  echo intval($data['saler_refund_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['saler_refund_close_sms'])?>" <?php  if(empty($data['saler_refund_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
           <tr>
                <td style="vertical-align: top;">选择通知人-<br/>维权订单通知</td>
                <td colspan="<?php  if(!empty($opensms)) { ?>4<?php  } else { ?>2<?php  } ?>" class="colstd">
                    <?php  echo tpl_selector('openids4',array('key'=>'openid','text'=>'nickname', 'thumb'=>'avatar','multi'=>1,'placeholder'=>'昵称/姓名/手机号','buttontext'=>'选择通知人', 'items'=>$salers4,'url'=>webUrl('member/query') ))?>
                    <span class='help-block'>客户申请维权后以模板消息的方式商家通知，可以指定多个人，如果不填写则不通知</span>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">填写通知人-<br/>维权订单短信</td>
                <td colspan="<?php  if(!empty($opensms)) { ?>4<?php  } else { ?>2<?php  } ?>" class="colstd">
                    <textarea class="form-control" name="data[mobile4]" style="resize: none; padding: 6px;" rows="3"><?php  echo $data['mobile4'];?></textarea>
                    <span class='help-block'>客户申请维权后以短信的方式商家通知，如果不填写则不通知(11位手机号，多个请以英文逗号隔开)</span>
                </td>
            </tr>












            <tr>
                <td>商品付款通知</td>
                <td>
                    <select class="select2 is_advanced" name="data[saler_goodpay_template]">
                        <option value=''>[默认]商品付款通知</option>
                        <?php  if(is_array($template_group['saler_goodpay'])) { foreach($template_group['saler_goodpay'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['saler_goodpay_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[saler_goodpay_close_advanced]" value="<?php  echo intval($data['saler_goodpay_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="saler_goodpay"  type="checkbox"   value="<?php  echo intval($data['saler_goodpay_close_advanced'])?>" <?php  if(empty($data['saler_goodpay_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt="" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[saler_goodpay_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['saler_goodpay_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[saler_goodpay_close_sms]" value="<?php  echo intval($data['saler_goodpay_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['saler_goodpay_close_sms'])?>" <?php  if(empty($data['saler_goodpay_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="form-group splitter"></div>

        <table class="table table-responsive">
            <thead class="send-mess" >
            <th>买家通知 - 订单通知</th>
            <th class="w200">模板消息</th>
            <th class="w60 is_advanced"><!--<input class="js-switch small checkall" data-type="tpl-advanced" type="checkbox" />--></th>
            <th class="w200 is_sms">短信模板</th>
            <th class="w60 is_sms" style="text-align: right"><input class="js-switch small checkall" data-type="sms" type="checkbox" /></th>
            </thead>
            <tbody>
            <tr>
                <td>自提订单提交成功通知</td>
                <td>
                    <select class="select2 is_advanced" name="data[carrier_template]">
                        <option value=''>[默认]自提订单提交成功通知</option>
                        <?php  if(is_array($template_group['carrier'])) { foreach($template_group['carrier'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['carrier_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[carrier_close_advanced]" value="<?php  echo intval($data['carrier_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced"   data-tag="carrier" type="checkbox" value="<?php  echo intval($data['carrier_close_advanced'])?>" <?php  if(empty($data['carrier_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt="" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[carrier_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['carrier_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[carrier_close_sms]" value="<?php  echo intval($data['carrier_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['carrier_close_sms'])?>" <?php  if(empty($data['carrier_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            <tr>
                <td>订单取消通知</td>
                <td>
                    <select class="select2 is_advanced" name="data[cancel_template]">
                        <option value=''>[默认]订单取消通知</option>
                        <?php  if(is_array($template_group['cancel'])) { foreach($template_group['cancel'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['cancel_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[cancel_close_advanced]" value="<?php  echo intval($data['cancel_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="cancel" type="checkbox" value="<?php  echo intval($data['cancel_close_advanced'])?>" <?php  if(empty($data['cancel_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt="" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[cancel_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['cancel_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[cancel_close_sms]" value="<?php  echo intval($data['cancel_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['cancel_close_sms'])?>" <?php  if(empty($data['cancel_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            <tr>
                <td>订单即将取消通知</td>
                <td>
                    <select class="select2 is_advanced" name="data[willcancel_template]">
                        <option value=''>[默认]订单即将取消通知</option>
                        <?php  if(is_array($template_group['willcancel'])) { foreach($template_group['willcancel'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['willcancel_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[willcancel_close_advanced]" value="<?php  echo intval($data['willcancel_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced" data-tag="willcancel" type="checkbox" value="<?php  echo intval($data['willcancel_close_advanced'])?>" <?php  if(empty($data['willcancel_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt="" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[willcancel_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['willcancel_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[willcancel_close_sms]" value="<?php  echo intval($data['willcancel_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['willcancel_close_sms'])?>" <?php  if(empty($data['willcancel_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            <tr>
                <td>订单支付成功通知</td>
                <td>
                    <select class="select2 is_advanced" name="data[pay_template]">
                        <option value=''>[默认]订单支付成功通知</option>
                        <?php  if(is_array($template_group['pay'])) { foreach($template_group['pay'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['pay_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[pay_close_advanced]" value="<?php  echo intval($data['pay_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced" data-tag="pay" type="checkbox" value="<?php  echo intval($data['pay_close_advanced'])?>" <?php  if(empty($data['pay_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt="" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[pay_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['pay_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[pay_close_sms]" value="<?php  echo intval($data['pay_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['pay_close_sms'])?>" <?php  if(empty($data['pay_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            <tr>
                <td>订单发货通知</td>
                <td>
                    <select class="select2 is_advanced" name="data[send_template]">
                        <option value=''>[默认]订单发货通知</option>
                        <?php  if(is_array($template_group['send'])) { foreach($template_group['send'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['send_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[send_close_advanced]" value="<?php  echo intval($data['send_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced" data-tag="send"  type="checkbox" value="<?php  echo intval($data['send_close_advanced'])?>" <?php  if(empty($data['send_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[send_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['send_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[send_close_sms]" value="<?php  echo intval($data['send_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['send_close_sms'])?>" <?php  if(empty($data['send_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            <tr>
                <td>自动发货通知<br>(虚拟物品及卡密)</td>
                <td>
                    <select class="select2 is_advanced" name="data[virtualsend_template]">
                        <option value=''>[默认]自动发货通知</option>
                        <?php  if(is_array($template_group['virtualsend'])) { foreach($template_group['virtualsend'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['virtualsend_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[virtualsend_close_advanced]" value="<?php  echo intval($data['virtualsend_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced" data-tag="virtualsend" type="checkbox" value="<?php  echo intval($data['virtualsend_close_advanced'])?>" <?php  if(empty($data['virtualsend_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[virtualsend_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['virtualsend_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[virtualsend_close_sms]" value="<?php  echo intval($data['virtualsend_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['virtualsend_close_sms'])?>" <?php  if(empty($data['virtualsend_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>

            <tr>
                <td>订单状态更新<br>(修改收货地址)(修改价格)</td>
                <td>
                    <select class="select2 is_advanced" name="data[orderstatus_template]">
                        <option value=''>[默认]订单状态更新</option>
                        <?php  if(is_array($template_group['orderstatus'])) { foreach($template_group['orderstatus'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['orderstatus_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[orderstatus_close_advanced]" value="<?php  echo intval($data['orderstatus_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced" data-tag="orderstatus" type="checkbox" value="<?php  echo intval($data['orderstatus_close_advanced'])?>" <?php  if(empty($data['orderstatus_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[orderstatus_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['orderstatus_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[orderstatus_close_sms]" value="<?php  echo intval($data['orderstatus_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['orderstatus_close_sms'])?>" <?php  if(empty($data['orderstatus_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="form-group splitter"></div>

        <table class="table table-responsive">
            <thead  class="send-mess" >
            <th>买家通知 - 退款通知</th>
            <th class="w200">模板消息</th>
            <th class="w60 is_advanced"><!--<input class="js-switch small checkall" data-type="tpl-advanced" type="checkbox" />--></th>
            <th class="w200 is_sms">短信模板</th>
            <th class="w60 is_sms" style="text-align: right"><input class="js-switch small checkall" data-type="sms" type="checkbox" /></th>
            </thead>
            <tbody>
            <tr>
                <td>退款成功通知</td>
                <td>
                    <select class="select2 is_advanced" name="data[refund1_template]">
                        <option value=''>[默认]退款成功通知</option>
                        <?php  if(is_array($template_group['refund1'])) { foreach($template_group['refund1'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['refund1_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[refund1_close_advanced]" value="<?php  echo intval($data['refund1_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced" data-tag="refund1"  type="checkbox" value="<?php  echo intval($data['refund1_close_advanced'])?>" <?php  if(empty($data['refund1_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[refund1_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['refund1_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[refund1_close_sms]" value="<?php  echo intval($data['refund1_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['refund1_close_sms'])?>" <?php  if(empty($data['refund1_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            <tr>
                <td>换货成功通知</td>
                <td>
                    <select class="select2 is_advanced" name="data[refund3_template]">
                        <option value=''>[默认]换货成功通知</option>
                        <?php  if(is_array($template_group['refund3'])) { foreach($template_group['refund3'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['refund3_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[refund3_close_advanced]" value="<?php  echo intval($data['refund3_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="refund3" type="checkbox" value="<?php  echo intval($data['refund3_close_advanced'])?>" <?php  if(empty($data['refund3_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[refund3_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['refund3_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[refund3_close_sms]" value="<?php  echo intval($data['refund3_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['refund3_close_sms'])?>" <?php  if(empty($data['refund3_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            <tr>
                <td>换货发货通知</td>
                <td>
                    <select class="select2 is_advanced" name="data[refund4_template]">
                        <option value=''>[默认]换货发货通知</option>
                        <?php  if(is_array($template_group['refund4'])) { foreach($template_group['refund4'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['refund4_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[refund4_close_advanced]" value="<?php  echo intval($data['refund4_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="refund4" type="checkbox" value="<?php  echo intval($data['refund4_close_advanced'])?>" <?php  if(empty($data['refund4_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[refund4_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['refund4_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[refund4_close_sms]" value="<?php  echo intval($data['refund4_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['refund4_close_sms'])?>" <?php  if(empty($data['refund4_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            <tr>
                <td>退款申请驳回通知</td>
                <td>
                    <select class="select2 is_advanced" name="data[refund2_template]">
                        <option value=''>[默认]退款申请驳回通知</option>
                        <?php  if(is_array($template_group['refund2'])) { foreach($template_group['refund2'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['refund2_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[refund2_close_advanced]" value="<?php  echo intval($data['refund2_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="refund2"  type="checkbox" value="<?php  echo intval($data['refund2_close_advanced'])?>" <?php  if(empty($data['refund2_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[refund2_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['refund2_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[refund2_close_sms]" value="<?php  echo intval($data['refund2_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['refund2_close_sms'])?>" <?php  if(empty($data['refund2_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="form-group splitter"></div>

        <table class="table table-responsive">
            <thead  class="send-mess" >
            <th>买家通知 - 支付通知</th>
            <th class="w200">模板消息</th>
            <th class="w60 is_advanced"><!--<input class="js-switch small checkall" data-type="tpl-advanced" type="checkbox" />--></th>
            <th class="w200 is_sms">短信模板</th>
            <th class="w60 is_sms" style="text-align: right"><input class="js-switch small checkall" data-type="sms" type="checkbox" /></th>
            </thead>
            <tbody>
            <tr>
                <td>充值成功通知</td>
                <td>
                    <select class="select2 is_advanced" name="data[recharge_ok_template]">
                        <option value=''>[默认]充值成功通知</option>
                        <?php  if(is_array($template_group['recharge_ok'])) { foreach($template_group['recharge_ok'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['recharge_ok_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[recharge_ok_close_advanced]" value="<?php  echo intval($data['recharge_ok_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="recharge_ok" type="checkbox" value="<?php  echo intval($data['recharge_ok_close_advanced'])?>" <?php  if(empty($data['recharge_ok_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[recharge_ok_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['recharge_ok_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[recharge_ok_close_sms]" value="<?php  echo intval($data['recharge_ok_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['recharge_ok_close_sms'])?>" <?php  if(empty($data['recharge_ok_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            <tr>
                <td>提现成功通知</td>
                <td>
                    <select class="select2 is_advanced" name="data[withdraw_ok_template]">
                        <option value=''>[默认]提现成功通知</option>
                        <?php  if(is_array($template_group['withdraw_ok'])) { foreach($template_group['withdraw_ok'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['withdraw_ok_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[withdraw_ok_close_advanced]" value="<?php  echo intval($data['withdraw_ok_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced" data-tag="withdraw_ok" type="checkbox" value="<?php  echo intval($data['withdraw_ok_close_advanced'])?>" <?php  if(empty($data['withdraw_ok_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[withdraw_ok_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['withdraw_ok_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[withdraw_ok_close_sms]" value="<?php  echo intval($data['withdraw_ok_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['withdraw_ok_close_sms'])?>" <?php  if(empty($data['withdraw_ok_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            <tr>
                <td>充值成功通知（后台管理员手动）</td>
                <td>
                    <select class="select2 is_advanced" name="data[backrecharge_ok_template]">
                        <option value=''>[默认]充值成功通知</option>
                        <?php  if(is_array($template_group['backrecharge_ok'])) { foreach($template_group['backrecharge_ok'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['backrecharge_ok_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[backrecharge_ok_close_advanced]" value="<?php  echo intval($data['backrecharge_ok_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="backrecharge_ok" type="checkbox" value="<?php  echo intval($data['backrecharge_ok_close_advanced'])?>" <?php  if(empty($data['backrecharge_ok_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[backrecharge_ok_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['backrecharge_ok_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[backrecharge_ok_close_sms]" value="<?php  echo intval($data['backrecharge_ok_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['backrecharge_ok_close_sms'])?>" <?php  if(empty($data['backrecharge_ok_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            <tr>
                <td>积分变动提醒</td>
                <td>
                    <select class="select2 is_advanced" name="data[backpoint_ok_template]">
                        <option value=''>[默认]积分变动提醒</option>
                        <?php  if(is_array($template_group['backpoint_ok'])) { foreach($template_group['backpoint_ok'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['backpoint_ok_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[backpoint_ok_close_advanced]" value="<?php  echo intval($data['backpoint_ok_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="backpoint_ok" type="checkbox" value="<?php  echo intval($data['backpoint_ok_close_advanced'])?>" <?php  if(empty($data['backpoint_ok_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[backpoint_ok_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['backpoint_ok_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[backpoint_ok_close_sms]" value="<?php  echo intval($data['backpoint_ok_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['backpoint_ok_close_sms'])?>" <?php  if(empty($data['backpoint_ok_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="form-group splitter"></div>

        <table class="table table-responsive">
            <thead  class="send-mess" >
            <th>买家通知 - 会员通知</th>

            <th class="w200">模板消息</th>
            <th class="w60 is_advanced"><!--<input class="js-switch small checkall" data-type="tpl-advanced" type="checkbox" />--></th>
            <th class="w200 is_sms">短信模板</th>
            <th class="w60 is_sms" style="text-align: right"><input class="js-switch small checkall" data-type="sms" type="checkbox" /></th>
            </thead>
            <tbody>
            <tr>
                <td>会员升级通知<br>(业务处理通知)</td>
                <td>
                    <select class="select2 is_advanced" name="data[upgrade_template]">
                        <option value=''>[默认]会员升级通知</option>
                        <?php  if(is_array($template_group['upgrade'])) { foreach($template_group['upgrade'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['upgrade_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[upgrade_close_advanced]" value="<?php  echo intval($data['upgrade_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="upgrade"  type="checkbox" value="<?php  echo intval($data['upgrade_close_advanced'])?>" <?php  if(empty($data['upgrade_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[upgrade_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['upgrade_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[upgrade_close_sms]" value="<?php  echo intval($data['upgrade_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['upgrade_close_sms'])?>" <?php  if(empty($data['upgrade_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="form-group splitter"></div>


        <table class="table table-responsive">
            <thead  class="send-mess" >
            <th>o2o - 门店店员通知</th>

            <th class="w200">模板消息</th>
            <th class="w60 is_advanced"><!--<input class="js-switch small checkall" data-type="tpl-advanced" type="checkbox" />--></th>
            <th class="w200 is_sms">短信模板</th>
            <th class="w60 is_sms" style="text-align: right"><input class="js-switch small checkall" data-type="sms" type="checkbox" /></th>
            </thead>
            <tbody>
            <tr>
                <td>记次时商品核销通知</td>
                <td>
                    <select class="select2 is_advanced" name="data[o2o_sverify_template]">
                        <option value=''>[默认]记次时商品核销通知</option>
                        <?php  if(is_array($template_group['o2o_sverify'])) { foreach($template_group['o2o_sverify'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['o2o_sverify_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[o2o_sverify_close_advanced]" value="<?php  echo intval($data['o2o_sverify_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="o2o_sverify"  type="checkbox" value="<?php  echo intval($data['o2o_sverify_close_advanced'])?>" <?php  if(empty($data['o2o_sverify_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[o2o_sverify_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['o2o_sverify_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[o2o_sverify_close_sms]" value="<?php  echo intval($data['o2o_sverify_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['o2o_sverify_close_sms'])?>" <?php  if(empty($data['o2o_sverify_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="form-group splitter"></div>


        <table class="table table-responsive">
            <thead  class="send-mess" >
            <th>o2o - 买家通知</th>

            <th class="w200">模板消息</th>
            <th class="w60 is_advanced"><!--<input class="js-switch small checkall" data-type="tpl-advanced" type="checkbox" />--></th>
            <th class="w200 is_sms">短信模板</th>
            <th class="w60 is_sms" style="text-align: right"><input class="js-switch small checkall" data-type="sms" type="checkbox" /></th>
            </thead>
            <tbody>
            <tr>
                <td>记次时商品核销通知</td>
                <td>
                    <select class="select2 is_advanced" name="data[o2o_bverify_template]">
                        <option value=''>[默认]记次时商品核销通知</option>
                        <?php  if(is_array($template_group['o2o_bverify'])) { foreach($template_group['o2o_bverify'] as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['o2o_bverify_template'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['title'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_advanced">
                    <label class="notice-default">
                        <input type="hidden" name="data[o2o_bverify_close_advanced]" value="<?php  echo intval($data['o2o_bverify_close_advanced'])?>" />
                        <input class="js-switch small checkone" data-type="tpl-advanced"  data-tag="o2o_bverify"  type="checkbox" value="<?php  echo intval($data['o2o_bverify_close_advanced'])?>" <?php  if(empty($data['o2o_bverify_close_advanced'])) { ?>checked<?php  } ?>/>
                    </label>
                    <label style="display: none;">
                        <img src="../addons/ewei_shopv2/static/images/loading.gif" width="20" alt=""  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" />
                    </label>
                </td>
                <td class="is_sms">
                    <select class="select2" name="data[o2o_bverify_sms]">
                        <option value=''>从短信消息库中选择</option>
                        <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                        <option value="<?php  echo $template_val['id'];?>" <?php  if($data['o2o_bverify_sms'] == $template_val['id'] ) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                        <?php  } } ?>
                    </select>
                </td>
                <td style="text-align: right;" class="is_sms">
                    <input type="hidden" name="data[o2o_bverify_close_sms]" value="<?php  echo intval($data['o2o_bverify_close_sms'])?>" />
                    <input class="js-switch small checkone" data-type="sms" type="checkbox" value="<?php  echo intval($data['o2o_bverify_close_sms'])?>" <?php  if(empty($data['o2o_bverify_close_sms'])) { ?>checked<?php  } ?>/>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="form-group splitter"></div>

        <div class="form-group">
            <div class="col-sm-12 col-xs-12" >
                <?php if(cv('sysset.notice.edit')) { ?>
                <input type="submit"  value="提交" class="btn btn-primary"  />

                <?php  } ?>
            </div>
        </div>
    </form>
</div>

<script>
    $(function () {
        $(".js-switch").not(".checkhi").click(function () {
            var next = $(this).next();
            if(next.hasClass('checked')){
                $(this).val("1").prev().val("0");
            }else{
                $(this).val("0").prev().val("1");
            }
        });

        $(".checkhi").click(function () {
            var trueval = $(this).prev().data('true');
            var falseval = $(this).prev().data('false');
            var next = $(this).next();
            if(next.hasClass('checked')){
                $(this).val("1").prev().val(trueval);
            }else{
                $(this).val("0").prev().val(falseval);
            }
        });

        $(".checkall").click(function () {
            var type = $(this).data('type');
            var val = $(this).val();
            if(val==0){
                $(this).closest(".table").find(".checkone[data-type='"+type+"']").attr("checked","false").val("1").next().removeClass("checked").prev().prev().val("1");
            }else{
                $(this).closest(".table").find(".checkone[data-type='"+type+"']").attr("checked","true").val("0").next().addClass("checked").prev().prev().val("0");
            }
        });

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