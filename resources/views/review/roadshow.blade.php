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
                <li>线下路演</li>
                <li class="active">线下路演列表</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="cert-state-btns">
             {{--<a href="javascript:;" class="ver_all" @if(empty($action) || $action  == 'all') id="hoverstyle" @endif>全部</a>
                    <a href="javascript:;" class="ver_wait" @if(!empty($action) && $action == 'wait') id="hoverstyle" @endif>待接受</a>
                    <a href="javascript:;" class="ver_fail" @if(!empty($action) && $action == 'fail') id="hoverstyle" @endif>未通过</a>
                    <a href="javascript:;" class="ver_wput" @if(!empty($action) && $action == 'wput') id="hoverstyle" @endif>已通过</a>
                    <a href="javascript:;" class="ver_pushok" @if(!empty($action) && $action == 'ver_pushok') id="hoverstyle" @endif>已完成</a>
--}}
                </div>
                <div class="cert-list">
                    @foreach($datas as $v)
                        <div class="container-fluid cert-item">
                            <div class="col-md-10 cert-border">
                                <div class="container-fluid">
                                    <div class="col-md-4">
                                        <h2 class="cert-company"><a href="{{asset('/roadShowdetail/'.$v->showid)}}" class="look-link">{{$v->enterprisename}}</a></h2>
                                        <span class="cert-telephone">联系电话：{{$v->phone}}</span>
                                        <p class="cert-scale">行业：<span>{{--{{$v->industry}}--}}</span></p><br><br>

                                        <p class="cert-scale">项目标题：<span>{{$v->title}}</span></p>
                                        <p class="cert-scale">项目名称：<span><a href="{{env('ImagePath')}}/show/{{$v->bpurl}}" target="_blank">{{$v->bpname}}</a></span></p>

                                    </div>
                                    <p class="cert-zone" style="float: right;color:black;"><b>提交时间：{{$v->showtime}}</b></p>
                                    <div class="col-md-8 cert-cap" style="overflow: hidden;height: 150px;">
                                        <span>{{$v->brief}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 set-certificate">
                                <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-success eve_put" index="{{$v->showid}}" id="{{$v->showid}}" onclick="push(this)" >推送项目BP</button></a>
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
            window.location = '{{url('supplyShow','fail')}}';
        });
        $('.ver_all').on('click',function () {
            window.location = '{{url('supplyShow','all')}}';
        });
        $('.ver_wait').on('click',function () {
            window.location = '{{url('supplyShow','wait')}}';
        });
        $('.ver_wput').on('click',function () {
            window.location = '{{url('supplyShow','wput')}}';
        });
        $('.ver_pushok').on('click',function () {
            window.location = '{{url('supplyShow','pushok')}}';
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
                $.post('{{url('changeShow')}}',{'showid':showid,'remark':remark,'configid':3},function (data) {
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



        /**
         * 推送给专家项目评议
         * */
        function push(e){
            //var type=$(e).closest('.cert-item').find('.cert-scale span').text();//领域
            var showId=$(e).attr("id");


            $.ajax({
                url:"{{url('showSelectExpert')}}",
                data:{"showId":showId},
                dateType:"json",
                type:"POST",
                async:false,
                success:function(res){
                    $(".supply-list").html("");
                    var str="";
                    $.each(res,function(key,value){
                        var ExpertId=value.expertid;
                        str="<li class='col-md-4'>";
                        str+="<input type='hidden' id='show' value='"+showId+"'>"
                        str+="<a href='{{'serve_expertDet'}}/"+value.expertid+"' class='expert-list-link'>";
                        str+="<div class='exp-list-top'>"
                        str+="<span class='exp-list-img'><img src='{{env('ImagePath')}}"+value.showimage+"'></span>";
                        str+="<div class='exp-list-brief'>"
                        str+="<span class='exp-list-name'>"+value.expertname+"</span>"
                        str+="<span class='exp-list-video'><i class='fa fa-play-circle-o'></i>视频咨询：<em>免费</em></span>"
                        str+="<span class='exp-list-best'><i class='fa fa-thumbs-o-up'></i>擅长领域：<em>"+value.domain1+"</em></span></div>"
                        str+="<div class='exp-list-lab'>"
                        str+="</div>"
                        str+="</div>"
                        str+="<div class='exp-list-desc'>"
                        str+=value.brief
                        str+="</div>"
                        str+="</a>"
                        var strExpertId=String(ExpertId)

                        str+="<a href='javascript:;' onclick='xuanzhong("+value.expertid+")' id='show_"+value.expertid+"' class='xuanzhong'><i class='fa fa-check-square'></i></a>"

                        str+="</li>"
                        $(".supply-list").append(str);
                    })
                    $(".modal-new-list").modal();
                    $(".btn-primary").attr("id",this);

                }
            })

        }

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