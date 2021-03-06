<?php echo $header;?>



<div class="content">
    <div class="header">
        <h1 class="page-title">权限组添加</h1>
        <!--<ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">权限组添加</li>
        </ul>-->
    </div>
    <div class="main-content">

        <div class="row">
            <div class="col-sm-12 col-md-10">

                <form class="form-horizontal" role="form" method="post" action="<?php echo $config['default_php']?>/manage/add_group" id="reset-form">

                    <div class="form-group">
                        <label class="col-sm-2 control-label">组名称</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control span12" name="title">
                            </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default" name="submit">提交</button>
                        </div>
                    </div>
                </form>



            </div>

        </div>

    </div>
</div>
<script src="<?php echo HOST?>/static/jQuery.validate/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo HOST?>/static/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo HOST?>/static/dialog/js/bootstrap-dialog.js" type="text/javascript"></script>
<script type="text/javascript">

    $(document).ready(function() {

        $("#reset-form").validate({
            errorElement : 'span',
            errorClass : 'help-block',
            rules : {
                title : "required",
            },
            messages : {
                title : "请输入标题",

            },
            errorPlacement : function(error, element) {
                element.next().remove();
                element.after('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>');
                element.closest('.form-group').append(error);
            },
            highlight : function(element) {
                $(element).closest('.form-group').addClass('has-error has-feedback');
            },
            success : function(label) {
                var el=label.closest('.form-group').find("input");
                el.next().remove();
                el.after('<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>');
                label.closest('.form-group').removeClass('has-error').addClass("has-feedback has-success");
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
                            if(result.url){
                                window.location.href = result.url;
                            }

                        },1500);
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
