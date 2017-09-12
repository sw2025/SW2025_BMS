function showimage(source)
{
   $(".mymodal").find(".img-show").html("<image src='"+source+"' class='modal-img' />");
   $(".mymodal").modal();
}
function showReason(e){
    $(".modal-reason").modal();
    $(".btn-primary").attr("id",e);
}
function showList(e){
   
}