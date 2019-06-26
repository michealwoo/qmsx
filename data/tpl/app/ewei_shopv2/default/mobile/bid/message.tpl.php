<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html>
<head>
  <title>留言</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://apps.bdimg.com/libs/jquerymobile/1.4.5/jquery.mobile-1.4.5.min.css">
<!--   <link rel="stylesheet" href="../addons/ewei_shopv2/template/mobile/default/gonghuo/static/css/bootstrap.css"/> -->
  <script src="https://apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="https://apps.bdimg.com/libs/jquerymobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
  <style>
   .table span{ width: 5rem;}
  </style>
</head>

<body>
    <div data-role="page">
      <div data-role="main" class="ui-content">
        <form method="post" action="#" id="form">
          <div class="ui-field-contain">
            <label for="company"><i style="color:red;">*</i>公司名称：</label>
            <input type="text" name="company" id="company" required />
            <label for="name"><i style="color:red;">*</i>姓名：</label>
            <input type="text" name="name" id="name" required/>       
            <label for="phone"><i style="color:red;">*</i>手机：</label>
            <input type="text" name="phone" id="phone" required/>       
            <label for="telephone">固话：</label>
            <input type="text" name="telephone" id="telephone"/>
            <label for="msg">留言：</label>
            <textarea name="msg" id="msg"></textarea>     
          </div>
          <button type="submit" id="submit">提交</button>
        </form>
      </div>
    </div>
    <script type="text/javascript">
      $('#submit').click(function(){
          var d = {};
          var t =$('#form').serializeArray();
          $.each(t,function(){
            d[this.name] = this.value;
          });      
          $.post("<?php  echo mobileUrl('bid/message')?>",{d:d},function(data){
               alert(data);
          });
      });
    </script>
</body>

</html>
