<!doctype html>
<html lang="en"><head>
    <meta charset="utf-8">
    <title><?php echo $config["project"];?>--登录</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">


    <link rel="stylesheet" type="text/css" href="<?php echo HOST?>/static/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo HOST?>/static/font-awesome/css/font-awesome.css">

    <script src="<?php echo HOST?>/static/jquery-1.11.1.min.js" type="text/javascript"></script>



    <link rel="stylesheet" type="text/css" href="<?php echo HOST?>/static/theme.css">
    <link rel="stylesheet" type="text/css" href="<?php echo HOST?>/static/premium.css">

</head>
<body class=" theme-blue">

<!-- Demo page code -->

<script type="text/javascript">
    $(function() {
        var match = document.cookie.match(new RegExp('color=([^;]+)'));
        if(match) var color = match[1];
        if(color) {
            $('body').removeClass(function (index, css) {
                return (css.match (/\btheme-\S+/g) || []).join(' ')
            })
            $('body').addClass('theme-' + color);
        }

        $('[data-popover="true"]').popover({html: true});

    });
</script>
<style type="text/css">
    #line-chart {
        height:300px;
        width:800px;
        margin: 0px auto;
        margin-top: 1em;
    }
    .navbar-default .navbar-brand, .navbar-default .navbar-brand:hover {
        color: #fff;
    }
</style>

<script type="text/javascript">
    $(function() {
        var uls = $('.sidebar-nav > ul > *').clone();
        uls.addClass('visible-xs');
        $('#main-menu').append(uls.clone());
    });
</script>

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="<?php echo HOST?>/static/html5.js"></script>
<![endif]-->


<!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
<!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
<!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
<!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->

<!--<![endif]-->

<div class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
        <a class="" href="index.html"><span class="navbar-brand"><?php echo $config["project"];?></span></a></div>

    <div class="navbar-collapse collapse" style="height: 1px;">

    </div>
</div>
</div>



<div class="dialog">
    <div class="panel panel-default">
        <p class="panel-heading no-collapse">登录</p>
        <div class="panel-body">
            <form action="<?php echo $config['default_php']?>/user/ajaxLogin" method="post" id="login-form">
                <div class="form-group">
                    <label>姓名</label>
                    <input type="text" name="username" class="form-control span12" id="username">
                </div>
                <div class="form-group">
                    <label>密码</label>
                    <input type="password" name="password" class="form-controlspan12 form-control" id="password">
                </div>
                <input type="submit" class="btn btn-primary pull-right" value="登录" name="submit" id="submit">
             <!--   <label class="remember-me"><input type="checkbox"> Remember me</label>-->
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>


<script src="<?php echo HOST?>/static/jQuery.validate/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo HOST?>/static/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo HOST?>/static/dialog/js/bootstrap-dialog.js" type="text/javascript"></script>
<script type="text/javascript">
    $("[rel=tooltip]").tooltip();
    $(function() {
        $('.demo-cancel-click').click(function(){return false;});
    });

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

        $("#login-form").validate({
            errorElement : 'span',
            errorClass : 'help-block',

            rules : {
                username : "required",
                password : {
                    required : true,
                    isPwd : true
                }
            },
            messages : {
                username : "请输入姓名",

                password : {
                    required : "请输入密码",
                    isPwd : jQuery.format("以字母开头，长度在6-12之间，必须包含数字和特殊字符。")
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
                login();
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
    function login(){
        var param = $("#login-form").serialize();
        var url = $("#login-form").attr("action");
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
</script>


</body></html>
