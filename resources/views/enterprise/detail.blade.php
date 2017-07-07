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
                    @endforeach
            </div>
        </section>
    </div>
@endsection