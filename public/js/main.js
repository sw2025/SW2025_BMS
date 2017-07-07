function showimage(source)
{
   $(".mymodal").find(".img-show").html("<image src='"+source+"' class='modal-img' />");
   $(".mymodal").modal();
}
function showReason(e){
    $(".modal-reason").modal();
    $(".btn-primary").attr("id",e);
}
$(document).ready(function(){
    $('.cert-state-btns a').on('click', function(event) {
        event.preventDefault();
        $(this).addClass('current').siblings().removeClass('current');
    });


    $('.demo-list').on('click', 'li', function(event) {
        event.preventDefault();
        $(this).parent().prev('.result-select').html($(this).children().html());
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
    $('.serve-member-sel').on('click','li', function(event) {
        event.preventDefault();
        var valHtml = $(this).children().html();
        if(valHtml != '请选择'){
            $('.results-unit-member').html(valHtml).show();
        }
    });

    $('.results-unit').on('click','a', function(event) {
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
});