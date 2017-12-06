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
                        <div class="input-group-addon">手机号码</div>
                        <input name="phone" class="form-control span12" type="text" value="<?php echo $phone;?>" style="width: 180px;">
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
                            <th>时间</th>
                            <th>电话号码</th>
                            <th >激活日期</th>
                            <th >护照号码</th>
                            <th >国家</th>
                            <th >出生年月日</th>
                            <th >姓拼音</th>
                            <th >名拼音</th>
                            <th >性别</th>
                        <!--    <th width="7%">护照图</th>-->
                            <th >操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list as $key=>$val){?>
                        <tr id="data_<?php echo $val["id"] ?>">

                            <td title="<?php echo $val["addtime"] ?>"><?php echo $val['addtime'];?></td>
                            <td title="<?php echo $val["phone"] ?>"><?php echo $val['phone'];?></td>
                            <td title="<?php echo $val["activationdate"] ?>"><?php echo $val['activationdate'];?></td>
                            <td title="<?php echo $val["passport"] ?>"><?php echo $val['passport'];?></td>
                            <td title="<?php echo $val["country"] ?>"><?php echo $val['country'];?></td>
                            <td title="<?php echo $val["birthday"] ?>"><?php echo $val['birthday'];?></td>
                            <td title="<?php echo $val["name"] ?>"><?php echo $val['name'];?></td>
                            <td title="<?php echo $val["user"] ?>"><?php echo $val['user'];?></td>
                            <td title="<?php echo $val["sex"] ?>"><?php echo $val['sex'];?></td>
                  <!--          <td><a href="<?php /*echo $val['image'];*/?>" target="_blank"><img src="<?php /*echo $val['image'];*/?>" width="100"></a></td>-->
                            <td><a href="javascript:;" url="/user/del?id=<?php echo $val["id"] ?>" class="edit"><span class="label label-danger">删除</span></a></td>
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
    $('.edit').click(function(){
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
