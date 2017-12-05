@extends("layouts.master")
@section("content")
    <div id="content">
        <section>
            <ol class="breadcrumb">
                <li>板块设置</li>
                <li class="active"></li>
            </ol>
            <div class="section-body change-pwd">
                <div class="col-md-12">

                    <div class="box box-outlined">
                        <div class="box-head tac">
                            <h4 class="text-light tac">新增板块信息</h4>
                        </div>
                        <div class="box-body no-padding">
                            <form class="form-horizontal form-bordered form-validate" role="form" novalidate="novalidate" action="{{url('addModular')}}" method="post">

                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="timelimit" class="control-label">板块名称</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <input type="text" name="name" id="timelimit" class="form-control" placeholder="请输入板块名称" required="" data-rule-minlength="1" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="selector" class="control-label">板块等级</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <select name="grade" id="selector" class="form-control" required="">
                                            <option value="">请选择</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="url" style="display:none;">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="fees" class="control-label">URL</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <input type="text" name="url" id="fees" class="form-control" placeholder="请输入url" required="" value="">
                                    </div>
                                </div>

                              <div class="form-group" id="bankuai" style="display:none;">
                                    <div class="col-lg-3 col-sm-2">
                                        <label for="selectora" class="control-label">所属板块</label>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <select name="typename" id="selectora" class="form-control" required="">
                                            <option value="">请选择</option>
                                            @foreach($data as $small)
                                                    <option value="{{$small->permissionname}}">{{$small->permissionname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-lg-3 col-sm-2">
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                    </div>
                                </div>
                                <div class="form-footer col-lg-offset-3 col-sm-offset-2">
                                    <button type="submit" style="margin-left: 26%;" class="btn btn-primary">保存</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>

        $("#selector").blur(function(){
           var a = $('#selector').val();
            if(a==1){
                $('#url').css('display','none');
                $('#bankuai').css('display','none');
            }else{
                $('#url').css('display','');
                $('#bankuai').css('display','');
            }
        });

        /*$("form").submit(function(){
            var a = $('#selector').val();
            if(a==1){
                $('#url').css('display','none');
                $('#bankuai').css('display','none');
            }else{
                $('#url').css('display','');
                $('#bankuai').css('display','');
            }
        });*/

    </script>
@endsection