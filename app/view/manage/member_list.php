<?php echo $header;?>


<div class="content">
    <div class="header">
        <h1 class="page-title">人员列表</h1>
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
                            <th>公司</th>
                            <th>用户名</th>
                            <th>模块</th>
                            <th>手机</th>
                            <th>操作</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list as $key=>$val){?>
                        <tr>

                            <td><?php echo $val['company'];?></td>
                            <td><?php echo $val['username'];?></td>
                            <td><?php echo $val['title'];?></td>
                            <td><?php echo $val['phone'];?></td>

                            <td>


                                <a class="btn btn-default" href="<?php echo $config['default_php']?>/manage/group?uid=<?php echo $val['id']?>" role="button">管理模块</a>
                            </td>

<?php }?>
                        </tr>
                        </tbody>
                    </table>

                </div>
                   <?php echo $pagination;?>
            </div>

        </div>
        <?php if($group_id){?>
            <a class="btn btn-primary" id="add">确认添加</a>
        <?php }?>

    </div>
</div>
<script src="<?php echo HOST?>/static/jQuery.validate/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo HOST?>/static/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo HOST?>/static/dialog/js/bootstrap-dialog.js" type="text/javascript"></script>

</body>
</html>
