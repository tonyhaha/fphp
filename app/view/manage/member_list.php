<?php echo $header;?>


<div class="content">
    <div class="header">
        <h1 class="page-title">人员列表</h1>
        <ul class="breadcrumb">
            <li><a href="/">主菜单</a></li>
        </ul>
    </div>
    <div class="main-content">

    </div>
    <div class="main-content">
        <div class="row">
            <div class="col-sm-11 col-md-12">

                <div class="panel panel-default">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>

                            <th>姓名</th>
                            <th>部门</th>
                            <th>权限组</th>
                            <th>手机</th>
                            <?php if($group_id){?>
                            <th>操作</th>
                            <?php }?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list as $key=>$val){?>
                        <tr>

                            <td><?php echo $val['username'];?></td>
                            <td><?php echo $val['department'];?></td>
                            <td><?php echo $val['title'];?></td>
                            <td><?php echo $val['phone'];?></td>
                            <?php if($group_id){?>
                            <td>
                                <?php if($group_id == $val['group_id']){?>
                                    <a class="btn btn-info" role="button">已在<?php echo $val['title'];?></a>
                                <?php }else{?>
                                <a class="btn btn-primary add" href="javascript:;" id="<?php echo $val['id'];?>" role="button">添加归组</a>
                                <?php }?>
                            </td>
                            <?php }?>
                        </tr>
                        <?php }?>
                        </tbody>
                    </table>

                </div>
                   <?php echo $pagination;?>
            </div>

        </div>


    </div>
</div>
<script src="<?php echo HOST?>/static/jQuery.validate/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo HOST?>/static/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo HOST?>/static/dialog/js/bootstrap-dialog.js" type="text/javascript"></script>
<script>
    $(function () {

        $(".add").click(function(){
            var ids = $(this).attr('id');
            var param = {};
            var url = "<?php echo $config['default_php']?>/manage/add_group_access?group_id=<?php echo (int)$group_id;?>&uid="+ids;
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
                        if(result.code == 200){
                            $("input[name='rulesId']:checkbox").prop("checked", false);
                        }
                    },1500);
                }
            });

        })
    });
</script>
</body>
</html>
