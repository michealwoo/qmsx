<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!-- <link rel="stylesheet" href="https://apps.bdimg.com/libs/jquerymobile/1.4.5/jquery.mobile-1.4.5.min.css"> -->
    <link rel="stylesheet" href="../addons/ewei_shopv2/template/mobile/default/gonghuo/static/css/bootstrap.css"/>
    <script src="https://apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
   <!--  <script src="https://apps.bdimg.com/libs/jquerymobile/1.4.5/jquery.mobile-1.4.5.min.js"></script> -->
    <script src="../addons/ewei_shopv2/static/js/require.js"></script>
    <style>
     .table span{ width: 5rem;}
    </style>
</head>
<body>

<div data-role="page" id="pageone">
  <div data-role="main" class="ui-content">
      <form method="post" action="<?php  echo mobileUrl('bid/subbid')?>" id="form" data-ajax="false">
        <table class="table table-bordered" >
          <tr>
            <td colspan="4">商品名称</td>
            <td colspan="4">原价</td>
            <td colspan="4">竞价</td>
            <td colspan="4">说明</td>
          </tr>
          <?php  if(!empty($goods_list)){?>
            <?php  if(is_array($goods_list)) { foreach($goods_list as $item) { ?>
              <tr>
                <td colspan="4"><span><input type="hidden" name="goodsid[]" value="<?php  echo $item['id'];?>"/><?php  echo $item['title'];?></span></td>
                <td colspan="4"><span><?php  echo $item['marketprice'];?></span></td>
                <td colspan="4"><input type="text" name="bidprice[]"></td>
                <td colspan="4"><input type="text" name="desc[]"></td>
              </tr>
            <?php  } } ?>
             </table>
             <button id="submit">提交报价</button>
          <?php  }else{?>
                 <td colspan="16" style="text-align: center;">暂无商品</td>
            </table>
          <?php  }?>
        <!-- <input type="submit" id="submit" value="提交报价"> -->
      </form>
  </div>
</div>

<script type="text/javascript">

// $('#submit').click(function(){
//     var d = {};
//     var t =$('#form').serializeArray();
//     $.each(t,function(){
//       d[this.name] = this.value;
//     });
//     console.log(d);
//     //$.post("<?php  echo mobileUrl('gonghuo/subquote')?>",{});
// });

</script>

</body>
</html>
