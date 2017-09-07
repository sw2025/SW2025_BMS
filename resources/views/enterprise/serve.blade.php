@extends("layouts.cert")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>信息维护</li>
                <li class="active">企业信息审核</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="search-bar clearfix">
                    <input class="search-bar-inp" type="text" placeholder="请输入企业名称" @if($serveName!="null") value="{{$serveName}}" @endif />
                    <input type="button" value="搜索" class="btn btn-support2 search-bar-btn">
                </div>
                <div class="serve-results">
                    <div class="all-results clearfix">
                        <span class="tip-caption">全部结果 -> </span>
                        <div class="results-unit">
                            <a href="javascript:;" class="results-unit-del results-unit-scale" @if($size!="null") style="display:inline-block" @endif>{{$size}}</a>
                            <a href="javascript:;" class="results-unit-del results-unit-industry" @if($job!="null") style="display: inline-block" @endif>{{$job}}</a>
                            <a href="javascript:;" class="results-unit-del results-unit-zone" @if($location!="全国") style="display: inline-block" @endif>{{$location}}</a>
                            <a href="javascript:;" class="results-unit-del results-unit-member"@if($idCard!="null") style="display:inline-block" @endif>{{$idCard}}</a>
                        </div>
                    </div>
                    <div class="choice-condition clearfix">
                        <div class="btn-group serve-mr">
                            <span style="float:left">规模：</span><button type="button" id="size" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                               @if($size!="null"){{$size}}@else不限@endif
                            </button>
                            <ul class="demo-list dropdown-menu animation-slide serve-scale-sel" role="menu" style="text-align: left;">
                                <li><a href="javascript:;">不限</a></li>
                                <li><a href="javascript:;">20人以下</a></li>
                                <li><a href="javascript:;">20-99人</a></li>
                                <li><a href="javascript:;">100-499人</a></li>
                                <li><a href="javascript:;">500-999人</a></li>
                                <li><a href="javascript:;">1000-9999人</a></li>
                                <li><a href="javascript:;">10000人以上</a></li>
                            </ul>
                        </div>
                        <div class="btn-group serve-mr">
                            <span style="float:left">行业：</span><button type="button" id="job" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                                @if($job!="null"){{$job}}@else  不限 @endif
                            </button>
                            <ul class="demo-list dropdown-menu animation-slide serve-industry-sel" role="menu" style="text-align: left;">
                                <li><a href="javascript:;">不限</a></li>
                                <li><a href="javascript:;">IT|通信|电子|互联网</a></li>
                                <li><a href="javascript:;">金融业</a></li>
                                <li><a href="javascript:;">房地产|建筑业</a></li>
                                <li><a href="javascript:;">商业服务</a></li>
                                <li><a href="javascript:;">贸易|批发|零售|租赁业</a></li>
                                <li><a href="javascript:;">文体教育|工艺美术</a></li>
                                <li><a href="javascript:;">生产|加工|制造</a></li>
                                <li><a href="javascript:;">交通|运输|物流|仓储</a></li>
                                <li><a href="javascript:;">服务业</a></li>
                                <li><a href="javascript:;">文化|传媒|娱乐|体育</a></li>
                                <li><a href="javascript:;">能源|矿产|环保</a></li>
                                <li><a href="javascript:;">政府|非盈利机构</a></li>
                                <li><a href="javascript:;">农|林|牧|渔|其他</a></li>
                            </ul>
                        </div>
                        <div class="btn-group serve-mr">
                            <span style="float:left">所在地区：</span><button type="button" id="location" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown" style="display:block">
                                @if($location!="全国"){{$location}}@else  全国 @endif
                            </button>
                            <ul class="demo-list dropdown-menu animation-slide serve-zone-sel" role="menu" style="text-align: left;">
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
                            <span style="float:left">身份：</span><button type="button" id="idCard" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                                @if($idCard!="null"){{$idCard}}@else  不限 @endif
                            </button>
                            <ul class="demo-list dropdown-menu animation-slide serve-member-sel" role="menu" style="text-align: left;">
                                <li><a href="javascript:;">不限</a></li>
                                <li><a href="javascript:;">会员</a></li>
                                <li><a href="javascript:;">普通</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="result-order">
                        <a href="javascript:;" class="order-scale">规模 <i @if($sizeType=="up") class="fa fa-arrow-circle-o-up" @else class="fa fa-arrow-circle-o-down" @endif></i></a>
                        <a href="javascript:;" class="order-time">认证时间 <i @if($regTime=="up") class="fa fa-arrow-circle-o-up" @else class="fa fa-arrow-circle-o-down" @endif></i></a>
                        <span class="counts">数量:{{$counts}}</span>
                    </div>
                </div>
                <div class="cert-list">
                    @foreach($datas as $data)
                        <div class="container-fluid cert-item">
                            <div class="col-md-12 cert-border">
                                <div class="container-fluid">
                                    <div class="col-md-6">
                                        <h2 class="cert-company"><a href="{{asset('/serve_enterpriseDet?id='.$data->enterpriseid)}}" class="look-link">{{$data->enterprisename}}</a></h2>
                                        <span class="cert-time">{{$data->created_at}}</span>
                                        <span class="cert-telephone">联系电话：{{$data->phone}}</span>
                                        <p class="cert-industry">行业：{{$data->industry}}</p>
                                        <p class="cert-scale">规模：{{$data->size}}人</p>
                                        <p class="cert-zone">地区：{{$data->address}}</p>
                                    </div>
                                    <div class="col-md-3 cert-img"><img onclick="javascript:showimage('{{env('ImagePath').$data->licenceimage}}');" src="{{env('ImagePath').$data->licenceimage}}" /></div>
                                    <div class="col-md-3 cert-img"><img onclick="javascript:showimage('{{env('ImagePath').$data->showimage}}');" src="{{env('ImagePath').$data->showimage}}" /></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pages">
                    {!! $datas->appends(["size"=>$size,"serveName"=>$serveName,"location"=>$location,"idCard"=>$idCard,"job"=>$job,"regTime"=>$regTime,"sizeType"=>$sizeType])->render() !!}
                    {{-- <div class="oh"><div id="Pagination"></div><span class="page-sum">共<strong class="allPage">1</strong>页</span></div>--}}
                </div>
            </div>
        </section>
    </div>
    <script src="{{asset('js/enterprise.js')}}" type="text/javascript"></script>
@endsection