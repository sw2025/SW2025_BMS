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
                <li class="active">角色权限</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="col-md-12">
                    <p class="tac add-tit"><a href="javascript:;" onclick="javascript:history.back(-1);">返回</a></p>
                    <div class="box box-outlined">
                        <div class="box-head tac">
                            <h4 class="text-light">新增或修改角色信息</h4>
                        </div>
                        <div class="box-body no-padding">
                            <form class="form-horizontal form-bordered form-validate" role="form" novalidate="novalidate" method="post" action="{{asset("edit_roleSave")}}">
                               @foreach($datas as $data)
                                    <input type="hidden" name="roleId" value="{{$data->roleid}}">
                                    <div class="form-group">
                                        <div class="col-lg-3 col-sm-2">
                                            <label for="name" class="control-label">请输入角色</label>
                                        </div>
                                        <div class="col-lg-9 col-sm-10">
                                            <input type="text" name="name" id="name" class="form-control" placeholder="请输入角色" required="" data-rule-minlength="2" value="{{$data->rolename}}">
                                        </div>
                                    </div>
                                    <p class="set-right-cap">设置权限</p>
                                    <table class="table table-hover table-striped no-margin table-vertic">
                                        <thead>
                                        <tr>
                                            <th>一级权限</th>
                                            <th>二级权限</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($auths1 as $auth1)
                                            <tr>
                                                <td>
                                                    <div data-toggle="buttons">
                                                        @if(in_array($auth1->permissionid,$auths))
                                                            <label class="btn checkbox-inline btn-checkbox-primary-inverse active">
                                                                <input type="checkbox" name="auth[]" value="{{$auth1->permissionid}}">{{$auth1->permissionname}}
                                                            </label>
                                                        @else
                                                            <label class="btn checkbox-inline btn-checkbox-primary-inverse ">
                                                                <input type="checkbox" name="auth[]" value="{{$auth1->permissionid}}"> {{$auth1->permissionname}}
                                                            </label>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div data-toggle="buttons">
                                                        @foreach($auths2 as $auth2)
                                                            @if($auth2->pid==$auth1->permissionid)
                                                                @if(in_array($auth2->permissionid,$auths))
                                                                <label class="btn checkbox-inline btn-checkbox-primary-inverse active">
                                                                    <input type="checkbox" name="auth[]" value="{{$auth2->permissionid}}"> {{$auth2->permissionname}}
                                                                </label>
                                                                @else
                                                                    <label class="btn checkbox-inline btn-checkbox-primary-inverse">
                                                                        <input type="checkbox" name="auth[]" value="{{$auth2->permissionid}}"> {{$auth2->permissionname}}
                                                                    </label>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="form-footer col-lg-offset-3 col-sm-offset-2">
                                        <button type="submit" class="btn btn-primary">保存</button>
                                    </div>
                                @endforeach
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection