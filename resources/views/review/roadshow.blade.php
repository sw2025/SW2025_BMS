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
    <!-- BEGIN CONTENT-->
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>直通路演</li>
                <li class="active">直通路演列表</li>
            </ol>
            <div class="section-body change-pwd">

                <!-- 筛选始-->
                <div class="search-bar clearfix">
                    <input class="search-bar-inp" type="text" placeholder="请输入路演标题或项目名称" value="{{$serveName or ''}}"  />
                    <input type="submit" value="搜索" class="btn btn-support2 search-bar-btn">
                </div>

               <div class="serve-results">
                    <div class="all-results clearfix">
                        <span class="tip-caption">全部结果 -> </span>
                        <div class="results-unit">
                            <a href="javascript:;" class="results-unit-del results-unit-industry" @if($job!=null)style="display:inline-block"@endif>{{$job}}</a>
                            <a href="javascript:;" class="results-unit-del results-unit-member"@if($idCard!=null) style="display:inline-block" @endif>{{$idCard}}</a>
                            <a href="javascript:;" class="results-unit-del results-unit-stage"@if($stage!=null) style="display: inline-block" @endif>{{$stage}}</a>
                            <a href="javascript:;" class="results-unit-del results-unit-size"@if($size!=null) style="display: inline-block" @endif>{{$size}}</a>
                            <a href="javascript:;" class="results-unit-del results-unit-zone"@if($location!=null) style="display: inline-block" @endif>{{$location}}</a>

                        </div>
                    </div>
                    <div class="choice-condition clearfix">
                        <div class="btn-group serve-mr">
                            <span style="float:left">通道分类：</span><button type="button" id="job" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                              {{$job or '不限'}}
                            </button>
                            <ul class="demo-list dropdown-menu animation-slide  serve-passageway-sel"  role="menu" style="text-align: left;">
                                <li><a href="javascript:;">不限</a></li>
                                <li><a href="javascript:;">免费通道</a></li>
                                <li><a href="javascript:;">定点推送</a></li>
                            </ul>
                        </div>

                        <div class="btn-group serve-mr">
                            <span style="float:left">领域分类：</span><button type="button" id="idCard" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                                {{$idCard or '不限'}}
                            </button>
                            <ul class="demo-list dropdown-menu animation-slide serve-member-sel" role="menu" style="text-align: left;">
                                <li><a href="javascript:;">不限</a></li>
                                @foreach($cate1 as $v)
                                    <li><a href="javascript:;">{{$v->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="btn-group serve-mr">
                            <span style="float:left">项目阶段：</span><button type="button" id="stage" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                                {{$stage or '不限'}}
                            </button>
                            <ul class="demo-list dropdown-menu animation-slide serve-stage-sel" role="menu" style="text-align: left;">
                                <li><a href="javascript:;">不限</a></li>
                                @foreach($cate2 as $v)
                                    <li><a href="javascript:;">{{$v->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="btn-group serve-mr">
                            <span style="float:left">时间段：</span><button type="button" id="size" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                                {{$size or '不限'}}
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
                            <span style="float:left">所在地区：</span><button type="button" id="location" class="result-select btn btn-support3 dropdown-toggle" data-toggle="dropdown">
                                {{$location or '全国'}}
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

                    </div>

                    <div class="result-order">
{{--
                        <a href="javascript:;" class="order-time">认证时间 <i @if($regTime=="up") class="fa fa-arrow-circle-o-up" @else class="fa fa-arrow-circle-o-down" @endif></i></a>
--}}
                        <h4 style="color:red;">数量：{{$counts or ''}}</h4>
                    </div>
                </div>
                <!-- 筛选未-->




                <div class="cert-list">
                    @foreach($datas as $v)
                        <div class="container-fluid cert-item">
                            <a href="{{url('perfectRoadShow',$v->showid)}}" style="float: right">完善</a>
                            <div class="col-md-10 cert-border">
                                <div class="container-fluid">
                                    <div class="col-md-4">
                                        <h2 class="cert-company"><a href="{{asset('/roadShowdetail/'.$v->showid)}}" class="look-link">{{unserialize($v->basicdata)['enterprisename']}}</a></h2>
                                        <span class="cert-telephone">联系电话：{{$v->phone}}</span>
                                        <p class="cert-scale">项目领域：<span>{{$v->domain1}}</span></p>
                                        <p class="cert-scale">项目阶段：<span>{{$v->preference}}</span></p>
                                        @if($v->level==2)
                                            @foreach($pushOk as $value)
                                                @if($v->showid==$value->showid)
                                                    <p class="cert-zone"><b>推送专家：<a style="cursor:pointer;text-decoration:none;">{{$value->expertname}}</a></b>
                                                        @if($value->state >= 2)
                                                            @foreach($message as $vv)
                                                                @if($vv->showid==$v->showid)
                                                                    @if($vv->isyes==1)
                                                                        有兴趣
                                                                    @else
                                                                        无兴趣
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @else
                                                             (未评价)
                                                        @endif
                                                    </p>
                                                @endif
                                            @endforeach
                                        @endif
                                        <p>项目标题：<span>{{$v->title}}</span></p>
                                        <p>项目名称：<span><a href="{{env('ImagePath')}}/show/{{$v->bpurl}}" target="_blank">{{$v->bpname}}</a></span></p>

                                    </div>
                                    <p class="cert-zone" style="float: right;color:black;"><b>提交时间：{{$v->showtime}}</b></p>
                                    <div class="col-md-8 cert-cap" style="overflow: hidden;height: 150px;">
                                        <span>{{$v->brief}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 set-certificate">

                                @if($v->level==2)
                                    @if($v->configid >= 4)
                                        <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-error eve_put"  style="background: yellow;" >推送项目（已推送）</button></a>
                                    @else
                                        <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-success eve_put" index="{{$v->showid}}" id="{{$v->showid}}" onclick="push(this)" >推送项目BP</button></a>

                                    @endif
                                 @else
                                    <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-error eve_put">免费通道提交的项目</button></a>
                                @endif
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
    <script>
        $(function(){
            var currentPage=parseInt("{{$datas->currentPage()}}")-1;
            $("#Pagination").pagination("{{$datas->lastpage()}}",{'callback':pageselectCallback,'current_page':currentPage});
            function pageselectCallback(page_index, jq){
                // 从表单获取每页的显示的列表项数目
                var current = parseInt(page_index)+1;
                var url = window.location.href;
                url = url.replace(/(\?|\&)?page=\d+/,'');
                var isexist = url.indexOf("?");
                if(isexist == -1){
                    url += '?ordertime=desc&page='+current;
                } else {
                    url += '&page='+current;
                }
                window.location=url;
                //阻止单击事件
                return false;
            }
        })
        $('.ver_fail').on('click',function () {
            window.location = '{{url('roadShow','fail')}}';
        });
        $('.ver_all').on('click',function () {
            window.location = '{{url('roadShow','all')}}';
        });
        $('.ver_wait').on('click',function () {
            window.location = '{{url('roadShow','wait')}}';
        });

        /**
         * 推送给专家项目评议
         * */
        function push(e){
            var type=$.trim($(e).closest('.cert-item').find('.cert-scale span').text());//领域
            console.log(type);
            var showId=$(e).attr("id");

            $.ajax({
                url:"{{url('showSelectExpert')}}",
                data:{"type":type},
                dateType:"json",
                type:"POST",
                async:false,
                success:function(res){
                    console.log(res=='');
                    if(res!=''){
                        $(".supply-list").html("");
                        var str="";
                        $.each(res,function(key,value){
                            var ExpertId=value.expertid;
                            str="<li class='col-md-4'>";
                            str+="<input type='hidden' id='show' value='"+showId+"'>"
                            str+="<a href='{{'serve_expertDet'}}/"+value.expertid+"' class='expert-list-link'>";
                            str+="<div class='exp-list-top'>"
                            str+="<span class='exp-list-img'><img src='{{env('ImagePath')}}"+value.showimage+"'></span>";
                            str+="<div class='exp-list-brief'>"
                            str+="<span class='exp-list-name'>"+value.expertname+"</span>"
                            str+="<span class='exp-list-video'><i class='fa fa-play-circle-o'></i>视频咨询：<em>免费</em></span>"
                            str+="<span class='exp-list-best'><i class='fa fa-thumbs-o-up'></i>擅长领域：<em>"+value.domain1+"</em></span></div>"
                            str+="<div class='exp-list-lab'>"
                            str+="</div>"
                            str+="</div>"
                            str+="<div class='exp-list-desc'>"
                            str+=value.brief
                            str+="</div>"
                            str+="</a>"
                            var strExpertId=String(ExpertId)
                            str+="<a href='javascript:;' onclick='xuanzhong("+value.expertid+")' id='show_"+value.expertid+"' class='xuanzhong'><i class='fa fa-check-square'></i></a>"
                            str+="</li>"
                            $(".supply-list").append(str);
                        })
                        $(".modal-new-list").modal();
                        $(".btn-primary").attr("id",this);
                    }else {
                        layer.open({
                            content: '没有次领域下的专家'
                            ,btn: ['从所有专家中筛选', '取消']
                            ,yes: function(index, layero){
                                //按钮【按钮一】的回调
                                layer.close(index);
                                $(function () {
                                    $.post('{{url('showSelectExpert')}}',{'type':null} ,function (res) {
                                        $(".supply-list").html("");
                                        var str = "";
                                        $.each(res, function (key, value) {
                                            var ExpertId = value.expertid;
                                            str = "<li class='col-md-4'>";
                                            str += "<input type='hidden' id='show' value='" + showId + "'>"
                                            str += "<a href='{{'serve_expertDet'}}/" + value.expertid + "' class='expert-list-link'>";
                                            str += "<div class='exp-list-top'>"
                                            str += "<span class='exp-list-img'><img src='{{env('ImagePath')}}" + value.showimage + "'></span>";
                                            str += "<div class='exp-list-brief'>"
                                            str += "<span class='exp-list-name'>" + value.expertname + "</span>"
                                            str += "<span class='exp-list-video'><i class='fa fa-play-circle-o'></i>视频咨询：<em>免费</em></span>"
                                            str += "<span class='exp-list-best'><i class='fa fa-thumbs-o-up'></i>擅长领域：<em>" + value.domain1 + "</em></span></div>"
                                            str += "<div class='exp-list-lab'>"
                                            str += "</div>"
                                            str += "</div>"
                                            str += "<div class='exp-list-desc'>"
                                            str += value.brief
                                            str += "</div>"
                                            str += "</a>"
                                            var strExpertId = String(ExpertId)
                                            str += "<a href='javascript:;' onclick='xuanzhong(" + value.expertid + ")' id='show_" + value.expertid + "' class='xuanzhong'><i class='fa fa-check-square'></i></a>"
                                            str += "</li>"
                                            $(".supply-list").append(str);
                                        })
                                        $(".modal-new-list").modal();
                                        $(".btn-primary").attr("id", this);
                                    }, 'json');
                                })

                            }
                            ,btn2: function(index, layero){
                                layer.close(index);
                            }
                            ,cancel: function(){
                                //右上角关闭回调
                                //return false 开启该代码可禁止点击该按钮关闭
                            }
                        });
                    }


                }
            })

        }

        var xuanzhong=function(id){
            $("#show_"+id).toggleClass('xzchecked');
        }
        $("#btnOK").on("click",function(){
            var expertSelect="";
            $('.xzchecked').each(function(index,element){
                var ids=$(this).attr('id');
                var num=ids.lastIndexOf('_')+1;
                id=ids.substring(num);
                expertSelect=id+','+expertSelect;
            })
            var showId=$("#show").val();
            if(!expertSelect){
                alert("请您选择专家");
                return false;
            }
            $.ajax({
                url:"{{url('pushExpert')}}",
                data:{"expertSelect":expertSelect,"showId":showId},
                dateType:"json",
                type:"post",
                success:function(res){
                    window.location = res.url;
                }
            })
        })
    </script>
    <script src="{{asset('js/review.js')}}" type="text/javascript"></script>
@endsection