<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
    当前位置：
    <span class="text-primary">
        <?php  if(!empty($item['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>标签组 <small><?php  if(!empty($item['id'])) { ?>修改【<?php  echo $item['label'];?>】<?php  } ?></small>
    </span>
</div>
<div class="page-content">
    <div class="page-sub-toolbar">
        <span class=''>
		<?php if(cv('goods.label.add')) { ?>
            <a class="btn btn-primary btn-sm" href="<?php  echo webUrl('goods/label/add')?>">添加新标签组</a>
		<?php  } ?>
	</span>
    </div>
    <form <?php if( ce('goods' ,$item) ) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate" enctype="multipart/form-data" >
        <div class="form-group">
            <label class="col-lg control-label">排序</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( ce('goods' ,$item) ) { ?>
                <input type="text" name="displayorder" class="form-control" value="<?php  echo $item['displayorder'];?>" />
                <?php  } else { ?>
                <div class='form-control-static'><?php  echo $item['displayorder'];?></div>
                <?php  } ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg control-label must">标签组名称</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( ce('goods' ,$item) ) { ?>
                <input type="text" name="label" class="form-control" value="<?php  echo $item['label'];?>" data-rule-required="true" />
                <?php  } else { ?>
                <div class='form-control-static'><?php  echo $item['label'];?></div>
                <?php  } ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg control-label">标签</label>
            <div class="col-sm-9 col-xs-12">
                <table class="table table-responsive" style="margin:0;">
                    <tbody id='tbody-items' style="border-top:none;">
                    <?php  if(is_array($labelname)) { foreach($labelname as $row) { ?>
                    <tr>
                        <td>
                            <?php if(cv('goods.label.edit')) { ?>
                            <input type="text" class="form-control" name="labelname[]" value="<?php  echo $row;?>" >
                            <?php  } else { ?>
                            <?php  echo $row['labelname'];?>
                            <?php  } ?>
                        </td>
                        <td style="width: 45px;">
                            <?php if(cv('goods.label.delete')) { ?>
                            <a href="javascript:void(0);" class="btn btn-default btn-del btn-op btn-operation" data-confirm="确认删除此标签?">
                                  <span data-toggle="tooltip" data-placement="top" title="" data-original-title="删除">
                                      <i class="icow icow-shanchu1"></i>
                                    </span>
                                </a>
                            <?php  } ?>
                        </td>

                    </tr>
                    <?php  } } ?>
                    </tbody>
                </table>
                <?php if(cv('goods.label.edit')) { ?>
                <input name="button" type="button" class="btn btn-default" value="添加标签" onclick='addCategory()'>
                <?php  } ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg control-label">是否启用</label>
            <div class="col-sm-9 col-xs-12" id="param-items">
                 <?php if( ce('groups.goods' ,$item) ) { ?>
                <label class="radio-inline">
                    <input type="radio" name='status' value="1" <?php  if($item['status']==1) { ?>checked<?php  } ?> /> 是
                </label>
                <label class="radio-inline">
                    <input type="radio" name='status' value="0" <?php  if(empty($item['status'])) { ?>checked<?php  } ?> /> 否
                </label>
                    <?php  } else { ?>
                 <div class='form-control-static'><?php  if(empty($item['status'])) { ?>是<?php  } else { ?>否<?php  } ?></div>
                 <?php  } ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg control-label"></label>
            <div class="col-sm-9 col-xs-12">
                 <?php if( ce('goods.label' ,$item) ) { ?>
                    <input type="submit" value="提交" class="btn btn-primary"  />
                <?php  } ?>
               <a href="<?php  echo webUrl('goods/label')?>" <?php if(cv('goods.label.add|goods.label.edit')) { ?>style='margin-left:10px;'<?php  } ?> value="返回列表" class="btn btn-default">返回列表</a>
            </div>
        </div>
    </form>
</div>
<script>

    <?php if(cv('goods.label.edit')) { ?>
    require(['jquery.ui'],function(){
        $('#tbody-items').sortable();
    })
    <?php  } ?>

    function addCategory(){
        var html ='<tr>';
        html+='<td style="width:200px;">';
        html+='<input type="text" class="form-control" name="labelname[]" value="">';
        html+='</td>';

        html+='<td></td></tr>';;
        $('#tbody-items').append(html);
    }
    $(function(){
        $(".btn-del").on("click",function(){
            var $btntr = $(this).parents('tr');
            console.log($btntr);
            tip.confirm('确认删除此标签?',function(){
                $btntr.remove();
            });
        });
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--青岛易联互动网络科技有限公司-->