@extends("layouts.cert")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>审核操作</li>
                <li class="active">企业认证审核</li>
            </ol>
            <div class="section-body contain-lg change-pwd">
                @foreach($datas as $data)
                    <div class="container-fluid details-bg">
                        <div class="col-md-12 details-tit"><h2 class="cert-company">{{$data->enterprisename}}</h2></div>
                        <div class="col-md-6 details-tit"><span class="cert-industry">{{$data->created_at}}</span></div>
                        <div class="col-md-6 details-tit"><span class="cert-industry">联系电话：{{$data->phone}}</span></div>
                        <div class="col-md-6 details-tit"><p class="cert-industry">行业：{{$data->industry}}</p></div>
                        <div class="col-md-6 details-tit"><p class="cert-industry">规模：{{$data->size}}人</p></div>
                        <div class="col-md-6 details-tit"><p class="cert-industry">地区：{{$data->address}}</p></div>
                    </div>
                    <div class="container-fluid details-bg">
                        <p class="details-tit details-desc">简介：{{$data->brief}}</p>
                    </div>
                    <div class="container-fluid details-bg">
                        <div class="details-tit clearfix">
                            <div class="col-md-4 cert-img"><img onclick="javascript:showimage('http://images.ziyawang.com{{$data->licenceimage}}');" src="http://images.ziyawang.com{{$data->licenceimage}}" /></div>
                            <div class="col-md-4 cert-img"><img onclick="javascript:showimage('http://images.ziyawang.com{{$data->licenceimage}}');" src="http://images.ziyawang.com{{$data->licenceimage}}" /></div>
                        </div>
                    </div>
                    @if($data->configid==1)
                        <div class="details-tit details-btns">
                            <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1" id="{{$data->enterpriseid}}">通过审核</button></a>
                            <a href="javascript:;" onclick="showReason({{$data->enterpriseid}})"><button type="button" class="btn btn-block ink-reaction btn-support5">拒绝审核</button></a>
                        </div>
                    @elseif($data->configid==2)
                        <div class="details-tit details-btns">
                            <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-default">已拒绝</button></a>
                        </div>
                    @else
                        <div class="details-tit details-btns">
                            <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-default">待缴费</button></a>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>
    </div>
    <script>
        $(".btn-support1").on("click",function(){
            var enterpriseId=$(this).attr("id");
            $.ajax({
                url:"{{asset('/changeEnterprise')}}",
                data:{"configid":3,"enterpriseId":enterpriseId},
                dataType:"json",
                type:"POST",
                success:function(res){
                    if(res['code']=="success"){
                        window.location.href="{{asset('/cert_enterprise')}}";
                    }else{
                        alert("审核失败");
                        window.location.href="{{asset('/cert_enterprise')}}";
                    }
                }
            })
        })

        $(function(){
            $(".btn-primary").on("click",function (){
                var remark=$("#textarea").val();
                var enterpriseId=$(this).attr("id");
                $.ajax({
                    url:"{{asset('/changeEnterprise')}}",
                    data:{"remark":remark,"enterpriseId":enterpriseId,"configid":2},
                    dataType:"json",
                    type:"POST",
                    success:function(res){
                        if(res['code']=="success"){
                            window.location.href="{{asset('/cert_enterprise')}}";
                        }else{
                            alert("审核失败");
                            window.location.href="{{asset('/cert_enterprise')}}";
                        }
                    }
                })
            });
        })
    </script>
@endsection