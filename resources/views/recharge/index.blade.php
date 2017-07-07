@extends("layouts.extend")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>审核操作</li>
                <li class="active">提现申请审核</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="cert-state-btns">
                    <a href="javascript:;">全部</a>
                    <a href="javascript:;">待认证</a>
                    <a href="javascript:;">认证失败</a>
                </div>
                <div class="cert-recharge container-fluid">
                    <div class="col-md-4">
                        <div class="cert-recharge-item">
                            <h2 class="cert-company"><a href="{{asset('/details_recharge')}}" class="look-link">****公司</a></h2>
                            <span class="cert-telephone">联系电话：12345678901</span>
                            <span class="cert-recharge-time">2017-07-02  14:00:00</span>
                            <p class="cert-money">提现金额：<span class="money-color">￥10000</span></p>
                            <div class="cert-recharge-btns">
                                <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1">通过审核</button></a>
                                <a href="javascript:;" onclick="showReason();"><button type="button" class="btn btn-block ink-reaction btn-support5">拒绝审核</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cert-recharge-item">
                            <h2 class="cert-company"><a href="{{asset('/details_recharge')}}" class="look-link">****公司</a></h2>
                            <span class="cert-telephone">联系电话：12345678901</span>
                            <span class="cert-recharge-time">2017-07-02  14:00:00</span>
                            <p class="cert-money">提现金额：<span class="money-color">￥10000</span></p>
                            <div class="cert-recharge-btns">
                                <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-default">已拒绝</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cert-recharge-item">
                            <h2 class="cert-company"><a href="javascript:;" class="look-link">****公司</a></h2>
                            <span class="cert-telephone">联系电话：12345678901</span>
                            <span class="cert-recharge-time">2017-07-02  14:00:00</span>
                            <p class="cert-money">提现金额：<span class="money-color">￥10000</span></p>
                            <div class="cert-recharge-btns">
                                <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1">通过审核</button></a>
                                <a href="javascript:;" onclick="showReason();"><button type="button" class="btn btn-block ink-reaction btn-support5">拒绝审核</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection