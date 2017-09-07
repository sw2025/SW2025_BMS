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
                <li class="active">提现申请审核</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="cert-state-btns">
                    <a href="javascript:;" class="ver_all" @if(empty($status) || $status  == 'all') id="hoverstyle" @endif>全部</a>
                    <a href="javascript:;" class="ver_wait" @if(!empty($status) && $status == 'wait') id="hoverstyle" @endif>待认证</a>
                    <a href="javascript:;" class="ver_faild" @if(!empty($status) && $status == 'fail') id="hoverstyle" @endif>认证失败</a>
                </div>
                <div class="cert-recharge container-fluid">
                    @foreach($datas as $data)
                    <div class="col-md-4">
                        <div class="cert-recharge-item">
                            <h2 class="cert-company"><a href="{{asset('/details_recharge')}}?id={{$data->userid}}" class="look-link">{{$data->enterprisename or $data->expertname}}</a></h2>
                            <span class="cert-telephone">联系电话：{{$data->phone}}</span>
                            <span class="cert-recharge-time">{{$data->billtime}}</span>
                            <p class="cert-money">提现金额：{{$data->money}}<span class="money-color"></span></p>
                            @if($data->type=='在途')
                                <div class="cert-recharge-btns">
                                    <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1" id="{{$data->id}}">通过审核</button></a>
                                    <a href="javascript:;" onclick="showReason({{$data->id}});"><button type="button" class="btn btn-block ink-reaction btn-support5" id="{{$data->id}}">拒绝审核</button></a>
                                </div>
                            @else
                                <div class="cert-recharge-btns">
                                    <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-default refuse" id="{{$data->id}}" >已拒绝</button></a>
                                </div>
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
            window.location = '{{url('cert_recharge','fail')}}';
        });
        $('.ver_all').on('click',function(){
            window.location = '{{url('cert_recharge','all')}}';
        });
        $('.ver_wait').on('click',function(){
            window.location = '{{url('cert_recharge','wait')}}';
        })

        $(".btn-support1").on("click",function(){
            var id=$(this).attr("id");
            $(".btn-support1").attr('disabled','disabled');
            $.ajax({
                url:"{{asset('/changeRecharge')}}",
                data:{"type":'支出',"id":id,"channel":"提现成功"},
                dataType:"json",
                type:"POST",
                success:function(res){
                    if(res['code']=="success"){
                        window.location.href="{{asset('/cert_recharge')}}";
                    }else{
                        alert("审核失败");
                        window.location.href="{{asset('/cert_recharge')}}";
                    }
                }
            })
        })

        $(function(){
            $(".btn-primary").on("click",function (){
                var remark=$("#textarea").val();
                $(".btn-primary").attr('disabled','disabled');
                var id=$(this).attr("id");
                $.ajax({
                    url:"{{asset('/changeRecharge')}}",
                    data:{"remark":remark,"id":id,"type":"收入","channel":"提现失败"},
                    dataType:"json",
                    type:"POST",
                    success:function(res){
                        if(res['code']=="success"){
                            window.location.href="{{asset('/cert_recharge')}}";
                        }else{
                            alert("审核失败");
                            window.location.href="{{asset('/cert_recharge')}}";
                        }
                    }
                })
            });
        })
        $(".refuse").on("click",function(){
            var id=$(this).attr('id');
            $.ajax({
                url:"{{url('getRemark')}}",
                data:{"type":"recharge","id":id},
                dateType:"json",
                type:"POST",
                success:function(res){
                    layer.alert(res);
                }
            })
        })
    </script>
@endsection