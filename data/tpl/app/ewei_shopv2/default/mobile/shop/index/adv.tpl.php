<?php defined('IN_IA') or exit('Access Denied');?><style type="text/css">
    #show-area{
        width: 100%;
        height:auto;
        position:relative;
        margin:0px auto;
        overflow:hidden;
    }
    /*注意：找bug找了很久，这里自动插入一张，父容器要加上他的宽度，否则怎么显示呢？小问题大解决*/
    #show-area ul{
        position:relative;
        height:auto;
        right:0;
    }
    #show-area ul li{
        width:100%;
        float:left;
    }
    /*指示器*/
    #indicator{
        width:140px;
        text-align:center;
        position:absolute;
        top:450px;
        left:0;
        right: 0;
        margin: auto;
        z-index:1;
        /*ackground-color: #00ccff;*/
    }
    #indicator div{
        height:12px;
        width:12px;
        border-radius:100%;
        background-color:#ccc;
        float:left;
        margin-left:5px;
        opacity:0.9;
        filter:Alpha(opacity=90);/*为了适应旧的浏览器*/
    }
    #button-left,#button-right{
        /*display:none;*/
        position: absolute;
        width: 50px;
        height: 110px;
        z-index: 2;
        background-color: #cccccc;
        font-size: 40px;
        color: #FFFFFF;
        text-align: center;
        line-height: 110px;
        opacity:0;
        filter:Alpha(opacity=50);/*为了适应旧的浏览器*/
        cursor: default;
    }
    #button-left{
        top:180px;
        left:0px;
    }
    #button-right{
        top:180px;
        left:16rem;
    }
    .onclick{
        background-color:#FFF !important;
    }

    #show-area ul li a img,
    #show-area ul li a video{
        height: 187px;
    }
</style>

<?php  if(!empty($advs)) { ?>

	<div id="show-area" class='fui-swipe'>
	    <ul class='fui-swipe-wrapper'>
	        <?php  if(is_array($advs)) { foreach($advs as $item) { ?>
	          <?php  if($item['isvideo']==1) { ?>
	            <li class='fui-swipe-item'>
		             <a href="javascript:;">
		               <video class="video" autoplay="autoplay" controls="controls" src="<?php  echo $item['link'];?>"></video>
		             </a>
	            </li>
	          <?php  } else { ?>
	            <li class='fui-swipe-item'><a href="javascript:;"><img src="<?php  echo tomedia($item['thumb'])?>" <?php  if(!empty($item['link'])) { ?> onclick="location.href='<?php  echo $item['link'];?>'" <?php  } ?>/></a></li>
	          <?php  } ?>
	        <?php  } } ?>
	    </ul>

	    <!-- <div id="button-left" title="上一张"><</div>
	    <div id="button-right" title="下一张">></div> -->

	   <!--  <div id="indicator"></div> -->
	    <!--控制按钮,为了日后方便后台操作这里的控制按钮在js代码中控制添加-->
	</div>

<?php  } ?>

<script>
    $(function () {
 
        /*设置鼠标移动到整个show区域则左右按钮显示出来，否则不显示*/
        $("#show-area").mouseenter(function () {
            $("#button-right,#button-left").css({opacity:0.5});
        });
        $("#show-area").mouseleave(function () {
            $("#button-right,#button-left").css({opacity:0});
        });
 
        var i=0;
        /*假装自己很智能，自动获取一下，在后面left值移动时就可以用它了*/
        var imgWidth = $("#show-area ul li").width();
        var clone = $("#show-area ul li").first().clone(true);
        /*copy 第一张的照片并且添加到最后已达到无缝对接的效果*/
        $("#show-area ul").append(clone);
 
        /*get 所有li的个数,只有length才是属性*/
        var size = $("#show-area ul li").length;

        /*step 1:  */
        //一开始循环添加按钮
        //为什么要size - 1？因为最后一张图片只是作一个过渡效果我们显示的始终还是4张图片
        //所以添加按钮的时候我们也应该添加4个按钮
        for(var j=0;j<size -1 ;j++){
            $("#indicator").append("<div></div>");
        }
 
        $("#indicator div").eq(i).addClass("onclick");
 
 
        /*step 2:  */
        //左按钮
        $("#button-left").click(function () {
            toLeft();
        });
        //右按钮
        $("#button-right").click(function () {
            toRight();
        });
 
        /*step 3：*/
        //按钮指示器鼠标移出移入事件
        $("#indicator div").hover(function () {
            i = $(this).index();
            clearInterval(timer);
            $("#show-area ul").stop().animate({left:-i * imgWidth});
            $(this).addClass("onclick").siblings().removeClass("onclick");
 
        },function () {
            timer = setInterval(function () {
                toRight();
            },5000)
        });
 
        //两个方向按钮鼠标移出移入事件
        $("#button-left,#button-right").mouseenter(function () {
            clearInterval(timer);
        }).mouseleave(function () {
            timer = setInterval(function () {
                toRight();
            },5000);
        });
 
        //定时器,注意，这里是最开始启动的，所以呢，这里不设值，会导致页面开始刷新出现错误。
         var timer = setInterval(function () {
            toRight();
        },5000);
 
 
        /*step 2-2*/
        //左按钮实现的函数
        function toLeft(){
 
            //同理，如果当前图片位置是第一张图片我再按一下右按钮那么我们也利用css的快速变换使它的位置来到最后一张图片的位置（size-1），并且让倒数第二张图片滑动进来
            i--;
            if(i==-1){
                $("#show-area ul").css({left:-(size - 1)*imgWidth});
                i=size-2;
            }
            $("#show-area ul").animate({left:-i*imgWidth},1000);
            $("#indicator div").eq(i).addClass("onclick").siblings().removeClass("onclick");
 
        }
 
        /*step2-2:*/
        //右按钮的实现函数
        function toRight() {
            i++;
            /*当前图片为最后一张图片的时候（我们一开始复制并且添加到ul最后面的图片）
            并且再点击了一次左按钮，这时候我们就利用css的快速转换效果把ul移动第一张图片的位置
            并且第二张图片滑入达到无缝效果（css的变换效果很快我们肉眼是很难看见的）*/
            if(i==size){
                console.log("qq");
                $("#show-area ul").css({left:0});
                i=1;
            }
 
            $("#show-area ul").stop().animate({left: -i * imgWidth}, 1000);
 
            //设置下面指示器的颜色索引
            if(i == size-1){
                $("#indicator div").eq(0).addClass("onclick").siblings().removeClass("onclick");
 
            }else{
                $("#indicator div").eq(i).addClass("onclick").siblings().removeClass("onclick");
            }
        }
 
    });
</script>
<!--青岛易联互动网络科技有限公司-->