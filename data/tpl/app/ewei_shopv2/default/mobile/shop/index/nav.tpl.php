<?php defined('IN_IA') or exit('Access Denied');?><?php  if(!empty($navs)) { ?>
	<div class="fui-icon-group noborder">
		<?php  if(is_array($navs)) { foreach($navs as $item) { ?>
			<div class="fui-icon-col" <?php  if(!empty($item['url'])) { ?> onclick="location.href='<?php  echo $item['url'];?>'"<?php  } ?>>
				<div class="icon"><img src="<?php  echo tomedia($item['icon'])?>" /></div>
				<div class="text"><?php  echo $item['navname'];?></div>
		    </div>
		<?php  } } ?>
	</div>
 <?php  } ?>

<!--NDAwMDA5NzgyNw==-->