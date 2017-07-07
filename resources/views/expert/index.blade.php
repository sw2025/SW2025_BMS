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
                    <a href="javascript:;">全部</a>
                    <a href="javascript:;">待认证</a>
                    <a href="javascript:;">认证失败</a>
                </div>
                <div class="cert-list">
                    <div class="container-fluid cert-item">
                        <div class="col-md-10 cert-border">
                            <div class="container-fluid">
                                <div class="col-md-4">
                                    <h2 class="cert-company"><a href="{{asset('/details_expert')}}" class="look-link">****专家</a></h2>
                                    <span class="cert-time">2017-07-02  12:10:35</span>
                                    <span class="cert-telephone">联系电话：12345678901</span>
                                    <p class="cert-industry">擅长问题：******</p>
                                    <p class="cert-scale">专家分类：个人</p>
                                    <p class="cert-zone">地区：北京</p>
                                </div>
                                <div class="col-md-4 cert-img"><img onclick="javascript:showimage('img/zhanwei.jpg');" src="img/zhanwei.jpg" /></div>
                                <div class="col-md-4 cert-img"><img onclick="javascript:showimage('img/zhanwei.jpg');" src="img/zhanwei.jpg" /></div>
                            </div>
                        </div>
                        <div class="col-md-2 set-certificate">
                            <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1">通过审核</button></a>
                            <a href="javascript:;" onclick="showReason();"><button type="button" class="btn btn-block ink-reaction btn-support5">拒绝审核</button></a>
                        </div>
                    </div>
                    <div class="container-fluid cert-item">
                        <div class="col-md-10 cert-border">
                            <div class="container-fluid">
                                <div class="col-md-4">
                                    <h2 class="cert-company"><a href="javascript:;" class="look-link">****专家</a></h2>
                                    <span class="cert-time">2017-07-02  12:10:35</span>
                                    <span class="cert-telephone">联系电话：12345678901</span>
                                    <p class="cert-industry">擅长问题：******</p>
                                    <p class="cert-scale">专家分类：机构</p>
                                    <p class="cert-zone">地区：北京</p>
                                </div>
                                <div class="col-md-4 cert-img"><img onclick="javascript:showimage('img/zhanwei.jpg');" src="img/zhanwei.jpg" /></div>
                                <div class="col-md-4 cert-img"><img onclick="javascript:showimage('img/zhanwei.jpg');" src="img/zhanwei.jpg" /></div>
                            </div>
                        </div>
                        <div class="col-md-2 set-certificate">
                            <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-default">已拒绝</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection