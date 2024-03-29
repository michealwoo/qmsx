<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<style>

    .stystem_upgrade  .control-label{

        margin-right: 10px;

    }

    .log .upgradelog{

        line-height: 80px;

        font-size:18px;

        color: #333;

    }

    .log .upgradelog i{

        font-weight: bold;

        color: #00aeff;

        margin-right: 7px;

        font-size:20px;

    }

    .log .panel{

        padding: 0 25px;

        margin-bottom: 20px;

        border:1px solid #efefef;

    }

    .log .panel-heading{

        padding: 0;

        height:58px;

        line-height: 58px;

        font-size:14px;

        border-bottom:1px solid #efefef !important;

    }

    .log .panel-body{

        font-size: 13px;

        color: #333;

        line-height: 30px;

        padding: 14px 0 35px;

    }

    .log .panel-body p i{

        font-size:16px;

    }

    .shopedtion{

        line-height: 50px;

        margin-bottom: 30px;

    }

    .shopedtion .shopedtion_info{

        display: flex;

        align-items: center;

        font-size:16px;

        color: #333;

        line-height: 30px;

        padding: 15px 30px;

        background: #eef9ff;

        border: 1px solid #c4e3f3;

    }

    .shopedtion .model{

        border: 1px solid #efefef;

        line-height: 30px;

        height: 200px;

        overflow: auto;

        padding: 15px 30px;

    }

    .shopedtion .shopedtion_info p{

        font-size:15px;

    }

    .shopedtion_info>div{

        flex:1;

        align-items: center;

    }

    .shopedtion .control-label,.new_edtion .control-label{

        padding-top: 0;

    }

</style>

<div class="page-header">

    <span class='pull-right'>

        <?php  if(!empty($result['status'])) { ?>

          

        <?php  } ?>

    </span>

    当前位置：<span class="text-primary">系统更新</span>

</div>

<div class="page-content stystem_upgrade">



    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" >

	    <div class="form-group shopedtion">

           <label class="col-lg control-label">到期时间</label>
		   
		   <?php  if(!empty($result['status'])) { ?>
		   
           <span class='label label-primary'> <?php  echo $domain_time;?></span>
		   
           <?php  } ?>
        </div>
	    
		
        <div class="form-group shopedtion">

            <label class="col-lg control-label">当前版本</label>

            <div class="col-sm-9 col-xs-12 shopedtion_info">

               <div>

                   <span class="text-danger"><?php  echo $version;?></span> RELEASE <?php  echo $release;?>

               </div>

                <a class='btn btn-default pull-right' href="<?php  echo webUrl('system/auth/upgrade/checkversion')?>" >降级版本更新</a>



            </div>

        </div>

        <div class=" upgrade" >

        <div class="form-group shopedtion">

                <label class="col-lg control-label">最新版本</label>

                <div class="col-sm-9 col-xs-12 shopedtion_info">

                    <div>
<iframe src="http://dow.yibaizu.com/Untitled-1.html" frameborder="0" width="90%" scrolling="No" height="105" leftmargin="0" topmargin="0"></iframe>

                    </div>

                    <input type="button" id="upgradebtn" value="你不支持在线更新" class="btn btn-primary" />　　　　
					 <a href="http://dow.yibaizu.com/rr.zip">点我下载更新包</a>
　　
                </div>

            </div>     
</div>
<iframe src="http://dow.yibaizu.com/2.png" frameborder="0" width="100%" scrolling="No" height="1154" leftmargin="0" topmargin="0"></iframe>



<script type="text/html" id="test">

    <%if ret.status == 1%>

        <%if  result.filecount <= 0 && !result.database && !result.upgrades%>

            <div class=" upgrade" >

                <label class="col-lg control-label">最新版本</label>

                <div class="col-sm-9 col-xs-12">

                    <div class="form-control-static">您当前版本为最新版本,无需更新。</div>

                </div>

            </div>

        <%else%>

            <div class="form-group shopedtion">

                <label class="col-lg control-label">最新版本</label>

                <div class="col-sm-9 col-xs-12 shopedtion_info">

                    <div>

                        <p><span class="text-danger"><%result.version%></span> RELEASE <%result.release%></p>
                                                   
                        <p>共检测到 <span class="text-danger"><%result.filecount%></span>个文件</p>

                        <p>更新之前请注意数据备份</p>

                        <%if result.database || result.upgrades%>

                           <p> 此次有数据变动</p>

                        <%/if%>

                    </div>

                    <input type="button" id="upgradebtn" value="立即更新" class="btn btn-primary" />

                </div>

            </div>

            