@extends("layouts.extend")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>审核操作</li>
                <li class="active">充值提现信息维护</li>
            </ol>
            <div class="section-body contain-lg change-pwd">
                <div class="container-fluid details-bg">
                    <div class="col-md-12 details-tit"><h2 class="cert-company">{{$data->expertname}}</h2></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">{{$data->billtime}}</span></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">联系电话：{{$data->phone}}</span></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">提现金额：<span class="money-color">￥{{$data->phone}}</span></p></div>
                </div>
                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc">{{$data->brief}}</p>
                </div>
            </div>
        </section>
    </div>
@endsection