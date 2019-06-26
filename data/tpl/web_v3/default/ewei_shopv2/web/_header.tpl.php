<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header_base', TEMPLATE_INCLUDEPATH)) : (include template('_header_base', TEMPLATE_INCLUDEPATH));?>


<?php  $system=m('system')->init()?>

<?php  $sysmenus = m('system')->getMenu(true)?>

<?php  $notice_redis_click = m('common')->getSysset('notice_redis')?>

<?php  $wxpaycert_view_click = m('common')->getSysset('wxpaycert_view')?>

<!--多商户图片选择器删除图片没有方法解决  只能在此隐藏-->

<?php  if(strpos( $_W['script_name'] , 'merchant' ) != false) { ?>

<style>

    .del{

        opacity:0;

    }

</style>

<?php  } ?>

<div class="wb-header" style="position: fixed;">

    <div class="logo <?php  if(!empty($system['foldnav'])) { ?>small<?php  } ?>">

        <?php  if(!empty($copyright) && !empty($copyright['logo'])) { ?>

            <img class='logo-img' src="<?php  echo tomedia($copyright['logo'])?>" onerror="this.src='../addons/ewei_shopv2/static/images/nologo.png'"/>

        <?php  } ?>

    </div>

    <ul>

        <li>

            <a href="<?php  echo webUrl()?>" data-toggle="tooltip" data-placement="bottom" title="管理首页"><i class="icow icow-homeL"></i></a>

        </li>

        <li class="wb-shortcut"><a id="showmenu"><i class="icow icow-list"></i></a></li>

    </ul>

    <div class="wb-topbar-search expand-search" id="navwidth">

        <form action="" id="topbar-search">

            <input type="hidden" name="c" value="site" />

            <input type="hidden" name="a" value="entry" />

            <input type="hidden" name="m" value="ewei_shopv2" />

            <input type="hidden" name="do" value="web" />

            <input type="hidden" name="r" value="search" />

            <div class="input-group">

                <input type="text" placeholder="请输入关键词进行功能搜索..." class="form-control wb-search-box" maxlength="15" name="keyword" <?php  if($system['merch']) { ?> data-merch="1"<?php  } ?> />

                <span class="input-group-btn">

                    <a class="btn wb-header-btn"><i class="icow icow-sousuo-sousuo"></i></a>

                </span>

            </div>

        </form>

        <div class="wb-search-result">

            <ul></ul>

        </div>

    </div>

    <div class="wb-header-flex"></div>



    <ul>

        <?php  if($system['right_menu']['system']) { ?>

            <!--<li data-toggle="tooltip" data-placement="bottom" title="">-->

                <!--<a href="<?php  echo webUrl('system')?>">-->

                    <!--系统管理-->

                <!--</a>-->

            <!--</li>-->

        <?php  } ?>

        <?php  if(p('app')) { ?>

            <?php  $appsets = p('app')->getGlobal()?>

            <?php  if(!empty($appsets['mmanage']['qrcode'])) { ?>

                <?php  $appqrcode = tomedia($appsets['mmanage']['qrcode'])?>

            <?php  } ?>

        <?php  } ?>



		<?php  if(!empty($appqrcode)) { ?>

	        <li   class="wxcode_box">

	            <i class="icow icow-erweima2" style="margin-right: 10px"></i>手机管理后台

	            <img src="../addons/ewei_shopv2/static/images/new.gif" alt=""  style="margin-top: -10px ">

	            <div class="wx_code">

	                <img src="<?php  echo $appqrcode;?>" alt="">

	                <div class="text">扫码登录小程序管理后台</div>

	            </div>

	        </li>



        <?php  } ?>

        <?php  if($_W['role'] == 'founder') { ?>

        <li>

            <a href="<?php  echo webUrl('system')?>" >

                <i class="icow icow-qiehuan" style="margin-right: 10px;color: #f34347"></i>系统管理

            </a>

        </li>

        <?php  } ?>

        <li class="dropdown <?php  if($system['merch']) { ?>auto<?php  } ?> ellipsis">

            <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                <?php  if(strlen($system['right_menu']['menu_title'])>60) { ?>

                <?php  echo substr($system['right_menu']['menu_title'],0,60).'...'?>

                <?php  } else { ?>

                <?php  echo $system['right_menu']['menu_title'];?>

                <?php  } ?>

                <span></span>

            </a>


            <ul class="dropdown-menu" <?php  if($system['routes']['0']=='system') { ?>style="width:100%;left:0"<?php  } ?>>

                <?php  if($system['routes']['0']!='system') { ?>

                <?php  if(is_array($system['right_menu']['menu_items'])) { foreach($system['right_menu']['menu_items'] as $right_menu_item) { ?>

                    <?php  if(!is_array($right_menu_item)) { ?>

                    <?php  } else { ?>

                        <li>

                            <a href="<?php  echo $right_menu_item['href'];?>" <?php  if($right_menu_item['blank']) { ?>target="_blank"<?php  } ?>>

                                <i class="icow <?php  echo $right_menu_item['icow'];?> " style="font-size: 30px;"></i>

                                <span style="display: block"><?php  echo $right_menu_item['text'];?></span>

                            </a>

                        </li>

                    <?php  } ?>

                <?php  } } ?>

                <li <?php  if($system['merch']) { ?> style="display: none" <?php  } ?>><a href="./index.php?c=account&a=display&">返回系统</a></li>

                <?php  } else { ?>

                <li style="margin-top: 0;height: 50px;line-height: 50px;<?php  if($system['merch']) { ?>display: none<?php  } ?>"><a href="./index.php?c=account&a=display&">返回系统</a></li>

                <?php  } ?>

            </ul>

        </li>

        <li data-toggle="tooltip" data-placement="bottom" title="退出登录" data-href="<?php  echo $system['right_menu']['logout'];?>">

            <a class="wb-header-logout"><i class="icow icow-exit"></i></a>

        </li>

    </ul>



    <div class="fast-nav <?php  if(!empty($system['foldnav'])) { ?>indent<?php  } ?>">

        <?php  if(!empty($system['history'])) { ?>

            <div class="fast-list history">

                <span class="title">最近访问</span>

                <?php  if(is_array($system['history'])) { foreach($system['history'] as $history_item) { ?>

                    <a href="<?php  echo $history_item['url'];?>"><?php  echo $history_item['title'];?></a>

                <?php  } } ?>

                <a href="javascript:;" id="btn-clear-history" <?php  if($system['merch']) { ?> data-merch="1"<?php  } ?>>清除最近访问</a>

            </div>

        <?php  } ?>

        <div class="fast-list menu">

            <span class="title">全部导航</span>

            <?php  if(is_array($sysmenus['shopmenu'])) { foreach($sysmenus['shopmenu'] as $index => $shopmenu) { ?>

                <a href="javascript:;" <?php  if($index==0) { ?>class="active"<?php  } ?> data-tab="tab-<?php  echo $index;?>"><?php  echo $shopmenu['title'];?></a>

            <?php  } } ?>

            <?php  if(!empty($system['funbar']['open']) && empty($system['merch'])) { ?>

                <a href="javascript:;" class="bold" data-tab="funbar">自定义快捷导航</a>

            <?php  } ?>

        </div>

        <div class="fast-list list">

            <?php  if(is_array($sysmenus['shopmenu'])) { foreach($sysmenus['shopmenu'] as $index => $shopmenu) { ?>

                <div class="list-inner <?php  if($index==0) { ?>in<?php  } ?>" data-tab="tab-<?php  echo $index;?>">

                    <?php  if(is_array($shopmenu['items'])) { foreach($shopmenu['items'] as $shopmenu_item) { ?>

                        <a href="<?php  echo $shopmenu_item['url'];?>"><?php  echo $shopmenu_item['title'];?></a>

                    <?php  } } ?>

                </div>

            <?php  } } ?>

            <?php  if(!empty($system['funbar']['open']) && empty($system['merch'])) { ?>

                <div class="list-inner" data-tab="funbar" id="funbar-list">

                    <?php  if(is_array($system['funbar']['data'])) { foreach($system['funbar']['data'] as $funbar_item) { ?>

                        <a href="<?php  echo $funbar_item['href'];?>" style="<?php  if($funbar_item['bold']) { ?>font-weight: bold;<?php  } ?> color: <?php  echo $funbar_item['color'];?>;"><?php  echo $funbar_item['text'];?></a>

                    <?php  } } ?>

                    <a href="javascript:;" class="text-center funbar-add-btn"><i class="fa fa-plus"></i> 添加快捷导航</a>

                    <?php  if(!empty($system['funbar']['data'])) { ?>

                        <a href="<?php  echo webUrl('sysset/funbar')?>" class="text-center funbar-add-btn"><i class="fa fa-edit"></i> 编辑快捷导航</a>

                    <?php  } ?>

                    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('funbar', TEMPLATE_INCLUDEPATH)) : (include template('funbar', TEMPLATE_INCLUDEPATH));?>

                </div>

            <?php  } ?>

        </div>

    </div>

</div>





    <!-- 一级导航 -->

    <div class="wb-nav <?php  if(!empty($system['foldnav'])) { ?>fold<?php  } ?>">

        <p class="wb-nav-fold"><i class="icow icow-zhedie"></i></p>

        <ul id="navheight">

            <?php  if(is_array($sysmenus['menu'])) { foreach($sysmenus['menu'] as $sysmenu) { ?>

                <li <?php  if($sysmenu['active']) { ?>class="active"<?php  } ?>>

                    <a href="<?php echo empty($sysmenu['index'])? webUrl($sysmenu['route']): webUrl($sysmenu['route']. '.'. $sysmenu['index'])?>">

                        <?php  if($sysmenu['route']=='plugins') { ?>

                        <svg class="iconplug" aria-hidden="true">

                            <use xlink:href="#icow-yingyong3"></use>

                        </svg>

                        <?php  } else { ?>

                            <?php  if(!empty($sysmenu['icon'])) { ?>

                                <i class="icow icow-<?php  echo $sysmenu['icon'];?>" <?php  if(!empty($sysmenu['iconcolor'])) { ?> style="color: <?php  echo $sysmenu['iconcolor'];?>"<?php  } ?>></i>

                            <?php  } ?>

                        <?php  } ?>

                        <?php  if($sysmenu['route'] == 'sysset') { ?>

                            <span class="wb-nav-title <?php  if(empty($notice_redis_click['notice_redis_click']) || !isset($notice_redis_click['notice_redis_click'])) { ?>point<?php  } ?>"><?php  echo $sysmenu['text'];?></span>

                        <?php  } else { ?>

                            <span class="wb-nav-title"><?php  echo $sysmenu['text'];?></span>

                        <?php  } ?>

                    </a>

                    <span class="wb-nav-tip"><?php  echo $sysmenu['text'];?></span>

                </li>

            <?php  } } ?>

            <?php  if($_W['role'] == 'founder') { ?>

            <?php  if($system['routes']['0']=='system') { ?>

            <li class="sysset">

                <?php  if(is_array($system['right_menu']['menu_items'])) { foreach($system['right_menu']['menu_items'] as $right_menu_item) { ?>

                    <?php  if(!is_array($right_menu_item)) { ?>

                    <?php  } else { ?>

                        <a href="<?php  echo $right_menu_item['href'];?>" <?php  if($right_menu_item['blank']) { ?>target="_blank"<?php  } ?>>

                            <i class="icow <?php  echo $right_menu_item['icow'];?>"></i>

                            <span class="wb-nav-title"><?php  echo $right_menu_item['text'];?></span>

                        </a>

                    <?php  } ?>

                <?php  } } ?>

            </li>

            <?php  } else { ?>

            <li class="sysset">

                <i class="icow icow-qiehuan"></i>

                <span class="wb-nav-title" data-href="">系统管理</span>

                <div class="syssetsub">

                    <div class="syssettitle">系统管理</div>

                    <a href="<?php  echo webUrl('system/plugin')?>"><i class="icow icow-plugins "></i>应用</a>

                    <a href="<?php  echo webUrl('system/copyright')?>"><i class="icow icow-banquan"></i>版权</a>

                    <a href="<?php  echo webUrl('system/data')?>"><i class="icow icow-statistics"></i>数据</a>

                    <a href="<?php  echo webUrl('system/site')?>"><i class="icow icow-wangzhan"></i>网站</a>

                    <a href="<?php  echo webUrl('system/auth')?>"><i class="icow icow-iconfont-shouquan"></i>授权</a>

                    <a href="<?php  echo webUrl('system/auth/upgrade')?>"><i class="icow icow-gengxin"></i>更新</a>

                    <span class="syssettips"></span>

                </div>

            </li>

            <?php  } ?>

            <?php  } ?>

        </ul>

    </div>

    <!--低分辨率一级导航显示不全问题 start-->

    <script>

        var navheight = document.getElementById('navheight');

        var navwidth = document.getElementById('navwidth')

        var vh = document.body.clientHeight;

        var vw = screen.width;

        if(vh < 800){

            navheight.classList.add("wb-navheight");

        } else {

            navheight.classList.remove("wb-navheight");

        }

        if(vw < 1300 ){

            navwidth.classList.add("wb-navwidth");

        }

    </script>

    <!--低分辨率一级导航显示不全问题 end-->

    <!-- 二级导航 -->

    <?php  if(!$no_left && !empty($sysmenus['submenu']['items'])) { ?>

        <div class="wb-subnav">

          <div style="width: 100%;height: 100%;overflow-y: auto">

              <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_tabs', TEMPLATE_INCLUDEPATH)) : (include template('_tabs', TEMPLATE_INCLUDEPATH));?>

              <div class="wb-subnav-fold icow"></div>

          </div>

        </div>

    <?php  } ?>

    <?php  if(!$no_right) { ?>

        <div class="wb-panel <?php  if(empty($system['foldpanel'])) { ?>in<?php  } ?>">

            <div class="panel-group" id="panel-accordion">

                <?php if(cv('order.list.status1|order.list.status4')) { ?>

                <div class="panel panel-default">

                    <div class="panel-heading" data-toggle="collapse" data-parent="#panel-accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">

                        <h4 class="panel-title">

                            <i class="icow icow-dingdan"></i> <a class="news">订单消息</a> <span></span>

                        </h4>

                    </div>

                    <div id="collapseOne" class="panel-collapse collapse <?php  if($_W['action']!='shop.comment' && $_W['routes']!='shop.index.notice' && ($_W['action']!='apply' && $_W['plugin']!='commission')) { ?>in<?php  } ?>" aria-labelledby="headingOne">

                        <ul class="panel-body">

                            <?php  if(!empty($system['order1'])) { ?>

                            <li class="panel-list">

                                <a class="panel-list-text" href="<?php  echo webUrl('order/list/status1')?>">待发货订单 <span class="pull-right text-warning">(<?php  echo $system['order1'];?>)</span> </a>

                            </li>

                            <?php  } ?>

                            <?php  if(!empty($system['order4'])) { ?>

                            <li class="panel-list">

                                <a class="panel-list-text" href="<?php  echo webUrl('order/list/status4')?>">维权订单<span class="pull-right text-danger">(<?php  echo $system['order4'];?>)</span></a>

                            </li>

                            <?php  } ?>

                            <?php  if(empty($system['order1'])&&empty($system['order4'])) { ?>

                            <li class="panel-list">

                                <div class="panel-list-text text-center">暂无消息提醒</div>

                            </li>

                            <?php  } ?>

                        </ul>

                    </div>

                </div>

                <?php  } ?>

                <div class="panel panel-default">

                    <div class="panel-heading" data-toggle="collapse" data-parent="#panel-accordion" href="#collapseSix" aria-expanded="true" aria-controls="collapseSix">

                        <h4 class="panel-title">

                            <i class="icow icow-dingdan"></i> <a class="news">报价消息</a> <span></span>

                        </h4>

                    </div>

                    <div id="collapseSix" class="panel-collapse collapse <?php  if($_W['action']!='shop.comment' && $_W['routes']!='shop.index.notice' && ($_W['action']!='apply' && $_W['plugin']!='commission')) { ?>in<?php  } ?>" aria-labelledby="headingOne">

                        <ul class="panel-body">

                            <?php  if(!empty($system['quoteTotal'])) { ?>

                            <li class="panel-list">

                                <a class="panel-list-text" href="<?php  echo webUrl('gonghuo')?>">未读报价信息 <span class="pull-right text-warning">(<?php  echo $system['quoteTotal'];?>)</span> </a>

                            </li>
                            <?php  } else { ?>

                            <li class="panel-list">

                                <div class="panel-list-text text-center">暂无消息提醒</div>

                            </li>

                            <?php  } ?>

                        </ul>

                    </div>

                </div>

                <div class="panel panel-default">

                    <div class="panel-heading" data-toggle="collapse" data-parent="#panel-accordion" href="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">

                        <h4 class="panel-title">

                            <i class="icow icow-dingdan"></i> <a class="news">竞价消息</a> <span></span>

                        </h4>

                    </div>

                    <div id="collapseSeven" class="panel-collapse collapse <?php  if($_W['action']!='shop.comment' && $_W['routes']!='shop.index.notice' && ($_W['action']!='apply' && $_W['plugin']!='commission')) { ?>in<?php  } ?>" aria-labelledby="headingOne">

                        <ul class="panel-body">

                            <?php  if(!empty($system['bidTotal'])) { ?>

                            <li class="panel-list">

                                <a class="panel-list-text" href="<?php  echo webUrl('gonghuo/bid_supplier')?>">未读竞价信息 <span class="pull-right text-warning">(<?php  echo $system['bidTotal'];?>)</span> </a>

                            </li>

                            <?php  } else { ?>

                            <li class="panel-list">

                                <div class="panel-list-text text-center">暂无消息提醒</div>

                            </li>

                            <?php  } ?>


                        </ul>

                    </div>

                </div>


                <?php  if($system['notice']!='none' && !$system['merch']) { ?>

                    <div class="panel panel-default">

                        <div class="panel-heading" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#panel-accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">

                            <h4 class="panel-title">

                                <i class="icow icow-gonggao"></i> <a>内部公告</a> <span></span>

                            </h4>

                        </div>

                        <div id="collapseTwo" class="panel-collapse collapse <?php  if($_W['routes']=='shop.index.notice') { ?>in<?php  } ?>" role="tabpanel" aria-labelledby="headingTwo">

                            <ul class="panel-body">

                                <?php  if(empty($system['notice'])) { ?>

                                <li class="panel-list small">

                                    <div class="panel-list-text text-center">暂无消息提醒</div>

                                </li>

                                <?php  } else { ?>

                                <?php  if(is_array($system['notice'])) { foreach($system['notice'] as $notice_item) { ?>

                                <li class="panel-list small">

                                    <a class="panel-list-text" href="javascript:;" data-toggle="ajaxModal" data-href="<?php  echo webUrl('shop/index/view', array('id'=>$notice_item['id']))?>" title="<?php  echo $notice_item['title'];?>"><?php  echo $notice_item['title'];?></a>

                                </li>

                                <?php  } } ?>

                                <li class="panel-list small" style="padding: 10px;">

                                    <a class="panel-list-text text-center" href="<?php  echo webUrl('shop/index/notice')?>"><span class="text-primary">查看更多</span></a>

                                </li>

                                <?php  } ?>

                            </ul>

                        </div>

                    </div>

                <?php  } ?>

                <?php  if(!$system['merch']) { ?>

                    <?php if(cv('commission.apply.view1|commission.apply.view2')) { ?>

                    <div class="panel panel-default">

                        <div class="panel-heading" role="tab" id="headingThree" data-toggle="collapse" data-parent="#panel-accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">

                            <h4 class="panel-title">

                                <i class="icow icow-yongjinmingxi"></i> <a>佣金提现</a> <span></span>

                            </h4>

                        </div>

                        <div id="collapseThree" class="panel-collapse collapse <?php  if($_W['action']=='apply' && $_W['plugin']=='commission') { ?>in<?php  } ?>" role="tabpanel" aria-labelledby="headingFour">

                            <ul class="panel-body">

                                <?php  if(!empty($system['commission1'])) { ?>

                                <li class="panel-list">

                                    <a class="panel-list-text" href="<?php  echo webUrl('commission/apply', array('status'=>1))?>">待审核申请<span class="pull-right text-warning">(<?php  echo $system['commission1'];?>)</span></a>

                                </li>

                                <?php  } ?>

                                <?php  if(!empty($system['commission2'])) { ?>

                                <li class="panel-list">

                                    <a class="panel-list-text" href="<?php  echo webUrl('commission/apply', array('status'=>2))?>">待打款申请<span class="pull-right text-danger">(<?php  echo $system['commission2'];?>)</span></a>

                                </li>

                                <?php  } ?>

                                <?php  if(empty($system['commission1'])&&empty($system['commission2'])) { ?>

                                <li class="panel-list">

                                    <div class="panel-list-text text-center">暂无消息提醒</div>

                                </li>

                                <?php  } ?>

                            </ul>

                        </div>

                    </div>

                    <?php  } ?>

                <?php  } ?>

                <?php if(cv('shop.comment.edit')) { ?>

                <div class="panel panel-default">

                    <div class="panel-heading" role="tab" id="headingFour" data-toggle="collapse" data-parent="#panel-accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">

                        <h4 class="panel-title">

                            <i class="icow icow-pingjia"></i> <a>评价</a> <span></span>

                        </h4>

                    </div>

                    <div id="collapseFour" class="panel-collapse collapse <?php  if($_W['action']=='shop.comment') { ?>in<?php  } ?>" role="tabpanel" aria-labelledby="headingFour">

                        <ul class="panel-body">

                            <?php  if(empty($system['comment'])) { ?>

                            <li class="panel-list">

                                <div class="panel-list-text text-center">暂无消息提醒</div>

                            </li>

                            <?php  } else { ?>

                            <li class="panel-list">

                                <a class="panel-list-text" href="<?php  echo webUrl('shop/comment')?>">待审核评价<span class="pull-right text-warning">(<?php  echo $system['comment'];?>)</span></a>

                            </li>

                            <?php  } ?>

                        </ul>

                    </div>

                </div>

                <?php  } ?>

                <!--系统更新-->

                <?php  if($_W['isfounder'] && $_W['routes']!='system.auth.upgrade' && $_W['role'] !='vice_founder') { ?>

                <div class="panel panel-default">

                    <div class="panel-heading" role="tab" id="headingFive" data-toggle="collapse" data-parent="#panel-accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseThree">

                        <h4 class="panel-title">

                            <i class="icow icow-lingdang1"></i> <a style="position:relative;">系统提示 <i class="systips"></i></a> <span></span>

                        </h4>

                    </div>

                    <div id="collapseFive" class="panel-collapse collapse <?php  if($_W['action']=='shop.comment') { ?>in<?php  } ?>" role="tabpanel" aria-labelledby="headingFour">

                        <ul class="panel-body">

                            <li class="panel-list">

                                <div class="panel-list-text nomsg">暂无消息提醒</div>

                                <div class="panel-list-text upmsg" style="display: none; max-height: none;">

                                    <div>检测到更新</div>

                                    <div>新版本 <span id="sysversion">------</span></div>

                                    <div>新版本 <span id="sysrelease">------</span></div>

                                    <div>

                                        <a class="text-primary" href="<?php  echo webUrl('system/auth/upgrade')?>">立即更新</a>

                                        <a class="text-warning" href="javascript:check_ewei_shopv2_upgrade_hide();" style="margin-left: 15px;">暂不提醒</a>

                                    </div>

                                </div>

                            </li>

                        </ul>

                    </div>

                </div>

                <?php  } ?>

            </div>

        </div>

        <div class="wb-panel-fold <?php  if(empty($system['foldpanel'])) { ?>in<?php  } ?>"><?php  if(!empty($system['foldpanel'])) { ?><i class="icow icow-info"></i> 消息提醒<?php  } else { ?><i class="fa fa-angle-double-right"></i> 收起面板<?php  } ?></div>

    <?php  } ?>

    <div class="wb-container <?php  if(!empty($system['foldpanel'])) { ?>right-panel<?php  } ?>">