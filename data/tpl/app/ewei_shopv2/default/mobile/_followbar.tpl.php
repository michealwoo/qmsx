<?php defined('IN_IA') or exit('Access Denied');?>	<div class="fui-list follow_topbar">
	   	<div class="fui-list-media">
	   		<img class="round" src="<?php  if(!empty($followbar['share_member'])) { ?><?php  echo $followbar['share_member']['avatar'];?><?php  } else { ?><?php  echo $followbar['shoplogo'];?><?php  } ?>">
	   	</div>
	    <div class="fui-list-inner">
	    	<div class="text"><?php  if(!empty($followbar['share_member'])) { ?> 来自好友 <span class="text-warning"><?php  echo $followbar['share_member']['nickname'];?></span> 的推荐  <?php  } else { ?> 欢迎进入 <?php  echo $followbar['shopname'];?> <?php  } ?> <br> 关注公众号，享专属服务</div>
	    </div>
   		<div class="fui-list-angle">
   			<a class="btn btn-success external" data-followurl="<?php  echo $followbar['followurl'];?>" data-qrcode="<?php  echo $followbar['qrcode'];?>" id="followbtn">立即关注</a>
   		</div> 
   	</div>
   	
   	<div class="follow_hidden" style="display: none;">
		<div class="verify-pop">
		    <div class="close"><i class="icon icon-roundclose"></i></div>
		    <div class="qrcode" style="height: 250px;">
				<img class="qrimg" src="" />
		    </div>
		    <div class="tip">
		    	<p class="text-white">长按识别二维码关注</p>
		    	<p class="text-warning"><?php  echo $_W['shopset']['shop']['name'];?></p> 
		    </div>
		</div>
	</div>
   	
   	<script>
   		$(function(){
   			var _followbtn = $("#followbtn");
   			var _followurl = _followbtn.data("followurl");
   			var _qrcode = _followbtn.data("qrcode");
   			_followbtn.click(function(){
   				if(_qrcode){
   					$('.verify-pop').find('.qrimg').attr('src', _qrcode).show();
   					follow_container = new FoxUIModal({
   						content: $(".follow_hidden").html(),
   						extraClass: "popup-modal",
   						maskClick:function(){
   							follow_container.close();
   						}
   					});
   					follow_container.show();
   					$('.verify-pop').find('.close').unbind('click').click(function () {
		        		follow_container.close();
		        	});
   				}
   				else if(_followurl){
					window.open(_followurl);
   				}
   				return;
   			});
   		});
   	</script>
   	

<!--913702023503242914-->