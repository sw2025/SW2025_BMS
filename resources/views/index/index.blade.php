@extends("layouts.master")
@section("content")
<!-- 柱形图=====>start -->
<script type="text/javascript">
    require.config({
        paths: {
            echarts: '{{asset('js/dist')}}'
        }
    });
    require(
            [
                'echarts',
                'echarts/chart/bar',
                'echarts/chart/pie'
            ],
            function (ec) {
                var register = ec.init(document.getElementById('register'));
                var recharge = ec.init(document.getElementById('recharge'));
                var member = ec.init(document.getElementById('member'));
                var supply = ec.init(document.getElementById('supply'));
                var work = ec.init(document.getElementById('work'));
                var video = ec.init(document.getElementById('video'));


                option1 = {
                    title: {
                        x: 'center',
                        text: '注册信息'
                    },
                    tooltip: {
                        trigger: 'item'
                    },
                    grid: {
                        borderWidth: 0,
                        y: 80,
                        y2: 60
                    },
                    legend: {
                        data:['企业数', '专家数', '既是企业又是专家', '注册数'],
                        orient: 'vertical',
                        x:'right',
                        y:'top'
                    },
                    xAxis: [
                        {
                            type: 'category',
                            show: true,
                            splitLine : {
                                show: false
                            },
                            data: ['企业数', '专家数', '既是企业又是专家', '注册数']
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value',
                            splitLine : {
                                show: false
                            },
                            show: true
                        }
                    ],
                    series: [
                        {
                            type: 'bar',
                            barMaxWidth:100,
                            itemStyle: {
                                normal: {
                                    color: function(params) {
                                        // build a color map as your need.
                                        var colorList = [
                                            '#FB6E52','#48CFAE','#EC87BF','#FFCE55'
                                        ];
                                        return colorList[params.dataIndex]
                                    },
                                    label: {
                                        show: true,
                                        position: 'top',
                                        formatter: '{b}\n{c}'
                                    }
                                }
                            },
                            data: (function () {
                                var data1;
                                $.ajax({
                                    url: '{{url('registerData')}}',
                                    type: 'post',
                                    data: {},
                                    dataType: 'json',
                                    async: false,
                                    success: function (result) {
                                        if (result)
                                        {
                                            data1 = result.data
                                        }
                                    },
                                    error: function (errorMsg)
                                    {
                                        alert("注册信息请求失败");
                                    }
                                })
                                return data1;
                            })(),

                        }]
                };
                option2 = {
                    title: {
                        x: 'center',
                        text: '充值提现信息'
                    },
                    tooltip: {
                        trigger: 'item'
                    },
                    grid: {
                        borderWidth: 0,
                        y: 80,
                        y2: 60
                    },
                    legend: {
                        data:['充值金额', '提现金额'],
                        orient: 'vertical',
                        x:'right',
                        y:'top'
                    },
                    xAxis: [
                        {
                            type: 'category',
                            show: true,
                            splitLine : {
                                show: false
                            },
                            data: ['充值金额', '提现金额']
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value',
                            splitLine : {
                                show: false
                            },
                            show: true
                        }
                    ],
                    series: [
                        {
                            type: 'bar',
                            barMaxWidth:150,
                            itemStyle: {
                                normal: {
                                    color: function(params) {
                                        // build a color map as your need.
                                        var colorList = [
                                            '#FB6E52','#48CFAE'
                                        ];
                                        return colorList[params.dataIndex]
                                    },
                                    label: {
                                        show: true,
                                        position: 'top',
                                        formatter: '{b}\n{c}'
                                    }
                                }
                            },
                            data: (function () {
                                var data3;
                                $.ajax({
                                    url: '{{url('rechargeData')}}',
                                    type: 'post',
                                    data: {},
                                    dataType: 'json',
                                    async: false,
                                    success: function (result) {
                                        if (result)
                                        {
                                            data3= result.data
                                        }
                                    },
                                    error: function (errorMsg)
                                    {
                                        alert("充值提现信息请求失败");
                                    }
                                })
                                return data3;
                            })(),
                        }
                    ]
                };
                option3 = {
                    title : {
                        text: '会员费',
                        x:'center'
                    },
                    tooltip : {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    color:['#D87A80','#5AB1EF'],
                    legend: {
                        orient : 'vertical',
                        x : 'right',
                        y : 'top',
                        data:['支付宝','微信']
                    },
                    series : [
                        {

                            type:'pie',
                            radius : '55%',
                            center: ['50%', '60%'],
                            data:[
                                {value:3350, name:'支付宝'},
                                {value:3100, name:'微信'}
                            ],
                            itemStyle:{
                                normal:
                                {
                                    label:{
                                        show: true,
                                        formatter: '{b} : {c} ({d}%)'
                                    },
                                    labelLine :{show:true}
                                }
                            }
                        }
                    ]
                };
                option4 = {
                    title : {
                        text: '供求信息',
                        x:'center'
                    },
                    tooltip : {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    color:['#FFB980','#EC87BF'],
                    legend: {
                        orient : 'vertical',
                        x : 'right',
                        y : 'top',
                        data:['企业发布','专家发布']
                    },
                    series : [
                        {

                            type:'pie',
                            radius : '55%',
                            center: ['50%', '60%'],
                            data: (function () {
                                var data4;
                                $.ajax({
                                    url: '{{url('supplyData')}}',
                                    type: 'post',
                                    data: {},
                                    dataType: 'json',
                                    async: false,
                                    success: function (data) {
                                        if (data)
                                        {
                                            data4 = [
                                                {value:data.expert, name:'企业发布'},
                                                {value:data.enterprise, name:'专家发布'}
                                            ]
                                        }
                                    },
                                    error: function (errorMsg)
                                    {
                                        alert("供求信息请求失败");
                                    }
                                })
                                return data4;
                            })(),

                            itemStyle:{
                                normal:
                                {
                                    label:{
                                        show: true,
                                        formatter: '{b} : {c} ({d}%)'
                                    },
                                    labelLine :{show:true}
                                }
                            }
                        }
                    ]
                };
                option5 = {
                    title : {
                        text: '办事信息',
                        x:'center'
                    },
                    tooltip : {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    color:['#FB6E52','#48CFAE','#EC87BF','#FFCE55'],
                    legend: {
                        orient : 'vertical',
                        x : 'right',
                        y : 'top',
                        data:['办事阶段：1','办事阶段：2','办事阶段：3','办事阶段：4','办事阶段：5','办事阶段：6','办事阶段：7','办事阶段：8','办事阶段：9']
                    },
                    series : [
                        {

                            type:'pie',
                            radius : '55%',
                            center: ['50%', '60%'],
                            data: (function () {
                                var data6;
                                $.ajax({
                                    url: '{{url('workData')}}',
                                    type: 'post',
                                    data: {},
                                    dataType: 'json',
                                    async: false,
                                    success: function (data) {
                                        if (data)
                                        {
                                            data6 = [
                                                {value:data.work1, name:'咨询阶段：1'},
                                                {value:data.work2, name:'咨询阶段：2'},
                                                {value:data.work3, name:'咨询阶段：3'},
                                                {value:data.work4, name:'咨询阶段：4'}
                                            ]
                                        }
                                    },
                                    error: function (errorMsg)
                                    {
                                        alert("视频信息请求失败");
                                    }
                                })
                                return data6;
                            })(),
                            itemStyle:{
                                normal:
                                {
                                    label:{
                                        show: true,
                                        formatter: '{b} : {c} ({d}%)'
                                    },
                                    labelLine :{show:true}
                                }
                            }
                        }
                    ]
                };
                option6 = {
                    title : {
                        text: '视频咨询信息',
                        x:'center'
                    },
                    tooltip : {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    color:['#FB6E52','#48CFAE','#EC87BF','#FFCE55'],
                    legend: {
                        orient : 'vertical',
                        x : 'right',
                        y : 'top',
                        data:['咨询阶段：1','咨询阶段：2','咨询阶段：3','咨询阶段：4']
                    },
                    series : [
                        {

                            type:'pie',
                            radius : '55%',
                            center: ['50%', '60%'],
                            data: (function () {
                                var data6;
                                $.ajax({
                                    url: '{{url('videoData')}}',
                                    type: 'post',
                                    data: {},
                                    dataType: 'json',
                                    async: false,
                                    success: function (data) {
                                        if (data)
                                        {
                                            data6 = [
                                                {value:data.video1, name:'咨询阶段：1'},
                                                {value:data.video2, name:'咨询阶段：2'},
                                                {value:data.video3, name:'咨询阶段：3'},
                                                {value:data.video4, name:'咨询阶段：4'}
                                            ]
                                        }
                                    },
                                    error: function (errorMsg)
                                    {
                                        alert("视频信息请求失败");
                                    }
                                })
                                return data6;
                            })(),
                            itemStyle:{
                                normal:
                                {
                                    label:{
                                        show: true,
                                        formatter: '{b} : {c} ({d}%)'
                                    },
                                    labelLine :{show:true}
                                }
                            }
                        }
                    ]
                };
                register.setOption(option1);
                recharge.setOption(option2);
                member.setOption(option3);
                supply.setOption(option4);
                work.setOption(option5);
                video.setOption(option6);
              setTimeout(function (){
                    window.onresize = function () {
                        register.resize();
                        recharge.resize();
                        member.resize();
                        supply.resize();
                        work.resize();
                        video.resize();
                    }
                },200)
            }
    )
</script>
<!-- 柱形图=====>end -->

    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li><a href="index.html">首页</a></li>
                <!-- <li class="active">用户管理第一项</li> -->
            </ol>
            <div class="section-body">
                <div id="register" class="col-md-6"></div>
                <div id="member" class="col-md-6"></div>
                <div id="supply" class="col-md-6"></div>
                <div id="work" class="col-md-6"></div>
                <div id="video" class="col-md-6"></div>
                <div id="recharge" class="col-md-6"></div>
            </div>
        </section>
    </div>
@endsection
