<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group-title">字段设置</div>

<div class="form-group">

    <div class="col-sm-12">
        <table class='table'>
            <thead>
            <th style='width:90px'>类型</th>
            <th style='width:100px'>字段名称</th>
            <th style='width:50px'>必填</th>
            <th  style='width:550px'>设置</th>
            <th></th>
            </thead>
            <tbody id="type-items">
            <?php  $kw=0;?>
            <?php  if(!empty($dfields)) { ?>
            <?php  if(is_array($dfields)) { foreach($dfields as $k1 => $v1) { ?>
            <?php  $data_type = $v1['data_type'];?>
            <?php  if($datacount>0) { ?>
            <?php  $flag=2;?>
            <?php  } ?>

            <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('diyform/temp/tpl', TEMPLATE_INCLUDEPATH)) : (include template('diyform/temp/tpl', TEMPLATE_INCLUDEPATH));?>

            <?php  $kw++;?>
            <?php  } } ?>
            <?php  } ?>
            </tbody>
            <?php if(cv('diyform.temp.add|diyform.temp.edit|goods.add|goods.edit')) { ?>
            <tr>
                <td colspan='5'>
                    <div class='input-group'>
                        <select id="data_type" name="data_type" class="form-control" style="width:200px;">
                            <?php  if(is_array($data_type_config)) { foreach($data_type_config as $key => $value) { ?>
                            <option value="<?php  echo $key;?>"><?php  echo $value;?></option>
                            <?php  } } ?>
                        </select>
                        <div class='input-group-btn'>
                            <a class="btn btn-primary btn-add-type" href="javascript:;" onclick="addType();"><i id="add_field" class="fa fa-plus" title=""></i> 增加一个字段</a>
                        </div>
                    </div>
                </td>
            </tr>
            <?php  } ?>

        </table>
    </div>
</div>
<!--4000097827-->