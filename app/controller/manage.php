<?php
namespace App\controller;

use Core\engine\Controller;
use Service\Auth;

class Manage extends Controller{

    private $data = array();

    private $auth;
    public function __construct($registry)
    {
        parent::__construct($registry);
        session_start();
        $this->load->bootstrap($registry);
        $this->auth = new Auth($registry);
        //$this->data['userinfo'] = $this->auth->isLogin();
        $this->data['userinfo'] = $this->auth->getLoginInfo();
        $this->data['config'] = $this->config;
    }

    //人员入组

    public function member(){
        $pagesize = 200;
        $curpage = max($this->request->get('page'),1);
        $group_id = $this->request->get('group_id');
        $offset = ($curpage-1)*$pagesize;
        $rs = $this->mysql->query("select * from dp_staff as s LEFT JOIN `dp_auth_group_access` as g on `s`.`id` = g.`uid` limit $offset,$pagesize");
        foreach($rs->rows as $key=>$val){
            if($val['group_id']){
                $gid = $val['group_id'];
                $group_sql = "select title from dp_auth_group where id = $gid";
                $rst = $this->mysql->query($group_sql);
                $rs->rows[$key]['title'] = $rst->row['title'];
            }else{
                $rs->rows[$key]['title'] = '无';
            }

        }
        $count = $this->mysql->query("select count(*) as count from dp_staff");
        $this->data['list'] = $rs->rows;
        $this->data['count'] = $count->row['count'];
        $this->data['group_id'] = $group_id;
        $this->data['pagination'] = $this->pagination->show($this->data['count'],$pagesize);
        $this->data['header'] = $this->load->view('common/header',$this->data);
        echo $this->load->view('manage/member_list',$this->data);
    }


    public function delMember(){

    }


    public function editMember(){

    }

    //权限组
    public function group(){
        $pagesize = 20;
        $curpage = max($this->request->get('page'),1);
        $offset = ($curpage-1)*$pagesize;
        $rs = $this->mysql->query("select * from dp_auth_group limit $offset,$pagesize");
        $count = $this->mysql->query("select count(*) as count from dp_auth_group");
        $this->data['list'] = $rs->rows;
        $this->data['count'] = $count->row['count'];
        $this->data['pagination'] = $this->pagination->show($this->data['count'],$pagesize);
        $this->data['header'] = $this->load->view('common/header',$this->data);
        echo $this->load->view('manage/group_list',$this->data);
    }

    public function add_group_rules(){
        $group_id = $this->request->get('group_id');
        $rules = $this->request->get('rules');
        if($rules && $group_id){
            $this->mysql->prepare("UPDATE `dp_auth_group` SET `rules` = :rules WHERE `id` = :id");
            $this->mysql->bindParam(':rules',$rules);
            $this->mysql->bindParam(':id',$group_id);
            $rst = $this->mysql->execute();
            if ($rst->num_rows) {
                $msg = "添加成功 ! <-_-> ";
                $ref = $_SERVER['HTTP_REFERER'];
                $code = 200;
            } else {
                $msg = "添加失败";
                $ref = '';
                $code = -1;
            }

        }else{
            $msg = "参数不对";
            $ref = '';
            $code = -1;
        }
        ajax(array('code'=>$code,'msg'=>$msg,'url'=>$ref));
    }

    public function add_group_access(){
        $uid = $this->request->get('uid');
        $group_id = $this->request->get('group_id');
        if($group_id && $uid){
            $this->mysql->prepare("replace into dp_auth_group_access(`uid`,`group_id`)values(:uid,:group_id)");
            $this->mysql->bindParam(':group_id',$group_id);
            $this->mysql->bindParam(':uid',$uid);
            $rst = $this->mysql->execute();
            if ($rst) {
                $msg = "添加成功 ! <-_-> ";
                $ref = '';
                $code = 200;
            } else {
                $msg = "添加失败";
                $ref = '';
                $code = -1;
            }

        } else {
            $msg = "参数失败";
            $ref = '';
            $code = -1;
        }
        ajax(array('code'=>$code,'msg'=>$msg,'url'=>$ref));
    }

    public function add_group(){

        $title = $this->request->post('title');
        if($title){
            $this->mysql->prepare("insert into dp_auth_group(`title`,`status`)values(:title,:status)");
            $this->mysql->bindParam(':title',$title);
          //  $this->mysql->bindParam(':condition',$rules);
            $this->mysql->bindParam(':status',1);
            $this->mysql->execute();
            $rst = $this->mysql->getLastId();
            if ($rst) {
                $msg = "添加成功 ! <-_-> ";
                $ref = '';
                $code = 200;
            } else {
                $msg = "添加失败";
                $ref = '';
                $code = -1;
            }
            ajax(array('code'=>$code,'msg'=>$msg,'url'=>$ref));
        }else{
            $this->data['header'] = $this->load->view('common/header', $this->data);
            echo $this->load->view('manage/group_add', $this->data);
        }
    }



    public function delGroup(){

    }

    //规则
    public function rule(){
        $pagesize = 200;
        $curpage = max($this->request->get('page'),1);
        $group_id = $this->request->get('group_id');
        $offset = ($curpage-1)*$pagesize;
        $rs = $this->mysql->query("select * from dp_auth_rule limit $offset,$pagesize");
        $count = $this->mysql->query("select count(*) as count from dp_auth_rule");
        if($group_id){
            $rules = $this->mysql->query("SELECT * FROM `dp_auth_group` where id = $group_id");
            $this->data['rules'] = explode(',',$rules->row['rules']);
        }
        $this->data['list'] = $rs->rows;
        $this->data['group_id'] =$group_id;
        $this->data['count'] = $count->row['count'];
        $this->data['pagination'] = $this->pagination->show($this->data['count'],$pagesize);
        $this->data['header'] = $this->load->view('common/header',$this->data);
        echo $this->load->view('manage/rule_list',$this->data);
    }

    public function del_rule(){
        $id = $this->request->get('id');
        if($id){
            $this->mysql->prepare("DELETE FROM `dp_auth_rule` WHERE `dp_auth_rule`.`id` = :id");
            $this->mysql->bindParam(':id',$id);
            $rst = $this->mysql->execute();
            if ($rst) {
                $msg = "删除成功 ! <-_-> ";
                $ref = $this->data['config']['default_php'].'/manage/rule';
                $code = 200;
            } else {
                $msg = "删除失败";
                $ref = '';
                $code = -1;
            }

        } else {
            $msg = "参数失败";
            $ref = '';
            $code = -1;
        }
        ajax(array('code'=>$code,'msg'=>$msg,'url'=>$ref));
    }


    public function add_rule(){

        if($this->request->isPost()){
            $name = $this->request->post('name');
            $title = $this->request->post('title');
            $condition = $this->request->post('condition');
            $this->mysql->prepare("insert into dp_auth_rule(`name`,`title`,`condition`,`status`)values(:name,:title,:condition,:status)");
            $this->mysql->bindParam(':name',$name);
            $this->mysql->bindParam(':title',$title);
            $this->mysql->bindParam(':condition',$condition);
            $this->mysql->bindParam(':status',1);
            $this->mysql->execute();
            $rst = $this->mysql->getLastId();
            if ($rst) {
                $msg = "添加成功 ! <-_-> ";
                $ref = '';
                $code = 200;
            } else {
                $msg = "添加失败";
                $ref = '';
                $code = -1;
            }
            ajax(array('code'=>$code,'msg'=>$msg,'url'=>$ref));
        }else{
            $this->data['header'] = $this->load->view('common/header', $this->data);
            echo $this->load->view('manage/rule_add', $this->data);
        }

    }

    //菜单
    public function menu(){
        $this->data['nodes'] = $this->_get_nodes();        
        $this->data['header'] = $this->load->view('common/header', $this->data);
        echo $this->load->view('manage/menu', $this->data);
    }

    public function menu_add(){
        if($this->request->isPost()){
            $pid = $this->request->post('pid');
            $title = $this->request->post('title');
            $type = $this->request->post('type');
            $role = $this->request->post('role');
            if($type == 2 && $role != 0) {
                ajax(array('code'=>-1,'msg'=>"一级菜单不必选择规则，请重新填写",'url'=>''));
            }
            if($pid == 0 && $type != 2) {
                ajax(array('code'=>-1,'msg'=>"一级菜单需选择 普通菜单，请重新填写",'url'=>''));
            }            
            $condition = $this->request->post('condition');
            $this->mysql->prepare("insert into dp_node(`pid`,`title`,`type`,`role`)values(:name,:title,:condition,:status)");
            $this->mysql->bindParam(':name',$pid);
            $this->mysql->bindParam(':title',$title);
            $this->mysql->bindParam(':condition',$type);
            $this->mysql->bindParam(':status',$role);
            $this->mysql->execute();
            $rst = $this->mysql->getLastId();
            if ($rst) {
                $msg = "添加成功 ! <-_-> ";
                $ref = '';
                $code = 200;
            } else {
                $msg = "添加失败";
                $ref = '';
                $code = -1;
            }
            ajax(array('code'=>$code,'msg'=>$msg,'url'=>$ref));
        }else{
            $this->data['nodes'] = $this->_get_nodes();  
            $rs = $this->mysql->query("select * from dp_auth_rule");
            $this->data['list'] = $rs->rows;
            $this->data['nid'] = intval($this->request->get('id')); //默认为一级菜单
            $this->data['header'] = $this->load->view('common/header', $this->data);
            echo $this->load->view('manage/menu_add', $this->data);
        }
    }

    /**
     * 菜单编辑
     * @return [type] [description]
     */
    public function menu_edit() 
    {
        if($this->request->isPost()){ 
            // echo "<pre>";print_r($_POST);exit();
            $data = $_POST;
            $this->mysql->prepare("UPDATE `dp_node` SET `pid` = :pid,`title` = :title,`type` = :type,`role` = :role WHERE `dp_node`.`nid` = :nid");
            $this->mysql->bindParam(':nid',$data['nid']);
            $this->mysql->bindParam(':pid',$data['pid']);
            $this->mysql->bindParam(':title',$data['title']);
            $this->mysql->bindParam(':type',$data['type']);
            $this->mysql->bindParam(':role',$data['role']);
            $rst = $this->mysql->execute();
            if($rst->num_rows == 1) {
                $msg = "修改成功 ! <-_-> ";
                $ref = '';
                $code = 200;
            } else {
                $msg = "修改失败";
                $ref = '';
                $code = -1;
            }
            ajax(array('code'=>$code,'msg'=>$msg,'url'=>$ref));
        }else{
            $this->data['nodes'] = $this->_get_nodes();  
            $rs = $this->mysql->query("select * from dp_auth_rule");
            $this->data['list'] = $rs->rows;
            $this->data['nid'] = intval($this->request->get('id')); //默认为一级菜单
            $this->data['info'] = $this->mysql->query("SELECT * FROM dp_node WHERE nid = " . $this->data['nid'])->row;
            $this->data['header'] = $this->load->view('common/header', $this->data);
            echo $this->load->view('manage/menu_edit', $this->data);
        }
    }
    public function menu_del(){
        $nid = $this->request->get('nid');
        if($nid){
            $_inf = $this->mysql->query("SELECT * FROM dp_node WHERE pid = " . $nid)->rows;
            if(! empty($_inf)) {
                ajax(array('code'=>-1,'msg'=>"此菜单下有子菜单，删除子菜单后才能删除",'url'=>''));
            }
            $this->mysql->prepare("DELETE FROM `dp_node` WHERE `dp_node`.`nid` = :nid");
            $this->mysql->bindParam(':nid',$nid);
            $rst = $this->mysql->execute();
            if ($rst) {
                $msg = "删除成功 ! <-_-> ";
                $ref = '';
                $code = 200;
            } else {
                $msg = "删除失败";
                $ref = '';
                $code = -1;
            }

        } else {
            $msg = "参数失败";
            $ref = '';
            $code = -1;
        }
        ajax(array('code'=>$code,'msg'=>$msg,'url'=>$ref));
    }

    private function _get_nodes() {
        $rs = $this->mysql->query("select * from dp_node where status = 1");
        $datya = \Core\library\Node::tree($rs->rows, "title", "nid", "pid");
        return $datya;
    }
}