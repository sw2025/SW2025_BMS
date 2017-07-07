@extends("layouts.cert")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>审核操作</li>
                <li class="active">企业认证审核</li>
            </ol>
            <div class="section-body contain-lg change-pwd">
                <div class="container-fluid details-bg">
                    <div class="col-md-12 details-tit"><h2 class="cert-company">成都欣专家</h2></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">2017-07-02  12:10:35</span></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">联系电话：12345678901</span></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">擅长问题：制造业</p></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">专家分类：个人</p></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">地区：北京</p></div>
                </div>
                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc">简介：习近平代表中国政府和中国人民，向友好的俄罗斯政府和人民致以诚挚问候和良好祝愿。习近平指出，中俄两国是好邻居、好朋友、好伙伴，两国人民传统友谊源远流长。当前，中俄全面战略协作伙伴关系处于历史最好时期。双方在涉及对方核心利益问题上相互坚定支持，积极开展两国发展战略对接和“一带一路”建设同欧亚经济联盟对接。面对复杂多变的国际形势，中俄发挥大国作用和担当，树立了以合作共赢为核心的新型国际关系典范，为维护地区及世界和平稳定贡献了强大正能量。</p>
                </div>
                <div class="container-fluid details-bg">
                    <div class="details-tit clearfix">
                        <div class="col-md-4 cert-img"><img onclick="javascript:showimage('img/zhanwei.jpg');" src="img/zhanwei.jpg" /></div>
                        <div class="col-md-4 cert-img"><img onclick="javascript:showimage('img/zhanwei.jpg');" src="img/zhanwei.jpg" /></div>
                    </div>
                </div>
                <div class="details-tit details-btns">
                    <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1">通过审核</button></a>
                    <a href="javascript:;" onclick="showReason();"><button type="button" class="btn btn-block ink-reaction btn-support5">拒绝审核</button></a>
                </div>
                <div class="details-tit details-btns">
                    <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-default">已拒绝</button></a>
                </div>
            </div>
        </section>
    </div>
@endsection