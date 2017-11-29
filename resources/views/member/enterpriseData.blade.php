@extends("layouts.cert")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>企业信息</li>
                <li class="active">企业信息</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="cert-state-btns">
                    <a href="javascript:;" @if($status==0) class="current"@endif>全部</a>
                    <a href="javascript:;" @if($status==1) class="current"@endif>已认证</a>
                    <a href="javascript:;" @if($status==2) class="current"@endif>未认证</a>
                </div>
                <div class="cert-list">
                    @foreach($datas as $data)
                        <div class="container-fluid cert-item">
                            <div class="col-md-10 cert-border">
                                <div class="container-fluid">
                                    <div class="col-md-4">
                                        <h2 class="cert-company"><a href="{{asset('/details_enterprise?id='.$data->enterpriseid)}}" class="look-link">{{$data->enterprisename}}</a></h2>
                                        <span class="cert-time">{{$data->created_at}}</span>
                                        <span class="cert-telephone">联系电话：{{$data->phone}}</span>
                                        <p class="cert-industry">行业：{{$data->industry}}</p>
                                        <p class="cert-scale">规模：{{$data->size}}</p>
                                        <p class="cert-zone">地区：{{$data->address}}</p>
                                    </div>
                                    <div class="col-md-4 cert-img"><img onclick="javascript:showimage('{{env('ImagePath').$data->licenceimage}}');" src="{{env('ImagePath').$data->licenceimage}}" /></div>
                                    <div class="col-md-4 cert-img"><img onclick="javascript:showimage('{{env('ImagePath').$data->showimage}}');" src="{{env('ImagePath').$data->showimage}}" /></div>
                                </div>
                            </div>
                            <div class="col-md-2 set-certificate">
                                @if($status==1)
                                @if($data->configid==1)
                                        <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-default refuse btn-support5">已申请</button></a>
                                @elseif($data->configid==2)
                                    <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-default refuse ">未认证成功</button></a>
                                @else
                                    <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-success refuse">认证成功</button></a>
                                @endif

                                @else

                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pages">
                    {!! $datas->appends(["status"=>$status])->render() !!}
                </div>
            </div>
        </section>
    </div>
    <script>
        $(".cert-state-btns a").on("click",function(){
            var condition=$(this).text();
            if(condition=="全部"){
                window.location.href="{{asset('/enterprisedata?status=0')}}"
            }else if(condition=="已认证"){
                window.location.href="{{asset('/enterprisedata?status=1')}}"
            }else if(condition=="未认证"){
                window.location.href="{{asset('/enterprisedata?status=2')}}"
            }else{
                window.location.href="{{asset('/enterprisedata?status=3')}}"
            }
        })
    </script>
@endsection