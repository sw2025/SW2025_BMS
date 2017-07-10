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
                <li>审核操作<>
                <li class="active">企业认证审核<>
            </ol>
            <div class="section-body change-pwd">
                <div class="cert-state-btns">
                    <a href="javascript:;" class="ver_all" @if(empty($_GET['status']) || $_GET['status']  == 'all') id="hoverstyle" @endif>全部</a>
                    <a href="javascript:;" class="ver_wait" @if(!empty($_GET['status']) && $_GET['status'] == 'wait') id="hoverstyle" @endif>待认证</a>
                    <a href="javascript:;" class="ver_faild" @if(!empty($_GET['status']) && $_GET['status'] == 'fail') id="hoverstyle" @endif>认证失败</a>
                </div>


                <div class="cert-list">
                    @foreach($datas as $data)
                        <div class="container-fluid cert-item">
                            <div class="col-md-10 cert-border">
                                <div class="container-fluid">
                                    <div class="col-md-4">
                                        <h2 class="cert-company"><a href="{{asset('/details_expert')}}?expertid={{$data->expertid}}" class="look-link">{{$data->expertname}}专家</a></h2>
                                        <span class="cert-time">{{$data->created_at}}</span>
                                        <span class="cert-telephone">联系电话：{{$data->phone}}</span>
                                        <p class="cert-industry">擅长问题：{{$data->domain1}}/{{$data->domain2}}</p>
                                        <p class="cert-scale">专家分类：{{$data->category}}</p>
                                        <p class="cert-zone">{{$data->address}}</p>
                                    </div>
                                    <div class="col-md-4 cert-img"><img onclick="javascript:showimage('../img/zhanwei.jpg');" src="../img/zhanwei.jpg" /></div>
                                    <div class="col-md-4 cert-img"><img onclick="javascript:showimage('../img/zhanwei.jpg');" src="../img/zhanwei.jpg" /></div>
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
            var expertid=$(this).attr("id");
            $.ajax({
                url:"{{asset('/changeExpert')}}",
                data:{"configid":2,"expertid":expertid},
                dataType:"json",
                type:"POST",
                success:function(res){
                    if(res['code']=="success"){
                        window.location.href="{{asset('/cert_expert')}}";
                    }else{
                        alert("审核失败");
                        window.location.href="{{asset('/cert_expert')}}";
                    }
                }
            })
        })

        $(function(){
            $(".btn-primary").on("click",function (){
                var remark=$("#textarea").val();
                var expertid=$(this).attr("id");
                $.ajax({
                    url:"{{asset('/changeExpert')}}",
                    data:{"remark":remark,"expertid":expertid,"configid":3},
                    dataType:"json",
                    type:"POST",
                    success:function(res){
                        if(res['code']=="success"){
                            window.location.href="{{asset('/cert_expert')}}";
                        }else{
                            alert("审核失败");
                            window.location.href="{{asset('/cert_expert')}}";
                        }
                    }
                })
            });
        })

    </script>
@endsection