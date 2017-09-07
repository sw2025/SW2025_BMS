<!DOCTYPE html>
<html lang="en">
<head>
    <title>升维网后台管理系统</title>
    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">
    <!-- END META -->
    <!-- BEGIN STYLESHEETS -->
   {{-- <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,300,400,600,700,800' rel='stylesheet' type='text/css'/>--}}
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/modules/boostbox/css/theme-5/bootstrap-1401441891.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/modules/boostbox/css/theme-5/boostbox-1401441889.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/modules/boostbox/css/theme-5/boostbox_responsive-1401441889.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/modules/boostbox/css/theme-5/font-awesome.min-1401441891.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/modules/boostbox/css/theme-5/libs/DataTables/jquery.dataTables-1401442112.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/modules/boostbox/css/theme-5/libs/DataTables/TableTools-1401442112.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/public.css')}}" />

    <script src="{{asset('assets/js/modules/boostbox/libs/jquery/jquery-1.11.0.min.js')}}"></script>
    <script src="{{asset('assets/js/modules/boostbox/libs/jquery/jquery-migrate-1.2.1.min.js')}}"></script>
    <script src="{{asset('assets/js/modules/boostbox/core/BootstrapFixed.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/layer/layer.js')}}"></script>
    <script src="{{asset('assets/js/modules/boostbox/libs/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/modules/boostbox/core/App.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/dist/echarts.js')}}"></script>
    <script src="{{asset('assets/js/modules/boostbox/libs/jquery-validation/dist/jquery.validate.min.js')}}"></script>
     <script src="{{asset('assets/js/modules/boostbox/libs/jquery-validation/dist/additional-methods.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}" type="text/javascript"></script>
    {{-- <script src="js/jquery.pagination.js" type="text/javascript"></script>--}}
            <!-- END STYLESHEETS -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="http://www.codecovers.eu/assets/js/modules/boostbox/libs/utils/html5shiv.js?1401441990"></script>
    <script type="text/javascript" src="http://www.codecovers.eu/assets/js/modules/boostbox/libs/utils/respond.min.js?1401441990"></script>
    <![endif]-->
</head>
<body>
<header id="header">
    <nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <a class="btn btn-transparent btn-equal btn-menu" href="javascript:void(0);"><i class="fa fa-bars fa-lg"></i></a>
            <div class="navbar-brand">
                <a class="main-brand" href="{{asset('/index')}}">
                    <h3 class="text-light text-white"><span>升维网后台管理系统</span></h3>
                </a>
            </div>
            <a class="btn btn-transparent btn-equal navbar-toggle" data-toggle="collapse" data-target="#header-navbar-collapse"><i class="fa fa-wrench fa-lg"></i></a>
        </div>
        <div class="collapse navbar-collapse" id="header-navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown"><a class="dropdown-toggle myname">胖大海</a></li>
                <li class="dropdown">
                    <a href="{{asset('/quit')}}" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-power-off text-danger"></i>退出</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div id="base">
    <div id="sidebar">
        <div class="sidebar-back"></div>
        <div class="sidebar-content">
            <div class="nav-brand">
                <a class="main-brand" href="{{asset('/index')}}">
                    <h3 class="text-light text-white"><span>升维网后台管理系统</span></h3>
                </a>
            </div>
            <ul class="main-menu">
                <li>
                    <a href="{{asset('/index')}}"><i class="fa fa-home fa-fw"></i><span class="title">首页</span></a>
                </li>
                <li>
                    <a href="javascript:void(0);">
                        <i class="fa fa-gear fa-fw"></i><span class="title">基础设置</span> <span class="expand-sign">+</span>
                    </a>
                    <ul>
                        <li><a href="{{asset('/change_pwd')}}">修改密码</a></li>
                        <li><a href="{{asset('/operate_people')}}">操作人员</a></li>
                        <li><a href="{{asset('/role')}}" >角色权限</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);">
                        <i class="fa fa-gear fa-fw"></i><span class="title">参数设置</span> <span class="expand-sign">+</span>
                    </a>
                    <ul>
                        <li><a href="{{asset('/member')}}">会员权益</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);">
                        <i class="fa fa-edit fa-fw"></i><span class="title">审核操作</span> <span class="expand-sign">+</span>
                    </a>
                    <ul>
                        <li><a href="{{asset('/cert_enterprise')}}">企业认证审核</a></li>
                        <li><a href="{{asset('/cert_expert')}}">专家认证审核</a></li>
                        <li><a href="{{asset('/cert_supply')}}">供求信息审核</a></li>
                        <li><a href="{{asset('/cert_work')}}">办事服务审核</a></li>
                        <li><a href="{{asset('/cert_video')}}">视频咨询审核</a></li>
                        <li><a href="{{asset('/cert_recharge')}}">提现申请审核</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);">
                        <i class="fa fa-puzzle-piece fa-fw"></i><span class="title">信息维护</span> <span class="expand-sign">+</span>
                    </a>
                    <ul>
                        <li><a href="{{asset('/serve_enterprise')}}" >企业信息维护</a></li>
                        <li><a href="{{asset('/serve_expert')}}">专家信息维护</a></li>
                        <li><a href="{{asset('/serve_supply')}}">需求信息维护</a></li>
                        <li><a href="{{asset('/serve_work')}}">办事服务信息</a></li>
                        <li><a href="{{asset('/serve_video')}}">视频咨询信息</a></li>
                        <li><a href="{{asset('/serve_recharge')}}">充值提现信息</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    @yield("content")
</div>
<div class="modal modal-reason">
    <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button">关闭</button>
    </div>
    <div class="modal-body">
        <div class="reject-reasons">
            <form class="form-horizontal form-bordered" role="form">
                <div class="form-group">
                    <div class="col-lg-3 col-md-2 col-sm-3">
                        <label for="textarea3" class="control-label">请输入拒绝原因</label>
                    </div>
                    <div class="col-lg-9 col-md-10 col-sm-9">
                        <textarea name="textarea" class="form-control" rows="3" placeholder="请输入拒绝原因"></textarea>
                    </div>
                </div>
                <div class="form-footer col-lg-offset-1 col-md-offset-2 col-sm-offset-3">
                    <button type="button" class="btn btn-primary">确定</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<script>
    $('.main-menu li ul li a').each(function () {
        if($(this).attr('href') == window.location.href){
            $(this).addClass('active');
        }
    });
</script>