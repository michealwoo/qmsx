<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
        <script> document.documentElement.style.fontSize =document.documentElement.clientWidth/750*40 +"px";</script>
        <meta name="format-detection" content="telephone=no" />
        <title><?php  if(empty($this->merch_user)) { ?><?php  echo $_W['shopset']['shop']['name'];?><?php  } else { ?><?php  echo $this->merch_user['merchname']?><?php  } ?></title>
        <link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/static/js/dist/foxui/css/foxui.min.css?v=0.2">
        <link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/template/mobile/default/static/css/style.css?v=<?php  echo time()?>">
        <?php  if(is_h5app()) { ?>
        <link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/template/mobile/default/static/css/h5app.css?v=2.0.3">
        <?php  } ?>

        <link rel="stylesheet" type="text/css" href="<?php  echo EWEI_SHOPV2_LOCAL?>static/fonts/iconfont.css?v=2017070719">
        <!--<link rel="stylesheet" href="//at.alicdn.com/t/font_82607_e93d131lklr6n7b9.css">-->
        <script src="./resource/js/lib/jquery-1.11.1.min.js"></script>
       <script src='//res.wx.qq.com/open/js/jweixin-1.3.0.js'></script>
<!--   <script src="../addons/ewei_shopv2/static/js/dist/foxui/js/foxui.min.js"></script>-->
        <script src="<?php  echo EWEI_SHOPV2_LOCAL?>static/js/require.js"></script>
        <script src="<?php  echo EWEI_SHOPV2_LOCAL?>static/js/myconfig-app.js"></script>
        <script language="javascript">require(['core'],function(modal){modal.init({siteUrl: "<?php  echo $_W['siteroot'];?>",baseUrl: "<?php  echo mobileUrl('ROUTES')?>"})});</script>


        <?php  if(!empty($_W['shopset']['shop']['loading'])) { ?>
        <style>.fui-goods-group.block .fui-goods-item .image {background-image: url("<?php  echo tomedia($_W['shopset']['shop']['loading'])?>");}</style>
        <?php  } ?>

        <?php  if(!is_mobile() && !is_weixin() && !is_h5app()) { ?>
        <style type="text/css">
            body {
                position: absolute;;
                max-width: 750px;  margin:auto;
            }
            .fui-navbar {
                max-width:750px;
            }
            .fui-navbar,.fui-footer  {
                max-width:750px;
            }
            .fui-page.fui-page-from-center-to-left,
            .fui-page-group.fui-page-from-center-to-left,
            .fui-page.fui-page-from-center-to-right,
            .fui-page-group.fui-page-from-center-to-right,
            .fui-page.fui-page-from-right-to-center,
            .fui-page-group.fui-page-from-right-to-center,
            .fui-page.fui-page-from-left-to-center,
            .fui-page-group.fui-page-from-left-to-center {
                -webkit-animation: pageFromCenterToRight 0ms forwards;
                animation: pageFromCenterToRight 0ms forwards;
            }
        </style>
        <?php  } ?>

        <?php  if(is_h5app()) { ?>
            <style>
                .page-shop-goods_category .fui-header, .fui-page-group.statusbar .fui-statusbar, .fui-header, .page-goods-list .fui-header {background-color: <?php  echo $_W['shopset']['wap']['headerbgcolor'];?>;}
                .fui-header a.back:before {border-color: <?php  echo $_W['shopset']['wap']['headericoncolor'];?>;}
                .fui-header .title {color: <?php  echo $_W['shopset']['wap']['headercolor'];?>;}
                .fui-header a, .fui-header i {color: <?php  echo $_W['shopset']['wap']['headericoncolor'];?>;}
                <?php  if(is_ios()) { ?>.head-menu-mask, .fui-mask, .fui-mask-m, .order-list-page .fui-tab {top: 3.2rem;}.head-menu{top: 3.65rem}<?php  } ?>
            </style>
        <?php  } ?>

        <style>.danmu {display: none;opacity: 0;}</style>
    </head>

    <body ontouchstart>

		<div class='fui-page-group <?php  if(is_ios()) { ?>statusbar<?php  } ?>'>
            <?php  if(is_h5app()) { ?>
            <div class="fui-statusbar"></div>
            <?php  } ?>