@extends("layouts.cert")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>审核操作</li>
                <li class="active">专家信息维护</li>
            </ol>

            <div class="section-body contain-lg change-pwd">
                <div class="container-fluid details-bg">
                    <div class="col-md-12 details-tit"><h2 class="cert-company">{{$data->expertname}}</h2></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">{{$data->created_at}}</span></div>
                    <div class="col-md-6 details-tit"><span class="cert-industry">联系电话：{{$data->phone}}</span></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">擅长行业：{{$data->industry}}</p></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">擅长问题：{{$data->domain1}}/{{$data->domain2}}</p></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">专家分类：{{$data->category}}</p></div>
                    <div class="col-md-6 details-tit"><p class="cert-industry">地区：{{$data->address}}</p></div>
                </div>
                <div class="container-fluid details-bg">
                    <p class="details-tit details-desc">{{$data->brief}}</p>
                </div>
                <div class="container-fluid details-bg">
                    <div class="details-tit clearfix">
                        <div class="col-md-4 cert-img"><img onclick="javascript:showimage('{{env('ImagePath').$data->licenceimage}}');" src="{{env('ImagePath').$data->licenceimage}}" /></div>
                        <div class="col-md-4 cert-img"><img onclick="javascript:showimage('{{env('ImagePath').$data->showimage}}');" src="{{env('ImagePath').$data->showimage}}" /></div>
                    </div>
                </div>
                @if($data->isfirst==0)
                    <div class="details-tit details-btns">
                        <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1" id="{{$data->expertid}}">设置首页</button></a>
                    </div>
                @else
                    <div class="details-tit details-btns">
                        <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support2" id="{{$data->expertid}}">取消首页设置</button></a>
                    </div>
                @endif
                <h3>评论</h3>
                @foreach($result as $big)
                    @if($big->parentid==0)
                        <div class="container-fluid details-bg">
                            <p class="details-tit details-desc"><span style="font-size: 14px;font-weight: bold;">评论：</span>{{$big->content}}</p>
                            <p><a href="{{asset('deleteExpertContent?id='.$big->id.'&expertid='.$big->expertid)}}" onclick="return confirm('您确定要删除!')"><button type="button" class="btn btn-block ink-reaction btn-support1" style="width: 100px;float: right;">删除</button></a></p>
                            @foreach($result as $small)
                                @if($small->parentid==$big->id)
                                    <p class="details-tit details-desc"><span style="font-size: 14px;font-weight: bold;">楼中楼：</span>{{$small->content}}</p>
                                    <p><a href="{{asset('deleteExpertContent?id='.$small->id.'&expertid='.$small->expertid)}}" onclick="return confirm('您确定要删除!')"><button type="button" class="btn btn-block ink-reaction btn-support1" style="width: 100px;float: right;">删除</button></a></p>

                                @endif
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        </section>
    </div>
    <script>
        /**
         * 设置首页
         */
        $(".btn-support1").on("click",function(){
            var expertid=$(this).attr("id");
            $.ajax({
                url:"{{asset('/changeHomePage')}}",
                data:{"isfirst":1,"expertid":expertid},
                dataType:"json",
                type:"POST",
                success:function(res){
                    if(res['code']=="success"){
                        window.location.href=window.location;
                    }else{
                        alert("审核失败");
                        window.location.href=window.location;
                    }
                }
            })
        })
        $(".btn-support2").on("click",function(){
            var expertid=$(this).attr("id");
            $.ajax({
                url:"{{asset('/changeHomePage')}}",
                data:{"isfirst":0,"expertid":expertid},
                dataType:"json",
                type:"POST",
                success:function(res){
                    if(res['code']=="success"){
                        window.location.href=window.location;
                    }else{
                        alert("审核失败");
                        window.location.href=window.location;
                    }
                }
            })
        })
    </script>
@endsection