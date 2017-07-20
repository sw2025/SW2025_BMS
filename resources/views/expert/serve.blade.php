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
                                <li><a href="javascript:;">北京市</a></li>
                                <li><a href="javascript:;">上海市</a></li>
                                <li><a href="javascript:;">天津市</a></li>
                                <li><a href="javascript:;">重庆市</a></li>
                                <li><a href="javascript:;">河北省</a></li>
                                <li><a href="javascript:;">山西省</a></li>
                                <li><a href="javascript:;">内蒙古</a></li>
                                <li><a href="javascript:;">辽宁省</a></li>
                                <li><a href="javascript:;">吉林省</a></li>
                                <li><a href="javascript:;">黑龙江省</a></li>
                                <li><a href="javascript:;">江苏省</a></li>
                                <li><a href="javascript:;">浙江省</a></li>
                                <li><a href="javascript:;">安徽省</a></li>
                                <li><a href="javascript:;">福建省</a></li>
                                <li><a href="javascript:;">江西省</a></li>
                                <li><a href="javascript:;">山东省</a></li>
                                <li><a href="javascript:;">河南省</a></li>
                                <li><a href="javascript:;">湖北省</a></li>
                                <li><a href="javascript:;">湖南省</a></li>
                                <li><a href="javascript:;">广东省</a></li>
                                <li><a href="javascript:;">广西</a></li>
                                <li><a href="javascript:;">海南省</a></li>
                                <li><a href="javascript:;">四川省</a></li>
                                <li><a href="javascript:;">贵州省</a></li>
                                <li><a href="javascript:;">云南省</a></li>
                                <li><a href="javascript:;">西藏</a></li>
                                <li><a href="javascript:;">陕西省</a></li>
                                <li><a href="javascript:;">甘肃省</a></li>
                                <li><a href="javascript:;">青海省</a></li>
                                <li><a href="javascript:;">宁夏</a></li>
                                <li><a href="javascript:;">新疆</a></li>
                                <li><a href="javascript:;">台湾省</a></li>
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
                                    <h2 class="cert-company"><a href="{{url('/serve_expertDet',$data->expertid)}}" class="look-link">{{$data->expertname}}专家</a></h2>
                                    <span class="cert-time">时间</span>
                                    <span class="cert-telephone">联系电话：{{$data->phone}}</span>
                                    <p class="cert-industry">擅长问题：{{$data->domain1}}</p>
                                    <p class="cert-scale">专家分类：{{$data->category}}</p>
                                    <p class="cert-zone">地区：{{$data->address}}</p>
                                </div>
                                <div class="col-md-4 cert-img"><img onclick="javascript:showimage('img/zhanwei.jpg');" src="../img/zhanwei.jpg" /></div>
                                <div class="col-md-4 cert-img"><img onclick="javascript:showimage('img/zhanwei.jpg');" src="../img/zhanwei.jpg" /></div>
                            </div>
                        </div>
                        <div class="col-md-2 set-certificate">
                            {{--@if($data->configid==1)
                                <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1" id="{{$data->expertid}}">设为首页</button></a>
                                <a href="javascript:;" onclick="showReason({{$data->expertid}});"><button type="button" class="btn btn-block ink-reaction btn-support5" id="{{$data->expertid}}">拒绝审核</button></a>
                            @else @endif--}}
                            @if($data->isfirst==0)
                                <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-support1" id="{{$data->expertid}}">设为首页</button></a>
                            @else
                                <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-support2" id="{{$data->expertid}}">取消首页设置</button></a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    <div class="pages">
                        {!! $datas->appends(["serveName"=>$serveName,"location"=>$location,"job"=>$job,"regTime"=>$regTime])->render() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        /**
         * 设置首页
         */
        $(".btn-support1").on("click",function(){
            var expertid=$(this).attr("id");
            $.ajax({
                url:"{{asset('/changeHomePage')}}",
                data:{"isfirst":1,"expertid":expertid},
                dataType:"json",
                type:"POST",
                success:function(res){
                    if(res['code']=="success"){
                        window.location.href="{{asset('/serve_expert')}}";
                    }else{
                        alert("审核失败");
                        window.location.href="{{asset('/serve_expert')}}";
                    }
                }
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
                        window.location.href="{{asset('/serve_expert')}}";
                    }else{
                        alert("审核失败");
                        window.location.href="{{asset('/serve_expert')}}";
                    }
                }
            })
        })
    </script>
<script src="{{asset('js/expert.js')}}" type="text/javascript"></script>
@endsection