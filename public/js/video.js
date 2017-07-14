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
    $(".search-bar-btn").on("click",function(){
        var valHtml = $(".search-bar-inp").val();
        /*  var condition=new Array();*/
        condition[0]="serveName";
        condition[1]=valHtml;
        getCondition(condition);
    })
    $('.serve-scale-sel').on('click','li', function(event) {
        event.preventDefault();
        var valHtml = $(this).children().html();
        if(valHtml != '不限'){
            $('.results-unit-scale').html(valHtml).show();
        }
        condition[0]="size";
        condition[1]=valHtml;
        getCondition(condition);
    });
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
        var size=$.trim($("#size").html());
        var job=$.trim($("#job").html());
        var location=$.trim($("#location").html());
        var idCard=$.trim($("#idCard").html());
        serveName=(serveName)?serveName:null;
        size=(size!="不限")?size:null;
        job=(job!="不限")?job:null;
        location=(location!="全国")?location:"全国";
        idCard=(idCard!="不限")?idCard:null;
        if( $(".order-scale").children('i').hasClass('fa-arrow-circle-o-up')){
            var sizeType="up";
        }else{
            var sizeType="down";
        }
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
                case "size":
                    size=(Condition[1]!="不限")?Condition[1]:null;
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
                case "sizeType":
                    sizeType=Condition[1];
                    break;
                case "regTime":
                    regTime=Condition[1];

            }
        }
        window.location.href="http://www.sw2025.com/serve_video?serveName="+serveName+"&size="+size+"&job="+job+"&location="+location+"&idCard="+idCard+"&sizeType="+sizeType+"&regTime="+regTime;
    }

});