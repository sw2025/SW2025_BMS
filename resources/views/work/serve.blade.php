@extends("layouts.extend")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>信息维护</li>
                <li class="active">办事服务信息</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="search-bar clearfix">
                    <input class="search-bar-inp" type="text" placeholder="请输入办事关键字" @if($serveName!="null") value="{{$serveName}}" @endif />
                    <input type="submit" value="搜索" class="btn btn-support2 search-bar-btn" >
                </div>
                <div class="serve-results">
                    <div class="all-results clearfix">
                        <span class="tip-caption">全部结果 <span class="glyphicon glyphicon-arrow-right"></span> </span>
                        <div class="results-unit">
                            <a href="javascript:;" class="results-unit-del results-unit-scale" @if($size!="null") style="display:inline-block" @endif><span> {{$size}} </span></a>
                            <a href="javascript:;" class="results-unit-del results-unit-industry" @if($job!="null") style="display:inline-block" @endif><span> {{$job}} </span></a>
                            <a href="javascript:;" class="results-unit-del results-unit-zone" @if($location!="null" && $location != '全国') style="display:inline-block" @endif><span> {{$location}} </span></a>
                        </div>
                    </div>
                    <div class="choice-condition clearfix">
                        <div class="btn-group serve-mr">
                            <span style="float:left">状态：</span><button type="button" id="size" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                                @if($size!="null"){{$size}}@else不限@endif
                            </button>
                            <ul class="demo-list dropdown-menu animation-slide serve-scale-sel"  role="menu" style="text-align: left;">
                                <li><a href="javascript:;">全部</a></li>
                                <li><a href="javascript:;">正在办事</a></li>
                                <li><a href="javascript:;">已完成</a></li>
                            </ul>
                        </div>
                        <div class="btn-group serve-mr">
                            <span style="float:left">需求领域：</span><button type="button" id="job" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                                @if($job!="null"){{$job}}@else  不限 @endif
                            </button>
                            <ul class="dropdown-menu animation-slide sub-industry" role="menu" style="text-align: left;">
                                <li><a href="javascript:;">不限</a></li>
                                @foreach($cate as $v)
                                    @if($v->level == 1)
                                        <li>
                                            <a href="javascript:;">{{$v->domainname}}</a>
                                            <ul class="sub-industry-menu">
                                                @foreach($cate as $sm)
                                                    @if($sm->level == 2 && $sm->parentid == $v->domainid)
                                                        <li>{{$sm->domainname}}</li>
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
                                @if($location!="全国"){{$location}}@else  全国 @endif
                            </button>
                            <ul class="demo-list dropdown-menu animation-slide serve-zone-sel"  role="menu" style="text-align: left;">
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
                    </div>
                    <div class="result-order">
                        <a href="javascript:;" class="order-time">认证时间 <i @if($regTime=="up") class="fa fa-arrow-circle-o-up" @else class="fa fa-arrow-circle-o-down" @endif></i></a>
                        <span class="counts" >数量:{{$counts}}</span>
                    </div>
                </div>
                <div class="cert-list" >
                    @foreach($datas as $v)
                    <div class="container-fluid cert-item">
                        <div class="col-md-4">
                            <h2 class="cert-company"><a href="{{url('serve_workDet',$v->eventid)}}" class="look-link">{{$v->enterprisename}}</a></h2>
                            <span class="cert-telephone">联系电话：{{$v->phone}}</span>
                            <p class="cert-scale">需求分类：{{$v->domain1}}/{{$v->domain2}}</p>
                            <p class="cert-zone">指定专家：{{--@if($v->state === "0") {{  App\Http\Controllers\WorkController::getExpertName($v->expertid) }} @else 系统匹配 @endif--}}</p>
                        </div>
                        <div class="col-md-8 cert-cap">
                            <span class="cert-work-time">{{$v->eventtime}}</span>
                           <span>{{$v->brief}}</span>
                            <p  value="{{$v->eventid}}"><a href="javascript:;" class="deleteWork"><button type="button" class="btn btn-block ink-reaction btn-support1" style="width: 100px;float: right;">删除</button></a></p>
                        </div>

                    </div>
                   @endforeach
                    <div class="pages">
                        {!! $datas->appends(["size"=>$size,"serveName"=>$serveName,"location"=>$location,"job"=>$job,"regTime"=>$regTime])->render() !!}
                        <div class="oh"><div id="Pagination"></div><span class="page-sum">共<strong class="allPage">{{$datas->lastPage()}}</strong>页</span></div>
                    </div>
                </div>


            </div>
        </section>
    </div>
    <script src="/js/layer/extend/layer.ext.js"></script>
    <script>
        $('.deleteWork').on('click',function () {
            var eventid = $(this).parent('p').attr('value');
            layer.prompt({title: '请写出删除原因，并确认', formType: 2}, function(text, index){
                layer.close(index);
                var remark = text;
                $.ajax({
                    url:"{{url('deleteWork')}}",
                    data:{"eventid":eventid,"remark":remark},
                    dateType:"json",
                    type:"POST",
                    success:function(res){
                        layer.alert(res.code,3);
                        window.location.href = window.location;
                    }
                })
            });
        })
    </script>
    <script src="{{asset('js/work.js')}}" type="text/javascript"></script>
@endsection
