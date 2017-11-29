<?php echo $header;?>


<div class="content">
    <div class="header">
        <h1 class="page-title">列表</h1>
        <ul class="breadcrumb">
            <li><a href="/">主菜单</a></li>
        </ul>
    </div>
    <div class="main-content">

    </div>
    <div class="main-content">
        <div class="row" style="padding:0px 20px 20px 20px;">
            <form class="form-inline">
                <div class="form-group">

                    <div class="input-group">
                        <div class="input-group-addon">手机号码</div>

                        <input name="phone" class="form-control span12" type="text" value="<?php echo $phone;?>">

                    </div>
                </div>

                <button type="submit" class="btn btn-primary" name="view_type" value="web">搜索</button>

            </form>
        </div>
        <div class="row">
            <div class="col-sm-11 col-md-12">

                <div class="panel panel-default">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>时间</th>
                            <th>电话号码</th>
                            <th width="7%">激活日期</th>
                            <th width="7%">护照号码</th>
                            <th width="7%">国家</th>
                            <th width="7%">出生年月日</th>
                            <th width="7%">姓拼音</th>
                            <th width="7%">名拼音</th>
                            <th width="7%">性别</th>
                            <th width="7%">护照图</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list as $key=>$val){?>
                        <tr>

                            <td title="<?php echo $val["addtime"] ?>"><?php echo $val['addtime'];?></td>
                            <td title="<?php echo $val["phone"] ?>"><?php echo $val['phone'];?></td>
                            <td title="<?php echo $val["activationdate"] ?>"><?php echo $val['activationdate'];?></td>
                            <td title="<?php echo $val["passport"] ?>"><?php echo $val['passport'];?></td>
                            <td title="<?php echo $val["country"] ?>"><?php echo $val['country'];?></td>
                            <td title="<?php echo $val["birthday"] ?>"><?php echo $val['birthday'];?></td>
                            <td title="<?php echo $val["name"] ?>"><?php echo $val['name'];?></td>
                            <td title="<?php echo $val["user"] ?>"><?php echo $val['user'];?></td>
                            <td title="<?php echo $val["sex"] ?>"><?php echo $val['sex'];?></td>
                            <td><a href="<?php echo $val['image'];?>" target="_blank"><img src="<?php echo $val['image'];?>" width="100"></a></td>
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
<script>
    function editMsg() {
        var dialog = BootstrapDialog.show({
            title:"温馨提示",
            message: '只能本周 周一至周四修改'
        });
        setTimeout(function(){
            dialog.close();
        },2000);
        return false;
    }
</script>
</body>
</html>
