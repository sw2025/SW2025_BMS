
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="robots" content="all">
    <title>升维网-后台专家录入</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="{{asset('myupload/ycbootstrap.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('myupload/reset.css')}}"/>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('myupload/iscroll-zoom.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('myupload/hammer.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('myupload/lrz.all.bundle.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('myupload/jquery.photoClip.min.js')}}" type="text/javascript" charset="utf-8"></script>

</head>
<body>
<h1 style="color:@if(!empty($errors->all()) && $errors->all()[0] == '注册成功') #00c566 @else #f10 @endif  ">{{$errors->all()[0] or ''}}</h1>
    <div class="container col-md-8 col-sm-8 col-xs-8 center-block" style="margin: 10px;" id="submitform">
        <form action="{{url('/submitexpert')}}" method="post" style="margin-left: 5px;" enctype="multipart/form-data" >
            <div class="form-group">
                <label for="exampleInputEmail1">手机号码</label>
                <input type="text" maxlength="11" class="form-control" name="phonenumber" required/>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">密码 </label>
                <input type="text" name="password"  class="form-control" value="123456" required/>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">专家姓名 </label>
                <input type="text" name="name" value="" class="form-control" required/>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-6">
                <label for="exampleInputPassword1">专家分类 </label>
                <select name="category" class="form-control" required>
                    <option selected>专家</option>
                    <option >机构</option>
                    <option >企业家</option>
                </select>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-6">
                <label for="exampleInputPassword1">所在地区 </label>
                <select name="address"  class="form-control" >
                    <option selected>北京</option>
                    <option>上海</option>
                    <option>天津</option>
                    <option>重庆</option>
                    <option>河北</option>
                    <option>山西</option>
                    <option>内蒙古</option>
                    <option>辽宁</option>
                    <option>吉林</option>
                    <option>黑龙江</option>
                    <option>江苏</option>
                    <option>浙江</option>
                    <option>安徽</option>
                    <option>福建</option>
                    <option>江西</option>
                    <option>山东</option>
                    <option>河南</option>
                    <option>湖北</option>
                    <option>湖南</option>
                    <option>广东</option>
                    <option>广西</option>
                    <option>海南</option>
                    <option>四川</option>
                    <option>贵州</option>
                    <option>云南</option>
                    <option>西藏</option>
                    <option>陕西</option>
                    <option>甘肃</option>
                    <option>青海</option>
                    <option>宁夏</option>
                    <option>新疆</option>
                    <option>台湾</option>
                    <option>香港</option>
                    <option>澳门</option>

                </select>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-6">
                <label for="exampleInputPassword1">专家分类1 </label>
                <select name="domain1" class="form-control" required>
                    @foreach($domain1 as $v)
                        <option>{{$v->domainname}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-6">
                <label for="exampleInputPassword1">专家分类2 </label>
                <select name="domain2" class="form-control" required>
                    @foreach($domain2 as $v)
                        <option>{{$v->domainname}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-6">
                <label for="exampleInputPassword1">专家等级 </label>
                <select name="level" class="form-control" required>
                        <option value="0">0级</option>
                        <option value="1">1级</option>
                        <option value="2">2级</option>
                </select>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-6">
                <label for="exampleInputPassword1">是否设为首页 </label>
                <select name="isfirst" class="form-control" required id="order">
                    <option value="0">否</option>
                    <option value="1">是</option>
                </select>
                <input type="text" name="order" class="form-control" style="display: none;" placeholder="请输入专家顺序"/>
            </div>
            <div class="form-group">
                <label for="exampleInputFile" required>专家简介</label>
                <textarea rows="6" name="brief" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="exampleInputFile">上传专家图片</label>
                <li class="list-group-item list-group-item-success">请上传320*320的封面图片</li>
                <div class="row" style="margin-top: 10px;">
                    <input type="hidden" name="showimage" value="" id="showimage">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="padding-right:0;padding-left:36px;">
                        <!--<a href="javascript:void(0);" class="cover-uploadBtn">
                            <img src="img/yc_uploadimg_06.png"/>
                            <div id="clipArea"></div>
                            <input type="file" id="file">
                            <button id="clipBtn">截取</button>
                        </a>
                        <div id="view"></div>-->
                        <div style="min-height:1px;line-height:160px;text-align:center;position:relative;" ontouchstart="">
                            <div class="cover-wrap" style="display:none;position:fixed;left:0;top:0;width:100%;height:100%;background: rgba(0, 0, 0, 0.4);z-index: 10000000;text-align:center;">
                                <div class="" style="width:900px;height:600px;margin:5px auto;background-color:#FFFFFF;overflow: hidden;border-radius:4px;">
                                    <div id="clipArea" style="margin:10px;height: 520px;"></div>
                                    <div class="" style="height:56px;line-height:36px;text-align: center;padding-top:8px;">
                                        <button id="clipBtn" style="width:120px;height: 36px;border-radius: 4px;background-color:#ff8a00;color: #FFFFFF;font-size: 14px;text-align: center;line-height: 36px;outline: none;">保存封面</button>
                                    </div>
                                </div>
                            </div>
                            <div id="view" style="width:214px;height:214px;background-image:url('img/avatar.jpg');" title="请上传 320*320 的封面图片"></div>
                            <div style="height:10px;"></div>
                            <div class="" style="cursor:pointer;    width:140px;height:32px;border-radius: 4px;background-color:#ff8a00;color: #FFFFFF;font-size: 14px;text-align:center;line-height:32px;outline:none;margin-left:37px;position:relative;">
                                点击上传封面图
                                <input type="file" id="file" style="cursor:pointer;opacity:0;filter:alpha(opacity=0);width:100%;height:100%;position:absolute;top:0;left:0;" name="photo">
                            </div>
                        </div>


                    </div>
                </div>
            </div>






            <button type="submit" class="btn btn-success" style="margin: 20px;width: 250px;" onclick="$('#submitform').submit()">提交专家资料</button>
        </form>
    </div>


<script type="text/javascript">
    $('#clipBtn').on('click',function (e) {
        e.preventDefault(); // 兼容标准浏览器
    });
    $('#order').on('change',function () {
        var isorder = $(this).find('option:selected').val();
        if(isorder == 1){
            $(this).siblings('input').show();
        } else {
            $(this).siblings('input').hide();
        }
    });
    //上传封面
    //document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
    var clipArea = new bjj.PhotoClip("#clipArea", {
        size: [480, 480],// 截取框的宽和高组成的数组。默认值为[260,260]
        outputSize: [480, 481], // 输出图像的宽和高组成的数组。默认值为[0,0]，表示输出图像原始大小
        outputType: "jpg", // 指定输出图片的类型，可选 "jpg" 和 "png" 两种种类型，默认为 "jpg"
        file: "#file", // 上传图片的<input type="file">控件的选择器或者DOM对象
        view: "#view", // 显示截取后图像的容器的选择器或者DOM对象
        ok: "#clipBtn", // 确认截图按钮的选择器或者DOM对象
        loadStart: function() {
            // 开始加载的回调函数。this指向 fileReader 对象，并将正在加载的 file 对象作为参数传入
            $('.cover-wrap').fadeIn();
            console.log("照片读取中");
        },
        loadComplete: function() {
            // 加载完成的回调函数。this指向图片对象，并将图片地址作为参数传入
            console.log("照片读取完成");
        },
        //loadError: function(event) {}, // 加载失败的回调函数。this指向 fileReader 对象，并将错误事件的 event 对象作为参数传入
        clipFinish: function(dataURL) {
            // 裁剪完成的回调函数。this指向图片对象，会将裁剪出的图像数据DataURL作为参数传入
            $('.cover-wrap').fadeOut();
            $('#view').css('background-size','100% 100%');
            $('#showimage').val(dataURL);
            return false;
        }
    });

    //clipArea.destroy();
</script>
</body>
</html>
