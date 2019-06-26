<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class='page-header'><span>当前位置： <span class="text-primary">满额立减设置</span></span></div>
 
    <div class="page-content">
        <form id="dataform"    <?php if(cv('sale.enough')) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate">


        <div class="form-group">

            <div class="col-sm-12">
                <?php if(cv('sale.enough')) { ?>
                <div class='input-group fixmore-input-group'>
                    <span class="input-group-addon">单笔订单满</span>
                    <input type="text" name="data[enoughmoney]"  value="<?php  echo $data['enoughmoney'];?>" class="form-control" />
                    <span class='input-group-addon'>元 立减</span>
                    <input type="text" name="data[enoughdeduct]"  value="<?php  echo $data['enoughdeduct'];?>" class="form-control" />
                    <span class='input-group-addon'>元</span>
                    <div class="input-group-btn"><button type='button' class="btn btn-default" ><i class="fa fa-minus"></i></button></div>
                </div>
                <?php  } else { ?>
                <div class='form-control-static'><?php  if(empty($data['enoughmoney'])) { ?>全场包邮<?php  } else { ?>订单金额满<?php  echo $data['enoughmoney'];?>元包邮<?php  } ?></div>
                <?php  } ?>
            </div>
        </div>
        <div class="form-group">

            <div class="col-sm-12">
                <div class='recharge-items'>

                    <?php  if(is_array($data['enoughs'])) { foreach($data['enoughs'] as $item) { ?>

                    <div class="input-group recharge-item fixmore-input-group" style="margin-top:5px">
                        <span class="input-group-addon">单笔订单满</span>
                        <input type="text" class="form-control" name='enough[]' value='<?php  echo $item['enough'];?>' />
                        <span class="input-group-addon">元 立减</span>
                        <input type="text" class="form-control"  name='give[]' value='<?php  echo $item['give'];?>' />
                        <span class="input-group-addon">元</span>
                        <div class='input-group-btn'>
                            <button class='btn btn-danger' type='button' onclick="removeConsumeItem(this)"><i class='fa fa-remove'></i></button>
                        </div>

                    </div>
                    <?php  } } ?>
                </div>

                <div style="margin-top:5px">
                    <button type='button' class="btn btn-default" onclick='addConsumeItem()' style="margin-bottom:5px"><i class='fa fa-plus'></i> 增加优惠项</button>
                </div>
                <span class="help-block">两项都填写才能生效</span>




            </div>
        </div>

        <?php if(cv('sale.enough')) { ?>
        <div class="form-group"></div>
        <div class="form-group">

            <div class="col-sm-9 col-xs-12">
                <input type="submit"  value="保存设置" class="btn btn-primary"/>

            </div>
        </div>
        <?php  } ?>


        </form>
    </div>
 
<script language='javascript'>
  
                $(function () {
                    $(":checkbox[name='data[enoughfree]']").click(function () {
                        if ($(this).prop('checked')) {
                            $("#enoughfree").show();
                        }
                        else {
                            $("#enoughfree").hide();
                        }
                    })
                   

                })
         
            
	function addConsumeItem(){
		var html= '<div class="input-group recharge-item fixmore-input-group"  style="margin-top:5px">';
           html+='<span class="input-group-addon">单笔订单满</span>';
		 html+='<input type="text" class="form-control" name="enough[]"  />';
							html+='<span class="input-group-addon">元 立减</span>';
							html+='<input type="text" class="form-control"  name="give[]"  />';
							html+='<span class="input-group-addon">元</span>';
							html+='<div class="input-group-btn"><button class="btn btn-danger" onclick="removeConsumeItem(this)"><i class="fa fa-remove"></i></button></div>';
						html+='</div>';
						$('.recharge-items').append(html);
	}
	function removeConsumeItem(obj){
		$(obj).closest('.recharge-item').remove();
	}
	</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--青岛易联互动网络科技有限公司-->