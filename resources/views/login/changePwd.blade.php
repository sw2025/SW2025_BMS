@extends("layouts.master")
@section("content")
    <div id="content">
        <section>
            @if(session("msg"))
                <div class="col-sm-12">
                    <div class="btn-group btn-group-justified">
                        <a class="btn btn-warning" id="toast-warning"><i class="fa fa-warning"></i> <strong>{{session("msg")}}</strong></a>
                    </div>
                </div>
            @endif
            <ol class="breadcrumb">
                <li>基础设置</li>
                <li class="active">修改密码</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="box box-outlined">
                    <div class="box-body no-padding">
                        <form class="form-horizontal form-bordered form-validate" role="form" novalidate="novalidate" method="post" action="{{asset('/save_pwd')}}">
                            <div class="form-group">
                                <div class="col-lg-3 col-sm-2">
                                    <label for="password" class="control-label">请输入原密码</label>
                                </div>
                                <div class="col-lg-9 col-sm-10">
                                    <input type="password" name="oldpassword" id="oldpassword" value="{{old('oldpassword')}}" class="form-control" placeholder="请输入原密码" required="" data-rule-minlength="5">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-3 col-sm-2">
                                    <label for="password" class="control-label">请输入新密码</label>
                                </div>
                                <div class="col-lg-9 col-sm-10">
                                    <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}" placeholder="请输入新密码" required="" data-rule-minlength="5">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-3 col-sm-2">
                                    <label for="passwordrepeat" class="control-label">请再次输入新密码</label>
                                </div>
                                <div class="col-lg-9 col-sm-10">
                                    <input type="password" name="passwordrepeat" id="passwordrepeat" value="{{old('passwordrepeat')}}" class="form-control" placeholder="请再次输入新密码" data-rule-equalto="#password" required="">
                                </div>
                            </div>
                            <div class="form-footer col-lg-offset-3 col-sm-offset-2">
                                <button type="submit" class="btn btn-primary">确定</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
