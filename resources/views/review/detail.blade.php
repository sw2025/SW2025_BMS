@extends("layouts.extend")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>项目评议</li>
                <li><a href="{{url('serve_supply')}}">项目评议列表</a> </li>
                <li class="active">详情</li>
            </ol>
            <div class="section-body contain-lg change-pwd">
                <div class="container-fluid details-bg">
                    <div class="col-md-12 details-tit"><h1 class="cert-company">{{$datas->enterprisename}}</h1></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">{{$datas->showtime}}</span></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">联系电话：{{$datas->phone}}</span></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry"><span style="font-size: 14px;font-weight: bold;">项目分类：</span>{{$datas->domain1}}-{{--{{$datas->domain2}}--}}</p></div>

                    @if($datas->configid >= 4)
                        @foreach($pushOk as $value)
                            @if($datas->showid==$value->showid)
                                <p class="cert-zone"><b>推送专家：<a style="cursor:pointer;text-decoration:none;"> {{$value->expertname}}</a></b>&nbsp;&nbsp;
                                    @if($value->state >= 2)
                                        (已评议)
                                    @else
                                        (未评议)
                                    @endif

                                </p>
                            @endif
                        @endforeach
                    @else
                    @endif
                </div>
                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc"><span style="font-size: 14px;font-weight: bold;">项目详情：</span>{{$datas->brief}}</p>
                </div>
                <h3>项目BP</h3>
                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc"><h3><b><a href="{{asset('./show/'.$datas->bpurl)}}" target="_blank">{{$datas->bpname}}</a></b></h3></p>
                </div>
                <h3>专家评议</h3>
                <div class="container-fluid details-bg">
                    @foreach($message as $v)
                        <h3>{{$v->expertname}}</h3>
{{--
                        <p class="details-tit details-desc"><b><a href="{{asset('./show/')}}.{{$datas->bpurl}}" target="_blank">{{$v->content}}</a></b></p>
--}}
                    @endforeach
                </div>


                @if($datas->configid == 1)
                    <div class="col-md-2 set-certificate">
                        <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1 sup_allow" index="{{$datas->showid}}" >通过审核</button></a>
                        <a href="javascript:;" onclick="showReason(); $('.reject-reasons button').attr('id',{{$datas->showid}})"><button type="button" class="btn btn-block ink-reaction btn-support5">拒绝审核</button></a>
                    </div>
                @else
                    <a href="javascript:;"><button type="button" class="btn btn-block " style="background-color:green;color:white;">{{$config[$datas->configid]}}</button></a>
                @endif
               {{-- @elseif($datas->configid == 3)
                    <div class="col-md-2 set-certificate">
                        <a href="javascript:;"><button type="button" class="btn btn-block " style="background-color: red;color:white; ">未通过</button></a>
                    </div>
                @elseif($datas->configid == 2)
                    <div class="col-md-2 set-certificate">
--}}{{--
                        <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-success eve_put" index="{{$datas->showid}}" id="{{$datas->showid}}" onclick="push(this)" >推送项目BP</button></a>
--}}{{--
                        <a href="javascript:;"><button type="button" class="btn btn-block">已支付</button></a>

                    </div>
                @elseif($datas->configid == 4)
                        <div class="col-md-2 set-certificate">
                            <a href="javascript:;"><button type="button" class="btn btn-block">已推送</button></a>
                        </div>

                @elseif($datas->configid == 5)
                    <div class="col-md-2 set-certificate">
                        <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-default refuse" id="{{$datas->showid}}">已完成</button></a>
                    </div>
                @elseif($datas->configid == 6)
                    <div class="col-md-2 set-certificate">
                        <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-default refuse" id="{{$datas->showid}}">已评价</button></a>
                    </div>
                @endif--}}

            </div>
        </section>
    </div>
@endsection