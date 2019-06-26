<?php defined('IN_IA') or exit('Access Denied');?>    <div class="region-goods-details row">        
	    <div class="region-goods-left col-sm-2">会员折扣</div>       
	     <div class="region-goods-right col-sm-10">            
	     <div class="form-group">                
		     <label class="col-sm-2 control-label"></label>                
			     <div class="col-sm-10">                    
			     <?php if( ce('goods' ,$item) ) { ?>                    
			     <label for="discounts_type0" class="radio-inline">
			       <input type="radio" name="discounts[type]" value="0" id="discounts_type0" <?php  if(empty($discounts) || $discounts['type'] == 0) { ?>checked="true"<?php  } ?> /> 统一设置折扣 0.1-10之间
			     </label>                    
			     <label for="discounts_type1" class="radio-inline" <?php  if($item['hasoption']!=1) { ?>style='display:none'<?php  } ?>>
			     <input type="radio" name="discounts[type]" value="1" id="discounts_type1"  
			     <?php  if(!empty($discounts) && $discounts['type'] == 1) { ?>checked="true"<?php  } ?> /> 详细设置折扣</label>                    
			     <?php  } else { ?>                    
			     <div class='form-control-static'>                        
			     <?php  if(empty($item) || $item['discounts']['type'] == 0) { ?>统一设置折扣 0.1-10之间
			     <?php  } ?>                        
			     <?php  if(!empty($item) && $item['discounts']['type'] == 1) { ?>详细设置折扣<?php  } ?>                    
			     </div>                    
			     <?php  } ?>                
		     </div>            
	     </div>            
	     <div id="discounts_0" <?php  if($discounts['type']!=0) { ?> style="display:none;" <?php  } ?>>            
		     <div class="form-group discounts-info">                
			     <div class="col-sm-12">                    
				     <div class='alert alert-primary'>                        只有当折扣大于0，小于10的情况下才能生效，否则按自身会员等级折扣计算<br>如果折扣为空或者0，则不设置折扣, 折扣和固定金额都有,则优先使用折扣<br>如果会员价为空或者0，则不设置会员价
				     </div>
			     </div>
		     </div>            
		     <?php  if(is_array($levels)) { foreach($levels as $level) { ?>            
		     <div class="form-group">                
		         <label class="col-sm-2 control-label"><?php  echo $level['levelname'];?></label>                
			     <div class="col-sm-6 col-xs-12">                    
				     <div class="input-group">                        
				     <input type="number" name="discounts[<?php  echo $level['key'];?>]" class="form-control" value="<?php echo is_array($discounts[$level['key']]) ? '' : $discounts[$level['key']]?>" data-min="0" data-max="10" />
				     <div class="input-group-addon">折 <!-- 或者 会员价 --></div>                        
				     <input style="display: none;" type="number" name="discounts[<?php  echo $level['key'];?>_pay]" class="form-control" value="<?php echo is_array($discounts[$level['key'].'_pay']) ? '' : $discounts[$level['key'].'_pay']?>" />
				     <div style="display: none;"  class="input-group-addon">元</div>                    
				     </div>           
			     </div>            
		     </div>            
		     <?php  } } ?>        
	     </div>        
	     <div id="discounts_1" <?php  if($discounts['type']!=1) { ?> style="display:none;" <?php  } ?>>            
	     <div class="form-group discounts-info">                
	     <div class="col-sm-12">                    
	     <div class='alert alert-info'>                        例如：当前商品原价是100元，如直接填写80，则优惠以后的最终价是80元，如果填写80%则为8 折，为空按自身会员等级折扣计算                    
	     </div>                
	     </div>            
	     </div>            
	     <div id='tbdiscount' style="padding-left:15px;" >                
	     <div id="discount" style="padding:0;"><?php  if($item['hasoption']==1) { ?><?php  echo $discounts_html;?><?php  } ?></div>            
	     </div>        
	     </div>        
	     </div>    
     </div>
     <script>    
     $(function () {
     	$("label[for='discounts_type0']").click(function () {
     		$("#discounts_1").hide();
     		$("#discounts_0").show();
     	})        
     	$("label[for='discounts_type1']").click(function () {
     		$("#discounts_0").hide();            
     		$("#discounts_1").show();        
     	})    
     });
     </script>