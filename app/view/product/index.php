<?php echo $header;?>

<div class="content">
    <div class="header">
        <h1 class="page-title">数据列表</h1>

    </div>

    <div class="main-content">
        <div class="row" >
            <div  style="padding:0px 0px 20px 20px;">
            <form class="form-inline">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">标题</div>
                        <input name="title" class="form-control span12" type="text" value="<?php echo $title;?>" style="width: 180px;">
                    </div>
                </div>
               <button type="submit" class="btn btn-primary" name="view_type" value="web">搜索</button>
                <a class="btn btn-primary" href="<?php echo $config['default_php']?>/product/add">添加数据</a><br><br>
            </form>
                </div>
        </div>
        <div class="row">
            <div class="col-sm-11 col-md-12">

                <div class="panel panel-default">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>标题</th>
                            <th >货号 </th>
                            <th >价格</th>
                            <th >条码 </th>
                            <th >操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list as $key=>$val){?>
                        <tr id="data_<?php echo $val["id"] ?>">

                            <td title="<?php echo $val["id"] ?>"><?php echo $val['id'];?></td>
                            <td title="<?php echo $val["title"] ?>"><?php echo $val['title'];?></td>

                            <td title="<?php echo $val["product_ns"] ?>"><?php echo $val['product_ns'];?></td>
                            <td title="<?php echo $val["price"] ?>"><?php echo $val['price'];?></td>
                            <td title="<?php echo $val["barcode"] ?>"><?php echo $val['barcode'];?></td>
                            <td>
                            <a  href="/product/edit?id=<?php echo $val["id"] ?>" class="edit"><span class="label label-default">修改</span></a>
                                <a href="javascript:;" url="/product/del?id=<?php echo $val["id"] ?>" class="delete"><span class="label label-danger">删除</span></a>
                            </td>
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
