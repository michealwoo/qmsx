<?php defined('IN_IA') or exit('Access Denied');?><?php  if(!empty($banners)) { ?>

	<div class='fui-swipe'>

		<?php  if(empty($bannerswipe)) { ?>

			<?php  if(is_array($banners)) { foreach($banners as $item) { ?>

                <?php  if($item['isvideo']==1) { ?>
			        <video class="video" style="display: block; width: 100%; height: auto;" autoplay="autoplay" controls="controls" src="<?php  echo $item['link'];?>"></video>
		          <?php  } else { ?>
		            <img src="<?php  echo tomedia($item['thumb'])?>" style="display: block; width: 100%; height: auto;" <?php  if(!empty($item['link'])) { ?>onclick="location.href='<?php  echo $item['link'];?>'"<?php  } ?> />
		        <?php  } ?> 

			<?php  } } ?>

		<?php  } else { ?>

		    <div class='fui-swipe-wrapper'>

		    	<?php  if(is_array($banners)) { foreach($banners as $item) { ?>

		    		<div class='fui-swipe-item' <?php  if(!empty($item['link'])) { ?>onclick="location.href='<?php  echo $item['link'];?>'"<?php  } ?>>

		    			<!--<img src="<?php  echo tomedia($item['thumb'])?>" />-->

		    			<!--<video src="https://www.swiper.com.cn/demo/mac/video/musician.mp4" loop="true"></video>-->

		    			<video src="<?php  echo tomedia($item['thumb'])?>" loop="true"></video>

		    		</div>

				<?php  } } ?>

		    </div>

		    <div class='fui-swipe-page'></div>

	    <?php  } ?>

	</div>

<?php  } ?>

<!--4000097827-->