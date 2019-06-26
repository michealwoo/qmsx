<?php defined('IN_IA') or exit('Access Denied');?><link href="/favicon.ico" rel="shortcut icon" />
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/static/css/card/index.css"/>

<style>
	.dropdown-menu {
		border: medium none;
		font-size: 12px;
		left: 0;
		list-style: none outside none;
		padding: 0;
		text-shadow: none;
		top: 100%;
		z-index: 1000;
		border-radius: 0;
		box-shadow: 0 0 3px rgba(86, 96, 117, 0.3);
	}

	.dropdown-menu li {
		display: inline-block;
	}

	.bootstrap-colorpalette {
		padding-left: 4px;
		padding-right: 4px;
		white-space: normal;
		line-height: 1;
	}

	.tabs-container .form-group-color {
		margin-right: -15px;
		margin-left: -15px;
	}
</style>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/template/web/sale/wxcard/css/iconfont.css"/>

<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否开启</label>
	<div class="col-sm-6 col-xs-6">
		<?php if( ce('goods' ,$item) ) { ?>
		<?php  if(empty($item['id'])) { ?>
		<label class="radio-inline">
			<input type="radio" name="opencard" value="1"  <?php  if(!empty($item['opencard'])) { ?>checked="true"<?php  } ?> onclick="$('.showcard').show();$"/> 开启
		</label>
		<label class="radio-inline">
			<input type="radio" name="opencard" value="0" <?php  if(empty($item['opencard'])) { ?>checked="true"<?php  } ?>  onclick="$('.showcard').hide();;" /> 关闭
		</label>
		<?php  } else { ?>
		<input type="hidden" name="opencard" value="<?php  echo $item['opencard'];?>">
		<?php  if(empty($item['opencard'])) { ?>
		关闭
		<?php  } else { ?>
		开启
		<?php  } ?>
		<?php  } ?>
		<?php  } else { ?>
		<input type="hidden" name="opencard" value="<?php  echo $item['opencard'];?>">
		<div class='form-control-static'>
			<?php  if(empty($item['opencard'])) { ?>
			关闭
			<?php  } else { ?>
			开启
			<?php  } ?>
		</div>
		<?php  } ?>
		<p class='frm_tip'>是否开启制作微信会员卡,开启后,用户可以领取此记次时商品绑定的微信会员卡,商品创建后此选项则无法修改</p>

	</div>
</div>

<div class="wrapper showcard" style="width: auto;  <?php  if(empty($item) ||empty($item['opencard'])) { ?> display: none;  <?php  } ?>">
	<div class="preview" style="overflow: visible;position: static;">
		<div class="cart-top">
			<img src="../addons/ewei_shopv2/static/images/cart_top.jpg" alt=""/>
		</div>
		<div class="title">
			<i class="back icon icon-back"></i>
			<i class="more pull-right icon icon-more"></i>
		</div>
		<div class="panel">
			<!--商户信息-->
			<div class="logo-area">

				<div class="logo">
					<img id="logoimg" src="<?php  if(empty($card)) { ?>../addons/ewei_shopv2/static/images/default.png<?php  } else { ?><?php  echo $card['card_logoimg'];?><?php  } ?>"/>
				</div>
				<div class="name"  id="brandname">
					<?php echo empty($card['card_brand_name'])?'会员卡商铺名称':$card['card_brand_name']?>
				</div>
				</br>
				<div class="name"  id="title">
					<?php echo empty($card['card_title'])?'会员卡标题名称':$card['card_title']?>
				</div>
				<div class="code">
					<img src="../addons/ewei_shopv2/static/images/code.jpg" alt="" />
				</div>

				<div class="bot">
					<span>0268 8888 8888</span>
					<i class="icon icon-info pull-right"></i>
				</div>
			</div>
			<div class="card-other">
				<ul>
					<li id="show_custom_cell1" <?php  if(empty($card['custom_cell1'])) { ?>style="display:none;" <?php  } ?>>
					<span id="show_custom_cell1_name"><?php echo empty($card['custom_cell1_name'])?'自定义入口':$card['custom_cell1_name']?></span>

					<span style="float: right;">
						<span id="show_custom_cell1_tips"><?php echo empty($card['custom_cell1_tips'])?'立即进入':$card['custom_cell1_tips']?></span>
						<i class="go pull-right icon icon-right"></i>
					</span>
					</li>
					<li>会员卡详情<i class="go pull-right icon icon-right"></i></li>
					<li>公众号<i class="go pull-right icon icon-right"></i></li>
				</ul>
			</div>
		</div>
		<!--自定义入口-->
		<!--卡券其他-->
		<div class="card-other">
			<ul>
			</ul>
		</div>
	</div>



	<!--控制台-->
	<div class="control col-sm-7" style=" padding: 10px;">
		<div class="editor_section">

			<!--会员卡标题-->
			<!--<div class="form-group limit">-->
				<!--<label class="col-sm-2 control-label">是否开启</label>-->
				<!--<div class="col-sm-9 col-xs-12" >-->
					<?php if( ce('goods' ,$item) ) { ?>
						<?php  if(empty($item['id'])) { ?>
					<!--<label class="radio-inline">-->
						<!--<input type="radio" name="opencard" value="1"  <?php  if(!empty($item['opencard'])) { ?>checked="true"<?php  } ?>  /> 开启-->
					<!--</label>-->
					<!--<label class="radio-inline">-->
						<!--<input type="radio" name="opencard" value="0" <?php  if(empty($item['opencard'])) { ?>checked="true"<?php  } ?>  /> 关闭-->
					<!--</label>-->

						<?php  } else { ?>
							<!--<label class="radio-inline">-->
								<!--<input type="hidden" name="opencard" value="<?php  echo $item['opencard'];?>">-->
							<!--</label>-->
							<?php  if(empty($item['opencard'])) { ?>
							<!--关闭-->
							<?php  } else { ?>
							<!--开启-->
							<?php  } ?>
						<?php  } ?>
					<?php  } else { ?>
					<!--<label class="radio-inline">-->
						<!--<input type="hidden" name="opencard" value="<?php  echo $item['opencard'];?>">-->
					<!--</label>-->
						<!--<div class='form-control-static'>-->
							<?php  if(empty($item['opencard'])) { ?>
							<!--关闭-->
							<?php  } else { ?>
							<!--开启-->
							<?php  } ?>
						<!--</div>-->
					<?php  } ?>
					<!--<p class='help-block'>是否开启制作微信会员卡,开启后,用户可以领取此记次时商品绑定的微信会员卡,商品创建后此选项则无法修改</p>-->
				<!--</div>-->
				<!--&lt;!&ndash;<p class='error'>会员卡标题创建后无法修改</p>&ndash;&gt;-->
			<!--</div>-->

			<!--商铺名称-->
			<div class="form-group limit">
				<label class="col-sm-2 control-label">商铺名称</label>
				<div class="col-sm-9 col-xs-12">
					<?php if(cv('member.card')) { ?>
					<input type="text" name="card_brand_name" id="card_brand_name" class="input form-control" value="<?php  echo $card['card_brand_name'];?>" <?php  if(!empty($card)) { ?>disabled<?php  } ?> />
					<?php  } else { ?>
					<?php  echo $card['card_brand_name'];?>
					<?php  } ?>
					<p class='help-block'>商铺名称创建后无法修改</p>
				</div>
			</div>

			<!--会员卡标题-->
			<div class="form-group limit">
				<label class="col-sm-2 control-label">会员卡标题</label>
				<div class="col-sm-9 col-xs-12">
					<?php if(cv('member.card')) { ?>
					<input type="text" name="card_title" id="card_title" class="input form-control" value="<?php  echo $card['card_title'];?>" <?php  if(!empty($card)) { ?>disabled<?php  } ?> />
					<?php  } else { ?>
					<?php  echo $card['card_title'];?>
					<?php  } ?>
					<p class='help-block'>会员卡标题创建后无法修改</p>
				</div>
			</div>



			<!--库存总量-->
			<div class="form-group limit">
				<label class="col-sm-2 control-label">库存总量</label>
				<div class="col-sm-9 col-xs-12">
					<?php if(cv('member.card')) { ?>
					<input type="text" name="card_totalquantity" id="card_totalquantity" class="input form-control" value="<?php  echo $card['card_totalquantity'];?>" <?php  if(!empty($card)) { ?>disabled<?php  } ?> />
					<?php  } else { ?>
					<?php  echo $card['card_totalquantity'];?>
					<?php  } ?>
				</div>
			</div>
			<hr style="height: 3px;background-color: #fff;margin: 0 -30px">


			<!--logo图片-->
			<div class="form-group">
				<label class="col-sm-2 control-label">logo图片</label>
				<div class="col-sm-9 col-xs-12">
					<div class="frm-image">
						<input type="hidden" name="card_logoimg" id="card_logoimg" value="<?php  echo $card['card_logoimg'];?>"/>
						<input type="hidden" name="card_logolocalpath" id="card_logolocalpath" value=""/>
						<img  id="showlogo"  style="border-radius: 50%;width: 50px;height: 50px;margin-bottom: 10px"  src="<?php  if(empty($card)) { ?>../addons/ewei_shopv2/static/images/nopic.png<?php  } else { ?><?php  echo $card['card_logoimg'];?><?php  } ?>" />
					</div>
				</div>
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-9 col-xs-12">
					<a class="btn btn-default upload" href="javascript:void(0);" <?php if(cv('member.card')) { ?>id="uploadlogo"<?php  } else { ?>disabled<?php  } ?> >上传图片</a>
					<p class='help-block'>会员卡的商户logo，建议像素为300*300。图片大小不能超过1mb,仅支持jpg,png格式</p>
				</div>
			</div>

			<!--卡券背景设置-->
			<div class="form-group">
				<label class="col-sm-2 control-label">卡券背景设置</label>
				<?php if(cv('member.card')) { ?>
				<label class="radio-inline">
					<input type="radio" name="card_backgroundtype" value="0"
						   onclick="$('.backgroundimg').hide();$('.color').show();$('.btn-color-down').hide();"
						   <?php  if(empty($card['card_backgroundtype'])) { ?>checked="true"<?php  } ?> />使用背景色
				</label>
				<label class="radio-inline">
					<input type="radio" name="card_backgroundtype" value="1"
						   onclick="$('.backgroundimg').show();$('.color').hide();$('.btn-color-down').hide();"
						   <?php  if(!empty($card['card_backgroundtype'])) { ?>checked="true"<?php  } ?> />使用背景图片
				</label>
				<?php  } else { ?>
				<input type="hidden" name="card_backgroundtype" value="<?php  echo $card['card_backgroundtype'];?>">
				<div class='col-sm-9 col-xs-12'>
					<?php  if(empty($card['card_backgroundtype'])) { ?>
					使用背景色
					<?php  } else { ?>
					使用背景图片
					<?php  } ?>
				</div>
				<?php  } ?>
			</div>

			<!--会员卡背景图-->
			<div class="form-group backgroundimg" <?php  if(empty($card['card_backgroundtype'])) { ?> style="display:none;"<?php  } ?>>
			<label class="col-sm-2 control-label">会员卡背景图</label>
			<div class="col-sm-9 col-xs-12">
				<div class="frm-image">
					<input type="hidden" name="card_backgroundimg" id="card_backgroundimg" value="<?php  echo $card['card_backgroundimg'];?>"/>
					<input type="hidden" name="card_backgroundimg_localpath" id="card_backgroundimg_localpath" value=""/>
					<img  id="showbackground"  src="<?php  echo $card['card_backgroundimg'];?>" style="width: 50px;height: 50px;margin-bottom: 10px"/>
				</div>
			</div>
			<label class="col-sm-2 control-label"></label>
			<div class="col-sm-9 col-xs-12">
				<a class="btn btn-default upload" href="javascript:void(0);" <?php if(cv('member.card')) { ?> id="uploadbackground"    <?php  } else { ?>disabled<?php  } ?> >上传图片</a>
				<p class='frm_tip'>会员卡背景图，建议像素为1000*600。图片大小不能超过1mb,仅支持jpg,png格式</p>
			</div>
		</div>

		<!--卡券颜色-->
		<div class="control-group color"   <?php  if(!empty($card['card_backgroundtype'])) { ?> style="display:none;"<?php  } ?>>
		<label class="col-sm-2 control-label">卡券背景色</label>
		<div class="btn-groups  btn-group btns">
			<input type="hidden" name="color2" id="color2" value="<?php  echo $card['color2'];?>"/>
			<input type="hidden" name="color" id="color" value="<?php  if(empty($card['color'])) { ?>Color010<?php  } else { ?><?php  echo $card['color'];?><?php  } ?>"/>
			<?php if( ce('sale.wxcard' ,$card) ) { ?>
			<a id="selected-color2" class="dropdown-toggle" data-toggle="dropdown"><i  <?php  if(empty($card['color'])) { ?>style=" background-color: rgb(99, 179, 89);"<?php  } else { ?>style=" background-color: <?php  echo $card['color2'];?>;"<?php  } ?>></i><span class="caret pull-right"></span></a>
			<?php  } else { ?>
			<a class="dropdown-toggle" ><i <?php  if(empty($card['color'])) { ?>style=" background-color: rgb(99, 179, 89);"<?php  } else { ?>style=" background-color: <?php  echo $card['color2'];?>;"<?php  } ?>></i><span class="caret pull-right"></span></a>
			<?php  } ?>
			<ul class="dropdown-menu" style="width:180px;">
				<li style="display:inline-block;">
					<div id="colorpalette3"></div>
				</li>
			</ul>
		</div>
	</div>

		<!--特权说明-->
		<div class="form-group">
			<label class="col-sm-2 control-label">特权说明</label>
			<?php if(cv('member.card')) { ?>
			<div class="col-sm-9 col-xs-12">
				<textarea  name="prerogative" rows="5" class="form-control"><?php  echo $card['prerogative'];?></textarea>
				<p class='help-block'>文本长度不能超过300字</p>
			</div>
			<?php  } else { ?>
			<div class='form-control-static'><?php  echo $card['prerogative'];?></div>
			<?php  } ?>
		</div>

		<!--使用须知-->
		<div class="form-group">
			<label class="col-sm-2 control-label">使用须知</label>
			<?php if(cv('member.card')) { ?>
			<div class="col-sm-9 col-xs-12">
				<textarea  name="card_description" rows="5"  class="form-control"><?php  echo $card['card_description'];?></textarea>
				<p class='help-block'>文本长度不能超过300字</p>
			</div>
			<?php  } else { ?>
			<div class='form-control-static'><?php  echo $card['card_description'];?></div>
			<?php  } ?>
		</div>

		<!--商户服务-->
		<div class="form-group">
			<label class="col-sm-2 control-label">商户服务</label>
			<?php if(cv('member.card')) { ?>
			<div class="col-sm-9 col-xs-12">
					<!--BIZ_SERVICE_FREE_WIFI-->
					<label class="checkbox-inline">
						<input type="checkbox" name="freewifi" id="freewifi" <?php  if(!empty($card['freewifi'])) { ?>checked<?php  } ?> <?php  if(!empty($card)) { ?>disabled<?php  } ?> / >免费WIFI
					</label>
					<label class="checkbox-inline">
						<!--BIZ_SERVICE_WITH_PET-->
						<input type="checkbox" name="withpet" id="withpet" <?php  if(!empty($card['withpet'])) { ?>checked<?php  } ?> <?php  if(!empty($card)) { ?>disabled<?php  } ?> />可带宠物
					</label>
					<label class="checkbox-inline">
						<!--BIZ_SERVICE_FREE_PARK-->
						<input type="checkbox" name="freepark" id="freepark" <?php  if(!empty($card['freepark'])) { ?>checked<?php  } ?> <?php  if(!empty($card)) { ?>disabled<?php  } ?> / >免费停车
					</label>
					<label class="checkbox-inline">
						<!--BIZ_SERVICE_DELIVER-->
						<input type="checkbox" name="deliver" id="deliver" <?php  if(!empty($card['deliver'])) { ?>checked<?php  } ?> <?php  if(!empty($card)) { ?>disabled<?php  } ?> / >可外卖
					</label>
			</div>
			<?php  } else { ?>
			<div class='frm_controls'>
				<?php  if(!empty($card['freewifi'])) { ?>免费WIFI <?php  } ?>
				<?php  if(!empty($card['withpet'])) { ?>可带宠物<?php  } ?>
				<?php  if(!empty($card['freepark'])) { ?>免费停车<?php  } ?>
				<?php  if(!empty($card['deliver'])) { ?>可外卖<?php  } ?>
			</div>
			<?php  } ?>
		</div>

		<!--是否自定义入口-->
		<div class="form-group">
			<label class="col-sm-2 control-label">自定入口</label>
			<div class="col-sm-9 col-xs-12">
				<?php if(cv('member.card')) { ?>
				<label class="radio-inline">
					<input type="radio" name="custom_cell1" value="1"  onclick="$('.custom_cell1').show();$('#show_custom_cell1').show();" <?php  if(!empty($card['custom_cell1'])) { ?>checked="true"<?php  } ?>  />开启
				</label>
				<label class="radio-inline">
					<input type="radio" name="custom_cell1" value="0"   onclick="$('.custom_cell1').hide();$('#show_custom_cell1').hide();" <?php  if(empty($card['custom_cell1'])) { ?>checked="true"<?php  } ?> />关闭
				</label>
				<?php  } else { ?>
				<input type="hidden" name="custom_cell1" value="<?php  echo $card['custom_cell1'];?>">
				<div class='frm_controls'>
					<?php  if(empty($card['custom_cell1'])) { ?>
					关闭
					<?php  } else { ?>
					开启
					<?php  } ?>
				</div>
				<?php  } ?>
			</div>
		</div>

		<!--入口名称-->
		<div class="form-group custom_cell1"  <?php  if(empty($card['custom_cell1'])) { ?> style="display:none;"<?php  } ?>>
			<label class="col-sm-2 control-label">入口名称</label>
			<div class="col-sm-9 col-xs-12">
				<?php if(cv('member.card')) { ?>
				<input type="text" name="custom_cell1_name" id="custom_cell1_name" class="input form-control"  value="<?php  echo $card['custom_cell1_name'];?>" />
				<?php  } else { ?>
				<?php  echo $card['custom_cell1_name'];?>
				<?php  } ?>
			</div>
		</div>

		<!--引导语-->
		<div class="form-group custom_cell1"  <?php  if(empty($card['custom_cell1'])) { ?> style="display:none;"<?php  } ?>>
		<label class="col-sm-2 control-label">引导语</label>
			<div class="col-sm-9 col-xs-12">
				<?php if(cv('member.card')) { ?>
				<input type="text" name="custom_cell1_tips" id="custom_cell1_tips" class="input form-control" value="<?php  echo $card['custom_cell1_tips'];?>" />
				<?php  } else { ?>
				<?php  echo $card['custom_cell1_tips'];?>
				<?php  } ?>
			</div>
		</div>

		<!--入口跳转链接-->
		<div class="form-group custom_cell1"  <?php  if(empty($card['custom_cell1'])) { ?> style="display:none;"<?php  } ?>>
		<label class="col-sm-2 control-label">跳转链接</label>
			<div class="col-sm-9 col-xs-12">
				<?php if(cv('member.card')) { ?>
				<div class="input-group">
					<input type="text" name="custom_cell1_url" id="custom_cell1_url" class="input form-control" value="<?php  echo $card['custom_cell1_url'];?>"  />
					<div class="input-group-btn">
						<span data-input="#custom_cell1_url" data-toggle="selectUrl" class="btn btn-default" data-full="true">选择链接</span>
					</div>
				</div>
				<?php  } else { ?>
				<?php  echo $card['custom_cell1_url'];?>
				<?php  } ?>
			</div>
		</div>
	</div>
</div>

</div>


<script type="text/javascript" src="../addons/ewei_shopv2/static/js/app/biz/sale/wxcard/colorpalette.js" charset="utf-8"></script>

<script>
	<?php  if(!empty($card)&&  !empty($card['card_backgroundtype']) &&!empty($card['card_backgroundimg'])) { ?>
	$(".logo-area").css({
		"background":"url('<?php  echo $card['card_backgroundimg'];?>') no-repeat left top",
		"background-size":"100% 100%",
	});
	<?php  } ?>


	<?php  if(!empty($card)&&  empty($card['card_backgroundtype'])) { ?>
	$(".logo-area").css({
		"background":"<?php  echo $card['color2'];?>"
	});
	<?php  } ?>

	$('#colorpalette3').colorPalette()
			.on('selectColor', function (e) {
				$('#selected-color2 i').css('background-color', e.color);
				$(".btn-color-down").hide();
				$(".logo-area").css({
					"background":e.color
				});

				$('#color2').val(e.color);
			});

	$(".btn-color-drop").off("click").on("click", function () {
		if ($(".btn-color-down").css("display") == "block") {
			$(".btn-color-down").hide();
		} else {
			$(".btn-color-down").show();
		}
	})

	require(['jquery', 'util'], function ($, util) {
		//示例图logo控制
		$('#uploadlogo').click(function () {
			util.image('', function (data) {
				$("#showlogo").attr('src', data.url);
				$("#showlogo").show();
				$("#card_logoimg").val(data.url);
				$("#card_logolocalpath").val(data.attachment);

				$("#logoimg").attr('src', data.url);

			});
		});

		//示例图封面图片控制
		$('#uploadbackground').click(function () {
			util.image('', function (data) {
				$("#showbackground").attr('src', data.url);
				$("#showbackground").show();
				$("#card_backgroundimg").val(data.url);
				$("#card_backgroundimg_localpath").val(data.attachment);


				$(".logo-area").css({
					"background":"url("+data.url+") no-repeat left top",
					"background-size":"100% 100%",
				});

			});
		});


		//示例图自定义入口1文本控制
		$('#custom_cell1_name').change(function(){

			var str = $(this).val();

			if(str=="")
			{
				str="自定义入口1(选填)";
			}

			$('#show_custom_cell1_name').html(str);
		});
		//示例图自定义入口1引导文本控制
		$('#custom_cell1_tips').change(function(){
			$('#show_custom_cell1_tips').html($(this).val());
		});

		//示例图自定义入口1引导文本控制
		$('#card_title').change(function(){
			$('#title').html($(this).val());
		});

		//示例图自定义入口1引导文本控制
		$('#card_brand_name').change(function(){
			$('#brandname').html($(this).val());
		});

	});

</script>