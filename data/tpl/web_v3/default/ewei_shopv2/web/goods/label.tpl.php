<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">

    当前位置：<span class="text-primary">标签组管理</span>

</div>

<div class="page-content">

    <form action="./index.php" method="get" class="form-horizontal form-search" role="form">

        <input type="hidden" name="c" value="site" />

        <input type="hidden" name="a" value="entry" />

        <input type="hidden" name="m" value="ewei_shopv2" />

        <input type="hidden" name="do" value="web" />

        <input type="hidden" name="r"  value="goods.label" />

        <div class="page-toolbar">

                <div class="col-sm-6">

                    <span class="">

                        <?php if(cv('goods.label.add')) { ?>

                            <a href="<?php  echo webUrl('goods/label/add')?>" class="btn btn-primary"><i class="fa fa-plus"></i> 添加新标签组</a>

                        <?php  } ?>

                        <a class="btn btn-default" href="<?php  echo webUrl('goods/label/style')?>">设置样式</a>

                    </span>

                </div>

                <div class="col-sm-6">

                    <div class="input-group">

                        <span class="input-group-select">

                            <select name="enabled" class='form-control'>

                                <option value="" <?php  if($_GPC['enabled'] == '') { ?> selected<?php  } ?>>状态</option>

                                <option value="1" <?php  if($_GPC['enabled']== '1') { ?> selected<?php  } ?>>启用</option>

                                <option value="0" <?php  if($_GPC['enabled'] == '0') { ?> selected<?php  } ?>>禁用</option>

                            </select>

                        </span>

                            <input type="text" class="input-sm form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词">

                        <span class="input-group-btn">

                            <button class="btn btn-primary" type="submit"> 搜索</button>

                        </span>

                </div>

            </div>

        </div>

    </form>

    <form action="" method="post" >

        <?php  if(count($label)>0) { ?>
        
        <div class="row">

            <div class="col-md-12">

                <div class="page-table-header">

                    <input type='checkbox' />

                    <div class="btn-group">

                        <?php if(cv('goods.label.edit')) { ?>

                        <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('goods/label/status',array('status'=>1))?>">

                            <i class='icow icow-qiyong'></i>启用

                        </button>

                        <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch'  data-href="<?php  echo webUrl('goods/label/status',array('status'=>0))?>">

                            <i class='icow icow-jinyong'></i> 禁用

                        </button>

                        <?php  } ?>

                        <?php if(cv('goods.label.delete')) { ?>

                        <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要删除?" data-href="<?php  echo webUrl('sns/level/delete')?>">

                            <i class="icow icow-shanchu1"></i>删除

                            <?php  } ?>

                    </div>

                </div>

                <table class="table table-responsive">

                    <thead>

                    <tr>

                        <th style="width:25px;"></th>

                        <th>标签组名称</th>

                        <th style="width:80px;">状态</th>

                        <th style="width:65px;text-align: center;">操作</th>

                    </tr>

                    </thead>

                    <tbody>

                    <?php  if(is_array($label)) { foreach($label as $row) { ?>

                    <tr>

                        <td>

                            <?php  if($row['id']!='default') { ?>

                            <input type='checkbox' value="<?php  echo $row['id'];?>"/>

                            <?php  } ?>

                        </td>

                        <td><?php  echo $row['label'];?></td>

                        <td>

                            <span class='label <?php  if($row['status']==1) { ?>label-primary<?php  } else { ?>label-default<?php  } ?>'

                            <?php if(cv('goods.label.edit')) { ?>

                            data-toggle='ajaxSwitch'

                            data-switch-value='<?php  echo $row['status'];?>'

                            data-switch-value0='0|禁用|label label-default|<?php  echo webUrl('goods/label/status',array('status'=>1,'id'=>$row['id']))?>'

                            data-switch-value1='1|启用|label label-primary|<?php  echo webUrl('goods/label/status',array('status'=>0,'id'=>$row['id']))?>'

                            <?php  } ?>>

                            <?php  if($row['status']==1) { ?>启用<?php  } else { ?>禁用<?php  } ?></span>

                        </td>

                        <td style="text-align: center;">

                            <?php if(cv('goods.label.view|goods.label.edit')) { ?>

                            <a href="<?php  echo webUrl('goods/label/edit', array('id' => $row['id']))?>" class="btn btn-default btn-sm btn-operation btn-op">

                                 <span data-toggle="tooltip" data-placement="top" title="" data-original-title="  <?php if(cv('goods.label.edit')) { ?>修改<?php  } else { ?>查看<?php  } ?>">

                                     <i class="icow icow-bianji2"></i>

                                </span>

                            </a>

                            <?php  } ?>

                            <?php  if($row['id']!='default') { ?>

                            <?php if(cv('goods.label.delete')) { ?>

                                <a data-toggle='ajaxRemove' href="<?php  echo webUrl('goods/label/delete', array('id' => $row['id']))?>"class="btn btn-default btn-sm btn-operation btn-op" data-confirm='确认要删除此标签组吗?'>

                                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">

                                     <i class="icow icow-shanchu1"></i>

                                </span>

                                </a>

                            <?php  } ?>

                            <?php  } ?>

                        </td>

                    </tr>

                    <?php  } } ?>

                    </tbody>

                    <tfoot>

                    <tr>

                        <td colspan="2">

                            <input type="checkbox">

                            <div class="btn-group">

                                <?php if(cv('goods.label.edit')) { ?>

                                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('goods/label/status',array('status'=>1))?>">

                                    <i class='icow icow-qiyong'></i>启用

                                </button>

                                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch'  data-href="<?php  echo webUrl('goods/label/status',array('status'=>0))?>">

                                    <i class='icow icow-jinyong'></i> 禁用

                                </button>

                                <?php  } ?>

                                <?php if(cv('goods.label.delete')) { ?>

                                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要删除?" data-href="<?php  echo webUrl('sns/level/delete')?>">

                                    <i class="icow icow-shanchu1"></i>删除

                                <?php  } ?>

                            </div>

                        </td>

                        <td colspan="2" style="text-align: right">

                            <?php  echo $pager;?>

                        </td>

                    </tr>

                    </tfoot>

                </table>

            </div>

        </div>

        <?php  } else { ?>

        <div class="panel panel-default">

            <div class="panel-body empty-data">暂时没有任何标签组</div>

        </div>

        <?php  } ?>

    </form>

</div>



<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>



<!--4000097827-->