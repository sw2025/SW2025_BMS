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
                            <span style="float:left">身份：</span><button type="button" id="idCard" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                                @if($idCard!="null"){{$idCard}}@else 不限 @endif
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
                        <span style="float: right;font-size:16px"><a href="javascript:;" id="delete">删除</a><label for="selector" class="control-label">全选</label><input type="checkbox" id="selector" onclick="swapCheck()" />
                        </span>
                    </div>
                </div>
                <div class="cert-list">
                    @foreach($datas as $data)
                        <div class="container-fluid cert-item">
                            <input type="checkbox" value="{{$data->id}}" name="r" style="float:right"/>
                            <div class="col-md-10 cert-border">
                                <div class="container-fluid">
                                    <div class="col-md-4">
                                        <h2 class="cert-company"><a href="javascript:;" class="look-link">{{$data->enterprisename}}</a></h2>
                                        <span class="cert-time">法定人：{{$data->username}}</span>
                                        <span class="cert-telephone">联系电话：{{$data->phone1}}</span>
                                        <span class="cert-telephone">联系电话：{{$data->phone2}}</span>
                                        <p class="cert-industry">行业：{{$data->industry}}</p>
                                        <p class="cert-scale">规模：{{$data->size}}</p>
                                        <p class="cert-zone">地区：{{$data->address}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 set-certificate">
                                <a href="{{url('/zhanshi',$data->id)}}"><button type="button" class="btn btn-block ink-reaction btn-support1">完善企业数据</button></a>
                                <a href="javascript:;" onclick="" ><button type="button" class="btn btn-block ink-reaction btn-support1">删除企业数据</button></a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pages">
                    {!! $datas->appends(["size"=>$size,"serveName"=>$serveName,"location"=>$location,"idCard"=>$idCard,"job"=>$job,"regTime"=>$regTime,"sizeType"=>$sizeType])->render() !!}
                </div>
            </div>
        </section>
    </div>
    <script src="{{asset('js/enterprise.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        var a = 123;
        console.log(a);
        $('#delete').click(function () {
            layer.confirm('确认删除数据？', {
                btn: ['确认', '取消']
            }, function(index, layero){
                layer.close(index);
                text = $("input:checkbox[name='r']:checked").map(function(index,elem){
                    return $(elem).val();
                }).get().join(',');
                $.ajax({
                    url:"{{asset('/deleteEnterprise')}}",
                    data:{"text":text},
                    dataType:"json",
                    type:"POST",
                    success:function(res){
                        if(res['errorMsg']=="success"){
                            window.location.href=window.location;
                        }else{
                            alert("操作失败");
                           window.location.href=window.location;
                        }
                    }
                })
            }, function(index){
                $("input[type='checkbox']").each(function() {
                    this.checked = false;
                });
                isCheckAll = false;
            });
        })

        //checkbox 全选/取消全选
        var isCheckAll = false;
        function swapCheck() {
            if (isCheckAll) {
                $("input[type='checkbox']").each(function() {
                    this.checked = false;
                });
                isCheckAll = false;
            } else {
                $("input[type='checkbox']").each(function() {
                    this.checked = true;
                });
                isCheckAll = true;
            }
        }
    </script>


@endsection