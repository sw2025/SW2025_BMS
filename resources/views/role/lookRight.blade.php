@extends("layouts.master")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>基础设置</li>
                <li class="active">角色权限</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="col-md-12">
                    <a href="javascript:;" onclick="javascript:history.back(-1);" class="back">返回</a>
                    <div class="box box-outlined">
                        <div class="box-head tac" style="border-bottom:1px solid #ccc;">
                            <h4 class="text-light tac">角色：<span>{{$roleName}}</span></h4>
                        </div>
                        <div class="box-body no-padding">
                            <div class="table-responsive">
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
                                                    <label class="btn checkbox-inline btn-checkbox-primary-inverse active" disabled>
                                                        <input type="checkbox" value="primary-inverse1"> {{$auth1->permissionname}}
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div data-toggle="buttons">
                                                    @foreach($auths2 as $auth2)
                                                        @if($auth2->pid==$auth1->permissionid)
                                                            <label class="btn checkbox-inline btn-checkbox-primary-inverse active" disabled>
                                                                <input type="checkbox" value="primary-inverse1"> {{$auth2->permissionname}}
                                                            </label>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection