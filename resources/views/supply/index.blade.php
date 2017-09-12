@extends("layouts.extend")
@section("content")
    <style>
        #hoverstyle{
            color: #e3643d;
            border-color: #e3643d;
        }

    </style>
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>审核操作</li>
                <li class="active">供求信息审核</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="cert-state-btns">
                    <a href="javascript:;" class="ver_all" @if(empty($action) || $action  == 'all') id="hoverstyle" @endif>全部</a>
                    <a href="javascript:;" class="ver_wait" @if(!empty($action) && $action == 'wait') id="hoverstyle" @endif>待认证</a>
                    <a href="javascript:;" class="ver_faild" @if(!empty($action) && $action == 'fail') id="hoverstyle" @endif>认证失败</a>
                </div>
                <div class="cert-list">
                    @foreach($datas as $v)
                        <div class="container-fluid cert-item">
                            <div class="col-md-10 cert-border">
                                <div class="container-fluid">
                                    <div class="col-md-4">
                                        <h2 class="cert-company"><a href="{{url('/details_supply', $v->needid)}}" class="look-link">【{{$v->role}}】@if(!empty($v->entname) && !empty($v->extname)) {{$v->entname.' / '.$v->extname}} @else {{$v->entname or $v->extname}} @endif </a></h2>
                                        <span class="cert-telephone">联系电话：{{$v->phone}}</span>
                                        <p class="cert-scale">需求分类：{{$v->domain1}}/{{$v->domain2}}</p>
                                    </div>
                                    <div class="col-md-8 cert-cap">
                                        <span class="cert-work-time">{{$v->needtime}}</span>
                                        <span>{{$v->brief}}</span>
                                    </div>
                                </div>
                            </div>
                            @if($v->configid == 1)

                                <div class="col-md-2 set-certificate">
                                    <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1 sup_allow" index="{{$v->needid}}" >通过审核</button></a>
                                    <a href="javascript:;" onclick="showReason(); $('.reject-reasons button').attr('id',{{$v->needid}})"><button type="button" class="btn btn-block ink-reaction btn-support5">拒绝审核</button></a>
                                </div>

                            @elseif($v->configid == 2)

                                <div class="col-md-2 set-certificate">
                                    <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-default refuse" id="{{$v->needid}}">已拒绝</button></a>
                                </div>

                            @endif

                        </div>
                    @endforeach
                    <div class="pages">
                        {!! $datas->render() !!}
                        {{-- <div class="oh"><div id="Pagination"></div><span class="page-sum">共<strong class="allPage">1</strong>页</span></div>--}}
                    </div>
                        <input type="hidden" id="flag" index="0">
                </div>

                <script>
                    $('.ver_faild').on('click',function () {
                        window.location = '{{url('cert_supply','fail')}}';
                    });
                    $('.ver_all').on('click',function () {
                        window.location = '{{url('cert_supply','all')}}';
                    });
                    $('.ver_wait').on('click',function () {
                        window.location = '{{url('cert_supply','wait')}}';
                    });

                    $('.sup_allow').on('click',function () {
                        var flag = $('#flag').attr('index');
                        $('#flag').attr("index",1);
                        var supply_id=$(this).attr("index");
                        $.post('{{url('changeSupply')}}',{'supply_id':supply_id,'config_id':3,'flag':flag},function (data) {
                            if (data.errorMsg == 'success') {
                                alert("操作成功");
                                window.location.href = "{{url('/cert_supply')}}";
                            } else {
                                alert("操作失败或反应超时");
                                window.location.href = "{{url('/cert_supply')}}";
                            }
                        },'json');
                    });
                    $(function () {
                        $('.reject-reasons button').on('click',function () {
                            var flag = $('#flag').attr('index');
                            $('#flag').attr("index",1);
                            var remark=$(".reject-reasons textarea").val();
                            var supply_id=$(this).attr("id");
                            $.post('{{url('changeSupply')}}',{'supply_id':supply_id,'remark':remark,'config_id':2,'flag':flag},function (data) {
                                if (data.errorMsg == 'success') {
                                    alert("操作成功");
                                    window.location.href = "{{url('/cert_supply')}}";
                                } else {
                                    alert("操作失败或反应超时");
                                    window.location.href = "{{url('/cert_supply')}}";
                                }
                            },'json');
                        });
                    })
                    $(".refuse").on("click",function(){
                        var id=$(this).attr('id');
                        $.ajax({
                            url:"{{url('getRemark')}}",
                            data:{"type":"supply","id":id},
                            dateType:"json",
                            type:"POST",
                            success:function(res){
                                layer.alert(res);
                            }
                        })
                    })
                </script>
            </div>
        </section>
    </div>
@endsection