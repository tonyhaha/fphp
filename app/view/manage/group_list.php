<?php echo $header;?>


<div class="content">
    <div class="header">
        <h1 class="page-title">模块列表</h1>
        <?php if($company){?>
        <ul class="breadcrumb">
            <h1 class="page-title">正在为《<?php echo $company;?>》管理模块</h1>
        </ul>
        <?php }?>
    </div>
    <a class="btn btn-primary" href="<?php echo $config['default_php']?>/manage/add_group">添加模块</a><br><br>
    <div class="main-content">
        <div class="row">
            <div class="col-sm-11 col-md-12">

                <div class="panel panel-default">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <?php if($uid){?>
                                <th><input type="checkbox" id="checkAll" value=""/></th>
                            <?php }?>
                            <th>标题</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list as $key=>$val){?>
                        <tr>
                            <?php if($uid){?>
                                <td><input type="checkbox" name="rulesId" value="<?php echo $val['id'];?>" <?php if(in_array($val['id'],$group_array)){?> checked <?php }?>/></td>
                            <?php }?>
                            <td><?php echo $val['title'];?></td>
                            <td>
                                <a class="btn btn-default" href="<?php echo $config['default_php']?>/manage/rule?group_id=<?php echo $val['id']?>" role="button">管理权限</a>
                                <a href="javascript:;" url="/manage/delGroup?gid=<?php echo $val["id"] ?>" class="btn btn-warning delete">删除模块</a>
                        </tr>
                        <?php }?>
                        </tbody>
                    </table>

                </div>
                <?php echo $pagination;?>
            </div>

        </div>

        <?php if($uid){?>
            <a class="btn btn-primary" id="add">确认添加</a>
        <?php }?>
    </div>
</div>
<script src="<?php echo HOST?>/static/jQuery.validate/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo HOST?>/static/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo HOST?>/static/dialog/js/bootstrap-dialog.js" type="text/javascript"></script>
<script>
    $(function () {
        $("#checkAll").click(function () {
            $("input[name='rulesId']:checkbox").prop("checked", this.checked);
        });
        $("#add").click(function(){
            var ids = '';
            $.each($('input:checkbox'),function(){
                if(this.checked){
                    if($(this).val()){
                        ids += $(this).val()+',';
                    }
                }
            });
            ids = ids.substring(0,ids.length-1);
            var param = {};
            var url = "<?php echo $config['default_php']?>/manage/add_group_access?uid=<?php echo (int)$uid;?>&group_id="+ids;
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
                        window.location.reload() ;

                        if(result.code == 200){
                            $("input[name='rulesId']:checkbox").prop("checked", false);
                        }
                    },1500);
                }
            });

        })
    });
    $('.delete').click(function(){
        var u = $(this).attr('url');
        var msg = '';
        $.ajax({url:u,
            type:'GET',
            dataType:'json',
            success:function(data){
                if(data.code == '200'){
                    msg = '删除成功'
                }else{
                    msg = '删除失败'
                }
                var dialog = BootstrapDialog.show({
                    title:"温馨提示",
                    message: msg
                });
                setTimeout(function(){
                    dialog.close();
                    if(data.url){
                        window.location.href = data.url;
                    }
                },2000);

            }});
    })
</script>
</body>
</html>
