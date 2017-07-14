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
                        </div>
                    </div>
                    <div class="choice-condition clearfix">
                        <div class="btn-group serve-mr">
                            <span style="float:left">擅长领域：</span><button type="button" id="job" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                                @if($job!="null"){{$job}}@else  不限 @endif
                            </button>
                            <ul class="dropdown-menu animation-slide sub-industry" role="menu" style="text-align: left;">
                                <li><a href="javascript:;">不限</a></li>
                                <li>
                                    <a href="javascript:;">融资投资</a>
                                    <ul class="sub-industry-menu">
                                        <li>投资理财</li>
                                        <li>融资投资</li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:;">战略合作</a>
                                    <ul class="sub-industry-menu">
                                        <li>战略目标</li>
                                        <li>战略资源</li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:;">产品升级</a>
                                    <ul class="sub-industry-menu">
                                        <li>企业转型</li>
                                        <li>产品更新</li>
                                        <li>产品迭代</li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:;">市场运营</a>
                                    <ul class="sub-industry-menu">
                                        <li>市场资源</li>
                                        <li>运营相关</li>
                                    </ul>
                                </li>
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
                    </div>
                    <div class="result-order">
                        <a href="javascript:;" class="order-time">认证时间 <i @if($regTime=="up") class="fa fa-arrow-circle-o-up" @else class="fa fa-arrow-circle-o-down" @endif></i></a>
                        <span class="counts">数量:{{$counts}}</span>
                    </div>
                </div>

                <div class="cert-list" id="content2">
                    @foreach($datas as $data)
                    <div class="container-fluid cert-item">
                        <div class="col-md-12 cert-border">
                            <div class="container-fluid">
                                <div class="col-md-6">
                                    <h2 class="cert-company"><a href="{{url('/serve_expertDet',$data->expertid)}}" class="look-link">{{$data->expertname}}专家</a></h2>
                                    <span class="cert-time">时间</span>
                                    <span class="cert-telephone">联系电话：{{$data->phone}}</span>
                                    <p class="cert-industry">擅长问题：{{$data->domain1}}</p>
                                    <p class="cert-scale">专家分类：{{$data->category}}</p>
                                    <p class="cert-zone">地区：{{$data->address}}</p>
                                </div>
                                <div class="col-md-3 cert-img"><img onclick="javascript:showimage('img/zhanwei.jpg');" src="../img/zhanwei.jpg" /></div>
                                <div class="col-md-3 cert-img"><img onclick="javascript:showimage('img/zhanwei.jpg');" src="../img/zhanwei.jpg" /></div>
                            </div>
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
<script src="{{asset('js/expert.js')}}" type="text/javascript"></script>
@endsection