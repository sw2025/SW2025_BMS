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
                    <div class="col-md-6 details-tit"><p class="cert-industry"><span style="font-size: 14px;font-weight: bold;">项目分类：</span>{{$datas->domain1}}-{{$datas->domain2}}</p></div>

                    @if($datas->configid >= 4)
                        @foreach($pushOk as $value)
                            @if($datas->showid==$value->showid)
                                <div class="col-md-6 details-tit"><span class="cert-industry">专家数量：{{$datas->basicdata}}</span></div>
                                <p class="cert-zone"><b>已推送专家姓名：<a style="cursor:pointer;text-decoration:none;"> {{$value->expertname}}</a></b>&nbsp;&nbsp;
                                    @if($counts!=0)
                                        @foreach($message as $expert)
                                            @if($value->showid==$expert->showid)
                                                @if($value->userid==$expert->userid)
                                                    (已评议)
                                                @else
                                                    (未评议)
                                                @endif
                                            @endif
                                        @endforeach
                                    @else
                                         (未评议)
                                    @endif

                                </p>
                            @endif
                        @endforeach
                    @else
                        <div class="col-md-6 details-tit"><span class="cert-industry">专家数量：{{$datas->basicdata}}</span></div>
                    @endif
                </div>
                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc"><span style="font-size: 14px;font-weight: bold;">项目详情：</span>{{$datas->brief}}</p>
                </div>
                <h3>项目BP</h3>
                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc"><h3><b><a href="{{env('ImagePath')}}/show/{{$datas->bpurl}}" target="_blank">{{$datas->bpname}}</a></b></h3></p>
                </div>


                @if($datas->configid == 1)
                    <div class="col-md-2 set-certificate">
                        <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1 sup_allow" index="{{$datas->showid}}" >通过审核</button></a>
                        <a href="javascript:;" onclick="showReason(); $('.reject-reasons button').attr('id',{{$datas->showid}})"><button type="button" class="btn btn-block ink-reaction btn-support5">拒绝审核</button></a>
                    </div>
                @elseif($datas->configid == 2)
                    <div class="col-md-2 set-certificate">
                        <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-success eve_put" style="background: red;">未通过</button></a>
                    </div>
                @elseif($datas->configid == 3)
                    <div class="col-md-2 set-certificate">
                        <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-success eve_put" index="{{$datas->showid}}" id="{{$datas->showid}}" onclick="push(this)" >推送项目BP</button></a>

                    </div>
                @elseif($datas->configid == 4)
                    <div class="col-md-2 set-certificate">
                        <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-success eve_put" index="{{$datas->showid}}" id="{{$datas->showid}}" onclick="push(this)" >已推送</button></a>
                    </div>
                @elseif($datas->configid == 5)
                    <div class="col-md-2 set-certificate">
                        <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-default refuse" id="{{$datas->showid}}">已完成</button></a>
                    </div>
                @elseif($datas->configid == 6)
                    <div class="col-md-2 set-certificate">
                        <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-default refuse" id="{{$datas->showid}}">已评价</button></a>
                    </div>
                @endif

            </div>
        </section>
    </div>
@endsection