<?php

namespace Service;

use Core\engine\Service;
use Core\library\db\Db;
class Generation extends Service
{

    public function __construct($registry)
    {
        parent::__construct($registry);

    }

    function getTableInfo($table){
        $sql = "SHOW FULL COLUMNS FROM pp.$table";
        $data = Db::getInstance()->execute($sql);
        return $data;
    }

    function generate_controller($name = "", $write = false)
    {

        $controller_name = ucfirst($name);
        $controller = file('core/helpers/controller.src');
        $search = array('[[name]]','[[controller_name]]');
        $replace = array($name,$controller_name);
        if ($write) {
            $file = 'app/controller/' . $name . '.php';
            if (file_exists($file)) {
                return true;
            }
            $handle = fopen($file, 'w+');
        }
        foreach ($controller as $value) {
            $value = str_replace($search, $replace, $value);
            if ($write) {
                fwrite($handle, $value);
            } else {
                echo $value;
            }
        }
        if ($write) {
            fclose($handle);
            chmod('app/controller/' . $name . '.php', 0777);
        }
    }


    function generate_detailview($name = "", $write = false)
    {

        $columns =  $this->getTableInfo($name);
        foreach ($columns as $value) {
            $comment = $value['Comment'];
            $field = $value['Field'];
            if($field == 'id' || $field == 'addtime') continue;
            if($value['Field'] == 'status'){
                $fields[] = "      <div class=\"form-group\">
                        <label class=\"col-sm-2 control-label\">$comment</label>
                        <div class=\"col-sm-10\">
                           <label class=\"radio-inline\">
                                <input type=\"radio\" name=\"status\" value=\"1\" checked=\"\"> 正常
                           </label>
                           <label class=\"radio-inline\">
                                <input type=\"radio\" name=\"status\" value=\"2\"> 关闭
                           </label>
                        </div>
                    </div>";
            }elseif($value['Field'] == 'type'){
                $fields[] = "          <div class=\"form-group\">
                        <label class=\"col-sm-2 control-label\">$comment</label>
                        <div class=\"col-sm-10\">
                        <select class=\"form-control\" name=\"data[$field]\">
                            <option ><?php echo \$info['$field']?></option>
                        </select>
                        </div>
                    </div>";
            }else{
                $fields[] = "          <div class=\"form-group\">
                        <label class=\"col-sm-2 control-label\">$comment</label>
                        <div class=\"col-sm-10\">
                            <input type=\"text\" class=\"form-control span12\" name=\"data[$field]\" value=\"<?php echo \$info['$field']?>\">

                        </div>
                    </div>";
            }

            $rules[] = "$field : \"required\",";
            $messages[] = "   $field : \"请输入$comment\",";

        }

        $controller = file('core/helpers/details_view.src');
        $search = array('[[name]]', '[[primary_key]]', '[[fields]]', '[[rules]]', '[[messages]]');
        $replace = array($name, $columns[0]['Field'], implode("\n", $fields), implode("\n", $rules), implode("\n", $messages));
        if ($write) {
            if (!file_exists('app/view/' . $name . '/')) {
                mkdir('app/view/' . $name . '/');
            }

            $file = 'app/view/' . $name . '/detail.php';
            if (file_exists($file)) {
                return true;
            }
            $handle = fopen($file, 'w+');
        }
        foreach ($controller as $value) {
            $value = str_replace($search, $replace, $value);
            if ($write) {
                fwrite($handle, $value);
            } else {
                echo $value;
            }
        }
        if ($write) {
            fclose($handle);
            chmod('app/view/' . $name . '/ detail.php', 0777);
        }

    }


    function generate_listview($name = "", $write = false)
    {
        $columns =  $this->getTableInfo($name);
        //Create table header

        //Create grid
        foreach ($columns as $value) {
            $comment = $value['Comment'];
            $field = $value['Field'];
            $gridheader[] = "<th><b>" . $comment . "</b></th>";
            $gridrow[] = '<td><?php echo $val["' . $field . '"] ?></td>';
        }
        $gridheader[] = "<th><b>操作</b></th>";
        $gridrow[] = "<td>
<a  href=\"/$name/edit?id=<?php echo \$val['id']?> \" class=\"edit\"><span class=\"label label-default\">修改</span></a>

 <a href=\"javascript:;\" url=\"/$name/del?id=<?php echo \$val['id']?>\" class=\"delete\"><span class=\"label label-danger\">删除</span></a>
</td>";

        $controller = file('core/helpers/list_view.src');
        $search = array('[[name]]', '[[primary_key]]', '[[gridrow]]', '[[gridheader]]');
        $replace = array($name, $columns[0]['Field'], implode("\n", $gridrow), implode("\n", $gridheader));

        if ($write) {
            if (!file_exists('app/view/' . $name . '/')) {
                mkdir('app/view/' . $name . '/');
            }
            $file = 'app/view/' . $name . '/index.php';
            if (file_exists($file)) {
                return true;
            }
            $handle = fopen($file, 'w+');
        }
        foreach ($controller as $value) {
            $value = str_replace($search, $replace, $value);
            if ($write) {
                fwrite($handle, $value);
            } else {
                echo $value;
            }
        }

        if ($write) {
            fclose($handle);
            chmod('app/view/' . $name . '/index.php', 0777);
        }
    }
}