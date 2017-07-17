@extends("layouts.extend")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>审核操作</li>
                <li class="active">视频信息维护</li>
            </ol>
            <div class="section-body contain-lg change-pwd">
                <div class="container-fluid details-bg">
                    <div class="col-md-12 details-tit"><h2 class="cert-company">{{$datas->enterprisename}}</h2></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">2017-07-02  12:10:35</span></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">联系电话：{{$datas->phone}}</span></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">开始时间：2017-07-03 12:00:00</p></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">结束时间：2017-07-03 13:00:00</p></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">需求分类：{{$datas->domain1}}/{{$datas->domain2}}</p></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">指定专家：系统分配</p></div>
                </div>
                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc">{{$datas->brief}}-----------------------简介：习近平代表中国政府和中国人民，向友好的俄罗斯政府和人民致以诚挚问候和良好祝愿。习近平指出，中俄两国是好邻居、好朋友、好伙伴，两国人民传统友谊源远流长。当前，中俄全面战略协作伙伴关系处于历史最好时期。
            </div>
        </section>
    </div>
@endsection