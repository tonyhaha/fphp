<?php echo $header;?>
<style>
    .help-block {
        margin-left: 18%;
    }
</style>


<div class="content">
    <div class="header">
        <h1 class="page-title">数据添加</h1>
    </div>
    <div class="main-content">

        <div class="row">
            <div class="col-sm-12 col-md-10">

                <form class="form-horizontal" role="form" method="post" action="<?php echo $config['default_php']?>/product/<?php echo $action;?>" id="reset-form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">标题</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control span12" name="data[title]" value="<?php echo $info['title'];?>">
                            <input type="hidden" class="form-control span12" name="data[id]" value="<?php echo $info['id'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">价格</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control span12" name="data[price]" value="<?php echo $info['price'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">型号</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control span12" name="data[product_ns]" value="<?php echo $info['product_ns'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">条形号</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control span12" name="data[barcode]" value="<?php echo $info['barcode'];?>">
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
                price : "required",
                product_ns : "required",
                barcode : "required",
            },
            messages : {
                title : "请输入标题",
                price : "请输入价格",
                product_ns : "请输入类型",
                barcode : "请输入类条形号",
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
                            window.location.href = "/product/index";


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
