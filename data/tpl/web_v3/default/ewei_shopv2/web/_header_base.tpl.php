<?php defined('IN_IA') or exit('Access Denied');?><?php  $copyright = m('common')->getCopyright(true)?>
<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php  if(!empty($copyright) && !empty($copyright['title'])) { ?><?php  echo $copyright['title'];?><?php  } ?></title>
        <link rel="shortcut icon" href="<?php  echo $_W['siteroot'];?><?php  echo $_W['config']['upload']['attachdir'];?>/<?php  if(!empty($_W['setting']['copyright']['icon'])) { ?><?php  echo $_W['setting']['copyright']['icon'];?><?php  } else { ?>images/global/wechat.jpg<?php  } ?>" />
        <link href="<?php  echo EWEI_SHOPV2_LOCAL?>static/css/bootstrap.min.css?v=3.3.7" rel="stylesheet">
        <link href="<?php  echo EWEI_SHOPV2_LOCAL?>static/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
        <link href="<?php  echo EWEI_SHOPV2_LOCAL?>static/css/animate.css" rel="stylesheet">
        <link href="<?php  echo EWEI_SHOPV2_LOCAL?>static/css/v3.css?v=4.1.0" rel="stylesheet">
        <link href="<?php  echo EWEI_SHOPV2_LOCAL?>static/css/common_v3.css?v=3.0.1" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php  echo EWEI_SHOPV2_LOCAL?>static/fonts/v3/iconfont.css?v=2016070717">
        <link rel="stylesheet" type="text/css" href="<?php  echo EWEI_SHOPV2_LOCAL?>static/fonts/iconfont.css?v=2016070717">
        <link rel="stylesheet" type="text/css" href="<?php  echo EWEI_SHOPV2_LOCAL?>static/fonts/wxiconx/iconfont.css?v=2016070717">
        <!--<link rel="stylesheet" href="//at.alicdn.com/t/font_244637_dkvlqrgjbde1m7vi.css">-->
        <script src="<?php  echo EWEI_SHOPV2_LOCAL?>static/fonts/v3/iconfont.js"></script>

        <script src="./resource/js/lib/jquery-1.11.1.min.js"></script>
        <script src="<?php  echo EWEI_SHOPV2_LOCAL?>static/js/dist/jquery/jquery.gcjs.js"></script>
        <script src="./resource/js/app/util.js"></script>


        <script type="text/javascript">
            window.sysinfo = {
            <?php  if(!empty($_W['uniacid'])) { ?>'uniacid': '<?php  echo $_W['uniacid'];?>',<?php  } ?>
            <?php  if(!empty($_W['acid'])) { ?>'acid': '<?php  echo $_W['acid'];?>',<?php  } ?>
            <?php  if(!empty($_W['openid'])) { ?>'openid': '<?php  echo $_W['openid'];?>',<?php  } ?>
            <?php  if(!empty($_W['uid'])) { ?>'uid': '<?php  echo $_W['uid'];?>',<?php  } ?>
            'isfounder': <?php  if(!empty($_W['isfounder'])) { ?>1<?php  } else { ?>0<?php  } ?>,
            'siteroot': '<?php  echo $_W['siteroot'];?>',
                    'siteurl': '<?php  echo $_W['siteurl'];?>',
                    'attachurl': '<?php  echo $_W['attachurl'];?>',
                    'attachurl_local': '<?php  echo $_W['attachurl_local'];?>',
                    'attachurl_remote': '<?php  echo $_W['attachurl_remote'];?>',
                    'module' : {'url' : '<?php  if(defined('MODULE_URL')) { ?><?php echo MODULE_URL;?><?php  } ?>', 'name' : '<?php  if(defined('IN_MODULE')) { ?><?php echo IN_MODULE;?><?php  } ?>'},
            'cookie' : {'pre': '<?php  echo $_W['config']['cookie']['pre'];?>'},
            'account' : <?php  echo json_encode($_W['account'])?>,
            };
        </script>


        <!-- 兼容微擎1.5.3 -->
        <?php  if(IMS_VERSION >= 1.5) { ?>
        <link href="<?php  echo EWEI_SHOPV2_LOCAL?>static/css/we7.common.css?v=1.0.0" rel="stylesheet">
        <script type="text/javascript" src="./resource/js/lib/bootstrap.min.js"></script>
        <script type="text/javascript" src="./resource/js/app/common.min.js?v=20170802"></script>
        <script type="text/javascript">if(util){util.clip = function(){}}</script>
        <?php  } ?>
        <!-- 兼容微擎1.6 -->
        <!-- 兼容微擎1.6 -->
        <?php  if(IMS_VERSION >= '1.7.2') { ?>
        <link href="<?php  echo EWEI_SHOPV2_LOCAL?>static/css/we7.common172.css?v=1.0.0" rel="stylesheet">
        <?php  } else if(IMS_VERSION >= '1.6.9') { ?>
        <link href="<?php  echo EWEI_SHOPV2_LOCAL?>static/css/we7.common169.css?v=1.0.0" rel="stylesheet">
        <?php  } ?>



        <script src="<?php  echo EWEI_SHOPV2_LOCAL?>static/js/require.js"></script>

        <?php  if(IMS_VERSION > 0.8 && IMS_VERSION != '1.0.0') { ?>
        <script src="<?php  echo EWEI_SHOPV2_LOCAL?>static/js/config1.0.js"></script>
        <?php  } else { ?>
        <script src="./resource/js/app/config.js"></script>
        <?php  } ?>

        <script>
            require.config({
                waitSeconds: 0
            });
        </script>
        <script src="<?php  echo EWEI_SHOPV2_LOCAL?>static/js/myconfig.js"></script>
        <script type="text/javascript">
                if (navigator.appName == 'Microsoft Internet Explorer') {
                    if (navigator.userAgent.indexOf("MSIE 5.0") > 0 || navigator.userAgent.indexOf("MSIE 6.0") > 0 || navigator.userAgent.indexOf("MSIE 7.0") > 0) {
                        alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
                    }
                }
                myrequire.path = "<?php  echo $_W['siteroot'];?>addons/ewei_shopv2/static/js/";

            function preview_html(txt)
            {
                var win = window.open("", "win", "width=300,height=600"); // a window object
                win.document.open("text/html", "replace");
                win.document.write($(txt).val());
                win.document.close();
            }
        </script>
    </head>

    <body>