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
                                @if($job!="null"){{$job}}@else不限 @endif
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
                            @if($v->level=='1' && $v->configid=='3')
                                <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-success eve_put" index="{{$v->needid}}" id="{{$v->needid}}" onclick="push(this)" style="width: 100px;float:right;">推送</button></a>
                            @else
                            @endif
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
                    {{--<div id="Pagination"></div><span class="page-sum">共<strong class="allPage">{{$datas->lastpage()}}</strong>页</span>--}}
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
            $.ajax({
                url:"{{url('selectEnterprise')}}",
                data:{"needId":needId},
                dateType:"json",
                type:"POST",
                async:false,
                success:function(res){
                    //var allPage = res.last_page;

                    $(".supply-list").html("");
                    var str="";
                    $.each(res.data,function(key,value){
                        //console.log(value.showimage);
                        if((typeof(value.enterprisename) == "undefined")) {
                            var name = value.expertname;
                            var image = value.showimage;
                            var domain = value.domain1+'-'+value.domain2;
                        }else{
                            var name = value.enterprisename;
                            var image = value.showimage;
                            var domain = value.industry;
                        }
                        str="<li class='col-md-4'>";
                        str+="<input type='hidden' id='need' value='"+needId+"'>"
                        str+="<div class='exp-list-top'>"
                        str+="<span class='exp-list-img'><img src='{{env('ImagePath')}}"+image+"'></span>"
                        str+="<div class='exp-list-brief'>"
                        str+="<span class='exp-list-name'>"+name+"</span>"
                        str+="<span class='exp-list-name'>"+domain+"</span>"
                        str+="<div class='exp-list-lab'>"
                        str+="</div>"
                        str+="</div>"
                        str+="<div class='exp-list-desc'>"
                        str+="</div>"
                        str+="</a>"
                        str+="<a href='javascript:;' onclick='xuanzhong("+value.userid+")' id='need_"+value.userid+"' class='xuanzhong'><i class='fa fa-check-square'></i></a>"
                        str+="</li>"
                        $(".supply-list").append(str);
                    })
                    $(".myinfo-page").html("");
                    var str="";
                        /*str+="<div><a>上一页</a><a>下一页</a></div>"
                    str += '<div class="pages"></div>'*/
                    if (res.prev_page_url == null){
                        str += '<a href="javascript:;"  rel="prev">上一页</a>'
                    } else {
                        str += '><a href="javascript:;" onclick=pagenext("'+ res.prev_page_url +'") rel="prev">上一页</a>'
                    }
                    if (res.next_page_url == null){
                        str += '<a href="javascript:;"  rel="next"> 下一页</a>'
                    } else {
                        str += '<a href="javascript:;" onclick=pagenext("'+ res.next_page_url +'") rel="next">下一页</a>'
                    }
                    str += '<li> <span style="font-size: 17px;">总页数:'+ res.last_page +'</span></li>';
                    str += '<li> <span style="font-size: 17px;">当前页:'+ res.current_page +'</span></li>'
                  /*  if(res.total > 1) {
                        str += ' <li><input type="number" max="'+res.to+'" id="pagenumber"  style="width: 70px;height: 36px;display: inline-block;padding: 5px 14px;background-color: #ffffff;border: 1px solid #dddddd;border-radius: 0px;">'
                        str += '<button class="btn btn-success" type="button" onclick=pagenext("serve_work?page="+$("#pagenumber").val()) style="height: 36px; margin-bottom: 4px;">跳转</button></li>'
                    }*/
                 /*   str += '</ul>'*/

                        /*str+="<div id='Pagination'></div><span class='page-sum'>共<strong class='allPage'>"+res.last_page+"</strong>页</span>"*/


                    $(".myinfo-page").append(str);
                    //$('.myinfo-page').html(str_pag);

                    $('.result-order .counts').html('数量:'+res.total);
                    //修改隐藏where条件
                    //$('#where').val(data.where);


                    $(".modal-new-list").modal();
                    //$(".btn-primary").attr("id",this);
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