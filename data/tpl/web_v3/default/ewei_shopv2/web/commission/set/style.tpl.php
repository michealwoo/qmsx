<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
    <label class="col-lg control-label">模板选择</label>
    <div class="col-sm-9 col-xs-12">
    <?php if(cv('commission.set.edit')) { ?>
		<select class='form-control' name='data[style]'>
		    <?php  if(is_array($styles)) { foreach($styles as $style) { ?>
		    <option value='<?php  echo $style;?>' <?php  if($style==$data['style']) { ?>selected<?php  } ?>><?php  echo $style;?></option>
		    <?php  } } ?>
		</select>
	<?php  } else { ?>
		<?php  echo $data['style'];?>
	<?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">注册面头部图片</label>
    <div class="col-sm-9 col-xs-12">
    	<?php if(cv('commission.set.edit')) { ?>
			<?php  echo tpl_form_field_image('data[regbg]',$data['regbg'],'../addons/ewei_shopv2/plugin/commission/template/mobile/default/static/images/bg.png')?>
		<?php  } else { ?>
			<?php  if(empty($data['regbg'])) { ?>
				<img src="../addons/ewei_shopv2/plugin/commission/template/mobile/default/static/images/bg.png" onerror="this.src='../addons/ewei_shopv2/plugin/commission/template/mobile/default/static/images/bg.png'; this.title='图片未找到.'" class="img-responsive img-thumbnail" width="150">
			<?php  } else { ?>
				<img src="<?php  echo tomedia($data['regbg'])?>" onerror="this.src='../addons/ewei_shopv2/plugin/commission/template/mobile/default/static/images/bg.png'; this.title='图片未找到.'" class="img-responsive img-thumbnail" width="150">
			<?php  } ?>
		<?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">分销商名称</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    	<input type="text" name="texts[agent]" class="form-control" value="<?php echo empty($data['texts']['agent'])?'分销商':$data['texts']['agent']?>"  />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['agent'])?'分销商':$data['texts']['agent']?></div>
	    <?php  } ?>
	</div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">小店</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    	<input type="text" name="texts[shop]" class="form-control" value="<?php echo empty($data['texts']['shop'])?'小店':$data['texts']['shop']?>"  />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['shop'])?'小店':$data['texts']['shop']?></div>
	    <?php  } ?>
	</div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">我的小店</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    	<input type="text" name="texts[myshop]" class="form-control" value="<?php echo empty($data['texts']['myshop'])?'我的小店':$data['texts']['myshop']?>"  />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['myshop'])?'我的小店':$data['texts']['myshop']?></div>
	    <?php  } ?>	
	</div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">分销中心</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    	<input type="text" name="texts[center]" class="form-control" value="<?php echo empty($data['texts']['center'])?'分销中心':$data['texts']['center']?>"  />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['center'])?'分销中心':$data['texts']['center']?></div>
	    <?php  } ?>	
	</div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">成为分销商</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    	<input type="text" name="texts[become]" class="form-control" value="<?php echo empty($data['texts']['become'])?'成为分销商':$data['texts']['become']?>"  />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['become'])?'成为分销商':$data['texts']['become']?></div>
	    <?php  } ?>
	</div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">提现</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    	<input type="text" name="texts[withdraw]" class="form-control" value="<?php echo empty($data['texts']['withdraw'])?'提现':$data['texts']['withdraw']?>"  />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['withdraw'])?'提现':$data['texts']['withdraw']?></div>
	    <?php  } ?>
	</div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">佣金</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    	<input type="text" name="texts[commission]" class="form-control" value="<?php echo empty($data['texts']['commission'])?'佣金':$data['texts']['commission']?>"  />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['commission'])?'佣金':$data['texts']['commission']?></div>
	    <?php  } ?>
	</div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">分销佣金</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    	<input type="text" name="texts[commission1]" class="form-control" value="<?php echo empty($data['texts']['commission1'])?'分销佣金':$data['texts']['commission1']?>"  />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['commission1'])?'分销佣金':$data['texts']['commission1']?></div>
	    <?php  } ?>
	</div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">累计佣金</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    	<input type="text" name="texts[commission_total]" class="form-control" value="<?php echo empty($data['texts']['commission_total'])?'累计佣金':$data['texts']['commission_total']?>"  />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['commission_total'])?'累计佣金':$data['texts']['commission_total']?></div>
	    <?php  } ?>
	</div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">可提现佣金</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    	<input type="text" name="texts[commission_ok]" class="form-control" value="<?php echo empty($data['texts']['commission_ok'])?'可提现佣金':$data['texts']['commission_ok']?>"  />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['commission_ok'])?'可提现佣金':$data['texts']['commission_ok']?></div>
	    <?php  } ?>
	</div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">已申请佣金</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    	<input type="text" name="texts[commission_apply]" class="form-control" value="<?php echo empty($data['texts']['commission_apply'])?'已申请佣金':$data['texts']['commission_apply']?>"  />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['commission_apply'])?'已申请佣金':$data['texts']['commission_apply']?></div>
	    <?php  } ?>
	</div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">待打款佣金</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    	<input type="text" name="texts[commission_check]" class="form-control" value="<?php echo empty($data['texts']['commission_check'])?'待打款佣金':$data['texts']['commission_check']?>"  />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['commission_check'])?'待打款佣金':$data['texts']['commission_check']?></div>
	    <?php  } ?>
	</div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">未结算佣金</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    	<input type="text" name="texts[commission_lock]" class="form-control" value="<?php echo empty($data['texts']['commission_lock'])?'未结算佣金':$data['texts']['commission_lock']?>"  />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['commission_lock'])?'未结算佣金':$data['texts']['commission_lock']?></div>
	    <?php  } ?>
	</div>
    </div>
</div>
<div class="form-group">
	<label class="col-lg control-label"></label>
	<div class="col-sm-9 col-xs-12">
		<div class="input-group">
			<div class="input-group-addon">待收货佣金</div>
			<?php if(cv('commission.set.edit')) { ?>
			<input type="text" name="texts[commission_wait]" class="form-control" value="<?php echo empty($data['texts']['commission_wait'])?'待收货佣金':$data['texts']['commission_wait']?>"  />
			<?php  } else { ?>
			<div class="form-control valid"><?php echo empty($data['texts']['commission_wait'])?'待收货佣金':$data['texts']['commission_wait']?></div>
			<?php  } ?>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="col-lg control-label"></label>
	<div class="col-sm-9 col-xs-12">
		<div class="input-group">
			<div class="input-group-addon">无效佣金</div>
			<?php if(cv('commission.set.edit')) { ?>
			<input type="text" name="texts[commission_fail]" class="form-control" value="<?php echo empty($data['texts']['commission_fail'])?'无效佣金':$data['texts']['commission_fail']?>"  />
			<?php  } else { ?>
			<div class="form-control valid"><?php echo empty($data['texts']['commission_fail'])?'无效佣金':$data['texts']['commission_fail']?></div>
			<?php  } ?>
		</div>
	</div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">成功提现佣金</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    	<input type="text" name="texts[commission_pay]" class="form-control" value="<?php echo empty($data['texts']['commission_pay'])?'成功提现佣金':$data['texts']['commission_pay']?>"  />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['commission_pay'])?'成功提现佣金':$data['texts']['commission_pay']?></div>
	    <?php  } ?>
	</div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
        <div class="input-group">
            <div class="input-group-addon">扣除提现手续费</div>
            <?php if(cv('commission.set.edit')) { ?>
            <input type="text" name="texts[commission_charge]" class="form-control" value="<?php echo empty($data['texts']['commission_charge'])?'扣除提现手续费':$data['texts']['commission_charge']?>"  />
            <?php  } else { ?>
            <div class="form-control valid"><?php echo empty($data['texts']['commission_charge'])?'成功提现佣金':$data['texts']['commission_charge']?></div>
            <?php  } ?>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">佣金明细</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    	<input type="text" name="texts[commission_detail]" class="form-control" value="<?php echo empty($data['texts']['commission_detail'])?'佣金明细':$data['texts']['commission_detail']?>"  />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['commission_detail'])?'佣金明细':$data['texts']['commission_detail']?></div>
	    <?php  } ?>
	</div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">分销订单</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    <input type="text" name="texts[order]" class="form-control" value="<?php echo empty($data['texts']['order'])?'分销订单':$data['texts']['order']?>"  />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['order'])?'分销订单':$data['texts']['order']?></div>
	    <?php  } ?>
	</div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">下线</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    	<input type="text" name="texts[down]" class="form-control" value="<?php echo empty($data['texts']['down'])?'下线':$data['texts']['down']?>"  />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['down'])?'下线':$data['texts']['down']?></div>
	    <?php  } ?>
	</div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">我的下线</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    	<input type="text" name="texts[mydown]" class="form-control" value="<?php echo empty($data['texts']['mydown'])?'我的下线':$data['texts']['mydown']?>"  />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['mydown'])?'我的下线':$data['texts']['mydown']?></div>
	    <?php  } ?>
	</div>
    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
	<div class="input-group">
	    <div class="input-group-addon">级别名称</div>
	    <?php if(cv('commission.set.edit')) { ?>
	    <input type="text" name="texts[c1]" class="form-control" value="<?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?>" style="width:100px;" />
	    <input type="text" name="texts[c2]" class="form-control" value="<?php echo empty($data['texts']['c2'])?'二级':$data['texts']['c2']?>" style="width:100px;" />
	    <input type="text" name="texts[c3]" class="form-control" value="<?php echo empty($data['texts']['c3'])?'三级':$data['texts']['c3']?>" style="width:100px;" />
	    <?php  } else { ?>
	    	<div class="form-control valid"><?php echo empty($data['texts']['c1'])?'一级':$data['texts']['c1']?></div>
	    	<div class="form-control valid"><?php echo empty($data['texts']['c2'])?'二级':$data['texts']['c2']?></div>
	    	<div class="form-control valid"><?php echo empty($data['texts']['c3'])?'三级':$data['texts']['c3']?></div>
	    <?php  } ?>
	</div>
    </div>
</div>

<div class="form-group">
	<label class="col-lg control-label"></label>
	<div class="col-sm-9 col-xs-12">
		<div class="input-group">
			<div class="input-group-addon">元</div>
			<?php if(cv('commission.set.edit')) { ?>
			<input type="text" name="texts[yuan]" class="form-control" value="<?php echo empty($data['texts']['yuan'])?'元':$data['texts']['yuan']?>"  />
			<?php  } else { ?>
			<div class="form-control valid"><?php echo empty($data['texts']['yuan'])?'我的下线':$data['texts']['yuan']?></div>
			<?php  } ?>
		</div>
	</div>
</div>

<div class="form-group">
	<label class="col-lg control-label"></label>
	<div class="col-sm-9 col-xs-12">
		<div class="input-group">
			<div class="input-group-addon">邀请码</div>
			<?php if(cv('commission.set.edit')) { ?>
			<input type="text" name="texts[icode]" class="form-control" value="<?php echo empty($data['texts']['icode'])?'邀请码':$data['texts']['icode']?>"  />
			<?php  } else { ?>
			<div class="form-control valid"><?php echo empty($data['texts']['icode'])?'邀请码':$data['texts']['icode']?></div>
			<?php  } ?>
		</div>
	</div>
</div>
<!--913702023503242914-->