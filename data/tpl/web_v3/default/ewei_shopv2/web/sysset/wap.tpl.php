<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">当前位置：<span class="text-primary">全网通设置</span></div>

<div class="page-content">
    <div class="alert alert-primary">
        <p>说明:</p>
        <p>1. 不开启WAP只能在微信环境打开，开启WAP后可以从非微信浏览器打开(任何浏览器)，可用手机号码作为登录凭证</p>
        <p >2. 开启WAP后分享参数只在微信、QQ中生效，其他社交软件或浏览器转发将有可能不会确立下线</p>
        <p >3. 请认真配置下面的参数</p>
    </div>

    <form action="" method="post" class="form-horizontal form-validate" enctype="multipart/form-data">

        <div class="tabs-container">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a href="#tab_basic">基本设置</a></li>
                <li><a href="#tab_style">样式设置</a></li>
                <li><a href="#tab_sms">验证码短信模板</a></li>
                <?php  if(com('h5app')) { ?>
                <li><a href="#tab_login">APP登录设置</a></li>
                <li><a href="#tab_style_app">APP样式设置</a></li>
                <?php  } ?>
            </ul>
            <div class="tab-content ">

                <div class="tab-pane  active" id="tab_basic">
                    <div class="form-group">
                        <label class="col-lg control-label">是否开启WAP访问</label>
                        <div class="col-sm-9">
                            <?php if(cv('sysset.wap.edit')) { ?>
                            <label class="radio-inline">
                                <input type="radio" name="data[open]" value="1" <?php  if($data['open']==1) { ?> checked="checked"<?php  } ?>/>开启
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="data[open]" value="0" <?php  if(empty($data['open'])) { ?> checked="checked"<?php  } ?> />关闭
                            </label>
                            <div class="form-control-static">关闭后H5APP也将无法访问，如果只需在H5APP中访问可设置仅APP访问</div>
                            <?php  } else { ?>
                            <div class='form-control-static'><?php  if($data['open']==1) { ?>开启<?php  } else { ?>关闭<?php  } ?></div>
                            <?php  } ?>
                        </div>
                    </div>

                    <?php  if(com('h5app')) { ?>
                    <div class="form-group">
                        <label class="col-lg control-label">仅H5APP访问</label>
                        <div class="col-sm-9">
                            <?php if(cv('sysset.wap.edit')) { ?>
                            <label class="radio-inline">
                                <input type="radio" name="data[inh5app]" value="1" <?php  if($data['inh5app']==1) { ?> checked="checked"<?php  } ?>/>是
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="data[inh5app]" value="0" <?php  if(empty($data['inh5app'])) { ?> checked="checked"<?php  } ?> />否
                            </label>
                            <div class="form-control-static">开启仅H5APP访问后非H5APP之外的WAP将无法访问，开启此功能前请确保开启WAP</div>
                            <?php  } else { ?>
                            <div class='form-control-static'><?php  if($data['inh5app']==1) { ?>开启<?php  } else { ?>关闭<?php  } ?></div>
                            <?php  } ?>
                        </div>
                    </div>
                    <?php  } ?>

                    <div class="form-group">
                        <label class="col-lg control-label">强制绑定手机号</label>
                        <div class="col-sm-9">
                            <?php if(cv('sysset.wap.edit')) { ?>
                            <label class="radio-inline">
                                <input type="radio" name="data[mustbind]" value="1" <?php  if($data['mustbind']==1) { ?> checked="checked"<?php  } ?>/>是
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="data[mustbind]" value="0" <?php  if(empty($data['mustbind'])) { ?> checked="checked"<?php  } ?> />否
                            </label>
                            <div class="form-control-static">注意：设置强制绑定手机号后，在用户下单时将弹出提示并且无法下单(必须开启WAP访问)</div>
                            <?php  } else { ?>
                            <div class='form-control-static'><?php  if($data['mustbind']==1) { ?>是<?php  } else { ?>否<?php  } ?></div>
                            <?php  } ?>
                        </div>
                    </div>


                    <div class='form-group-title'>开启强制绑定后，用户必填信息</div>
                    <div class="form-group">
                        <label class="col-lg control-label must">真实姓名</label>
                        <div class="col-sm-9 col-xs-12">
                            <?php if(cv('sysset.wap.edit')) { ?>
                            <label class="radio-inline"><input type="radio" value="1" name="data[bindrealname]"  <?php  if($data['bindrealname'] == 1) { ?>checked="true"<?php  } ?> >填写</label>
                            <label class="radio-inline"><input type="radio" value="0" name="data[bindrealname]"  <?php  if(empty($data['bindrealname'])) { ?>checked="true"<?php  } ?>  >不填写</label>
                            <?php  } else { ?>
                            <div class='form-control-static'>
                                <?php  if($data['realname']==0) { ?>
                                关闭
                                <?php  } else if($data['realname']==1) { ?>
                                开启
                                <?php  } ?>
                            </div>
                            <?php  } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg control-label must">出生日期</label>
                        <div class="col-sm-9 col-xs-12">
                            <?php if(cv('sysset.wap.edit')) { ?>
                            <label class="radio-inline"><input type="radio" value="1" name="data[bindbirthday]"  <?php  if($data['bindbirthday'] == 1) { ?>checked="true"<?php  } ?> >填写</label>
                            <label class="radio-inline"><input type="radio" value="0" name="data[bindbirthday]"  <?php  if(empty($data['bindbirthday'])) { ?>checked="true"<?php  } ?>  >不填写</label>
                            <?php  } else { ?>
                            <div class='form-control-static'>
                                <?php  if($data['birthday']==0) { ?>
                                关闭
                                <?php  } else if($data['birthday']==1) { ?>
                                开启
                                <?php  } ?>
                            </div>
                            <?php  } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg control-label must">身份证号</label>
                        <div class="col-sm-9 col-xs-12">
                            <?php if(cv('sysset.wap.edit')) { ?>
                            <label class="radio-inline"><input type="radio" value="1" name="data[bindidnumber]"  <?php  if($data['bindidnumber'] == 1) { ?>checked="true"<?php  } ?> >填写</label>
                            <label class="radio-inline"><input type="radio" value="0" name="data[bindidnumber]"  <?php  if(empty($data['bindidnumber'])) { ?>checked="true"<?php  } ?>  >不填写</label>
                            <?php  } else { ?>
                            <div class='form-control-static'>
                                <?php  if($data['idnumber']==0) { ?>
                                关闭
                                <?php  } else if($data['idnumber']==1) { ?>
                                开启
                                <?php  } ?>
                            </div>
                            <?php  } ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg control-label must">微信号</label>
                        <div class="col-sm-9 col-xs-12">
                            <?php if(cv('sysset.wap.edit')) { ?>
                            <label class="radio-inline"><input type="radio" value="1" name="data[bindwechat]"  <?php  if($data['bindwechat'] == 1) { ?>checked="true"<?php  } ?> >填写</label>
                            <label class="radio-inline"><input type="radio" value="0" name="data[bindwechat]"  <?php  if(empty($data['bindwechat'])) { ?>checked="true"<?php  } ?>  >不填写</label>
                            <?php  } else { ?>
                            <div class='form-control-static'>
                                <?php  if($data['mobile']==0) { ?>
                                关闭
                                <?php  } else if($data['mobile']==1) { ?>
                                开启
                                <?php  } ?>
                            </div>
                            <?php  } ?>
                        </div>
                    </div>
                </div>

                <div class="tab-pane  " id="tab_style">


                    <div class="form-group">
                        <label class="col-lg control-label">选择模板</label>
                        <div class="col-sm-9 col-xs-12">
                            <select class='form-control' <?php if(cv('sysset.wap.edit')) { ?>name='data[style]'<?php  } else { ?>disabled<?php  } ?>>
                            <?php  if(is_array($styles)) { foreach($styles as $style) { ?>
                            <option value='<?php  echo $style;?>' <?php  if($style==$data['style']) { ?>selected<?php  } ?>><?php  echo $style;?></option>
                            <?php  } } ?>
                            </select>
                            <div class="help-block">您可以根据系统自带3套模板数据格式设计自己的模板上传至addons/ewei_shopv2/template/account/目录下并且在此处设置</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg control-label">主色调</label>
                        <div class="col-sm-9 col-xs-12" id="maincolor">
                            <?php if(cv('sysset.wap.edit')) { ?>
                            <?php  echo tpl_form_field_color('data[color]', $data['color'])?>
                            <div class='help-block'>
                                <div class="btn btn-default btn-sm setcolor" data-color="#ffffff">恢复default默认色调</div>
                                <div class="btn btn-default btn-sm setcolor" data-color="#fea119">恢复default2默认色调</div>
                                <div class="btn btn-default btn-sm setcolor" data-color="#43afcf">恢复default3默认色调</div>
                            </div>
                            <?php  } else { ?>
                            <div class="form-control-static"><?php  echo $data['color'];?></div>
                            <?php  } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg control-label">背景图片</label>
                        <div class="col-sm-9 col-xs-12" id="bgimg">
                            <?php if(cv('sysset.wap.edit')) { ?>
                            <?php echo tpl_form_field_image2('data[bg]', empty($data['bg'])?'../addons/ewei_shopv2/template/account/default/bg.jpg':$data['bg'])?>
                            <div class='help-block'>建议尺寸：default模板640*1008  default2模板640*284  default3模板640*366</div>
                            <div class='help-block'>
                                <div class="btn btn-default btn-sm setimg" data-style="default">恢复default默认背景</div>
                                <div class="btn btn-default btn-sm setimg" data-style="default2">恢复default2默认背景</div>
                                <div class="btn btn-default btn-sm setimg" data-style="default3">恢复default3默认背景</div>
                            </div>
                            <?php  } else { ?>
                            <input type="hidden" name="data[bg]" value="<?php  echo $data['bg'];?>"/>
                            <?php  if(!empty($data['bg'])) { ?>
                            <a href='<?php  echo tomedia($data['bg'])?>' target='_blank'>
                            <img src="<?php  echo tomedia($data['bg'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />
                            </a>
                            <?php  } ?>
                            <?php  } ?>
                        </div>
                    </div>

                </div>

                <div class="tab-pane" id="tab_sms">

                    <div class="form-group">
                        <label class="col-lg control-label must">图形验证码</label>
                        <div class="col-sm-9 col-xs-12">
                            <label class="radio-inline"><input type="radio" value="1" <?php if(cv('sysset.wap.edit')) { ?>name="data[smsimgcode]"<?php  } else { ?>disabled<?php  } ?> <?php  if(!empty($data['smsimgcode'])) { ?> checked="checked"<?php  } ?>>开启</label>
                            <label class="radio-inline"><input type="radio" value="0" <?php if(cv('sysset.wap.edit')) { ?>name="data[smsimgcode]"<?php  } else { ?>disabled<?php  } ?> <?php  if(empty($data['smsimgcode'])) { ?> checked="checked"<?php  } ?>>关闭</label>
                            <div class="help-block text-danger">提示：开启后用户在请求发送短信验证码时需先填写图形二维码并验证成功(仅在用户注册、找回密码、绑定手机号生效)</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg control-label must">用户注册</label>
                        <div class="col-sm-9 col-xs-12">
                            <select class="select2" style="display: block; width: 100%" id="sms_reg" <?php if(cv('sysset.wap.edit')) { ?>name="data[sms_reg]"<?php  } else { ?>disabled<?php  } ?>>
                            <option value=''>从短信消息库中选择</option>
                            <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                            <option value="<?php  echo $template_val['id'];?>" <?php  if($data['sms_reg']==$template_val['id']) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                            <?php  } } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg control-label must">找回密码</label>
                        <div class="col-sm-9 col-xs-12">
                            <select class="select2" style="display: block; width: 100%" id="sms_forget" <?php if(cv('sysset.wap.edit')) { ?>name="data[sms_forget]"<?php  } else { ?>disabled<?php  } ?>>
                            <option value=''>从短信消息库中选择</option>
                            <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                            <option value="<?php  echo $template_val['id'];?>" <?php  if($data['sms_forget']==$template_val['id']) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                            <?php  } } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg control-label must">修改密码</label>
                        <div class="col-sm-9 col-xs-12">
                            <select class="select2" style="display: block; width: 100%" id="sms_changepwd" <?php if(cv('sysset.wap.edit')) { ?>name="data[sms_changepwd]"<?php  } else { ?>disabled<?php  } ?>>
                            <option value=''>从短信消息库中选择</option>
                            <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                            <option value="<?php  echo $template_val['id'];?>" <?php  if($data['sms_changepwd']==$template_val['id']) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                            <?php  } } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg control-label must">绑定手机</label>
                        <div class="col-sm-9 col-xs-12">
                            <select class="select2" style="display: block; width: 100%" id="sms_bind" <?php if(cv('sysset.wap.edit')) { ?>name="data[sms_bind]"<?php  } else { ?>disabled<?php  } ?>>
                            <option value=''>从短信消息库中选择</option>
                            <?php  if(is_array($template_sms)) { foreach($template_sms as $template_val) { ?>
                            <option value="<?php  echo $template_val['id'];?>" <?php  if($data['sms_bind']==$template_val['id']) { ?>selected<?php  } ?>><?php  echo $template_val['name'];?></option>
                            <?php  } } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <?php  if(com('h5app')) { ?>
                <div class="tab-pane  " id="tab_login">
                    <div class="form-group">
                        <label class="col-lg control-label must">APP第三方登录</label>
                        <div class="col-sm-9 col-xs-12">
                            <label class="checkbox-inline"><input type="checkbox" <?php if(cv('sysset.wap.edit')) { ?>name="data[sns][qq]" value="1"<?php  } else { ?>disabled<?php  } ?> <?php  if(!empty($data['sns']['qq'])) { ?>checked<?php  } ?>> QQ登录</label>
                            <label class="checkbox-inline"><input type="checkbox" <?php if(cv('sysset.wap.edit')) { ?>name="data[sns][wx]" value="1"<?php  } else { ?>disabled<?php  } ?> <?php  if(!empty($data['sns']['wx'])) { ?>checked<?php  } ?>> 微信登录</label>
                            <div class="form-control-static">勾选后请在APP后台开启相应支付插件并且配置好参数</div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="tab_style_app">
                    <div class="form-group">
                        <label class="col-lg control-label">标题栏背景颜色</label>
                        <div class="col-sm-9 col-xs-12">
                            <?php if(cv('sysset.wap.edit')) { ?>
                            <?php  echo tpl_form_field_color('data[headerbgcolor]', $data['headerbgcolor'])?>
                            <?php  } else { ?>
                            <div class="form-control-static"><?php  echo $data['headerbgcolor'];?></div>
                            <?php  } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg control-label">标题栏文字颜色</label>
                        <div class="col-sm-9 col-xs-12">
                            <?php if(cv('sysset.wap.edit')) { ?>
                            <?php  echo tpl_form_field_color('data[headercolor]', $data['headercolor'])?>
                            <?php  } else { ?>
                            <div class="form-control-static"><?php  echo $data['headercolor'];?></div>
                            <?php  } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg control-label">标题栏图标颜色</label>
                        <div class="col-sm-9 col-xs-12">
                            <?php if(cv('sysset.wap.edit')) { ?>
                            <?php  echo tpl_form_field_color('data[headericoncolor]', $data['headericoncolor'])?>
                            <?php  } else { ?>
                            <div class="form-control-static"><?php  echo $data['headericoncolor'];?></div>
                            <?php  } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg control-label">IOSAPP状态栏<br>文字颜色</label>
                        <div class="col-sm-9 col-xs-12" style="padding-top: 10px;">
                            <?php if(cv('sysset.wap.edit')) { ?>
                            <label class="radio-inline"><input type="radio" name="data[statusbar]" value="0" <?php  if(empty($data['statusbar'])) { ?>checked<?php  } ?>>白色</label>
                            <label class="radio-inline"><input type="radio" name="data[statusbar]" value="1" <?php  if(!empty($data['statusbar'])) { ?>checked<?php  } ?>>黑色</label>
                            <?php  } else { ?>
                            <div class="form-control-static"><?php  if(empty($data['statusbar'])) { ?>白色<?php  } else { ?>黑色<?php  } ?></div>
                            <?php  } ?>
                        </div>
                    </div>
                </div>
                <?php  } ?>

            </div>

        </div>



        <div class="form-group">
            <label class="col-lg control-label"></label>
            <div class="col-sm-9 col-xs-12">
                <?php if(cv('sysset.wap.edit')) { ?>
                <input type="submit" value="提交" class="btn btn-primary"  />
                <?php  } ?>
            </div>
        </div>

    </form>
</div>

<script type="text/javascript">
    require(['bootstrap'], function () {
        $('#myTab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        })
    });
    $(function () {
        $("form").submit(function () {
            var openwap = $("input[name='data[open]']:checked").val();
             if (openwap == '0'){
                $("form").removeAttr('stop');
                return true;
            }
            if(!$("#sms_reg option:selected").val()){
                $("#sms_reg").focus();
                tip.msgbox.err('请选择用户注册短信模板!');
                $('#myTab a[href="#tab_sms"]').tab('show');
                $('form').attr('stop',1);
                return false;
            }
            if(!$("#sms_forget option:selected").val()){
                $("#sms_forget").focus();
                tip.msgbox.err('请选择找回密码短信模板!');
                $('#myTab a[href="#tab_sms"]').tab('show');
                $('form').attr('stop',1);
                return false;
            }
            if(!$("#sms_changepwd option:selected").val()){
                $("#sms_changepwd").focus();
                tip.msgbox.err('请选择修改密码短信模板!');
                $('#myTab a[href="#tab_sms"]').tab('show');
                $('form').attr('stop',1);
                return false;
            }
            if(!$("#sms_bind option:selected").val()){
                $("#sms_bind").focus();
                tip.msgbox.err('请选择绑定用户短信模板!');
                $('#myTab a[href="#tab_sms"]').tab('show');
                $('form').attr('stop',1);
                return false;
            }
            $("form").removeAttr('stop');
            return true;
        });
    });

    $(".setcolor").click(function () {
        var color = $(this).data('color');
        if(color){
            $("#maincolor").find("input").val(color).next().css("background-color", color);
        }
    });

    $(".setimg").click(function () {
       var imgurl = $(this).data('style');
        if(imgurl){
            imgurl = "../addons/ewei_shopv2/template/account/"+imgurl+"/bg.jpg";
            $("#bgimg").find("input").val(imgurl);
            $("#bgimg").find("img").attr("src", imgurl);
        }
    });
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>     