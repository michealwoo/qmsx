<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
    <label class="col-lg control-label">社区等级</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('sns.level.edit')) { ?>
        <select name='snsdata[level]' class='form-control'>
            <option value='0'><?php echo empty($plugin_sns_set['levelname'])?'社区粉丝':$plugin_sns_set['levelname']?> </option>
            <?php  if(is_array($snslevels)) { foreach($snslevels as $level) { ?>
            <option value="<?php  echo $level['id'];?>" <?php  if($sns_member['level']==$level['id']) { ?>selected<?php  } ?>><?php  echo $level['levelname'];?></option>
            <?php  } } ?>
        </select>
        <?php  } else { ?>
        <input type="hidden" name="snsdata[level]" class="form-control" value="<?php  echo $sns_member['level'];?>"  />

        <?php  if(empty($member['aagentlevel'])) { ?>
        <?php echo empty($plugin_sns_set['levelname'])?'默认等级':$plugin_sns_set['levelname']?>
        <?php  } else { ?>
        <?php  echo pdo_fetchcolumn('select levelname from '.tablename('ewei_shop_sns_level').' where id=:id limit 1',array(':id'=>$sns_member['level']))?>
        <?php  } ?>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">话题数</label>
    <div class="col-sm-9 col-xs-12">
        <div class='form-control-static'><?php  echo $sns_member['postcount'];?></div>
    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">评论数</label>
    <div class="col-sm-9 col-xs-12">
        <div class='form-control-static'><?php  echo $sns_member['replycount'];?></div>
    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">社区积分</label>
    <div class="col-sm-9 col-xs-12">
        <div class='form-control-static'><?php  echo $sns_member['credit'];?></div>
    </div>
</div>


<div class="form-group">
    <label class="col-lg control-label">注册时间</label>
    <div class="col-sm-9 col-xs-12">
        <div class='form-control-static'><?php echo empty($sns_member['createtime']) ? '' : date('Y-m-d H:i:s',$sns_member['createtime'])?></div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">强制不自动升级</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('sns.level.edit')) { ?>
        <label class="radio-inline" ><input type="radio" name="snsdata[notupgrade]" value="0" <?php  if($sns_member['notupgrade']==0) { ?>checked<?php  } ?>>允许自动升级</label>
        <label class="radio-inline"><input type="radio" name="snsdata[notupgrade]" value="1" <?php  if($sns_member['notupgrade']==1) { ?>checked<?php  } ?>>强制不自动升级</label>
        <span class="help-block">如果强制不自动升级，满足任何条件，此会员的社区级别也不会改变</span>
        <?php  } else { ?>
        <input type="hidden" name="snsdata[notupgrade]" class="form-control" value="<?php  echo $member['notupgrade'];?>"  />
        <div class='form-control-static'><?php  if($sns_member['notupgrade']==1) { ?>强制不自动升级<?php  } else { ?>允许自动升级<?php  } ?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">黑名单</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('sns.level.edit')) { ?>
        <label class="radio-inline"><input type="radio" name="snsdata[isblack]" value="1" <?php  if($sns_member['isblack']==1) { ?>checked<?php  } ?>>是</label>
        <label class="radio-inline" ><input type="radio" name="snsdata[isblack]" value="0" <?php  if($sns_member['isblack']==0) { ?>checked<?php  } ?>>否</label>
        <input type='hidden' name='oldsnsisblack' value="<?php  echo $sns_member['isblack'];?>" />
        <?php  } else { ?>
        <div class='form-control-static'><?php  if($sns_member['isblack']==1) { ?>是<?php  } else { ?>否<?php  } ?></div>
        <?php  } ?>
    </div>
</div>
