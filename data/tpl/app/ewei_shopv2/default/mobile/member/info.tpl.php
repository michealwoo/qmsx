<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
	#file-avatar {
		opacity: 0;
		position: absolute;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
		z-index: 9;
		background: red;
		width: 100%;
	}
	.fui-list-img{
		display: -webkit-box;
		display: -webkit-flex;
		display: flex;
		-webkit-flex-shrink: 0;
		-ms-flex: 0 0 auto;
		-webkit-flex-shrink: 0;
		flex-shrink: 0;
		-webkit-box-lines: single;
		-moz-box-lines: single;
		-webkit-flex-wrap: nowrap;
		flex-wrap: nowrap;
		box-sizing: border-box;
		-webkit-box-align: center;
		-webkit-align-items: center;
		align-items: center;
		margin-right: .6rem;
		color: #aaa;
		position: relative;
		margin-right: 0;
	}
	.fui-list-img img{
		width: 2.5rem;
		height: 2.5rem;
		border-radius: 50%;
	}
	.fui-cell-group .fui-cell  .fui-cell-remark.down:after {
		-webkit-transform: rotate(135deg);
		-ms-transform: rotate(135deg);
		transform: rotate(135deg);
		top:-.1rem;
	}
</style>
<div class='fui-page  fui-page-current'>
    <div class="fui-header">
		<div class="fui-header-left">
			<a class="back" onclick='location.back()'></a>
		</div>
		<div class="title">会员资料</div>
		<div class="fui-header-right">&nbsp;</div>
	</div>

	<div class='fui-content'>
		<?php  if(is_weixin()) { ?>
		<div id='btn-getinfo' class='text-danger' style="text-decoration: underline;text-align: right;padding-right: .6rem;padding-top: .3rem">读取微信资料</div>
		<?php  } ?>
		<!--<div class="fui-list-group">-->
			<!--<a class="fui-list" href="<?php  echo mobileUrl('member/info/face')?>" data-nocache="true">-->
				<!--<div class="fui-list-media">-->
					<!--<img class="round avatar" src="<?php  echo tomedia($member['avatar'])?>" />-->
				<!--</div>-->
				<!--<div class="fui-list-inner">-->
					<!--<div class="title nickname"><?php  echo $member['nickname'];?></div>-->
				<!--</div>-->
				<!--<div class="fui-list-angle">-->
					<!--<div class="angle"></div>-->
				<!--</div>-->
			<!--</a>-->
		<!--</div>-->
		<div class="fui-list-group">
			<input type="file" name="file-avatar" id="file-avatar" />
			<div class="fui-list" id="btn-avatar">
				<div class="fui-list-inner" style="color: #666;">头像</div>
				<div class="fui-list-img">
					<img src="<?php  echo $member['avatar'];?>" id="avatar"
						 data-wechat="<?php  echo $member['avatar_wechat'];?>"
						 data-filename="<?php  echo $member['avatar'];?>"
						 onerror="this.src='../addons/ewei_shopv2/static/images/noface.png';" />
				</div>
				<div class="angle"></div>
			</div>
		</div>
		<div class="fui-cell-group">
			<div class="fui-cell must ">
				<div class="fui-cell-label ">修改昵称</div>
				<div class="fui-cell-info"><input type="text" class='fui-input' id='nickname' data-wechat="<?php  echo $member['nickname_wechat'];?>" placeholder="请输入您的昵称"  value="<?php  echo $member['nickname'];?>" /></div>
			</div>
		</div>
		<?php  if(!empty($wapset['open'])) { ?>
		<div class="fui-cell-group">
			<div class="fui-cell must">
				<div class="fui-cell-label">手机号</div>
				<div class="fui-cell-info c000"><?php  if(empty($member['mobile'])) { ?>未绑定手机号<?php  } else { ?><?php  echo $member['mobile'];?><?php  } ?><?php  if(!empty($member['mobileverify'])) { ?>(已绑定)<?php  } ?></div>
				<?php  if(!empty($member['mobile'])) { ?>
				<input type="hidden" name="mobile" id="mobile" value="<?php  echo $member['mobile'];?>"/>
				<?php  } ?>
				<a class="fui-cell-remark external" href="<?php  echo mobileUrl('member/bind')?>"><?php  if(empty($member['mobile'])) { ?>绑定<?php  } else { ?>更换绑定<?php  } ?></a>
			</div>
		</div>
		<?php  } ?>

		<?php  if(empty($template_flag)) { ?>
			 
		<div class="fui-cell-group">
			<div class="fui-cell must ">
				<div class="fui-cell-label ">姓名</div>
				<div class="fui-cell-info c000"><input type="text" class='fui-input' id='realname' name='realname' placeholder="请输入您的姓名"  value="<?php  echo $member['realname'];?>" /></div>
			</div>

			<?php  if(empty($wapset['open'])) { ?>
				<div class="fui-cell must">
					<div class="fui-cell-label">手机号</div>
					<div class="fui-cell-info c000"><input type="text" class='fui-input' id='mobile' name='mobile' placeholder="请输入您的手机号"  value="<?php  echo $member['mobile'];?>" /></div>
				</div>
			<?php  } ?>
			
			<div class="fui-cell">
				<div class="fui-cell-label">微信号</div>
				<div class="fui-cell-info c000"><input type="text"  class='fui-input'  id='weixin' name='weixin' placeholder="请输入您的微信号"  value="<?php  echo $member['weixin'];?>" /></div>
			</div>
			<div class="fui-cell">
				<div class="fui-cell-label">出生日期</div>
				<div class="fui-cell-info c000"><input type="text"  class='fui-input'  id='birthday' name='birthday' placeholder="请选择出生日期"  value="<?php  echo $member['birthday'];?>" readonly/></div>
				<div class="fui-cell-remark down" ></div>
			</div>
			<div class="fui-cell">
				<div class="fui-cell-label ">所在城市</div>
				<div class="fui-cell-info c000"><input type="text"  class='fui-input'  id='city' name='city' placeholder="请选择城市"  value="<?php  if(!empty($show_data) && !empty($member) && !empty($member['city'])) { ?><?php  echo $member['province'];?> <?php  echo $member['city'];?><?php  } ?>" data-value="<?php  if(!empty($show_data)) { ?><?php  echo $member['datavalue'];?><?php  } ?>" readonly/></div>
				<div class="fui-cell-remark down" ></div>
			</div>
		 
		</div>
		<?php  } else { ?>
		   <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('diyform/formfields', TEMPLATE_INCLUDEPATH)) : (include template('diyform/formfields', TEMPLATE_INCLUDEPATH));?>
		<?php  } ?>
		<a href='#' id='btn-submit' class='btn btn-danger block mtop'>确认修改</a>
	</div>
	<script language='javascript'>
		require(['biz/member/info'], function (modal) {
		  	modal.init({
			    new_area:<?php  echo $new_area?>,
			    returnurl:"<?php  echo $returnurl?>",
			    template_flag: <?php  echo intval($template_flag)?>,
				wapopen: <?php  echo intval($wapset['open'])?>
			});
	});
</script>
	<script language='javascript'>
        require(['biz/member/info'], function (modal) {
            modal.initFace({});
        });
	</script>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

