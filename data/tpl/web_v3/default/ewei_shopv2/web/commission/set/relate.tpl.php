<?php defined('IN_IA') or exit('Access Denied');?>    <div class="form-group-title" style="margin-top: -25px">上下线关系设置</div>
           <div class="form-group">
                <label class="col-lg control-label">成为下线条件</label>
                <div class="col-sm-9 col-xs-12">
                	<?php if(cv('commission.set.edit')) { ?>
	                    <label class="radio-inline"><input type="radio"  name="data[become_child]" value="0" <?php  if($data['become_child'] ==0) { ?> checked="checked"<?php  } ?> /> 首次点击分享链接</label>
	                    <label class="radio-inline"><input type="radio"  name="data[become_child]" value="1" <?php  if($data['become_child'] ==1) { ?> checked="checked"<?php  } ?> /> 首次下单</label>
	                    <label class="radio-inline"><input type="radio"  name="data[become_child]" value="2" <?php  if($data['become_child'] ==2) { ?> checked="checked"<?php  } ?> /> 首次付款</label>
	                    <span class='help-block'>首次点击分享链接： 可以自由设置分销商条件</span>
	                    <span class='help-block'>首次下单/首次付款： 无条件不可用</span>
                    <?php  } else { ?>
                    	<?php  if($data['become_child'] ==0) { ?>首次点击分享链接<?php  } ?>
                    	<?php  if($data['become_child'] ==1) { ?>首次下单<?php  } ?>
                    	<?php  if($data['become_child'] ==2) { ?>首次下单<?php  } ?>
                    <?php  } ?>
                </div>
               </div>

            <div class="form-group">
                <label class="col-lg control-label">我的邀请码</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.set.edit')) { ?>
                        <label class="radio-inline"><input type="radio"  name="data[hideicode]" value="0" <?php  if(empty($data['hideicode'])) { ?>checked="checked"<?php  } ?> /> 开启</label>
                        <label class="radio-inline"><input type="radio"  name="data[hideicode]" value="1" <?php  if(!empty($data['hideicode'])) { ?>checked="checked"<?php  } ?> /> 关闭</label>
                    <?php  } else { ?>
                        <?php  if(empty($data['hideicode'])) { ?>开启<?php  } else { ?>关闭<?php  } ?>
                    <?php  } ?>
                </div>
            </div>
	    
    <div class="form-group-title">分销资格设置</div>
		
            <div class="form-group">
                <label class="col-lg control-label">成为分销商条件</label>
                <div class="col-sm-9 col-xs-12">
                	<?php if(cv('commission.set.edit')) { ?>
	                	<label class="radio-inline"><input type="radio"  name="data[become]" value="0" <?php  if($data['become'] ==0) { ?> checked="checked"<?php  } ?> data-needcheck="1" onclick="showBecome(this)" /> 无条件</label>
	                    <label class="radio-inline"><input type="radio"  name="data[become]" value="1" <?php  if($data['become'] ==1) { ?> checked="checked"<?php  } ?> data-needcheck="1" onclick="showBecome(this)"/> 申请</label>
	                    <label class="radio-inline"><input type="radio"  name="data[become]" value="2" <?php  if($data['become'] ==2) { ?> checked="checked"<?php  } ?> data-needcheck="1" onclick="showBecome(this)"/> 消费次数</label>
						<label class="radio-inline"><input type="radio"  name="data[become]" value="3" <?php  if($data['become'] ==3) { ?> checked="checked"<?php  } ?> data-needcheck="1" onclick="showBecome(this)"/> 消费金额</label>
						<label class="radio-inline"><input type="radio"  name="data[become]" value="4" <?php  if($data['become'] ==4) { ?> checked="checked"<?php  } ?> data-needcheck="1" onclick="showBecome(this)"/> 购买商品</label>
					<?php  } else { ?>
						<?php  if($data['become'] ==0) { ?>无条件<?php  } ?>
						<?php  if($data['become'] ==1) { ?>申请<?php  } ?>
						<?php  if($data['become'] ==2) { ?>消费次数<?php  } ?>
						<?php  if($data['become'] ==3) { ?>消费金额<?php  } ?>
						<?php  if($data['become'] ==4) { ?>购买商品<?php  } ?>
					<?php  } ?>
                </div> 
            </div>
           <div class="form-group become become2"  <?php  if($data['become']!='2' ) { ?>style="display:none"<?php  } ?>>
                    <label class="col-lg control-label "></label>
                    <div class="col-sm-9 col-xs-12">
                    	<?php if(cv('commission.set.edit')) { ?>
                           <div class='input-group' >
	                            <div class='input-group-addon'>消费达到</div>
	                            <input type='text' class='form-control' name='data[become_ordercount]' value="<?php  echo $data['become_ordercount'];?>" />
	                            <div class='input-group-addon'>次</div>
                        	</div>
                        <?php  } else { ?>
                        	消费达到 <?php  echo $data['become_ordercount'];?>次
                        <?php  } ?>
                    </div>
           </div>
          <div class="form-group  become become3" <?php  if($data['become']!='3' ) { ?>style="display:none"<?php  } ?>>
                    <label class="col-lg control-label" ></label>
                    <div class="col-sm-9 col-xs-12">
                    	<?php if(cv('commission.set.edit')) { ?>
                           <div class='input-group' >
	                            <div class='input-group-addon'>消费达到</div>
	                            <input type='text' class='form-control' name='data[become_moneycount]' value="<?php  echo $data['become_moneycount'];?>" />
	                            <div class='input-group-addon'>元</div>
	                        </div>
	                    <?php  } else { ?>
	                    	消费达到 <?php  echo $data['become_moneycount'];?>元
	                    <?php  } ?>
                    </div>
           </div>
         <div class="form-group  become become4" <?php  if($data['become']!='4' ) { ?>style="display:none"<?php  } ?>>
                    <label class="col-lg control-label" ></label>
                    <div class="col-sm-9 col-xs-12">
                    	<?php if(cv('commission.set.edit')) { ?>
                              <?php  echo tpl_selector('become_goodsid',array('url'=>webUrl('goods/query'), 'items'=>$goods,'buttontext'=>'选择商品','placeholder'=>'请输入商品标题','preview'=>false))?>
                        <?php  } else { ?>
                        	<?php  if(!empty($goods)) { ?>
                        		<a href="<?php  echo webUrl('goods/edit',array('id'=>$goods['id']))?>" target="_blank"><?php  echo $goods['title'];?>(ID: <?php  echo $goods['id'];?>)</a>
                        	<?php  } else { ?>
                        		未选择商品
                        	<?php  } ?>
                        <?php  } ?>
                    </div>
           </div>
   
    
          <div class="form-group becomecon">
                <label class="col-lg control-label"></label>
                <div class="col-sm-5 becomecheck">
                	<?php if(cv('commission.set.edit')) { ?>
                    <label class="radio-inline"><input type="radio"  name="data[become_check]" value="0" <?php  if($data['become_check'] ==0) { ?> checked="checked"<?php  } ?> /> 需要</label>
                    <label class="radio-inline"><input type="radio"  name="data[become_check]" value="1" <?php  if($data['become_check'] ==1) { ?> checked="checked"<?php  } ?> /> 不需要</label>
                    <span class="help-block">是否需要审核</span>
                    <?php  } else { ?>
                    	<?php  if($data['become_check']==0) { ?>需要审核<?php  } else { ?>不需要审核<?php  } ?>
                    <?php  } ?>
                </div>
                <div class="col-sm-4 becomeconsume"  <?php  if(empty($data['become']) || $data['become']=='1') { ?>style="display:none"<?php  } ?>>
                	<?php if(cv('commission.set.edit')) { ?>
                    <label class="radio-inline"><input type="radio"  name="data[become_order]" value="0" <?php  if($data['become_order'] ==0) { ?> checked="checked"<?php  } ?> /> 付款后</label>
                    <label class="radio-inline"><input type="radio"  name="data[become_order]" value="1" <?php  if($data['become_order'] ==1) { ?> checked="checked"<?php  } ?> /> 完成后</label>
                    <span class="help-block">消费条件统计的方式</span>
                    <?php  } else { ?>
                    	消费条件统计的方式: <?php  if($data['become_order'] ==0) { ?>付款后<?php  } else { ?>完成后<?php  } ?>
                    <?php  } ?>
                </div>
           </div>

            <div class="form-group protocol-group" <?php  if($data['become'] !=1) { ?>style="display: none;"<?php  } ?>>
            <label class="col-lg control-label">显示申请协议</label>
            <div class="col-sm-8">
                <?php if(cv('commission.set.edit')) { ?>
                <label class="radio-inline"><input type="radio"  name="data[open_protocol]" value="1" <?php  if($data['open_protocol'] ==1) { ?> checked="checked"<?php  } ?> /> 显示</label>
                <label class="radio-inline"><input type="radio"  name="data[open_protocol]" value="0" <?php  if($data['open_protocol'] ==0) { ?> checked="checked"<?php  } ?> /> 隐藏</label>
                <?php  } else { ?>
                <?php  if($data['open_protocol'] ==0) { ?>隐藏<?php  } else { ?>显示<?php  } ?>
                <?php  } ?>
            </div>
            </div>

           <div class="form-group">
                <label class="col-lg control-label">分销商必须完善资料</label>
                <div class="col-sm-9 col-xs-12">
                	<?php if(cv('commission.set.edit')) { ?>
                    <label class="radio-inline"><input type="radio"  name="data[become_reg]" value="0" <?php  if($data['become_reg'] ==0) { ?> checked="checked"<?php  } ?> /> 需要</label>
                    <label class="radio-inline"><input type="radio"  name="data[become_reg]" value="1" <?php  if($data['become_reg'] ==1) { ?> checked="checked"<?php  } ?> /> 不需要</label>
                    <span class="help-block">分销商在分销或提现时是否必须完善资料</span>
                    <?php  } else { ?>
                    	分销商在分销或提现时是否必须完善资料: <?php  if($data['become_reg'] ==0) { ?>需要<?php  } else { ?>不需要<?php  } ?>
                    <?php  } ?>
                </div>
           </div>

            <div class="form-group">
                <label class="col-lg control-label">非分销商链接</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('commission.set.edit')) { ?>
                    <input type="text" name="data[no_commission_url]" class="form-control" value="<?php  echo $data['no_commission_url'];?>">
                    <?php  } else { ?>
                    <?php  echo $data['no_commission_url'];?>
                    <?php  } ?>
                    <span class="help-block">自定义非分销商点击分销中心链接 ; 如果不填写 则走默认;<span class="text text-danger">（小程序暂未支持）</span></span>
                </div>
            </div>
        