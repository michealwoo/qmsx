<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">
    当前位置：<span class="text-primary">订单自定义导出</span>
</div>
<style type='text/css'>
    .dd-handle { height: 40px; line-height: 30px;width:100px;}
    .field-item {
        padding:10px; border:1px solid #ccc;
        border-radius: 3px; float:left;
        margin:5px;
        -webkit-user-select: none;
        -moz-user-select:none;
        position:relative;
        cursor: pointer;

    }
    .field-item:active {
        background:#d9d9d9;
    }
    .drag{
        background:#d9d9d9;
    }
    .form-control .select2-choice {
        border: 0 none;
        border-radius: 2px;
        height: 32px;    line-height: 32px;
    }
    .field-item.field-item-remove span {
        color:red;
        position: absolute;right:-5px;top:-10px;cursor: pointer;
    }

</style>

<div class="page-content">
    <form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
        <input type="hidden" name="c" value="site" />
        <input type="hidden" name="a" value="entry" />
        <input type="hidden" name="m" value="ewei_shopv2" />
        <input type="hidden" name="do" value="web" />
        <input type="hidden" name="r" value="order.export" />
        <div class="panel panel-default">
            <div class='panel-heading'>
                查询条件
            </div>
            <div class="panel-body">

                <div class="form-group">

                    <div class="col-sm-3">

                        <input class="form-control" name="keyword" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="订单号">

                    </div>


                    <div class="col-sm-3">

                        <input class="form-control" name="expresssn" type="text" value="<?php  echo $_GPC['expresssn'];?>" placeholder="快递单号">
                    </div>


                    <div class="col-sm-3">
                        <input class="form-control" name="member" type="text" value="<?php  echo $_GPC['member'];?>" placeholder="用户手机号/姓名/昵称, 收件人姓名/手机号 ">
                    </div>

                    <div class="col-sm-3">

                        <select name="paytype" class="form-control">
                            <option value="" <?php  if($_GPC['paytype']=='') { ?>selected<?php  } ?>>支付方式</option>
                            <?php  if(is_array($paytype)) { foreach($paytype as $key => $type) { ?>
                            <option value="<?php  echo $key;?>" <?php  if($_GPC['paytype'] == "$key") { ?> selected="selected" <?php  } ?>><?php  echo $type['name'];?></option>
                            <?php  } } ?>
                        </select>

                    </div>

                </div>

                <div class="form-group">
                    <div class="col-sm-3">

                        <select name="status" class="form-control">
                            <option value="" <?php  if($_GPC['status']=='') { ?>selected<?php  } ?>>订单状态</option>
                            <?php  if(is_array($orderstatus)) { foreach($orderstatus as $key => $type) { ?>
                            <option value="<?php  echo $key;?>" <?php  if($_GPC['status'] == "$key") { ?> selected="selected" <?php  } ?>><?php  echo $type['name'];?></option>
                            <?php  } } ?>
                        </select>

                    </div>

                    <div class="col-sm-3">

                        <input class="form-control" name="saler" type="text" value="<?php  echo $_GPC['saler'];?>" placeholder="核销员昵称/姓名/手机号">

                    </div>

                    <div class="col-sm-3">

                        <select name="storeid" class="form-control select2">
                            <option value="" <?php  if($_GPC['storeid']=='') { ?>selected<?php  } ?> >核销门店</option>
                            <?php  if(is_array($stores)) { foreach($stores as $store) { ?>
                            <option value="<?php  echo $store['id'];?>" <?php  if($_GPC['storeid'] ==$store['id']) { ?> selected="selected" <?php  } ?>><?php  echo $store['storename'];?></option>
                            <?php  } } ?>
                        </select>

                    </div>
                </div>
                <div class="form-group">
                    <?php  if($is_openmerch == 1) { ?>
                    <div class="col-sm-3">
                        <select name="merchtype" class="form-control">
                            <option value="1" <?php  if($_GPC['merchtype']=='1') { ?>selected<?php  } ?>>所有订单</option>
                            <option value="" <?php  if($_GPC['merchtype']=='') { ?>selected<?php  } ?>>自营订单</option>
                            <option value="2" <?php  if($_GPC['merchtype']=='2') { ?>selected<?php  } ?>>多商户订单</option>
                        </select>
                    </div>
                    <?php  } ?>

                    <div class="col-sm-5">
                        <?php  echo tpl_daterange('time', array('sm'=>true,'placeholder'=>'下单时间'),true);?>
                    </div>

                </div>
            </div>

            <div class='panel-heading'>
                订单类型 (可以多选,默认导出所有类型的订单)
            </div>
            <div class="panel-body" id='new_fields1'>
                <div class="form-group">
                    <div class="col-sm-12">

                        <label for="export_dispatch" class="checkbox-inline">
                            <input type="checkbox" name="export_dispatch" value="1" id="export_dispatch" <?php  if($_GPC['isdispatch'] == 1) { ?>checked="true"<?php  } ?> /> 快递订单
                        </label>

                        <label for="export_since" class="checkbox-inline">
                            <input type="checkbox" name="export_since" value="1" id="export_since" <?php  if($_GPC['isvirtual'] == 1) { ?>checked="true"<?php  } ?> /> 自提订单
                        </label>

                        <label for="export_verify" class="checkbox-inline">
                            <input type="checkbox" name="export_verify" value="1" id="export_verify" <?php  if($_GPC['isverify'] == 1) { ?>checked="true"<?php  } ?> /> 核销订单
                        </label>

                        <label for="export_virtual" class="checkbox-inline">
                            <input type="checkbox" name="export_virtual" value="1" id="export_virtual" <?php  if($_GPC['isvirtual'] == 1) { ?>checked="true"<?php  } ?> /> 虚拟物品订单
                        </label>

                    </div>
                </div>
            </div>


            <div class='panel-heading'>
                现有列 （拖动可排序)

                <select id="templates" class="form-control select2" style="width:300px;" onchange="changeTemplate()" name="tempname">
                    <option value="" >请选择导出列模板</option>
                    <?php  if(is_array($templates)) { foreach($templates as $key => $t) { ?>
                    <option value="<?php  echo $key;?>" ><?php  echo $key;?></option>
                    <?php  } } ?>

                </select>
                <button class='btn btn-primary btn-sm' id="deltemplate" type='button' style="display:none;"  >删除当前模板</button>

                <button class='btn btn-primary  btn-sm' id="changetemplate" type='button'  onclick='saveFields()'>将当前保存为模板</button>

                <button class='btn btn-danger  btn-sm' type='button'  onclick='resetFields()'>全部清空</button>

                <button class='btn btn-primary  btn-sm' type='button'  onclick='defaultFields()'>默认模板</button>

            </div>
            <div class="panel-body" id='add_fields'>


                <?php  if(is_array($columns)) { foreach($columns as $row) { ?>

                <div class='field-item  field-item-remove'
                     data-field="<?php  echo $row['field'];?>"
                     data-subtitle="<?php echo isset($row['subtitle'])?$row['subtitle']:''?>"
                     data-title="<?php  echo $row['title'];?>"
                     data-width="<?php  echo $row['width'];?>">
                    <?php echo !empty($row['subtitle'])?$row['subtitle']:$row['title']?>   <span><i class='fa fa-remove'></i></span>

                </div>
                <?php  } } ?>

            </div>
            <div class='panel-heading'>
                增加列 (点击增加)
            </div>
            <div class="panel-body" id='new_fields'>


                <?php  if(is_array($default_columns)) { foreach($default_columns as $row) { ?>
                <?php  if(!$row['select']) { ?>
                <div class='field-item field-item-add'
                     data-field="<?php  echo $row['field'];?>"
                     data-subtitle="<?php echo isset($row['subtitle'])?$row['subtitle']:''?>"
                     data-title="<?php  echo $row['title'];?>"
                     data-width="<?php  echo $row['width'];?>">
                    <?php echo !empty($row['subtitle'])?$row['subtitle']:$row['title']?>

                </div>
                <?php  } ?>
                <?php  } } ?>

            </div>
        </div>
        <div class='panel-body'>

            <div class="form-group">

                <div class="col-sm-7 col-lg-9 col-xs-12">
                    <button type="submit" name="export" value="1" class="btn btn-primary">立即导出</button>
                </div>
            </div>
        </div>


    </form>
</div>
<script language='javascript'>
    function resetFields() {
        tip.confirm('确认全部清空?', function () {
            $.get("<?php  echo webUrl('order/export/reset')?>", function () {
                location.href = "<?php  echo webUrl('order/export', array('dflag' => 1))?>";
            });
        });
    }

    function defaultFields() {
        tip.confirm('确认切换成默认模板?', function () {
            $.get("<?php  echo webUrl('order/export/reset')?>", function () {
                location.href = "<?php  echo webUrl('order/export')?>";
            });
        });
    }

    var currentTemplate = "";
    function changeTemplate() {

        var val = $('#templates').val();
        currentTemplate = val;
        if (val == '') {
            $('#deltemplate').hide();
            $('#changetemplate').text('将当前保存为模板');
        }
        else {
            $('#changetemplate').text('保存当前模板');
            $('#deltemplate').show().unbind('click').click(function () {
                if (confirm('确认要删除此导出模板?')) {
                    $.post("<?php  echo webUrl('order/export/delete')?>", {tempname: val}, function (ret) {
                        ret = eval("(" + ret + ")");
                        if (ret.templates) {
                            $('#templates').empty();
                            var opt = new Option('请选择导出列模板', '');
                            $('#templates')[0].options.add(opt);

                            $.each(ret.templates, function (i, tn) {
                                var opt = new Option(tn, tn);
                                $('#templates')[0].options.add(opt);
                            });
                            $('#templates').val('').trigger("change");
                            ;
                        }
                    });
                }
            });

            $.get("<?php  echo webUrl('order/export/gettemplate')?>&tempname=" + currentTemplate, function (ret) {
                ret = eval("(" + ret + ")");
                if (ret.columns && ret.others) {

                    $('#add_fields').empty();
                    $.each(ret.columns, function (i, d) {
                        addData(d, false);
                    });
                    $('#new_fields').empty();
                    $.each(ret.others, function (i, d) {
                        addData(d, true);
                    });
                }
            });

        }
    }
    function addData(data, other) {
        var html = '';
        if (!other) {
            html = '<div class="field-item field-item-remove"  data-field="' + data.field + '"  data-title="' + data.title + '" data-width="' + data.width + '" data-subtitle="' + (data.subtitle || "") + '">' + (data.subtitle || data.title) + ' <span><i class="fa fa-remove"></i></span></div>';
            $('#add_fields').append(html);
        } else {
            html = '<div class="field-item field-item-add"  data-field="' + data.field + '"  data-title="' + data.title + '" data-width="' + data.width + '" data-subtitle="' + (data.subtitle || "") + '">' + (data.subtitle || data.title) + '</div>';
            $('#new_fields').append(html);
        }
        initEvents();

    }
    function addField(item) {

        var field = item.data('field');
        var html = '<div class="field-item field-item-remove"  data-field="' + field + '"  data-title="' + item.data('title') + '" data-width="' + item.data('width') + '" data-subtitle="' + item.data('subtitle') + '">' + (item.data('subtitle') || item.data('title')) + ' <span><i class="fa fa-remove"></i></span></div>';
        $('#add_fields').append(html);
        item.remove();
        initEvents();
        changedata();
    }
    function removeField(item) {
        var field = item.data('field');
        var html = '<div class="field-item field-item-add"  data-field="' + field + '"  data-title="' + item.data('title') + '" data-width="' + item.data('width') + '" data-subtitle="' + item.data('subtitle') + '">' + (item.data('subtitle') || item.data('title')) + ' </div>';
        $('#new_fields').append(html);
        item.remove();
        initEvents();
        changedata();
    }
    function changedata(isnew) {

        var columns = [];
        $('#add_fields').find('.field-item').each(function () {
            columns.push({
                field: $(this).data('field'),
                title: $(this).data('title'),
                subtitle: $(this).data('subtitle'),
                width: $(this).data('width')
            });
        });
        $.post("<?php  echo webUrl('order/export/save')?>", {columns: columns, tempname: currentTemplate}, function (ret) {
            if (isnew) {
                ret = eval("(" + ret + ")");
                if (ret.templates) {
                    $('#templates').empty();
                    var opt = new Option('请选择导出列模板', '');
                    $('#templates')[0].options.add(opt);
                    $.each(ret.templates, function (i, tn) {
                        var opt = new Option(tn, tn);
                        $('#templates')[0].options.add(opt);
                    });
                    $('#templates').val(currentTemplate).trigger('change');

                }
            }
        });
    }
    function saveFields() {
        var isnew = false;
        if (currentTemplate == '') {
            var templatename = prompt('请输入列模板名称:');
            if (!templatename) {
                return;
            }
            currentTemplate = templatename;
            isnew = true;
        }
        changedata(isnew);
    }
    function initEvents() {
        $('.field-item-remove span').unbind('click').click(function () {
            removeField($(this).closest('.field-item'));
        });
        $('.field-item-add').unbind('click').click(function () {
            addField($(this));
        });
        require(['jquery.ui'], function () {
            $('#add_fields').sortable({
                stop: function () {
                    changedata(false)
                }
            });
        })
    }
    $(function () {

        initEvents();

        $('#form1').submit(function(){
            var val = $('#templates').val();
            if(val == ''){
                alert('请选择导出列模板!');
                return false;
            }
            return true;
        });
    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
