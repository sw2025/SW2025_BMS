@extends("layouts.extend")
@section("content")
    <style>
        #hoverstyle{
            color: #e3643d;
            border-color: #e3643d;
        }

    </style>
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
                                        <p class="cert-scale">需求分类：{{$v->domain1}}</p>
                                        <p class="cert-zone">指定专家：{{$v->domain2}}</p>
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
                                    <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-success eve_put" index="{{$v->eventid}}">办事推送</button></a>
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

            <script>
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
                $('.eve_put').on('click',function () {
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
                });

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
            </script>
        </section>
    </div>
@endsection