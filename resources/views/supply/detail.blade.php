@extends("layouts.extend")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>审核操作</li>
                <li><a href="{{url('serve_supply')}}">供求信息维护</a> </li>
                <li class="active">供求维护详情</li>
            </ol>
            <div class="section-body contain-lg change-pwd">
                <div class="container-fluid details-bg">
                    <div class="col-md-12 details-tit"><h1 class="cert-company">【{{$datas->role}}】@if(!empty($datas->expertname) && !empty($datas->enterprisename)){{$datas->enterprisename}}/{{$datas->expertname}} @else {{$datas->expertname or $datas->enterprisename}} @endif</h1></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">{{$datas->needtime}}</span></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">联系电话：{{$datas->phone}}</span></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry"><span style="font-size: 14px;font-weight: bold;">需求分类：</span>{{$datas->domain1}}/{{$datas->domain2}}</p></div>
                </div>
                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc"><span style="font-size: 14px;font-weight: bold;">企业/专家介绍：</span>@if(!empty($datas->expertname) && !empty($datas->enterprisename)) <br />企业：{{$datas->desc2}} <br /> 专家：{{$datas->desc1}} @else {{$datas->desc1 or $datas->desc2}}@endif</p>
                </div>
                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc"><span style="font-size: 14px;font-weight: bold;">供求详情：</span>{{$datas->brief}}</p>
                </div>
            </div>
        </section>
    </div>
@endsection