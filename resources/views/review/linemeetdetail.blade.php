@extends("layouts.extend")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>项目评议</li>
                <li><a href="">项目评议列表</a> </li>
                <li class="active">详情</li>
            </ol>
            <div class="section-body contain-lg change-pwd">
                <div class="container-fluid details-bg">
                    <div class="col-md-12 details-tit"><h1 class="cert-company">{{$datas->enterprisename}}</h1></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">{{$datas->puttime}}</span></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">联系电话：{{$datas->phone}}</span></div>


                </div>
                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc"><span style="font-size: 14px;font-weight: bold;">项目详情：</span>{{$datas->contents}}</p>
                </div>



                <div class="container-fluid details-bg">
                    <p class="cert-scale">企业建议时间：<span>{{$datas->suggetime}}</span></p>
                    <p class="cert-scale">专家姓名：<span>{{$datas->expertname}}</span></p>
                    <p class="cert-scale">约见时长：<span>{{$datas->timelot}}/小时</span></p>
                    <p class="cert-scale">约见费用：<span>{{$datas->price}}</span></p>
                </div>

                @if($datas->configid == 1)
                    <div class="col-md-2 set-certificate">
                        <a href="javascript:;"><button type="button" class="btn btn-block" style="background-color: darkgreen;color:white; ">待接受</button></a>
                    </div>
                @elseif($datas->configid == 2)
                    <div class="col-md-2 set-certificate">
                        <a href="javascript:;"><button type="button" class="btn btn-block " style="background-color: red;color:white; ">未通过</button></a>
                    </div>
                @elseif($datas->configid == 3)
                    <div class="col-md-2 set-certificate">
                        <a href="javascript:;"><button type="button" class="btn btn-block">已通过</button></a>

                    </div>
                @elseif($datas->configid == 4)
                    <div class="col-md-2 set-certificate">
                        <a href="javascript:;"><button type="button" class="btn btn-block">已完成</button></a>
                    </div>
                @endif


            </div>
        </section>
    </div>
@endsection