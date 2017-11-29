<?php echo $header;?>
<style>
    .help-block {
        margin-left: 18%;
    }
</style>


<div class="content">
    <div class="header">
        <h1 class="page-title">菜单添加</h1>
        <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">菜单添加</li>
        </ul>
    </div>
    <div class="main-content">

        <div class="row">
            <div class="col-sm-12 col-md-10">

                <form class="form-horizontal" role="form" method="post" action="<?php echo $config['default_php']?>/manage/menu_edit" id="reset-form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">父级</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="pid">
                               <option value="0">一级菜单</option>
                                <?php foreach ($nodes as $v): ?>
                                    <option value="<?php echo $v['nid'] ?>"
                                        <?php if($v['_level'] == 2): ?>disabled<?php endif; ?>
                                        <?php if($info['pid'] == $v['nid']): ?>selected='selected' <?php endif; ?>>
                                        <?php echo $v['_name'] ?>
                                    </option>
                                <?php endforeach ?>
                            </select>       
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">标题</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control span12" name="title" value="<?php echo $info['title'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">类型</label>
                        <!-- 默认为权限菜单 有选择项 -->
                        <div class="col-sm-10">
                           <label class="radio-inline">
                                <input type="radio" name="type" value="1" <?php if($info['type'] == 1): ?> checked <?php endif ?>> 权限菜单
                           </label>
                           <label class="radio-inline">
                                <input type="radio" name="type" value="2" <?php if($info['type'] == 2): ?> checked <?php endif ?>> 普通菜单
                           </label>    
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">选择关联的规则</label>
                        <!-- 规则列表-->
                        <div class="col-sm-10">
                            <?php if (!empty($list) && is_array($list)) { ?>
                               <select class="form-control" name="role">
                                   <option value="">请选择规则</option>
                                   <?php foreach ($list as $key => $value): ?>
                                       <option value="<?php echo $value['id'] ?>"
                                       <?php if($info['role'] == $value['id']): ?>selected='selected' <?php endif; ?>>
                                            <?php echo $value['title'] ?>
                                        </option>
                                   <?php endforeach ?>
                               </select>
                            <?php } ?>
                        </div>
                        <div class="help-block">如果~类型~是普通菜单，此表单默认即可</div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="hidden" value="<?php echo $nid ?>" name="nid">
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
                type : "required",
            },
            messages : {
                title : "请输入标题",
                type : "请输入类型",
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
                $(".btn-default").attr("disabled",'disabled');
                var param = $("#reset-form").serialize();
                var url = $("#reset-form").attr("action");
                $.ajax({
                    url : url,
                    type : "post",
                    dataType : "json",
                    data: param,
                    success : function(result) {
                        $(".btn-default").removeAttr("disabled");
                        var dialog = BootstrapDialog.show({
                            title:"温馨提示",
                            message: result.msg
                        });
                        setTimeout(function(){
                            dialog.close();
                            // if(result.url){
                                window.location.href = "/manage/menu";
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
