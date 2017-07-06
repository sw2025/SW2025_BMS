<!DOCTYPE html>
<html lang="en">
<head>
    <title>升维网后台管理系统</title>
    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="升维网">
    <meta name="description" content="">
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,300,400,600,700,800' rel='stylesheet' type='text/css'/>
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/modules/boostbox/css/theme-5/bootstrap-1401441891.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/modules/boostbox/css/theme-5/boostbox-1401441889.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/modules/boostbox/css/theme-5/boostbox_responsive-1401441889.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/modules/boostbox/css/theme-5/font-awesome.min-1401441891.css')}}" />
    <!-- END STYLESHEETS -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="http://www.codecovers.eu/assets/js/modules/boostbox/libs/utils/html5shiv.js?1401441990"></script>
    <script type="text/javascript" src="http://www.codecovers.eu/assets/js/modules/boostbox/libs/utils/respond.min.js?1401441990"></script>
    <![endif]-->
    <!-- BEGIN JAVASCRIPT -->
    <script src="{{asset('assets/js/modules/boostbox/libs/jquery/jquery-1.11.0.min.js')}}"></script>
    {{--<script src="{{asset('js/jquery.min.js')}}"></script>--}}
    <script src="{{asset('assets/js/modules/boostbox/libs/jquery/jquery-migrate-1.2.1.min.js')}}"></script>
    <script src="{{asset('assets/js/modules/boostbox/core/BootstrapFixed.js')}}"></script>
    <script src="{{asset('assets/js/modules/boostbox/libs/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/modules/boostbox/libs/spin.js/spin.min.js')}}"></script>
    <script src="{{asset('assets/js/modules/boostbox/libs/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('assets/js/modules/boostbox/core/App.js')}}"></script>
    <script src="{{asset('assets/js/modules/boostbox/core/demo/Demo.js')}}"></script>
    <!-- END JAVASCRIPT -->
</head>
<body class="body-dark">
<!-- START LOGIN BOX -->
<div class="box-type-login">
    <div class="box text-center">
        <div class="box-head">
            <h2 class="text-light text-white">升维网后台管理系统</h2>
            <!-- <h4 class="text-light text-inverse-alt">Great Wall</h4> -->
        </div>
        <div class="box-body box-centered style-inverse">
            <h2 class="text-light">请输入您的用户名和密码</h2>
            <br/>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="用户名">
                    <span class="phone"></span>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" name="passWord" id="passWord" placeholder="密码">
                    <span class="passWord"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btn"><i class="fa fa-key"></i> 登录</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END LOGIN BOX -->
<script>
    $("#btn").on("click",function(){
        var phone=$("#phone").val();
        var passWord=$("#passWord").val();
        if(phone.length==0){
            $(".phone").text("账号不能为空!");
            return false;
        }
        if(phone.length!=0){
            var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
            if(!myreg.test(phone)) {
                $(".phone").text("请输入有效的手机号码!");
                return false;
            }
        }
        if(passWord.length==0){
            $(".passWord").text("密码不能为空!");
            return false;
        }
        $.ajax({
            url:"{{asset('/login')}}",
            data:{"phone":phone,"passWord":passWord},
            dataType:"json",
            type:"POST",
            success:function(res){
                if(res['code']=="phone"){
                    $(".name").text(res['msg']);
                }else if(res['code']=="passWord"){
                    $(".passWord").text(res['msg']);
                }else{
                    window.location.href="{{asset('/index')}}";
                }
            }
        })
    })
</script>
</body>
</html>