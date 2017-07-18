@extends("layouts.extend")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>审核操作</li>
                <li class="active">视频咨询审核</li>
            </ol>
            <div class="section-body contain-lg change-pwd">
                <div class="container-fluid details-bg">
                    <div class="col-md-12 details-tit"><h2 class="cert-company">{{$datas->enterprisename}}</h2></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">{{$datas->created_at}}</span></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">联系电话：{{$datas->phone}}</span></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">开始时间：2017-07-03 12:00:00</p></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">结束时间：2017-07-03 13:00:00</p></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">需求分类：销售</p></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">指定专家：系统分配</p></div>
                </div>
                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc">简介：习近平代表中国政府和中国人民，向友好的俄罗斯政府和人民致以诚挚问候和良好祝愿。习近平指出，中俄两国是好邻居、好朋友、好伙伴，两国人民传统友谊源远流长。当前，中俄全面战略协作伙伴关系处于历史最好时期。双方在涉及对方核心利益问题上相互坚定支持，积极开展两国发展战略对接和“一带一路”建设同欧亚经济联盟对接。面对复杂多变的国际形势，中俄发挥大国作用和担当，树立了以合作共赢为核心的新型国际关系典范，为维护地区及世界和平稳定贡献了强大正能量。</p>
                </div>
                @if($datas->configid==1)
                    <div class="details-tit details-btns">
                        <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1" id="{{$datas->consultid}}">通过审核</button></a>
                        <a href="javascript:;" onclick="showReason({{$datas->consultid}});"><button type="button" class="btn btn-block ink-reaction btn-support5" id="{{$datas->consultid}}">拒绝审核</button></a>
                    </div>
                @elseif($datas->configid==2)
                    <div class="details-tit details-btns">
                        <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-default">推送</button></a>
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
            var consultid=$(this).attr("id");
            $(".btn-support1").attr('disabled','disabled');
            $.ajax({
                url:"{{asset('/changeVideo')}}",
                data:{"configid":2,"consultid":consultid},
                dataType:"json",
                type:"POST",
                success:function(res){
                    if(res['code']=="success"){
                        window.location.href=window.location;
                    }else{
                        alert("审核失败");
                        window.location.href=window.location;
                    }
                }
            })
        })

        $(function(){
            $(".btn-primary").on("click",function (){
                $(".btn-primary").attr('disabled','disabled');
                var remark=$("#textarea").val();
                var consultid=$(this).attr("id");
                $.ajax({
                    url:"{{asset('/changeVideo')}}",
                    data:{"remark":remark,"consultid":consultid,"configid":3},
                    dataType:"json",
                    type:"POST",
                    success:function(res){
                        if(res['code']=="success"){
                            window.location.href=window.location;
                        }else{
                            alert("审核失败");
                            window.location.href=window.location;
                        }
                    }
                })
            });
        })
    </script>
@endsection