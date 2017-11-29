<!doctype html>
<html lang="en"><head>
    <meta charset="utf-8">
    <title><?php echo $config["project"];?>--重置密码</title>
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
        <a class="" href="index.html"><span class="navbar-brand"><span class="fa"> <img src="<?php echo HOST?>/static/logos.png" height="25"></span><?php echo $config["project"];?></span></a></div>

    <div class="navbar-collapse collapse" style="height: 1px;">

    </div>
</div>
</div>
<div class="dialog">
    <div class="panel panel-default">
        <p class="panel-heading no-collapse">重置密码</p>
        <div class="panel-body">
            <!-- <form action="<?php echo $config['default_php']?>/user/findPwd" method="post" id="login-form"> -->
            <?php $post_url = $config['default_php'] . "/user/changePwd"; ?>
            <form onsubmit="return hd_submit(this,'<?php echo $post_url ?>')" isPost=''>
                <div class="form-group">
                    <label>有户名</label>
                    <p><strong><?php echo $userinfo['username']; ?></strong></p>
                </div>
                <div class="form-group">
                    <label>新密码</label>
                    <input type="password" name="password" class="form-control span12" id="password">
                </div>
                <div class="form-group">
                    <label>重复新密码</label>
                    <input type="password" name="repassword" class="form-control span12" id="repassword">
                </div>
                <p class="bg-success">以字母开头，长度在6-12之间，必须包含数字和特殊字符</p>
                    <input type="hidden" name="username" value="<?php echo $userinfo['username'] ?>">
                <input type="submit" class="btn btn-primary pull-right" value="提交" name="submit">
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo HOST?>/static/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo HOST?>/static/dialog/js/bootstrap-dialog.js" type="text/javascript"></script>
<script>
function hd_submit(e, t) {
    return $(e).data("isPost") || ($(e).data("isPost", 1), $.ajax({
        url: t,
        data: $(e).serialize(),
        type: "POST",
        dataType: "json",
        success: function(res) {
            switch (res['code']) {
                case -1:
                    var dialog = BootstrapDialog.show({
                             title:"温馨提示",
                             message: res.msg
                         });
                         setTimeout(function(){
                             dialog.close();
                             window.location.reload();
                         },2000), $(e).removeData("isPost")
                    break;
                case -2:
                    var dialog = BootstrapDialog.show({
                             title:"温馨提示",
                             message: res.msg
                         });
                         setTimeout(function(){
                             dialog.close();
                             res.url && (window.location.href = res.url)
                         },2000), $(e).removeData("isPost")
                    break;
                case 1:
                    var dialog = BootstrapDialog.show({
                             title:"温馨提示",
                             message: res.msg
                         });
                         setTimeout(function(){
                             dialog.close();
                             res.url && (window.location.href = res.url)
                         },2000), $(e).removeData("isPost")
                    break;
            }

        }
    })), !1
}

</script>
</body>
</html>
