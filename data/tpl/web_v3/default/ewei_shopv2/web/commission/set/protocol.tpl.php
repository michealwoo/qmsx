<?php defined('IN_IA') or exit('Access Denied');?>
<div class="form-group">
    <label class="col-lg control-label">协议名称</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('commission.set.edit')) { ?>
        <input type='text' class='form-control' name='data[applytitle]' value="<?php  echo $data['applytitle'];?>" />
        <?php  } else { ?>
        <div class='form-control-static'><?php  echo $data['applytitle'];?></div>
        <?php  } ?>
    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">协议内容</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('commission.set.edit')) { ?>
        <?php  echo tpl_ueditor('data[applycontent]',$data['applycontent'],array('height'=>200))?>
        <?php  } else { ?>
        <textarea id='applycontent' style='display:none'><?php  echo $data['applycontent'];?></textarea>
        <a href='javascript:preview_html("#applycontent")' class="btn btn-default">查看内容</a>
        <?php  } ?>
    </div>
</div>


<!--4000097827-->