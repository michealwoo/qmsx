<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
<title>供货商商品列表</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://apps.bdimg.com/libs/jquerymobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="https://apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://apps.bdimg.com/libs/jquerymobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>

<div data-role="page">
  <div data-role="main" class="ui-content">
    <form method="post" action="<?php  echo mobileUrl('gonghuo/quote')?>">
      <fieldset data-role="controlgroup">
        <?php  if(is_array($goods_list)) { foreach($goods_list as $item) { ?>
            <label for="goods<?php  echo $item['id'];?>"><?php  echo $item['title'];?></label>
            <input type="checkbox" name="ids[]" id="goods<?php  echo $item['id'];?>" value="<?php  echo $item['id'];?>"/>
        <?php  } } ?> 
      </fieldset>
      <input type="submit" data-inline="true" value="报价"/>
    </form>
  </div>
</div>

</body>
</html>