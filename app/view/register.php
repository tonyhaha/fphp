<!doctype html>
<html lang="en"><head>
    <meta charset="utf-8">
    <title><?php echo $config["project"];?>--注册</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="<?php echo HOST?>/static/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo HOST?>/static//font-awesome/css/font-awesome.css">

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
        <a class="" href="index.html"><span class="navbar-brand">     <span class="fa"> <img src="<?php echo HOST?>/static/logos.png" height="25"></span><?php echo $config["project"];?></span></a></div>

    <div class="navbar-collapse collapse" style="height: 1px;">

    </div>
</div>
</div>



<div class="dialog">
    <div class="panel panel-default">
        <p class="panel-heading no-collapse">注册</p>
        <div class="panel-body">
            <form action="<?php echo $config['default_php']?>/user/ajaxRegister" method="post" id="register-form">
                <div class="form-group">
                    <label>公司名</label>
                    <input type="text" class="form-control span12" name="company" id="company" >
                </div>
                <div class="form-group">
                    <label>用户名</label>
                    <input type="text" class="form-control span12" name="username" id="username" >
                </div>
                <div class="form-group">
                    <label>邮件</label>
                    <input type="text" class="form-control span12" name="email"  id="email" >
                </div>
                <div class="form-group">
                    <label>手机号</label>
                    <input type="text" class="form-control span12" name="phone" id="phone">
                </div>
                <div class="form-group">
                    <label>密码</label>
                    <input type="password"  id="password" class="form-control span12" name="password">
                </div>
                <div class="form-group">
                    <label>确认密码</label>
                    <input type="password"  id="confirm_password" class="form-control span12" name="confirm_password">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary pull-right" value="注册" name="submit" id="submit">
                    <!-- <label class="remember-me"><input type="checkbox"> I agree with the <a href="terms-and-conditions.html">Terms and Conditions</a></label>-->
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
    <p><a href="<?php echo $config['default_php']?>/user/login" style="font-size: 1.2em; margin-top: .25em;">登录</a></p>
</div>


<script src="<?php echo HOST?>/static/jQuery.validate/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo HOST?>/static/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo HOST?>/static/dialog/js/bootstrap-dialog.js" type="text/javascript"></script>
<script type="text/javascript">

    $(document).ready(function() {
        // 手机号码验证
        jQuery.validator.addMethod("isPhone", function(value, element) {
            var length = value.length;
            return this.optional(element) || (length == 11 && /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test(value));
        }, "请正确填写您的手机号码。");

        // 电话号码验证
        jQuery.validator.addMethod("isTel", function(value, element) {
            var tel = /^(\d{3,4}-)?\d{7,8}$/g; // 区号－3、4位 号码－7、8位
            return this.optional(element) || (tel.test(value));
        }, "请正确填写您的电话号码。");
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

        $("#register-form").validate({
            errorElement : 'span',
            errorClass : 'help-block',

            rules : {
                company : "required",
                username : "required",
                email : {
                    required : true,
                    email : true
                },
                password : {
                    required : true,
                    isPwd : true
                },
                confirm_password : {
                    required : true,
                    isPwd : true,
                    equalTo : "#password"
                },
                phone : {
                    required : true,
                    isPhone : true
                }
            },
            messages : {
                company : "请输入公司名",
                username : "请输入用户名",
                email : {
                    required : "请输入Email地址",
                    email : "请输入正确的email地址"
                },
                password : {
                    required : "请输入密码",
                    minlength : jQuery.format("密码不能小于{0}个字 符")
                },
                confirm_password : {
                    required : "请输入确认密码",
                    minlength : "确认密码不能小于5个字符",
                    equalTo : "两次输入密码不一致不一致"
                },
                phone : {
                    required : "请输入手机号码"
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
                register();
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

    function register(){
        var param = $("#register-form").serialize();
        var url = $("#register-form").attr("action");
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

    $("[rel=tooltip]").tooltip();
    $(function() {
        $('.demo-cancel-click').click(function(){return false;});
    });
</script>


</body></html>
