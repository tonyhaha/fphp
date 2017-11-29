<?php echo $header;?>



<div class="content">
    <div class="header">
        <h1 class="page-title">修改密码</h1>
        <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">修改密码</li>
        </ul>
    </div>
    <div class="main-content">

        <div class="row">
            <div class="col-sm-12 col-md-10">

                <form class="form-horizontal" role="form" method="post" action="<?php echo $config['default_php']?>/user/ajaxReset" id="reset-form">

                    <div class="form-group">
                        <label class="col-sm-2 control-label">密码</label>
                        <div class="col-sm-10">
                        <input type="password"  id="password" class="form-control span12" name="password">
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">确认密码</label>
                        <div class="col-sm-10">
                        <input type="password"  id="confirm_password" class="form-control span12" name="confirm_password">
                            </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default" name="submit" id="submit">提交</button>
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

        // 匹配密码，以字母开头，长度在6-12之间，必须包含数字和特殊字符。
        jQuery.validator.addMethod("isPwd", function(value, element) {
            var str = value;
            if (str.length < 6 || str.length > 18)
                return false;
            if (!/^[a-zA-Z]/.test(str))
                return false;
            if (!/[0-9]/.test(str))
                return false;
            return this.optional(element) || /[^A-Za-z0-9]/.test(str);
        }, "以字母开头，长度在6-12之间，必须包含数字和特殊字符。");

        $("#reset-form").validate({
            errorElement : 'span',
            errorClass : 'help-block',
            rules : {
                password : {
                    required : true,
                    isPwd : true
                },
                confirm_password : {
                    required : true,
                    isPwd : true,
                    equalTo : "#password"
                }
            },
            messages : {
                password : {
                    required : "请输入密码",
                    minlength : jQuery.format("密码不能小于{0}个字 符")
                },
                confirm_password : {
                    required : "请输入确认密码",
                    minlength : "确认密码不能小于5个字符",
                    equalTo : "两次输入密码不一致不一致"
                }

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
    document.onkeydown = function (e) {
        var theEvent = window.event || e;
        var code = theEvent.keyCode || theEvent.which;
        if (code == 13) {
            $("#submit").click();
        }
    }
    $("[rel=tooltip]").tooltip();
    $(function() {
        $('.demo-cancel-click').click(function(){return false;});
    });
</script>
</body>
</html>
