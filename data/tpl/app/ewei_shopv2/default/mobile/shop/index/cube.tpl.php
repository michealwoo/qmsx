<?php defined('IN_IA') or exit('Access Denied');?><?php  if(!empty($cubes)) { ?>
	<div class="fui-cube">
		<?php  if(count($cubes)==1) { ?>
			<img data-lazy="<?php  echo tomedia($cubes[0]['img'])?>" <?php  if(!empty($cubes[0]['url'])) { ?>onclick="location.href='<?php  echo $cubes[0]['url'];?>'"<?php  } ?> />
		<?php  } ?>
			
		<?php  if(count($cubes)>1) { ?>
			<div class="fui-cube-left">
				<img data-lazy="<?php  echo tomedia($cubes[0]['img'])?>" <?php  if(!empty($cubes[0]['url'])) { ?>onclick="location.href='<?php  echo $cubes[0]['url'];?>'"<?php  } ?> />
			</div>
			<div class="fui-cube-right">
				<?php  if(count($cubes)==2) { ?>
					<img data-lazy="<?php  echo tomedia($cubes[1]['img'])?>" <?php  if(!empty($cubes[1]['url'])) { ?>onclick="location.href='<?php  echo $cubes[1]['url'];?>'"<?php  } ?> />
				<?php  } ?>
				<?php  if(count($cubes)>2) { ?>
					<div class="fui-cube-right1">
						<img data-lazy="<?php  echo tomedia($cubes[1]['img'])?>" <?php  if(!empty($cubes[1]['url'])) { ?>onclick="location.href='<?php  echo $cubes[1]['url'];?>'"<?php  } ?> />
					</div>
					<div class="fui-cube-right2">
						<?php  if(count($cubes)==3) { ?>
							<img data-lazy="<?php  echo tomedia($cubes[2]['img'])?>" <?php  if(!empty($cubes[2]['url'])) { ?>onclick="location.href='<?php  echo $cubes[2]['url'];?>'"<?php  } ?> />
						<?php  } ?>
						<?php  if(count($cubes)>3) { ?>
							<div class="left">
								<img data-lazy="<?php  echo tomedia($cubes[2]['img'])?>" <?php  if(!empty($cubes[2]['url'])) { ?>onclick="location.href='<?php  echo $cubes[2]['url'];?>'"<?php  } ?> />
							</div>
						<?php  } ?>
						<?php  if(count($cubes)==4) { ?>
							<div class="right">
								<img data-lazy="<?php  echo tomedia($cubes[3]['img'])?>" <?php  if(!empty($cubes[3]['url'])) { ?>onclick="location.href='<?php  echo $cubes[3]['url'];?>'"<?php  } ?> />
							</div>
						<?php  } ?>
					</div>
				<?php  } ?>
			</div>
		<?php  } ?>
	</div>
<?php  } ?>

<!--青岛易联互动网络科技有限公司-->