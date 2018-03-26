@extends("layouts.extend")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>线下约见</li>
                <li><a href="">线下约见列表</a> </li>
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
                    <p class="cert-scale">企业建议时间：<span>{{$datas->puttime}}</span></p>
                    <p class="cert-scale">专家姓名：<span>{{$datas->expertname}}</span></p>
                    <p class="cert-scale">约见时长：<span>{{$datas->timelot}}/小时</span></p>
                    <p class="cert-scale">约见费用：<span>{{$datas->price}}</span></p>
                </div>

                <div class="col-md-2 set-certificate">
                    <a href="javascript:;"><button type="button" class="btn btn-block" style="background-color:#d5d5d5;color:black; ">{{$config[$datas->configid]}}</button></a>
                </div>

            </div>
        </section>
    </div>
@endsection