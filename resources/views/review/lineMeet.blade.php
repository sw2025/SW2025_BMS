@extends("layouts.extend")
@section("content")
    <style>
        #hoverstyle{
            color: #e3643d;
            border-color: #e3643d;
        }

    </style>
    <link rel="stylesheet" href="{{asset('css/list.css')}}">
    <script src="{{asset('js/jquery.pagination.js')}}" type="text/javascript"></script>
    <!-- BEGIN CONTENT-->
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>线下约见</li>
                <li class="active">线下约见列表</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="cert-state-btns">
                    <a href="javascript:;" class="ver_all" @if(empty($action) || $action  == 'all') id="hoverstyle" @endif>全部</a>
                    <a href="javascript:;" class="ver_wait" @if(!empty($action) && $action == 'wait') id="hoverstyle" @endif>待接受</a>
                    <a href="javascript:;" class="ver_fail" @if(!empty($action) && $action == 'fail') id="hoverstyle" @endif>未通过</a>
                    <a href="javascript:;" class="ver_wput" @if(!empty($action) && $action == 'wput') id="hoverstyle" @endif>已响应</a>
                    <a href="javascript:;" class="ver_pushok" @if(!empty($action) && $action == 'ver_pushok') id="hoverstyle" @endif>已完成</a>
                </div>
                <div class="cert-list">
                    @foreach($datas as $v)
                        <div class="container-fluid cert-item" style="height:220px;">
                            <div class="col-md-10 cert-border">
                                <div class="container-fluid">
                                    <div class="col-md-4">
                                        <h2 class="cert-company"><a href="{{asset('/linemeetdetail/'.$v->meetid)}}" class="look-link">{{$v->enterprisename}}</a></h2>
                                        <span class="cert-telephone">联系电话：{{$v->phone}}</span>
                                        <p class="cert-scale">企业建议时间：<span>{{$v->puttime}}</span></p>
                                        <p class="cert-scale">专家姓名：<span>{{$v->expertname}}</span></p>
                                        <p class="cert-scale">约见时长：<span>{{$v->timelot}}/小时</span></p>
                                        <p class="cert-scale">约见费用：<span>{{$v->price}}</span></p>


                                    </div>

                                    <p class="cert-zone" style="float: right;color:black "><b>申请时间：{{$v->puttime}}</b></p>

                                    <div class="col-md-8 cert-cap" style="overflow: hidden; height:150px;">

                                        <span >{{$v->contents}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 set-certificate">
                                <a href="javascript:;"><button type="button" class="btn btn-block " style="background-color:#d5d5d5;color:black ">{{$config[$v->configid]}}</button></a>
                            </div>


                        </div>
                    @endforeach
                    <div class="pages">
                        {!! $datas->render() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal modal-new-list">
        <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button">关闭</button>
        </div>
        <div class="modal-body">
            <div class="new-list container">
                <ul class="supply-list clearfix">

                </ul>
                <div class="pages myinfo-page">
                    <div id="Pagination"></div><span class="page-sum">共<strong class="allPage">{{$datas->lastpage()}}</strong>页</span>
                </div>
                <div class="btn-two">
                    <button type="button" class="btn btn-block ink-reaction btn-inverse" data-dismiss="modal">取消</button>
                    <button type="button" id="btnOK" class="btn btn-block ink-reaction btn-danger" >确定</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            var currentPage=parseInt("{{$datas->currentPage()}}")-1;
            $("#Pagination").pagination("{{$datas->lastpage()}}",{'callback':pageselectCallback,'current_page':currentPage});
            function pageselectCallback(page_index, jq){
                // 从表单获取每页的显示的列表项数目
                var current = parseInt(page_index)+1;
                var url = window.location.href;
                url = url.replace(/(\?|\&)?page=\d+/,'');
                var isexist = url.indexOf("?");
                if(isexist == -1){
                    url += '?ordertime=desc&page='+current;
                } else {
                    url += '&page='+current;
                }
                window.location=url;
                //阻止单击事件
                return false;
            }
        })
        $('.ver_fail').on('click',function () {
            window.location = '{{url('lineMeet','fail')}}';
        });
        $('.ver_all').on('click',function () {
            window.location = '{{url('lineMeet','all')}}';
        });
        $('.ver_wait').on('click',function () {
            window.location = '{{url('lineMeet','wait')}}';
        });
        $('.ver_wput').on('click',function () {
            window.location = '{{url('lineMeet','wput')}}';
        });
        $('.ver_pushok').on('click',function () {
            window.location = '{{url('lineMeet','ver_pushok')}}';
        });
        /**
         *项目审核通过按钮
         */
        $('.btn-support1').on('click',function () {
            var showid = $('.btn-support1').attr('index');
            $.post('{{url('changeShow')}}',{'showid':showid,'configid':4},function (data) {
                if (data.errorMsg == 'success') {
                    alert("操作成功");
                    window.location.href = "{{url('supplyShow')}}";
                } else {
                    alert("审核失败或反应超时");
                    window.location.href = "{{url('supplyShow')}}";
                }
            },'json');
        });
         //办事审核不通过
        $(function () {
            $('.reject-reasons button').on('click',function () {
                var remark=$(".reject-reasons textarea").val();
                var showid=$(this).attr("id");
                $.post('{{url('changeShow')}}',{'showid':showid,'remark':remark,'configid':2},function (data) {
                    if (data.errorMsg == 'success') {
                        alert("操作成功");
                        window.location.href = "{{url('/supplyShow')}}";
                    } else {
                        alert("审核失败或反应超时");
                        window.location.href = "{{url('/supplyShow')}}";
                    }
                },'json');
            });
        })

        $(".refuse").on("click",function(){
            var id=$(this).attr('id');
            $.ajax({
                url:"{{url('getRemark')}}",
                data:{"type":"work","id":id},
                dateType:"json",
                type:"POST",
                success:function(res){
                    layer.alert(res);
                }
            })
        })

      /*  var getCountExpert=function(type){
            var count;
            $.ajax({
                url:"{{url('showCountExpert')}}",
                data:{"type":type},
                dateType:"json",
                async:false,
                type:"POST",
                success:function(res){
                    count=res;
                }
            })
            return count;
        }*/
        var xuanzhong=function(id){
            $("#show_"+id).toggleClass('xzchecked');
        }
        $("#btnOK").on("click",function(){
            var expertSelect="";
            $('.xzchecked').each(function(index,element){
                var ids=$(this).attr('id');
                var num=ids.lastIndexOf('_')+1;
                id=ids.substring(num);
                expertSelect=id+','+expertSelect;
            })
            var showId=$("#show").val();
            if(!expertSelect){
                alert("请您选择专家");
                return false;
            }
            $.ajax({
                url:"{{url('pushExpert')}}",
                data:{"expertSelect":expertSelect,"showId":showId},
                dateType:"json",
                type:"post",
                success:function(res){
                    window.location.reload();
                }
            })
        })
    </script>
@endsection