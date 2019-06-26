<?php defined('IN_IA') or exit('Access Denied');?>	<div class='fui-content navbar'>
		<?php  if(is_array($sorts)) { foreach($sorts as $name => $item) { ?>
			<?php  if($item['visible']==1) { ?>
				<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('shop/index/'.$name, TEMPLATE_INCLUDEPATH)) : (include template('shop/index/'.$name, TEMPLATE_INCLUDEPATH));?>
			<?php  } ?>
		<?php  } } ?>
		<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('goods/picker', TEMPLATE_INCLUDEPATH)) : (include template('goods/picker', TEMPLATE_INCLUDEPATH));?>
		<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('goods/wholesalePicker', TEMPLATE_INCLUDEPATH)) : (include template('goods/wholesalePicker', TEMPLATE_INCLUDEPATH));?>
		<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_copyright', TEMPLATE_INCLUDEPATH)) : (include template('_copyright', TEMPLATE_INCLUDEPATH));?>
	</div>

<!--青岛易联互动网络科技有限公司-->