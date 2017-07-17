@extends("layouts.extend")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>审核操作</li>
                <li><a href="{{url('cert_supply')}}">供求信息审核</a> </li>
                <li class="active">供求信息详情</li>
            </ol>
            <div class="section-body contain-lg change-pwd">
                <div class="container-fluid details-bg">
                    <div class="col-md-12 details-tit"><h2 class="cert-company">{{$datas->name}}</h2></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">{{$datas->verifytime}}</span></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">联系电话：{{$datas->phone}}</span></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">需求分类：{{$datas->domain1}}/{{$datas->domain2}}</p></div>
                </div>
                <div class="container-fluid details-bg">
                    <p><h5>&ensp;&ensp;需求问题:</h5></p>
                    <p class="details-tit details-desc">{{$datas->brief}}</p>
                </div>


                @if($datas->configid == 1)

                    <div class="details-tit details-btns">
                        <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1 sup_allow" index="{{$datas->needid}}" >通过审核</button></a>
                        <a href="javascript:;" onclick="showReason(); $('.reject-reasons button').attr('id',{{$datas->needid}})"><button type="button" class="btn btn-block ink-reaction btn-support5">拒绝审核</button></a>
                    </div>

                @elseif($datas->configid == 3)

                    <div class="details-tit details-btns">
                        <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-default">已拒绝</button></a>
                    </div>

                @endif

            </div>
            <input type="hidden" id="flag" index="0">
        </section>
    </div>

    <script>

        $('.sup_allow').on('click',function () {
            var flag = $('#flag').attr('index');
            var supply_id=$(this).attr("index");
            $('#flag').attr("index",1);
            $.post('{{url('changeSupply')}}',{'supply_id':supply_id,'config_id':2,'flag':flag},function (data) {
                if (data.errorMsg == 'success') {
                    window.location.href = "{{url('/cert_supply')}}";
                } else {
                    alert("审核失败或反应超时");
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
                $.post('{{url('changeSupply')}}',{'supply_id':supply_id,'remark':remark,'config_id':3,'flag':flag},function (data) {
                    if (data.errorMsg == 'success') {
                        window.location.href = "{{url('/cert_supply')}}";
                    } else {
                        alert("审核失败或反应超时");
                        window.location.href = "{{url('/cert_supply')}}";
                    }
                },'json');
            });
        })

    </script>
@endsection