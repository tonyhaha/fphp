<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $config["project"];?></title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="/static/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo HOST?>/static/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="<?php echo HOST?>/static/theme.css">
    <link rel="stylesheet" type="text/css" href="<?php echo HOST?>/static/premium.css">
    <link rel="stylesheet" type="text/css" href="<?php echo HOST?>/static/dialog/css/bootstrap-dialog.css">
    <script src="<?php echo HOST?>/static/jquery-1.11.1.min.js" type="text/javascript"></script>
</head>
<body class=" theme-blue">

<!-- Demo page code -->

<style type="text/css">
    #line-chart {
        height: 300px;
        width: 800px;
        margin: 0px auto;
        margin-top: 1em;
    }
    .navbar-default .navbar-brand, .navbar-default .navbar-brand:hover {
        color: #fff;
    }
</style>

<script type="text/javascript">
    $(function () {
        var uls = $('.sidebar-nav > ul > *').clone();
        uls.addClass('visible-xs');
        $('#main-menu').append(uls.clone());
    });
</script>

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="<?php echo HOST?>/static/html5.js"></script>
<![endif]-->




<!--[if lt IE 7 ]>
<body class="ie ie6"> <![endif]-->
<!--[if IE 7 ]>
<body class="ie ie7 "> <![endif]-->
<!--[if IE 8 ]>
<body class="ie ie8 "> <![endif]-->
<!--[if IE 9 ]>
<body class="ie ie9 "> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->

<!--<![endif]-->

<div class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="" href="<?php echo $config['default_php']?>"><span class="navbar-brand">


                <?php echo $config["project"];?></span></a>
    </div>

    <div class="navbar-collapse collapse" style="height: 1px;">
        <ul id="main-menu" class="nav navbar-nav navbar-right">
            <li class="dropdown hidden-xs">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-user padding-right-small"
                          style="position:relative;top: 3px;"></span><?php echo $userinfo['username']?>
                    <i class="fa fa-caret-down"></i>
                </a>

                <ul class="dropdown-menu">
       <!--             <li><a href="./">My Account</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Admin Panel</li>
                    <li><a href="./">Users</a></li>
                    <li><a href="./">Security</a></li>
                    <li><a tabindex="-1" href="./">Payments</a></li>-->
                    <li><a tabindex="-1" href="<?php echo $config['default_php']?>/user/reset">修改密码</a></li>
                    <li><a tabindex="-1" href="<?php echo $config['default_php']?>/user/outlogin">退出登录</a></li>
                </ul>
            </li>
        </ul>

    </div>
</div>

<div class="sidebar-nav">
    <ul>
        <?php if(is_array($userinfo['menus']) && ! empty($userinfo['menus'])){ ?>
            <?php $i =0;foreach ($userinfo['menus'] as $k => $v){ $i++; ?>
                <li><a href="javascript:;" data-target=".dashboard-menu-<?php echo $k;?>" class="nav-header" data-toggle="collapse">
                    <i class="fa fa-fw <?php echo $config['tools'][$i];?>"></i> <?php echo $v['title'] ?> <i class="fa fa-collapse"></i></a>
                </li>
                <li>
                    <ul class="dashboard-menu-<?php echo $k;?> nav nav-list collapse in">
                        <?php if(! empty($v['_data'])): ?>
                            <?php foreach ($v['_data'] as $key => $value): ?>
                                <li><a href="<?php echo $config['default_php']?>/<?php echo $value['url'] ?>"><span class="fa fa-caret-right"></span> <?php echo $value['title'] ?></a></li>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </ul>
                </li>

            <?php } ?>
        <?php } ?>
    </ul>
</div>
