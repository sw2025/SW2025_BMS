@extends("layouts.extend")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>审核操作</li>
                <li class="active">视频信息维护</li>
            </ol>
            <div class="section-body contain-lg change-pwd">
                <div class="container-fluid details-bg">
                    <div class="col-md-12 details-tit"><h2 class="cert-company">{{$datas->enterprisename}}</h2></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">2017-07-02  12:10:35</span></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">联系电话：{{$datas->phone}}</span></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">开始时间：{{$datas->starttime}}</p></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">结束时间：{{$datas->endtime}}</p></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">需求分类：{{$datas->domain1}}-{{$datas->domain2}}-------------{{$datas->name}}</p></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">@if($datas->state === "0") 指定专家 @else 系统匹配 @endif</p></div>
                </div>
                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc">视频咨询详情：{{$datas->brief}}</p>
                </div>
                <h3>专家信息</h3>
                @foreach($expertData as $value)
                    <div class="container-fluid details-bg">
                        <div class="col-md-12 details-tit"><h2 class="cert-company">{{$value->expertname}}</h2></div>
                        <div class="col-md-12 details-tit"><span class="cert-industry"><img src="{{$value->showimage}}"></span></div>
                        <div class="col-md-6 details-tit"><span class="cert-industry">联系电话：{{$value->phone}}</span></div>
                        <div class="col-md-6 details-tit"><span class="cert-industry">专家分类：{{$value->category}}</span></div>
                        <div class="col-md-6 details-tit"><span class="cert-industry">地址：{{$value->address}}</span></div>
                        <div class="col-md-6 details-tit"><p class="cert-industry">擅长领域：{{$value->domain1}}-{{$value->domain2}}</p></div>
                        <div class="col-md-6 details-tit"><p class="cert-industry">擅长行业：{{$value->industry}}</p></div>
                        <div class="col-md-6 details-tit"><p class="cert-industry">专家状态：@if($value->state==2)响应@elseif($value->state==3)受邀@elseif($value->state==4)完成@elseif($value->state==5)失效@elseif($value->state==0)指定@elseif($value->state==1)匹配@endif</p></div>
                    </div>
                @endforeach

            </div>
        </section>
    </div>
@endsection