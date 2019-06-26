<?php defined('IN_IA') or exit('Access Denied');?><style>

	.fui-goods-list{width:100%;border-bottom: 1px dashed #e1ecee;padding-top:5px;padding-bottom:5px;}

	.fui-goods-list span{display: block;padding:0;}

</style>

<form class="form-horizontal form-validate" action="<?php  if($edit_flag==1) { ?><?php  echo webUrl('order/op/changeExpress')?><?php  } else { ?><?php  echo webUrl('order/op/send')?><?php  } ?>" method="post" enctype="multipart/form-data">

	<input type='hidden' name='id' value='<?php  echo $id;?>' />

	<div class="modal-dialog">

           <div class="modal-content">

            <div class="modal-header">

                <button data-dismiss="modal" class="close" type="button">×</button>

                <h4 class="modal-title"><?php  if($edit_flag==1) { ?>修改物流信息<?php  } else { ?>订单发货<?php  } ?></h4>

            </div>

            <div class="modal-body">

                   	<div class="form-group">

						<label class="col-sm-2 control-label">收 货 人</label>

						<div class="col-sm-9 col-xs-12">

							<div class="form-control-static">

								联系人: <?php  echo $address['realname'];?> / <?php  echo $address['mobile'];?> <br/>

								地    址: <?php  echo $address['province'];?><?php  echo $address['city'];?><?php  echo $address['area'];?> <?php  echo $address['address'];?>

							</div>

						</div>

					</div>

                   <div class="form-group">

						<label class="col-sm-2 control-label">配 送 员</label>

						<div class="col-sm-9 col-xs-12">

							<select class="form-control" name="deliveryman_id"  id="deliveryman_id" required>
                                <?php  if(is_array($delivery)) { foreach($delivery as $value) { ?>

                                <option value="<?php  echo $value['id'];?>" <?php  if($item['deliveryman_id']==$value['id']) { ?>selected<?php  } ?> data-name="<?php  echo $value['name'];?>"><?php  echo $value['name'];?></option>

                                <?php  } } ?>

							</select>

						</div>

					</div>      

					<div class="form-group">

						<label class="col-sm-2 control-label">快递公司</label>

						<div class="col-sm-9 col-xs-12">

							<select class="form-control" name="express" <?php  if($item['city_express_state']==1) { ?>disabled="disabled"<?php  } ?> id="express">

                                <option value="" data-name=""><?php  if($item['city_express_state']==0) { ?>其他快递<?php  } else { ?>同城配送<?php  } ?></option>

                                <?php  if(is_array($express_list)) { foreach($express_list as $value) { ?>

                                <option value="<?php  echo $value['express'];?>" <?php  if($item['express']==$value['express']) { ?>selected<?php  } ?> data-name="<?php  echo $value['name'];?>"><?php  echo $value['name'];?></option>

                                <?php  } } ?>

							</select>

							<input type='hidden' name='expresscom' id='expresscom' value="<?php  echo $item['expresscom'];?>"/>

						</div>

					</div>

					<div class="form-group">

						<label class="col-sm-2 control-label must">快递单号</label>

						<div class="col-sm-9 col-xs-12">

							<input type="text" name="expresssn" class="form-control" <?php  if($item['city_express_state']==1) { ?>disabled="disabled"<?php  } ?> value="<?php  echo $item['expresssn'];?>" data-rule-required='false' />

						</div>

					</div>

				<?php  if($order_goods) { ?>

					<div class="form-group">

						<label class="col-sm-2 control-label">发货类型</label>

						<div class="col-sm-9 col-xs-12">

							<label class="radio-inline"><input type="radio" name="sendtype" value="0" <?php  if($item['sendtype']>0) { ?>disabled="disabled"<?php  } ?>  <?php  if(empty($item['sendtype'])) { ?>checked="true"<?php  } ?>  <?php  if($item['city_express_state']==1) { ?>disabled="disabled"<?php  } ?>/> 按订单发货</label>

							<label class="radio-inline"><input type="radio" name="sendtype" value="1" <?php  if($item['sendtype']>0) { ?>disabled="disabled"<?php  } ?> <?php  if($item['sendtype']>0) { ?>checked="true"<?php  } ?>     <?php  if($item['city_express_state']==1) { ?>disabled="disabled"<?php  } ?>/> 商品分包裹发货</label>

							<span class="help-block">选择商品发货类型</span>

						</div>

					</div>

					<div class="form-group sendpress" <?php  if($item['sendtype']==0) { ?>style="display: none;"<?php  } ?>>

						<label class="col-sm-2 control-label">发货商品</label>

						<div class="col-sm-9 col-xs-12">

							<?php  if($item['sendtype'] > 0) { ?>

							<ul id="myTab" class="nav nav-tabs">

								<li class="active"><a href="#noshipped" data-toggle="tab">未发货</a></li>

								<li><a href="#shipped" data-toggle="tab">已发货</a></li>

							</ul>

							<div id="myTabContent" class="tab-content">

								<div class="tab-pane fade in active" id="noshipped">

									<div class="alert alert-danger">

										请选择需要发货的商品

									</div>

									<?php  if(is_array($noshipped)) { foreach($noshipped as $k => $g) { ?>

									<label class="fui-goods-list checkbox-inline row">

										<span class="col-sm-1">

											<?php  if($g['sendtype']==0) { ?>

											<input type="checkbox" name="ordergoodsid[]"  value="<?php  echo $g['id'];?>" <?php  if(!empty($item['quality'])) { ?>checked="true"<?php  } ?>   />

											<?php  } ?>

											<img src="<?php  echo tomedia($g['thumb'])?>" width="25" height="25" alt="">

										</span>

										<span class="col-sm-11" style="height:25px;line-height: 25px;display: block;overflow: hidden;">

											<?php  if($g['ispresell']==1) { ?><label class="fui-tag fui-tag-danger">预</label><?php  } ?><?php  echo $g['title'];?>

										</span>

									</label>

									<?php  } } ?>

								</div>

								<div class="tab-pane fade" id="shipped">

									<?php  if(is_array($shipped)) { foreach($shipped as $k => $b) { ?>

									<label class="fui-goods-list checkbox-inline row" style="padding:0;">

										<span class="col-sm-2">

											<label class="fui-tag fui-tag-danger">包裹<?php  echo $b['sendtype'];?></label>

										</span>

										<div class="col-sm-10">

											<?php  if(is_array($b['goods'])) { foreach($b['goods'] as $g) { ?>

											<div class="row" style="margin:0;padding-bottom:5px">

											   <span class="col-sm-1">

													<img src="<?php  echo tomedia($g['thumb'])?>" width="25" alt="">

											   </span>

												<span class="col-sm-11" style="height:25px;line-height: 25px;display: block;overflow: hidden;padding-left:3px;">

													<?php  if($g['ispresell']==1) { ?><label class="label label-danger" style="padding:2px 4px;margin-right:3px;">预售</label><?php  } ?><?php  echo $g['title'];?>

												</span>

											</div>

											<?php  } } ?>

										</div>

									</label>

									<?php  } } ?>

								</div>

							</div>

							<?php  } else { ?>

							<?php  if(is_array($order_goods)) { foreach($order_goods as $k => $g) { ?>

							<label class="fui-goods-list checkbox-inline row">

								<span class="col-sm-1">

									<?php  if($g['sendtype']==0) { ?>

									<input type="checkbox" name="ordergoodsid[]"  value="<?php  echo $g['id'];?>" <?php  if(!empty($item['quality'])) { ?>checked="true"<?php  } ?>   />

									<?php  } ?>

									<img src="<?php  echo tomedia($g['thumb'])?>" width="25" height="25" alt="">

								</span>

								<span class="col-sm-11" style="height:25px;line-height: 25px;display: block;overflow: hidden;">

									<?php  if($g['ispresell']==1) { ?><label class="fui-tag fui-tag-danger">预</label><?php  } ?><?php  echo $g['title'];?>

								</span>

							</label>

							<?php  } } ?>

							<?php  } ?>

						</div>

					</div>

			   		<?php  } ?>

				<?php  if($bundles) { ?>

			   <div class="form-group">

				   <label class="col-sm-2 control-label must">选择包裹</label>

				   <div class="col-sm-9 col-xs-12">

					   <div class="alert alert-danger">

						   请选择需要修改的包裹

					   </div>

					   <?php  if(is_array($bundles)) { foreach($bundles as $k => $b) { ?>

					   <label class="fui-goods-list checkbox-inline row" style="padding:0;">

							<span class="col-sm-1">

								<input type="radio" name="bundle" style="margin-top:5px;" value="<?php  echo $b['sendtype'];?>"/>

							</span>

						   <div class="col-sm-11" style="padding:5px 0;">

								<?php  if(is_array($b['goods'])) { foreach($b['goods'] as $g) { ?>

							   <div class="row" style="margin:0;padding-bottom:5px">

								   <span class="col-sm-1">

										<img src="<?php  echo tomedia($g['thumb'])?>" width="25" alt="">

								   </span>

									<span class="col-sm-11" style="height:25px;line-height: 25px;display: block;overflow: hidden;">

										<?php  if($g['ispresell']==1) { ?><label class="label label-danger" style="padding:2px 4px;margin-right:3px;">预售</label><?php  } ?><?php  echo $g['title'];?>

									</span>

							   </div>

								<?php  } } ?>

						   </div>

					   </label>

					   <?php  } } ?>

				   </div>

			   </div>

			   <?php  } ?>



			   <?php  if($sendgoods) { ?>

			   <div class="form-group">

				   <label class="col-sm-2 control-label must">包裹商品</label>

				   <div class="col-sm-9 col-xs-12">

					   <label class="fui-goods-list checkbox-inline row" style="padding:0;">

						   <div class="col-sm-11" style="padding:5px 0;">

							   <div class="row" style="margin:0;padding-bottom:5px">

								   <span class="col-sm-1">

										<img src="<?php  echo tomedia($sendgoods['thumb'])?>" width="25" alt="">

								   </span>

									<span class="col-sm-11" style="height:25px;line-height: 25px;display: block;overflow: hidden;">

										<?php  if($sendgoods['ispresell']==1) { ?><label class="label label-danger" style="padding:2px 4px;margin-right:3px;">预售</label><?php  } ?><?php  echo $sendgoods['title'];?>

									</span>

							   </div>

						   </div>

					   </label>

				   </div>

			   </div>

			   <?php  } ?>



            </div>

            <div class="modal-footer">

                <button class="btn btn-primary" type="submit"><?php  if($edit_flag==1) { ?>保存信息<?php  } else { ?>确认发货<?php  } ?></button>

                <button data-dismiss="modal" class="btn btn-default" type="button">取消</button>

            </div>

        </div>

</form>



<script language="javascript">

    $("select[name=express]").val("<?php  if(!empty($item['expresssn'])) { ?><?php  echo $item['express'];?><?php  } else { ?><?php  echo $item['dispatchkey'];?><?php  } ?>");

    $("#express").change(function () {

        var obj = $(this);

        var sel = obj.find("option:selected").attr("data-name");

        $("#expresscom").val(sel);

    });

    // $("#deliveryman_id").change(function () {

    //     var obj = $(this);

    //     var sel = obj.find("option:selected").attr("data-name");

    //     $("#deliveryman_id").val(sel);

    // });

	$("input[name=sendtype]").off("click").on("click",function(){

		window.sendtype = $(this).val();

		if(window.sendtype==1){

			$(".sendpress").show();

		}else{

			$(".sendpress").hide();

		}

	});

    $("#express").change();
    //$("#deliveryman_id").change();



</script>







