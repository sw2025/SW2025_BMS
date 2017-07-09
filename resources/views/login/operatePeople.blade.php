@extends("layouts.master")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>基础设置</li>
                <li class="active">操作人员</li>
            </ol>
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="{{asset('add_operator')}}" class="add-btn-link">
                            <button type="button" class="btn ink-reaction btn-raised btn-sm btn-primary">新增操作员</button>
                        </a>
                        <div class="box box-outlined">
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped no-margin table-vertic">
                                        <thead>
                                        <tr>
                                            <th>姓名</th>
                                            <th>角色</th>
                                            <th>手机号</th>
                                            <th>职位</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($datas as $data)
                                            <tr>
                                                <td>{{$data->name}}</td>
                                                <td><a href="{{asset('/look_right?roleId='.$data->roleid)}}" class="look-link">{{$data->rolename}}</a></td>
                                                <td>{{$data->phone}}</td>
                                                <td>{{$data->position}}</td>
                                                <td class="operate-btns">
                                                    <a href="{{asset('/edit_operator?userId='.$data->userid)}}"><button type="button" class="btn btn-block ink-reaction btn-inverse">修改</button></a>
                                                    <a href="{{asset('delete_operator?userId='.$data->userid)}}" onclick="return confirm('您确定要删除吗!')"><button type="button" class="btn btn-block ink-reaction btn-danger">删除</button></a>
                                                    <a href="{{asset('reset_operator?userId='.$data->userid)}}" onclick="return confirm('您确定要重置吗!')"><button type="button" class="btn btn-block ink-reaction btn-warning">重置密码</button></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="pages">
                            {!! $datas->render() !!}
                           {{-- <div class="oh"><div id="Pagination"></div><span class="page-sum">共<strong class="allPage">1</strong>页</span></div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- start JAVASCRIPT -->
   {{-- <script type="text/javascript">
        $(document).ready(function() {
            $("#Pagination").pagination("2");
        });
    </script>--}}
    <!-- END JAVASCRIPT -->
@endsection