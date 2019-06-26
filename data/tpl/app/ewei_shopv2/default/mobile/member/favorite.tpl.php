<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<style>

	.member-cart-page .fui-radio{

		position: static;

	}

</style>

<div class='fui-page  fui-page-current member-cart-page'>

    <div class="fui-header">

	<div class="fui-header-left">

	    <a class="back"></a>

	</div>

	<div class="title">我的关注</div> 

	<div class="fui-header-right" >

		<a class="btn-edit" style="display: none;">编辑</a>

	</div>

    </div>



    <div class='fui-content ' >



		<div class='content-empty' style='display:none;'>

			 <i class='icon icon-like'></i><br/>您还没有关注任何商品，何不现在就去逛逛~<br/><a href="<?php  echo mobileUrl()?>" class='btn btn-default-o external'>去逛逛吧~</a>

		</div>

		  <div class='fui-list-group container' style="display:none;margin-top: 0"></div>

		  <div class='infinite-loading'><span class='fui-preloader'></span><span class='text'> 正在加载...</span></div>

		</div>

		<div class="fui-footer editmode">

		<div class="fui-list noclick">

			<div class="fui-list-media">

			<label class="checkbox-inline editcheckall"><input type="checkbox" name="checkbox" class="fui-radio fui-radio-danger " />&nbsp;全选</label>

			</div>

			<div class="fui-list-inner"></div>



			<div class='fui-list-angle'>

			<div class="btn  btn-danger btn-delete  disabled">删除</div>

			</div>

		</div>

    </div>

 

    <script id="tpl_member_favorite_list" type="text/html">

	 

	    <%each list as g index%>

	    <div class="fui-list goods-item align-start" data-id="<%g.id%>" data-goodsid="<%g.goodsid%>">

				<div class="fui-list-media editmode">

				   <input type="checkbox" id="<%index%>" name="checkbox" class="fui-radio fui-radio-danger edit-item"/>

				</div>

				<div class="fui-list-media image-media" style="margin-left: 0">

					<a href="<?php  echo mobileUrl('goods/detail')?>&id=<%g.goodsid%>" >

					<img data-lazy="<%g.thumb%>" class="round">

					</a>

				</div>

				<div class="fui-list-inner">

					<a href="<?php  echo mobileUrl('goods/detail')?>&id=<%g.goodsid%>" data-nocache="true">

					<div class="subtitle">

					  <%g.title%>

					</div>

					</a>

					<div class="text" style="margin-bottom: .3rem;font-size: .75rem;"><span class="text-danger">￥<%g.marketprice%><%if g.productprice>0%></span> <span class='oldprice'>￥<%g.productprice%></span><%/if%></div>



				</div>

			<div class="favoritecover" style="width: 90%;position: absolute;top: 0;;right: 0;height: 100%;display: none"></div>

		</div>

		<%/each%>

    </script>

	<script language='javascript'>
	require(['biz/member/favorite'], function (modal) 
	{
        modal.init();
    });
    </script>

</div>



<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--913702023503242914-->