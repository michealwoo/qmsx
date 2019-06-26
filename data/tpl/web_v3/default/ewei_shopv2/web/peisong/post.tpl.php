<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">当前位置：<span class="text-primary">配送员详情</span></div>

<div class="page-content">

<form method='post' class='form-horizontal form-validate' action=""> 

 <input type="hidden" name="id" value="<?php  echo $info['id'];?>" />

	<div class="tabs-container">

		<div class="tabs">

			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#tab-basic" aria-expanded="true"> 基本信息</a></li>
			</ul>

			<div class="tab-content">
				<div id="tab-basic" class="tab-pane active">
			     	<div class="form-group">
					    <label class="col-lg control-label">姓名</label>
					    <div class="col-sm-9 col-xs-12">
					        <input type="text" class="form-control" value="<?php  echo $info['name'];?>" name="name" required/>
					    </div>
					</div>
					<div class="form-group">
	                    <label class="col-lg control-label">关联账号:</label>
	                    <div class="col-sm-9 col-xs-12">
	                        <select class="form-control" name="mid" id="mid">
	                              <option value="0">请选择</option>
	                            <?php  if(is_array($members)) { foreach($members as $value) { ?>
	                              <option value="<?php  echo $value['id'];?>" 
	                                  <?php  if($info['mid']==$value['id']) { ?>selected='selected'<?php  } ?>><?php  echo $value['nickname'];?>
	                              </option>
	                            <?php  } } ?>
	                        </select>
	                    </div>
	                </div>
			        <div class="form-group">
					    <label class="col-lg control-label">手机号码</label>
					    <div class="col-sm-9 col-xs-12">
					        <input type="text" class="form-control" value="<?php  echo $info['phone'];?>" name="phone" required/>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-lg control-label">配送范围</label>
					    <div class="col-sm-9 col-xs-12">
					        <textarea name="delivery_range" class='form-control' rows="5" name="delivery_range" required><?php  echo $info['delivery_range'];?></textarea>
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-lg control-label">工作状态</label>
					    <div class="col-sm-9 col-xs-12">
					        <label class="radio-inline"><input type="radio" name="workstate" value="1" <?php  if($info['workstate']==1) { ?>checked<?php  } ?>>工作中</label>
					        <label class="radio-inline" ><input type="radio" name="workstate" value="0" <?php  if($info['workstate']==0) { ?>checked<?php  } ?>>空闲中</label>
					        <span class="help-block">设置工作状态</span>
					    </div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group"></div>	

    <div class="form-group">
		<label class="col-lg control-label"></label>
		<div class="col-sm-9 col-xs-12">
			<input type="submit"  value="保存" class="btn btn-primary"/>
			<input type="button" class="btn btn-default" name="submit" onclick="history.back();" value="返回列表" />
		</div>
	</div>
</form>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--913702023503242914-->