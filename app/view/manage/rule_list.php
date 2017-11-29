<?php echo $header;?>


<div class="content">
    <div class="header">
        <h1 class="page-title">规则列表</h1>
        <ul class="breadcrumb">
            <li><a href="/">主菜单</a></li>
        </ul>
    </div>
    <a class="btn btn-primary"  href="<?php echo $config['default_php']?>/manage/add_rule">添加规则</a><br><br>
    <div class="main-content">
        <div class="row">
            <div class="col-sm-11 col-md-12">

                <div class="panel panel-default">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <?php if($group_id){?>
                            <th><input type="checkbox" id="checkAll" value=""/></th>
                            <?php }?>
                            <th>标题</th>
                            <th>名称</th>
                            <th>条件</th>
                            <th>操作</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list as $key=>$val){?>
                        <tr>
                            <?php if($group_id){?>
                            <td><input type="checkbox" name="rulesId" value="<?php echo $val['id'];?>" <?php if(in_array($val['id'],$rules)){?> checked <?php }?>/></td>
                            <?php }?>
                            <td><?php echo $val['title'];?></td>
                            <td><?php echo $val['name'];?></td>
                            <td><?php echo $val['condition'];?></td>
                            <td><a class="btn btn-warning delete" href="javascript:;" id="<?php echo $val['id'];?>" role="button">删除</a></td>
                        </tr>
                        <?php }?>
                        </tbody>
                    </table>

                </div>
                <?php if($group_id){?>
                <a class="btn btn-primary" id="add">确认添加</a>
                <?php }?>
            </div>

        </div>


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
            var group_id = "<?php echo !empty($group_id)?(int)$group_id:'';?>";
            if(!group_id){
                var dialog = BootstrapDialog.show({
                    title:"温馨提示",
                    message: '组ID为空不能提交'
                });
                return false;
            }
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
            var url = "<?php echo $config['default_php']?>/manage/add_group_rules?group_id="+group_id+"&rules="+ids;
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

        $(".delete").click(function(){
            var ids = $(this).attr('id');
            var param = {};
            var url = "<?php echo $config['default_php']?>/manage/del_rule?id="+ids;
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
        })
    });
</script>
</body>
</html>
