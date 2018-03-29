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
                <li>直通路演</li>
                <li class="active">直通路演列表</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="cert-state-btns">
                    <a href="javascript:;" class="ver_all" @if(empty($action) || $action  == 'all') id="hoverstyle" @endif>全部</a>
                    <a href="javascript:;" class="ver_wait" @if(!empty($action) && $action == 'wait') id="hoverstyle" @endif>免费通道</a>
                    <a href="javascript:;" class="ver_fail" @if(!empty($action) && $action == 'fail') id="hoverstyle" @endif>定点推送</a>
                </div>
                <div class="cert-list">
                    <h4 style="color:red;">数量：{{$counts or ''}}</h4>
                    @foreach($datas as $v)
                        <div class="container-fluid cert-item">
                            <div class="col-md-10 cert-border">
                                <div class="container-fluid">
                                    <div class="col-md-4">
                                        <h2 class="cert-company"><a href="{{asset('/roadShowdetail/'.$v->showid)}}" class="look-link">{{$v->enterprisename}}</a></h2>
                                        <span class="cert-telephone">联系电话：{{$v->phone}}</span>
                                        <p class="cert-scale">领域：<span>{{$v->oneword}}</span></p>
                                        @if($v->level==2)
                                            @foreach($pushOk as $value)
                                                @if($v->showid==$value->showid)
                                                    <p class="cert-zone"><b>推送专家：<a style="cursor:pointer;text-decoration:none;">{{$value->expertname}}</a></b>
                                                        @if($value->state >= 2)
                                                            @foreach($message as $vv)
                                                                @if($vv->showid==$v->showid)
                                                                    @if($vv->isyes==1)
                                                                        有兴趣
                                                                    @else
                                                                        无兴趣
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @else
                                                             (未评价)
                                                        @endif
                                                    </p>
                                                @endif
                                            @endforeach
                                        @endif
                                        <p>项目标题：<span>{{$v->title}}</span></p>
                                        <p>项目名称：<span><a href="{{env('ImagePath')}}/show/{{$v->bpurl}}" target="_blank">{{$v->bpname}}</a></span></p>

                                    </div>
                                    <p class="cert-zone" style="float: right;color:black;"><b>提交时间：{{$v->showtime}}</b></p>
                                    <div class="col-md-8 cert-cap" style="overflow: hidden;height: 150px;">
                                        <span>{{$v->brief}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 set-certificate">

                                @if($v->level==2)
                                    @if($v->configid >= 4)
                                        <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-error eve_put"  style="background: yellow;" >推送项目（已推送）</button></a>

                                    @else
                                        <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-success eve_put" index="{{$v->showid}}" id="{{$v->showid}}" onclick="push(this)" >推送项目BP</button></a>

                                    @endif
                                 @else
                                    <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-error eve_put">免费通道提交的项目</button></a>
                                @endif
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
            window.location = '{{url('roadShow','fail')}}';
        });
        $('.ver_all').on('click',function () {
            window.location = '{{url('roadShow','all')}}';
        });
        $('.ver_wait').on('click',function () {
            window.location = '{{url('roadShow','wait')}}';
        });

        /**
         * 推送给专家项目评议
         * */
        function push(e){
            var type=$.trim($(e).closest('.cert-item').find('.cert-scale span').text());//领域
            var showId=$(e).attr("id");

            $.ajax({
                url:"{{url('showSelectExpert')}}",
                data:{"type":type},
                dateType:"json",
                type:"POST",
                async:false,
                success:function(res){
                    //console.log(res=='');
                    if(res!=''){
                        $(".supply-list").html("");
                        var str="";
                        $.each(res,function(key,value){
                            var ExpertId=value.expertid;
                            str="<li class='col-md-4'>";
                            str+="<input type='hidden' id='show' value='"+showId+"'>"
                            str+="<a href='{{'serve_expertDet'}}/"+value.expertid+"' class='expert-list-link' target='_blank'>";
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
                    }else {
                        layer.open({
                            content: '没有次领域下的专家'
                            ,btn: ['从所有专家中筛选', '取消']
                            ,yes: function(index, layero){
                                //按钮【按钮一】的回调
                                layer.close(index);
                                $(function () {
                                    $.post('{{url('showSelectExpert')}}',{'type':null} ,function (res) {
                                        $(".supply-list").html("");
                                        var str = "";
                                        $.each(res, function (key, value) {
                                            var ExpertId = value.expertid;
                                            str = "<li class='col-md-4'>";
                                            str += "<input type='hidden' id='show' value='" + showId + "'>"
                                            str += "<a href='{{'serve_expertDet'}}/" + value.expertid + "' class='expert-list-link' target='_blank'>";
                                            str += "<div class='exp-list-top'>"
                                            str += "<span class='exp-list-img'><img src='{{env('ImagePath')}}" + value.showimage + "'></span>";
                                            str += "<div class='exp-list-brief'>"
                                            str += "<span class='exp-list-name'>" + value.expertname + "</span>"
                                            str += "<span class='exp-list-video'><i class='fa fa-play-circle-o'></i>视频咨询：<em>免费</em></span>"
                                            str += "<span class='exp-list-best'><i class='fa fa-thumbs-o-up'></i>擅长领域：<em>" + value.domain1 + "</em></span></div>"
                                            str += "<div class='exp-list-lab'>"
                                            str += "</div>"
                                            str += "</div>"
                                            str += "<div class='exp-list-desc'>"
                                            str += value.brief
                                            str += "</div>"
                                            str += "</a>"
                                            var strExpertId = String(ExpertId)
                                            str += "<a href='javascript:;' onclick='xuanzhong(" + value.expertid + ")' id='show_" + value.expertid + "' class='xuanzhong'><i class='fa fa-check-square'></i></a>"
                                            str += "</li>"
                                            $(".supply-list").append(str);
                                        })
                                        $(".modal-new-list").modal();
                                        $(".btn-primary").attr("id", this);
                                    }, 'json');
                                })

                            }
                            ,btn2: function(index, layero){
                                layer.close(index);
                            }
                            ,cancel: function(){
                                //右上角关闭回调
                                //return false 开启该代码可禁止点击该按钮关闭
                            }
                        });
                    }


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
                    window.location = res.url;
                }
            })
        })
    </script>
@endsection