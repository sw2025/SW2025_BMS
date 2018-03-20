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
                    <div class="col-md-12 details-tit"><h1 class="cert-company">{{$datas->enterprisename}}<span style="float: right;">申请时间：{{$datas->showtime}}</span></h1></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">联系电话：{{$datas->phone}}</span></div>



                </div>

                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc"><span style="font-size: 14px;font-weight: bold;">项目标题：</span>{{$datas->title}}</p>

                    <p class="details-tit details-desc"><span style="font-size: 14px;font-weight: bold;">项目详情：</span>{{$datas->brief}}</p>
                </div>


                <div class="container-fluid details-bg">
                    <p><b><h4>提交的项目：</h4></b></p>
                    <p class="cert-scale"><span> </span></p>
                    <p class="cert-scale">项目：<span><a href="{{env('ImagePath')}}/show/{{$datas->bpurl}}" target="_blank">{{$datas->bpname}}</a></span></p>
                </div>
            </div>
        </section>
    </div>
@endsection