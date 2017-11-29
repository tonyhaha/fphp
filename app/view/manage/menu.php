<?php echo $header;?>


<div class="content">
    <div class="header">
        <h1 class="page-title">菜单列表</h1>
        <ul class="breadcrumb">
            <li><a href="/">主菜单</a></li>
        </ul>
    </div>
    <a class="btn btn-primary" href="<?php echo $config['default_php']?>/manage/menu_add">添加菜单</a><br><br>
    <div class="main-content">
        <div class="row" style="padding-left: 20px">

                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>菜单名称</th>
                            <th>状态</th>
                            <th>类型</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php if(! empty($nodes) && is_array($nodes)): ?>
                            <?php foreach ($nodes as $k => $v): ?>
                                 <tr>
                                     <td><?php echo $v['nid'] ?></td>
                                     <td><?php echo $v['_name'] ?></td>
                                     <td>
                                        <?php if($v['status'] == 1): ?>
                                             显示
                                        <?php else: ?>
                                             隐藏
                                         <?php endif; ?>
                                     </td>
                                     <td>
                                         <?php if($v['type'] == 2): ?>
                                             普通菜单
                                          <?php else: ?>
                                             权限菜单
                                          <?php endif; ?>
                                     </td>
                                     <td style="text-align: left">
                                            <?php if($v['_level'] == 2): ?>
                                             &nbsp;
                                           <?php else: ?>
                                             &nbsp;<a href="<?php echo $config['default_php']?>/manage/menu_add?id=<?php echo $v['nid'] ?>" class="btn btn-info">添加子菜单</a> 
                                            <?php endif ?>
                                             <a href="<?php echo $config['default_php']?>/manage/menu_edit?id=<?php echo $v['nid'] ?>" class="btn btn-warning">修改</a> 
                                             <a href="javascript:delNode(<?php echo $v['nid'] ?>);" class="btn btn-danger">删除</a>
                                     </td>
                                 </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>


        </div>
    </div>
</div>
<script src="<?php echo HOST?>/static/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo HOST?>/static/dialog/js/bootstrap-dialog.js" type="text/javascript"></script>
<script>
    function delNode(nid) 
    {
        BootstrapDialog.show({
           title: '温馨提示',
           message: '确定要删除吗',
           buttons: [{
               label: '取消',
               action: function(dialog) {
                   dialog.close();
               }
           }, {
               label: '确定',
               action: function(dialog) {
                   var param = {};
                   var url = "<?php echo $config['default_php']?>/manage/menu_del?nid="+nid;
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
                               window.location.href = "/manage/menu";
                           },1500);
                       }
                   });
               }
           }]
       });
    }
   
</script>
</body>
</html>
