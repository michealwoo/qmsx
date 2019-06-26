<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">当前位置：<span class="text-primary">商品销售转化率 </span></div>

<div class="page-content">
    <form action="./index.php" method="get" class="form-horizontal">
        <input type="hidden" name="c" value="site" />
        <input type="hidden" name="a" value="entry" />
        <input type="hidden" name="m" value="ewei_shopv2" />
        <input type="hidden" name="do" value="web" />
        <input type="hidden" name="r"  value="statistics.goods_trans" />
        <div class="page-toolbar">
            <div class="col-sm-6 pull-right">
                <div class="input-group">
                    <span class="input-group-select">
                        <select name='orderby'  class='form-control  '   style="width:100px;"  >
                            <option value='' <?php  if($_GPC['orderby']=='') { ?>selected<?php  } ?>>排序</option>
                            <option value='0' <?php  if($_GPC['orderby']=='0') { ?>selected<?php  } ?>>降序</option>
                            <option value='1' <?php  if($_GPC['orderby']=='1') { ?>selected<?php  } ?>>升序</option>
                        </select>
                    </span>
                    <input type="text" class="form-control"  name="title" value="<?php  echo $_GPC['title'];?>" placeholder="商品名称"/>
				<span class="input-group-btn">
					<button class="btn btn-primary" type="submit"> 搜索</button>
                    <?php if(cv('statistics.goods_trans.export')) { ?>
                    <button type="submit" name="export" value="1" class="btn btn-success ">导出</button>
                    <?php  } ?>
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
    <table class="table table-hover">
        <thead>
        <tr>
            <th>商品名称</th>
            <th style='width:100px;'>访问次数</th>
            <th style='width:100px;'>购买件数</th>
            <th style="width: 80px">转化率</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php  if(is_array($list)) { foreach($list as $row) { ?>
        <tr>
            <td>
                <img src="<?php  echo tomedia($row['thumb'])?>" style="width: 30px; height: 30px;border:1px solid #ccc;padding:1px;"  onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" >
                <?php  echo $row['title'];?></td>
            <td><?php  echo $row['viewcount'];?></td>
            <td><?php  echo intval($row['buycount'])?></td>
            <td><span class="progress-num" tyle="color:#000"><?php echo empty($row['percent'])?'':$row['percent'].'%'?></span></td>
            <td>   <div class="progress" style='max-width:500px;'>
                <div style="width: <?php  echo $row['percent'];?>%;" class="progress-bar progress-bar-info"></div>
            </div>
            </td>
        </tr>
        <?php  } } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="text-align: right">
                    <?php  echo $pager;?>
                </td>
            </tr>
        </tfoot>
    </table>
    <?php  } ?>
</div>
 
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+4-->