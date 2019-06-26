<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://apps.bdimg.com/libs/jquerymobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="https://apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://apps.bdimg.com/libs/jquerymobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>

<body>
<div data-role="page" id="pageone">
  <div data-role="main" class="ui-content">
    <h2>商品搜索</h2>
    <form class="ui-filterable" method="get" action="<?php  echo mobileUrl('bid/goodslist')?>">
         <input id="myFilter" data-type="search" placeholder="根据商品名称搜索..">
    </form>
    <ul data-role="listview" data-filter="true" data-input="#myFilter" data-autodividers="true" data-inset="true">
      <?php  if(is_array($goods_list)) { foreach($goods_list as $item) { ?>
         <li><a href="<?php  echo mobileUrl('bid/goodslist',array('id'=>$item['id']))?>"><?php  echo $item['title'];?></a></li>
      <?php  } } ?>
    </ul>
  </div>
</div>

</body>
</html>
