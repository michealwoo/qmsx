<?php defined('IN_IA') or exit('Access Denied');?><div class="region-goods-details row">    
<div class="region-goods-left col-sm-2">        基本信息    </div>    
<div class="region-goods-right col-sm-10">        
<div class="form-group">            
<label class="col-sm-2 control-label">排序</label>            
<div class="col-sm-9 col-xs-12">                
<?php if( ce('goods' ,$item) ) { ?>                
<input type="text" name="displayorder" id="displayorder" class="form-control" value="<?php  echo $item['displayorder'];?>" />                
<span class='help-block'>数字越大，排名越靠前,如果为空，默认排序方式为创建时间</span>                <?php  } else { ?>                
<div class='form-control-static'><?php  echo $item['displayorder'];?></div>                
<?php  } ?>            
</div>        
</div>        
<div class="form-group">            
<label class="col-sm-2 control-label must">商品名称</label>            <?php if( ce('goods' ,$item) ) { ?>            <div class="col-sm-7"  style="padding-right:0;" >                
<input type="text" name="goodsname" id="goodsname" class="form-control" value="<?php  echo $item['title'];?>" data-rule-required="true" />            
</div>            
<div class="col-sm-2" style="padding-left:5px">                
<input type="text" name="unit" id="unit" class="form-control" value="<?php  echo $item['unit'];?>" placeholder="单位, 如: 个/件/包"  />            
</div>            
<?php  } else { ?>            
<div class='form-control-static'><?php  echo $item['title'];?></div>            
<?php  } ?>        
</div>        
<div class="form-group">            
<label class="col-sm-2 control-label">副标题</label>            
<?php if( ce('goods' ,$item) ) { ?>           
<div class="col-sm-9 subtitle">                
<textarea id="" name="subtitle" id="subtitle" rows="5"  class="form-control" data-parent=".subtitle" maxlength="100" data-rule-maxlength="100"><?php  echo $item['subtitle'];?></textarea>                
<div class="help-block">副标题的长度请控制在100字以内</div>            
</div>            
<?php  } else { ?>            
<div class='form-control-static'><?php  echo $item['subtitle'];?></div>            
<?php  } ?>        
</div>        
<div class="form-group">            
<label class="col-sm-2 control-label">商品短标题</label>            
<?php if( ce('goods' ,$item) ) { ?>            
<div class="col-sm-9 subtitle">                
<input type="text" name="shorttitle" class="form-control" value="<?php  echo $item['shorttitle'];?>" />                
<div class="help-block">商品短标题 用于快递打印,以及小型热敏打印机打印</div>            
</div>            
<?php  } else { ?>            
<div class='form-control-static'><?php  echo $item['shorttitle'];?></div>            
<?php  } ?>        
</div>        
<div class="form-group">           
<label class="col-sm-2 control-label">关键字</label>            
<?php if( ce('goods' ,$item) ) { ?>            
<div class="col-sm-9">                
<input type="text" name="keywords" class="form-control" value="<?php  echo $item['keywords'];?>"/>                
<div class="help-block">商品关键字,能准确搜到商品的,比如 : 海尔电视|电视 之类的</div>            
</div>            
<?php  } else { ?>            
<div class='form-control-static'><?php  echo $item['keywords'];?></div>            
<?php  } ?>        
</div>        
<div class="form-group">            
<label class="col-sm-2 control-label">商品类型</label>            
<div class="col-sm-9 col-xs-12">                
<input type="hidden" name="goodstype" value="<?php  echo $item['type'];?>">                
<?php if( ce('goods' ,$item) ) { ?>                
<label class="radio-inline">
<input type="radio" name="type" value="1" 
<?php  if(!empty($item['id'])) { ?>disabled<?php  } ?> 
<?php  if(empty($item['type']) || $item['type'] == 1) { ?>checked="true"<?php  } ?> onclick="type_change(1);" /> 实体商品</label>                
<?php  if(com('virtual')) { ?>                    
<label class="radio-inline">
<input type="radio" name="type" value="2" <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?>  
<?php  if($item['type'] == 2) { ?>checked="true"<?php  } ?>  onclick="type_change(2);" /> 虚拟商品</label>                    <label class="radio-inline">
<input type="radio" name="type" value="3" <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?>  <?php  if($item['type'] == 3) { ?>checked="true"<?php  } ?>  onclick="type_change(3);" /> 虚拟物品(卡密)</label>                <?php  } ?>                
<label class="radio-inline">
<input type="radio" name="type" value="4" <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?>  <?php  if($item['type'] == 4) { ?>checked="true"<?php  } ?>  onclick="type_change(4);" /> 批发商品</label>                
<label class="radio-inline">
<input type="radio" name="type" value="5" <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?>  <?php  if($item['type'] == 5) { ?>checked="true"<?php  } ?>  onclick="type_change(5);" /> 记次/时商品</label>                
<?php  if(p('mr')) { ?>                
<label class="radio-inline">
<input type="radio" name="type" value="10" 
<?php  if(!empty($item['id'])) { ?>disabled<?php  } ?>  
<?php  if($item['type'] == 10) { ?>checked="true"<?php  } ?>  onclick="type_change(10);" /> 话费流量充值</label>                
<?php  } ?>               
<?php  if(p('ccard')) { ?>                
<label class="radio-inline">
<input type="radio" name="type" value="20" <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?>  <?php  if($item['type'] == 20) { ?>checked="true"<?php  } ?>  onclick="type_change(20);" /> 充值卡</label>                
<?php  } ?>                
<span class="help-block">商品类型，商品保存后无法修改，请谨慎选择</span>                <?php  } else { ?>                
<div class='form-control-static'><?php  if(empty($item['type']) || $item['type'] == 1) { ?>                    实体物品                    
<?php  } else if($item['type']==2) { ?>                    
虚拟物品                    
<?php  } else if($item['type']==3) { ?>                    
虚拟物品(卡密)                    
<?php  } ?>
</div>                
<?php  } ?>            
</div>        
</div>        
<div class="form-group">            
<label class="col-sm-2 control-label">供 货 商</label>            
<div class="col-sm-9 col-xs-12">                
<select class="form-control select2" name="supplier_id"  id="supplier_id">                    
<option value="0" data-name="请选择">请选择</option>                    
<?php  if(is_array($supplier)) { foreach($supplier as $value) { ?>                    
<option value="<?php  echo $value['id'];?>" <?php  if($item['supplier_id']==$value['id']) { ?>selected<?php  } ?> data-name="<?php  echo $value['name'];?>"><?php  echo $value['name'];?></option>                    
<?php  } } ?>                
</select>            
</div>        
</div>     
</div></div>    
<!--商品信息-->    
<div class="region-goods-details row">        
<div class="region-goods-left col-sm-2">            
商品信息        
</div>        
<div class="region-goods-right col-sm-10">            
<div class="form-group dispatch_info" 
<?php  if(!empty($item['type']) && $item['type'] > 1) { ?>style="display: none;"<?php  } ?>>            
<label class="col-sm-2 control-label">预售设置</label>            
<div class="col-sm-9 col-xs-12">                
<?php if( ce('goods' ,$item) ) { ?>                
<label class="radio-inline">
<input type="radio" name="ispresell" value="0"  
<?php  if(empty($item['ispresell'])) { ?>checked="true"<?php  } ?>/> 否</label>                
<label class="radio-inline">
<input type="radio" name="ispresell" value="1" <?php  if($item['ispresell'] == 1) { ?>checked="true"<?php  } ?>   /> 是</label>                
<span class="help-block">提示：是否开启商品预售设置</span>                <?php  } else { ?>                
<div class='form-control-static'><?php  if(empty($item['ispresell'])) { ?>否<?php  } else { ?>是<?php  } ?></div>                
<?php  } ?>            
</div>        
</div>        
<div class="form-group presell_info" <?php  if(empty($item['ispresell']) || $item['ispresell'] > 1) { ?>style="display: none;"<?php  } ?>>        
<label class="col-sm-2 control-label must">预售价格</label>        
<div class="col-sm-9 col-xs-12">           
<?php if( ce('goods' ,$item) ) { ?>            
<div class="input-group">                
<input type="text" name="presellprice" id="presellprice" class="form-control" value="<?php  echo $item['presellprice'];?>" />                
<span class="input-group-addon">元</span>            
</div>            
<span class='help-block'>尽量填写完整，有助于于商品销售的数据分析</span>            
<?php  } else { ?>            
<div class='form-control-static'>预售：<?php  echo $item['presellprice'];?> 元</div>            
<?php  } ?>        
</div>    
</div>    
<div class="form-group presell_info" <?php  if(empty($item['ispresell']) || $item['ispresell'] > 1) { ?>style="display: none;"<?php  } ?>>    
<label class="col-sm-2 control-label">预售时间</label>    
<div class="col-sm-9 col-xs-12">        
<?php if( ce('goods' ,$item) ) { ?>        
<div class="input-group">                
<span class="input-group-addon">                   
<input type="checkbox" name="presellstart" value="1" id="presellstart" <?php  if($item['presellstart'] == 1) { ?>checked="true"<?php  } ?> />                    
预售开始时间                
</span>            
<?php echo tpl_form_field_eweishop_date('preselltimestart', !empty($item['preselltimestart']) ? date('Y-m-d H:i',$item['preselltimestart']) : date('Y-m-d H:i'),true)?>                
<span class="input-group-addon">                    
<input type="checkbox" name="presellend" value="1" id="presellend" <?php  if($item['presellend'] == 1) { ?>checked="true"<?php  } ?> />                    
预售结束时间                
</span>            
<?php echo tpl_form_field_eweishop_date('preselltimeend', !empty($item['preselltimeend']) ? date('Y-m-d H:i',$item['preselltimeend']) : date('Y-m-d H:i'),true)?>        
</div>        
<span class='help-block'>尽量填写完整，有助于于商品销售的数据分析</span>        
<?php  } else { ?>        
<div class='form-control-static'>            
<?php  if($item['ispresell']==1) { ?> <?php  echo date('Y-m-d H:i',$item['preselltimestart'])?> - <?php  echo date('Y-m-d H:i',$item['preselltimeend'])?> <?php  } ?>        
</div>        <?php  } ?>    
</div>    
</div>    
<div class="form-group presell_info" <?php  if(empty($item['ispresell']) || $item['ispresell'] > 1) { ?>style="display: none;"<?php  } ?>>    
<label class="col-sm-2 control-label">发货时间</label>    
<div class="col-sm-6 col-xs-6" style='padding-left:0'>        
<?php if( ce('goods' ,$item) ) { ?>        
<div class="input-group">                
<span class='input-group-addon' style='border:none'>                    
<label class="radio-inline" style='margin-top:-7px;' >                        
<input type="radio" name="presellsendtype" value="0" <?php  if(empty($item['presellsendtype'])) { ?>checked="true"<?php  } ?>   /> 固定时间                    
</label>                
</span>            
<?php echo tpl_form_field_eweishop_date('presellsendstatrttime', !empty($item['presellsendstatrttime']) ? date('Y-m-d H:i',$item['presellsendstatrttime']) : date('Y-m-d H:i'),true)?>        
</div>       
<?php  } else { ?>        
<div class='form-control-static'>            
<?php  if($item['presellsendtype']==0) { ?>固定时间<?php  } ?> {date('Y-m-d H:i',$item['presellsendstatrttime'])}        
</div>        
<?php  } ?>    
</div>    
</div>    
<div class="form-group presell_info" <?php  if(empty($item['ispresell']) || $item['ispresell'] > 1) { ?>style="display: none;"<?php  } ?>>    
<label class="col-sm-2 control-label"></label>    
<div class="col-sm-6 col-xs-6" style='padding-left:0'>        
<?php if( ce('goods' ,$item) ) { ?>        
<div class="input-group">                
<span class='input-group-addon' style='border:none'>                    
<label class="radio-inline"  style='margin-top:-7px;' >                        
<input type="radio"name="presellsendtype" value="1" <?php  if($item['presellsendtype'] == 1) { ?>checked="true"<?php  } ?>  /> 购买时间                    
</label>                
</span>            
<span class="input-group-addon">购买后</span>            
<input type="text" name="presellsendtime" id="presellsendtime" class="form-control" value="<?php  echo $item['presellsendtime'];?>" />            
<span class="input-group-addon">天发货</span>        
</div>        
<?php  } else { ?>        
<div class='form-control-static'>            
<?php  if($item['presellsendtype']==1) { ?>购买时间<?php  } ?> 购买后 <?php  echo $item['presellsendtime'];?> 天发货        
</div>        
<?php  } ?>   
</div>    
</div>    
<div class="form-group presell_info" <?php  if(empty($item['ispresell']) || $item['ispresell'] > 1) { ?>style="display: none;"<?php  } ?>>    
<label class="col-sm-2 control-label">预售结束设置</label>    
<div class="col-sm-9 col-xs-12">        
<?php if( ce('goods' ,$item) ) { ?>        
<div class="input-group">                    
<span class="input-group-addon">                        
<input type="checkbox" name="presellover" value="1" id="presellover" <?php  if($item['presellover'] == 1) { ?>checked="true"<?php  } ?> />                        
预售结束                    
</span>           
 <input type="text" name="presellovertime" id="presellovertime" class="form-control" value="<?php  echo $item['presellovertime'];?>" />            
 <span class="input-group-addon">天后，商品转为正常销售</span>        
 </div>        
 <span class='help-block'>如不选择，则商品预售结束商品下架</span>        
 <?php  } else { ?>        
 <div class='form-control-static'>            
 <?php  if($item['presellover']==1) { ?> 预售结束<?php  echo $item['presellovertime'];?>天后，商品转为正常销售 <?php  } ?>        
 </div>        
 <?php  } ?>    
 </div>    
 </div>    
 <div class="form-group send-group" style="<?php  if($item['type'] != 2) { ?>display: none;<?php  } ?>">       
 <label class="col-sm-2 control-label">自动发货</label>        
 <div class="col-sm-9 col-xs-12">            
 <?php if( ce('goods' ,$item) ) { ?>            
 <label class="radio-inline">
 <input type="radio" onclick="type_change(2);" name="virtualsend" value="0"  
 <?php  if(empty($item['virtualsend'])) { ?>checked="true"<?php  } ?>/> 否</label>            
 <label class="radio-inline">
 <input type="radio" onclick="type_change(2);" name="virtualsend" value="1" <?php  if($item['virtualsend'] == 1) { ?>checked="true"<?php  } ?>   /> 是</label>            
 <span class="help-block">提示：发货后订单自动完成</span>            
 <?php  } else { ?>            
 <div class='form-control-static'>
 <?php  if(empty($item['virtualsend'])) { ?>否<?php  } else { ?>是<?php  } ?></div>            
 <?php  } ?>        
 </div>    
 </div>    
 <div class="form-group send-group" style="<?php  if($item['type'] != 2) { ?>display: none;<?php  } ?>">        
 <label class="col-sm-2 control-label">自动发货内容</label>        
 <div class="col-sm-9 col-xs-12">            
 <textarea class="form-control" name="virtualsendcontent"><?php  echo $item['virtualsendcontent'];?></textarea>        
 </div>    
 </div>    
 <?php  if(com('virtual')) { ?>    
 <div class="form-group" style="<?php  if($item['type'] != 3) { ?>display: none;<?php  } ?>" id="type_virtual" <?php  if(!empty($item['id'])) { ?>disabled<?php  } ?>>    
 <label class="col-sm-2 control-label"></label>    
 <div class="col-sm-6 col-xs-6">        
 <?php if( ce('goods' ,$item) ) { ?>        
 <select class="form-control select2" id="virtual" name="virtual">            
<option value="0">多规格虚拟物品</option>            
<?php  if(is_array($virtual_types)) { foreach($virtual_types as $virtual_type) { ?>            
<option value="<?php  echo $virtual_type['id'];?>" <?php  if($item['virtual'] == $virtual_type['id']) { ?>selected="true"<?php  } ?>><?php  echo $virtual_type['usedata'];?>/<?php  echo $virtual_type['alldata'];?> | <?php  echo $virtual_type['title'];?></option>            <?php  } } ?>        </select>        <span>提示：直接选中虚拟物品模板即可，选择多规格需在商品规格页面设置</span>        <?php  } else { ?>        <?php  if(is_array($virtual_types)) { foreach($virtual_types as $virtual_type) { ?>        <?php  if($item['virtual'] == $virtual_type['id']) { ?><?php  echo $virtual_type['usedata'];?>/<?php  echo $virtual_type['alldata'];?> | <?php  echo $virtual_type['title'];?><?php  } ?>        <?php  } } ?>        <?php  } ?>    </div>    </div>    <?php  } ?>    <div class="form-group">        <label class="col-sm-2 control-label">商品分类</label>        <div class="col-sm-8 col-xs-12">            <?php if( ce('goods' ,$item) ) { ?>            <select id="cates"  name='cates[]' class="form-control select2" style='width:605px;' multiple='' >                <?php  if(is_array($category)) { foreach($category as $c) { ?>                <option value="<?php  echo $c['id'];?>" <?php  if(is_array($cates) &&  in_array($c['id'],$cates)) { ?>selected<?php  } ?> ><?php  echo $c['name'];?></option>                <?php  } } ?>            </select>            <?php  } else { ?>            <div class='form-control-static ops'>                <?php  if(is_array($cates)) { foreach($cates as $c) { ?>                <a><?php  echo $category[$c]['name'];?></a>                <?php  } } ?>            </div>            <?php  } ?>        
</div>    </div>    <div class="form-group">        <label class="col-sm-2 control-label">商品属性</label>        <div class="col-sm-9 col-xs-12" >            <?php if( ce('goods' ,$item) ) { ?>            <label for="isrecommand" class="checkbox-inline">                <input type="checkbox" name="isrecommand" value="1" id="isrecommand" <?php  if($item['isrecommand'] == 1) { ?>checked="true"<?php  } ?> /> 推荐            </label>            <label for="isnew" class="checkbox-inline">                <input type="checkbox" name="isnew" value="1" id="isnew" <?php  if($item['isnew'] == 1) { ?>checked="true"<?php  } ?> /> 新品            </label>            <label for="ishot" class="checkbox-inline">                <input type="checkbox" name="ishot" value="1" id="ishot" <?php  if($item['ishot'] == 1) { ?>checked="true"<?php  } ?> /> 热卖            </label>            <label for="issendfree" class="checkbox-inline">                <input type="checkbox" name="issendfree" value="1" id="issendfree" <?php  if($item['issendfree'] == 1) { ?>checked="true"<?php  } ?> /> 包邮            </label>            
<label for="isnodiscount" class="checkbox-inline">                <input type="checkbox" name="isnodiscount" value="1" id="isnodiscount" <?php  if($item['isnodiscount'] == 1) { ?>checked="true"<?php  } ?> /> 不参与会员折扣            </label>            <?php  } else { ?> <div class='form-control-static'>            <?php  if($item['isnew']==1) { ?>新品; <?php  } ?>            <?php  if($item['ishot']==1) { ?>热卖; <?php  } ?>            <?php  if($item['isrecommand']==1) { ?>推荐; <?php  } ?>            <?php  if($item['issendfree']==1) { ?>包邮; <?php  } ?>            <?php  if($item['isnodiscount']==1) { ?>不参与折扣; <?php  } ?>        </div>            
<?php  } ?>            <?php  if($item['merchid']>0) { ?><span class="help-block">多商户的商品如果设置参与会员折扣，给多商户结算的时候是按照折扣前的价格结算</span><?php  } ?>        </div>    </div>    <div class="form-group price" <?php  if($item['type']==4) { ?>  style="display: none"<?php  } ?>>    <label class="col-sm-2 control-label">商品价格</label>    <div class="col-sm-9 col-xs-12">        <?php if( ce('goods' ,$item) ) { ?>        <div class="input-group">            <input type="text" name="marketprice" id="marketprice" class="form-control" value="<?php  echo $item['marketprice'];?>" />            <span class="input-group-addon">元 原价</span>            <input type="text" name="productprice" id="productprice" class="form-control" value="<?php  echo $item['productprice'];?>" />            <span class="input-group-addon">元 成本</span>            <input type="text" name="costprice" id="costprice" class="form-control" value="<?php  echo $item['costprice'];?>" />            <span class="input-group-addon">元</span>        </div>        <span class='help-block'>尽量填写完整，有助于于商品销售的数据分析</span>        <?php  } else { ?>        
<div class='form-control-static'>现价：<?php  echo $item['marketprice'];?> 元 原价：<?php  echo $item['productprice'];?> 元 成本：<?php  echo $item['costprice'];?> 元</div>        <?php  } ?>    </div>    </div>    <div class="form-group interval"  <?php  if($item['type']!=4) { ?>  style="display: none"<?php  } ?> >    <label class="col-sm-2 control-label" >批发价格</label>    <div class="col-sm-2">        <input type="hidden" id="intervalfloor" name="intervalfloor" value="<?php  echo $item['intervalfloor'];?>">        <?php if( ce('goods' ,$item) ) { ?>        <a href="javascript:;" id='add-param' onclick="setinterval('plus')" class="btn btn-default"  title="添加价格区间"><i class='fa fa-plus'></i> 添加价格区间</a>        <?php  } ?>    </div>    <div class="col-sm-2">        <?php if( ce('goods' ,$item) ) { ?>        <a href="javascript:;" id='add-param' onclick="setinterval('minus')" class="btn btn-default"  title="添加价格区间"><i class='fa fa-minus'></i> 移除价格区间</a>        <?php  } ?>    </div>    <div class="col-sm-5">        <p style="margin-top: 7px;">批发商品请至少设置一组价格区间，才能正常发布信息。</p>    </div>    </div>    <div class="form-group interval"  <?php  if($item['type']!=4) { ?>  style="display: none"<?php  } ?> >    <div class="col-sm-2">    </div>    <div class="col-sm-8">        
<div class="input-group"  <?php  if(!is_array($intervalprices['0'])) { ?> style="display: none"<?php  } ?>  id="interval1">        <span class="input-group-addon">购买</span>        <input type="text" name="intervalnum1" id="intervalnum1" class="form-control" value="<?php  if(is_array($intervalprices['0'])) { ?><?php  echo $intervalprices[0]['intervalnum'];?><?php  } ?>" />        <span class="input-group-addon">件及以上</span>        <input type="text" name="intervalprice1" id="intervalprice1" class="form-control" value="<?php  if(is_array($intervalprices['0'])) { ?><?php  echo $intervalprices[0]['intervalprice'];?><?php  } ?>" />        <span class="input-group-addon">元/件</span>        <!--<span class="input-group-addon" style="padding:0;">            <a href="javascript:;" class='btn btn-default btn-sm' style="border:none;" onclick="" title="删除"><i class='fa fa-remove'></i></a>        </span>-->    
</div>    <div class="input-group"  <?php  if(!is_array($intervalprices['1'])) { ?> style="display: none"<?php  } ?> id="interval2">    <span class="input-group-addon">购买</span>    <input type="text" name="intervalnum2" id="intervalnum2" class="form-control" value="<?php  if(is_array($intervalprices['1'])) { ?><?php  echo $intervalprices[1]['intervalnum'];?><?php  } ?>" />    <span class="input-group-addon">件及以上</span>    <input type="text" name="intervalprice2" id="intervalprice2" class="form-control" value="<?php  if(is_array($intervalprices['1'])) { ?><?php  echo $intervalprices[1]['intervalprice'];?><?php  } ?>" />    <span class="input-group-addon">元/件</span>    <!--<span class="input-group-addon" style="padding:0;">        <a href="javascript:;" class='btn btn-default btn-sm' style="border:none;" onclick="" title="删除"><i class='fa fa-remove'></i></a>    </span>-->    </div>    <div class="input-group" <?php  if(!is_array($intervalprices['2'])) { ?> style="display: none"<?php  } ?> id="interval3">    <span class="input-group-addon">购买</span>    <input type="text" name="intervalnum3" id="intervalnum3" class="form-control" value="<?php  if(is_array($intervalprices['2'])) { ?><?php  echo $intervalprices[2]['intervalnum'];?><?php  } ?>" />    <span class="input-group-addon">件及以上</span>    <input type="text" name="intervalprice3" id="intervalprice3" class="form-control" value="<?php  if(is_array($intervalprices['2'])) { ?><?php  echo $intervalprices[2]['intervalprice'];?><?php  } ?>" />    
<span class="input-group-addon">元/件</span>    <!--<span class="input-group-addon" style="padding:0;">        <a href="javascript:;" class='btn btn-default btn-sm' style="border:none;" onclick="" title="删除"><i class='fa fa-remove'></i></a>    </span>-->    </div>    </div>    </div>    <?php  if(p('offic')) { ?>    <div class="form-group">        <label class="col-sm-2 control-label">文案营销长图</label>        <div class="col-sm-9 col-xs-12">            <?php if( ce('goods' ,$item) ) { ?>            <?php  echo tpl_form_field_image2('officthumb', $item['officthumb'])?>            <span class='help-block'>营销专用商品长缩略图</span>            <?php  } else { ?>            <?php  if(!empty($item['officthumb'])) { ?>            <a href="<?php  echo tomedia($item['officthumb'])?>" target="_blank">            <img src="<?php  echo tomedia($item['officthumb'])?>" style="width:100px;border:1px solid #ccc;padding:1px" />            </a>            <?php  } ?>            <?php  } ?>        </div>    </div>    <?php  } ?>    <div class="form-group">        <label class="col-sm-2 control-label must">商品图片</label>        <div class="col-sm-9 col-xs-12 gimgs">            <?php if( ce('goods' ,$item) ) { ?>            <?php  echo tpl_form_field_multi_image2('thumbs',$piclist)?>            <span class="help-block image-block">第一张为缩略图，其他为详情页图片，尺寸建议宽度为640，并保持图片大小一致，图片大小依照首图尺寸显示，不显示首图时依照第二张图片尺寸显示</span>            <span class="help-block">您可以拖动图片改变其显示顺序 </span>            <?php  } else { ?>            <?php  if(is_array($piclist)) { foreach($piclist as $p) { ?>            <a href='<?php  echo tomedia($p)?>' target='_blank'>                <img src="<?php  echo tomedia($p)?>" style='height:100px;border:1px solid #ccc;padding:1px;float:left;margin-right:5px;' />            </a>            <?php  } } ?>            <?php  } ?>        </div>    </div>    <div class="form-group">        <label class="col-sm-2 control-label"></label>        <div class="col-sm-9 col-xs-12">            <?php if( ce('goods' ,$item) ) { ?>            <label class="checkbox-inline"><input type="checkbox" name="thumb_first" value="1" <?php  if($item['thumb_first'] == 1) { ?>checked="true"<?php  } ?>   /> 详情显示首图</label>            <span class="help-block"></span>            <?php  } else { ?>            <div class='form-control-static'><?php  if(empty($item['thumb_first'])) { ?>否<?php  } else { ?>是<?php  } ?></div>            <?php  } ?>        </div>    </div>    <?php  if(p('app')) { ?>    <div class="form-group">        <label class="col-sm-2 control-label">首图视频</label>        <div class="col-sm-9 col-xs-12">            <?php  echo tpl_form_field_video2('video', $item['video'], array('disabled'=>!cv('goods.edit'), 'network'=>true, 'placeholder'=>'请选择视频'))?>            <div class='form-control-static'>设置后商品详情首图默认显示视频，目前仅支持小程序</div>        
</div>    </div>    <?php  } ?>        <div class="form-group" <?php  if($item['type']==10) { ?>style="display:none"<?php  } ?>>        <label class="col-sm-2 control-label">已出售数</label>        <div class="col-sm-6 col-xs-12">            <?php if( ce('goods' ,$item) ) { ?>            <div class="input-group">                <input type="text" name="sales" id="sales" class="form-control" value="<?php  echo $item['sales'];?>" />                <span class="input-group-addon">件</span>            </div>            <?php  } else { ?>            <div class='form-control-static'><?php  echo $item['sales'];?> 件</div>            <?php  } ?>        </div>        </div>        <div class="form-group">            <label class="col-sm-2 control-label"></label>            <div class="col-sm-9 col-xs-12">                <?php if( ce('goods' ,$item) ) { ?>                <label class="checkbox-inline"><input type="checkbox" name="showsales" value="1" <?php  if($item['showsales'] == 1) { ?>checked="true"<?php  } ?>   /> 显示销量</label>                <span class="help-block"></span>                <?php  } else { ?>                <div class='form-control-static'><?php  if(empty($item['showsales'])) { ?>否<?php  } else { ?>是<?php  } ?></div>                <?php  } ?>            </div>        </div>    </div></div><div class="region-goods-details row">    <div class="region-goods-left col-sm-2">        商品属性    </div>    <div class="region-goods-right col-sm-10">        <div class="form-group dispatch_info" <?php  if(($item['type'] == 2 || $item['isverify']==2 || $item['type'] == 3 || $item['type'] == 5 || $item['type'] == 10)) { ?>style="display: none;"<?php  } ?>>            <label class="col-sm-2 control-label">单品满件包邮</label>            <div class="col-sm-8">                <?php if( ce('goods' ,$item) ) { ?>                <div class='input-group fixsingle-input-group'>                    <span class="input-group-addon">满</span>                    <input type="text" name="ednum" value="<?php  echo $item['ednum'];?>" class="form-control"/>                    <span class="input-group-addon">件</span>                </div>                <span class="help-block">如果设置0或空，则不支持满件包邮</span>                <?php  } else { ?>                <div class='form-control-static'><?php  if(empty($item['ednum'])) { ?>不支持满件包邮<?php  } else { ?>支持 <?php  } ?></div>                <?php  } ?>            </div>        </div>        <div class="form-group dispatch_info" <?php  if(($item['type'] == 2 || $item['isverify']==2  || $item['type'] == 3 || $item['type'] == 5 || $item['type'] == 10)) { ?>style="display: none;"<?php  } ?>>            <label class="col-sm-2 control-label">单品满额包邮</label>            <div class="col-sm-8">                <?php if( ce('goods' ,$item) ) { ?>                <div class='input-group fixsingle-input-group'>                    <span class="input-group-addon">满</span>                    <input type="text" name="edmoney" value="<?php  echo $item['edmoney'];?>" class="form-control"/>                    <span class="input-group-addon">元</span>                </div>                <span class="help-block">如果设置0或空，则不支持满额包邮</span>                <?php  } else { ?>                <div class='form-control-static'><?php  if(empty($item['edmoney'])) { ?>不支持满额包邮<?php  } else { ?>支持 <?php  } ?></div>                <?php  } ?>            </div>        </div>        <div class="form-group dispatch_info" <?php  if(($item['type'] == 2  || $item['isverify']==2 || $item['type'] == 3 || $item['type'] == 5 || $item['type'] == 10)) { ?>style="display: none;"<?php  } ?>>            <label class="col-sm-2 control-label">不参与单品包邮地区</label>            <div class="col-sm-9 col-xs-12">                <?php if( ce('goods' ,$item) ) { ?>                <div id="areas" class="form-control-static"><?php  echo $item['edareas'];?></div>                <a href="javascript:;" class="btn btn-default" onclick="selectAreas()">添加不参加满包邮的地区</a>                <input type="hidden" id='selectedareas' name="edareas" value="<?php  echo $item['edareas'];?>"/>                <input type="hidden" id='selectedareas_code' name="edareas_code" value="<?php  echo $item['edareas_code'];?>"/>                <span class="help-block">如果设置0或空，则不支持满件包邮</span>                <?php  } else { ?>                <div class='form-control-static'><?php  echo $set['enoughareas'];?></div>                <?php  } ?>            </div>        </div>        <div class="form-group dispatch_info" <?php  if(($item['type'] == 2  || $item['isverify']==2 || $item['type'] == 3 || $item['type'] == 5 || $item['type'] == 10)) { ?>style="display: none;"<?php  } ?>>        <label class="col-sm-2 control-label">运费设置</label>        <div class="col-sm-6 col-xs-6" style='padding-left:0'>            <?php if( ce('goods' ,$item) ) { ?>            <div class="input-group">                <span class='input-group-addon' style='border:none'><label class="radio-inline" style='margin-top:-7px;' ><input type="radio" name="dispatchtype" value="0" <?php  if(empty($item['dispatchtype'])) { ?>checked="true"<?php  } ?>   /> 运费模板</label></span>                <select class="form-control tpl-category-parent select2" id="dispatchid" name="dispatchid">                    <option value="0">默认模板</option>                    <?php  if(is_array($dispatch_data)) { foreach($dispatch_data as $dispatch_item) { ?>                    <option value="<?php  echo $dispatch_item['id'];?>" <?php  if($item['dispatchid'] == $dispatch_item['id']) { ?>selected="true"<?php  } ?>><?php  echo $dispatch_item['dispatchname'];?></option>                    <?php  } } ?>                </select>            </div>            <span class="help-block">如果开启了同城配送，系统优先使用同城配送方式，如果未开启同城配送或者超出同城配送范围则使用普通快递方式计算运费</span>            <?php  } else { ?>            <div class='form-control-static'><?php  if(empty($item['dispatchtype'])) { ?>运费模板 <?php  if($item['dispatchid'] == 0) { ?>默认模板<?php  } else { ?><?php  if(is_array($dispatch_data)) { foreach($dispatch_data as $dispatch_item) { ?><?php  if($item['dispatchid'] == $dispatch_item['id']) { ?><?php  echo $dispatch_item['dispatchname'];?><?php  } ?><?php  } } ?><?php  } ?><?php  } else { ?>统一邮费<?php  } ?></div>            <?php  } ?>        </div>    </div>    <?php if( ce('goods' ,$item) ) { ?>    <div class="form-group dispatch_info"  <?php  if(($item['type'] == 2  || $item['isverify']==2 || $item['type'] == 3 || $item['type'] == 5 || $item['type'] == 10)) { ?>style="display: none;"<?php  } ?>>    <label class="col-sm-2 control-label"></label>    <div class="col-sm-6 col-xs-6" style='padding-left:0'>        <div class="input-group">            <span class='input-group-addon' style='border:none'><label class="radio-inline"  style='margin-top:-7px;' ><input type="radio"name="dispatchtype" value="1" <?php  if($item['dispatchtype'] == 1) { ?>checked="true"<?php  } ?>  /> 统一邮费</label></span>            <input type="text" name="dispatchprice" id="dispatchprice" class="form-control" value="<?php  echo $item['dispatchprice'];?>" />            <span class="input-group-addon">元</span>        </div>        <span class="help-block">如果开启了同城配送，同城运费根据统一邮费进行计算</span>    </div></div><?php  } ?><div class="form-group dispatch_info"  <?php  if(($item['type'] == 2  || $item['isverify']==2 || $item['type'] == 3 || $item['type'] == 5 || $item['type'] == 10)) { ?>style="display: none;"<?php  } ?>><label class="col-sm-2 control-label">所在地</label>    <div class="col-sm-6 col-xs-6">        <?php if( ce('goods' ,$item) ) { ?>        <select id="sel-provance" name='province' onchange="selectCity();" class="form-control" style='width:200px;display: inline-block' >            <option value="" selected="true">省/直辖市</option>        </select>        <select id="sel-city" name='city'  onchange="selectcounty(0)" class="form-control" style='width:200px;display: inline-block' >            <option value="" selected="true">请选择</option>        </select>        <select id="sel-area" name='area'  class="form-control" style='width:200px;display: inline-block;display:none;' >            <option value="" selected="true">请选择</option>        </select>        <span class='help-block'>商品所在地，显示在详情页面，如果不选择，则显示商城所在地</span>        <script language='javascript'>            cascdeInit("<?php  echo $new_area?>","0","<?php  echo $item['province'];?>","<?php  echo $item['city'];?>","");        </script>        <?php  } else { ?>        <div class='form-control-static'><?php  echo $item['province'];?> <?php  echo $item['province'];?></div>        <?php  } ?>    </div></div><?php  if(p('cashier')) { ?><div class="form-group">    <label class="col-sm-2 control-label">支持收银台</label>    <div class="col-sm-9 col-xs-12">        <?php if( ce('goods' ,$item) ) { ?>        <label class="checkbox-inline"><input type="checkbox" name="cashier" value="1" <?php  if(!empty($item['cashier'])) { ?>checked="true"<?php  } ?>/> 支持</label>        <?php  } else { ?>        <div class='form-control-static'><?php  if(!empty($item['cashier'])) { ?>支持<?php  } else { ?>不支持<?php  } ?></div>        <?php  } ?>        <div class='help-block'>上架或者不上架,收银台都能查到!</div>    </div></div><?php  } ?><div class="form-group dispatch_info"  <?php  if(($item['type'] == 2  || $item['isverify']==2 || $item['type'] == 3 || $item['type'] == 5 || $item['type'] == 10)) { ?>style="display: none;"<?php  } ?>><label class="col-sm-2 control-label">货到付款</label>    <div class="col-sm-9 col-xs-12">        <?php if( ce('goods' ,$item) ) { ?>        <label class="checkbox-inline">        <input type="checkbox" name="cash" value="2" <?php  if($item['cash'] =='2') { ?>checked="true"<?php  } ?>  /> 支持        </label>        
<?php  } else { ?>        
<div class='form-control-static'>
<?php  if(!empty($item['cash'])) { ?>支持<?php  } else { ?>不支持<?php  } ?></div>        
<?php  } ?>    
</div>
</div>
<div class="form-group">    
<label class="col-sm-2 control-label">发票</label>    
<div class="col-sm-9 col-xs-12">        
<?php if( ce('goods' ,$item) ) { ?>        
<label class="checkbox-inline">
<input type="checkbox" name="invoice" value="1" <?php  if(!empty($item['invoice'])) { ?>checked="true"<?php  } ?>/> 支持</label>        
<?php  } else { ?>        
<div class='form-control-static'><?php  if(!empty($item['invoice'])) { ?>支持<?php  } else { ?>不支持<?php  } ?></div>        
<?php  } ?>    
</div>
</div>
<div class="form-group">    
<label class="col-sm-2 control-label">标签</label>    
<div class="col-sm-9 col-xs-12">        
<?php if( ce('goods' ,$item) ) { ?>        
<label class="checkbox-inline">
<input type="checkbox" name="quality" value="1" <?php  if(!empty($item['quality'])) { ?>checked="true"<?php  } ?>   /> 正品保证</label>        
<label class="checkbox-inline">
<input type="checkbox" name="seven" value="1" 
<?php  if(!empty($item['seven'])) { ?>checked="true"<?php  } ?>   /> 7天无理由退换</label>        
<label class="checkbox-inline"><input type="checkbox" name="repair" value="1" <?php  if(!empty($item['repair'])) { ?>checked="true"<?php  } ?>   /> 保修</label>        
<?php  } else { ?>        
<div class='form-control-static'>            
<?php  if(!empty($item['quality'])) { ?>正品保证;<?php  } ?>            
<?php  if(!empty($item['seven'])) { ?>7天无理由退换;<?php  } ?>            
<?php  if(!empty($item['repair'])) { ?>保修;<?php  } ?>        
</div>        
<?php  } ?>    
</div>
</div>
<div class="form-group">    
<label class="col-sm-2 control-label">自定义标签</label>    
<div class="col-sm-9 col-xs-12">        
<?php if( ce('goods' ,$item) ) { ?>        
<?php  echo tpl_selector('labelname',array('text'=>'labelname','multi'=>1,'type'=>'text',        'placeholder'=>'自定义标签组名称','buttontext'=>'选择标签','items'=>$label,'nokeywords'=>1,        'autosearch'=>1,        'url'=>webUrl('goods/label/query')))?>        
<?php  } else { ?>        
<div class='form-control-static'>            
<?php  if(is_array($labelname)) { foreach($labelname as $label) { ?>            
<?php  echo $label;?>;            
<?php  } } ?>        
</div>        
<?php  } ?>    
</div>
</div>
<div class="form-group">    
<label class="col-sm-2 control-label">上架</label>    
<div class="col-sm-9 col-xs-12">        
<?php if( ce('goods' ,$item) ) { ?>        
<label class="radio-inline"><input type="radio" name="status" value="0" <?php  if($item['status'] == 2) { ?>disabled<?php  } ?> <?php  if(empty($item['status'])) { ?>checked="true"<?php  } ?>/> 否</label>        
<label class="radio-inline"><input type="radio" name="status" value="1" <?php  if($item['status'] == 2) { ?>disabled<?php  } ?> <?php  if($item['status'] == 1) { ?>checked="true"<?php  } ?>   /> 上架</label>        
<label class="radio-inline"><input type="radio" name="status" value="2" <?php  if($item['status'] == 2) { ?>readonly<?php  } ?> <?php  if($item['status'] == 2) { ?>checked="true"<?php  } ?>   /> 赠品上架</label>        
<span class="help-block">赠品上架之后，状态不可更改。</span>        
<?php  } else { ?>        
<div class='form-control-static'><?php  if(empty($item['status'])) { ?>否<?php  } else { ?>是<?php  } ?></div>        
<?php  } ?>    
</div>
</div>
<div class="form-group">    
<label class="col-sm-2 control-label">是否选择上架时间</label>    
<div class="col-sm-9 col-xs-12">        
<?php if( ce('goods' ,$item) ) { ?>        
<label class="radio-inline"><input type="radio" name="isstatustime" value="1" <?php  if($item['isstatustime'] == 1) { ?>checked="true"<?php  } ?>   /> 是</label>        
<label class="radio-inline"><input type="radio" name="isstatustime" value="0" <?php  if(empty($item['isstatustime'])) { ?>checked="true"<?php  } ?>/> 否</label>        
<span class="help-block">商品在选择时间内自动上架，过期自动下架</span>        
<?php  } else { ?>        
<div class='form-control-static'><?php  if(empty($item['isstatustime'])) { ?>否<?php  } else { ?>是<?php  } ?></div>        
<?php  } ?>    
</div>
</div>
<div id="shelves" class="form-group" <?php  if($item['isstatustime']!=1) { ?>style="display:none"<?php  } ?>>
<label class="col-sm-2 control-label">    上架时间</label><?php if( ce('goods' ,$item) ) { ?>
<div class="col-sm-4 col-xs-6">    <?php  echo tpl_form_field_eweishop_daterange('statustime', array('starttime'=>date('Y-m-d H:i', $item['statustimestart']),'endtime'=>date('Y-m-d H:i', $item['statustimeend'])),true);?></div>
<?php  } else { ?>
<div class="col-sm-6 col-xs-6">    
<div class='form-control-static'>        <?php  if($item['status']==1) { ?> <?php  echo date('Y-m-d H:i',$item['statustimestart'])?> - <?php  echo date('Y-m-d H:i',$item['statustimeend'])?> <?php  } ?>    </div></div><?php  } ?></div>
<div class="form-group">    
<label class="col-sm-2 control-label">主商城搜索结果中是否显示该商品</label>    
<div class="col-sm-9 col-xs-12">        <?php if( ce('goods' ,$item) ) { ?>        
<label class="radio-inline">
<input type="radio" name="nosearch" value="1" <?php  if($item['nosearch'] == 1) { ?>checked="true"<?php  } ?>   /> 隐藏</label>        
<label class="radio-inline"><input type="radio" name="nosearch" value="0" <?php  if(empty($item['nosearch'])) { ?>checked="true"<?php  } ?>/> 显示</label>        
<span class="help-block">禁止后,在主商城搜索结果中,将不会显示该商品</span>        
<?php  } else { ?>        
<div class='form-control-static'>
<?php  if(empty($item['nosearch'])) { ?>显示<?php  } else { ?>隐藏<?php  } ?></div>        
<?php  } ?>    
</div>
</div>
<?php  if(p('groups')) { ?>
<div class="form-group" style="display: none;">    
<label class="col-sm-2 control-label">是否支持拼团</label>    
<div class="col-sm-9 col-xs-12">        
<?php if( ce('goods' ,$item) ) { ?>        
<label class="radio-inline">
<input type="radio" name="groupstype" value="1" <?php  if($item['groupstype'] == 1) { ?>checked="true"<?php  } ?>   /> 是</label>        
<label class="radio-inline"><input type="radio" name="groupstype" value="0" <?php  if(empty($item['groupstype'])) { ?>checked="true"<?php  } ?>/> 否</label>        
<span class="help-block"></span>        
<?php  } else { ?>        
<div class='form-control-static'><?php  if(empty($item['groupstype'])) { ?>否<?php  } else { ?>是<?php  } ?></div>        
<?php  } ?>    
</div>
</div>
<?php  } ?>
<div class="entity" <?php  if(($item['type'] == 2 || $item['type'] == 3 || $item['type'] == 10)) { ?>style="display: none;"<?php  } ?>><div class="form-group">    
<label class="col-sm-2 control-label">是否支持退换货</label>    
<div class="col-sm-9 col-xs-12">        
<?php if( ce('goods' ,$item) ) { ?>        
<label class="radio-inline">
<input type="radio" name="cannotrefund" value="0" <?php  if(empty($item['cannotrefund'])) { ?>checked="true"<?php  } ?>   /> 是</label>        
<label class="radio-inline">
<input type="radio" name="cannotrefund" value="1" <?php  if(!empty($item['cannotrefund'])) { ?>checked="true"<?php  } ?>/> 否</label>        
<?php  } else { ?>        
<div class='form-control-static'>
<?php  if(empty($item['cannotrefund'])) { ?>否<?php  } else { ?>是<?php  } ?></div>        <?php  } ?>    
</div></div><div class="form-group">    
<label class="col-sm-2 control-label">确认收货时间</label>    
<div class="col-sm-9 col-xs-12">        
<?php if( ce('goods' ,$item) ) { ?>        
<div class="input-group">            
<span class="input-group-addon">发货后</span>            
<input type="number" name="autoreceive" class="form-control valid" value="<?php  echo $item['autoreceive'];?>">
<span class="input-group-addon">天</span>        
</div>       
<?php  } else { ?>        
<div class='form-control-static'>发货后<?php  echo $item['autoreceive'];?>天自动收货</div>        
<?php  } ?>        
<div class="help-block">0读取系统设置 -1为不自动收货</div>    
</div>
</div>
</div>    
</div>
</div>
<script language="javascript">    
require(['jquery.ui'],function(){        
	$('.multi-img-details').sortable({scroll:'false'});        
	$('.multi-img-details').sortable('option', 'scroll', false);        
/*$('.multi-img-details').sortable({zIndex: 50 });        $('.multi-img-details').sortable('option','zIndex', 50);*/    
})   
 $(function () {        
 	$("input[name=isstatustime]").off('click').on('click',function () {            
 		if($(this).val()==1){                
 			$("#shelves").show()            
 			}else{                
 				$("#shelves").hide();            
 				}        
 				})    
 				})
 </script>
 <?php  if(empty($new_area)) { ?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('shop/selectareas', TEMPLATE_INCLUDEPATH)) : (include template('shop/selectareas', TEMPLATE_INCLUDEPATH));?><?php  } else { ?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('shop/selectareasNew', TEMPLATE_INCLUDEPATH)) : (include template('shop/selectareasNew', TEMPLATE_INCLUDEPATH));?><?php  } ?>