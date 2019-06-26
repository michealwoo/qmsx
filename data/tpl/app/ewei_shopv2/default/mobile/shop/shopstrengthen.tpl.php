<?php defined('IN_IA') or exit('Access Denied');?><?php  if(!empty($order)) { ?>
<div id="unpaid" >
    <div class="unpaid-alert">
        <div class="unpaid-title">您有一个订单待支付</div>
        <div class="unpaid-subtitle">未支付的订单将在不久之后自动关闭，请尽快支付哦！</div>
        <div class="unpaid-content fui-list-group">
            <?php  if(is_array($goods)) { foreach($goods as $item) { ?>
                <div class="fui-list">
                    <div class="fui-list-media image-media">
                        <a>
                            <img class=""  src="<?php  echo tomedia($item['thumb'])?>">
                        </a>
                    </div>
                    <div class="fui-list-inner">
                        <a>
                            <div class="subtitle">
                                <?php  echo $item['title'];?>
                            </div>
                        </a>
                        <div class="price">
                            <span class="bigprice text-danger">￥<span class="marketprice"><?php  echo $item['marketprice'];?>  </span> </span><span style="float:right;color:#999;font-size:.6rem">x <?php  echo $item['totals'];?></span>
                        </div>
                    </div>
                </div>
            <?php  } } ?>
            <?php  if($goodstotal>3) { ?>
                <div class="fui-list">
                    等多件商品
                </div>
            <?php  } ?>
        </div>
        <a id="btn-pay" href="<?php  echo mobileurl('order/detail', array('id'=>$order['id']))?>" class=" btn btn-danger disable block">立即支付<span style="font-size:.65rem;margin-left:.5rem">(合计:￥<?php  echo $order['price'];?>)</span></a>
        <i class="icon icon-guanbi1" id="unpaid-colse" style="font-size:1.5rem;color:#fff;position: absolute;top:105%;left:46%"></i>
    </div>
</div>


<script>
    $(function(){
        $("#unpaid-colse").click(function(){
            $("#unpaid").addClass("shut")
            setTimeout(function(){
                $("#unpaid").css("display","none")
                $("#unpaid").removeClass("shut")
            },1000)
        })
    })
</script>

<?php  } ?>
<!--OTEzNzAyMDIzNTAzMjQyOTE0-->