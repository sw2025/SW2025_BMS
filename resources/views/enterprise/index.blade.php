@extends("layouts.cert")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>审核操作</li>
                <li class="active">企业认证审核</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="cert-state-btns">
                    <a href="javascript:;" @if($status==0) class="current"@endif>全部</a>
                    <a href="javascript:;" @if($status==1) class="current"@endif>待认证</a>
                    <a href="javascript:;" @if($status==2) class="current"@endif>认证失败</a>
                    <a href="javascript:;" @if($status==3) class="current"@endif>待缴费</a>
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
                                        <p class="cert-scale">规模：{{$data->size}}人</p>
                                        <p class="cert-zone">地区：{{$data->address}}</p>
                                    </div>
                                    <div class="col-md-4 cert-img"><img onclick="javascript:showimage('http://images.ziyawang.com{{$data->licenceimage}}');" src="http://images.ziyawang.com{{$data->licenceimage}}" /></div>
                                    <div class="col-md-4 cert-img"><img onclick="javascript:showimage('http://images.ziyawang.com{{$data->showimage}}');" src="http://images.ziyawang.com{{$data->showimage}}" /></div>
                                </div>
                            </div>
                            <div class="col-md-2 set-certificate">
                                @if($data->configid==1)
                                    <a href="javascript:;"><button type="button" class="btn btn-block ink-reaction btn-support1" id="{{$data->enterpriseid}}">通过审核</button></a>
                                    <a href="javascript:;" onclick="showReason({{$data->enterpriseid}});" ><button type="button" class="btn btn-block ink-reaction btn-support5" >拒绝审核</button></a>
                                @elseif($data->configid==2)
                                    <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-default">已拒绝</button></a>
                                @else
                                    <a href="javascript:;" class="reject"><button type="button" class="btn btn-block ink-reaction btn-default">未缴费</button></a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pages">
                    {!! $datas->appends(["status"=>$status])->render() !!}
                    {{-- <div class="oh"><div id="Pagination"></div><span class="page-sum">共<strong class="allPage">1</strong>页</span></div>--}}
                </div>
            </div>
        </section>
    </div>
    <script>
        $(".cert-state-btns a").on("click",function(){
            var condition=$(this).text();
            if(condition=="全部"){
                window.location.href="{{asset('/cert_enterprise?status=0')}}"
            }else if(condition=="待认证"){
                window.location.href="{{asset('/cert_enterprise?status=1')}}"
            }else if(condition=="待缴费"){
                window.location.href="{{asset('/cert_enterprise?status=3')}}"
            }else{
                window.location.href="{{asset('/cert_enterprise?status=2')}}"
            }
        })
        $(".btn-support1").on("click",function(){
            var enterpriseId=$(this).attr("id");
            $.ajax({
                url:"{{asset('/changeEnterprise')}}",
                data:{"configid":3,"enterpriseId":enterpriseId},
                dataType:"json",
                type:"POST",
                success:function(res){
                    if(res['code']=="success"){
                        window.location.href="{{asset('/cert_enterprise')}}";
                    }else{
                        alert("审核失败");
                        window.location.href="{{asset('/cert_enterprise')}}";
                    }
                }
            })
        })

      $(function(){
          $(".btn-primary").on("click",function (){
              var remark=$("#textarea").val();
              var enterpriseId=$(this).attr("id");
              $.ajax({
                  url:"{{asset('/changeEnterprise')}}",
                  data:{"remark":remark,"enterpriseId":enterpriseId,"configid":2},
                  dataType:"json",
                  type:"POST",
                  success:function(res){
                      if(res['code']=="success"){
                          window.location.href="{{asset('/cert_enterprise')}}";
                      }else{
                          alert("审核失败");
                          window.location.href="{{asset('/cert_enterprise')}}";
                      }
                  }
              })
          });
      })
    </script>
@endsection