@extends("layouts.extend")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>审核操作</li>
                <li class="active">提现信息维护</li>
            </ol>
            <div class="section-body contain-lg change-pwd">
                <div class="container-fluid details-bg">
                    <div class="col-md-12 details-tit"><h2 class="cert-company">{{$datas->enterprisename or $datas->expertname}}</h2></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">{{$datas->billtime}}</span></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">联系电话：{{$datas->phone}}</span></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">提现金额：<span class="money-color">￥{{$datas->money}}</span></p></div>
                </div>

                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc">简介：{{$datas->brief}}和“一带一路”建设同欧亚经济联盟对接。面对复杂多变的国际形势，中俄发挥大国作用和担当，树立了以合作共赢为核心的新型国际关系典范，为维护地区及世界和平稳定贡献了强大正能量。</p>
                </div>
                @if($datas->type=='在途')
                <div class="details-tit details-btns">
                    <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1" id="{{$datas->id}}">通过审核</button></a>
                    <a href="javascript:;" onclick="showReason({{$datas->id}});"><button type="button" class="btn btn-block ink-reaction btn-support5" id="{{$datas->id}}">拒绝审核</button></a>
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
            var id=$(this).attr("id");
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
    </script>
@endsection