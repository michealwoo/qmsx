<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>



<div class="page-header">当前位置：<span class="text-primary">订单概述</span></div>

<div class="page-content">

<div class="row">

    <div class="col-md-6 col-sm-6">

        <div class="summary_box">

            <div class="summary_title">

                <span class="text-default title_inner">今日成交</span>

                <span class="pull-right" style="margin-right: 30px">人均消费 : ¥ <span class="today-avg"></span></span>

            </div>

            <div class="summary flex">

                <div class="flex1 flex column" style="border-right: 1px solid #efefef">

                    成交量/交易量

                    <h2 class="today-count">--</h2>

                </div>

                <div class="flex1 flex column">

                    成交额/交易额

                    <h2 class="text-danger">¥ <span class="today-price">--</span></h2>

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-6 col-sm-6">

        <div class="summary_box">

            <div class="summary_title">

                <span class="text-default title_inner">昨日成交</span>

                <span class="pull-right" style="margin-right: 30px">人均消费 : ¥ <span class="yesterday-avg">--</span></span>

            </div>

            <div class="summary flex">

                <div class="flex1 flex column" style="border-right: 1px solid #efefef">

                    成交量/交易量

                    <h2 class="yesterday-count">--</h2>

                </div>

                <div class="flex1 flex column">

                    成交额/交易额

                    <h2 class="text-danger">¥ <span class="yesterday-price">--</span></h2>

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-6 col-sm-6">

        <div class="summary_box">

            <div class="summary_title">

                <span class="text-default title_inner">近7日成交</span>

                <span class="pull-right" style="margin-right: 30px">人均消费 : ¥ <span class="seven-avg">--</span></span>

            </div>

            <div class="summary flex">

                <div class="flex1 flex column" style="border-right: 1px solid #efefef">

                    成交量/交易量

                    <h2 class="seven-count">--</h2>

                </div>

                <div class="flex1 flex column">

                    成交额/交易额

                    <h2 class="text-danger">¥ <span class="seven-price">--</span></h2>

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-6 col-sm-6">

        <div class="summary_box">

            <div class="summary_title">

                <span class="text-default title_inner">近1个月成交</span>

                <span class="pull-right" style="margin-right: 30px">人均消费 : ¥ <span class="month-avg">--</span></span>

            </div>

            <div class="summary flex">

                <div class="flex1 flex column" style="border-right: 1px solid #efefef">

                    成交量/交易量

                    <h2 class="month-count">--</h2>

                </div>

                <div class="flex1 flex column">

                    成交额/交易额

                    <h2 class="text-danger">¥ <span class="month-price">--</span></h2>

                </div>

            </div>

        </div>

    </div>

    <div class="col-sm-12">

        <div class="ibox float-e-margins" style="border: 1px solid #e7eaec">

            <div class="ibox-title">

                <h5>交易走势图</h5>

            </div>

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

        </div>

    </div>

</div>

</div>

<script>

    $(function () {

        $.ajax({

            type: "GET",

            url: "<?php  echo webUrl('order/ajaxorder')?>&day=0",

            dataType: "json",

            success: function (data) {

                var json = data.result;

                $(".today-count").text(json.order.order_count+"/"+json.order.allorder_count);

                $(".today-price").text(json.order.order_price +"/"+json.order.allorder_price);

                $(".today-avg").text(json.order.avg);

            }

        });


        $.ajax({

            type: "GET",

            url: "<?php  echo webUrl('order/ajaxorder')?>&day=1",

            dataType: "json",

            success: function (data) {

                var json = data.result;

                $(".yesterday-count").text(json.order.order_count+"/"+json.order.allorder_count);

                $(".yesterday-price").text(json.order.order_price +"/"+json.order.allorder_price);

                $(".yesterday-avg").text(json.order.avg);

            }

        });



        $.ajax({

            type: "GET",

            url: "<?php  echo webUrl('order/ajaxorder')?>&day=7",

            dataType: "json",

            success: function (data) {

                var json = data.result;

                $(".seven-count").text(json.order.order_count+"/"+json.order.allorder_count);

                $(".seven-price").text(json.order.order_price +"/"+json.order.allorder_price);

                $(".seven-avg").text(json.order.avg);

            }

        });



        $.ajax({

            type: "GET",

            url: "<?php  echo webUrl('order/ajaxorder')?>&day=30",

            dataType: "json",

            success: function (data) {

                var json = data.result;

                $(".month-count").text(json.order.order_count+"/"+json.order.allorder_count);

                $(".month-price").text(json.order.order_price +"/"+json.order.allorder_price);

                $(".month-avg").text(json.order.avg);

            }

        });

        $.ajax({

            type: "GET",

            url: "<?php  echo webUrl('order/ajaxtransaction')?>",

            dataType: "json",

            success: function (json) {

                myrequire(['echarts'], function () {

                    var lineChart = echarts.init(document.getElementById("echarts-line-chart"));

                    var lineoption = {

                        title: {

                            text: '近七日交易走势',

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

                            data: ['交易量','成交量','交易额','成交额']

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

                                data: json.price_key,

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

                                name: '交易额',

                                type: 'line',

                                data: json.allprice_value,

                                markPoint: {

                                    data: [

                                        {

                                            type: 'max',

                                            name: '最大值'

                                        },

                                        {

                                            type: 'min', name: '最小值'

                                        }

                                    ]

                                },

                                markLine: {

                                    data: [

                                        {type: 'average', name: '平均值'}

                                    ]

                                },

                                itemStyle: {

                                    normal: {

                                        color: '#ffc000'

                                    }

                                }

                            },

                            {

                                name: '成交额',

                                type: 'line',

                                data: json.price_value,

                                markPoint: {

                                    data: [

                                        {

                                            type: 'max',

                                            name: '最大值'

                                        },

                                        {

                                            type: 'min', name: '最小值'

                                        }

                                    ]

                                },

                                markLine: {

                                    data: [

                                        {type: 'average', name: '平均值'}

                                    ]

                                },

                                itemStyle: {

                                    normal: {

                                        color: '#ff5555'

                                    }

                                }

                            },

                            {

                                name: '交易量',

                                type: 'line',

                                data: json.allcount_value,

                                markLine: {

                                    data: [

                                        {type: 'average', name: '平均值'}

                                    ]

                                },

                                itemStyle: {

                                    normal: {

                                        color: '#44abf7'

                                    }

                                }

                            },

                            {

                                name: '成交量',

                                type: 'line',

                                data: json.count_value,

                                markLine: {

                                    data: [

                                        {type: 'average', name: '平均值'}

                                    ]

                                },

                                itemStyle: {

                                    normal: {

                                        color: '#30af84'

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

            }

        });

    });

</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>