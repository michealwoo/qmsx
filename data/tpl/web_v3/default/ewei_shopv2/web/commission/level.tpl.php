<?php defined('IN_IA') or exit('Access Denied');?> <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
 <div class="page-header">
     当前位置：<span class="text-primary">分销商等级</span>
</div>
 <div class="page-content">
     <div class="page-toolbar">
         <span class=''>

		 <?php if(cv('commission.level.add')) { ?>
                            <a class='btn btn-primary btn-sm' data-toggle='ajaxModal' href="<?php  echo webUrl('commission/level/add')?>"><i class="fa fa-plus"></i> 添加新等级</a>
		 <?php  } ?>

	</span>
     </div>
   <div class='alert alert-primary'>
    提示: 没有设置等级的分销商将按默认设置计算提成。商品指定的佣金金额的优先级仍是最高的，也就是说只要商品指定了佣金金额就按商品的佣金金额来计算，不受等级影响
</div>
            <table class="table table-responsive table-hover">
                <thead>
                    <tr>
                        <th style='width:160px;'>等级名称</th>
                        <?php  if($set['level']>=1) { ?><th>一级佣金比例</th><?php  } ?>
                        <?php  if($set['level']>=2) { ?><th>二级佣金比例</th><?php  } ?>
                        <?php  if($set['level']>=3) { ?><th>三级佣金比例</th><?php  } ?>
                        <th>升级条件</th>
                        <th style="width: 65px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <tr <?php  if($row['id']=='default') { ?>style='background:#f2f2f2'<?php  } ?>>
                        <td><?php  echo $row['levelname'];?><?php  if($row['id']=='default') { ?>【默认等级】<?php  } ?></td>
                        <?php  if($set['level']>=1) { ?><td><?php  echo number_format((float)$row['commission1'],2)?>%</td><?php  } ?>
                         <?php  if($set['level']>=2) { ?><td><?php  echo number_format((float)$row['commission2'],2)?>%</td><?php  } ?>
                          <?php  if($set['level']>=3) { ?><td><?php  echo number_format((float)$row['commission3'],2)?>%</td><?php  } ?>
                          <td>	<?php  if($row['id']!='default') { ?>
						<?php  if($leveltype==0) { ?><?php  if($row['ordermoney']>0) { ?>分销订单金额满 <?php  echo $row['ordermoney'];?> 元 <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==1) { ?><?php  if($row['ordermoney']>0) { ?>一级分销订单金额满 <?php  echo $row['ordermoney'];?> 元 <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==2) { ?><?php  if($row['ordercount']>0) { ?>分销订单数量满 <?php  echo $row['ordercount'];?> 个 <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==3) { ?><?php  if($row['ordercount']>0) { ?>一级分销订单数量满 <?php  echo $row['ordercount'];?> 个 <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==4) { ?><?php  if($row['ordermoney']>0) { ?>自购订单金额满 <?php  echo $row['ordermoney'];?> 元 <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==5) { ?><?php  if($row['ordercount']>0) { ?>自购订单数量满 <?php  echo $row['ordercount'];?> 个 <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						
						<?php  if($leveltype==6) { ?><?php  if($row['downcount']>0) { ?>下级总人数满 <?php  echo $row['downcount'];?> 个（分销商+非分销商） <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==7) { ?><?php  if($row['downcount']>0) { ?>一级下级人数满 <?php  echo $row['downcount'];?> 个（分销商+非分销商） <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						
						<?php  if($leveltype==8) { ?><?php  if($row['downcount']>0) { ?>团队总人数满 <?php  echo $row['downcount'];?> 个（分销商） <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==9) { ?><?php  if($row['downcount']>0) { ?>一级团队人数满 <?php  echo $row['downcount'];?> 个（分销商） <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						
						 
						<?php  if($leveltype==10) { ?><?php  if($row['commissionmoney']>0) { ?>已提现佣金总金额满 <?php  echo $row['commissionmoney'];?> 元<?php  } else { ?>不自动升级<?php  } ?><?php  } ?>	 
					<?php  } else { ?>
					默认等级
					<?php  } ?>
                          </td>
                        <td>
							<?php if(cv('commission.level.edit')) { ?>
                            <a class='btn btn-default btn-sm btn-op btn-operation' data-toggle='ajaxModal'  href="<?php  echo webUrl('commission/level/edit', array('id' => $row['id']))?>">
                                <span data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php if(cv('commission.level.edit')) { ?>编辑<?php  } else { ?>查看<?php  } ?>">
                                    <?php if(cv('commission.level.edit')) { ?>
                                    <i class='icow icow-bianji2'></i>
                                    <?php  } else { ?>
                                    <i class='icow icow-chakan-copy'></i>
                                    <?php  } ?>
                               </span>
                            </a>
                            <?php  } ?> 
                            <?php  if($row['id']!='default') { ?>
							 <?php if(cv('commission.level.delete')) { ?>
								<a class='btn btn-default btn-sm btn-op btn-operation' data-toggle='ajaxRemove'  href="<?php  echo webUrl('commission/level/delete', array('id' => $row['id']))?>" data-confirm="确认删除此等级吗？">
                                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">
                                    <i class='icow icow-shanchu1'></i>
                               </span>
                                </a>
                        </td>
						<?php  } ?>
						<?php  } ?>

                    </tr>
                    <?php  } } ?>
                
                </tbody>
            </table>
 </div>
 <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>


<!--青岛易联互动网络科技有限公司-->