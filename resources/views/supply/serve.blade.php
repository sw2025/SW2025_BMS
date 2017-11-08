@extends("layouts.extend")
@section("content")
    <style>
        #hoverstyle{
            color: #e3643d;
            border-color: #e3643d;
        }

    </style>
    <link rel="stylesheet" href="{{asset('css/list.css')}}">
    <script src="{{asset('js/jquery.pagination.js')}}" type="text/javascript"></script>
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
                            <a href="javascript:;" class="results-unit-del results-unit-member"@if($level!="null") style="display:inline-block" @endif>{{$level}}</a>
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
                            <span style="float:left">是否会员：</span><button type="button" id="level" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                                @if($level!="null"){{$level}}@else不限@endif
                            </button>
                            <ul class="demo-list dropdown-menu animation-slide serve-member-sel" role="menu" style="text-align: left;">
                                <li><a href="javascript:;">不限</a></li>
                                <li><a href="javascript:;">会员</a></li>
                                <li><a href="javascript:;">非会员</a></li>
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
                            @if($v->configid == '4')
                            <p><a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support2" style="width: 100px;">已解决</button></a></p>
                             @else
                                <p><a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support4" style="width: 100px;">未解决</button></a></p>
                            @endif
                        </div>
                        <div class="col-md-8 cert-cap">
                            <span class="cert-work-time">{{$v->needtime}}</span>
                            <span>{{$v->brief}}</span>

                        </div>
                        <div>
                            <p  value="{{$v->needid}}"><a href="javascript:;" class="deleteSupply"><button type="button" class="btn btn-block ink-reaction btn-support1" style="width: 100px;float:right;">删除</button></a></p>
                            <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-success eve_put" index="{{$v->needid}}" id="{{$v->needid}}" onclick="push(this)" style="width: 100px;float:right;">推送</button></a>
                        </div>
                    </div>
                   @endforeach
                    <div class="pages">
                        {!! $datas->appends(["size"=>$size,"level"=>$level,"serveName"=>$serveName,"location"=>$location,"job"=>$job,"regTime"=>$regTime])->render() !!}
                        <div class="oh"><div id="Pagination"></div><span class="page-sum">共<strong class="allPage">{{$datas->lastPage()}}</strong>页</span></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal modal-new-list">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">关闭</button>
        </div>
        <div class="modal-body">
            <div class="new-list container">
                <ul class="supply-list clearfix">
                </ul>
                <div class="pages myinfo-page">
                    <div id="Pagination"></div><span class="page-sum">共<strong class="allPage">{{$datas->lastpage()}}</strong>页</span>
                </div>
                <div class="btn-two">
                    <button type="button" class="btn btn-block ink-reaction btn-inverse" data-dismiss="modal">取消</button>
                    <button type="button" id="btnOK" class="btn btn-block ink-reaction btn-danger" >确定</button>
                </div>
            </div>
        </div>
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
        /**
         * 推送
         */
        function push(e){
            var type=$(e).closest('.cert-item').find('.cert-scale span').text();
            var needId=$(e).attr("id");
            //alert(eventId);
            //var datas=getCountExpert(needId);
            /*var expertCount=datas.expertCount;
            var expertstring=datas.expertids;*/
            //alert(expertCount);
            $.ajax({
                url:"{{url('selectEnterprise')}}",
                data:{"needId":needId},
                dateType:"json",
                type:"POST",
                async:false,
                success:function(res){
                    var allPage = res.last_page;
                    
                    $(".supply-list").html("");
                    var str="";
                    $.each(res.data,function(key,value){
                        console.log(value.showimage);
                        //var enterpriseid=value.enterpriseid;
                        str="<li class='col-md-4'>";
                        str+="<input type='hidden' id='need' value='"+needId+"'>"
                        str+="<div class='exp-list-top'>"
                        str+="<span class='exp-list-img'><img src='{{env('ImagePath')}}"+value.showimage+"'></span>"
                        str+="<div class='exp-list-brief'>"
                        str+="<span class='exp-list-name'>"+value.enterprisename+"</span>"
                        str+="<span class='exp-list-name'>"+value.industry+"</span>"
                        str+="<div class='exp-list-lab'>"
                        str+="</div>"
                        str+="</div>"
                        str+="<div class='exp-list-desc'>"
                        str+="</div>"
                        str+="</a>"
                        //var strEnterpriseid=String(enterpriseid)
                        str+="<a href='javascript:;' onclick='xuanzhong("+value.userid+")' id='need_"+value.userid+"' class='xuanzhong'><i class='fa fa-check-square'></i></a>"
                        str+="</li>"
                        $(".supply-list").append(str);
                    })
                    $(".modal-new-list").modal();
                    $(".btn-primary").attr("id",this);
                }
            })
        }

        var xuanzhong=function(id){
            $("#need_"+id).toggleClass('xzchecked');
        }
        $("#btnOK").on("click",function(){
            var expertSelect="";
            $('.xzchecked').each(function(index,element){
                var ids=$(this).attr('id');
                var num=ids.lastIndexOf('_')+1;
                id=ids.substring(num);
                expertSelect=id+','+expertSelect;
            })
            var needId=$("#need").val();
            if(!expertSelect){
                alert("请您选择专家");
                return false;
            }
            $.ajax({
                url:"{{url('needPushSelect')}}",
                data:{"expertSelect":expertSelect,"needId":needId},
                dateType:"json",
                type:"post",
                success:function(res){
                   window.location.reload();
                }
            })
        })
    </script>
    <script src="{{asset('js/supply.js')}}" type="text/javascript"></script>
@endsection