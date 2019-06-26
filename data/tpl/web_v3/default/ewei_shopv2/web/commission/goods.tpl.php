<?php defined('IN_IA') or exit('Access Denied');?><script language="javascript">
    $(function() {
        $("#hascommission").click(function() {
            var obj = $(this);
            if (obj.get(0).checked) {
                $("#commission_div").show();
            } else {
                $("#commission_div").hide();
            }
        });
    })
</script>

<div class="region-goods-details row">
    <div class="region-goods-left col-sm-2">分销</div>
    <div class="region-goods-right col-sm-10">
        <div class="form-group">
            <label class="col-sm-2 control-label">是否参与分销</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( ce('goods' ,$item) ) { ?>
                <label class="radio-inline">
                    <input type="radio"  value="0" name="nocommission" <?php  if($item['nocommission']==0) { ?>checked<?php  } ?> /> 参与分销
                </label>
                <label class="radio-inline">
                    <input type="radio"  value="1" name="nocommission" <?php  if($item['nocommission']==1) { ?>checked<?php  } ?> /> 不参与分销
                </label>
                <span class="help-block">如果不参与分销，则不产生分销佣金</span>
                <?php  } else { ?>
                <div class='form-control-static'><?php  if($item['nocommission']==1) { ?>不参与分销<?php  } else { ?>参与分销<?php  } ?></div>
                <?php  } ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">分享按钮</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( ce('goods' ,$item) ) { ?>
                <label class="radio-inline">
                    <input type="radio"  value="0" name="sharebtn" <?php  if(empty($item['sharebtn'])) { ?>checked<?php  } ?> /> 弹出关注提示层
                </label>
                <label class="radio-inline">
                    <input type="radio"  value="1" name="sharebtn" <?php  if(!empty($item['sharebtn'])) { ?>checked<?php  } ?> /> 跳转至商品海报
                </label>
                <?php  } else { ?>
                <div class='form-control-static'><?php  if($item['nocommission']==1) { ?>不参与分销<?php  } else { ?>参与分销<?php  } ?></div>
                <?php  } ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">海报图片</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( ce('goods' ,$item) ) { ?>
                <?php  echo tpl_form_field_image2('commission_thumb', $item['commission_thumb'])?>
                <span class='help-block'>尺寸: 640*640，如果为空默认缩略图片</span>
                <?php  } else { ?>
                <?php  if(!empty($item['commission_thumb'])) { ?>
                <a href='<?php  echo tomedia($item['commission_thumb'])?>' target='_blank'>
                <img src="<?php  echo tomedia($item['commission_thumb'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />
                </a>
                <?php  } ?>
                <?php  } ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">独立规则</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( ce('goods' ,$item) ) { ?>
                <label class="checkbox-inline">
                    <input type="checkbox" id="hascommission" value="1" name="hascommission" <?php  if($item['hascommission']==1) { ?>checked<?php  } ?> />启用独立佣金比例
                </label>
                <span class="help-block">启用独立佣金设置，此商品拥有独自的佣金比例,不受分销商等级比例及默认设置限制</span>
                <?php  } else { ?>
                <div class='form-control-static'><?php  if($item['hascommission']==1) { ?>启用独立佣金设置<?php  } else { ?>不启用独立佣金设置<?php  } ?></div>
                <?php  } ?>
            </div>
        </div>

        <div id="commission_div" <?php  if(empty($item['hascommission'])) { ?>style="display:none"<?php  } ?> >


        <div class="form-group">
            <label class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
                <?php if( ce('goods' ,$item) ) { ?>
                <label for="commission_type0" class="radio-inline"><input type="radio" name="commission_type" value="0" id="commission_type0" <?php  if(empty($commission_type) || $commission_type == 0) { ?>checked="true"<?php  } ?> /> 统一分销佣金</label>
                <label for="commission_type1" class="radio-inline"><input type="radio" name="commission_type" value="1" id="commission_type1"  <?php  if(!empty($commission_type) && $commission_type == 1) { ?>checked="true"<?php  } ?> /> 详细设置分销佣金</label>
                <?php  } else { ?>
                <div class='form-control-static'>
                    <?php  if(empty($commission_type) || $commission_type == 0) { ?>统一设置折扣<?php  } ?>
                    <?php  if(!empty($commission_type) && $commission_type == 1) { ?>详细设置折扣<?php  } ?>
                </div>

                <?php  } ?>
            </div>
        </div>

        <div id="commission_0"  <?php  if($commission_type!=0) { ?> style="display:none;" <?php  } ?>>
        <div class='alert alert-danger'>
            如果比例为空，则使用固定规则，如果都为空则无分销佣金
        </div>
        <?php  if($com_set['level']>=1) { ?>
        <div class="form-group">
            <label class="col-sm-2 control-label">一级分销</label>
            <div class="col-sm-4 col-xs-12">
                <?php if( ce('goods' ,$item) ) { ?>
                <div class="input-group">
                    <input type="text" name="commission1_rate" id="commission1_rate" class="form-control" value="<?php  echo $item['commission1_rate'];?>" />
                    <div class="input-group-addon">% 固定</div>
                    <input type="text" name="commission1_pay" id="commission1_pay" class="form-control" value="<?php  echo $item['commission1_pay'];?>" />
                    <div class="input-group-addon">元</div>
                </div>
                <?php  } else { ?>
                <div class='form-control-static'>比例: <?php  echo $item['commission1_rate'];?>% 固定: <?php  echo $item['commission1_pay'];?> 元</div>
                <?php  } ?>
            </div>
        </div>
        <?php  } ?>
        <?php  if($com_set['level']>=2) { ?>
        <div class="form-group">
            <label class="col-sm-2 control-label">二级分销</label>
            <div class="col-sm-4 col-xs-12">
                <?php if( ce('goods' ,$item) ) { ?>
                <div class="input-group">
                    <input type="text" name="commission2_rate" id="commission2_rate" class="form-control" value="<?php  echo $item['commission2_rate'];?>" />
                    <div class="input-group-addon">% 固定</div>
                    <input type="text" name="commission2_pay" id="commission2_pay" class="form-control" value="<?php  echo $item['commission2_pay'];?>" />
                    <div class="input-group-addon">元</div>
                </div>
                <?php  } else { ?>
                <div class='form-control-static'>比例: <?php  echo $item['commission2_rate'];?>% 固定: <?php  echo $item['commission2_pay'];?> 元</div>
                <?php  } ?>
            </div>
        </div>
        <?php  } ?>
        <?php  if($com_set['level']>=3) { ?>
        <div class="form-group">
            <label class="col-sm-2 control-label">三级分销</label>
            <div class="col-sm-4 col-xs-12">
                <?php if( ce('goods' ,$item) ) { ?>
                <div class="input-group">
                    <input type="text" name="commission3_rate" id="commission3_rate" class="form-control" value="<?php  echo $item['commission3_rate'];?>" />
                    <div class="input-group-addon">% 固定</div>
                    <input type="text" name="commission3_pay" id="commission3_pay" class="form-control" value="<?php  echo $item['commission3_pay'];?>" />
                    <div class="input-group-addon">元</div>
                </div>
                <?php  } else { ?>
                <div class='form-control-static'>比例: <?php  echo $item['commission3_rate'];?>% 固定: <?php  echo $item['commission3_pay'];?> 元</div>
                <?php  } ?>
            </div>
        </div>
        <?php  } ?>
    </div>
    <div id="commission_1" <?php  if($commission_type!=1) { ?> style="display:none;" <?php  } ?>>
    <div class='alert alert-danger'>
        填写佣金规则,如果是数字(只能是纯数字),则是以固定金额给佣金<br>
        例如 1  就是按照卖一件,给分销商1元<br>
        如果上百分号<br>
        例如 1% 则是以支付商品金额的百分比给佣金
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">统一设置</label>
        <div class="col-sm-10 col-xs-10">
            <select id="commission_level1" class="form-control" style="width:200px;display: inline-block">
                <option value="">选择等级</option>
                <?php  if(is_array($commission_level)) { foreach($commission_level as $level) { ?>
                <?php  if($level['key'] == 'default') { ?>
                <option value="<?php  echo $level['key'];?>"><?php  echo $level['levelname'];?></option>
                <?php  } else { ?>
                <option value="<?php  echo $level['id'];?>"><?php  echo $level['levelname'];?></option>
                <?php  } ?>
                <?php  } } ?>
            </select>
            <select id="commission_level2" class="form-control" style="width:200px;display: inline-block">
                <option value="">选择佣金级别</option>
                <?php  for($i=0;$i<$_W['shopset']['commission']['level'];$i++):?>
                <option value="<?php  echo $i;?>"><?php  echo $i+1?>级佣金</option>
                <?php  endfor;?>
            </select>
            <input id="commission_level3" class="form-control" style="width:100px;display: inline-block" placeholder="佣金设置">
            <a class="btn btn-danger" onclick="commission_change_all()">设置</a>
        </div>
    </div>
    <div id='tbcommission' style="padding-left:15px;" >
        <div id="commission" style="padding:0;"><?php  if($item['hasoption']==1) { ?><?php  echo $commission_html;?><?php  } ?></div>
        <div id="commission_default" style="padding:0;overflow-x: auto;"></div>
    </div>
</div>
</div>
    </div>
</div>




<script>
    $(function () {
        $("label[for='commission_type0']").click(function () {
            $("#commission_1").hide();
            $("#commission_0").show();
        });
        $("label[for='commission_type1']").click(function () {

            commission_change();
            $("#commission_0").hide();
            $("#commission_1").show();
        });
    });
    function commission_change() {
        var html = '<table class="table table-bordered table-condensed" <?php  if(count($commission_level) >5) { ?> style="width: <?php  echo count($commission_level)* 205?>px;" <?php  } ?> ><thead><tr class="active"><?php  if(is_array($commission_level)) { foreach($commission_level as $level) { ?><th><div class=""><div style="padding-bottom:10px;text-align:center;"><?php  echo $level["levelname"];?></div></div></th><?php  } } ?></tr></thead><tbody><tr><?php  if(is_array($commission_level)) { foreach($commission_level as $level) { ?><?php  if($level["key"]=="default") { ?><td><?php  for ($c_i = 0; $c_i < $_W["shopset"]["commission"]["level"]; $c_i++): ?><input name="commission_level_<?php  echo $level["key"];?>_default[]" type="text" class="form-control commission_<?php  echo $level["key"];?> commission_<?php  echo $level["key"];?>_default" value="<?php  echo $commission[$level["key"]]["option0"][$c_i ];?>" style="display:inline;width: <?php  echo (96 / $_W["shopset"]["commission"]["level"])?>%;" placeholder="<?php  echo $c_i+1?>级"> <?php  endfor;?></td><?php  } else { ?><td><?php  for ($c_i = 0; $c_i < $_W["shopset"]["commission"]["level"]; $c_i++): ?><input name="commission_level_<?php  echo $level["id"];?>_default[]" type="text" class="form-control commission_level<?php  echo $level["id"];?> commission_<?php  echo $level["key"];?>_default" value="<?php  echo $commission["level".$level["id"]]["option0"][$c_i ];?>" style="display:inline;width: <?php  echo (96 / $_W["shopset"]["commission"]["level"])?>%;" placeholder="<?php  echo $c_i+1?>级"> <?php  endfor;?></td><?php  } ?><?php  } } ?></tr></tbody></table>';
        if ($("#commission").html()=='')
        {
            $("#commission_default").html(html);
            $("#commission_default").show();
        }
        else
        {
            $("#commission_default").html('');
            $("#commission_default").show();
        }
    }
    commission_change();

    function commission_change_all() {
        var commission_level1 = $("#commission_level1").val();
        var commission_level2 = $("#commission_level2").val();
        var commission_level3 = $("#commission_level3").val();

        if (commission_level1=='')
        {
            tip.msgbox.err('请选择分销商等级');
            return false;
        }
        if (commission_level2=='')
        {
            tip.msgbox.err('请选择佣金等级');
            return false;
        }
        if (commission_level3=='')
        {
            tip.msgbox.err('请填写佣金比例');
            return false;
        }

        if (commission_level1=='default')
        {
            $(".commission_default").each(function (key,val) {
                if(key%<?php  echo $_W['shopset']['commission']['level'];?> == commission_level2)
                {
                    $(this).val(commission_level3);
                }
            });
        }
        else
        {
            $(".commission_level"+commission_level1).each(function (key,val) {
                if(key%<?php  echo $_W['shopset']['commission']['level'];?> == commission_level2)
                {
                    $(this).val(commission_level3);
                }
            });
        }
    }
</script>
<!--OTEzNzAyMDIzNTAzMjQyOTE0-->