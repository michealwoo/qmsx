<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
    当前位置：<span class="text-primary">分销商增长趋势</span>
</div>

<div class="page-content">
        <form action="./index.php" method="get"   class="form-horizontal form-search" role="form">
            <input type="hidden" name="c" value="site" />
            <input type="hidden" name="a" value="entry" />
            <input type="hidden" name="m" value="ewei_shopv2" />
	        <input type="hidden" name="do" value="web" />
            <input type="hidden" name="r" value="commission.increase" />
            <input type="hidden" name="search" value="1" />
            <div class="page-toolbar m-b-sm m-t-sm">
	            <div style="width: 318px;float: right;">
                         <div class="input-group">
                             <div class="input-group-select">
                                 <select id='days' name="days" class="form-control">
                                     <option value="7"  <?php  if($days==7) { ?>selected<?php  } ?>>最近</option>
                                     <option value="7"  <?php  if($days==7) { ?>selected<?php  } ?>>7天</option>
                                     <option value="14"  <?php  if($days==14) { ?>selected<?php  } ?>>14天</option>
                                     <option value="30"  <?php  if($days==30) { ?>selected<?php  } ?>>30天</option>
                                     <option value=""  <?php  if($days=='') { ?>selected<?php  } ?>>按日期</option>
                                 </select>
                             </div>
                             <div class="input-group-select">
                                 <select id='year' name="year" class="form-control">
                                     <option value=''>年份</option>
                                     <?php  if(is_array($years)) { foreach($years as $y) { ?>
                                     <option value="<?php  echo $y['data'];?>"  <?php  if($y['selected']) { ?>selected="selected"<?php  } ?>><?php  echo $y['data'];?>年</option>
                                     <?php  } } ?>
                                 </select>
                             </div>
                             <div class="input-group-select">
                                 <select id='month' name="month" class="form-control">
                                     <option value=''>月份</option>
                                     <?php  if(is_array($months)) { foreach($months as $m) { ?>
                                     <option value="<?php  echo $m['data'];?>"  <?php  if($m['selected']) { ?>selected="selected"<?php  } ?>><?php  echo $m['data'];?>月</option>
                                     <?php  } } ?>
                                 </select>
                             </div>
                             <div class="btn-group">
                                 <button class="btn  btn-primary" type="submit"> 搜索</button>
                             </div>
                         </div>
                </div>
            </div>
        </form>

        <div class="panel panel-default">
            <div class="panel-heading">趋势图示例</div>
            <div class="panel-body">
                <div id="container" style="width: 800px; height: 400px; margin: 0 auto"></div>
            </div>
        </div>
</div>
<script language="javascript" src="<?php echo EWEI_SHOPV2_STATIC;?>js/dist/highcharts/highcharts.js"></script>
<script type="text/javascript">
    
   function checkform(){

       if($('#days').val()==''){
           if($('#year').val()==''){
               alert('请选择年份!');
               return false;
           }
       }
       return true;
   }

      $('#days').change(function(){
            if($(this).val()!=''){
                $('#year').val('');
                $('#month').val('').attr('disabled',true);;
            }

        })
       $('#year').change(function(){
            if($(this).val()==''){
                $('#month').val('').attr('disabled',true);
            }
            else{
                $('#days').val('');
                $('#month').removeAttr('disabled');
            }
        })

    $(function () {



        $('#container').highcharts({
        chart: {
            type: 'line'
        },
        title: {
             text: '<?php  echo $charttitle;?>',
        },
        subtitle: {
            text: ''
        },
        colors: [
'#0061a5',
'#ff0000'
],
        xAxis: {
            categories: [    <?php  if(is_array($datas)) { foreach($datas as $key => $row) { ?>
                   <?php  if($key>0) { ?>,<?php  } ?>"<?php  echo $row['date'];?>"
                   <?php  } } ?>]
        },
        yAxis: {
            title: {
                text: '人数'
            },allowDecimals:false
        },
        tooltip: {
            enabled: false,
            formatter: function() {
                return '<b>'+ this.series.name +'</b><br>'+this.x +': '+ this.y +'°C';
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [
            {
               name: '会员',
               data: [
                   <?php  if(is_array($datas)) { foreach($datas as $key => $row) { ?>
                   <?php  if($key>0) { ?>,<?php  } ?><?php  echo $row['acount'];?>
                   <?php  } } ?>
               ]
            } ]
    });

});
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>