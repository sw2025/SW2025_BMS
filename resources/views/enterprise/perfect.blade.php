@extends("layouts.master")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>导入企业信息</li>
                <li class="active">完善企业信息</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="col-md-12">
                    <p class="tac add-tit"><a href="{{asset('/importenterprises')}}">返回</a></p>
                    <div class="box box-outlined">
                        <div class="box-head tac">
                            <h4 class="text-light tac">完善企业信息</h4>
                        </div>
                        <div class="box-body no-padding">
                            <form class="form-horizontal form-bordered form-validate" role="form" novalidate="novalidate" action="{{url('baocun')}}" method="post">
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="enterprisename" class="control-label">企业名称</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <input type="text" name="enterprisename" id="enterprisename" class="form-control" required="" data-rule-minlength="1" value="{{$data->enterprisename}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="username" class="control-label">法定人</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <input type="text" name="username" id="username" class="form-control"  required="" value="{{$data->username}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="phone1" class="control-label">联系电话1</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <input type="text" name="phone1" id="phone1" class="form-control" data-rule-minlength="1" required="" value="{{$data->phone1}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="phone2" class="control-label">联系电话2</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <input type="text" name="phone2" id="phone2" class="form-control"  data-rule-minlength="1" required="" value="{{$data->phone2}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="industry" class="control-label">行业</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <select name="industry" id="industry" class="form-control" required="">
                                           <option name="moren">{{$data->industry}}</option>
                                           <option value="不限">不限</option>
                                           <option value="IT|通信|电子|互联网">IT|通信|电子|互联网</option>
                                           <option value="金融业">金融业</option>
                                           <option value="房地产|建筑业">房地产|建筑业</option>
                                           <option value="商业服务">商业服务</option>
                                           <option value="贸易|批发|零售|租赁业">贸易|批发|零售|租赁业</option>
                                           <option value="文体教育|工艺美术">文体教育|工艺美术</option>
                                           <option value="生产|加工|制造">生产|加工|制造</option>
                                           <option value="交通|运输|物流|仓储">交通|运输|物流|仓储</option>
                                           <option value="服务业">服务业</option>
                                           <option value="文化|传媒|娱乐|体育">文化|传媒|娱乐|体育</option>
                                           <option value="能源|矿产|环保">能源|矿产|环保</option>
                                           <option value="政府|非盈利机构">政府|非盈利机构</option>
                                           <option value="农|林|牧|渔|其他">农|林|牧|渔|其他</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="address" class="control-label">地区</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <input type="text" name="address" id="address" class="form-control"  data-rule-minlength="1" required="" value="{{$data->address}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="detail" class="control-label">详情</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <textarea name="detail" id="detail" required="" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-footer col-lg-offset-3 col-sm-offset-2">
                                    <input type="submit" name="submit" class="btn btn-primary">
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#industry').click(function () {
            $('[name="moren"]').hide();
        });


        $(function () {
            $("[name='submit']").click(function () {
/*
                if($('div').hasClass('has-error')){
                    alert(123);
                }*/



                var id = $("[name='id']").val();
                var enterprisename =$('#enterprisename').val();
                var username =$('#username').val();
                var phone1 =$('#phone1').val();
                var phone2 =$('#phone2').val();
                var industry =$('#industry').val();
                var address =$('#address').val();
                var detail =$('#detail').val();
                $.ajax({
                    url:"{{url('baocun')}}",
                    data:{'id':id,'enterprisename':enterprisename,'username':username,'phone1':phone1,'phone2':phone2,'industry':industry,'address':address,'detail':detail},
                    dataType:"json",
                    type:"POST",
                    success:function(res){
                        if(res['errorMsg']=="success"){
                            alert("操作成功");
                            window.location.href=window.location;
                        }else{
                            alert("操作失败");
                            window.location.href=window.location;
                        }
                    }
                })
            })

        })

    /*$(function () {
        var kong = $(".help-block").val();
        alert(kong);
        if(kong=='不能为空'){
            alert(1);
        }
    })*/






    </script>
@endsection