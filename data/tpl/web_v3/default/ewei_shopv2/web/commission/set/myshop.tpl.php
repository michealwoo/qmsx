<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
    <label class="col-lg control-label">"我的小店"功能</label>
    <div class="col-sm-9 col-xs-12">
    <?php if(cv('commission.set.edit')) { ?>
	<label class="radio-inline"><input type="radio"  name="data[closemyshop]" value="0" <?php  if(empty($data['closemyshop'])) { ?> checked="checked"<?php  } ?> /> 开启</label>
	<label class="radio-inline"><input type="radio"  name="data[closemyshop]" value="1" <?php  if($data['closemyshop'] ==1) { ?> checked="checked"<?php  } ?> /> 关闭</label>
	<?php  } else { ?>
		<?php  if(empty($data['closemyshop'])) { ?>开启<?php  } else { ?>关闭<?php  } ?>
	<?php  } ?>
	<span class="help-block">如果关闭小店功能, 则分享的店铺链接，进入店铺的链接全是总店</span>
    </div> 
</div>
<div class="form-group">
    <label class="col-lg control-label">自选商品</label>
    <div class="col-sm-9 col-xs-12">
    <?php if(cv('commission.set.edit')) { ?>
		<label class="radio-inline"><input type="radio"  name="data[select_goods]" value="1" <?php  if($data['select_goods'] ==1) { ?> checked="checked"<?php  } ?> /> 开启</label>
	<label class="radio-inline"><input type="radio"  name="data[select_goods]" value="0" <?php  if($data['select_goods'] ==0) { ?> checked="checked"<?php  } ?> /> 关闭</label>
	<?php  } else { ?>
		<?php  if($data['select_goods'] ==0) { ?>关闭<?php  } else { ?>显示<?php  } ?>
	<?php  } ?>
	<span class="help-block">是否允许分销商自己的小店选择自己推广的产品,如果开启自选后，要单独禁用某个分销商的自选权限，请到分销商管理中设置</span>
    </div> 
</div>
<!--NDAwMDA5NzgyNw==-->