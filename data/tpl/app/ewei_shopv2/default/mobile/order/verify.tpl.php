<?php defined('IN_IA') or exit('Access Denied');?><div class="order-verify-hidden" style="display: none;">
	<!--<div class="verify-pop">-->
	    <!--<div class="close" <?php  if(is_h5app()) { ?>style="top: 2rem;"<?php  } ?>><i class="icon icon-roundclose"></i></div>-->
	    <!--<div class="qrcode">-->
		<!--<div class="loading"><i class="icon icon-qrcode1"></i> 正在生成二维码</div>-->
		<!--<img class="qrimg" src="" />-->
	    <!--</div>-->
	    <!--<div class="tip">-->
	    	<!--<p>如果无法扫描?</p>-->
	    	<!--<p>请使用消费码或自提码核销</p>-->
	    	<!--<p>(请将此二维码出示给店员进行核销)</p>-->
	    <!--</div>-->
	<!--</div>-->
	<div class="verify-pop">
	<div class="code_box">
		<p>请将二维码出示给核销员</p>
		<div class="img_box">
			<img class="qrimg" src=""/>
		</div>
		<div class="cav_code"><?php  echo $verifycode;?></div>
		<div class="error">
			<p style="padding: 0 1.3rem">温馨提示：为了更好的保护您利益,请不要轻易将您的核销二维码泄露给他人</p>
		</div>
	</div>
	</div>
</div>
<!--NDAwMDA5NzgyNw==-->