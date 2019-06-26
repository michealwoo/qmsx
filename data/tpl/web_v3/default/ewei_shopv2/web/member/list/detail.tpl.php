<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">当前位置：<span class="text-primary">会员详情</span></div>
<div class="page-content">


<form <?php  if('member.list.edit') { ?>action="" method='post'<?php  } ?> class='form-horizontal form-validate'>
 <input type="hidden" name="referer" value="" />
	<div class="tabs-container">

		<div class="tabs">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#tab-basic" aria-expanded="true"> 基本信息</a></li>
				<li class=""><a data-toggle="tab" href="#tab-trade" aria-expanded="false"> 交易信息</a></li>
				
                               
				<?php  if($hascommission) { ?> <?php if(cv('commission.agent.main')) { ?>
				<li class=""><a data-toggle="tab" href="#tab-commission" aria-expanded="false"> 分销商信息</a></li>
                                                        <?php  } ?>
                                                        <?php  } ?>
				<?php  if($hasglobonus) { ?>
				<li class=""><a data-toggle="tab" href="#tab-globonus" aria-expanded="false">股东信息</a></li>
				<?php  } ?>

				<?php  if($hasauthor) { ?>
				<li class=""><a data-toggle="tab" href="#tab-author" aria-expanded="false">创始人信息</a></li>
				<?php  } ?>

				<?php  if($hasabonus) { ?>
				<li class=""><a data-toggle="tab" href="#tab-abonus" aria-expanded="false">区域代理信息</a></li>
				<?php  } ?>

				<?php  if($hassns) { ?>
				<li class=""><a data-toggle="tab" href="#tab-sns" aria-expanded="false">社区信息</a></li>
				<?php  } ?>

			</ul>
			<div class="tab-content ">
				<div id="tab-basic" class="tab-pane active"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('member/detail/basic', TEMPLATE_INCLUDEPATH)) : (include template('member/detail/basic', TEMPLATE_INCLUDEPATH));?></div>
				<div id="tab-trade" class="tab-pane"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('member/detail/trade', TEMPLATE_INCLUDEPATH)) : (include template('member/detail/trade', TEMPLATE_INCLUDEPATH));?></div>
				<?php  if($hascommission) { ?>
                <?php if(cv('commission.agent.main')) { ?>

				<div id="tab-commission" class="tab-pane">
                    <?php  if(p('cmember')) { ?>
                    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('cmember/commission', TEMPLATE_INCLUDEPATH)) : (include template('cmember/commission', TEMPLATE_INCLUDEPATH));?>
                    <?php  } else { ?>
                    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('member/detail/commission', TEMPLATE_INCLUDEPATH)) : (include template('member/detail/commission', TEMPLATE_INCLUDEPATH));?>
                    <?php  } ?>
                </div>
				<?php  } ?>
				<?php  } ?>

				<?php  if($hasglobonus) { ?>
				<div id="tab-globonus" class="tab-pane"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('member/detail/globonus', TEMPLATE_INCLUDEPATH)) : (include template('member/detail/globonus', TEMPLATE_INCLUDEPATH));?></div>
				<?php  } ?>

				<?php  if($hasauthor) { ?>
				<div id="tab-author" class="tab-pane"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('member/detail/author', TEMPLATE_INCLUDEPATH)) : (include template('member/detail/author', TEMPLATE_INCLUDEPATH));?></div>
				<?php  } ?>

				<?php  if($hasabonus) { ?>
				<div id="tab-abonus" class="tab-pane "><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('member/detail/abonus', TEMPLATE_INCLUDEPATH)) : (include template('member/detail/abonus', TEMPLATE_INCLUDEPATH));?></div>
				<?php  } ?>


				<?php  if($hassns) { ?>
				<div id="tab-sns" class="tab-pane "><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('member/detail/sns', TEMPLATE_INCLUDEPATH)) : (include template('member/detail/sns', TEMPLATE_INCLUDEPATH));?></div>
				<?php  } ?>
				
			</div>
		</div>
	</div>
	<div class="form-group"></div>	
          <div class="form-group">
		<label class="col-lg control-label"></label>
		<div class="col-sm-9 col-xs-12">
			<?php if(cv('member.list.edit')) { ?>
			<input type="submit"  value="提交" class="btn btn-primary" />
			<?php  } ?>
			<input type="button" class="btn btn-default" name="submit" onclick="history.back();" value="返回列表" <?php if(cv('member.list.edit')) { ?>style='margin-left:10px;'<?php  } ?> />
		</div>
	</div>

</form>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--913702023503242914-->