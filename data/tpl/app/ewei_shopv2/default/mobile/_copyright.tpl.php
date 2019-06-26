<?php defined('IN_IA') or exit('Access Denied');?><?php  $copyright = m('common')->getCopyright()?>
<?php  if(!empty($copyright) && !empty($copyright['copyright'])) { ?>
    <div class="footer" style='width:100%; margin-top:0.5rem;display: block; <?php  if(!empty($copyright['bgcolor'])) { ?> background: <?php  echo $copyright['bgcolor'];?>; <?php  } ?>'>
        <?php  echo $copyright['copyright'];?>
    </div>
<?php  } ?>
<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->