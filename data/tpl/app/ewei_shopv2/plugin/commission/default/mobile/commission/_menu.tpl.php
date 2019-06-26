<?php defined('IN_IA') or exit('Access Denied');?><div class="fui-navbar">
    <a href="<?php  echo mobileUrl('commission')?>" class="external nav-item <?php  if($_W['routes']=='commission') { ?>active<?php  } ?>">
        <span class="icon icon-home"></span>
        <span class="label"><?php  echo $this->set['texts']['center']?></span>

    </a>
    <a href="<?php  echo mobileUrl('commission/withdraw')?>"
       class="external nav-item <?php  if($_W['routes']=='commission.log' || $_W['routes']=='commission.withdraw' || $_W['routes']=='commission.apply') { ?>active<?php  } ?>">
        <span class="icon icon-qian1"></span>
        <span class="label"><?php  echo $this->set['texts']['commission1']?></span>
    </a>

    <a href="<?php  echo mobileUrl('commission/order')?>"
       class="external nav-item <?php  if($_W['routes']=='commission.order') { ?>active<?php  } ?>">
        <span class="icon icon-list"></span>
        <span class="label"><?php  echo $this->set['texts']['order']?></span>
    </a>

    <a href="<?php  echo mobileUrl('commission/down')?>"
       class="external nav-item <?php  if($_W['routes']=='commission.down') { ?>active<?php  } ?>">
        <span class="icon icon-group"></span>
        <span class="label"><?php  echo $this->set['texts']['mydown']?></span>
    </a>
    <?php  if(empty($this->set['closemyshop'])) { ?>
        <?php  $mid = m('member')->getMid()?>
        <a href="<?php  echo mobileUrl('commission/myshop',array('mid'=>$mid))?>"
           class=" external nav-item <?php  if($_W['routes']=='commission.myshop') { ?>active<?php  } ?>">
            <span class="icon icon-shop"></span>
            <span class="label"><?php  echo $this->set['texts']['myshop']?></span>
        </a>
    <?php  } ?>
</div>

<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->