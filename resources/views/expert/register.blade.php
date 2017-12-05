<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IE Image Upload</title>
    <link rel="stylesheet" href="{{asset('jcrop/css/jquery.Jcrop.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('jcrop/js/jquery.Jcrop.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/layer/layer.js')}}"></script>
    {{--<script type="text/javascript" src="js/imgCropUpload.js"></script>--}}
    <style type="text/css">
        #truecaijian{
            border: 1px solid #000;
            background: #fff;
            width: 200px;
            height: 30px;
            border-radius: 5px;
            margin: 5px 5px 5px 30px;
        }
        img{max-width: 100%;height:auto;}
        ol, ul, li,a {list-style: none;text-decoration: none;}
        body{
            font-size: 14px;
            font-family: "Microsoft YaHei";
            padding:0;
            margin: 0;
            color:#8D8D8D;
            /*background: #E7E8EB;*/
        }

        .upload-control{
            padding: 20px;
            border: 2px dashed #cccccc;
            border-radius: 15px;
        }
        .file-control{
            margin-top: 10px;
        }
        .upload-control input[type=file]{
            position:relative;
            left:-7px;
            top: -40px;
            opacity:0;
            z-index:1;
            width:223px;
            height: 40px;
            cursor: pointer;
            text-align: center;
            margin-bottom: -30px;
        }
        .system-img ul{
            display: block;
            margin: 0;
            padding: 0;
        }


    </style>
</head>
<body>
<div class="upload-control center">

    <div class="file-control">
        <img src="" style="width: 40px;">
        <span>请选择需要上传的图片</span>
    </div>
    <input type="file" name="image_file" id="image_file" onchange="fileSelectHandler()">
    <div class="error"></div>
    <p><i>注：图片格式需为.jpg或.png,其它格式无效(不支持中文命名)，且图片大小不超过1MB。</i></p>

</div>
<div id="hidden" style="display: none;">
    <div class="popUp-box-mask" id="popUp-box-mask"></div>
    <form action="{{url('changeavatar')}}" method="post" name="form2" enctype="multipart/form-data" onSubmit="return checkForm()" >
        <div id="uploadimg-control" class="popUp-box">
            <div class="align-right" id="close"><i></i></div>
            <div class="popUp-box-inner">
                <div class="img-container">
                    <img id="preview" src="" style="text-align:center;">
                </div>
                <!-- hidden crop params -->
                <input type="hidden" id="photo" name="photo" />
                <input type="hidden" id="x1" name="x1" />
                <input type="hidden" id="y1" name="y1" />
                <input type="hidden" id="x2" name="x2" />
                <input type="hidden" id="y2" name="y2" />
                <input type="hidden"  id="w" name="w" />
                <input type="hidden"  id="h" name="h" />
                <div class="up-btn">
                    <a href="" class="up-btn-sd btn-bg-s"><input type="submit" value="确定" id="truecaijian"></a> {{--<a href="" class="up-btn-sd btn-bg-d" id="resetBtn" onclick="return false;">取消</a>--}}
                </div>
            </div>
        </div>
    </form>
</div>


{{--<div class="example">
    <!-- This is the image we're attaching Jcrop to -->
    <img src="{{asset('img/zhanwei.jpg')}}" id="cropbox">
</div>

<div class="example">
    <!-- This is the form that our event handler fills -->
    <form action="?" method="post" onsubmit="return checkCoords();">
        <input type="hidden" id="x1" name="x1" />
        <input type="hidden" id="y1" name="y1" />
        <input type="hidden" id="x2" name="x2" />
        <input type="hidden" id="y2" name="y2" />
        <input type="hidden"  id="w" name="w" />
        <input class="button blue" type="submit" value="裁剪图像">
    </form>
</div>--}}
<script type="text/javascript">

    function bytesToSize(bytes) {
        var sizes = ['Bytes', 'KB', 'MB'];
        if (bytes == 0) return 'n/a';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
    };
    // check for selected crop region
    function checkForm() {
        if (parseInt($('#w').val())) {
            return true;
        }else{
            layer.alert('请选择一个裁剪的区域！');
            return false;
        }
    };

    // update info by cropping (onChange and onSelect events handler)
    function updateInfo(e) {
        $('#x1').val(e.x);
        $('#y1').val(e.y);
        $('#x2').val(e.x2);
        $('#y2').val(e.y2);
        $('#w').val(e.w);
        $('#h').val(e.h);
    };

    // clear info by cropping (onRelease event handler)
    function clearInfo() {
        $('#w').val('');
        $('#h').val('');
        layer.closeAll();
    };

    function fileSelectHandler() {

        // get selected file
        var oFile = $('#image_file')[0].files[0];
        // hide all errors
        $('.error').hide();

        // check for image type (jpg and png are allowed)
        var rFilter = /^(image\/jpeg|image\/png)$/i;
        if (! rFilter.test(oFile.type)) {
            $('.error').html('图片格式不符合要求，请重新选择！').show();
            return;
        }
        var fsize=oFile.size ; //文件大小（bit）
        fsize=fsize/1024;//计算当前上传文件的大小
        // check for file size
        if (fsize>1024) {
            $('.error').html('上传的图片大小大于1MB，请重新选择！').show();
            return;
        }


        // preview element
        var oImage = document.getElementById('preview');

        // prepare HTML5 FileReader
        var oReader = new FileReader();
        oReader.onload = function(e) {
            // e.target.result contains the DataURL which we can use as a source of the image
            oImage.src = e.target.result;
//        alert( oImage.src);
            $('#photo').val(e.target.result);

            oImage.onload = function () { // onload event handler

                layer.open({
                    type: 1,
                    shade: false,
                    area: ['1000px', '550px'],
                    skin: 'layui-layer-rim', //加上边框
                    title: '截取图片', //不显示标题
                    content: $('#hidden'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
                    cancel: function(){
                        $("#popUp-box-mask,#uploadimg-control").css("display","none");
                        $("#preview").attr("src",' ');
                        $(".crop-holder img").attr("src",' ');
                        jcrop_api.destroy();
                        $('#w').val('');
                        $('#h').val('');
                        $('#x1').val("");
                        $('#x2').val("");
                        $('#y1').val("");
                        $('#y2').val("");
                    }
                });
                // display step 2
                $('#uploadimg-control,#popUp-box-mask').fadeIn(500);

                // Create variables (in this scope) to hold the Jcrop API and image size
                var jcrop_api, boundx, boundy;

                // destroy Jcrop if it is existed
                if (typeof jcrop_api != 'undefined')
                    jcrop_api.destroy();

                // initialize Jcrop
                $('#preview').Jcrop({
                    minSize: [32, 32], // min crop size
                    aspectRatio : 1, // keep aspect ratio 1:1
                    bgFade: true, // use fade effect
                    bgOpacity: .3, // fade opacity
                    onChange: updateInfo,
                    onSelect: updateInfo,
                    onRelease: clearInfo
                }, function(){

                    // use the Jcrop API to get the real image size
                    var bounds = this.getBounds();
                    boundx = bounds[0];
                    boundy = bounds[1];

                    // Store the Jcrop API in the jcrop_api variable
                    jcrop_api = this;
                });
            };
        };
        // read selected file as DataURL
        oReader.readAsDataURL(oFile);
    }
    $("#close,#resetBtn").bind("click",function(){
        //alert("wwwee");
        $("#popUp-box-mask,#uploadimg-control").css("display","none");
        $("#preview").attr("src",' ');
        $('#w').val('');
        $('#h').val('');
        $('#x1').val("");
        $('#x2').val("");
        $('#y1').val("");
        $('#y2').val("");
    });

    /*var jcropApi,
    boundx,
    boundy,
    $preview = $('#preview-pane'),
    $pcnt = $('#preview-pane .preview-container'),
    $pimg = $('#preview-pane .preview-container img'),
    xsize = $pcnt.width(),ysize = $pcnt.height();
    $('#cropbox').Jcrop({
        minSize: [64, 64], // min crop size
        aspectRatio: 1, // keep aspect ratio 1:1
        bgFade: true, // use fade effect
        bgOpacity: .3, // fade opacity
        onChange: updateInfo,
        onSelect: updateInfo,

    });
    function updateInfo(c) {
        if (parseInt(c.w) > 0) {
            var rx = xsize / c.w;
            var ry = ysize / c.h;

            $pimg.css({
                width: Math.round(rx * boundx) + 'px',
                height: Math.round(ry * boundy) + 'px',
                marginLeft: '-' + Math.round(rx * c.x) + 'px',
                marginTop: '-' + Math.round(ry * c.y) + 'px'
            });
        }
        $('#x1').val(c.x);
        $('#y1').val(c.y);
        $('#x2').val(c.x2);
        $('#y2').val(c.y2);
        $('#w').val(c.w);
        $('#h').val(c.h);
    };
    function checkCoords(){
        if (parseInt($('#w').val())) {
            return true;
        };
        alert('请先选择要裁剪的区域后，再提交。');
        return false;
    };*/
</script>
</body>
</html>