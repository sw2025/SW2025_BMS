$(document).ready(function(){
    $('.cert-state-btns a').on('click', function(event) {
        event.preventDefault();
        $(this).addClass('current').siblings().removeClass('current');
    });


    $('.demo-list').on('click', 'li', function(event) {
        event.preventDefault();
        $(this).parent().prev('.result-select').html($(this).children().html());
        var html = $(this).children().html();
        if(html != '请选择'){
            var name = $(this).parent().attr('index');
            sendAjax(name,html);
        }
    });

    $('.serve-scale-sel').on('click','li', function(event) {
        event.preventDefault();
        var valHtml = $(this).children().html();
        if(valHtml != '请选择'){
            $('.results-unit-scale').html(valHtml).show();
        }
    });

    $('.serve-industry-sel').on('click','li', function(event) {
        event.preventDefault();
        var valHtml = $(this).children().html();
        if(valHtml != '请选择'){
            $('.results-unit-industry').html(valHtml).show();
        }
    });

    $('.serve-zone-sel').on('click','li', function(event) {
        event.preventDefault();
        var valHtml = $(this).children().html();
        if(valHtml != '请选择'){
            $('.results-unit-zone').html(valHtml).show();
        }
    });
    /**
     * 这段js没用
     * */
    $('.serve-member-sel').on('click','li', function(event) {
        event.preventDefault();
        var valHtml = $(this).children().html();
        if(valHtml != '请选择'){
            $('.results-unit-member').html(valHtml).show();
        }
    });

    $('.results-unit').on('click','a', function(event) {
        alert('我这里是删除条件');
        event.preventDefault();
        $(this).empty().hide();
    });
    $('.result-order a').click(function(event) {
        if($(this).children('i').hasClass('fa-arrow-circle-o-up')){
            $(this).children('i').removeClass('fa-arrow-circle-o-up').addClass('fa-arrow-circle-o-down');
        }else{
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

    function sendAjax (name,html) {
        var where = $("#where").val();

        $.post("serve_supply",{'key':name,'value':html,'where':where},function (data) {
            var datas = data.data;
            var str = '';
            for ($i=0;$i<datas.length;$i++){
               str += '<div class="container-fluid cert-item">';
               str += ' <div class="col-md-4"> ';
               str += '<h2 class="cert-company"><a href={{asset("/serve_supplyDet")}} class="look-link">【'+datas[$i].role+'】 '+datas[$i].enterprisename+datas[$i].expertname+'</a></h2>';
               str += '<span class="cert-telephone">联系电话：'+datas[$i].phone+'</span>';
               str += '<p class="cert-scale">需求分类：'+datas[$i].domain1+'/'+datas[$i].domain2+'</p>';
               str += '<p class="cert-scale">地区：'+datas[$i].address+'</p>';
               str += '</div><div class="col-md-8 cert-cap"><span class="cert-work-time">'+datas[$i].needtime+'</span><span>'+datas[$i].brief+'</span> </div> </div>';

            }
            $('#content2').html(str);
            $('#where').val(data.where);
        });
    }

});