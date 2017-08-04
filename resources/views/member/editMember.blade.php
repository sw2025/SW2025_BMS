@extends("layouts.master")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>参数设置</li>
                <li class="active">会员权益</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="col-md-12">
                    <p class="tac add-tit"><a href="member.html">返回</a></p>
                    <div class="box box-outlined">
                        <div class="box-head tac">
                            <h4 class="text-light tac">编辑会员信息</h4>
                        </div>
                        <div class="box-body no-padding">
                            <form class="form-horizontal form-bordered form-validate" role="form" novalidate="novalidate" method="post" action="{{url('dealeditmember')}}">
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="selector" class="control-label">会员等级</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <select name="typename" id="selector" class="form-control" required="">
                                            <option value="" >请选择</option>
                                            <option value="普通会员" @if($datas->typename == '普通会员') selected @endif>普通会员</option>
                                            <option value="VIP会员" @if($datas->typename == 'VIP会员') selected @endif>VIP会员</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="memberid" value="{{$datas->memberid}}">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="timelimit" class="control-label">期限</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <input type="text" name="termtime" id="timelimit" class="form-control" placeholder="请输入年限" required="" data-rule-minlength="1" value="{{$datas->termtime}}">
                                    </div>
                                    <span class="col-lg-1 col-sm-1 line-hei" style="line-height:32px;">年</span>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="fees" class="control-label">会员费</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <input type="text" name="cost" id="fees" class="form-control" placeholder="请输入会费" required="" value="{{$datas->cost}}">
                                    </div>
                                    <span class="col-lg-1 col-sm-1 line-hei" style="line-height:32px;">元</span>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="consults" class="control-label">咨询次数</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <input type="text" name="consultcount" id="consults" class="form-control" placeholder="请输入咨询次数" data-rule-minlength="1" required="" value="{{$datas->consultcount}}">
                                    </div>
                                    <span class="col-lg-1 col-sm-1 line-hei" style="line-height:32px;">次</span>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="worksCount" class="control-label">办事次数</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <input type="text" name="eventcount" id="worksCount" class="form-control" placeholder="请输入办事次数" data-rule-minlength="1" required="" value="{{$datas->eventcount}}">
                                    </div>
                                    <span class="col-lg-1 col-sm-1 line-hei" style="line-height:32px;">次</span>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="worksCount" class="control-label">权益描述</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <textarea name="rightbrief"  placeholder="请输入权益描述" required=""  class="form-control" rows="3">{{$datas->rightbrief}}</textarea>
                                    </div>
                                </div>
                                <div class="form-footer col-lg-offset-3 col-sm-offset-2">
                                    <button type="submit" class="btn btn-primary">保存</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection