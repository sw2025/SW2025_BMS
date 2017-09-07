@extends("layouts.cert")
@section("content")
    <div id="content">
        <section>

            <ol class="breadcrumb">
                <li>审核操作</li>
                <li class="active"><a href="{{asset('/cert_expert')}}">专家认证审核</a></li>
            </ol>
            <div class="section-body contain-lg change-pwd">
                <div class="container-fluid details-bg">
                    <div class="col-md-12 details-tit"><h2 class="cert-company">{{$datas->expertname}}</h2></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">{{$datas->created_at}}</span></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">联系电话：{{$datas->phone}}</span></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">擅长行业：{{$datas->industry}}</p></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">擅长问题：{{$datas->domain1}}/{{$datas->domain2}}</p></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">专家分类：{{$datas->category}}</p></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">地区：{{$datas->address}}</p></div>
                </div>
                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc">简介：{{$datas->brief}}</p>
                </div>
                <div class="container-fluid details-bg">
                    <div class="details-tit clearfix">
                        <div class="col-md-4 cert-img"><img onclick="javascript:showimage('{{$datas->licenceimage}}');" src="{{$datas->licenceimage}}" /></div>
                        <div class="col-md-4 cert-img"><img onclick="javascript:showimage('{{$datas->showimage}}');" src="{{$datas->showimage}}" /></div>
                    </div>
                </div>
                @if($datas->configid==1)
                <div class="details-tit details-btns">
                    <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1" id="{{$datas->expertid}}">通过审核</button></a>
                    <a href="javascript:;" onclick="showReason();"><button type="button" class="btn btn-block ink-reaction btn-support5" id="{{$datas->expertid}}">拒绝审核</button></a>
                </div>
                @else
                <div class="details-tit details-btns">
                    <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-default">已拒绝</button></a>
                </div>
                @endif
            </div>

        </section>
    </div>
    <script>
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
                        window.location.href=window.location;
                    }else{
                        alert("操作失败");
                        window.location.href=window.location;
                    }
                }
            })
        })

        $(function(){
            $(".btn-primary").on("click",function (){
                $(".btn-primary").attr('disabled','disabled');
                var remark=$("#textarea").val();
                var expertid=$('.btn-support5').attr("id");
                $.ajax({
                    url:"{{asset('/changeExpert')}}",
                    data:{"remark":remark,"expertid":expertid,"configid":3},
                    dataType:"json",
                    type:"POST",
                    success:function(res){
                        if(res['code']=="success"){
                            alert("操作成功");
                            window.location.href=window.location;
                        }else{
                            alert("操作失败");
                            window.location.href=window.location;
                        }
                    }
                })
            });
        })
    </script>
@endsection