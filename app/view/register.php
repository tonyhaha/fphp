<!doctype html>
<html lang="en"><head>
    <meta charset="utf-8">
    <title><?php echo $config["project"];?></title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="<?php echo HOST?>/static/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo HOST?>/static//font-awesome/css/font-awesome.css">

    <script src="<?php echo HOST?>/static/jquery-1.11.1.min.js" type="text/javascript"></script>



    <link rel="stylesheet" type="text/css" href="<?php echo HOST?>/static/theme.css">
    <link rel="stylesheet" type="text/css" href="<?php echo HOST?>/static/premium.css">
    <link rel="stylesheet" type="text/css" href="<?php echo HOST?>/static/bootstrap-datetimepicker.min.css">
</head>
<body class=" theme-blue">
<style type="text/css">
    #feedback{
        height: 200px;
        text-align: center;
        height: 160px;
        border: 1px solid silver;
        border-radius: 3px;
    }
    #feedback img{
        margin:3px 10px;
        border: 1px solid silver;
        border-radius:3px;
        padding: 6px;
        width: 35%;
        height: 85%;
    }
    #feedback p{
        font-family: "微软雅黑";
        line-height: 120px;
        color: #ccc;
    }
    .file {
        position: relative;
        display: inline-block;
        border: 1px solid #1ab294;
        border-radius: 4px;
        padding: 8px 16px;
        overflow: hidden;
        color: #fff;
        text-decoration: none;
        text-indent: 0;
        line-height: 20px;
        color: #1ab294;
    }

    .file input {
        position: absolute;
        font-size: 100px;
        right: 0;
        top: 0;
        opacity: 0;
    }
    .box{
        margin-top: 10px;
        text-align: center;
    }
    .box a{
        margin-left: 10px;
    }
</style>
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
        <a class="" href="index.html"><span class="navbar-brand">    <?php echo $config["project"];?></span></a></div>

    <div class="navbar-collapse collapse" style="height: 1px;">

    </div>
</div>
</div>



<div class="dialog" style="max-width: 800px;">
    <div class="panel panel-default">
        <p class="panel-heading no-collapse">数据提交</p>
        <div class="panel-body">
            <form action="<?php echo $config['default_php']?>/user/ajaxRegister" method="post" id="register-form">
                <div class="form-group">
                    <label>电话号码</label>
                    <input type="text" class="form-control span12" name="phone" id="phone">
                </div>
                <div class="form-group form_datetime">
                    <label>激活日期</label>
                    <input type="text" class="form-control span12" name="activationdate" id="activationdate" >
                    <span class="add-on"><i class="icon-remove"></i></span>
                    <span class="add-on"><i class="icon-calendar"></i></span>
                </div>
                <div class="form-group">
                    <label>护照号码</label>
                    <input type="text" class="form-control span12" name="passport"  id="passport" >
                </div>

                <div class="form-group">
                    <label>国家</label>
                    <input type="text"  id="country" class="form-control span12" name="country">
                </div>
                <div class="form-group ">
                    <label>出生年月日</label>
                    <input type="text"  id="birthday" class="form-control span12 " name="birthday">
                    <span class="add-on"><i class="icon-remove"></i></span>
                    <span class="add-on"><i class="icon-calendar"></i></span>
                </div>
                <div class="form-group">
                    <label>姓拼音</label>
                    <input type="text"  id="user" class="form-control span12" name="user">
                </div>
                <div class="form-group">
                    <label>名拼音</label>
                    <input type="text"  id="name" class="form-control span12" name="name">
                </div>
                <div class="form-group">
                    <label>性别</label>
                        <label class="checkbox-inline">  男 <input type="radio"  id="sex" class="form-control" name="sex" value="男" checked></label>
                        <label class="checkbox-inline">   女 <input type="radio"  id="sex" class="form-control" name="sex" value="女"></label>
                </div>
                <div class="form-group">
                    <label>护照样本</label>
                    <div id="feedback">
                    </div>
                    <div class="box">
                        <a href="javascript:;" class="file">选择图片
                            <input type="file" multiple="multiple" id="inputfile" name="" class="photo">
                        </a>
                        <a href="javascript:;" class="file close">重新选择
                            <input type="buttom" class="photo">
                        </a>
                    </div>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary pull-right" value="提交" name="submit" id="submit">
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>


<script src="<?php echo HOST?>/static/jQuery.validate/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo HOST?>/static/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo HOST?>/static/dialog/js/bootstrap-dialog.js" type="text/javascript"></script>


<script src="<?php echo HOST?>/static/bootstrap-datetimepicker.min.js"></script>

<script src="<?php echo HOST?>/static/bootstrap-datetimepicker.zh-CN.js"></script>
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

                phone : "required",
                activationdate : "required",
                passport : "required",
                country : "required",
                user : "required",
                name : "required",

            },
            messages : {
                phone : "请输入手机号码",
                activationdate : "请输入激活日期",
                passport : "请输入手机号码",
                country : "请输入国家",
                user : "请输入姓拼音",
                name : "请输入名拼音",

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
<script type="text/javascript">
    $("#birthday,#activationdate").datetimepicker({
        language:  'zh-CN',
        autoclose: true,
        todayHighlight: true
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        //响应文件添加成功事件
        var feedback = $("#feedback");
        $("#inputfile").change(function(){
            if (feedback.children('img').length>1) {
                alert("最多只能选择两张图片");
                return false;
            }
            //创建FormData对象
            var data = new FormData();
            //为FormData对象添加数据
            $.each($('#inputfile')[0].files, function(i, file) {
                data.append('upload_file'+i, file);
            });
            $(".loading").show();    //显示加载图片
            //发送数据
            $.ajax({
                url:'/user/upload', /*去过那个php文件*/
                type:'POST',  /*提交方式*/
                data:data,
                cache: false,
                contentType: false,        /*不可缺*/
                processData: false,         /*不可缺*/
                success:function(data){
                    data = $(data).html();        /*转格式*/

                    //第一个feedback数据直接append，其他的用before第1个（ .eq(0).before() ）放至最前面。
                    //data.replace(/&lt;/g,'<').replace(/&gt;/g,'>') 转换html标签，否则图片无法显示。
                    if($("#feedback").children('img').length == 0)
                    {
                        $("#feedback").append(data.replace(/&lt;/g,'<').replace(/&gt;/g,'>'));
                    }
                    else{
                        $("#feedback").children('img').eq(0).before(data.replace(/&lt;/g,'<').replace(/&gt;/g,'>'));
                    }
                },
                error:function(){
                    alert('上传出错');
                }
            });
        });
        $(".close").on("click",function(){
            $("#feedback").empty();
        });
    });
</script>
</body></html>
