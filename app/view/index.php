


<?php echo $header;?>

<div class="content">
    <div class="header">
        <h1 class="page-title">列表</h1>

    </div>

    <div class="main-content">
        <div class="row" >
            <div  style="padding:0px 0px 20px 20px;">
            <form class="form-inline">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">名称</div>
                        <input name="name" class="form-control span12" type="text" value="<?php echo $name;?>" style="width: 180px;">
                    </div>
                </div>
               <button type="submit" class="btn btn-primary" name="view_type" value="web">搜索</button>
            </form>
                </div>
        </div>
        <div class="row">
            <div class="col-sm-11 col-md-12">

                <div class="panel panel-default">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>

<th><b>用户ID</b></th>
<th><b>名称</b></th>
                            <th><b>操作</b></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list as $key=>$val){?>
                        </tr>
                           <td><?php echo $val["id"] ?></td>
<td><?php echo $val["uid"] ?></td>
<td><?php echo $val["name"] ?></td>
<td>

 <a href="javascript:;" url="/table/del?name=<?php echo $val['name']?>" class="delete"><span class="label label-danger">删除</span></a>
</td>
                           <tr>
                        <?php }?>


                        </tbody>
                    </table>

                </div>
                <?php echo $pagination;?>
            </div>

        </div>


    </div>
</div>
<script src="<?php echo HOST?>/static/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo HOST?>/static/dialog/js/bootstrap-dialog.js" type="text/javascript"></script>
<script src="<?php echo HOST?>/static/layui/layui.js"></script>
<script>
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





