@extends("layouts.extend")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>审核操作</li>
                <li ><a href="{{url('cert_work')}}">办事服务审核</a></li>
                <li class="active">办事详情</li>
            </ol>
            <div class="section-body contain-lg change-pwd">
                <div class="container-fluid details-bg">
                    <div class="col-md-12 details-tit"><h2 class="cert-company">【{{$datas->role}}】 {{$datas->enterprisename or $datas->expertname}}</h2></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">{{$datas->verifytime}}</span></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">联系电话：{{$datas->phone}}</span></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">需求分类：{{$datas->domain1}}</p></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">指定专家：{{$datas->domain2}}</p></div>
                </div>
                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc">简介：{{$datas->brief}}</p>
                </div>
                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc">公司/专家简介：{{$datas->desc1 or $datas->desc2}}</p>
                </div>
                @if($datas->configid == 1)
                    <div class="col-md-2 set-certificate">
                        <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1">通过审核</button></a>
                        <a href="javascript:;" onclick="showReason();"><button type="button" class="btn btn-block ink-reaction btn-support5">拒绝审核</button></a>
                    </div>
                @elseif($datas->configid == 2)
                    <div class="col-md-2 set-certificate">
                        <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-success">通过审核</button></a>
                    </div>
                @elseif($datas->configid == 3)
                    <div class="col-md-2 set-certificate">
                        <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-default">已拒绝</button></a>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection