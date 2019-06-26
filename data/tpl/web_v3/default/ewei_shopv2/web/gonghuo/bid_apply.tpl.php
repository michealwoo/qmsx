<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>    
.popover{        
	width:170px;        
	font-size:12px;        
	line-height: 21px;        
	color: #0d0706;    
}    
.popover span{        
	color: #b9b9b9;   
}    
.nickname{        
	display: inline-block;        
	max-width:200px;        
	overflow: hidden;        
	text-overflow:ellipsis;        
	white-space: nowrap;        
	vertical-align: middle;    
}
.tooltip-inner{        
	border:none;    
}
</style>
<div class="page-header">当前位置：<span class="text-primary">供货商列表</span></div>
<div class="page-content">    
<div class="fixed-header">        
<div style="width:25px;"></div>        
<div style="width: 250px;">姓名</div>
<div class="flex1">公司</div> 
<div class="flex1">手机</div>   
<div class="flex1">经营产品</div>            
<div style="width: 125px;text-align: center;">操作</div>    
</div>    
<form action="./index.php" method="get" class="form-horizontal table-search" role="form">
	<input type="hidden" name="c" value="site"/>
	<input type="hidden" name="a" value="entry"/>
	<input type="hidden" name="m" value="ewei_shopv2"/>
	<input type="hidden" name="do" value="web"/>
	<input type="hidden" name="r" value="gonghuo.bid_apply"/>
	<div class="page-toolbar">
		<div class="input-group col-sm-6 pull-right">                
			<input type="text" class="form-control " name="title" value="<?php  echo $_GPC['title'];?>" placeholder="公司名称/手机号">
			<span class="input-group-btn">
				<button class="btn btn-primary" type="submit"> 搜索</button>
				<!-- <button type="submit" name="export" value="1" class="btn btn-success ">导出</button> -->
			</span>
		</div>
	</div>
</form>    
<?php  if(empty($list)) { ?>        
<div class="panel panel-default">            
  <div class="panel-body empty-data">未查询到相关数据</div>        
</div>    
<?php  } else { ?>        
<div class="row">            
<div class="col-md-12">                
	<!-- <div class="page-table-header">
	<input type="checkbox">
	<div class="btn-group">      
	<button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要删除?" data-href="<?php  echo webUrl('gonghuo/delete')?>">
	<i class="icow icow-shanchu1"></i> 批量删除
	</button>
	</div>                
	</div>      -->           
	<table class="table table-responsive">                    
	<thead>                    
	<tr>                        
	<!-- <th style="width:25px;"></th>   -->                      
	<th style="width:250px;">公司名称</th> 
	<th style="">姓名</th>                       
	<th style="">手机</th>
	<th style="">固话</th>
	<th style="">留言内容</th>
	<th style="">留言时间</th>
	<th style="width: 125px;text-align: center;">操作</th>                    
	</tr>                    
	</thead>                    
		<tbody>                        
		<?php  if(is_array($list)) { foreach($list as $row) { ?>                        
			<tr>
				<!--<td style="position: relative; "><input type='checkbox' value="<?php  echo $row['id'];?>" class="checkone"/></td>-->
				<td style="overflow: visible">
					<span><?php  echo $row['company'];?></span>                           
				</td> 
				<td>
					<span><?php  echo $row['name'];?></span>                          
				</td>                           
				<td>
					<span><?php  echo $row['phone'];?></span>                          
				</td> 
				<td>
					<span><?php  echo $row['telephone'];?></span>                          
				</td>
				<td>
					<span><?php  echo $row['msg'];?></span>                          
				</td>
				<td>
					<span><?php  echo $row['createtime'];?></span>                          
				</td> 

				<td style="overflow:visible;text-align: center;">                                
					<div class="btn-group">                                        
						<a class="btn  btn-op btn-operation" href="<?php  echo webUrl('gonghuo/bid_apply_info',array('id' => $row['id']));?>" title="">
						<span data-toggle="tooltip" data-placement="top" title="查看" data-original-title="查看">
							<i class='icow icow-chakan2'></i>                                            
						</span>
						</a>                    
					</div>                            
				</td>
			</tr>
		<?php  } } ?>                    
		</tbody>                    
		<tfoot>                    
			<tr>                        
				<!-- <td><input type="checkbox"></td>       -->                  
				<td colspan="4">                            
					<!-- <div class="btn-group">                                
					<?php if(cv('gonghuo.delete')) { ?>
						<button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要删除?" data-href="<?php  echo webUrl('gonghuo/delete')?>">
						<i class="icow icow-shanchu1"></i> 批量删除                                
						</button>
					<?php  } ?>                                                        
					</div>           -->              
				</td>                        
				<td colspan="3" style="text-align: right"><?php  echo $pager;?>                        
				</td>                    
			</tr>                    
		</tfoot>                
	</table>            
	</div>        
</div>    
<?php  } ?>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>