<?php defined('IN_IA') or exit('Access Denied');?>
<div class="region-goods-details row">
	<div class="region-goods-left col-sm-2">购买权限</div>
	<div class="region-goods-right col-sm-10">
		<div class="form-group">
			<label class="col-sm-2 control-label">单次最多购买</label>
			<div class="col-sm-6 col-xs-12">
				<?php if( ce('goods' ,$item) ) { ?>
				<div class="input-group">
					<input type="text" name="maxbuy" id="maxbuy" class="form-control" value="<?php  echo $item['maxbuy'];?>" />
					<span class="input-group-addon">件</span>

				</div>
				<span class="help-block">用户单次购买此商品数量限制</span>
				<?php  } else { ?>
				<div class='form-control-static'><?php  echo $item['maxbuy'];?> 件</div>
				<?php  } ?>
			</div>
		</div>
		<div class="form-group minbuy" <?php  if($item['type']==4) { ?>  style="display: none"<?php  } ?>>
		<label class="col-sm-2 control-label">单次最低购买</label>
		<div class="col-sm-6 col-xs-12">
			<?php if( ce('goods' ,$item) ) { ?>
			<div class="input-group">
				<input type="text" name="minbuy" id="minbuy" class="form-control" value="<?php  echo $item['minbuy'];?>" />
				<span class="input-group-addon">件</span>

			</div>
			<span class="help-block">用户单次必须最少购买此商品数量限制</span>
			<?php  } else { ?>
			<div class='form-control-static'><?php  echo $item['minbuy'];?> 件</div>
			<?php  } ?>
		</div>
	</div>


	<div class="form-group">
		<label class="col-sm-2 control-label">最多购买</label>

		<div class="col-sm-6 col-xs-12">
			<?php if( ce('goods' ,$item) ) { ?>
			<div class="input-group">
				<input type="text" name="usermaxbuy" class="form-control" value="<?php  echo $item['usermaxbuy'];?>" />
				<span class="input-group-addon">件</span>
			</div>
			<span class="help-block">用户购买过的此商品数量限制</span>
			<?php  } else { ?>
			<div class='form-control-static'><?php  echo $item['usermaxbuy'];?> 件</div>
			<?php  } ?>

		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">会员等级浏览权限</label>
		<div class="col-sm-9 col-xs-12 chks">

			<?php if( ce('goods' ,$item) ) { ?>
			<select name='showlevels[]' class='form-control select2' multiple=''>
				<!--<option value="0"  <?php  if($item['showlevels']!='' && is_array($item['showlevels'])  && in_array('0', $item['showlevels'])) { ?>selected<?php  } ?>>普通等级</option>-->
				<?php  if(is_array($levels)) { foreach($levels as $level) { ?>
				<option value="<?php  echo $level['id'];?>" <?php  if(is_array($item['showlevels']) && in_array($level['id'], $item['showlevels'])) { ?>selected<?php  } ?>><?php  echo $level['levelname'];?></option>
				<?php  } } ?>
			</select>
			<span class='help-block'>不设置默认全部会员等级</span>

			<?php  } else { ?>
			<div class='form-control-static'>
				<?php  if($item['showlevels']=='') { ?>
				全部会员等级
				<?php  } else { ?>
				<?php  if($item['showlevels']!='' && is_array($item['showlevels']) && in_array('0', $item['showlevels'])) { ?>
				<?php echo empty($shop['levelname'])?'普通等级':$shop['levelname']?>;
				<?php  } ?>
				<?php  if(is_array($levels)) { foreach($levels as $level) { ?>
				<?php  if($item['showlevels']!='' && is_array($item['showlevels'])  && in_array($level['id'], $item['showlevels'])) { ?>
				<?php  echo $level['levelname'];?>;
				<?php  } ?>
				<?php  } } ?>
				<?php  } ?>
			</div>

			<?php  } ?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">会员等级购买权限</label>
		<div class="col-sm-9 col-xs-12 chks" >
			<?php if( ce('goods' ,$item) ) { ?>
			<select name='buylevels[]' class='form-control select2' multiple=''>

				<!--<option value="0"  <?php  if($item['buylevels']!='' && is_array($item['buylevels'])  && in_array('0', $item['buylevels'])) { ?>selected<?php  } ?>>普通等级</option>-->
				<?php  if(is_array($levels)) { foreach($levels as $level) { ?>
				<option value="<?php  echo $level['id'];?>" <?php  if(is_array($item['buylevels']) && in_array($level['id'], $item['buylevels'])) { ?>selected<?php  } ?>><?php  echo $level['levelname'];?></option>
				<?php  } } ?>
			</select>
			<span class='help-block'>不设置默认全部会员等级</span>
			<?php  } else { ?>
			<div class='form-control-static'>
				<?php  if($item['buylevels']=='') { ?>
				全部会员等级
				<?php  } else { ?>
				<?php  if($item['buylevels']!='' && is_array($item['buylevels']) && in_array('0', $item['buylevels'])) { ?>
				<?php echo empty($shop['levelname'])?'普通等级':$shop['levelname']?>;
				<?php  } ?>
				<?php  if(is_array($levels)) { foreach($levels as $level) { ?>
				<?php  if($item['buylevels']!='' && is_array($item['buylevels'])  && in_array($level['id'], $item['buylevels'])) { ?>
				<?php  echo $level['levelname'];?>;
				<?php  } ?>
				<?php  } } ?>
				<?php  } ?>
			</div>

			<?php  } ?>


		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">标签组浏览权限</label>
		<div class="col-sm-9 col-xs-12 chks" >
			<?php if( ce('goods' ,$item) ) { ?>
			<select name='showgroups[]' class='form-control select2' multiple=''>
				<option value="0"  <?php  if($item['showgroups']!='' && is_array($item['showgroups'])  && in_array('0', $item['showgroups'])) { ?>selected<?php  } ?>>无会员标签组</option>
				<?php  if(is_array($groups)) { foreach($groups as $group) { ?>
				<option value="<?php  echo $group['id'];?>" <?php  if(is_array($item['showgroups']) && in_array($group['id'], $item['showgroups'])) { ?>selected<?php  } ?>><?php  echo $group['groupname'];?></option>
				<?php  } } ?>
			</select>
			<span class='help-block'>不设置默认全部会员标签组</span>

			<?php  } else { ?>
			<div class='form-control-static'>
				<?php  if($item['showgroups']=='') { ?>
				全部会员标签组
				<?php  } else { ?>
				<?php  if($item['showgroups']!='' && is_array($item['showgroups']) && in_array('0', $item['showgroups'])) { ?>
				<?php echo empty($shop['levelname'])?'无会员标签组':$shop['levelname']?>;
				<?php  } ?>
				<?php  if(is_array($levels)) { foreach($levels as $level) { ?>
				<?php  if($item['showgroups']!='' && is_array($item['showgroups'])  && in_array($level['id'], $item['showgroups'])) { ?>
				<?php  echo $level['levelname'];?>;
				<?php  } ?>
				<?php  } } ?>
				<?php  } ?>
			</div>

			<?php  } ?>

		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">会员标签组购买权限</label>
		<div class="col-sm-9 col-xs-12 chks" >
			<?php if( ce('goods' ,$item) ) { ?>
			<select name='buygroups[]' class='form-control select2' multiple=''>
				<option value="0"  <?php  if($item['buygroups']!='' && is_array($item['buygroups'])  && in_array('0', $item['buygroups'])) { ?>selected<?php  } ?>>无标签组</option>
				<?php  if(is_array($groups)) { foreach($groups as $group) { ?>
				<option value="<?php  echo $group['id'];?>" <?php  if(is_array($item['buygroups']) && in_array($group['id'], $item['buygroups'])) { ?>selected<?php  } ?>><?php  echo $group['groupname'];?></option>
				<?php  } } ?>
			</select>
			<span class='help-block'>不设置默认全部标签组</span>
			<?php  } else { ?>
			<div class='form-control-static'>
				<?php  if($item['buygroups']=='') { ?>
				全部会员标签组
				<?php  } else { ?>
				<?php  if($item['buygroups']!='' && is_array($item['buygroups']) && in_array('0', $item['buygroups'])) { ?>
				<?php echo empty($shop['levelname'])?'无会员标签组':$shop['levelname']?>;
				<?php  } ?>
				<?php  if(is_array($levels)) { foreach($levels as $level) { ?>
				<?php  if($item['buygroups']!='' && is_array($item['buygroups'])  && in_array($level['id'], $item['buygroups'])) { ?>
				<?php  echo $level['levelname'];?>;
				<?php  } ?>
				<?php  } } ?>
				<?php  } ?>
			</div>

			<?php  } ?>

		</div>
	</div>
	</div>
</div>