$('#sup_allow').on('click',function () {
    var supply_id=$(this).attr("index");
    $.post('{{url('changeSupply')}}',{'supply_id':supply_id,'config_id':2},function (data) {
        if (data.errorMsg == 'success') {
            window.location.href = "{{url('/cert_supply')}}";
        } else {
            alert("审核失败");
            window.location.href = "{{url('/cert_supply')}}";
        }
    },'json');
});


$(function () {
    $('.reject-reasons button').on('click',function () {
        var remark=$(".reject-reasons textarea").val();
        var supply_id=$(this).attr("id");
        $.post('{{url('changeSupply')}}',{'supply_id':supply_id,'remark':remark,'config_id':3},function (data) {
            if (data.errorMsg == 'success') {
                window.location.href = "{{url('/cert_supply')}}";
            } else {
                alert("审核失败");
                window.location.href = "{{url('/cert_supply')}}";
            }
        },'json');
    });
})