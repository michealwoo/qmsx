<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/template/mobile/default/static/css/index.css"/>
<style>
    .fui-mask {
        opacity: 1;
    }
	.order-success-header{
		background: -moz-linear-gradient(left, #ffb43e 0%, #fd9526 100%);
		background: -webkit-linear-gradient(left, #ffb43e 0%,#fd9526 100%);
		background: -o-linear-gradient(left, #ffb43e 0%,#fd9526 100%);
		background: -ms-linear-gradient(left, #ffb43e 0%,#fd9526 100%);
		background: linear-gradient(to right, #ffb43e 0%,#fd9526 100%);
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#ffffb43e, endColorstr=#fffd9526,gradientType='1');
		-webkit-box-flex: 1;
		-webkit-flex: 1;
		-ms-flex: 1;
		flex: 1;
		display: -webkit-box;
		display: -webkit-flex;
		display: -ms-flexbox;
		display: flex;
		flex-direction: column;
		align-items: center;
		-webkit-align-items: center;
		justify-content: center;
		padding: 0 0.6rem;
		font-size: 0.65rem;
		line-height: 1.2rem;
		height: 4rem;
		color: #fff;
	}
	.red .order-success-header{
		background:#fc664c;
		background:linear-gradient(to right, #fdad89 0%,#f94444 100%);
		background: -webkit-linear-gradient(left, #fdad89 0%,#f94444 100%);
	}
	.blue .order-success-header{
		background:#4e87ee;
		background:linear-gradient(to right, #4fbaee 0%,#4e87ee 100%);
		background: -webkit-linear-gradient(left, #4fbaee 0%,#4e87ee 100%);
	}
	.purple .order-success-header{
		background:#a839fa;
		background:linear-gradient(to right, #6a60ff 0%,#a839fa 100%);
		background: -webkit-linear-gradient(left, #6a60ff 0%,#a839fa 100%);
	}
	.orange .order-success-header{
		background:#ff8c1e;
		background:linear-gradient(to right, #ffb81e 0%,#ff8c1e 100%);
		background: -webkit-linear-gradient(left, #ffb81e 0%,#ff8c1e 100%);
	}
	.pink .order-success-header{
		background:#ff7e95;
		background:linear-gradient(to right, #ffacd0 0%,#ff7e95 100%);
		background: -webkit-linear-gradient(left, #ffacd0 0%,#ff7e95 100%);
	}
</style>
<div class='fui-page order-success-page pay <?php  echo $seckill_color;?>'>

	<div class="fui-header">
		<div class="fui-header-left">
			<a class="back" href="<?php  echo mobileUrl('order')?>"></a>
		</div>
		<div class="title">
			<?php  if($_GPC['result']=='seckill_refund') { ?>
			支付失败
			<?php  } else { ?>
			支付成功
			<?php  } ?>

		</div>
		<div class="fui-header-right" data-nomenu="true">&nbsp;</div>
	</div>

    <div class='fui-content'>
	
	<div class='fui-list-group result-list ' style="margin-top: 0;display: none">
	    <div class='fui-list'>
		<div class='fui-list-media' >
			<?php  if($_GPC['result']=='seckill_refund') { ?>
					<i class='icon icon-cry'></i>
			<?php  } else { ?>
		   <?php  if(!empty($address)&&empty($order['istrade'])) { ?><i class='icon icon-deliver'></i><?php  } ?>

			<?php  if(!empty($order['dispatchtype']) && empty($order['isverify'])) { ?><i class='icon icon-store'></i><?php  } ?>

			<?php  if(!empty($order['isverify'])||$isonlyverifygoods || !empty($order['istrade'])) { ?><i class='icon icon-store'></i><?php  } ?>

			<?php  if(!empty($order['virtual'])) { ?><i class='icon icon-text'></i><?php  } ?>

			<?php  if(!empty($order['isvirtual']) && empty($order['virtual'])) { ?>
			    <?php  if(!empty($order['isvirtualsend'])) { ?>
			    <i class='icon icon-text'></i>
			    <?php  } else { ?>
			    <i class='icon icon-check'></i>
			    <?php  } ?>
			<?php  } ?>
			<?php  } ?>

		     </div>
		<div class='fui-list-inner'>
		    <div class='title'>
				<?php  if($_GPC['result']=='seckill_refund') { ?>
				订单支付失败
				<?php  } else { ?>
				<?php  if($order['paytype']==3) { ?>
				订单提交支付
				<?php  } else { ?>
				订单支付成功

				<?php  } ?>
				<?php  } ?>

		    </div>
		    <div class='text'>

				<?php  if($_GPC['result']=='seckill_refund') { ?>
				 支付超时，秒杀失败，系统会自动退款，如果未收到退款，请联系客服!
				<?php  } else { ?>


			<?php  if(!empty($address)&&empty($order['istrade'])) { ?>您的包裹整装待发<?php  } ?>

			<?php  if(!empty($order['istrade'])) { ?>您的服务已成功预约<?php  } ?>

			<?php  if(!empty($order['dispatchtype']) && empty($order['isverify'])) { ?>您可以到您选择的自提点取货了<?php  } ?>

			<?php  if(!empty($order['isverify'])) { ?>您可以到适用门店去使用了<?php  } ?>

			<?php  if(!empty($order['virtual'])) { ?>您购买的商品已自动发货<?php  } ?>

			<?php  if(!empty($order['isvirtual']) && empty($order['virtual'])) { ?>
			     <?php  if(!empty($order['isvirtualsend'])) { ?>
			         您购买的商品已自动发货
			    <?php  } else { ?>
			         您已经支付成功

				<?php  if(p('lottery')) { ?>
				<div id="changesmodel" style="display: none;">
					<div id="changescontent" onclick="" class="task-model" style="background: url('../addons/ewei_shopv2/plugin/lottery/static/images/changes.png');background-size: cover; width: 16rem; height: 16rem;  background-size: cover;position: relative; left: 9%; margin-bottom: 55%;">
        <span class="changes-btn-close" style="border: 1px solid #ffffff; color: #ffffff; border-radius: 50%; position: relative; top: -1.3rem; left: 15.5rem; padding: 0.2rem 0.3rem;"><i class="icon icon-close"></i><span>
					</div>
				</div>
				<script type="text/javascript">
					$(document).ready(function () {
						setTimeout(function () {
							if (<?php  echo $lottery_changes['is_changes'];?> == 1) {
								var changes = <?php  echo json_encode($lottery_changes['lottery']);?>;
								$('#changescontent').attr('onclick', 'window.location.href="<?php  echo mobileUrl("lottery/lottery_info",array(),true);?>&id=' + changes.lottery_id + '"');
								taskget = new FoxUIModal({
									content: $('#changesmodel').html(),
									extraClass: 'picker-modal',
									maskClick: function () {
										taskget.close()
									}
								});
								taskget.container.find('.changes-btn-close').click(function () {
									taskget.close();
									event.stopPropagation();
								});

								taskget.show();
							}
						}, 200);
					});

				</script>
				<?php  } ?>


			    <?php  } ?>
			<?php  } ?>
				<?php  } ?>

		    </div>
		</div>
	    </div>
	</div>
	<div class="order-success-header">
		<div style="font-size: .85rem">
			<?php  if($_GPC['result']=='seckill_refund') { ?>
			订单支付失败
			<?php  } else { ?>
			<?php  if($order['paytype']==3) { ?>
			订单提交支付
			<?php  } else { ?>
			订单支付成功

			<?php  } ?>
			<?php  } ?>

		</div>
		<div class='text'>

			<?php  if($_GPC['result']=='seckill_refund') { ?>
			支付超时，秒杀失败，系统会自动退款，如果未收到退款，请联系客服!
			<?php  } else { ?>


			<?php  if(!empty($address)&&empty($order['istrade'])) { ?>您的包裹整装待发<?php  } ?>

			<?php  if(!empty($order['istrade'])) { ?>您的服务已成功预约<?php  } ?>

			<?php  if(!empty($order['dispatchtype']) && empty($order['isverify'])) { ?>您可以到您选择的自提点取货了<?php  } ?>

			<?php  if(!empty($order['isverify'])) { ?>您可以到适用门店去使用了<?php  } ?>

			<?php  if(!empty($order['virtual'])) { ?>您购买的商品已自动发货<?php  } ?>

			<?php  if(!empty($order['isvirtual']) && empty($order['virtual'])) { ?>
			<?php  if(!empty($order['isvirtualsend'])) { ?>
			您购买的商品已自动发货
			<?php  } else { ?>
			您已经支付成功

			<?php  if(p('lottery')) { ?>
			<div id="changesmodel" style="display: none;">
				<div id="changescontent" onclick="" class="task-model" style="background: url('../addons/ewei_shopv2/plugin/lottery/static/images/changes.png');background-size: cover; width: 16rem; height: 16rem;  background-size: cover;position: relative; left: 9%; margin-bottom: 55%;">
        <span class="changes-btn-close" style="border: 1px solid #ffffff; color: #ffffff; border-radius: 50%; position: relative; top: -1.3rem; left: 15.5rem; padding: 0.2rem 0.3rem;"><i class="icon icon-close"></i><span>
				</div>
			</div>
			<script type="text/javascript">
                $(document).ready(function () {
                    setTimeout(function () {
                        if (<?php  echo $lottery_changes['is_changes'];?> == 1) {
                            var changes = <?php  echo json_encode($lottery_changes['lottery']);?>;
                            $('#changescontent').attr('onclick', 'window.location.href="<?php  echo mobileUrl("lottery/lottery_info",array(),true);?>&id=' + changes.lottery_id + '"');
                            taskget = new FoxUIModal({
                                content: $('#changesmodel').html(),
                                extraClass: 'picker-modal',
                                maskClick: function () {
                                    taskget.close()
                                }
                            });
                            taskget.container.find('.changes-btn-close').click(function () {
                                taskget.close();
                                event.stopPropagation();
                            });

                            taskget.show();
                        }
                    }, 200);
                });

			</script>
			<?php  } ?>


			<?php  } ?>
			<?php  } ?>
			<?php  } ?>

		</div>
	</div>


	<?php  if(!empty($stores) && empty($store)) { ?>
	<script language='javascript' src='https://api.map.baidu.com/api?v=2.0&ak=ZQiFErjQB7inrGpx27M1GR5w3TxZ64k7&s=1'></script>
	<div class='fui-according-group'>
	<div class='fui-according'>
	    <div class='fui-according-header'>
		<i class='icon icon-shop'></i>
		<span class="text">适用门店</span>
		<span class="remark"><div class="badge"><?php  echo count($stores)?></div></span>
	    </div>
	   <div class="fui-according-content store-container">
		 <?php  if(is_array($stores)) { foreach($stores as $item) { ?>
			<!--<div  class="fui-list store-item" -->
		      
		      <!--data-lng="<?php  echo floatval($item['lng'])?>"-->
		      <!--data-lat="<?php  echo floatval($item['lat'])?>">-->
		    <!--<div class="fui-list-media">-->
			<!--<i class='icon icon-shop'></i>-->
		    <!--</div>-->
		    <!--<div class="fui-list-inner store-inner">-->
			<!--<div class="title"> <span class='storename'><?php  echo $item['storename'];?></span></div>-->
			<!--<div class="text">-->
			    <!--<span class='realname'><?php  echo $item['realname'];?></span> <span class='mobile'><?php  echo $item['mobile'];?></span>-->
			<!--</div>-->
			<!--<div class="text">-->
			    <!--<span class='address'><?php  echo $item['address'];?></span>-->
			<!--</div>-->
			<!--<div class="text location" style="color:green;display:none">正在计算距离...</div>-->
		    <!--</div> -->
		     <!--<div class="fui-list-angle ">-->
			 <!--//<?php  if(!empty($item['tel'])) { ?><a href="tel:<?php  echo $item['tel'];?>" class='external '><i class=' icon icon-phone' style='color:green'></i></a><?php  } ?>-->
			 <!--<a href="<?php  echo mobileUrl('store/map',array('id'=>$item['id'],'merchid'=>$item['merchid']))?>" class='external' ><i class='icon icon-dingwei' style='color:#f90'></i></a>-->
  		      <!--</div>-->
		<!--</div>-->
		   <div   class="fui-list"
				  data-storeid="<?php  echo $item['id'];?>"
				  data-lng="<?php  echo floatval($item['lng'])?>"
				  data-lat="<?php  echo floatval($item['lat'])?>"
				  data-storename="<?php  echo $item['storename'];?>"
				  data-realname="<?php  echo $item['realname'];?>"
				  data-mobile="<?php  echo $item['mobile'];?>"
				  data-address="<?php  echo $item['address'];?>"
				  data-map="<?php  echo mobileUrl('store/map',array('id'=>$item['id'],'merchid'=>$item['merchid']))?>"
		   >
			   <div class="fui-list-media" style="margin-right: 0.6rem;">
				   <i class="icon icon-dianpu1">
				   </i>
			   </div>
			   <div class="fui-list-inner">
				   <div class="title has-address">
                                    <span class="storename">
                                        <?php  echo $item['storename'];?>
                                    </span>
					   <div class="text"style="display: none">
						   <span class='realname'><?php  echo $item['realname'];?></span> <span class='mobile'><?php  echo $item['mobile'];?></span>
					   </div>
				   </div>
				   <div class="text">
                                    <span class="aline address">
                                        地址：<?php  echo $item['address'];?>
                                    </span>
				   </div>
				   <div style="font-size:.65rem;color:#999;display: flex;align-items: center" >
					   <i class="icon icon-dingwei"style="color:#999;display: none">
					   </i>
					   <div class="text location" style="color:#999;margin-left:.2rem;display:none">正在计算距离...</div>
				   </div>
			   </div>
			   <div class="fui-list-angle" style="height: auto">
				   <i class="icon icon-xiangqing-copy ">
				   </i>
			   </div>
		   </div>
			<?php  } } ?>
		</div>
	 
	<div id="nearStore" style="display:none">
		 
		<div class='fui-list store-item'   id='nearStoreHtml'></div>
	</div>
	</div></div>
	<?php  } ?>
	<?php  if(!empty($address)) { ?>
	 
	<div class='fui-list-group' >
	    <div class='fui-list'>
		<div class='fui-list-media'><i class="icon icon-dingwei"></i></div>
		<div class='fui-list-inner'>
			<div class='title'>联系人&nbsp;&nbsp;&nbsp;&nbsp;：<?php  echo $address['realname'];?></div>
			<div class='title'>联系电话 ：<?php  echo $address['mobile'];?></div>
		    <div class='text'><?php  echo $address['province'];?><?php  echo $address['city'];?><?php  echo $address['area'];?><?php  echo $address['street'];?><?php  echo $address['address'];?></div>
		</div>
	    </div>
	</div>
	<?php  } ?>



	<?php  if($hasverifygood) { ?>
	<a  href="<?php  echo mobileUrl('verifygoods')?>" class="fui-cell-group small noborder nopadding no_active" style="display: block;">
		<div class="fui-cell">
			<div class="fui-cell-label">
				<img src="../addons/ewei_shopv2/static/images/card.png" alt="" class="card"/ >
			</div>
			<div class="fui-cell-info" style="font-size: 0.75rem;" >
				<p>您有一件记次时商品待使用</p>
				<div>立即前往激活>></div>
			</div>
		</div>
	</a>
	<?php  } ?>

	
	<?php  if(!empty($carrier) || !empty($store)) { ?>
	 
	<div class='fui-list-group'>
	        <?php  if(!empty($carrier)) { ?>
	    <div class='fui-list'>
		<div class='fui-list-media'><i class='icon icon-person2'></i></div>
		<div class='fui-list-inner'>
		    <div class='title'>联系人&nbsp;&nbsp;&nbsp;&nbsp;：<?php  echo $carrier['carrier_realname'];?></div>
			<div class='title'>联系电话 ：<?php  echo $carrier['carrier_mobile'];?></div>
		</div>
	    </div>
		<?php  } ?>
	    
	    <?php  if(!empty($store)) { ?>
	       <!--<div  class="fui-list" >-->
		    <!--<div class="fui-list-media">-->
			<!--<i class='icon icon-shop'></i>-->
		    <!--</div>-->
		    <!--<div class="fui-list-inner store-inner">-->
			<!--<div class="title"> <span class='storename'><?php  echo $store['storename'];?></span></div>-->
			<!--<div class="text">-->
			    <!--<span class='realname'><?php  echo $store['realname'];?></span> <span class='mobile'><?php  echo $store['mobile'];?></span>-->
			<!--</div>-->
			<!--<div class="text">-->
			    <!--<span class='address'><?php  echo $store['address'];?></span>-->
			<!--</div>-->
		    <!--</div> -->
		     <!--<div class="fui-list-angle ">-->
			 <!--//<?php  if(!empty($store['tel'])) { ?><a href="tel:<?php  echo $store['tel'];?>" class='external '><i class=' icon icon-phone' style='color:green'></i></a><?php  } ?>-->
			 <!--<a href="<?php  echo mobileUrl('store/map',array('id'=>$store['id'],'merchid'=>$store['merchid']))?>" class='external' ><i class='icon icon-location' style='color:#f90'></i></a>-->
  		      <!--</div>-->
		<!--</div>-->
		<div   class="fui-list store-item"
			   data-storeid="<?php  echo $store['id'];?>"
			   data-lng="<?php  echo floatval($store['lng'])?>"
			   data-lat="<?php  echo floatval($store['lat'])?>"
			   data-storename="<?php  echo $store['storename'];?>"
			   data-realname="<?php  echo $store['realname'];?>"
			   data-mobile="<?php  echo $store['mobile'];?>"
			   data-address="<?php  echo $store['address'];?>"
			   data-map="<?php  echo mobileUrl('store/map',array('id'=>$store['id'],'merchid'=>$store['merchid']))?>"
		>
			<div class="fui-list-media" style="margin-right: 0.6rem;">
				<i class="icon icon-dianpu1">
				</i>
			</div>
			<div class="fui-list-inner">
				<div class="title has-address">
                                    <span class="storename">
                                        <?php  echo $store['storename'];?>
                                    </span>
					<div class="text"style="display: none">
						<span class='realname'><?php  echo $store['realname'];?></span> <span class='mobile'><?php  echo $store['mobile'];?></span>
					</div>
				</div>
				<div class="text">
                                    <span class="aline address">
                                        地址：<?php  echo $store['address'];?>
                                    </span>
				</div>
				<div style="font-size:.65rem;color:#999;display: flex;align-items: center" >
					<i class="icon icon-dingwei"style="color:#999;display: none">
					</i>
					<div class="text location" style="color:#999;margin-left:.2rem;display:none">正在计算距离...</div>
				</div>
			</div>
			<div class="fui-list-angle" style="height: auto">
				<i class="icon icon-xiangqing-copy shopmask">
				</i>
			</div>
		</div>
	    <?php  } ?>
	</div>
	<?php  } ?>
	
	
	<div class="fui-cell-group ">
	    <div class="fui-cell">
		<div class="fui-cell-label"><?php  if($order['paytype']==3) { ?>需到付<?php  } else { ?>实付金额<?php  } ?></div>
		<div class="fui-cell-info"></div>
		<div class="fui-cell-remark noremark"><span class='text-danger'>￥<?php  if(empty($peerprice)) { ?><?php  echo number_format($order['price'],2)?><?php  } else { ?><?php  echo $peerprice['price'];?><?php  } ?></span></div>
	    </div>
	</div>

		<?php  if(!empty($order['virtual']) && !empty($order['virtual_str'])) { ?>
		<!--发货信息-->
			<?php  if(is_array($ordervirtual) && !empty($ordervirtual)) { ?>
				<?php  if(is_array($ordervirtual)) { foreach($ordervirtual as $ordervirtualindex => $ordervirtualitem) { ?>
				<div class="fui-cell-group">
					<div class="fui-cell-title">发货信息 <?php echo count($ordervirtual)>1? $ordervirtualindex+1: ''?></div>
					<?php  if(is_array($ordervirtualitem)) { foreach($ordervirtualitem as $ordervirtualrow) { ?>
						<div class="fui-cell">
							<div class="fui-cell-label"><?php  echo $ordervirtualrow['key'];?></div>
							<div class="fui-cell-info" style="white-space: normal;word-wrap: break-word"><?php  echo $ordervirtualrow['value'];?></div>
						</div>
					<?php  } } ?>
					<?php  if(!empty($virtualtemp) && !empty($virtualtemp['linkurl'])) { ?>
					<a class="btn btn-default block" href="<?php  echo $virtualtemp['linkurl'];?>"><?php echo !empty($virtualtemp['linktext'])? $virtualtemp['linktext']: '使用地址'?></a>
					<?php  } ?>
				</div>
				<?php  } } ?>
			<?php  } else { ?>
				<div class="fui-cell-group">
					<div class="fui-cell-title">发货信息</div>
					<div class="fui-cell">
						<div class="fui-cell-info" style="white-space: normal;word-wrap: break-word"><?php  echo $order['virtual_str'];?></div>
					</div>
					<?php  if(!empty($virtualtemp) && !empty($virtualtemp['linkurl'])) { ?>
					<a class="btn btn-default block" href="<?php  echo $virtualtemp['linkurl'];?>"><?php echo !empty($virtualtemp['linktext'])? $virtualtemp['linktext']: '使用地址'?></a>
					<?php  } ?>
				</div>
			<?php  } ?>

		<?php  } ?>

		<?php  if(!empty($order['isvirtualsend']) && !empty($order['virtualsend_info'])) { ?>
		<!--发货信息-->
		<div class="fui-according-group">
			<div class="fui-according expanded">
				<div class="fui-according-header">
					<span class="text">发货信息</span>
					<span class="remark"></span>
				</div>
				<div class="fui-according-content"  style="display: block;">
					<div class="content-block">
						<div class="fui-cell-group notop">
							<div   class="fui-cell">
								<div class="fui-cell-info" style="white-space: normal;word-wrap: break-word">
									<?php  echo $order['virtualsend_info'];?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php  } ?>
	 
	<div class='row'>
	    <div class='col-50'>
			<?php  if(!empty($order['iscycelbuy'])) { ?>
				<a class="btn btn-default external" href="<?php  echo mobileUrl('cycelbuy/order/detail',array('id'=>$order['id']))?>">订单详情</a>
			<?php  } else { ?>
				<a class="btn btn-default external" <?php  if(empty($ispeerpay)) { ?>href="<?php  echo mobileUrl('order/detail',array('id'=>$order['id']))?>"<?php  } else { ?>href="<?php  echo mobileUrl('order/pay/peerpaydetail',array('id'=>$orderid))?>"<?php  } ?> >订单详情</a>
			<?php  } ?>
	    </div>
	    <div class='col-50'>
			<?php  if($order['isnewstore']==1) { ?>
				<a class="btn btn-default external" href="<?php  echo mobileUrl('newstore.stores.detail',array('storeid'=>$order['storeid']))?>" >返回门店</a>
			<?php  } else { ?>
				<a class="btn btn-default external" href="<?php  echo mobileUrl()?>" >返回首页</a>
			<?php  } ?>
	    </div>
	</div>
	 
    </div>

	<?php  if(p('lottery')) { ?>
	<div id="changesmodel" style="display: none;width: 90%">
		<div id="changescontent" onclick="" class="task-model" style="background: url('../addons/ewei_shopv2/plugin/lottery/static/images/changes.png');background-size: cover; width: 90%; height: 16rem;  background-size: cover;position: relative;margin: 0 auto; margin-bottom: 55%;">
            <span class="changes-btn-close" style="border: 1px solid dodgerblue; color: dodgerblue; border-radius: 50%; position: absolute;right: 5px; padding: 0.2rem 0.4rem;top: 5px;z-index: 10"><i class="icon icon-close"></i><span>
		</div>
	</div>
	<?php  } ?>
	    <script language='javascript'>
            require(['biz/order/success'], function (modal) {modal.init("<?php  echo $lottery_changes['is_changes'];?>","<?php  echo $lottery_changes['lottery']['lottery_id'];?>");});
        </script>
</div>
<div id="shopmask" style="display: none;">
	<div class="shopmask-alert">
		<div class="shopmask-title"></div>
		<div class="shopmask-content">
			<div class="shopmask-content-title">地址</div>
			<div class="shopmask-content-subtitle address">
				<div></div>
				<a href="" class='external' ><i class="icon icon-dingwei"></i></a>
			</div>
		</div>
		<div class="shopmask-content">
			<div class="shopmask-content-title">电话</div>
			<a >
				<div class="shopmask-content-subtitle mobile">
					<div></div>
					<i class="icon icon-dianhua"></i>
				</div>
			</a>
		</div>
		<div class="shopmask-content">
			<div class="shopmask-content-title">联系人</div>
			<div class="shopmask-content-subtitle realname">
				<div></div>
			</div>
		</div>
		<div class="shopmask-bottom">
			我知道了
		</div>
	</div>
</div>
<script language='javascript'>
    require(['biz/store/selector'], function (modal) {
        modal.init()
    });</script>
<?php  if($share) { ?>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('sale/sendticket/share', TEMPLATE_INCLUDEPATH)) : (include template('sale/sendticket/share', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>