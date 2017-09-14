@extends("layouts.master")
@section("content")
<div id="content">
        <section>
            <ol class="breadcrumb">
                <li>参数设置</li>
                <li class="active">会员权益</li>
            </ol>
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="{{asset('add_member')}}" class="add-btn-link">
                            <button type="button" class="btn ink-reaction btn-raised btn-sm btn-primary">新增会员</button>
                        </a>
                        <div class="box box-outlined">
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped no-margin table-vertic">
                                        <thead>
                                        <tr>
                                            <th>会员名称</th>
                                            <th>期限</th>
                                            <th>会费</th>
                                            <th>咨询次数</th>
                                            <th>办事次数</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($datas as $v)
                                        <tr>
                                            <td>{{$v->typename}}</td>
                                            <td>{{$v->termtime}}年</td>
                                            <td>{{$v->cost}}</td>
                                            <td>{{$v->consultcount}}</td>
                                            <td>{{$v->eventcount}}</td>
                                            <td class="operate-btns">
                                                <a href="{{url('edit_member',$v->memberid)}}"><button type="button" class="btn btn-block ink-reaction btn-inverse">修改</button></a>
                                                <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-danger" onclick="delmember({{$v->memberid}},this)">删除</button></a>
                                            </td>
                                        </tr>
                                       @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="pages">
                            <div class="oh"><div id="Pagination"></div><span class="page-sum">共<strong class="allPage">{{$datas->lastpage()}}</strong>页</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div></div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#Pagination").pagination("2");
    });

    function delmember(id,obj) {
        $.post('{{url('deletemember')}}',{'memberid':id},function (data){
            window.location = window.location.href;
        });
    }
</script>
@endsection