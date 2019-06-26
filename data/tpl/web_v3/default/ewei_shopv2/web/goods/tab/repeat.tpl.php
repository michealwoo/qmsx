<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
    <label class="col-sm-2 control-label">重复购买折扣</label>
    <div class="col-sm-6 col-xs-12">
		<?php if( ce('goods' ,$item) ) { ?>
        <div class="input-group fixsingle-input-group">
            <input type="number" name="buyagain" class="form-control" value="<?php  echo $item['buyagain'];?>" />
            <span class="input-group-addon">折</span>
        </div>
			   <span class="help-block">重复购买此商品,享受的折扣</span>
		<?php  } else { ?>
        <div class='form-control-static'><?php  echo $item['buyagain'];?> 折</div>
        <?php  } ?>
    </div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label">持续使用</label>
	<div class="col-sm-9 col-xs-12">
		<?php if( ce('goods' ,$item) ) { ?>
		<label class="radio-inline"><input type="radio" name="buyagain_islong" value="1" <?php  if($item['buyagain_islong'] == 1) { ?>checked="true"<?php  } ?>   /> 是</label>
		<label class="radio-inline"><input type="radio" name="buyagain_islong" value="0" <?php  if(empty($item['buyagain_islong'])) { ?>checked="true"<?php  } ?>/> 否</label>
		<span class="help-block">购买一次后,以后都使用这个折扣</span>
		<?php  } else { ?>
		<div class='form-control-static'><?php  if(empty($item['buyagain_islong'])) { ?>否<?php  } else { ?>是<?php  } ?></div>
		<?php  } ?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label">使用条件</label>
	<div class="col-sm-9 col-xs-12">
		<?php if( ce('goods' ,$item) ) { ?>
		<label class="radio-inline"><input type="radio" name="buyagain_condition" value="0" <?php  if(empty($item['buyagain_condition'])) { ?>checked="true"<?php  } ?>/> 订单付款后</label>
		<label class="radio-inline"><input type="radio" name="buyagain_condition" value="1" <?php  if($item['buyagain_condition'] == 1) { ?>checked="true"<?php  } ?>   /> 订单完成后</label>
		<span class="help-block">重复购买使用条件,是付款后还是完成后 , 默认是付款后</span>
		<?php  } else { ?>
		<div class='form-control-static'><?php  if(empty($item['buyagain_condition'])) { ?>订单付款后<?php  } else { ?>订单完成后<?php  } ?></div>
		<?php  } ?>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label">可以使用优惠</label>
	<div class="col-sm-9 col-xs-12">
		<?php if( ce('goods' ,$item) ) { ?>
		<label class="radio-inline"><input type="radio" name="buyagain_sale" value="1" <?php  if($item['buyagain_sale'] == 1) { ?>checked="true"<?php  } ?>   /> 是</label>
		<label class="radio-inline"><input type="radio" name="buyagain_sale" value="0" <?php  if(empty($item['buyagain_sale'])) { ?>checked="true"<?php  } ?>/> 否</label>
		<span class="help-block">重复购买时,是否与其他优惠共享!其他优惠享受后,在使用这个折扣（其他优惠不包含优惠券）</span>
		<?php  } else { ?>
		<div class='form-control-static'><?php  if(empty($item['buyagain_condition'])) { ?>否<?php  } else { ?>是<?php  } ?></div>
		<?php  } ?>
	</div>
</div>