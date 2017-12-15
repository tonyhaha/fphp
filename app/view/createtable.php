<?php echo $header;?>

<div class="content">
    <div class="header">
        <h1 class="page-title">创建数据表</h1>

    </div>

    <div class="main-content">
        <div class="row" >
            <div  style="padding:0px 0px 20px 20px;">

            <form class="form-inline" method="post" action="/table/create" id="reset-form">

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">数据标题</div>
                        <input name="title" class="form-control span12" type="text" value="" style="width: 150px;">
                        </div>
                    <br>
                    <div class="input-group">
                        <div class="input-group-addon">数据表名</div>
                        <input name="table" class="form-control span12" type="text" value="" style="width: 150px;">

                    </div>
                    <br>
                    <div id="line">
                    <div class="input-group">
                        <div class="input-group-addon">字段名</div>
                        <input name="name[]" class="form-control span12" type="text" value="" style="width: 150px;">
                        <div class="input-group-addon">字段标题</div>
                        <input name="comment[]" class="form-control span12" type="text" value="" style="width: 150px;">
                        <div class="input-group-addon">数据类型</div>
                        <select class="form-control" name="type[]" style="width: 150px;">
                                <option value="varchar">文本</option>
                                <option value="int">数字</option>
                                <option value="timestamp">时间</option>
                        </select>
                        <div class="input-group-addon">长度</div>
                        <input name="length[]" class="form-control span12" type="text" value="" style="width: 150px;">
                        <div class="input-group-addon">默认值</div>
                        <input name="default[]" class="form-control span12" type="text" value="" style="width: 150px;">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"  data-id="1"></span></div>

                    </div>
                        <br>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary" name="submit" value="web">提交</button>
                <a class="btn btn-primary" href="#" id="addline">添加一行</a>
                <br>
            </form>

                </div>
        </div>


    </div>
</div>
<script src="<?php echo HOST?>/static/jQuery.validate/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo HOST?>/static/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo HOST?>/static/dialog/js/bootstrap-dialog.js" type="text/javascript"></script>
<script>
    var i = 1;
    $('#addline').click(function(){
        i++;
        var html = $("#line").clone(true).attr('id', 'line'+i);
        html.find('span').attr('data-id',i);
        $(".form-group").append(html);
    });
    $('.input-group').delegate('span','click',function(){
        var id = $(this).attr('data-id');
        if(id == 1){
            var dialog = BootstrapDialog.show({
                title:"温馨提示",
                message: "第一个是不能删除的"
            });
            setTimeout(function(){
                dialog.close();
            },2000);
        }else{
            $('#line'+id).remove();
        }
    });
    $(document).ready(function() {
        $("#reset-form").validate({
            errorElement : 'span',
            errorClass : 'help-block',
            rules : {
                title : "required",
                table : "required",


            },
            messages : {
                title : "请输入数据标题",
                table : "请输入表名",
            },
            errorPlacement : function(error, element) {
                element.next().remove();
                //element.after('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>');
                element.closest('.form-group').append(error);
            },
            highlight : function(element) {
                $(element).closest('.form-group').addClass('has-error has-feedback');
            },
            success : function(label) {
                var el=label.closest(this).find("input");
                el.next().remove();
                el.append('<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>');
                label.closest(label).removeClass('has-error').addClass("has-feedback has-success");
                label.remove();
            },
            submitHandler: function(form) {
                //form.submit();
                var param = $("#reset-form").serialize();
                var url = $("#reset-form").attr("action");
                $.ajax({
                    url : url,
                    type : "post",
                    dataType : "json",
                    data: param,
                    success : function(result) {
                        var dialog = BootstrapDialog.show({
                            title:"温馨提示",
                            message: result.msg
                        });
                        setTimeout(function(){
                            dialog.close();
                            // if(result.url){
                            //window.location.href = "/manage/menu";
                            // }

                        },2000);
                    }
                });
            }

        })
    });

    $("[rel=tooltip]").tooltip();
    $(function() {
        $('.demo-cancel-click').click(function(){return false;});
    });
</script>
</body>
</html>
