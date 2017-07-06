@extends("layouts.master")
@section("content")
    <div id="content">
        @if(session("msg"))
            <div class="col-sm-12">
                <div class="btn-group btn-group-justified">
                    <a class="btn btn-warning" id="toast-warning"><i class="fa fa-warning"></i> <strong>{{session("msg")}}</strong></a>
                </div>
            </div>
        @endif
        <section>
            <ol class="breadcrumb">
                <li>基础设置</li>
                <li class="active">操作人员</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="col-md-12">
                    <p class="tac add-tit"><a href="{{asset('/operate_people')}}">返回</a></p>
                    <div class="box box-outlined">
                        <div class="box-head tac">
                            <h4 class="text-light tac">新增操作员信息</h4>
                        </div>
                        <div class="box-body no-padding">
                            <form class="form-horizontal form-bordered form-validate" role="form" novalidate="novalidate" method="post" action="{{asset('/add_operatorSave')}}">
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="name" class="control-label">请输入姓名</label>
                                    </div>
                                    <div class="col-lg-9 col-sm-10">
                                        <input type="text" name="name" id="name" class="form-control" placeholder="请输入姓名" required="" data-rule-minlength="2" value="{{old('name')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="selector" class="control-label">请选择角色</label>
                                    </div>
                                    <div class="col-lg-9 col-sm-10">
                                        <select name="selector" id="selector" class="form-control" required="">
                                            <option value="">请选择角色</option>
                                            @foreach($datas as $data)
                                                <option value="{{$data->roleid}}">{{$data->rolename}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="telephone" class="control-label">请输入手机号</label>
                                    </div>
                                    <div class="col-lg-9 col-sm-10">
                                        <input type="text" name="telephone" id="telephone" class="form-control" placeholder="请输入手机号" required="" value="{{old('telephone')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="job" class="control-label">请输入职位</label>
                                    </div>
                                    <div class="col-lg-9 col-sm-10">
                                        <input type="text" name="job" id="job" class="form-control" placeholder="请输入职位" data-rule-minlength="2" required="" value="{{old('job')}}">
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