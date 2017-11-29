document.onkeydown = function (e) {
    var theEvent = window.event || e;
    var code = theEvent.keyCode || theEvent.which;
    if (code == 13) {
        $("#submit").click();
    }
}

$("body").delegate(".delete","click",function(){
    var url = $(this).attr('url');
    var param = {};
    var message = $(this).attr('message');
    $.ajax({
        url : url,
        type : "post",
        dataType : "json",
        data: param,
        success : function(result) {
            var dialog = BootstrapDialog.show({
                title:"温馨提示",
                message: message
            });
            setTimeout(function(){
                dialog.close();
                if(result.url){
                    window.location.href = result.url;
                }
            },1500);
        }
    });
})