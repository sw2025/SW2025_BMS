@extends("layouts.master")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>直通路演</li>
                <li class="active">完善项目信息</li>
            </ol>
            <div class="section-body change-pwd">
                <div class="col-md-12">
                    <p class="tac add-tit"><a href="{{asset('/roadShow')}}">返回</a></p>
                    <div class="box box-outlined">
                        <div class="box-head tac">
                            <h4 class="text-light tac">完善项目信息</h4>
                        </div>
                        <div class="box-body no-padding">
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="enterprisename" class="control-label">企业名称</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <input type="text" name="enterprisename" id="enterprisename" class="form-control" required=""  value="@if(!empty(unserialize($data->basicdata)['enterprisename'])){{unserialize($data->basicdata)['enterprisename']}}@else @endif">
                                    </div>
                                </div>
                            <div class="form-group">
                                <div class="col-lg-3 col-sm-2">
                                    <label for="industry" class="control-label">公司行业</label>
                                </div>
                                <div class="col-lg-8 col-sm-9">
                                    <select name="industry" id="industry"  class="form-control" index="@if(!empty(unserialize($data->basicdata)['industry'])){{unserialize($data->basicdata)['industry']}}@else @endif">
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
                                        <label for="username" class="control-label">联系人</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <input type="text" name="username" id="username" class="form-control"  required="" value="@if(!empty(unserialize($data->basicdata)['job'])){{unserialize($data->basicdata)['job']}}@else @endif">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="phone1" class="control-label">联系电话</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <input type="text" name="phone" id="phone" class="form-control" data-rule-minlength="1" required="" value="@if(!empty(unserialize($data->basicdata)['phone'])){{unserialize($data->basicdata)['phone']}}@else{{$data->phone or ''}}@endif">
                                    </div>
                                </div>



                              {{--  <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="address" class="control-label">地区</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <input type="text" name="address" id="address" class="form-control"  data-rule-minlength="1" required="" value="{{$data->address or ''}}">
                                    </div>
                                </div>--}}
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="phone2" class="control-label">项目名称</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <input type="text" name="title" id="title" class="form-control"  data-rule-minlength="1" required="" value="{{$data->title or ''}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="phone2" class="control-label">一句话简介</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <input type="text" name="oneword" id="oneword" class="form-control"  data-rule-minlength="1" required="" value="{{$data->oneword or ''}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="domain1" class="control-label">项目领域</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <select name="domain1" id="domain1"  class="form-control" >
                                            @foreach($cate1 as $v)
                                                <option name="moren" @if($v->name==$data->domain1)selected="selected"@endif>{{$v->name or ''}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="preference" class="control-label">投资阶段</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <select name="preference" id="preference"  class="form-control">
                                            @foreach($cate2 as $value)
                                                <option name="moren" @if($value->name==$data->preference)selected="selected"@endif>{{$value->name or ''}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="detail" class="control-label">项目概述</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <textarea name="detail" id="brief"  class="form-control" rows="8">{{$data->brief or ''}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="phone2" class="control-label">商业计划书</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <a href="{{env('ImagePath')}}/show/{{$datas->bpurl or ''}}"><strong>{{$data->bpname or ''}}</strong></a>
                                       <button>重新上传</button>
                                    </div>
                                </div>

                                <div class="form-footer col-lg-offset-3 col-sm-offset-2">
                                    <button  id="submit" index="{{$data->showid}}" style="margin-top:160px;width:60px;height:30px;background:green;border-style:none;">提交</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        var industry = $('#industry').attr('index');
        $('#industry').val($.trim(industry));

     /*   $('#industry option').each(function () {
            if($.trim($(this).val()) == $.trim(industry)){
            }
        });*/
            $("#submit").on('click',function () {
                var showid = $("#submit").attr('index');
                var enterprisename =$('#enterprisename').val();
                var username =$('#username').val();
                var industry =$('#industry').val();
                var phone =$('#phone').val();
                var title =$('#title').val();
                var oneword =$('#oneword').val();
                var domain1 =$('#domain1').val();
                var preference =$('#preference').val();
                var brief =$('#brief').val();

                //var address =$('#address').val();
                $.ajax({
                    url:"{{url('preservation')}}",
                    data:{'showid':showid,'enterprisename':enterprisename,'username':username,'industry':industry,'phone':phone,'domain1':domain1,'preference':preference,'title':title,'oneword':oneword,'brief':brief},
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
    </script>
@endsection