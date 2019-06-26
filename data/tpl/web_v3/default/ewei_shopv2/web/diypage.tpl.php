<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">
	当前位置：<span class="text-primary"><?php  echo m('plugin')->getName('diypage')?></span>
</div>

<div class="page-content ">
	<div class="page-toolbar">
		<?php if(cv('diypage.page.sys.add|diypage.page.diy.add')) { ?>
		<div class="">
			<div class="col-sm-12">
				<a class="btn btn-primary" href="<?php  echo webUrl('diypage/page/create')?>"><i class="fa fa-plus"></i> 立即创建页面</a>
			</div>
		</div>
		<?php  } ?>
	</div>
<div class="row">
	<div class="col-sm-4">
		<div class="summary_box">
			<div class="summary_title">
				<span class="text-default title_inner">系统页面</span>
				<?php if(cv('diypage.page.sys')) { ?>
					<ul style="float: right;padding-right: 30px">
						<a class="label label-primary" href="<?php  echo webUrl('diypage/page/sys')?>">管理</a>
					</ul>
				<?php  } ?>
			</div>
			<div class="summary flex">
					<div class="flex1 flex column" style="border-right: 1px solid #efefef">
						页面总数
						<h2 class="no-margins"><?php  echo intval($sysnumall)?></h2>
					</div>
					<div class="flex1 flex column">
						今日新增
						<h2 class="no-margins"><?php  echo intval($sysnumtoday)?></h2>
					</div>
			</div>
		</div>
	</div>

	<div class="col-sm-4">
		<div class="summary_box">
			<div class="summary_title">
				<?php if(cv('diypage.page.diy')) { ?>
					<ul style="float: right;padding-right: 30px">
						<a class="label label-success" href="<?php  echo webUrl('diypage/page/diy')?>">管理</a>
					</ul>
				<?php  } ?>
				<span class="text-default title_inner">自定义页面</span>
			</div>
			<div class="summary flex">
					<div class="flex1 flex column"  style="border-right: 1px solid #efefef">
						页面总数
						<h2 class="no-margins"><?php  echo intval($diynumall)?></h2>
					</div>
					<div class="flex1 flex column" >
						今日新增
						<h2 class="no-margins"><?php  echo intval($diynumtoday)?></h2>
					</div>
			</div>
		</div>
	</div>

	<div class="col-sm-4">
		<div class="summary_box">
			<div class="summary_title">
				<?php if(cv('diypage.menu')) { ?>
					<ul  style="float: right;padding-right: 30px">
						<a class="label label-danger" href="<?php  echo webUrl('diypage/menu')?>">管理</a>
					</ul>
				<?php  } ?>
				<span class="text-default title_inner">自定义菜单</span>
			</div>
			<div class="summary flex">
					<div class="flex1 flex column"  style="border-right: 1px solid #efefef">
						<p>菜单总数</p>
						<h2 class="no-margins"><?php  echo intval($menunumall)?></h2>
					</div>
					<div class="flex1 flex column">
						<p>今日新增</p>
						<h2 class="no-margins"><?php  echo intval($menunumtoday)?></h2>
					</div>
			</div>
		</div>
	</div>
</div>

<div class="row" style="padding: 0;">
	<div class="col-sm-12">
		<div class="summary_box" >
			<div class="summary_title">
				<span class="text-default title_inner"><?php  echo m('plugin')->getName('diypage')?>介绍</span>
			</div>
			<div class="summary_lg">
				<p></p>
				<p><?php  echo m('plugin')->getName('diypage')?>是一款页面DIY神器。</p>
				<p><?php  echo m('plugin')->getName('diypage')?>的核心主要分为：<a href="<?php  echo webUrl('diypage/page/sys')?>">商城主要页面DIY</a>、<a href="<?php  echo webUrl('diypage/page/diy')?>">自定义页面</a>、<a href="<?php  echo webUrl('diypage/menu')?>">自定义商城菜单</a>。</p>
				<p>系统页面介绍：用户可根据页面类型进行创建DIY页面，保存预览无误后可通过<a href="<?php  echo webUrl('diypage/shop/page')?>">商城页面</a>设置替换商城原有模版。</p>
				<p>自定义页面介绍：用户可根据自己的需求设计出需要的页面，可通过关键字进入或直接通过链接进入。</p>
				<p>自定义菜单介绍：用户可根据自己的需求设计出需要的页面，并通过<a href="<?php  echo webUrl('diypage/shop/menu')?>">商城菜单</a>设置替换商城原有的菜单模板。</p>
				<p>公用模块介绍：多个页面出现的相同元素可用公用模块来实现，创建一个公用模块后直接在系统页面、自定义页面中调用即可。</p>
				<p></p>
			</div>
		</div>
	</div>
</div>


</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--OTEzNzAyMDIzNTAzMjQyOTE0-->