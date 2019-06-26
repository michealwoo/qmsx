<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">当前位置：<span class="text-primary"><?php  echo $goodsname?>价格变动走势图</span></div>

<!-- <div class="alert alert-primary">

    <p><b>数据说明</b></p>

    <p>商品成本价走势图<br>

    </p>

</div> -->

    <div class="page-content">

        <form action="./index.php" method="get" class="form-horizontal table-search">

        <input type="hidden" name="c" value="site" />

        <input type="hidden" name="a" value="entry" />

        <input type="hidden" name="m" value="ewei_shopv2" />

        <input type="hidden" name="do" value="web" />

        <input type="hidden" name="r"  value="statistics.sale_pricelog.detail" />
        
        <input type="hidden" name="id" value="<?php  echo $id?>" />
        
        <div class="page-toolbar">

            <div class="input-group">

                <span class="input-group-btn">

                    <?php  echo tpl_form_field_daterange('time',array('starttime'=>date('Y-m-d H:i', $starttime),'endtime'=>date('Y-m-d H:i', $endtime)),true);?>

                    <button class="btn btn-primary" type="submit"> 搜索</button>
                    <button class="btn btn-success" type="submit" name="export" value="1"> 导 出 </button>

                </span>

            </div>

        </div>

     </form>

    <div class="panel panel-default">

        <!-- <div class='panel-heading'>
           <span>商品价格走势图</span>
        </div> -->

        <div class="panel-body">

            <div class="col-sm-12">

                <div class="ibox float-e-margins" style="border: 1px solid #e7eaec">

                    <!-- <div class="ibox-title">

                        <h5>交易走势图</h5>

                    </div> -->
                    <?php  if(!empty($list)) { ?>
                    <div class="ibox-content">

                        <div class="echarts" id="echarts-line-chart" style="display: none"></div>

                        <div class="spiner-example ibox-loading" id="echarts-line-chart-loading">

                            <div class="sk-spinner sk-spinner-wave">

                                <div class="sk-rect1"></div>

                                <div class="sk-rect2"></div>

                                <div class="sk-rect3"></div>

                                <div class="sk-rect4"></div>

                                <div class="sk-rect5"></div>

                            </div>

                        </div>

                    </div>
                    <?php  } else { ?>
                    <div class="ibox-content">
                       
                        <div class="echarts" id="echarts-line-chart" style="display: none"></div>
                       
                        <div class="spiner-example ibox-loading">

                            <span >没有数据</span>
                        
                        </div>
                     
                    </div>
                    <?php  } ?>

                </div>

            </div>

            <div class="form-group" style="float: left;">
                <label class="col-lg control-label"></label>
                <div class="col-sm-9 col-xs-12">
                    <input type="button" class="btn btn-default" name="submit" onclick="history.back();" value="返回列表" />
                </div>
            </div>

        </div>

    </div>

</div>

<script language='javascript'>
var str = '<?php  echo $data;?>';
var json = eval('(' + str + ')');
//console.log(json);
myrequire(['echarts'], function () {
    var lineChart = echarts.init(document.getElementById("echarts-line-chart"));
    var lineoption = {
        title: {
            //text: '价格走势图',
            top: '100',
            textStyle: {
                fontWeight: 'normal',
                fontSize: 12,
                color: '#404040',
                fontFamily: 'Microsoft YaHei UI',
            }
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data: ['价格']
        },
        grid: {
            x: 50,
            x2: 50,
            y2: 30
        },
        calculable: true,
        xAxis: [
            {
                type: 'category',
                boundaryGap: false,
                data: json.date,
                axisLine: {
                    lineStyle: {
                       width: '0'
                    }
                },
            },
        ],
        yAxis: [
            {
                type: 'value',
                axisLine: {
                    lineStyle: {
                        width: '0'
                    }
                },
                axisLabel: {
                    formatter: '{value}'
                }
            }
        ],
        series: [
            {
                name: '价格',
                type: 'line',
                data: json.prices,
                itemStyle: {
                    normal: {
                        color: '#ffc000'
                    }
                }
            }
        ]
    };

    lineChart.setOption(lineoption);
    lineChart.resize();
});
$("#echarts-line-chart-loading").hide();
$("#echarts-line-chart").show();

 </script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

