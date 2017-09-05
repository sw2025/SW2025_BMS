@extends("layouts.cert")
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
                <li class="active">专家认证审核</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="cert-state-btns">
                    <a href="javascript:;" class="ver_all" @if(empty($status) || $status  == 'all') id="hoverstyle" @endif>全部</a>
                    <a href="javascript:;" class="ver_wait" @if(!empty($status) && $status == 'wait') id="hoverstyle" @endif>待认证</a>
                    <a href="javascript:;" class="ver_faild" @if(!empty($status) && $status == 'fail') id="hoverstyle" @endif>认证失败</a>
                </div>


                <div class="cert-list">
                    @foreach($datas as $data)
                        <div class="container-fluid cert-item">
                            <div class="col-md-10 cert-border">
                                <div class="container-fluid">
                                    <div class="col-md-4">
                                        <h2 class="cert-company"><a href="{{asset('/details_expert')}}?expertid={{$data->expertid}}" class="look-link">{{$data->expertname}}</a></h2>
                                        <span class="cert-time">{{$data->created_at}}</span>
                                        <span class="cert-telephone">联系电话：{{$data->phone}}</span>
                                        <p class="cert-industry">擅长行业：{{$data->industry}}</p>
                                        <p class="cert-industry">擅长问题：{{$data->domain1}}/{{$data->domain2}}</p>
                                        <p class="cert-scale">专家分类：{{$data->category}}</p>
                                        <p class="cert-zone">地区：{{$data->address}}</p>
                                    </div>
                                    <div class="col-md-4 cert-img"><img onclick="javascript:showimage('{{$data->licenceimage}}');" src="{{$data->licenceimage}}" /></div>
                                    <div class="col-md-4 cert-img"><img onclick="javascript:showimage('{{$data->showimage}}');" src="{{$data->showimage}}" /></div>
                                </div>
                            </div>
                            <div class="col-md-2 set-certificate">
                                @if($data->configid==1)
                                    <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1" id="{{$data->expertid}}">通过审核</button></a>
                                    <a href="javascript:;" onclick="showReason({{$data->expertid}});"><button type="button" class="btn btn-block ink-reaction btn-support5" id="{{$data->expertid}}">拒绝审核</button></a>
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

            window.location = '{{url('cert_expert','fail')}}';
        });
        $('.ver_all').on('click',function(){
            window.location = '{{url('cert_expert','all')}}';
        });
        $('.ver_wait').on('click',function(){
            window.location = '{{url('cert_expert','wait')}}';
        })

        $(".btn-support1").on("click",function(){
            $(".btn-support1").attr('disabled','disabled');
            var expertid=$(this).attr("id");
            $.ajax({
                url:"{{asset('/changeExpert')}}",
                data:{"configid":2,"expertid":expertid},
                dataType:"json",
                type:"POST",
                success:function(res){
                    if(res['code']=="success"){
                        alert("操作成功");
                        window.location.href="{{asset('/cert_expert')}}";
                    }else{
                        alert("操作失败");
                        window.location.href="{{asset('/cert_expert')}}";
                    }
                }
            })
        })

        $(function(){
            $(".btn-primary").on("click",function (){
                $(".btn-primary").attr('disabled','disabled');
                var remark=$("#textarea").val();
                var expertid=$(this).attr("id");
                $.ajax({
                    url:"{{asset('/changeExpert')}}",
                    data:{"remark":remark,"expertid":expertid,"configid":3},
                    dataType:"json",
                    type:"POST",
                    success:function(res){
                        if(res['code']=="success"){
                            alert("操作成功");
                            window.location.href="{{asset('/cert_expert')}}";
                        }else{
                            alert("操作失败");
                            window.location.href="{{asset('/cert_expert')}}";
                        }
                    }
                })
            });
        })

    </script>
@endsection