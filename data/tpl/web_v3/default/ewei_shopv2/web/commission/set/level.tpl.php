<?php defined('IN_IA') or exit('Access Denied');?>  <div class="form-group">
                <label class="col-lg control-label">分销等级说明链接</label>
                <div class="col-sm-9 col-xs-12">
                	<?php if(cv('commission.set.edit')) { ?>
                    <input type="text" name="data[levelurl]" class="form-control" value="<?php  echo $data['levelurl'];?>"  />
                    <span class="help-block">分销等级说明链接</span>
                  <?php  } else { ?>
                  	<?php  echo $data['levelurl'];?>
                  <?php  } ?>
                </div>
            </div>  
<div class="form-group">
                <label class="col-lg control-label">分销商等级升级依据</label>
                <div class="col-sm-9 col-xs-12">
              			<?php if(cv('commission.set.edit')) { ?>
                       <div style="background: #f5f7f9;width: 520px;padding: 10px;">
                           <label class="radio radio-inline" style="width:240px">
                               <input type="radio" name="data[leveltype]" value="0" <?php  if(empty($data['leveltype'])) { ?>checked<?php  } ?>/> 分销订单总额(完成的订单)
                           </label>
                           <label class="radio radio-inline" style="width:240px">
                               <input type="radio" name="data[leveltype]" value="1" <?php  if($data['leveltype']==1) { ?>checked<?php  } ?>/> 一级分销订单金额(完成的订单)
                           </label>

                           <br/>

                           <label class="radio radio-inline" style="width:240px">
                               <input type="radio" name="data[leveltype]" value="2" <?php  if($data['leveltype']==2) { ?>checked<?php  } ?>/> 分销订单总数(完成的订单)
                           </label>
                           <label class="radio radio-inline" style="width:240px">
                               <input type="radio" name="data[leveltype]" value="3" <?php  if($data['leveltype']==3) { ?>checked<?php  } ?>/> 一级分销订单总数(完成的订单)
                           </label>
                       </div>
                        

												
                    <div style="background: #f5f7f9;width: 520px;padding: 10px;margin-top: 10px">
                        <label class="radio radio-inline" style="width:240px">
                            <input type="radio" name="data[leveltype]" value="4" <?php  if($data['leveltype']==4) { ?>checked<?php  } ?>/> 自购订单金额(完成的订单)
                        </label>
                        <label class="radio radio-inline" style="width:240px">
                            <input type="radio" name="data[leveltype]" value="5" <?php  if($data['leveltype']==5) { ?>checked<?php  } ?>/> 自购订单数量(完成的订单)
                        </label>
                    </div>

												
                    <div style="background: #f5f7f9;width: 520px;padding: 10px;margin-top: 10px">
                        <label class="radio radio-inline" style="width:240px">
                            <input type="radio" name="data[leveltype]" value="6" <?php  if($data['leveltype']==6) { ?>checked<?php  } ?>/> 下线总人数（分销商+非分销商）
                        </label>
                        <label class="radio radio-inline" style="width:240px">
                            <input type="radio" name="data[leveltype]" value="7" <?php  if($data['leveltype']==7) { ?>checked<?php  } ?>/> 一级下线人数（分销商+非分销商）
                        </label>
                        <br />
                        <label class="radio radio-inline" style="width:240px">
                            <input type="radio" name="data[leveltype]" value="8" <?php  if($data['leveltype']==8) { ?>checked<?php  } ?>/> 下级分销商总人数
                        </label>
                        <label class="radio radio-inline" style="width:240px">
                            <input type="radio" name="data[leveltype]" value="9" <?php  if($data['leveltype']==9) { ?>checked<?php  } ?>/> 一级分销商人数
                        </label>
                    </div>

                    <div style="background: #f5f7f9;width: 520px;padding: 10px;margin-top: 10px">
                        <label class="radio radio-inline" style="width:240px">
                            <input type="radio" name="data[leveltype]" value="10" <?php  if($data['leveltype']==10) { ?>checked<?php  } ?>/> 已提现佣金总金额
                        </label>
                    </div>
                        <span class="help-block">默认为分销订单总金额</span>
                      <?php  } else { ?>
                      		<?php  if(empty($data['leveltype'])) { ?><?php  } ?>
                      		<?php  if($data['leveltype']==1) { ?>分销订单总额(完成的订单)<?php  } ?>
                      		<?php  if($data['leveltype']==2) { ?>一级分销订单金额(完成的订单)<?php  } ?>
                      		<?php  if($data['leveltype']==3) { ?>一级分销订单总数(完成的订单)<?php  } ?>
                      		<?php  if($data['leveltype']==4) { ?>自购订单金额(完成的订单)<?php  } ?>
                      		<?php  if($data['leveltype']==5) { ?>自购订单数量(完成的订单)<?php  } ?>
                      		<?php  if($data['leveltype']==6) { ?>下线总人数（分销商+非分销商）<?php  } ?>
                      		<?php  if($data['leveltype']==7) { ?>一级下线人数（分销商+非分销商）<?php  } ?>
                      		<?php  if($data['leveltype']==8) { ?>下级分销商总人数<?php  } ?>
                      		<?php  if($data['leveltype']==9) { ?>一级分销商人数<?php  } ?>
                      		<?php  if($data['leveltype']==10) { ?>已提现佣金总金额<?php  } ?>
                      <?php  } ?>
                </div>
            </div>
<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+4-->