$(document).ready(function(){
    var condition=new Array();
    $('.cert-state-btns a').on('click', function(event) {
        event.preventDefault();
        $(this).addClass('current').siblings().removeClass('current');
    });

    $('.demo-list').on('click', 'li', function(event) {
        event.preventDefault();
        $(this).parent().prev('.result-select').html($(this).children().html());
    });


    /**
     * 搜索
     */
    $(".search-bar-btn").on("click",function(){
        var valHtml = $(".search-bar-inp").val();
        /*  var condition=new Array();*/
        condition[0]="serveName";
        condition[1]=valHtml;
        getCondition(condition);
    })



    $('.serve-industry-sel').on('click','li', function(event) {
        event.preventDefault();
        var valHtml = $(this).children().html();
        if(valHtml != '不限'){
            $('.results-unit-industry').html(valHtml).show();
        }
        condition[0]="job";
        condition[1]=valHtml;
        getCondition(condition);
    });
    $('.serve-zone-sel').on('click','li', function(event) {
        event.preventDefault();
        var valHtml = $(this).children().html();
        if(valHtml != '全国'){
            $('.results-unit-zone').html(valHtml).show();
        }
        condition[0]="location";
        condition[1]=valHtml;
        getCondition(condition);
    });

    /**
     * 首页筛选
     */
    $('.serve-member-sel').on('click','li', function(event) {
        event.preventDefault();
        var valHtml = $(this).children().html();
        if(valHtml != '不限'){
            $('.results-unit-member').html(valHtml).show();
        }
         condition[0]="idCard";
        condition[1]=valHtml;
        getCondition(condition);
    });

    $('.results-unit').on('click','a', function(event) {
        event.preventDefault();
        $(this).empty().hide();
        if($(this).hasClass('results-unit-scale')){
            condition[0]="size";
            condition[1]=null;
        }
        if($(this).hasClass('results-unit-industry')){
            condition[0]="job";
            condition[1]=null;
        }
        if($(this).hasClass('results-unit-zone')){
            condition[0]="location";
            condition[1]="全国";
        }
        if($(this).hasClass('results-unit-member')){
            condition[0]="idCard";
            condition[1]=null;
        }

        getCondition(condition);

    });

    $('.sub-industry li a').on('click',function () {
        var valHtml = $(this).html();
        $('.results-unit-industry').html(valHtml).show();
        condition[0]="job";
        condition[1]=valHtml;
        getCondition(condition);
    });

    // 二级行业

    $('.sub-industry>li').on('hover', function(event) {
        event.preventDefault();
        $(this).children('.sub-industry-menu').toggle();
    });
    $('.sub-industry-menu').on('click','li', function(event) {
        event.preventDefault();
        var valHtml = $(this).html();
        var parentHtml = $(this).parent().siblings().html();
        condition[0]="job";
        condition[1]=parentHtml+'/'+valHtml;
        getCondition(condition);
        $(this).children('.sub-industry-menu').toggle();
        $(this).closest('.sub-industry').prev('.result-select').html(valHtml);
        $('.results-unit-industry').html(valHtml).show();
    });



    $('.order-scale').click(function(event) {
        if($(this).children('i').hasClass('fa-arrow-circle-o-up')){
            $(this).children('i').removeClass('fa-arrow-circle-o-up').addClass('fa-arrow-circle-o-down');
            condition[0]="sizeType";
            condition[1]="down";
            getCondition(condition);
        }else{
            $(this).children('i').removeClass('fa-arrow-circle-o-down').addClass('fa-arrow-circle-o-up');
            condition[0]="sizeType";
            condition[1]="up";
            getCondition(condition);
        }
    });
    $('.order-time').click(function(event) {
        if($(this).children('i').hasClass('fa-arrow-circle-o-up')){
            $(this).children('i').removeClass('fa-arrow-circle-o-up').addClass('fa-arrow-circle-o-down');

            condition[0]="regTime";
            condition[1]="down";
            getCondition(condition);
        }else{
            $(this).children('i').removeClass('fa-arrow-circle-o-down').addClass('fa-arrow-circle-o-up');

            condition[0]="regTime";
            condition[1]="up";
            getCondition(condition);
        }
    });
    var getCondition= function(condition){
        var Condition=condition;
        var serveName=$(".search-bar-inp").val();
        var job=$.trim($("#job").html());
        var location=$.trim($("#location").html());
        var idCard=$.trim($("#idCard").html());
        serveName=(serveName)?serveName:null;
        job=(job!="不限")?job:null;
        location=(location!="全国")?location:"全国";
        idCard=(idCard!="不限")?idCard:null;
        if( $(".order-time").children('i').hasClass('fa-arrow-circle-o-up')){
            var regTime="up";
        }else{
            var regTime="down";
        }
        if(Condition.length!=0){
            switch(Condition[0]){
                case "serveName":
                    serveName=Condition[1];
                    break;
                case "job":
                    job=(Condition[1]!="不限")?Condition[1]:null;
                    break;
                case "location":
                    location=(Condition[1]!="全国")?Condition[1]:"全国";
                    break;
                case "idCard":
                    idCard=(Condition[1]!="不限")?Condition[1]:null;
                    break;
                case "regTime":
                    regTime=Condition[1];

            }
        }
        window.location.href="?serveName="+serveName+"&idCard="+idCard+"&job="+job+"&location="+location+"&regTime="+regTime;
    }

});