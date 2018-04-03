@extends("layouts.extend")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>线下路演</li>
                <li><a href="">线下路演列表</a> </li>
                <li class="active">详情</li>
            </ol>
            <div class="section-body contain-lg change-pwd">
                <div class="container-fluid details-bg">
                    <div class="col-md-12 details-tit"><h1 class="cert-company">@if(unserialize($datas->basicdata)['enterprisename']){{unserialize($datas->basicdata)['enterprisename']}}@else @endif<span style="float: right;">申请时间：{{$datas->showtime}}</span></h1></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">联系电话：{{$datas->phone}}</span></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">公司行业：@if(unserialize($datas->basicdata)['industry']){{unserialize($datas->basicdata)['industry']}}@else @endif</span></div>



                </div>

                <div class="container-fluid details-bg">

                    @if($datas->level==2)
                        @foreach($pushOk as $value)
                            @if($datas->showid==$value->showid)
                                <p class="details-tit details-desc"><b>推送专家：<a style="cursor:pointer;text-decoration:none;">{{$value->expertname}}</a></b>
                                    @if($value->state >= 2)
                                        @foreach($message as $vv)
                                            @if($vv->isyes==1)
                                              有兴趣
                                            @else
                                              无兴趣
                                            @endif
                                        @endforeach
                                    @else
                                         (未评价)

                                    @endif
                                </p>
                            @endif
                        @endforeach
                    @endif

                    <p class="details-tit details-desc"><span style="font-size: 14px;font-weight: bold;">项目标题：</span>{{$datas->title}}</p>
                    <p class="details-tit details-desc"><span style="font-size: 14px;font-weight: bold;">项目领域：</span>{{$datas->domain1}}</p>
                    <p class="details-tit details-desc"><span style="font-size: 14px;font-weight: bold;">一句话简介：</span>{{$datas->oneword}}</p>

                    <p class="details-tit details-desc"><span style="font-size: 14px;font-weight: bold;">项目详情：</span>{{$datas->brief}}</p>
                </div>


                <div class="container-fluid details-bg">
                    <p><b><h4>提交的项目：</h4></b></p>
                    <p class="cert-scale"><span> </span></p>
                    <p class="cert-scale">项目：<span><a href="{{env('ImagePath')}}/show/{{$datas->bpurl}}" target="_blank">{{$datas->bpname}}</a></span></p>
                </div>
            </div>

            @if($datas->level==2)
                @if($datas->configid == 4)
                    <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-error eve_put"   style="background: yellow;" >推送项目（已推送）</button></a>
                @else
                    <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-success eve_put" index="{{$datas->showid}}" id="{{$datas->showid}}" onclick="push(this)" >推送项目BP</button></a>

                @endif
            @else
                <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-error eve_put"   >免费通道提交的项目</button></a>
            @endif
        </section>
    </div>
@endsection