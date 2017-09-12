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
                <li>审核操作</li>
                <li class="active">办事服务审核</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="cert-state-btns">
                    <a href="javascript:;" class="ver_all" @if(empty($action) || $action  == 'all') id="hoverstyle" @endif>全部</a>
                    <a href="javascript:;" class="ver_wait" @if(!empty($action) && $action == 'wait') id="hoverstyle" @endif>待认证</a>
                    <a href="javascript:;" class="ver_fail" @if(!empty($action) && $action == 'fail') id="hoverstyle" @endif>认证失败</a>
                    <a href="javascript:;" class="ver_wput" @if(!empty($action) && $action == 'wput') id="hoverstyle" @endif>待推送</a>
                </div>
                <div class="cert-list">
                    @foreach($datas as $v)
                        <div class="container-fluid cert-item">
                            <div class="col-md-10 cert-border">
                                <div class="container-fluid">
                                    <div class="col-md-4">
                                        <h2 class="cert-company"><a href="{{asset('/details_work/'.$v->eventid)}}" class="look-link">【{{$v->role}}】@if(!empty($v->enterprisename) && !empty($v->expertname)) {{$v->enterprisename.' / '.$v->expertname}} @else {{$v->enterprisename or $v->expertname}} @endif</a></h2>
                                        <span class="cert-telephone">联系电话：{{$v->phone}}</span>
                                        <p class="cert-scale">需求分类：<span>{{$v->domain1}}/{{$v->domain2}}</span></p>
                                        <p class="cert-zone">指定专家：系统匹配</p>
                                    </div>
                                    <div class="col-md-8 cert-cap">
                                        <span class="cert-work-time">{{$v->eventtime}}</span>
                                        <span>{{$v->brief}}</span>
                                    </div>
                                </div>
                            </div>
                            @if($v->configid == 1)
                            <div class="col-md-2 set-certificate">
                                <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1 eve_allow" index="{{$v->eventid}}">通过审核</button></a>
                                <a href="javascript:;" onclick="showReason();$('.reject-reasons button').attr('id',{{$v->eventid}})"><button type="button" class="btn btn-block ink-reaction btn-support5">拒绝审核</button></a>
                            </div>
                            @elseif($v->configid == 2)
                                <div class="col-md-2 set-certificate">
                                    <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-success eve_put" index="{{$v->eventid}}" id="{{$v->eventid}}" onclick="push(this)" >办事推送</button></a>
                                </div>
                            @elseif($v->configid == 3)
                                <div class="col-md-2 set-certificate">
                                    <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-default refuse" id="{{$v->eventid}}">已拒绝</button></a>
                                </div>
                            @endif

                        </div>
                    @endforeach
                    <div class="pages">
                        {!! $datas->render() !!}
                        {{-- <div class="oh"><div id="Pagination"></div><span class="page-sum">共<strong class="allPage">1</strong>页</span></div>--}}
                    </div>
                </div>
                <input type="hidden" id="flag" index="0">
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
            window.location = '{{url('cert_work','fail')}}';
        });
        $('.ver_all').on('click',function () {
            window.location = '{{url('cert_work','all')}}';
        });
        $('.ver_wait').on('click',function () {
            window.location = '{{url('cert_work','wait')}}';
        });
        $('.ver_wput').on('click',function () {
            window.location = '{{url('cert_work','wput')}}';
        });
        /**
         *审核通过
         */
        $('.eve_allow').on('click',function () {
            var flag = $('#flag').attr('index');
            $('#flag').attr("index",1);
            var eve_id=$(this).attr("index");
            $.post('{{url('changeEvent')}}',{'event_id':eve_id,'config_id':2,'flag':flag},function (data) {
                if (data.errorMsg == 'success') {
                    alert("操作成功");
                    window.location.href = "{{url('cert_work')}}";
                } else {
                    alert("审核失败或反应超时");
                    window.location.href = "{{url('cert_work')}}";
                }
            },'json');
        });

        /**
         * 办事推送
         */
        /*$('.eve_put').on('click',function () {
            var flag = $('#flag').attr('index');
            $('#flag').attr("index",1);
            var eve_id=$(this).attr("index");
            $.post('{{url('changeEvent')}}',{'event_id':eve_id,'config_id':4,'flag':flag},function (data) {
                if (data.errorMsg == 'success') {
                    alert("操作成功");
                    window.location.href = "{{url('cert_work')}}";
                } else {
                    alert("推送失败或反应超时");
                    window.location.href = "{{url('cert_work')}}";
                }
            },'json');
        });*/

        /**
         * 办事审核不通过
         */
        $(function () {
            $('.reject-reasons button').on('click',function () {
                var flag = $('#flag').attr('index');
                $('#flag').attr("index",1);
                var remark=$(".reject-reasons textarea").val();
                var eve_id=$(this).attr("id");
                $.post('{{url('changeEvent')}}',{'event_id':eve_id,'remark':remark,'config_id':3,'flag':flag},function (data) {
                    if (data.errorMsg == 'success') {
                        alert("操作成功");
                        window.location.href = "{{url('/cert_work')}}";
                    } else {
                        alert("审核失败或反应超时");
                        window.location.href = "{{url('/cert_work')}}";
                    }
                },'json');
            });
        })
        $(".refuse").on("click",function(){
            var id=$(this).attr('id');
            $.ajax({
                url:"{{url('getRemark')}}",
                data:{"type":"work","id":id},
                dateType:"json",
                type:"POST",
                success:function(res){
                    layer.alert(res);
                }
            })
        })
        $(function(){
            $(".btn-primary").on("click",function (){
                var remark=$("#textarea").val();
                $(".btn-primary").attr('disabled','disabled');
                var consultid=$(this).attr("id");
                $.ajax({
                    url:"{{asset('/changeVideo')}}",
                    data:{"remark":remark,"consultid":consultid,"configid":3},
                    dataType:"json",
                    type:"POST",
                    success:function(res){
                        if(res['code']=="success"){
                            window.location.href="{{asset('/cert_video')}}";
                        }else{
                            alert("审核失败");
                            window.location.href="{{asset('/cert_video')}}";
                        }
                    }
                })
            });
        })
        $(".refuse").on("click",function(){
            var id=$(this).attr('id');
            $.ajax({
                url:"{{url('getRemark')}}",
                data:{"type":"video","id":id},
                dateType:"json",
                type:"POST",
                success:function(res){
                    layer.alert(res);
                }
            })
        })
        function push(e){
            var type=$(e).closest('.cert-item').find('.cert-scale span').text();
            var eventId=$(e).attr("id");
            var datas=getCountExpert(eventId);
            var expertCount=datas.expertCount;
            var expertstring=datas.expertids;
            console.log(expertstring);
            $.ajax({
                url:"{{url('selectExpert')}}",
                data:{"type":type},
                dateType:"json",
                type:"POST",
                async:false,
                success:function(res){
                    $(".supply-list").html("");
                    var str="";
                    $.each(res.data,function(key,value){
                        console.log(value.showimage);
                        var ExpertId=value.expertid;
                        str="<li class='col-md-4'>";
                        str+="<input type='hidden' id='event' value='"+eventId+"'>"
                        str+="<a href='uct_resdetail.html' class='expert-list-link'>";
                        str+="<div class='exp-list-top'>"
                        str+="<span class='exp-list-img'><img src='{{env('ImagePath')}}"+value.showimage+"'></span>";
                        str+="<div class='exp-list-brief'>"
                        str+="<span class='exp-list-name'>"+value.expertname+"</span>"
                        str+="<span class='exp-list-video'><i class='fa fa-play-circle-o'></i>视频咨询：<em>免费</em></span>"
                        str+="<span class='exp-list-best'><i class='fa fa-thumbs-o-up'></i>擅长领域：<em>"+value.domain1+"</em></span></div>"
                        str+="<div class='exp-list-lab'>"
                        str+="<span class='exp-lab-a'>不知道</span>"
                        str+="<span class='exp-lab-a'>不知道</span>"
                        str+="<span class='exp-lab-a'>不知道</span>"
                        str+="<span class='exp-lab-a'>不知道</span>"
                        str+="</div>"
                        str+="</div>"
                        str+="<div class='exp-list-desc'>"
                        str+=value.brief
                        str+="</div>"
                        str+="</a>"
                        var strExpertId=String(ExpertId)
                        if(expertstring!=0){
                            if(expertstring.indexOf(strExpertId)>=0){
                                str+="<a href='javascript:;'  id='event_"+value.expertid+"' class='xuanzhong xzchecked'><i class='fa fa-check-square'></i></a>"
                            }else{
                                str+="<a href='javascript:;' onclick='xuanzhong("+value.expertid+")' id='event_"+value.expertid+"' class='xuanzhong'><i class='fa fa-check-square'></i></a>"
                            }
                        }else{
                            str+="<a href='javascript:;' onclick='xuanzhong("+value.expertid+")' id='event_"+value.expertid+"' class='xuanzhong'><i class='fa fa-check-square'></i></a>"
                        }
                        str+="</li>"
                        $(".supply-list").append(str);
                    })
                    $(".modal-new-list").modal();
                    $(".btn-primary").attr("id",this);

                }
            })

        }
        var getCountExpert=function(eventId){
            var count;
            $.ajax({
                url:"{{url('eventCountExpert')}}",
                data:{"eventId":eventId},
                dateType:"json",
                async:false,
                type:"POST",
                success:function(res){
                    count=res;
                }
            })
            return count;
        }
        var xuanzhong=function(id){
            $("#event_"+id).toggleClass('xzchecked');
        }
        $("#btnOK").on("click",function(){
            var expertSelect="";
            $('.xzchecked').each(function(index,element){
                var ids=$(this).attr('id');
                var num=ids.lastIndexOf('_')+1;
                id=ids.substring(num);
                expertSelect=id+','+expertSelect;
            })
            var eventId=$("#event").val();
            if(!expertSelect){
                alert("请您选择专家");
                return false;
            }
            $.ajax({
                url:"{{url('eventPushSelect')}}",
                data:{"expertSelect":expertSelect,"eventId":eventId},
                dateType:"json",
                type:"post",
                success:function(res){
                    window.location.reload();
                }
            })
        })
    </script>
@endsection