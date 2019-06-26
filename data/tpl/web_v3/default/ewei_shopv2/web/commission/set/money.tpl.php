<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
    <label class="col-lg control-label">提现方式</label>
    <div class="col-sm-9 col-xs-12" >
        <?php if(cv('commission.set.edit')) { ?>
        <label for="cashcredit" class="checkbox-inline">
            <input type="checkbox" name="data[cashcredit]" value="1" id="cashcredit" <?php  if(!empty($data['cashcredit'])) { ?>checked="true"<?php  } ?> /> 提现到商城余额
        </label>
        <label for="cashweixin" class="checkbox-inline">
            <input type="checkbox" name="data[cashweixin]" value="1" id="cashweixin" <?php  if(!empty($data['cashweixin'])) { ?>checked="true"<?php  } ?> /> 提现到微信钱包
        </label>
        <label for="cashother" class="checkbox-inline">
            <input type="checkbox" name="data[cashother]" value="1" id="cashother" <?php  if(!empty($data['cashother'])) { ?>checked="true"<?php  } ?> /> 其他提现方式
        </label>
        <div class='help-block'>提示: 提现方式支持多选</div>
        <?php  } else { ?> <div class='form-control-static'>
        <?php  if($data['cashcredit']==1) { ?>提现到商城余额; <?php  } ?>
        <?php  if($data['cashweixin']==1) { ?>提现到微信钱包; <?php  } ?>
        <?php  if($data['cashother']==1) { ?>其他提现方式; <?php  } ?>
    </div>
        <?php  } ?>
    </div>
</div>

<div class="form-group cashother-group" <?php  if(empty($data['cashother'])) { ?>style="display: none;"<?php  } ?>>
    <label class="col-lg control-label">其他提现方式</label>
    <div class="col-sm-9 col-xs-12" >
        <?php if(cv('commission.set.edit')) { ?>
        <label for="cashalipay" class="checkbox-inline">
            <input type="checkbox" name="data[cashalipay]" value="1" id="cashalipay" <?php  if(!empty($data['cashalipay'])) { ?>checked="true"<?php  } ?> /> 手动提现到支付宝
        </label>
        <label for="cashcard" class="checkbox-inline">
            <input type="checkbox" name="data[cashcard]" value="1" id="cashcard" <?php  if(!empty($data['cashcard'])) { ?>checked="true"<?php  } ?> /> 手动提现到银行卡
        </label>
        <div class='help-block'>支持的银行请到<a href='<?php  echo webUrl('commission/bank')?>' target='_blank'>【银行设置】</a>进行设置,使用手动提现到银行卡必须设置支持的银行</div>
        <?php  } else { ?> <div class='form-control-static'>
        <?php  if($data['cashalipay']==1) { ?>手动提现到支付宝; <?php  } ?>
        <?php  if($data['cashweixin']==1) { ?>手动提现到银行卡; <?php  } ?>
    </div>
        <?php  } ?>
    </div>
</div>

<!--<div class="form-group">
    <label class="col-lg control-label">开启提现到余额</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('commission.set.edit')) { ?>
        <label class="radio-inline"><input type="radio"  name="data[closetocredit]" value="0" <?php  if($data['closetocredit'] ==0) { ?> checked="checked"<?php  } ?> /> 开启</label>
        <label class="radio-inline"><input type="radio"  name="data[closetocredit]" value="1" <?php  if($data['closetocredit'] ==1) { ?> checked="checked"<?php  } ?> /> 关闭</label>
        <?php  } else { ?>
        <?php  if($data['closetocredit']==0) { ?>开启<?php  } else { ?>关闭<?php  } ?>
        <?php  } ?>
        <span class="help-block">是否允许用户佣金提现到余额，否则只允许微信提现</span>
    </div>
</div>-->

<div class="form-group">
    <label class="col-lg control-label">提现额度</label>
    <div class="col-sm-9 col-xs-12 fixmore-input-group">
        <?php if(cv('commission.set.edit')) { ?>
        <input type="text" name="data[withdraw]" class="form-control" value="<?php echo empty($data['withdraw'])?1:$data['withdraw']?>"  />
        <span class="help-block">分销商的佣金达到此额度时才能提现,最低1元</span>
        <?php  } else { ?>
        <?php echo empty($data['withdraw'])?1:$data['withdraw']?>
        <?php  } ?>
    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">佣金计算方式</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('commission.set.edit')) { ?>
        <label class="radio-inline"><input type="radio"  name="data[commissiontype]" value="0" <?php  if($data['commissiontype'] ==0) { ?> checked="checked"<?php  } ?> /> 默认方式</label>
        <label class="radio-inline"><input type="radio"  name="data[commissiontype]" value="1" <?php  if($data['commissiontype'] ==1) { ?> checked="checked"<?php  } ?> /> 实际支付方式</label>
        <span class="help-block">默认方式: 除运费和会员折扣(或促销折扣)外其他所有费用全部计算佣金<br>实际支付方式: 只计算实际支付和余额抵扣部分的佣金(包括余额支付)</span>
        <?php  } else { ?>
        <?php  if($data['commissiontype']==0) { ?>开启<?php  } else { ?>关闭<?php  } ?>
        <?php  } ?>
    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">佣金提现手续费</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('commission.set.edit')) { ?>
        <div class="input-group fixmore-input-group">
            <input type="text" name="data[withdrawcharge]" class="form-control" value="<?php  echo $data['withdrawcharge'];?>" />
            <div class="input-group-addon">%</div>
        </div>
        <span class="help-block">佣金提现时,扣除的提现手续费.空为不扣除提现手续费</span>
        <?php  } else { ?>
        <?php echo empty($data['withdrawcharge'])?1:$data['withdrawcharge']?>
        <?php  } ?>
    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">免提现手续费金额区间</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('sysset.trade.edit')) { ?>
        <div class='input-group fixmore-input-group'>
            <span class='input-group-addon'>开始金额￥</span>
            <input type="text" name="data[withdrawbegin]" class="form-control" value="<?php  echo $data['withdrawbegin'];?>" />
            <span class='input-group-addon'>结束金额￥</span>
            <input type="text" name="data[withdrawend]" class="form-control" value="<?php  echo $data['withdrawend'];?>" />
        </div>
        <span class='help-block'>当提现手续费金额在此区间内时,不扣除提现手续费. 结束金额 必须大于 开始金额才能生效</span>
        <span class='help-block'>例如 设置开始金额0元 结束金额5元,只有提现手续费金额高于5元时,才扣除</span>
        <?php  } else { ?>
        <input type="hidden" name="data[withdrawbegin]" value="<?php  echo $data['withdrawbegin'];?>"/>
        <input type="hidden" name="data[withdrawend]" value="<?php  echo $data['withdrawend'];?>"/>
        <div class='form-control-static'>
            <?php  echo $data['withdrawbegin'];?> 元 - <?php  echo $data['withdrawend'];?>元
        </div>
        <?php  } ?>
    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">结算天数</label>
    <div class="col-sm-9 col-xs-12 fixmore-input-group">
        <?php if(cv('commission.set.edit')) { ?>
        <input type="text" name="data[settledays]" class="form-control" value="<?php  echo $data['settledays'];?>"  />
        <span class="help-block">当订单完成后的n天后，佣金才能申请提现,设置0或空，订单完成就可以结算</span>
        <?php  } else { ?>
        <?php  echo $data['settledays'];?>
        <?php  } ?>
    </div>
</div>
<!--4000097827-->