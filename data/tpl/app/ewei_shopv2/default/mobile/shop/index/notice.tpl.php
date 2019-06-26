<?php defined('IN_IA') or exit('Access Denied');?><?php  if(!empty($notices)) { ?>
	<div class="fui-notice">
		<div class="image"><img src="../addons/ewei_shopv2/static/images/hotdot.jpg"></div>
		<div class="icon"><i class="icon icon-notification1" style="font-size: 0.7rem;"></i></div>
		<div class="text">
			<ul>
				<?php  if(is_array($notices)) { foreach($notices as $item) { ?>
					<li>
						<a href="<?php  if(!empty($item['link'])) { ?><?php  echo $item['link'];?><?php  } else { ?><?php  echo mobileUrl('shop/notice/detail', array('id'=>$item['id']))?><?php  } ?>"><?php  echo $item['title'];?></a>
					</li>
				<?php  } } ?>
			</ul>
		</div>
	</div>
	<?php  if(count($notices)>1) { ?>
		<script type="text/javascript">
			function autoScroll(obj){
				$(obj).find("ul").animate({  
					marginTop : "-1rem"  
				},500,function(){  
					$(this).css({marginTop : "0px"}).find("li:first").appendTo(this);  
				})  
			}  
			$(function(){  
				setInterval('autoScroll(".fui-notice .text")',3000);
			}) 
		</script>
	<?php  } ?>
<?php  } ?>

<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+4-->