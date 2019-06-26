<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">当前位置：<span class="text-primary">商品组管理</span></div>
<div class="page-content">
    <div class="alert alert-primary">商品组现主要用于店铺装修调用</div>
    <form action method="post">
        <div class="page-toolbar">
            <div class="col-sm-4">
                <?php if(cv('goods.group.add')) { ?>
                <a class="btn btn-primary btn-sm" href="<?php  echo webUrl('goods/group/add')?>"><i class="fa fa-plus"></i> 添加新组</a>
                <?php  } ?>
            </div>
            <div class="pull-right col-sm-6">
                <div class="input-group" style="width:100%;">
                    <input type="text" class="input-sm form-control" name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入商品组名称进行搜索">
                    <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit"> 搜索</button>
                        </span>
                </div>
            </div>
        </div>

        <?php  if(empty($list)) { ?>
        <div class="panel panel-default">
            <div class="panel-body empty-data">未查询到<?php  if(!empty($_GPC['keyword'])) { ?>"<?php  echo $_GPC['keyword'];?>"<?php  } ?>相关商品组!</div>
        </div>
        <?php  } else { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="page-table-header">
                    <input type='checkbox' />
                    <div class="btn-group">
                        <?php if(cv('goods.group.edit')) { ?>
                        <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('goods/group/enabled',array('enabled'=>1))?>">
                            <i class='icow icow-qiyong'></i> 启用</button>
                        <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch'  data-href="<?php  echo webUrl('goods/group/enabled',array('enabled'=>0))?>">
                            <i class='icow icow-jinyong'></i> 禁用</button>

                        <?php  } ?>
                        <?php if(cv('goods.group.delete')) { ?>
                        <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle="batch-remove" data-confirm="确认要删除?" data-href="<?php  echo webUrl('goods/group/delete')?>" disabled="disabled">
                            <i class="icow icow-shanchu1"></i>删除
                        </button>
                        <?php  } ?>
                    </div>
                </div>
                <table class="table table-responsive">
                    <thead>
            <tr>
                <?php if(cv('goods.group.delete|goods.group.edit')) { ?>
                <th style="width:25px;"></th>
                <?php  } ?>
                <th>商品组名称</th>
                <th></th>
                <th style="width: 70px;">状态</th>
                <th style="width: 65px">操作</th>
            </tr>
            </thead>
                <tbody>
                <?php  if(is_array($list)) { foreach($list as $item) { ?>
                <tr>
                    <?php if(cv('goods.group.delete|goods.group.edit')) { ?>
                    <td>
                        <input type="checkbox" value="<?php  echo $item['id'];?>">
                    </td>
                    <?php  } ?>
                    <td><?php  echo $item['name'];?></td>
                    <td></td>
                    <td>
                        <span class='label <?php  if($item['enabled']==1) { ?>label-primary<?php  } else { ?>label-default<?php  } ?>'
                        <?php if(cv('goods.group.edit')) { ?>
                        data-toggle='ajaxSwitch'
                        data-switch-value='<?php  echo $item['enabled'];?>'
                        data-switch-value0='0|禁用|label label-default|<?php  echo webUrl('goods/group/enabled',array('enabled'=>1,'id'=>$item['id']))?>'
                        data-switch-value1='1|启用|label label-primary|<?php  echo webUrl('goods/group/enabled',array('enabled'=>0,'id'=>$item['id']))?>'
                        <?php  } ?>>
                        <?php  if($item['enabled']==1) { ?>启用<?php  } else { ?>禁用<?php  } ?></span>
                    </td>
                    <td>
                        <?php if(cv('goods.group.view|goods.group.edit')) { ?>
                        <a class="btn btn-default btn-sm btn-operation btn-op" href="<?php  echo webUrl('goods/group/edit', array('id'=>$item['id']))?>">
                             <span data-toggle="tooltip" data-placement="top" title="" data-original-title=" <?php if(cv('goods.group.edit')) { ?>修改<?php  } else { ?>查看<?php  } ?>">
                                 <i class="icow icow-bianji2"></i>
                            </span>
                        </a>

                        <?php  } ?>
                        <?php if(cv('goods.group.delete')) { ?>
                        <a class="btn btn-default btn-sm btn-operation btn-op" data-toggle="ajaxRemove" href="<?php  echo webUrl('goods/group/delete', array('id'=>$item['id']))?>" data-confirm="确定要删除该分组吗？">
                           <span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">
                               <i class="icow icow-shanchu1"></i>
                            </span>
                            </a>
                        <?php  } ?>
                    </td>
                </tr>
                <?php  } } ?>
                </tbody>
                    <tfoot>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>
                            <div class="btn-group">
                                <?php if(cv('goods.group.edit')) { ?>
                                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('goods/group/enabled',array('enabled'=>1))?>">
                                    <i class='icow icow-qiyong'></i> 启用</button>
                                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch'  data-href="<?php  echo webUrl('goods/group/enabled',array('enabled'=>0))?>">
                                    <i class='icow icow-jinyong'></i> 禁用</button>
                                <?php  } ?>
                                <?php if(cv('goods.group.delete')) { ?>
                                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle="batch-remove" data-confirm="确认要删除?" data-href="<?php  echo webUrl('goods/group/delete')?>" disabled="disabled">
                                       <i class="icow icow-shanchu1"></i>删除
                                </button>
                                <?php  } ?>
                            </div>
                        </td>
                        <td colspan="3" style="text-align: right">
                            <?php  echo $pager;?>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <?php  } ?>

    </form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--OTEzNzAyMDIzNTAzMjQyOTE0-->