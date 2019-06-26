<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class='fui-page  fui-page-current shop-index-page'>
	<?php  if(is_h5app()) { ?>
	<div class="fui-header">
		<div class="fui-header-left"></div>
		<div class="title"><?php  if(empty($this->merch_user)) { ?><?php  echo $_W['shopset']['shop']['name'];?><?php  } else { ?><?php  echo $this->merch_user['merchname']?><?php  } ?></div>
		<div class="fui-header-right"></div>
	</div>
	<?php  } ?>
	<?php  $this->followBar()?>
	<?php  echo $index_cache;?>
</div>

<?php  if(!empty($cpinfos)) { ?>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('sale/sendticket', TEMPLATE_INCLUDEPATH)) : (include template('sale/sendticket', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>


<?php  if(empty($trade['shop_strengthen'])) { ?>
	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('shop/shopstrengthen', TEMPLATE_INCLUDEPATH)) : (include template('shop/shopstrengthen', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>

<?php  $this->diyDanmu()?>

<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>