<?php
namespace App\controller;
use Core\engine\Controller;
use Core\library\db\Db;
use Service\Generation;
use Core\library\Response;
class Table extends Controller
{

    private $data = array();

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->bootstrap($registry);
    }


    public function create(){
        if($this->request->isPost()) {
            $table = $this->request->post['table'];
            $title = $this->request->post['title'];
            $name = $this->request->post['name'];
            $type = $this->request->post['type'];
            $length = $this->request->post['length'];
            $default = $this->request->post['default'];
            if($table && count($name) >0) {
                $field = '';
                foreach ($name as $key => $val) {
                    if ($val) {
                        $def = '';
                        if ($length[$key]) {
                            $len = (int)$length[$key];
                        }else{
                            $len = 100;
                        }
                        if ($default[$key]) {
                            $def = "DEFAULT $default[$key]";
                        }
                        if ($type[$key] == 'timestamp') {
                            $def = 'NOW()';
                        }
                        $field .= "$val $type[$key]($len) NOT NULL $def,";
                    }

                }
                $sql = "create table $table(
                   id INT NOT NULL AUTO_INCREMENT,
                    $field
                   PRIMARY KEY ( id )
                )";
                $rs = Db::getInstance()->exec($sql);
                if ($rs !== false) {
                    $generation = new Generation();
                    $generation->generate_controller($table,true);
                    $generation->generate_detailview($table,true);
                    $generation->generate_listview($table,true);
                    $this->setAuth($this->userinfo['id'],$table,$title);
                    $msg = "操作成功 ! <-_-> ";
                    $ref = $_SERVER['HTTP_REFERER'];
                    $code = 200;
                } else {
                    $msg = "操作失败";
                    $ref = '';
                    $code = -1;
                }
            }else {
                $msg = "操作失败";
                $ref = '';
                $code = -1;
            }
            $data = array('code'=>$code,'msg'=>$msg,'url'=>$ref);
            Response::getInstance()->ajax($data);
        }else{
            $this->data['userinfo'] = $this->userinfo;
            Response::getInstance()->view('createtable', $this->data);
        }

    }

    public function setAuth($uid,$table,$title){
        $rule_id = Db::getInstance()->insert('dp_auth_rule',array('name'=>$table.'/index','title'=>$title,'status'=>1,'rule'=>$table.'/*'));
        $group_id = Db::getInstance()->insert('dp_auth_group',array('title'=>$title,'status'=>1,'rules'=>$rule_id));
        $group_access_id = Db::getInstance()->insert('dp_auth_group_access',array('uid'=>$uid,'group_id'=>$group_id));
        $node_id = Db::getInstance()->insert('dp_node',array('title'=>$title,'type'=>2,'pid'=>0,'role'=>$rule_id,'status'=>1,'url'=>'','order'=>300));
        Db::getInstance()->insert('dp_node',
            array(
                'title'=>$title,
                'type'=>1,
                'pid'=>$node_id,
                'role'=>0,
                'status'=>1,
                'url'=>$table.'/index',
                'order'=>300
            )
        );

    }
}