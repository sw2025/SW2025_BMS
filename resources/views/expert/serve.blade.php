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
                    <input class="search-bar-inp" type="text" placeholder="请输入专家名称" value="" />
                    <input type="submit" value="搜索" class="btn btn-support2 search-bar-btn">
                </div>
                <div class="serve-results">
                    <div class="all-results clearfix">
                        <span class="tip-caption">全部结果 -> </span>
                        <div class="results-unit">
                            <a href="javascript:;" class="results-unit-del results-unit-industry"><span> × </span></a>
                            <a href="javascript:;" class="results-unit-del results-unit-zone"><span> × </span></a>
                        </div>
                    </div>
                    <div class="choice-condition clearfix">
                        <div class="btn-group serve-mr">
                            <span style="float:left">擅长领域：</span><button type="button" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                                请选择
                            </button>
                            <ul class="dropdown-menu animation-slide sub-industry" role="menu" style="text-align: left;">
                                <li><a href="javascript:;">请选择</a></li>
                                <li><a href="javascript:;">不限</a></li>
                                <li>
                                    <a href="javascript:;">IT|通信|电子|互联网</a>
                                    <ul class="sub-industry-menu">
                                        <li>Item 2</li>
                                        <li>Open level 3</li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:;">金融业</a>
                                    <ul class="sub-industry-menu">
                                        <li>Item 2</li>
                                        <li>Open level 3</li>
                                    </ul>
                                </li>
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
                            <span style="float:left">所在地区：</span><button type="button" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                                全国
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
                        <a href="javascript:;" class="order-time">认证时间 <i class="fa fa-arrow-circle-o-up"></i></a>
                        <span class="counts">数量:{{$count}}</span>
                    </div>
                </div>

                <div class="cert-list" id="content2">
                    @foreach($datas as $data)
                    <div class="container-fluid cert-item">
                        <div class="col-md-12 cert-border">
                            <div class="container-fluid">
                                <div class="col-md-6">
                                    <h2 class="cert-company"><a href="{{asset('/serve_expertDet')}}" class="look-link">{{$data->expertname}}专家</a></h2>
                                    <span class="cert-time">{{$data->created_at}}</span>
                                    <span class="cert-telephone">联系电话：{{$data->phone}}</span>
                                    <p class="cert-industry">擅长问题：{{$data->domain1}}</p>
                                    <p class="cert-scale">专家分类：{{$data->category}}</p>
                                    <p class="cert-zone">地区：{{$data->address}}</p>
                                </div>
                                <div class="col-md-3 cert-img"><img onclick="javascript:showimage('img/zhanwei.jpg');" src="img/zhanwei.jpg" /></div>
                                <div class="col-md-3 cert-img"><img onclick="javascript:showimage('img/zhanwei.jpg');" src="img/zhanwei.jpg" /></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="pages">
                        {!! $datas->render() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
    <input type="hidden" name="where" value="a:1:{i:1;i:1;}" id="where">
<script src="{{asset('js/expert.js')}}" type="text/javascript"></script>
@endsection