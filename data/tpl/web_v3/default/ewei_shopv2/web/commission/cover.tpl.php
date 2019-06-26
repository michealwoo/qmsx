<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
    当前位置：<span class="text-primary">分销中心入口设置</span>
</div>
<div class="page-content">
    <form id="setform"  <?php if(cv('commission.cover.edit')) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate" >

               <div class="form-group">
                    <label class="col-lg control-label">直接链接</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class='form-control-static'>
                            <a href='javascript:;' class="js-clip" title='点击复制链接' data-url="<?php  echo mobileUrl('commission',null,true)?>" >
                                <?php  echo mobileUrl('commission',null,true)?>
                            </a>
                            <span style="cursor: pointer;" data-toggle="popover" data-trigger="hover" data-html="true"
                                  data-content="<img src='<?php  echo $qrcode;?>' width='130' alt='链接二维码'>" data-placement="auto right">
                                <i class="glyphicon glyphicon-qrcode"></i>
                            </span>
                        </p>
                    </div>
                </div>

               <div class="form-group">
                    <label class="col-lg control-label must" >关键词</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if(cv('commission.cover.edit')) { ?>
                         <input type='text' class='form-control' name='cover[keyword]' value="<?php  echo $keyword['content'];?>" data-rule-required="true" />
                        <?php  } else { ?>
                        <div class="form-control-static"><?php  echo $keyword['content'];?></div>
                        <?php  } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg control-label">封面标题</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if(cv('commission.cover.edit')) { ?>
                         <input type='text' class='form-control' name='cover[title]' value="<?php  echo $cover['title'];?>" />
                        <?php  } else { ?>
                        <div class="form-control-static"><?php  echo $cover['title'];?></div>
                        <?php  } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg control-label">封面图片</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if(cv('commission.cover.edit')) { ?>
                            <?php  echo tpl_form_field_image2('cover[thumb]',$cover['thumb'])?>
                        <?php  } else { ?>
                            <div class="form-control-static">
                                <img src="<?php  echo tomedia($cover['thumb'])?>" onerror="this.src='./resource/images/nopic.jpg'; this.title='图片未找到.'" class="img-responsive img-thumbnail" width="150">
                            </div>
                        <?php  } ?>
                    </div>
                </div>
                  <div class="form-group">
                    <label class="col-lg control-label">封面描述</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php if(cv('commission.cover.edit')) { ?>
                        <textarea name='cover[desc]' class='form-control' rows="5"><?php  echo $cover['description'];?></textarea>
                        <?php  } else { ?>
                        <div class="form-control-static"><?php  echo $cover['description'];?></div>
                        <?php  } ?>
                    </div>
                </div>
                   <div class="form-group">
                    <label class="col-lg control-label">状态</label>
                    <div class="col-sm-9">
                        <?php if(cv('commission.cover.edit')) { ?>
                        <label class="radio-inline">
                            <input type="radio" name="cover[status]" value="1" <?php  if($rule['status']==1) { ?> checked="checked"<?php  } ?>/>启用
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="cover[status]" value="0" <?php  if(empty($rule['status'])) { ?> checked="checked"<?php  } ?>/>禁用
                        </label>
                        <?php  } else { ?>
                            <div class="form-control-static"><?php  if(empty($rule['status'])) { ?> 禁用<?php  } else { ?>启用 <?php  } ?></div>
                        <?php  } ?>
                    </div>
                </div>

    <?php if(cv('commission.cover.edit')) { ?>
             <div class="form-group">
                <label class="col-lg control-label"></label>
                <div class="col-sm-9">
                    <input type="submit" value="提交" class="btn btn-primary" />

                </div>
            </div>
     <?php  } ?>
    </form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--NDAwMDA5NzgyNw==-->