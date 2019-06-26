<?php defined('IN_IA') or exit('Access Denied');?><div class="region-goods-details row">
    <div class="region-goods-left col-sm-2" >自定义表单</div>
    <div class="region-goods-right col-sm-10">
<div class="">

    <div class="alert alert-danger">
        警告：当模板中已经添加数据后切换自定义表单模板有可能导致无法使用！
    </div>

    <div class="form-group">
        <label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义表单形式</label>

        <?php if( ce('goods' ,$item) ) { ?>
        <div class="col-sm-9 col-xs-12">
            <label class="radio radio-inline" style="float: left;">
                <input type="radio" value="0" name="diyformtype" <?php  if(empty($item['diyformtype'])) { ?>checked="true"<?php  } ?>> 关闭
            </label>

            <label class="radio radio-inline" style="float: left;">
                <input type="radio" value="2" name="diyformtype" <?php  if($item['diyformtype'] == 2) { ?>checked="true"<?php  } ?>> 自定义
            </label>

            <label class="radio radio-inline" style="float: left;">
                <input type="radio" value="1" name="diyformtype" <?php  if($item['diyformtype'] == 1) { ?>checked="true"<?php  } ?>> 使用模板
            </label>

            <select id="user_diyform" name="diyformid" class="form-control" style="width:auto; float: left;margin-left:10px;">
                <option value="<?php  echo $value['id'];?>" <?php  if($item['diyformid']==0) { ?>selected<?php  } ?>>--选择自定义表单--</option>
                <?php  if(is_array($form_list)) { foreach($form_list as $key => $value) { ?>
                <option value="<?php  echo $value['id'];?>" <?php  if($item['diyformid']==$value['id']) { ?>selected<?php  } ?>><?php  echo $value['title'];?></option>
                <?php  } } ?>
            </select>

        </div>

        <div class="diyform-group" <?php  if($item['diyformtype'] != 2) { ?>style="display:none;"<?php  } ?>>

            <label class="col-xs-12 col-sm-3 col-md-2 control-label diyform-group">保存为表单模板</label>
            <div class="col-sm-9 col-xs-12 diyform-group">
                <label class="radio radio-inline" style="float: left;">
                    <input type="radio" value="0" name="diysave" <?php  if(empty($item['diysave'])) { ?>checked="true"<?php  } ?>> 不保存
                </label>

                <label class="radio radio-inline" style="float: left;">
                    <input type="radio" value="1" name="diysave" <?php  if($item['diysave'] == 1) { ?>checked="true"<?php  } ?>> 保存
                </label>
                <label class="radio radio-inline" style="float: left;cursor:default;">
                <?php  if(!empty($diyforminfo)) { ?>
                    (该表单已经保存为 <font style="color: red;"><?php  echo $diyforminfo["title"];?></font> 的模板)
                <?php  } ?>
                </label>
            </div>

        </div>

        <?php  } else { ?>
        <div class='form-control-static'>
            <?php  if(empty($item['diyformtype'])) { ?>
            关闭
            <?php  } else { ?>
            开启
            <?php  if(is_array($form_list)) { foreach($form_list as $key => $value) { ?>
            <?php  if($item['diyformid']==$value['id']) { ?><?php  echo $value['title'];?><?php  } ?>
            <?php  } } ?>
            <?php  } ?>
        </div>

        <?php  } ?> 

<!--        <label class="col-xs-12 col-sm-3 col-md-2 control-label">订单模式</label>

        <div class="col-sm-9 col-xs-12">
            <label class="radio radio-inline" style="float: left;">
                <input type="radio" value="0" name="diymode" <?php  if(empty($item['diymode'])) { ?>checked<?php  } ?>> 系统默认
            </label>

            <label class="radio radio-inline" style="float: left;">
                <input type="radio" value="1" name="diymode" <?php  if($item['diymode'] == 1) { ?>checked<?php  } ?>> 点击立即购买时填写
            </label>
            <label class="radio radio-inline" style="float: left;">
                <input type="radio" value="2" name="diymode" <?php  if($item['diymode'] == 2) { ?>checked<?php  } ?>> 确认订单时填写
            </label>

        </div>-->


    </div>

    <div class="diyform-group" style="margin:0 25px;  <?php  if($item['diyformtype']!=2) { ?>display:none;<?php  } ?>">
    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('diyform/temp/tpl/data', TEMPLATE_INCLUDEPATH)) : (include template('diyform/temp/tpl/data', TEMPLATE_INCLUDEPATH));?>
    </div>

</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('diyform/temp/tpl/script', TEMPLATE_INCLUDEPATH)) : (include template('diyform/temp/tpl/script', TEMPLATE_INCLUDEPATH));?>
</div>
</div>
<script>
    $(function () {
        $(':radio[name=diyformtype]').click(function () {
            window.type = $("input[name='diyformtype']:checked").val();

            if(window.type=='2'){
                $('.diyform-group').show();
            } else {
                $('.diyform-group').hide();
            }
        })
    })
</script>

<!--青岛易联互动网络科技有限公司-->