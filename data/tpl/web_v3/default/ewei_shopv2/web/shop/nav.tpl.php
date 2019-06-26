<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>



<div class="page-header">当前位置：<span class="text-primary">导航管理</span></div>

<div class="page-content">

    <form action="./index.php" method="get" class="form-horizontal form-search" role="form">

        <input type="hidden" name="c" value="site" />

        <input type="hidden" name="a" value="entry" />

        <input type="hidden" name="m" value="ewei_shopv2" />

        <input type="hidden" name="do" value="web" />

        <input type="hidden" name="r"  value="shop.nav" />



        <div class="page-toolbar">

            <div class="col-sm-4">

                <?php if(cv('shop.nav.add')) { ?>

                    <a class='btn btn-primary btn-sm' href="<?php  echo webUrl('shop/nav/add')?>"><i class='fa fa-plus'></i> 添加首页导航</a>

                <?php  } ?>

            </div>

            <div class="col-md-6 pull-right">

                <div class="input-group">

                    <span class="input-group-select">

                        <select name="status" class='form-control'>

                            <option value="" <?php  if($_GPC['status'] == '') { ?> selected<?php  } ?>>状态</option>

                            <option value="1" <?php  if($_GPC['status']== '1') { ?> selected<?php  } ?>>显示</option>

                            <option value="0" <?php  if($_GPC['status'] == '0') { ?> selected<?php  } ?>>隐藏</option>

                        </select>

                    </span>

                    <input type="text" class="form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词">

                    <span class="input-group-btn">

                        <button class="btn btn-primary" type="submit"> 搜索</button>

                    </span>

                </div>

            </div>

        </div>

    </form>



    <?php  if(empty($list)) { ?>

        <div class="panel panel-default">

            <div class="panel-body empty-data">未查询到相关数据</div>

        </div>

    <?php  } else { ?>

        <form action="" method="post">

            <div class="page-table-header">

                <input type='checkbox' />

                <div class="btn-group">

                    <?php if(cv('shop.nav.edit')) { ?>

                    <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('shop/nav/status',array('status'=>1))?>"><i class='icow icow-xianshi'></i> 显示</button>

                    <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch'  data-href="<?php  echo webUrl('shop/nav/status',array('status'=>0))?>"><i class='icow icow-yincang'></i> 隐藏</button>

                    <?php  } ?>

                    <?php if(cv('shop.nav.delete')) { ?>

                    <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要删除?" data-href="<?php  echo webUrl('shop/nav/delete')?>"><i class='icow icow-shanchu1'></i> 删除</button>

                    <?php  } ?>

                </div>

            </div>

            <table class="table table-responsive table-hover" >

                <thead class="navbar-inner">

                    <tr>

                        <th style="width:25px;"></th>

                        <th style='width:50px'>顺序</th>

                        <th style='width:45px; text-align: center;'>图标</th>

                        <th style='width: 140px;'>标题</th>

                        <th>链接</th>

                        <th style='width:60px'>显示</th>

                        <th style="width: 65px;">操作</th>

                    </tr>

                </thead>

                <tbody>

                    <?php  if(is_array($list)) { foreach($list as $row) { ?>

                        <tr>

                            <td>

                                <input type='checkbox'   value="<?php  echo $row['id'];?>"/>

                            </td>

                            <td>

                                <?php if(cv('shop.nav.edit')) { ?>

                                    <a href='javascript:;' data-toggle='ajaxEdit' data-href="<?php  echo webUrl('shop/nav/displayorder',array('id'=>$row['id']))?>" ><?php  echo $row['displayorder'];?></a>

                                <?php  } else { ?>

                                    <?php  echo $row['displayorder'];?>

                                <?php  } ?>

                            </td>

                            <td>

                                <img style="width:30px;height:30px;padding1px;border:1px solid #ccc" src="<?php  echo tomedia($row['icon'])?>" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'">

                            </td>

                            <td><?php  echo $row['navname'];?></td>

                            <td><?php  echo $row['url'];?></td>

                            <td>

                                <span class='label <?php  if($row['status']==1) { ?>label-primary<?php  } else { ?>label-default<?php  } ?>'

                                      <?php if(cv('shop.nav.edit')) { ?>

                                          data-toggle='ajaxSwitch'

                                          data-switch-value='<?php  echo $row['status'];?>'

                                          data-switch-value0='0|隐藏|label label-default|<?php  echo webUrl('shop/nav/status',array('status'=>1,'id'=>$row['id']))?>'

                                          data-switch-value1='1|显示|label label-primary|<?php  echo webUrl('shop/nav/status',array('status'=>0,'id'=>$row['id']))?>'

                                      <?php  } ?>>

                                      <?php  if($row['status']==1) { ?>显示<?php  } else { ?>隐藏<?php  } ?>

                                </span>

                            </td>

                            <td style="text-align:left;">

                                <?php if(cv('shop.nav.view|shop.nav.edit')) { ?>

                                    <a href="<?php  echo webUrl('shop/nav/edit', array('id' => $row['id']))?>" class="btn btn-op btn-operation">

                                        <span data-toggle="tooltip" data-placement="top" data-original-title="<?php if(cv('shop.nav.edit')) { ?>修改<?php  } else { ?>查看<?php  } ?>">

                                                <i class='icow icow-bianji2'></i>

                                            </span>

                                    </a>

                                <?php  } ?>

                                <?php if(cv('shop.nav.delete')) { ?>

                                    <a data-toggle='ajaxRemove' href="<?php  echo webUrl('shop/nav/delete', array('id' => $row['id']))?>"class="btn btn-op btn-operation" data-confirm='确认要删除此首页导航吗?'>

                                        <span data-toggle="tooltip" data-placement="top" data-original-title="删除">

                                               <i class='icow icow-shanchu1'></i>

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

                        <td colspan="4">

                            <div class="btn-group">

                                <?php if(cv('shop.nav.edit')) { ?>

                                    <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch' data-href="<?php  echo webUrl('shop/nav/status',array('status'=>1))?>"><i class='icow icow-xianshi'></i> 显示</button>

                                    <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch'  data-href="<?php  echo webUrl('shop/nav/status',array('status'=>0))?>"><i class='icow icow-yincang'></i> 隐藏</button>

                                <?php  } ?>

                                <?php if(cv('shop.nav.delete')) { ?>

                                    <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle='batch-remove' data-confirm="确认要删除?" data-href="<?php  echo webUrl('shop/nav/delete')?>"><i class='icow icow-shanchu1'></i> 删除</button>

                                <?php  } ?>

                            </div>

                        </td>

                        <td colspan="2" style="text-align: right">

                            <?php  echo $pager;?>

                        </td>

                    </tr>

                </tfoot>

            </table>

        </form>

    <?php  } ?>

</div>



<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--4000097827-->