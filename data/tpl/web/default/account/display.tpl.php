<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>

<!--新建弹窗-->
<div class="modal" id="owner-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">新建</h3>
			</div>
			<div class="modal-body">
				<div class="mask-creat">
					<ul>
						<?php  if(!empty($account_info['uniacid_limit']) && (!empty($account_info['founder_uniacid_limit']) && $_W['user']['owner_uid'] || empty($_W['user']['owner_uid'])) || $_W['isfounder'] && !user_is_vice_founder()) { ?>
						<li><i class="wi wi-wx-circle"></i><br/><a href="./index.php?c=account&a=post-step" class="name" title="新建公众号"></a></li>
						<?php  } ?>

						<?php  if(!empty($account_info['wxapp_limit']) && (!empty($account_info['founder_wxapp_limit']) && $_W['user']['owner_uid'] || empty($_W['user']['owner_uid'])) || $_W['isfounder'] && !user_is_vice_founder()) { ?>
						<li><i class="wi wi-wxapp"></i><br/><a href="<?php  echo url('wxapp/post/design_method')?>" class="name" title="新建小程序"></a></li>
						<?php  } ?>

						<?php  if(!empty($account_info['webapp_limit']) && (!empty($account_info['founder_webapp_limit']) && $_W['user']['owner_uid'] || empty($_W['user']['owner_uid'])) || $_W['isfounder'] && !user_is_vice_founder()) { ?>
						<li><i class="wi wi-pc-circle"></i><br/><a href="./index.php?c=webapp&a=manage&do=create_display" class="name" title="新建PC"></a></li>
						<?php  } ?>

						<?php  if(!empty($account_info['phoneapp_limit']) && (!empty($account_info['founder_phoneapp_limit']) && $_W['user']['owner_uid'] || empty($_W['user']['owner_uid'])) || $_W['isfounder'] && !user_is_vice_founder()) { ?>
						<li><i class="wi wi-app"></i><br/><a href="<?php  echo url('phoneapp/manage/create_display')?>" class="name" title="新建APP"></a></li>
						<?php  } ?>

						<?php  if(!empty($account_info['xzapp_limit']) && (!empty($account_info['founder_xzapp_limit']) && $_W['user']['owner_uid'] || empty($_W['user']['owner_uid'])) || $_W['isfounder'] && !user_is_vice_founder()) { ?>
						<li><i class="wi wi-app"></i><br/><a href="<?php  echo url('xzapp/post-step')?>" class="name" title="新建熊掌号"></a></li>
						<?php  } ?>

					</ul>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
			</div>
		</div>
	</div>
</div>

<div class="panel panel-cut" id="js-account-display" ng-controller="AccountDisplay" ng-cloak>
	<!--选项卡-->
	<div class="panel-heading mixMenu-panel-heading">
		<ul class="navbar-nav">
			<?php  if(is_array($nav_top_fold)) { foreach($nav_top_fold as $nav) { ?>
			<li <?php  if($type == $nav['name']) { ?> class="on-tab" <?php  } ?>>
			<a href="<?php  if(empty($nav['url'])) { ?><?php  echo url('home/welcome/' . $nav['name']);?><?php  } else { ?><?php  echo url('account/display/', array('type'=>$nav['name'], 'title'=>$nav['title']))?><?php  } ?>" <?php  if(!empty($nav['blank'])) { ?>target="_blank"<?php  } ?>>
			<?php  echo $nav['title'];?>
			</a>

			</li>
			<?php  } } ?>
		</ul>
	</div>
	<!--主体内容-->
	<div class="panel-body mixMenu-panel-body" >
		<!--全部应用-->
		<div class="cut-list ">
			<!--搜索、新建、管理-->
			<div class="we7-page-search cut-header">

				<div ng-if="searchShow" ng-cloak>
					<form action="./index.php" method="get">
						<input type="hidden" name="c" value="account">
						<input type="hidden" name="a" value="display">
						<input type="hidden" name="do" value="display" ng-if="type == 'all'">
						<input type="hidden" name="type" value="{{type}}">
						<input type="hidden" name="title" value="{{title}}">
						<input type="text" name="letter" ng-model="activeLetter" ng-style="{'display': 'none'}">
						<div class="cut-search">
							<div class="input-group pull-left">
								<input type="text" class="form-control" name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入{{title}}名称">
								<span class="input-group-btn"><button class="btn btn-default button"><i class="wi wi-search"></i></button></span>
							</div>
						</div>
					</form>
				</div>

				<div class="font-default pull-right">
					
					<div class="creat" ng-switch="type">
						<a ng-switch-when="all" href="javascript:;" data-toggle="modal" data-target="#owner-modal" class="color-default"><i class="wi wi-registersite"></i>新增应用</a>

						<?php  if(!empty($account_info['uniacid_limit']) && (!empty($account_info['founder_uniacid_limit']) && $_W['user']['owner_uid'] || empty($_W['user']['owner_uid'])) || $_W['isfounder'] && !user_is_vice_founder()) { ?>
						<a ng-switch-when="account" href="./index.php?c=account&a=post-step" class="color-default">
							<i class="wi wi-registersite"></i>新增公众号
						</a>
						<?php  } ?>

						<?php  if(!empty($account_info['wxapp_limit']) && (!empty($account_info['founder_wxapp_limit']) && $_W['user']['owner_uid'] || empty($_W['user']['owner_uid'])) || $_W['isfounder'] && !user_is_vice_founder()) { ?>
						<a ng-switch-when="wxapp" href="<?php  echo url('wxapp/post/design_method')?>" class="color-default"><i class="wi wi-registersite"></i>新建小程序</a>
						<?php  } ?>

						<?php  if(!empty($account_info['webapp_limit']) && (!empty($account_info['founder_webapp_limit']) && $_W['user']['owner_uid'] || empty($_W['user']['owner_uid'])) || $_W['isfounder'] && !user_is_vice_founder()) { ?>
						<a ng-switch-when="webapp" href="./index.php?c=webapp&a=manage&do=create_display" class="color-default">
							<i class="wi wi-registersite"></i>新增PC
						</a>
						<?php  } ?>

						<?php  if(!empty($account_info['phoneapp_limit']) && (!empty($account_info['founder_phoneapp_limit']) && $_W['user']['owner_uid'] || empty($_W['user']['owner_uid'])) || $_W['isfounder'] && !user_is_vice_founder()) { ?>
						<a ng-switch-when="phoneapp" href="<?php  echo url('phoneapp/manage/create_display')?>" class="color-default"><i class="wi wi-registersite"></i>新建APP</a>
						<?php  } ?>

						<?php  if(!empty($account_info['xzapp_limit']) && (!empty($account_info['founder_xzapp_limit']) && $_W['user']['owner_uid'] || empty($_W['user']['owner_uid'])) || $_W['isfounder'] && !user_is_vice_founder()) { ?>
						<a ng-switch-when="xzapp" href="<?php  echo url('xzapp/post-step')?>" class="color-default"><i class="wi wi-registersite"></i>新建熊掌号</a>
						<?php  } ?>

					</div>
					

					

					<div class="setting" ng-switch="type">
						<?php  if(in_array($_W['highest_role'], array(ACCOUNT_MANAGE_NAME_FOUNDER, ACCOUNT_MANAGE_NAME_VICE_FOUNDER, ACCOUNT_MANAGE_NAME_OWNER,ACCOUNT_MANAGE_NAME_MANAGER))) { ?>
						<a ng-switch-when="account" href="<?php  echo url('account/manage', array('account_type' => ACCOUNT_TYPE_OFFCIAL_NORMAL))?>" class="color-default">
							<i class="wi wi-manage"></i>
							公众号管理
						</a>

						<a ng-switch-when="webapp" href="<?php  echo url('account/manage', array('account_type' => ACCOUNT_TYPE_WEBAPP_NORMAL))?>" class="color-default">
							<i class="wi wi-manage"></i>
							PC管理
						</a>
						<?php  } ?>

						<a ng-switch-when="wxapp" href="<?php  echo url('account/manage', array('account_type' => ACCOUNT_TYPE_APP_NORMAL))?>" class="color-default">
							<i class="wi wi-manage"></i>小程序管理
						</a>

						<a ng-switch-when="phoneapp" href="<?php  echo url('account/manage', array('account_type' => ACCOUNT_TYPE_PHONEAPP_NORMAL))?>" class="color-default">
							<i class="wi wi-manage"></i>
							APP管理
						</a>

						<a ng-switch-when="xzapp" href="<?php  echo url('account/manage', array('account_type' => ACCOUNT_TYPE_XZAPP_NORMAL))?>" class="color-default">
							<i class="wi wi-manage"></i>
							熊掌号管理
						</a>

					</div>

				</div>
			</div>

			<!--首字母检索-->
			<div class="clearfix"></div>
			<ul class="letters-list" ng-if="searchShow" ng-cloak>
				<li ng-repeat="letter in alphabet" ng-style="{'background-color': letter == activeLetter ? '#ddd' : 'none'}" ng-class="{'active': letter == activeLetter}" ng-click="searchModule(letter)" class="ng-scope">
					<a href="javascript:;" ng-bind="letter" class="ng-binding"></a>
				</li>
			</ul>

			<!--列表数据-->
			<!--add-->
			<div class="mixMenu-list clearfix" ng-if="list" infinite-scroll='loadMore()' infinite-scroll-disabled='busy' infinite-scroll-distance='0' infinite-scroll-use-document-bottom="true">
				<!--add-->
				<div class="item module-list-item ng-scope" ng-repeat="detail in list" ng-if="list" style="">
					<div class="content">
						<img class="item-logo" ng-src="{{detail.logo}}" onerror="this.src='./resource/images/nopic-107.png'">
						<div class="item-footer">

							<div class="item-icon">
								<i ng-if="detail.type == types.account_normal" class="wi wi-wechat"></i>
								<i ng-if="detail.type == types.account_auth" class="wi wi-wechat"></i>
								<i ng-if="detail.type == types.wxapp_normal" class="wi wi-wxapp"></i>
								<i ng-if="detail.type == types.wxapp_auth" class="wi wi-wxapp"></i>
								<i ng-if="detail.type == types.webapp" class="wi wi-pc"></i>
								<i ng-if="detail.type == types.phoneapp" class="wi wi-app"></i>
								<i ng-if="detail.type == types.xzapp" class="wi wi-xzapp"></i>
							</div>
							<div class="info">
								<div class="name" ng-bind="detail.name"></div>
								<div class="type" ng-if="detail.type == types.account_normal || detail.type == types.account_auth">
									<span ng-if="detail.level == 1">类型：普通订阅号</span>
									<span ng-if="detail.level == 2">类型：普通服务号</span>
									<span ng-if="detail.level == 3">类型：认证订阅号</span>
									<span ng-if="detail.level == 4">类型：认证服务号</span>
								</div>

								<div class="type" ng-if="detail.type == types.wxapp_normal || detail.type == types.wxapp_auth || detail.type == types.phoneapp">
									<span>版本：{{detail.current_version.version}}</span>
								</div>

								<div class="type" ng-if="detail.type == types.webapp">
									<span>类型：PC应用</span>
								</div>


								<div class="type" ng-if="detail.type == types.xzapp">
									<span>类型：熊掌号</span>
								</div>

							</div>

						</div>
					</div>
					<!--鼠标悬停遮罩效果-->
					<div class="mask">
						<!-- 进入公众号/PC -->
						<a href="{{detail.switchurl}}&type={{detail.type}}" class="entry" ng-if="detail.type == types.account_normal || detail.type == types.account_auth"><div>进入公众号 <i class="wi wi-angle-right"></i></div></a>

						<!-- 进入PC -->
						<a href="{{detail.switchurl}}" class="entry" ng-if="detail.type == types.webapp"><div>进入PC <i class="wi wi-angle-right"></i></div></a>

						<!-- 进入小程序 -->
						<a ng-href="{{links.switch}}uniacid={{detail.uniacid}}&multiid={{detail.current_version.multiid}}&version_id={{detail.current_version.id}}&type={{detail.type}}" class="entry" ng-if="detail.type == types.wxapp_normal || detail.type == types.wxapp_auth"><div>进入小程序 <i class="wi wi-angle-right"></i></div></a>

						<!-- 进入 APP -->
						<a ng-href="{{links.switch}}uniacid={{detail.uniacid}}&version_id={{detail.current_version.id}}&type={{detail.type}}" class="entry" ng-if="detail.type == types.phoneapp">
							<div>进入APP <i class="wi wi-angle-right"></i></div>
						</a>

						<!-- 进入熊掌号 -->
						<a href="{{detail.switchurl}}&type={{detail.type}}" class="entry" ng-if="detail.type == types.xzapp"><div>进入熊掌号 <i class="wi wi-angle-right"></i></div></a>

						<!-- 小程序/APP 查看版本 -->
						<a href="javascript:;" class="cut-btn" ng-click="showVersions($event)" ng-if="detail.type == types.wxapp_normal || detail.type == types.wxapp_auth || detail.type == types.phoneapp">
							<i class="wi wi-changing-over"></i>
						</a>

						<!-- 添加到首页 -->
						<?php  if(!permission_check_account_user('see_user_profile_account_num')) { ?>
						<a ng-href="{{links.welcome}}uniacid={{detail.uniacid}}" onclick="return ajaxopen(this.href);" class="home-show" title="添加到首页常用功能">
							<i class="wi wi-eye"></i>
						</a>
						<?php  } ?>

						<!-- 置顶 -->
						<a href="javascript:;" class="stick" ng-click="stick(detail.uniacid, detail.type)" title="置顶">
							<i class="wi wi-stick-sign"></i>
						</a>
					</div>
					<!-- 小程序/APP版本查看 -->
					<div class="cut-select" ng-mouseleave="hideSelect($event)" ng-if="detail.versions">
						<div class="arrow-left"></div>
						<div class="cut-item">
							<a href="javascript:;">
								<div class="detail" ng-repeat="version in detail.versions">
									<div class="text-over"><span class="wi wi-small-routine"></span>{{version.version}}</div>
									<a class="cut-select-mask" href="{{links.switch}}&uniacid={{detail.uniacid}}&multiid={{version.multiid}}&version_id={{version.id}}&type={{detail.type}}">
										<div class="entry">选择进入 <i class="wi wi-angle-right"></i></div>
									</a>
								</div>
							</a>
						</div>
						<div class="cut-select-pager">
							<a href="{{links.wxapp_more_version}}&uniacid={{detail.uniacid}}" class="more color-default" ng-if="detail.type == types.wxapp_normal || detail.type == types.wxapp_auth">更多 >></a>
						</div>
					</div>
				</div>
			</div>
			<ul ng-if="!list" style="text-align:center;width:100%"><span ng-if="!list">暂无数据</span></ul>
		</div>
	</div>
</div>

<script>
	angular.module('accountApp').value('config', {
		'list' : <?php echo !empty($list) ? json_encode($list) : 'null'?>,
		'type' : "<?php  echo $type;?>",
		'title' : "<?php  echo $title;?>",
		'keyword' : "<?php  echo $keyword;?>",
		'letter' : "<?php  echo $letter;?>",
		'total' : '<?php  echo $total;?>',
		'links' : {
		'rank' : "<?php  echo url('account/display/rank')?>",
			'switch' : "<?php  echo url('account/display/switch')?>",
			'welcome' : "<?php  echo url('home/welcome/add_welcome')?>",
			'wxapp_more_version' : "<?php  echo url('wxapp/version/display')?>",
			'phoneapp_more_version' : "<?php  echo url('phoneapp/version/display')?>"
	},
	'types' : {
			'account_normal' : "<?php echo ACCOUNT_TYPE_OFFCIAL_NORMAL;?>",
			'account_auth' : "<?php echo ACCOUNT_TYPE_OFFCIAL_AUTH;?>",
			'wxapp_normal' : "<?php echo ACCOUNT_TYPE_APP_NORMAL;?>",
			'wxapp_auth' : "<?php echo ACCOUNT_TYPE_APP_AUTH;?>",
			'webapp' : "<?php echo ACCOUNT_TYPE_WEBAPP_NORMAL;?>",
			'phoneapp' : "<?php echo ACCOUNT_TYPE_PHONEAPP_NORMAL;?>",
			'xzapp' : "<?php echo ACCOUNT_TYPE_XZAPP_NORMAL;?>"
	},
	scrollUrl : "<?php  echo url('account/display', array('type'=>$type))?>"
	});

	angular.bootstrap($('#js-account-display'), ['accountApp']);
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 0) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>