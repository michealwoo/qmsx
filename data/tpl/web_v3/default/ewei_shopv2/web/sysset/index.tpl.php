<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">当前位置：<span class="text-primary">商城设置</span></div>

    <div class="page-content">
        <form action="" method="post" class="form-horizontal form-validate" enctype="multipart/form-data" >
            <div class="form-group">
                <label class="col-lg control-label">商城名称</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('sysset.shop.edit')) { ?>
                    <input type="text" name="data[name]" class="form-control" value="<?php  echo $data['name'];?>" />
                    <?php  } else { ?>
                    <input type="hidden" name="data[name]" value="<?php  echo $data['name'];?>"/>
                    <div class='form-control-static'><?php  echo $data['name'];?></div>
                    <?php  } ?>

                </div>
            </div>
            <div class="form-group">
                <label class="col-lg control-label">商城LOGO</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('sysset.shop.edit')) { ?>
                    <?php  echo tpl_form_field_image2('data[logo]', $data['logo'])?>
                    <span class='help-block'>正方型图片，建议尺寸100*100</span>
                    <?php  } else { ?>
                    <input type="hidden" name="data[logo]" value="<?php  echo $data['logo'];?>"/>
                    <?php  if(!empty($data['logo'])) { ?>
                    <a href='<?php  echo tomedia($data['logo'])?>' target='_blank'>
                    <img src="<?php  echo tomedia($data['logo'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />
                    </a>
                    <?php  } ?>
                    <?php  } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg control-label">商城简介</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('sysset.shop.edit')) { ?>
                    <textarea name="data[description]" class="form-control richtext"rows="5"><?php  echo $data['description'];?></textarea>
                    <?php  } else { ?>
                    <textarea name="data[description]" class="form-control richtext" rows="5" style="display:none"><?php  echo $data['description'];?></textarea>
                    <div class='form-control-static'><?php  echo $data['description'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg control-label">店招</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('sysset.shop.edit')) { ?>
                    <?php  echo tpl_form_field_image2('data[img]', $data['img'])?>
                    <span class='help-block'>商城首页店招，建议尺寸640*450</span>
                    <?php  } else { ?>
                    <input type="hidden" name="data[img]" value="<?php  echo $data['img'];?>"/>
                    <?php  if(!empty($data['img'])) { ?>
                    <a href='<?php  echo tomedia($data['img'])?>' target='_blank'>
                    <img src="<?php  echo tomedia($data['img'])?>" style='width:200px;border:1px solid #ccc;padding:1px' />
                    </a>
                    <?php  } ?>
                    <?php  } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg control-label">商城海报</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('sysset.shop.edit')) { ?>
                    <?php  echo tpl_form_field_image2('data[signimg]', $data['signimg'])?>
                    <span class='help-block'>推广海报，建议尺寸640*640</span>
                    <?php  } else { ?>
                    <input type="hidden" name="data[signimg]" value="<?php  echo $data['signimg'];?>"/>
                    <?php  if(!empty($data['signimg'])) { ?>
                    <a href='<?php  echo tomedia($data['signimg'])?>' target='_blank'>
                    <img src="<?php  echo tomedia($data['signimg'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />
                    </a>
                    <?php  } ?>
                    <?php  } ?>

                </div>
            </div>
            <div class="form-group">
                <label class="col-lg control-label">获取未关注者信息</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('sysset.shop.edit')) { ?>
                    <label class="radio-inline">
                        <input type="radio" name="data[getinfo]" value="1" <?php  if(empty($data['getinfo']) || $data['getinfo']==1) { ?>checked=""<?php  } ?>> 开启
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="data[getinfo]" value="2" <?php  if($data['getinfo']==2) { ?>checked=""<?php  } ?>> 关闭
                    </label>
                    <?php  } else { ?>
                    <input type="hidden" name="data[name]" value="<?php  echo $data['name'];?>"/>
                    <div class='form-control-static'><?php  if($data['getinfo']==0) { ?>关闭<?php  } else { ?>开启<?php  } ?></div>
                    <?php  } ?>
                    <div class="help-block"> 如果开启此选项,则是会弹出绿色微信授权框</div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg control-label">售罄图标</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('sysset.shop.edit')) { ?>
                    <?php  echo tpl_form_field_image2('data[saleout]', $data['saleout'])?>
                    <span class='help-block'>商品售罄图标，建议尺寸80*80，空则不显示</span>
                    <?php  } else { ?>
                    <input type="hidden" name="data[saleout]" value="<?php  echo $data['saleout'];?>"/>
                    <?php  if(!empty($data['saleout'])) { ?>
                    <a href='<?php  echo tomedia($data['saleout'])?>' target='_blank'>
                    <img src="<?php  echo tomedia($data['saleout'])?>" style='width:200px;border:1px solid #ccc;padding:1px' />
                    </a>
                    <?php  } ?>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg control-label">加载图标</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('sysset.shop.edit')) { ?>
                    <?php  echo tpl_form_field_image2('data[loading]', $data['loading'])?>
                    <span class='help-block'>商品列表图片加载图标，建议尺寸100*100(根据实际需求调整)，空则不显示</span>
                    <?php  } else { ?>
                    <input type="hidden" name="data[loading]" value="<?php  echo $data['loading'];?>"/>
                    <?php  if(!empty($data['loading'])) { ?>
                    <a href=""<?php  echo tomedia($data['loading'])?>" target='_blank'>
                    <img src="<?php  echo tomedia($data['loading'])?>" style='width:200px;border:1px solid #ccc;padding:1px' />
                    </a>
                    <?php  } ?>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg control-label">全局统计代码</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('sysset.shop.edit')) { ?>
                    <textarea name="data[diycode]" class="form-control richtext"  rows="5"><?php  echo $data['diycode'];?></textarea>
                    <?php  } else { ?>
                    <textarea name="data[diycode]" class="form-control richtext" style="display:none"  rows="5"><?php  echo $data['diycode'];?></textarea>
                    <div class='form-control-static'><?php  echo $data['diycode'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg control-label">开启导航条</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('sysset.shop.edit')) { ?>
                    <label class="radio-inline"><input type="radio" name="data[funbar]" value="1" <?php  if(!empty($data['funbar'])) { ?>checked=""<?php  } ?>> 开启</label>
                    <label class="radio-inline"><input type="radio" name="data[funbar]" value="0" <?php  if(empty($data['funbar'])) { ?>checked=""<?php  } ?>> 关闭</label>
                    <?php  } else { ?>
                    <input type="hidden" name="data[name]" value="<?php  echo $data['name'];?>"/>
                    <div class='form-control-static'><?php  if(empty($data['funbar'])) { ?>关闭<?php  } else { ?>开启<?php  } ?></div>
                    <?php  } ?>
                    <div class="help-block"> 如果开启此选项，导航内容请到导航条中编辑</div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg control-label">商品列表库存预警</label>
                <div class="col-sm-9 col-xs-12">
                    <input class="form-control" name="data[goodstotal]" value="<?php  echo intval($data['goodstotal'])?>"/>
                    <span class="help-block">当后台商品列表中商品库存小于此值时特殊标记(值为零时不提示)</span>
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg control-label">商品图片预览</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('sysset.shop.edit')) { ?>
                    <label class="radio-inline"><input type="radio" name="data[close_preview]" value="0" <?php  if(empty($data['close_preview'])) { ?>checked=""<?php  } ?>> 开启</label>
                    <label class="radio-inline"><input type="radio" name="data[close_preview]" value="1" <?php  if(!empty($data['close_preview'])) { ?>checked=""<?php  } ?>> 关闭</label>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  if(empty($data['close_preview'])) { ?>开启<?php  } else { ?>关闭<?php  } ?></div>
                    <?php  } ?>
                    <div class="help-block"> 如果开启此选项，则商品详情里面的图片可以放大预览</div>
                </div>
            </div>


            <div class="form-group">
                <label class="col-lg control-label"></label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('sysset.shop.edit')) { ?>
                    <input type="submit" value="提交" class="btn btn-primary"  />
                    <?php  } ?>
                </div>
            </div>
        </form>
    </div>
 
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>