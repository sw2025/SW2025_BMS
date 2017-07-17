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
                <li class="active">视频咨询审核</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="cert-state-btns">
                    <a href="javascript:;" class="ver_all" @if(empty($status) || $status  == 'all') id="hoverstyle" @endif>全部</a>
                    <a href="javascript:;" class="ver_wait" @if(!empty($status) && $status == 'wait') id="hoverstyle" @endif>待认证</a>
                    <a href="javascript:;" class="ver_faild" @if(!empty($status) && $status == 'fail') id="hoverstyle" @endif>认证失败</a>
                    <a href="javascript:;" class="ver_pendingPush" @if(!empty($status) && $status == 'pendingPush') id="hoverstyle" @endif>待推送</a>
                </div>
                <div class="cert-list">
                @foreach($datas as $data)
                    <div class="container-fluid cert-item">
                        <div class="col-md-10 cert-border">
                            <div class="container-fluid">
                                <div class="col-md-4">
                                    <h2 class="cert-company"><a href="{{asset('/details_video')}}?consultid={{$data->consultid}}" class="look-link">{{$data->enterprisename}}公司</a></h2>
                                    <span class="cert-telephone">联系电话：{{$data->phone}}</span>
                                    <span class="cert-time start-time">开始时间：{{$data->created_at}}</span>
                                    <span class="cert-time end-time">结束时间：</span>
                                    <p class="cert-scale">需求分类：销售</p>
                                    <p class="cert-zone">指定专家：系统分配</p>
                                </div>
                                <div class="col-md-8 cert-cap">
                                    <span class="cert-work-time">2017-07-02  12:10:35</span>
                                    <span>婚礼用品部会有现成的专家为您提供所需的一切帮助和建议。婚礼用品部会有现成的专家为您提供所需的一切帮助和建议。婚礼用品部会有现成的专家为您提供所需的一切帮助和建议。</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 set-certificate">
                            @if($data->configid==1)
                                <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1" id="{{$data->consultid}}">通过审核</button></a>
                                <a href="javascript:;" onclick="showReason({{$data->consultid}});"><button type="button" class="btn btn-block ink-reaction btn-support5" id="{{$data->consultid}}">拒绝审核</button></a>
                            @elseif($data->configid==2)
                                <a href="javascript:;" onclick="showReason();"><button type="button" class="btn btn-block ink-reaction btn-support5">推送</button></a>
                            @else
                                <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-default">已拒绝</button></a>
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
    <script>
        $('.ver_faild').on('click',function(){
            window.location = '{{url('cert_video','fail')}}';
        });
        $('.ver_all').on('click',function(){
            window.location = '{{url('cert_video','all')}}';
        });
        $('.ver_wait').on('click',function(){
            window.location = '{{url('cert_video','wait')}}';
        });
        $('.ver_pendingPush').on('click',function(){
            window.location = '{{url('cert_video','pendingPush')}}';
        });

        $(".btn-support1").on("click",function(){
            var consultid=$(this).attr("id");
            $(".btn-support1").attr('disabled','disabled');
            $.ajax({
                url:"{{asset('/changeVideo')}}",
                data:{"configid":2,"consultid":consultid},
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
    </script>
@endsection