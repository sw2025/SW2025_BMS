$(document).ready(function(){
    $('.cert-state-btns a').on('click', function(event) {
        event.preventDefault();
        $(this).addClass('current').siblings().removeClass('current');
    });

    $('#searchsub').on('click',function () {
        var name = $('.search-bar .search-bar-inp').val();
        if(name != ''){
            sendAjax('search',name);
        } else {
            sendAjax('unsearch',name);
        }

    });

    $('.demo-list').on('click', 'li', function(event) {
        event.preventDefault();
        $(this).parent().prev('.result-select').html($(this).children().html());
        var html = $(this).children().html();
        var name = $(this).parent().attr('index');
        if(html == '全部' || html == '全国' || html == '不限'){
            sendAjax('un'+name,html);
        } else {
            sendAjax(name,html);
        }
    });

    $('.serve-scale-sel').on('click','li', function(event) {
        event.preventDefault();
        var valHtml = $(this).children().html();
        if(valHtml != '全部'){
            $('.results-unit-scale').attr('index','unpublishing');
            $('.results-unit-scale').html(valHtml).show(200);
        } else {
            $('.results-unit-scale').html(valHtml).hide(200);
        }
    });

    $('.serve-industry-sel').on('click','li', function(event) {
        //alert(222);
        event.preventDefault();
        var valHtml = $(this).children().html();
        if(valHtml != '不限'){
            $('.results-unit-industry').attr('index','undomain');
            $('.results-unit-industry').html(valHtml).show(200);
        } else {
            $('.results-unit-industry').html(valHtml).hide(200);
        }
    });

    $('.serve-zone-sel').on('click','li', function(event) {
        //alert(333);
        event.preventDefault();
        var valHtml = $(this).children().html();
        if(valHtml != '全国'){
            $('.results-unit-zone').attr('index','unaddress');
            $('.results-unit-zone').html(valHtml).show(200);
        } else {
            $('.results-unit-zone').html(valHtml).hide(200);
        }
    });
    /**
     * 这段js没用
     * */
    $('.serve-member-sel').on('click','li', function(event) {
        alert(444);
        event.preventDefault();
        var valHtml = $(this).children().html();
        if(valHtml == '全部' || valHtml == '全国' || valHtml == '不限'){
            $('.results-unit-member').html(valHtml).show();
        }
    });
    /**
     * 删除的js代码
     */
    $('.results-unit').on('click','a', function(event) {
        var name = $(this).attr('index');
        sendAjax(name,'');
        event.preventDefault();
        $(this).empty().hide();
    });

    $('.result-order a').click(function(event) {
        if($(this).children('i').hasClass('fa-arrow-circle-o-up')){
            sendAjax('ordertime','desc');
            $(this).children('i').removeClass('fa-arrow-circle-o-up').addClass('fa-arrow-circle-o-down');
        }else{
            sendAjax('ordertime','asc');
            $(this).children('i').removeClass('fa-arrow-circle-o-down').addClass('fa-arrow-circle-o-up');
        }
    });

    // 二级行业
    $('.sub-industry>li').on('hover', function(event) {
        event.preventDefault();
        $(this).children('.sub-industry-menu').toggle();
    });
    $('.sub-industry-menu').on('click','li', function(event) {
        event.preventDefault();
        var valHtml = $(this).html();
        $(this).children('.sub-industry-menu').toggle();
        $(this).closest('.sub-industry').prev('.result-select').html(valHtml);
        $('.results-unit-industry').html(valHtml).show();
    });

    //ajax发送请求
    function sendAjax (name,html) {
        var where = $("#where").val();
        $.post("serve_work",{'key':name,'value':html,'where':where},success,'json');
    }



});
/**
 * 分页post请求获取数据
 * @param url
 * @returns {boolean}
 */
function pagenext (url) {
    var where = $('#where').val();
    $.post(url,{'key':'','value':'','where':where},success,'json');
    return false;
}

/**
 * ajax执行成功的方法
 * @param data
 */
function success (data) {
    var info=JSON.parse(data.data);
    var datas=info.data;console.log(info);
    var str='';
    var str_pag='';
    for ($i=0;$i<datas.length;$i++){
        str += '<div class="container-fluid cert-item">';
        str += ' <div class="col-md-4"> ';
        str += '<h2 class="cert-company"><a href="serve_workDet/'+datas[$i].eventid+'" class="look-link">【'+datas[$i].role+'】 ';
        if(datas[$i].enterprisename != null) {
            str += datas[$i].enterprisename;
        } else {
            str += datas[$i].expertname;
        }
        str += '</a></h2>';
        str += '<span class="cert-telephone">联系电话：'+datas[$i].phone+'</span>';
        str += '<p class="cert-scale">需求分类：'+datas[$i].domain1+'/'+datas[$i].domain2+'</p>';
        str += '<p class="cert-scale">地区：'+datas[$i].address+'</p>';
        str += '</div><div class="col-md-8 cert-cap"><span class="cert-work-time">'+datas[$i].eventtime+'</span><span>'+datas[$i].brief+'</span> </div> ';
        str += '<div style="font-size: 18px;float: right;"><span class="label ';
        if(datas[$i].configid == 1)  {str += 'label-primary';}
        else if(datas[$i].configid == 2) {str += 'label-success';}
        else if(datas[$i].configid == 3) {str += 'label-default';}
        else if(datas[$i].configid == 4) {str += 'label-info';}
        else if(datas[$i].configid == 9) {str += 'label-danger';}
        else  {str += 'label-warning';}
        str += '">'+datas[$i].name+'</span> </div></div>';

    }
    str += '<div class="pages"></div>';
    str_pag += '<ul class="pager pagination-lg"><li ';
    if (info.prev_page_url == null){
        str_pag += 'class="disabled" ><a href="javascript:;"  rel="prev"> « </a></li> <li ';
    } else {
        str_pag += '><a href="javascript:;" onclick=pagenext("'+ info.prev_page_url +'") rel="prev"> « </a></li> <li ';
    }
    if (info.next_page_url == null){
        str_pag += 'class="disabled" ><a href="javascript:;"  rel="next"> » </a></li>';
    } else {
        str_pag += '><a href="javascript:;" onclick=pagenext("'+ info.next_page_url +'") rel="next"> » </a></li>';
    }
    str_pag += '<li> <span style="font-size: 17px;">总页数:'+ info.last_page +'</span></li>';
    str_pag += '<li> <span style="font-size: 17px;">当前页:'+ info.current_page +'</span></li>';
    if(info.total > 1) {
        str_pag += ' <li><input type="number" max="'+info.to+'" id="pagenumber"  style="width: 70px;height: 36px;display: inline-block;padding: 5px 14px;background-color: #ffffff;border: 1px solid #dddddd;border-radius: 0px;">';
        str_pag += '<button class="btn btn-success" type="button" onclick=pagenext("serve_work?page="+$("#pagenumber").val()) style="height: 36px; margin-bottom: 4px;">跳转</button></li>';
    }
    str_pag += '</ul>';
    //添加内容
    $('#content2').html(str);
    $('#content2 .pages').html(str_pag);
    //修改数量
    $('.result-order .counts').html('数量:'+info.total);
    //修改隐藏where条件
    $('#where').val(data.where);
}