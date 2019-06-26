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
	 <div class="page-header">当前位置：<span class="text-primary">会员列表</span></div>
	 <div class="page-content">    
	 <div class="fixed-header">        
		 <div style="width:25px;"></div>        
		 <div style="width: 250px;">粉丝</div>        
		 <div class="flex1">等级/分组</div>        
		 <div class="flex1">注册时间</div>
		 <div class="flex1">最近下单</div>
		 <div class="flex1">未下单统计</div>
		 <div class="flex1">积分/余额</div>
		 <div class="flex1">成交</div>        
		 <div style="width: 125px;text-align: center;">操作</div>    
	 </div>   
	 <form action="./index.php" method="get" class="form-horizontal table-search" role="form">       
		   <input type="hidden" name="c" value="site"/>        
		   <input type="hidden" name="a" value="entry"/>        
		   <input type="hidden" name="m" value="ewei_shopv2"/>        
		   <input type="hidden" name="do" value="web"/>        
		   <input type="hidden" name="r" value="member.list"/>        
		   <div class="page-toolbar">           
			   <span class="pull-left">                
			     <?php  echo tpl_daterange('time', array('sm'=>true, 'placeholder'=>'注册时间'),true);?>            
			   </span>
			   <div class="input-group">
				   <span class="input-group-select">
					   <select name='followed' class='form-control'>
						   <option value=''>关注</option>
						   <option value='0' <?php  if($_GPC['followed']=='0') { ?>selected<?php  } ?>>未关注</option>
						   <option value='1' <?php  if($_GPC['followed']=='1') { ?>selected<?php  } ?>>已关注</option>
						   <option value='2' <?php  if($_GPC['followed']=='2') { ?>selected<?php  } ?>>取消关注</option>
					   </select>
				   </span>
				   <span class="input-group-select">                    
					   <select name='level' class='form-control'>                        
					   <option value=''>等级</option>                        
					   <?php  if(is_array($levels)) { foreach($levels as $level) { ?>                            
					   <option value="<?php  echo $level['id'];?>" <?php  if($_GPC['level']==$level['id']) { ?>selected<?php  } ?>><?php  echo $level['levelname'];?></option>
					   <?php  } } ?>                   
					   </select>                
				    </span>                
				    <span class="input-group-select">                    
					    <select name='groupid' class='form-control'>                        
						    <option value=''>分组</option>                        
						    <?php  if(is_array($groups)) { foreach($groups as $group) { ?>                            
						    <option value="<?php  echo $group['id'];?>" <?php  if($_GPC['groupid']==$group['id']) { ?>selected<?php  } ?>><?php  echo $group['groupname'];?></option>
						    <?php  } } ?>                    
					    </select>                
				    </span>                
				    <span class="input-group-select">            
					    <select name='isblack' class='form-control'>                
						    <option value=''>黑名单</option>                
						    <option value='0' <?php  if($_GPC['isblack']=='0') { ?>selected<?php  } ?>>否</option>                
						    <option value='1' <?php  if($_GPC['isblack']=='1') { ?>selected<?php  } ?>>是</option>            
					    </select>                
				    </span>                
				    <input type="text" class="form-control " name="realname" value="<?php  echo $_GPC['realname'];?>" placeholder="可搜索昵称/姓名/手机号/ID">                
				    <span class="input-group-btn">                    
					    <button class="btn  btn-primary" type="submit"> 搜索</button>                    
					    <button type="submit" name="export" value="1" class="btn btn-success ">导出</button>                
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
	    <div class="page-table-header">                    
		    <input type="checkbox">                    
		    <div class="btn-group">                        
		    <?php if(cv('member.list.edit')) { ?>                        
			    <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('member/list/setblack',array('isblack'=>1))?>">                            
			    <i class="icow icow-heimingdan2"></i>设置黑名单                        
			    </button>                        
			    <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('member/list/setblack',array('isblack'=>0))?>">                            
			    <i class="icow icow-yongxinyonghu"></i> 取消黑名单                        
			    </button>                        
		    <?php  } ?>                        
		    <?php if(cv('member.list.delete')) { ?>                        
			    <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要删除?" data-href="<?php  echo webUrl('member/list/delete')?>">                            
			    <i class="icow icow-shanchu1"></i> 批量删除                        
			    </button>                        
			<?php  } ?>                        
		    <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-group'> <i class="icow icow-fenzuqunfa"></i>修改分组</button>                        
		    <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-level'><i class="icow icow-cengjiguanli"></i> 修改等级</button>                    
		    </div>
	    </div>
	    <table class="table table-responsive">
	    <thead>
		    <tr>
		    <th style="width:25px;"></th>
		    <th style="width: 250px;">粉丝</th>
		    <th style="">等级/标签组</th>
		    <th style="">注册时间</th>
		    <th class="flex1">最近下单</th>
		    <th class="flex1">未下单统计</th>
		    <th style="">积分/余额</th>
		    <th style="">成交</th>
		    <?php  if($_GPC['groupid']) { ?>                        
		    <th style="width: 130px">会员组时间</th>
		    <th style="">会员组日志</th>
		    <?php  } ?>
		    <th style="width: 125px;text-align: center;">操作</th>
		    </tr>
	    </thead>
	    <tbody>
	    <?php  if(is_array($list)) { foreach($list as $row) { ?>                        
	    <tr>                            
	    <td style="position: relative; ">                                
	    <input type='checkbox' value="<?php  echo $row['id'];?>" class="checkone"/></td>
	    <td style="overflow: visible">
	    <div rel="pop" style="display: flex"  data-content=" <span>ID: </span><?php  echo $row['id'];?> </br>                                
	    <span>推荐人：</span> <?php  if(empty($row['agentid'])) { ?>
	    <?php  if($row['isagent']==1) { ?>总店
	    <?php  } else { ?>暂无
	    <?php  } ?>
	    <?php  } else { ?>
	    <?php  if(!empty($row['agentavatar'])) { ?>
	    <img src='<?php  echo $row['agentavatar'];?>' style='width:20px;height:20px;padding1px;border:1px solid #ccc' />                               
	    <?php  } ?>                               
	    [<?php  echo $row['agentid'];?>]<?php  if(empty($row['agentnickname'])) { ?>
	    未更新
	    <?php  } else { ?><?php  echo $row['agentnickname'];?><?php  } ?>
	    <?php  } ?><br/>
	    <span>真实姓名：</span> 
	    <?php  if(empty($row['realname'])) { ?>未填写<?php  } else { ?><?php  echo $row['realname'];?><?php  } ?><br/>
	    <span>手机号：</span><?php  if(!empty($row['mobileverify'])) { ?><?php  echo $row['mobile'];?><?php  } else { ?>未绑定<?php  } ?> 
	    <br/>                               
	    <span>是否关注：</span><?php  if(empty($row['followed'])) { ?>
	    <?php  if(empty($row['unfollowtime'])) { ?>
	    <i>未关注</><?php  } else { ?><i>取消关注</i>
	    <?php  } ?>
	    <?php  } else { ?>
	    <i>已关注</i>
	    <?php  } ?> <br/>
	    <span>状态:</span>  
	    <?php  if($row['isblack']==1) { ?>黑名单<?php  } else { ?>正常<?php  } ?> ">                                   
	    <img class="img-40" src="<?php  echo tomedia($row['avatar'])?>" style='border-radius:50%;border:1px solid #efefef;' onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'" />                                   
	    <span style="display: flex;flex-direction: column;justify-content: center;align-items: flex-start;padding-left: 5px">   
		    <span class="nickname">                                           
		    <?php  if(strexists($row['openid'],'sns_wa')) { ?><i class="icow icow-xiaochengxu" style="color: #7586db;vertical-align: middle;" data-toggle="tooltip" data-placement="top" title="" data-original-title="来源: 小程序"></i><?php  } ?>                                           
		    <?php  if(strexists($row['openid'],'sns_qq')||strexists($row['openid'],'sns_wx')||strexists($row['openid'],'wap_user')) { ?><i class="icow icow-app" style="color: #44abf7;vertical-align: top;" data-toggle="tooltip" data-placement="bottom" data-original-title="来源: 全网通(<?php  if(strexists($row['openid'],'wap_user')) { ?>手机号注册<?php  } else { ?>APP<?php  } ?>)"></i><?php  } ?>
		    <?php  if(empty($row['nickname'])) { ?>未更新<?php  } else { ?><?php  echo $row['nickname'];?><?php  } ?>                                       
		    </span>                                      
		     <?php  if($row['isblack']==1) { ?>                                            
		    <span class="text-danger">黑名单<i class="icow icow-heimingdan1"style="color: #db2228;margin-left: 2px;font-size: 13px;"></i></span>                                      
		     <?php  } ?>                                   
	     </span>                                
	     </div>                            
	     </td>
	     <td>
	      <?php  if(empty($row['levelname'])) { ?>普通会员<?php  } else { ?><?php  echo $row['levelname'];?><?php  } ?><?php  if(!empty($row['groupname'])) { ?>/<?php  echo $row['groupname'];?><?php  } ?>
	     </td>                            
	     <td><?php  echo date("Y-m-d",$row['createtime'])?><br/><?php  echo date("H:i:s",$row['createtime'])?></td>
	     <?php  if($row['lastplaceordertime']=='') { ?>
	         <td><span>未下单</span></td>
	     <?php  } else { ?>
		     <td>
		        <?php  echo date("Y-m-d",$row['lastplaceordertime'])?>
		        <br/>
		        <?php  echo date("H:i:s",$row['lastplaceordertime'])?>
		     </td> 
	     <?php  } ?>

	     <td><?php  echo $row['placeorderdays'];?>天</td>
	     <td><span >积分:<span style="color: #5097d3"><?php  echo intval($row['credit1'])?></span> </span>                            
	     <br/><span>余额:<span class="text-warning"><?php  echo price_format($row['credit2'],2)?> </span></span></td>                            <td><span>订单: <?php  echo $row['ordercount'];?></span>                            
	     <br/><span> 金额:<span class="text-warning"><?php  echo floatval($row['ordermoney'])?></span></span></td>                            <?php  if($_GPC['groupid']) { ?>                            
	     <td><?php  echo substr($row['add_time'],0,10)?><br/><?php  echo substr($row['add_time'],10,9)?></td>                            
	     <td title="<?php  echo $row['content'];?>"><?php  echo $row['content'];?></td>
	     <?php  } ?>                            
	     <td style="overflow:visible;text-align: center;">                                
	     <div class="btn-group">                                        
	     <?php if(cv('member.list.edit')) { ?>                                        
	     <a class="btn  btn-op btn-operation" href="<?php  echo webUrl('member/list/detail',array('id' => $row['id']));?>" title="">
	     <span data-toggle="tooltip" data-placement="top" title="" data-original-title="会员详情">
	     <i class='icow icow-bianji2'></i>                                            
	     </span>                                        
	     </a>                                       
         <?php  } ?>                                        
         <?php if(cv('member.list.view')) { ?>                                        
         <!--<a class="btn  btn-op btn-operation" href="<?php  echo webUrl('member/list/view',array('id' => $row['id']));?>" title="">                                            
         <span data-toggle="tooltip" data-placement="top" title="" data-original-title="查看会员">                                                
         <i class='icow icow-chakan3'></i>                                            
         </span>                                        
         </a>-->                                        
         <?php  } ?>                                        
         <?php if(cv('order.list')) { ?>                                            
         <a class="btn  btn-op btn-operation" href="<?php  echo webUrl('order/list', array('searchfield'=>'member','keyword'=>$row['nickname']))?>" title=''>
         <span data-toggle="tooltip" data-placement="top" title="" data-original-title="会员订单">
         <i class='icow icow-dingdan2'></i></span>                                            
         </a>                                        
         <?php  } ?>                                        
         <?php if(cv('finance.recharge.credit1')) { ?>                                       
         <a class="btn btn-op btn-operation" data-toggle="ajaxModal" href="<?php  echo webUrl('finance/recharge', array('type'=>'credit1','id'=>$row['id']))?>" title=''> 
           <span data-toggle="tooltip" data-placement="top" title="" data-original-title="充值">
           <i class='icow icow-31'></i>
         </span>                                       
         </a>                                        
         <?php  } ?>                                        
         <?php if(cv('member.list.delete')) { ?>                                        
         <a class="btn btn-op btn-operation" data-toggle='ajaxRemove' href="<?php  echo webUrl('member/list/delete',array('id' => $row['id']));?>" data-confirm="确定要删除该会员吗？">                                             
           <span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除会员">
           <i class='icow icow-shanchu1'></i>
           </span>                                        
         </a>                                        
         <?php  } ?>                                
         </div>                            
         </td>                        
         </tr>                        
         <?php  } } ?>                    
         </tbody>                    
         <tfoot>                    
	         <tr>                        
	         <td><input type="checkbox"></td>                        
	         <td colspan="3">                            
		         <div class="btn-group">                                
			         <?php if(cv('member.list.edit')) { ?>                                
			         <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('member/list/setblack',array('isblack'=>1))?>">                                    
			         <i class="icow icow-heimingdan2"></i>设置黑名单                                
			         </button>                                
			         <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('member/list/setblack',array('isblack'=>0))?>">                                    
			         <i class="icow icow-yongxinyonghu"></i> 取消黑名单                                
			         </button><?php  } ?>                                
			         <?php if(cv('member.list.delete')) { ?>
			         <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要删除?" data-href="<?php  echo webUrl('member/list/delete')?>">                                    
			         <i class="icow icow-shanchu1"></i> 批量删除                                
			         </button>                                
			         <?php  } ?>
			         <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-group'> 
			         <i class="icow icow-fenzuqunfa"></i>修改分组</button>                                
			         <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-level'>
			         <i class="icow icow-cengjiguanli"></i> 修改等级</button>                            
		         </div>                        
	         </td>                        
		     <td <?php  if($_GPC['groupid']) { ?>colspan="5"<?php  } ?> colspan="3" style="text-align: right">                            <?php  echo $pager;?>                        
		     </td>                    
	         </tr>                    
         </tfoot>                
         </table>            
         </div>        
         </div>    
         <?php  } ?>
         </div>
		 <div id="modal-change"  class="modal fade form-horizontal" tabindex="-1">    
		     <div class="modal-dialog">        
			     <div class="modal-content">            
				     <div class="modal-header">                
					     <button data-dismiss="modal" class="close" type="button">×</button>                
					     <h4 class="modal-title"><?php  if(!empty($group['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>标签组</h4>            
				     </div>            
				     <div class="modal-body">                
					     <div class="form-group batch-level" style="display: none;">                   
						     <label class="col-sm-2 control-label must">会员等级</label>                    
						     <div class="col-sm-9 col-xs-12">                        
							     <select name="batch-level" class="form-control">                            
							     <option value="0"><?php  echo $default_levelname;?></option>                            
							     <?php  if(is_array($levels)) { foreach($levels as $level) { ?>                                
							     <option value="<?php  echo $level['id'];?>"><?php  echo $level['levelname'];?></option>                            
							     <?php  } } ?>                        
							     </select>                    
						     </div>                
					     </div>                
					     <div class="form-group batch-group" style="display: none;">                    
						     <label class="col-sm-2 control-label must">标签组</label>                    
						     <div class="col-sm-9 col-xs-12">                        
							     <select name="batch-group[]" class="form-control select2" placeholder="会员会被加入指定的分组中" multiple style="position:absolute;">                            
							     <?php  if(is_array($groups)) { foreach($groups as $group) { ?>                                
							     <option value="<?php  echo $group['id'];?>"><?php  echo $group['groupname'];?></option>                            
							     <?php  } } ?>                        
							     </select>                    
						     </div>                
					     </div>            
				     </div>            
				     <div class="modal-footer">                
					     <button class="btn btn-primary" type="submit" id="modal-change-btn">提交</button>                
					     <button data-dismiss="modal" class="btn btn-default" type="button">取消</button>            
				     </div>        
			     </div>    
		     </div>
		</div>
<script language="javascript">    
<?php  if($opencommission) { ?>
require(['bootstrap'], function () {
 	$("[rel=pop]").popover({
 		trigger: 'manual',
 		placement: 'right',
 		title: $(this).data('title'),
 		html: 'true',
 		content: $(this).data('content'),            
 		animation: false        
		}).on("mouseenter", function () {
			var _this = this;            
			$(this).popover("show");            
			$(this).siblings(".popover").on("mouseleave", function () {                
				$(_this).popover('hide');            
			});
		}).on("mouseleave", function () {            
		var _this = this;            
		setTimeout(function () {                
			if (!$(".popover:hover").length) {                    
				$(_this).popover("hide")               
				}           
		}, 100);        
	});    
});
<?php  } ?>

$("[data-toggle='batch-group'], [data-toggle='batch-level']").click(function () {
	var toggle = $(this).data('toggle');        
	$("#modal-change .modal-title").text(toggle=='batch-group'?"批量修改标签组":"批量修改会员等级");        
	$("#modal-change").find("."+toggle).show().siblings().hide();        
	$("#modal-change-btn").attr('data-toggle', toggle=='batch-group'?'group':'level');        
	$("#modal-change").modal();    
});
$("#modal-change-btn").click(function () {
	var _this = $(this);        
	if(_this.attr('stop')){            
		return;        
	}        
	var toggle = $(this).data('toggle');        
	var ids = [];        
	$(".checkone").each(function () {           
	var checked = $(this).is(":checked");            
	var id = $(this).val();            
	if(checked && id){                
		ids.push(id);            
	}        
	});
	if(ids.length<1){            
		tip.msgbox.suc("请选择要批量操作的会员");            
		return;        
	}        
	var option = $("#modal-change .batch-"+toggle+" option:selected");        
	level = '';        
	if (toggle=='group'){            
		for(i=0;i<option.length;i++){                
			if (level == ''){                   
			level += $(option[i]).val();                
			}else{                    
				level += ','+$(option[i]).val();                
			}           
		}        
	}else{            
		var level = option.val();        
	}        
	var levelname = option.text();       
	tip.confirm("确定要将选中会员移动到 "+levelname+" 吗？", function () {            
		_this.attr('stop', 1).text("操作中...");            
		$.post(biz.url('member/list/changelevel'),{                
			level: level,                
			ids: ids,                
			toggle: toggle            
		}, function (ret) {                
			$("#modal-change").modal('hide');                
			if(ret.status==1){                    
				tip.msgbox.suc("操作成功");                    
				setTimeout(function () {                        
					location.reload();                    
				},1000);                
			}else{                    
			    tip.msgbox.err(ret.result.message);                
			    }            
		}, 'json')        
	});    
});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>