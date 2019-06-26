<?php defined('IN_IA') or exit('Access Denied');?><?php  $task_mode =intval(m('cache')->getString('task_mode', 'global'))?>

<?php  if($task_mode==0) { ?>

<script language='javascript'>

	$(function(){

		$.getJSON("<?php  echo mobileUrl('util/task')?>");

        <?php  if(p('task')) { ?>

            <?php  if(p('task')->get_unread()) { ?>

                <?php  if(p('task')->TasknewEntrance()) { ?>

                    var navs = $('.fui-navbar').find('a');

                    $.each(navs,function (i, v) {

                        var href = $(v).attr('href');



                        if (href.indexOf('&r=member')>0 && href.indexOf('&r=member.')<1){

                            var hasClass = $(v).hasClass('active');

                            if (!hasClass){

                                $(v).append('<span class="task-red-mark" style="background-color: #ff5555;position: absolute;width: 6.9px;height: 6.9px;border-radius: 50%;display: block;right: 1rem;top: 0.3rem"></span>');

                            }

                        }

                    });

                <?php  } ?>

                <?php  if(p('task')->TaskTopNotice()) { ?>

                    var tophtml = '<div class="task-hint"><a href="<?php  echo mobileUrl('task.reward');?>">您有一个新的任务奖励没有领取，点此去领取~~</a><span>忽略</span></div>';

                    //加载顶部栏

                    $('body').append(tophtml);

                    $('.task-hint span').click(function () {

                        $('.task-hint').css('display', 'none');

                        $.ajax({

                            url:'<?php  echo mobileUrl('task.set_read')?>',

                        });

                    })

                <?php  } ?>



            <?php  } ?>

        <?php  } ?>

	})

</script>

<?php  } ?>



<script language="javascript">

	require(['init']);

	setTimeout(function () {

		if($(".danmu").length>0){

			$(".danmu").remove();

		}

	}, 500);

</script>



<?php  if(is_weixin()) { ?>

<script language='javascript'>

	var width = window.screen.width *  window.devicePixelRatio;

	var height = window.screen.height *  window.devicePixelRatio;

	var h = document.body.offsetHeight *  window.devicePixelRatio;



	if(height==2436 && width==1125){

		$(".fui-navbar,.cart-list,.fui-footer,.fui-content.navbar").addClass('iphonex')

	}

	if(h == 1923){

        $(".fui-navbar,.cart-list,.fui-footer,.fui-content.navbar").removeClass('iphonex');

	}

</script>

<?php  } ?>

<?php  if(is_h5app()) { ?>

	<?php  $this->shopShare()?>

	<script language='javascript'>

		require(['biz/h5app'], function (modal) {

			modal.init({

				share: <?php  echo json_encode($_W['shopshare'])?>,

				backurl: "<?php  echo $_GPC['backurl'];?>",

				statusbar: "<?php  echo intval($_W['shopset']['wap']['statusbar'])?>",

				payinfo: <?php  echo json_encode($payinfo)?>

			});

			<?php  if($initWX) { ?>

			modal.initWX();

			<?php  } ?> 

		});



	</script>

	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('headmenu', TEMPLATE_INCLUDEPATH)) : (include template('headmenu', TEMPLATE_INCLUDEPATH));?>

<?php  } ?>



<?php  $this->wapQrcode()?>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_share', TEMPLATE_INCLUDEPATH)) : (include template('_share', TEMPLATE_INCLUDEPATH));?>



<?php $merchid = !empty($goods['merchid'])?$goods['merchid']:$_GPC['merchid']?>



<?php  if(!$hideLayer) { ?>

	<?php $this->diyLayer(true, $diypage, $merchid?$merchid:false)?>

<?php  } ?>



<?php  if(!$hideGoTop) { ?>

	<?php  $this->diyGotop(true, $diypage)?>

<?php  } ?>





<?php  if(p('live')) { ?>

	<?php  $this->backliving()?>

<?php  } ?>



<span style="display:none"><?php  echo $_W['shopset']['shop']['diycode'];?></span>

</body>

</html>

