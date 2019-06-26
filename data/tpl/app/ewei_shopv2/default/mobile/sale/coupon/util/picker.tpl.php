<?php defined('IN_IA') or exit('Access Denied');?><script id="tpl_coupons" type="text/html">
	<div class="coupon-picker option-picker">
		<div class="option-picker-inner coupon-picker">
			<div class="coupon-list mini">
				<%each wxcards as wxcard%>
					<div class="coupon-item  <%wxcard.color%>   "
						 data-couponname="<%wxcard.title%>"
						 data-contype="1"
						 data-wxid="<%wxcard.id%>"
						 data-wxcardid="<%wxcard.card_id%>"
						 data-wxcode="<%wxcard.code%>"
						 data-merchid="<%wxcard.merchid%>">
						<div class="coupon-dots">
							<i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i>
						</div>
						<div class="coupon-left">
							<div class="single"><%if wxcard.backpre%><span class="subtitle">￥</span><%/if%><%wxcard.backmoney%></div>
						</div>
						<div class="coupon-right">
							<div class="title"><%wxcard.title%></div>
							<div class="usetime">
								<div class="text">有效期:<%wxcard.timestr%></div>
							</div>
						</div>
						<div class="coupon-after">
							<div class="coupon-btn">选择</div>
						</div>
					</div>
				<%/each%>

				<%each coupons as coupon%>
				<div class="coupon-item  <%coupon.color%> "
					 data-contype="2"
					 data-couponname="<%coupon.couponname%>"
					 data-couponid="<%coupon.id%>"
					 data-merchid="<%coupon.merchid%>">
					<div class="coupon-dots">
						<i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i>
					</div>
					<div class="coupon-left">
						<div class="single"><%if coupon.backpre%><span class="subtitle">￥</span><%/if%><%coupon.backmoney%></div>
					</div>
					<div class="coupon-right">
						<div class="title"><%coupon.couponname%></div>
						<div class="usetime">
							<div class="text">有效期:<%coupon.timestr%></div>
						</div>
					</div>
					<div class="coupon-after">
						<div class="coupon-btn">选择</div>
					</div>
				</div>
				<%/each%>
			</div>
		</div>
		<div class="fui-navbar" style="z-index: 999">
			<a class="nav-item btn btn-default btn-cancel"  style="color: #666">不使用优惠券</a>
			<a class="nav-item btn btn-danger btn-confirm">确定使用</a>
		</div>
	</div>
</script>
<!--青岛易联互动网络科技有限公司-->