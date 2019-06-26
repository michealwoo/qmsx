<?php defined('IN_IA') or exit('Access Denied');?><script type="text/html" id="account-layer">

    <div class="account-layer">

        <?php  if(!empty($_W['shopset']['shop']['logo'])) { ?>

            <div class="account-logo">

                <img src="<?php  echo tomedia($_W['shopset']['shop']['logo'])?>" />

            </div>

        <?php  } ?>

        <div class="account-main">

            <div class="account-back"><i class="icon icon-back"></i></div>

            <div class="account-title"></div>

            <input class="account-input input-mobile" type="tel" maxlength="11" placeholder="请输入手机号" />

            <input class="account-input input-password" type="password" placeholder="请输入密码" />

            <input class="account-input input-password2" type="password" placeholder="请重复输入密码" />

            <input class="account-input input-bindrealname" type="text" placeholder="请输入真实姓名" />

            <input class="account-input input-bindbirthday" type="text" placeholder="请输入出生日期" />

            <input class="account-input input-bindidnumber" type="text" placeholder="请输入身份证号" />

            <input class="account-input input-bindwechat" type="text" placeholder="请输入微信号" />

            <div class="account-image">

                <input class="account-input input-image" type="tel" maxlength="4" placeholder="请输入图形验证码" />

                <img class="btn-image" src="../web/index.php?c=utility&a=code&r=<?php  echo time()?>">

            </div>

            <div class="account-verify">

                <input class="account-input input-verify" type="tel" maxlength="5" placeholder="请输入短信验证码" />

                <div class="btn-send disabled" id="btnCode">发送验证码</div>

            </div>

            <div class="account-tip"><span>还没账号？立即注册</span></div>

        </div>

        <div class="account-next">下一步</div>

        <div class="account-btn">登录</div>

        <div class="account-close">

            <i class="icon icon-guanbi1"></i>

        </div>

    </div>

</script>