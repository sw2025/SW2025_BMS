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
                    <div class="col-md-12 details-tit"><h1 class="cert-company">【{{$datas->needtype}}】@if(!empty($datas->expertname)){{$datas->enterprisename}} @else {{$datas->expertname}} @endif</h1></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">{{$datas->needtime}}</span></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">联系电话：{{$datas->phone}}</span></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry"><span style="font-size: 14px;font-weight: bold;">需求分类：</span>{{$datas->domain1}}/{{$datas->domain2}}</p></div>
                </div>
                <div class="container-fluid details-bg"></div>
                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc"><span style="font-size: 14px;font-weight: bold;">企业/专家介绍：</span>@if(!empty($datas->enterprisename) && !empty($datas->expertname)) <br />企业：{{$datas->desc1}} <br /> 专家：{{$datas->desc2}} @else {{$datas->desc1 or $datas->desc2}}@endif</p>

                    <p class="details-tit details-desc"><span style="font-size: 14px;font-weight: bold;">供求详情：</span>{{$datas->brief}}</p>
                </div>

                <h3>评论</h3>
                @foreach($result as $big)
                    @if($big->parentid==0)
                    <div class="container-fluid details-bg">
                        <p class="details-tit details-desc"><span style="font-size: 14px;font-weight: bold;">评论：</span>{{$big->content}}</p>
                        <p><a href="{{asset('deleteSupplyContent?id='.$big->id.'&needid='.$datas->needid)}}" onclick="return confirm('您确定要删除!')"><button type="button" class="btn btn-block ink-reaction btn-support1" style="width: 100px;float: right;">删除</button></a></p>
                    @foreach($result as $small)
                            @if($small->parentid==$big->id)
                        <p class="details-tit details-desc"><span style="font-size: 14px;font-weight: bold;">楼中楼：</span>{{$small->content}}</p>
                                <p><a href="{{asset('deleteSupplyContent?id='.$small->id.'&needid='.$small->needid)}}" onclick="return confirm('您确定要删除!')"><button type="button" class="btn btn-block ink-reaction btn-support1" style="width: 100px;float: right;">删除</button></a></p>

                            @endif
                            @endforeach
                    </div>
                    @endif
                @endforeach
            </div>
        </section>
    </div>
@endsection