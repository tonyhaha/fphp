<?php echo $header;?>


<div class="content">
    <div class="header">
        <h1 class="page-title">组列表</h1>
    </div>
    <a class="btn btn-primary" href="<?php echo $config['default_php']?>/manage/add_group">添加组</a><br><br>
    <div class="main-content">
        <div class="row">
            <div class="col-sm-11 col-md-12">

                <div class="panel panel-default">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>标题</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($list as $key=>$val){?>
                        <tr>
                            <td><?php echo $val['title'];?></td>
                            <td>
                                <a class="btn btn-default" href="<?php echo $config['default_php']?>/manage/rule?group_id=<?php echo $val['id']?>" role="button">添加权限</a>
                                <a class="btn btn-default" href="<?php echo $config['default_php']?>/manage/member?group_id=<?php echo $val['id']?>" role="button">添加人员</a> </td>
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
</body>
</html>
