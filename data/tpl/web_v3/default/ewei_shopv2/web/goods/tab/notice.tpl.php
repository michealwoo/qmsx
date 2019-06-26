<?php defined('IN_IA') or exit('Access Denied');?><div class="region-goods-details row">
    <div class="region-goods-left col-sm-2">卖家通知</div>
    <div class="region-goods-right col-sm-10">
        <div class="form-group notice">
            <label class="col-sm-2 control-label">商家通知</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( ce('goods' ,$item) ) { ?>
                <?php  echo tpl_selector('noticeopenid',array('key'=>'openid','text'=>'nickname','multi'=>1,'thumb'=>'avatar','placeholder'=>'昵称/姓名/手机号','buttontext'=>'选择通知人', 'items'=>$salers,'url'=>webUrl('member/query') ))?>
                <?php  } else { ?>
                <div class='form-control-static'>
                    <?php  if(!empty($saler)) { ?><?php  echo $saler['nickname'];?><?php  } else { ?>无<?php  } ?>
                </div>
                <?php  } ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">通知方式</label>
            <div class="col-sm-9 col-xs-12">

                <?php if( ce('goods' ,$item) ) { ?>
                <label class="checkbox-inline">
                    <input type="checkbox" value="1" name='noticetype[]' <?php  if(is_array($noticetype)) { ?><?php  if(in_array('1',$noticetype)) { ?>checked<?php  } ?><?php  } ?> /> 付款通知
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" value="2" name='noticetype[]' <?php  if(is_array($noticetype)) { ?><?php  if(in_array('2',$noticetype)) { ?>checked<?php  } ?><?php  } ?> /> 买家收货通知
                </label>
                <div class="help-block">通知商家方式</div>
                <?php  } else { ?>
                <div class='form-control-static'><?php  if(in_array(1,$noticetype)) { ?>付款通知;<?php  } ?><?php  if(in_array(2,$noticetype)) { ?>买家收货通知;<?php  } ?></div>
                <?php  } ?>
            </div>
        </div>
    </div>
</div>
<!--青岛易联互动网络科技有限公司-->