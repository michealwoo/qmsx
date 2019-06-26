<?php defined('IN_IA') or exit('Access Denied');?><div id="recommand"></div>

<div class='infinite-loading' style="text-align: center; color: #666;">
	<span class='fui-preloader'></span>
	<span class='text'> 正在加载...</span>
</div>

<script type="text/html" id="tpl_recommand">

	<%if list!=''%>

		<%if page==1%>

			<div class="fui-line" style="background: #f4f4f4;">

				<div class="text text-danger"><i class="icon icon-hotfill"></i> 店铺推荐</div>

			</div>

			<div class="fui-goods-group block border">

		<%/if%>

			<%each list as item%>

				<div class="fui-goods-item" data-goodsid="<%item.id%>" data-type="<%item.type%>">

					<a <%if item.bargain>0%>href="<?php  echo mobileUrl('bargain/detail')?>&id=<%item.bargain%>"<%/if%><%if item.bargain<=0 && item.type!=9%>href="<?php  echo mobileUrl('goods/detail')?>&id=<%item.id%>"<%else%>href="<?php  echo mobileUrl('cycelbuy/goods/detail')?>&id=<%item.id%>" <%/if%>>

						<div class="image" data-lazy-background="<%item.thumb%>">

				   		   <%if item.cansee<=0 && item.seecommission<=0%>



							<?php  if(!empty($_W['shopset']['shop']['saleout'])) { ?>



							<%if item.total<=0%><div class="salez" style="background-image: url('<?php  echo tomedia($_W['shopset']['shop']['saleout'])?>'); "></div><%/if%>



							<?php  } else { ?>



							<%if item.total<=0%><div class="salez" style="background-image: url('<?php  echo tomedia('../addons/ewei_shopv2/static/images/shouqin.png')?>'); "></div><%/if%>



							<?php  } ?>



							<%/if%>



							<!--分销佣金-->



							<%if item.cansee>0 && item.seecommission>0%>



							<div class="goods-Commission"><%item.seetitle || "预计最高佣金"%>￥<%item.seecommission%> </div>



							<%/if%>



						</div>



					</a>



					<div class="detail">



						<a <%if item.bargain>0%>href="<?php  echo mobileUrl('bargain/detail')?>&id=<%item.bargain%>"<%/if%><%if item.bargain<=0 && item.type!=9%>href="<?php  echo mobileUrl('goods/detail')?>&id=<%item.id%>"<%else%>href="<?php  echo mobileUrl('cycelbuy/goods/detail')?>&id=<%item.id%>" <%/if%>>

							<div class="name">

								<%if item.ispresell==1%><i class="fui-tag fui-tag-danger">预售</i><%/if%>

								<%if item.type == 9%><span class="cycle-tip">周期购</span><%/if%>

								<%item.title%>

							</div>

						</a>


						<div class="price" style="margin-top: 0.3rem">

							<span class="text">￥<%item.marketprice.toFixed(2)%></span>

							<%if item.type == 9%>

							<a href="<?php  echo mobileUrl('cycelbuy/goods/detail')?>&id=<%item.id%>"><span class="cycelbuy">详情</span></a>

							<%else%>

							<span class="buy<%if item.bargain>0%> bargain-btn<%/if%>" data-type="<%item.type%>" ><%if item.bargain>0%>砍价活动<%else%>购买<%/if%></span>



							<%/if%>

						</div>

					</div>

				</div>


			<%/each%>


		<%if page==1%>



			</div>



		<%/if%>



	<%/if%>



</script>



<script language='javascript'>



	require(['biz/shop/index'], function (modal) {modal.init({merchid:<?php  echo intval($_GPC['merchid'])?>})});



</script>