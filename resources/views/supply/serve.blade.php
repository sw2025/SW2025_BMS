@extends("layouts.extend")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>信息维护</li>
                <li class="active">供求信息维护</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="search-bar clearfix">
                    <input class="search-bar-inp" type="text" placeholder="请输入需求关键字" @if($serveName!="null") value="{{$serveName}}" @endif />
                    <input type="button" value="搜索" class="btn btn-support2 search-bar-btn" >
                </div>
                <div class="serve-results">
                    <div class="all-results clearfix">
                        <span class="tip-caption">全部结果
                            <span class="glyphicon glyphicon-arrow-right"></span> </span>
                        <div class="results-unit">
                            <a href="javascript:;" class="results-unit-del results-unit-scale" @if($size!="null") style="display:inline-block" @endif><span> {{$size}} </span></a>
                            <a href="javascript:;" class="results-unit-del results-unit-industry" @if($job!="null") style="display:inline-block" @endif><span> {{$job}} </span></a>
                            <a href="javascript:;" class="results-unit-del results-unit-zone" @if($location!="null" && $location != '全国') style="display:inline-block" @endif><span> {{$location}} </span></a>
                        </div>
                    </div>
                    <div class="choice-condition clearfix">
                        <div class="btn-group serve-mr">
                            <span style="float:left">发布方：</span><button type="button" id="size" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                                @if($size!="null"){{$size}}@else不限@endif
                            </button>
                            <ul class="demo-list dropdown-menu animation-slide serve-scale-sel" role="menu" style="text-align: left;">
                                <li><a href="javascript:;">不限</a></li>
                                <li><a href="javascript:;">专家</a></li>
                                <li><a href="javascript:;">企业</a></li>
                            </ul>
                        </div>
                        <div class="btn-group serve-mr">
                            <span style="float:left">
                                需求领域：</span><button type="button" id="job" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                                @if($job!="null"){{$job}}@else  不限 @endif
                            </button>

                            <ul class="demo-list dropdown-menu animation-slide sub-industry"  role="menu" style="text-align: left;">

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
                            <h2 class="cert-company"><a href="{{url('/serve_supplyDet',$v->needid)}}" class="look-link">【{{$v->needtype}}】@if($v->needtype=='企业') {{$v->enterprisename}} @else {{$v->expertname}} @endif</a></h2>
                            <span class="cert-telephone">联系电话：{{$v->phone}}</span>
                            <p class="cert-scale">需求分类：{{$v->domain1}}/{{$v->domain2}}</p>
                            <p class="cert-scale">地区：{{$v->address}}</p>
                        </div>
                        <div class="col-md-8 cert-cap">
                            <span class="cert-work-time">{{$v->needtime}}</span>
                            <span>{{$v->brief}}</span>

                            <p  value="{{$v->needid}}"><a href="javascript:;" class="deleteSupply"><button type="button" class="btn btn-block ink-reaction btn-support1" style="width: 100px;float: right;">删除</button></a></p>

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
        $('.deleteSupply').on('click',function () {
            var needid = $(this).parent('p').attr('value');
            layer.prompt({title: '请写出删除原因，并确认', formType: 2}, function(text, index){
                layer.close(index);
                var remark = text;
                $.ajax({
                    url:"{{url('deleteSupply')}}",
                    data:{"needid":needid,"remark":remark},
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
    <script src="{{asset('js/supply.js')}}" type="text/javascript"></script>
@endsection