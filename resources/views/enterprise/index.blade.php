@extends("layouts.cert")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>审核操作</li>
                <li class="active">企业认证审核</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="cert-state-btns">
                    <a href="javascript:;" class="current">全部</a>
                    <a href="javascript:;">待认证</a>
                    <a href="javascript:;">认证失败</a>
                </div>
                <div class="cert-list">
                    @foreach($datas as $data)
                        <div class="container-fluid cert-item">
                            <div class="col-md-10 cert-border">
                                <div class="container-fluid">
                                    <div class="col-md-4">
                                        <h2 class="cert-company"><a href="javascript:;" class="look-link">{{$data->enterprisename}}</a></h2>
                                        <span class="cert-time">{{$data->created_at}}</span>
                                        <span class="cert-telephone">联系电话：{{$data->phone}}</span>
                                        <p class="cert-industry">行业：{{$data->industry}}</p>
                                        <p class="cert-scale">规模：{{$data->size}}人</p>
                                        <p class="cert-zone">地区：{{$data->address}}</p>
                                    </div>
                                    <div class="col-md-4 cert-img"><img onclick="javascript:showimage('http://images.ziyawang.com{{$data->licenceimage}}');" src="http://images.ziyawang.com{{$data->licenceimage}}" /></div>
                                    <div class="col-md-4 cert-img"><img onclick="javascript:showimage('http://images.ziyawang.com{{$data->showimage}}');" src="http://images.ziyawang.com{{$data->showimage}}" /></div>
                                </div>
                            </div>
                            <div class="col-md-2 set-certificate">
                                @if($data->configid==1)
                                    <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1">通过审核</button></a>
                                    <a href="javascript:;" onclick="showReason();"><button type="button" class="btn btn-block ink-reaction btn-support5">拒绝审核</button></a>
                                @else
                                    <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-default">已拒绝</button></a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pages">
                    {!! $datas->render() !!}
                    {{-- <div class="oh"><div id="Pagination"></div><span class="page-sum">共<strong class="allPage">1</strong>页</span></div>--}}
                </div>
            </div>
        </section>
    </div>
@endsection