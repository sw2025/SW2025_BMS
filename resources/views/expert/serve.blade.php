@extends("layouts.cert")
@section("content")
    <!-- BEGIN CONTENT-->
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>信息维护</li>
                <li class="active">专家信息维护</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="search-bar clearfix">
                    <input class="search-bar-inp" type="text" placeholder="请输入专家名称" @if($serveName!="null") value="{{$serveName}}" @endif />
                    <input type="submit" value="搜索" class="btn btn-support2 search-bar-btn">
                </div>
                <div class="serve-results">
                    <div class="all-results clearfix">
                        <span class="tip-caption">全部结果 -> </span>
                        <div class="results-unit">
                            <a href="javascript:;" class="results-unit-del results-unit-industry" @if($job!="null") style="display: inline-block" @endif>{{$job}}</a>
                            <a href="javascript:;" class="results-unit-del results-unit-zone" @if($location!="全国") style="display: inline-block" @endif>{{$location}}</a>
                            <a href="javascript:;" class="results-unit-del results-unit-member"@if($idCard!="null") style="display:inline-block" @endif>{{$idCard}}</a>
                        </div>
                    </div>
                    <div class="choice-condition clearfix">
                        <div class="btn-group serve-mr">
                            <span style="float:left">擅长领域：</span><button type="button" id="job" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                                @if($job!="null"){{$job}}@else  不限 @endif
                            </button>
                            <ul class="demo-list dropdown-menu animation-slide sub-industry"  role="menu" style="text-align: left;">
                                <li><a href="javascript:;">不限</a></li>
                                @foreach($label as $labels)
                                    @if($labels->level==1)
                                        <li>
                                            <a href="javascript:;">{{$labels->domainname}}</a>
                                            <ul class="sub-industry-menu">
                                                @foreach($label as $labeled)
                                                    @if($labeled->level == 2 && $labeled->parentid == $labels->domainid)
                                                        <li>{{$labeled->domainname}}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="btn-group serve-mr">
                            <span style="float:left">所在地区：</span><button type="button" id="location" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                                @if($location!="全国"){{$location}}@else 全国 @endif
                            </button>
                            <ul class="demo-list dropdown-menu animation-slide serve-zone-sel" index="address" role="menu" style="text-align: left;">
                                <li><a href="javascript:;">全国</a></li>
                                <li><a href="javascript:;">北京</a></li>
                                <li><a href="javascript:;">上海</a></li>
                                <li><a href="javascript:;">天津</a></li>
                                <li><a href="javascript:;">重庆</a></li>
                                <li><a href="javascript:;">河北</a></li>
                                <li><a href="javascript:;">山西</a></li>
                                <li><a href="javascript:;">内蒙古</a></li>
                                <li><a href="javascript:;">辽宁</a></li>
                                <li><a href="javascript:;">吉林</a></li>
                                <li><a href="javascript:;">黑龙江</a></li>
                                <li><a href="javascript:;">江苏</a></li>
                                <li><a href="javascript:;">浙江</a></li>
                                <li><a href="javascript:;">安徽</a></li>
                                <li><a href="javascript:;">福建</a></li>
                                <li><a href="javascript:;">江西</a></li>
                                <li><a href="javascript:;">山东</a></li>
                                <li><a href="javascript:;">河南</a></li>
                                <li><a href="javascript:;">湖北</a></li>
                                <li><a href="javascript:;">湖南</a></li>
                                <li><a href="javascript:;">广东</a></li>
                                <li><a href="javascript:;">广西</a></li>
                                <li><a href="javascript:;">海南</a></li>
                                <li><a href="javascript:;">四川</a></li>
                                <li><a href="javascript:;">贵州</a></li>
                                <li><a href="javascript:;">云南</a></li>
                                <li><a href="javascript:;">西藏</a></li>
                                <li><a href="javascript:;">陕西</a></li>
                                <li><a href="javascript:;">甘肃</a></li>
                                <li><a href="javascript:;">青海</a></li>
                                <li><a href="javascript:;">宁夏</a></li>
                                <li><a href="javascript:;">新疆</a></li>
                                <li><a href="javascript:;">台湾</a></li>
                                <li><a href="javascript:;">香港</a></li>
                                <li><a href="javascript:;">澳门</a></li>
                            </ul>
                        </div>
                        <div class="btn-group serve-mr">
                            <span style="float:left">是否首页：</span><button type="button" id="idCard" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                                @if($idCard!="null"){{$idCard}}@else  不限 @endif
                            </button>
                            <ul class="demo-list dropdown-menu animation-slide serve-member-sel" role="menu" style="text-align: left;">
                                <li><a href="javascript:;">不限</a></li>
                                <li><a href="javascript:;">首页</a></li>
                                <li><a href="javascript:;">非首页</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="result-order">
                        <a href="javascript:;" class="order-time">认证时间 <i @if($regTime=="up") class="fa fa-arrow-circle-o-up" @else class="fa fa-arrow-circle-o-down" @endif></i></a>
                        <span class="counts">数量:{{$counts}}</span>
                    </div>
                </div>

                <div class="cert-list" id="content2">
                    @foreach($datas as $data)
                    <div class="container-fluid cert-item">
                        <div class="col-md-10 cert-border">
                            <div class="container-fluid">
                                <div class="col-md-4">
                                    <h2 class="cert-company"><a href="{{url('/serve_expertDet',$data->expertid)}}" class="look-link">{{$data->expertname}}</a></h2>
                                    <span class="cert-time">{{$data->created_at}}</span>
                                    <span class="cert-telephone">联系电话：{{$data->phone}}</span>
                                    @if($data->isfirst=='1')<p class="cert-industry">首页顺序：{{$data->order}}&nbsp;&nbsp;|&nbsp;专家等级：{{$data->level}}</p>@else<p class="cert-industry">专家等级：{{$data->level}}</p> @endif
                                    <p class="cert-industry">擅长问题：{{$data->domain1}}-{{join('/',explode(',',$data->domain2))}}</p>
                                    <p class="cert-scale">专家分类：{{$data->category}}</p>
                                    <p class="cert-zone">地区：{{$data->address}}</p>
                                </div>
                                <div class="col-md-4 cert-img"><img onclick="javascript:showimage('{{env('ImagePath').$data->licenceimage}}');" src="{{env('ImagePath').$data->licenceimage}}" /></div>
                                <div class="col-md-4 cert-img"><img onclick="javascript:showimage('{{env('ImagePath').$data->showimage}}');" src="{{env('ImagePath').$data->showimage}}" /></div>
                            </div>
                        </div>
                        <div class="col-md-2 set-certificate">
                            @if($data->isfirst==0)
                                <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support6" id="{{$data->expertid}}">专家等级</button></a>
                                <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support4" id="{{$data->expertid}}">删除专家</button></a>
                                <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-support1" id="{{$data->expertid}}">设为首页</button></a>
                            @else
                                <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support6" id="{{$data->expertid}}">专家等级</button></a>
                                <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support4" id="{{$data->expertid}}">删除专家</button></a>
                                <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support5" id="{{$data->expertid}}">选择顺序</button></a>
                                <a href="javascript:;" ><button type="button" class="btn btn-block ink-reaction btn-support2" id="{{$data->expertid}}">取消首页设置</button></a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    <div class="pages">
                        {!! $datas->appends(["serveName"=>$serveName,"location"=>$location,"idCard"=>$idCard,"job"=>$job,"regTime"=>$regTime])->render() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="/js/layer/extend/layer.ext.js"></script>
    <script>
        /**
         * 设置专家等级
         **/
         $(".btn-support6").on("click",function(){
            var expertid=$(this).attr("id");
            layer.prompt({title: '输入等级，并确认', formType: 3}, function(pass, index) {
                layer.close(index);
                var level = pass;
                $.ajax({
                    url: "{{asset('/changeGrade')}}",
                    data: {"expertid": expertid,"level":level},
                    dataType: "json",
                    type: "POST",
                    success: function (res) {
                        if (res['code'] == "success") {
                            alert("操作成功");
                            window.location.href = "{{asset('/serve_expert')}}";
                        } else {
                            alert("操作失败");
                            window.location.href = "{{asset('/serve_expert')}}";
                        }
                    }
                })
            })
        })

        /**
         * 设置首页
         * */
        $(".btn-support1").on("click",function(){
            var expertid=$(this).attr("id");
            layer.prompt({title: '输入首页顺序，并确认', formType: 3}, function(pass, index){
                layer.close(index);
                var order = pass;
                $.ajax({
                    url:"{{asset('/changeHomePage')}}",
                    data:{"isfirst":1,"expertid":expertid,"order":order},
                    dataType:"json",
                    type:"POST",
                    success:function(res){
                        if(res['code']=="success"){
                            alert("成功设置首页顺序");
                            window.location.href="{{asset('/serve_expert')}}";
                        }else{
                            alert("设置首页顺序失败");
                            window.location.href="{{asset('/serve_expert')}}";
                        }
                    }
                })
            })

        })
        $(".btn-support2").on("click",function(){
            var expertid=$(this).attr("id");
            $.ajax({
                url:"{{asset('/changeHomePage')}}",
                data:{"isfirst":0,"expertid":expertid},
                dataType:"json",
                type:"POST",
                success:function(res){
                    if(res['code']=="success"){
                        alert("成功取消首页设置");
                        window.location.href="{{asset('/serve_expert')}}";
                    }else{
                        alert("取消首页设置失败");
                        window.location.href="{{asset('/serve_expert')}}";
                    }
                }
            })
        })
        //选择专家首页顺序
        $(".btn-support5").on("click",function(){
            var expertid=$(this).attr("id");
            layer.prompt({title: '输入首页顺序，并确认', formType: 3}, function(pass, index) {
                layer.close(index);
                var order = pass;
                $.ajax({
                    url: "{{asset('/changeHomePage')}}",
                    data: {"isfirst":1,"expertid": expertid,"order":order},
                    dataType: "json",
                    type: "POST",
                    success: function (res) {
                        if (res['code'] == "success") {
                            alert("设置成功");
                            window.location.href = "{{asset('/serve_expert')}}";
                        } else {
                            alert("设置失败");
                            window.location.href = "{{asset('/serve_expert')}}";
                        }
                    }
                })
            })
        })

        $(".btn-support4").on("click",function(){
            var expertid=$(this).attr("id");
            layer.prompt({title: '删除原因，并确认', formType: 2}, function(text, index) {
                layer.close(index);
                var remark = text;
                $.ajax({
                    url:"{{asset('/changeExpert')}}",
                    data:{"remark":remark,"expertid":expertid,"configid":3},
                    dataType:"json",
                    type:"POST",
                    success:function(res){
                        if(res['code']=="success"){
                            alert("操作成功");
                            window.location.href="{{asset('/serve_expert')}}";
                        }else{
                            alert("操作失败");
                            window.location.href="{{asset('/serve_expert')}}";
                        }
                    }
                })
            })
        })
    </script>
<script src="{{asset('js/expert.js')}}" type="text/javascript"></script>
@endsection