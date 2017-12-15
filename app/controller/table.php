<?php
namespace App\controller;
use Core\engine\Controller;
use Core\library\db\Db;
use Service\Generation;
use Core\library\Response;
use Core\library\File;
class Table extends Controller
{

    private $data = array();
    private $table = 'dp_table';
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->bootstrap($registry);
    }
    public function index()
    {
        $pagesize = 20;
        $curpage = max($this->request->get('page'), 1);
        $name = $this->request->get('name');
        $where = array();
        if ($name) {
            $where['name'] = $name;
        }
        $offset = ($curpage - 1) * $pagesize;
        $list = Db::getInstance()->select($this->table,'*',$where,'order by id desc', "limit $offset,$pagesize");
        $count = Db::getInstance()->select($this->table,'*',$where,'', "",2);
        $this->data['list'] = $list;
        $this->data['count'] = $count;
        $this->data['pagination'] = $this->pagination->show($count, $pagesize);
        $this->data['userinfo'] = $this->userinfo;
        $this->data['name'] = $name;
        Response::getInstance()->view('/index', $this->data);
    }
    public function del(){
        $id = $this->request->get('name');
        if($id){
            $rs = Db::getInstance()->delete($this->table,array('name'=>$id));
            if ($rs) {
                $this->deleteAuth($this->userinfo['id'],$id);
                File::deleteDir(DIR_APP.'/view/'.$id);
                File::deleteFile(DIR_APP.'/controller/'.$id);
                $msg = "操作成功 ! <-_-> ";
                $ref = $_SERVER['HTTP_REFERER'];
                $code = 200;
            } else {
                $msg = "操作失败";
                $ref = '';
                $code = -1;
            }

        }else{
            $msg = "参数不对";
            $ref = '';
            $code = -1;
        }
        $data = array('code'=>$code,'msg'=>$msg,'url'=>$ref);
        Response::getInstance()->ajax($data);
    }
    public function create(){
        if($this->request->isPost()) {
            $table = $this->request->post['table'];
            $title = $this->request->post['title'];
            $name = $this->request->post['name'];
            $type = $this->request->post['type'];
            $length = $this->request->post['length'];
            $comment = $this->request->post['comment'];
            $default = $this->request->post['default'];
            if($table && $name[0] != '') {
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
                            $t = $type[$key];
                        }else{
                            $t = $type[$key].'('.$len.')';
                        }
                        $com = $comment[$key];
                        $field .= "`$val` $t $def COMMENT '$com',";
                    }

                }
                $sql = "create table $table(
                   id INT NOT NULL AUTO_INCREMENT COMMENT 'ID',
                    $field
                   PRIMARY KEY ( id )
                )";
                //echo $sql;exit;
                $rs = Db::getInstance()->exec($sql);
                if ($rs !== false) {
                    $generation = new Generation();
                    $generation->generate_controller($table,true);
                    $generation->generate_detailview($table,true);
                    $generation->generate_listview($table,true);
                    $this->setAuth($this->userinfo['id'],$table,$title);
                    Db::getInstance()->insert('dp_table',array('name'=>$table,'uid'=>$this->userinfo['id']));
                    $msg = "操作成功 ! <-_-> ";
                    $ref = $_SERVER['HTTP_REFERER'];
                    $code = 200;
                } else {
                    $msg = "操作失败";
                    $ref = '';
                    $code = -1;
                }
            }else {
                $msg = "字段不能为空";
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
        $rule_id = Db::getInstance()->insert('dp_auth_rule',array('name'=>$table,'title'=>$title,'status'=>1,'rule'=>$table.'/*'));
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

    public function deleteAuth($uid,$table){
       $rs = Db::getInstance()->select('dp_auth_rule','id',array('name'=>$table),'','',1);
        Db::getInstance()->delete('dp_auth_rule',array('name'=>$table));
        $auth_group_rs = Db::getInstance()->select('dp_auth_group','id',array('rules'=>$rs['id']),'','',1);
        Db::getInstance()->delete('dp_auth_group',array('rules'=>$rs['id']));
        Db::getInstance()->delete('dp_auth_group_access',array('uid'=>$uid,'group_id'=>$auth_group_rs['id']));
        $pid = Db::getInstance()->select('dp_node','nid',array('role'=>$rs['id']),'','',1);

        Db::getInstance()->delete('dp_node',array('nid'=>$pid['nid']));
        Db::getInstance()->delete('dp_node',array('pid'=>$pid['nid']));
        Db::getInstance()->delete('dp_table',array('name'=>$table,'uid'=>$this->userinfo['id']));
        Db::getInstance()->exec("DROP TABLE $table");
    }
}