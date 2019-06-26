<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
	.fui-icon-col.external.before:before{
		content: '';
		position: absolute;
		top: 1rem;
		bottom: 1rem;
		left: 0;
		width: 1px;
		background-color: #ebebeb;
		display: block;
		z-index: 15;
	}

</style>
<div class='fui-page  fui-page-current'>
    <div class="fui-header">
		<div class="fui-header-left">
			<a class="back" onclick='location.back()'></a>
		</div>
		<div class="title">会员中心</div>
		<div class="fui-header-right"></div>
	</div>

	<div class='fui-content member-page navbar'>
		<div style="overflow: hidden;height: 9rem;position: relative;background: #fff">
			<div class="headinfo" style="z-index:100;border: none;">
				<a class="setbtn" href="<?php  echo mobileUrl('member/info')?>" data-nocache='true'><i class="icon icon-shezhi"></i></a>
				<div class="child">
					<div class="title"><?php  echo $_W['shopset']['trade']['moneytext'];?></div>
					<div class="num"><?php  echo number_format($member['credit2'],2)?></div>
					<?php  if(empty($_W['shopset']['trade']['closerecharge'])) { ?><a href="<?php  echo mobileUrl('member/recharge')?>"><div class="btn">充值</div></a><?php  } ?>
				</div>
				<div class="child userinfo">
					<a href="<?php  echo mobileUrl('member/info')?>" data-nocache="true" style="color: white;">
						<div class="face"><img src="<?php  echo $member['avatar'];?>" onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'"/></div>
						<div class="name"><?php  echo $member['nickname'];?></div>
					</a>
					<div class="level" <?php  if(!empty($_W['shopset']['shop']['levelurl'])) { ?>onclick='location.href="<?php  echo $_W['shopset']['shop']['levelurl'];?>"'<?php  } ?>>
					<?php  if(empty($level['id'])) { ?>
					[<?php  if(empty($_W['shopset']['shop']['levelname'])) { ?>普通会员<?php  } else { ?><?php  echo $_W['shopset']['shop']['levelname'];?><?php  } ?>]
					<?php  } else { ?>
					[<?php  echo $level['levelname'];?>]
					<?php  } ?>
					<?php  if(!empty($_W['shopset']['shop']['levelurl'])) { ?><i class='icon icon-question1' style='font-size:0.65rem'></i><?php  } ?>
				</div>
			</div>
			<div class="child">
				<div class="title"><?php  echo $_W['shopset']['trade']['credittext'];?></div>
				<div class="num"><?php  echo number_format($member['credit1'],0)?></div>
				<?php  if($open_creditshop) { ?><a href="<?php  echo mobileUrl('creditshop')?>" class="external"><div class="btn">兑换</div></a><?php  } ?>
			</div>
		</div>
		<div class="member_header"></div>
		<?php  if($usermembercard) { ?>
		<a href="<?php  echo mobileUrl('membercard/index')?>" style="color: #ffffff">
		<div class='member_card'>
			<img class='icon' src='../addons/ewei_shopv2/static/images/icon-huangguan.png' />
			<div class='title'>我的会员卡</div>
			<?php  if(count($list_membercard['list'])) { ?>
			<div class='card-num'>已拥有<?php  echo count($list_membercard['list'])?>张</div>
			<?php  } else { ?>
			<div class='card-num'>已拥有0张</div>
			<?php  } ?>
		</div>
		</a>
		<?php  } ?>
		<image class='cover-img' src='../addons/ewei_shopv2/static/images/cover.png' />
		</div>

    <?php  if(p('task')) { ?>
        <?php  if(p('task')->get_unread()) { ?>
            <div class="fui-cell-group fui-cell-click" style="border-top: 1px solid #ebebeb;border-bottom: 1px solid #ebebeb;    margin-bottom: 0.5rem;">
                <a class="fui-cell external" href="<?php  echo mobileUrl('task')?>">
                    <div class="fui-cell-icon"><i class="icon icon-gifts"></i></div>
                    <style>
                        .task-red-mark{background-color: #ff5555;position: absolute;width: 6.9px;height: 6.9px;border-radius: 50%;display: block;left: 6.9rem;top: 0.69rem}
                    </style>
                    <div class="fui-cell-text"><p>您有奖励待领取</p><span class="task-red-mark"></span></div>
                    <div class="fui-cell-remark"></div>
                </a>
            </div>
        <?php  } else if(p('task')->TasknewEntrance()) { ?>
            <div class="fui-cell-group fui-cell-click" style="border-top: 1px solid #ebebeb;border-bottom: 1px solid #ebebeb;    margin-bottom: 0.5rem;">
                <a class="fui-cell" href="<?php  echo mobileUrl('task')?>">
                    <div class="fui-cell-icon"><i class="icon icon-gifts"></i></div>
                    <div class="fui-cell-text"><p>任务中心</p></div>
                    <div class="fui-cell-remark"></div>
                </a>
            </div>
        <?php  } ?>
    <?php  } ?>
	<div class="fui-cell-group fui-cell-click" style="margin-top: 0">
		<a class="fui-cell external" href="<?php  echo mobileUrl('order')?>">
			<div class="fui-cell-icon"><i class="icon icon-dingdan1"></i></div>
			<div class="fui-cell-text">我的订单</div>
			<div class="fui-cell-remark" style="font-size: 0.65rem;">查看全部订单</div>
		</a>
		<?php  $check_cycelbuy=p('cycelbuy')?>
		<div class="fui-icon-group selecter <?php  if($check_cycelbuy) { ?>col-5<?php  } else { ?>col-4<?php  } ?>">
			<a class="fui-icon-col external" href="<?php  echo mobileUrl('order',array('status'=>0))?>">
				<?php  if($statics['order_0']>0) { ?><div class="badge"><?php  echo $statics['order_0'];?></div><?php  } ?>
				<div class="icon icon-green radius"><i class="icon icon-daifukuan1"></i></div>
				<div class="text">待付款</div>
			</a>
			<a class="fui-icon-col external" href="<?php  echo mobileUrl('order',array('status'=>1))?>">
				<?php  if($statics['order_1']>0) { ?><div class="badge"><?php  echo $statics['order_1'];?></div><?php  } ?>
				<div class="icon icon-orange radius"><i class="icon icon-daifahuo1"></i></div>
				<div class="text">待发货</div>
			</a>
			<a class="fui-icon-col external" href="<?php  echo mobileUrl('order',array('status'=>2))?>">
				<?php  if($statics['order_2']>0) { ?><div class="badge"><?php  echo $statics['order_2'];?></div><?php  } ?>
				<div class="icon icon-blue radius"><i class="icon icon-daishouhuo1"></i></div>
				<div class="text">待收货</div>
			</a>
			<a class="fui-icon-col external" href="<?php  echo mobileUrl('order',array('status'=>4))?>">
				<?php  if($statics['order_4']>0) { ?><div class="badge"><?php  echo $statics['order_4'];?></div><?php  } ?>
				<div class="icon icon-pink radius"><i class="icon icon-daituikuan2"></i></div>
				<div class="text">退换货</div>
			</a>
			<?php  if($check_cycelbuy) { ?>
				<a class="fui-icon-col external before" href="<?php  echo mobileUrl('cycelbuy/order/list')?>">
					<div class="icon icon-pink radius"><i class="icon icon-xiangmuzhouqi" style="color: #ff6a54;"></i></div>
					<div class="text">周期购</div>
				</a>
			<?php  } ?>
		</div>
	</div>
		<?php  if($needbind) { ?>
			<div class="fui-cell-group fui-cell-click external">
				<a class="fui-cell"  href="<?php  echo mobileUrl('member/bind')?>">
					<div class="fui-cell-text">
						<i class="icon icon-shouji" style="color: #666;"></i>
							绑定手机号
						<div class="fui-cell-tip">如果您用手机号注册过会员或您想通过微信外购物请绑定您的手机号码</div>
					</div>
					<div class="fui-cell-remark"></div>
				</a>
			</div>
		<?php  } ?>

		<?php  if(!empty($roleuser)) { ?>
			<div class="fui-cell-group fui-cell-click external">
				<a class="fui-cell"  href="<?php  echo mobileUrl('mmanage')?>" data-nocache="true">
					<div class="fui-cell-text">
						<i class="icon icon-shouji" style="color: #666;"></i>
						<?php  echo m('plugin')->getName('mmanage')?>
						<div class="fui-cell-tip">当前用户已绑定操作员，您可以通过手机管理商城</div>
					</div>
					<div class="fui-cell-remark"></div>
				</a>
			</div>
		<?php  } ?>




	<?php  if($newstore_plugin) { ?>
	<div class="fui-cell-group fui-cell-click">
		<a class="fui-cell external" href="<?php  echo mobileUrl('newstore/norder')?>">
			<div class="fui-cell-icon"><i class="icon icon-list"></i></div>
			<div class="fui-cell-text">我的预约</div>
			<div class="fui-cell-remark" style="font-size: 0.65rem;">查看全部预约</div>
		</a>
		<div class="fui-icon-group selecter">
			<a class="fui-icon-col external" href="<?php  echo mobileUrl('newstore/norder',array('status'=>0))?>">
				<?php  if($statics['norder_0']>0) { ?><div class="badge"><?php  echo $statics['norder_0'];?></div><?php  } ?>
				<div class="icon icon-green radius"><i class="icon icon-pay"></i></div>
				<div class="text">待付款</div>
			</a>
			<a class="fui-icon-col external" href="<?php  echo mobileUrl('newstore/norder',array('status'=>1))?>">
				<?php  if($statics['norder_1']>0) { ?><div class="badge"><?php  echo $statics['norder_1'];?></div><?php  } ?>
				<div class="icon icon-orange radius"><i class="icon icon-like"></i></div>
				<div class="text">待使用</div>
			</a>
			<a class="fui-icon-col external" href="<?php  echo mobileUrl('newstore/norder',array('status'=>3))?>">
				<?php  if($statics['norder_3']>0) { ?><div class="badge"><?php  echo $statics['norder_3'];?></div><?php  } ?>
				<div class="icon icon-blue radius"><i class="icon icon-discover"></i></div>
				<div class="text">已完成</div>
			</a>
			<a class="fui-icon-col external" href="<?php  echo mobileUrl('newstore/norder',array('status'=>4))?>">
				<?php  if($statics['norder_4']>0) { ?><div class="badge"><?php  echo $statics['norder_4'];?></div><?php  } ?>
				<div class="icon icon-pink radius"><i class="icon icon-remind"></i></div>
				<div class="text">取消预约</div>
			</a>
		</div>
	</div>
	<?php  } ?>


	<?php  if(!empty($haveverifygoods)) { ?>
	<div class="fui-cell-group fui-cell-click">
		<a class="fui-cell external" href="<?php  echo mobileUrl('verifygoods')?>">
			<div class="fui-cell-icon"><i class="icon icon-list"></i></div>
			<div class="fui-cell-text">待使用商品信息</div>
			<div class="fui-cell-remark" style="font-size: 0.5rem;"></div>
		</a>

		<?php  if(!empty($verifygoods)) { ?>
		<div class="fui-icon-group selecter" style="overflow: scroll;">
			<ul class="banner-ul">
				<?php  if(is_array($verifygoods)) { foreach($verifygoods as $item) { ?>
				<li   <?php  if($item['numlimit']) { ?>class="banner-li-blue"<?php  } ?>>
				<a  <?php  if($item['cangetcard']) { ?> href="javascript:;" onclick="addCard('<?php  echo $item['card_id'];?>','<?php  echo $item['cardcode'];?>')" <?php  } else { ?> href="<?php  echo mobileUrl('verifygoods/detail',array('id'=>$item['id']))?>" <?php  } ?>>
				<div></div>
				<span>  <?php  if($item['cangetcard']) { ?>  待激活 <?php  } else { ?>待使用<?php  } ?></span>
				<img src="<?php  echo $item['thumb'];?>" alt="">
				<p>	<?php  echo $item['title'];?></p>
				</a>
				</li>
				<?php  } } ?>
			</ul>
		</div>
		<?php  } ?>
	</div>
	<?php  } ?>

	<?php  if($hasdividend) { ?>
	<div class="fui-cell-group fui-cell-click">
		<a class="fui-cell external"  href="<?php  echo mobileUrl('dividend')?>">
			<div class="fui-cell-icon"><i class="icon icon-profile"></i></div>
			<div class="fui-cell-text"><p><?php  echo $plugin_dividend_set['texts']['agent'];?></p></div>
			<div class="fui-cell-remark"></div>
		</a>
	</div>
	<?php  } ?>

	<?php  if($hasThreen) { ?>
	<div class="fui-cell-group fui-cell-click">
		<a class="fui-cell"  href="<?php  echo mobileUrl('threen')?>">
			<div class="fui-cell-icon"><i class="icon icon-profile"></i></div>
			<div class="fui-cell-text"><p><?php  echo $plugin_threen_set['texts']['threen'];?></p></div>
			<div class="fui-cell-remark"></div>
		</a>
	</div>
	<?php  } ?>
	<?php  if($haslive) { ?>
	<div class="fui-cell-group fui-cell-click">
		<a class="fui-cell" href="<?php  echo mobileUrl('live')?>">
			<div class="fui-cell-icon"><i class="icon icon-zhibo1"></i></div>
			<div class="fui-cell-text"><p><?php  echo $live_set['pluginname'];?></p></div>
			<div class="fui-cell-remark"></div>
		</a>
	</div>
	<?php  } ?>
	<?php  if($hassign) { ?>
	<div class="fui-cell-group fui-cell-click">
		<a class="fui-cell" href="<?php  echo mobileUrl('sign')?>">
			<div class="fui-cell-icon"><i class="icon icon-qiandao"></i></div>
			<div class="fui-cell-text"><p><?php  echo $hassign;?></p></div>
			<div class="fui-cell-remark"></div>
		</a>
	</div>
	<?php  } ?>

	<?php  if($hasglobonus) { ?>
	<div class="fui-cell-group fui-cell-click">
		<a class="fui-cell"  href="<?php  echo mobileUrl('globonus')?>">
			<div class="fui-cell-icon"><i class="icon icon-gudong1"></i></div>
			<div class="fui-cell-text"><p><?php  echo $plugin_globonus_set['texts']['center'];?></p></div>
			<div class="fui-cell-remark"></div>
		</a>
	</div>
	<?php  } ?>

	<?php  if($hasabonus) { ?>
	<div class="fui-cell-group fui-cell-click">
		<a class="fui-cell"  href="<?php  echo mobileUrl('abonus')?>">
			<div class="fui-cell-icon"><i class="icon icon-profile"></i></div>
			<div class="fui-cell-text"><p><?php  echo $plugin_abonus_set['texts']['center'];?></p></div>
			<div class="fui-cell-remark"></div>
		</a>
	</div>
	<?php  } ?>


	<?php  if($hasauthor) { ?>
	<div class="fui-cell-group fui-cell-click">
		<a class="fui-cell"  href="<?php  echo mobileUrl('author')?>">
			<div class="fui-cell-icon"><i class="icon icon-profile"></i></div>
			<div class="fui-cell-text"><p><?php  echo $plugin_author_set['texts']['center'];?></p></div>
			<div class="fui-cell-remark"></div>
		</a>
	</div>
	<?php  } ?>

	<?php  if(!empty($showcard)) { ?>
        <div class="fui-cell-group fui-cell-click">
            <a class="fui-cell" href="javascript:;" onclick="addCard('<?php  echo $card['card_id'];?>','')">
                <div class="fui-cell-icon"><i class="icon icon-same"></i></div>
                <div class="fui-cell-text"><p><?php  echo $cardtag;?></p></div>
                <div class="fui-cell-remark"></div>
            </a>
        </div>
	<?php  } ?>

	<?php  if($hascoupon) { ?>
		<div class="fui-cell-group fui-cell-click">
			 <?php  if($hascouponcenter) { ?>
			<a class="fui-cell" href="<?php  echo mobileUrl('sale/coupon')?>">
				<div class="fui-cell-icon"><i class="icon icon-lingquyouhuiquan1"></i></div>
				<div class="fui-cell-text"><p>领取优惠券</p></div>
				<div class="fui-cell-remark">
					<span class="badge"><?php  echo $couponnum;?></span>
				</div>
			</a>
			 <?php  } ?>
			<a class="fui-cell"  href="<?php  echo mobileUrl('sale/coupon/my')?>">
				<div class="fui-cell-icon"><i class="icon icon-wodeyouhuiquan"></i></div>
				<div class="fui-cell-text"><p>我的优惠券</p></div>
				<div class="fui-cell-remark"><?php  if($statics['coupon']>0) { ?><span  <?php  if($statics['newcoupon']>0) { ?>style="background: #fe5455;color:#fff"<?php  } ?> class='badge'>  <?php  if($statics['newcoupon']>0) { ?>new<?php  } else { ?><?php  echo $statics['coupon'];?><?php  } ?></span><?php  } ?>
				</div>
			</a>
		</div>
		<?php  } ?>

		<?php  if($hasLineUp) { ?>
		<div class="fui-cell-group fui-cell-click">
			<a class="fui-cell"  href="<?php  echo mobileUrl('lineup')?>">
				<div class="fui-cell-icon"><i class="icon icon-profile"></i></div>
				<div class="fui-cell-text"><p>排队返现列表</p></div>
				<div class="fui-cell-remark"></div>
			</a>
		</div>
		<?php  } ?>
		<?php  if(!empty( $_W['shopset']['rank']['status'] ) || !empty( $_W['shopset']['rank']['order_status'] ) ) { ?>
		<div class="fui-cell-group fui-cell-click">
			<?php  if(!empty( $_W['shopset']['rank']['status'] ) ) { ?>
			<a class="fui-cell" href="<?php  echo mobileUrl('member/rank');?>">
				<div class="fui-cell-icon"><i class="icon icon-rank"></i></div>
				<div class="fui-cell-text"><p><?php  echo $_W['shopset']['trade']['credittext'];?>排行</p></div>
				<div class="fui-cell-remark"></div>
			</a>
			<?php  } ?>
			<?php  if(!empty( $_W['shopset']['rank']['order_status'] ) ) { ?>
			<a class="fui-cell" href="<?php  echo mobileUrl('member/rank/order_rank');?>">
				<div class="fui-cell-icon"><i class="icon icon-paihang"></i></div>
				<div class="fui-cell-text"><p>消费排行</p></div>
				<div class="fui-cell-remark"></div>
			</a>
			<?php  } ?>
		</div>
		<?php  } ?>

	    <div class="fui-cell-group fui-cell-click">
			<a class="fui-cell" href="<?php  echo mobileUrl('member/cart');?>">
				<div class="fui-cell-icon"><i class="icon icon-cart"></i></div>
				<div class="fui-cell-text"><p>我的购物车</p></div>
				<div class="fui-cell-remark"><?php  if($statics['cart']>0) { ?><span class='badge'><?php  echo $statics['cart'];?></span><?php  } ?></div>
			</a>
			<a class="fui-cell" href="<?php  echo mobileUrl('member/favorite');?>">
				<div class="fui-cell-icon"><i class="icon icon-like"></i></div>
				<div class="fui-cell-text"><p>我的关注</p></div>
				<div class="fui-cell-remark"><?php  if($statics['favorite']>0) { ?><span class='badge'><?php  echo $statics['favorite'];?></span><?php  } ?></div>
			</a>

			<a class="fui-cell" href="<?php  echo mobileUrl('member/history');?>">
				<div class="fui-cell-icon"><i class="icon icon-footprint"></i></div>
				<div class="fui-cell-text"><p>我的足迹</p></div>
				<div class="fui-cell-remark"></div>
			</a>
			<!--<a class="fui-cell" href="<?php  echo mobileUrl('member/notice');?>" data-nocache="true">
				<div class="fui-cell-icon"><i class="icon icon-notice"></i></div>
				<div class="fui-cell-text"><p>消息提醒设置</p></div>
				<div class="fui-cell-remark"></div>
			</a>-->
			<?php  if($hasFullback) { ?>
			<a class="fui-cell external" href="<?php  echo mobileUrl('member/fullback');?>" data-nocache="true">
				<div class="fui-cell-icon"><i class="icon icon-daituikuan2"></i></div>
				<div class="fui-cell-text"><p>我的<?php  m('sale')->getFullBackText(true)?></p></div>
				<div class="fui-cell-remark"></div>
			</a>
			<?php  } ?>
		</div>

		<div class="fui-cell-group fui-cell-click">
		    <?php  if($_W['shopset']['trade']['withdraw']==1) { ?>
			<a class="fui-cell" href="<?php  echo mobileUrl('member/withdraw')?>">
				<div class="fui-cell-icon"><i class="icon icon-tixian"></i></div>
				<div class="fui-cell-text"><p><?php  echo $_W['shopset']['trade']['moneytext'];?>提现</p></div>
				<div class="fui-cell-remark"></div>
			</a>
		    <?php  } ?>
			<a class="fui-cell" href="<?php  echo mobileUrl('member/log')?>">
				<div class="fui-cell-icon"><i class="icon icon-xiaofei"></i></div>
				<div class="fui-cell-text"><p>
				    <?php  if($_W['shopset']['trade']['withdraw']==1) { ?><?php  echo $_W['shopset']['trade']['moneytext'];?>明细<?php  } else { ?>充值记录<?php  } ?>
				    </p></div>
				<div class="fui-cell-remark"></div>
			</a>
		</div>
		<div class="fui-cell-group fui-cell-click">
			<a class="fui-cell" href="<?php  echo mobileUrl('member/address')?>">
				<div class="fui-cell-icon"><i class="icon icon-dingwei1"></i></div>
				<div class="fui-cell-text"><p>收货地址管理</p></div>
				<div class="fui-cell-remark"></div>
			</a>
		</div>
	<?php  if($hasqa) { ?>
		<div class="fui-cell-group fui-cell-click">
			<a class="fui-cell external" href="<?php  echo mobileUrl('qa')?>">
				<div class="fui-cell-icon"><i class="icon icon-bangzhu1"></i></div>
				<div class="fui-cell-text"><p>帮助中心</p></div>
				<div class="fui-cell-remark"></div>
			</a>
		</div>
	<?php  } ?>
	<?php  if(!is_weixin()) { ?>
	<div class="fui-cell-group fui-cell-click transparent">
		<a class="fui-cell external changepwd" href="<?php  if(!empty($member['mobileverify'])) { ?><?php  echo mobileUrl('member/changepwd')?><?php  } else { ?><?php  echo mobileUrl('member/bind')?><?php  } ?>">
			<div class="fui-cell-text" style="text-align: center;"><p>修改密码</p></div>
		</a>
		<a class="fui-cell external btn-logout">
			<div class="fui-cell-text" style="text-align: center;"><p>退出登录</p></div>
		</a>
	</div>

	<div class="pop-apply-hidden" style="display: none">
		<div class="verify-pop pop">
			<div class="close"><i class="icon icon-roundclose"></i></div>
			<div class="qrcode">
				<div class="inner">
					<div class="title"><?php  echo $set['applytitle'];?></div>
					<div class="text"><?php  echo $set['applycontent'];?></div>
				</div>
				<div class="inner-btn" style="padding: 0.5rem">
					<div class="btn btn-warning" style="width: 100%; margin: 0">我已阅读</div>
				</div>
			</div>
		</div>
	</div>

	<?php  } ?>
		<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_copyright', TEMPLATE_INCLUDEPATH)) : (include template('_copyright', TEMPLATE_INCLUDEPATH));?>
	</div>
	<script language='javascript'>
		require(['biz/member/index'], function (modal) {
			modal.init();
		});
	</script>
</div>

<script  language='javascript'>
	var lis = $('.banner-ul').find('li');
	$('.banner-ul').width(lis.length*8.3+'rem');

	function addCard(card_id,code) {

		var data = {'openid': '<?php  echo $_W["openid"]?>', 'card_id': card_id, 'code': code};
		$.ajax({
			url: "<?php  echo mobileUrl('sale/coupon/getsignature')?>",
			data: data,
			cache: false
		}).done(function (result) {
			var data = jQuery.parseJSON(result);
			if (data.status == 1) {
				wx.addCard({
					cardList: [
						{
							cardId: card_id,
							cardExt: data.result.cardExt
						}
					],
					success: function (res) {
						//alert('已添加卡券：' + JSON.stringify(res.cardList));
					},
					cancel: function (res) {
						//alert(JSON.stringify(res))
					}
				});
			} else {
				alert("微信接口繁忙,请稍后再试!");
				alert(data.result.message);
			}
		});
	}

</script>

<?php  if(empty($_GPC['isnewstore']) ) { ?>
	<?php  $this->footerMenus()?>
<?php  } else { ?>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../../../plugin/newstore/template/mobile/default/_menu', TEMPLATE_INCLUDEPATH)) : (include template('../../../plugin/newstore/template/mobile/default/_menu', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
