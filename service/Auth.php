<?php

namespace Service;

use Core\engine\Service;
use Core\library\Node;
use Core\library\Response;
use Core\library\db\Db;

class Auth extends Service{
    //默认配置
    protected $_config = array(
        'AUTH_ON' => true, //认证开关
        'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
    );

    public function __construct($registry) {
        parent::__construct($registry);
        session_start();

    }

    public function validate($name, $uid, $relation='or') {
        if (!$this->_config['AUTH_ON'])
            return true;
        $authList = $this->getAuthList($uid);
        if (is_string($name)) {
            if (strpos($name, ',') !== false) {
                $name = explode(',', $name);
            } else {
                $name = array($name);
            }
        }
        $list = array(); //有权限的name
        $des_name = explode('/',$name[0]);
        foreach ($authList as $val) {
            if(strpos($val,$des_name[0]) !== false && strpos($val,'*') !== false){
                $list[] = $val;
            }else{
                if (in_array($val, $name)){
                    $list[] = $val;
                }
            }
        }
        if ($relation=='or' and !empty($list)) {
            return true;
        }
        $diff = array_diff($name, $list);
        if ($relation=='and' and empty($diff)) {
            return true;
        }
        return false;
    }
    //获得用户组，外部也可以调用
    public function getGroups($uid) {
        static $groups = array();
        if (isset($groups[$uid])){
            return $groups[$uid];
        }
        $sql = "select * from dp_auth_group_access as a join dp_auth_group as g on a.group_id = g.id where a.uid = :uid and g.status = :status";
        $user_groups = Db::getInstance()->execute($sql,array('uid'=>$uid,'status'=>1));
        $groups[$uid] = $user_groups?$user_groups:array();
        return $groups[$uid];
    }
    //获得权限列表
    protected function getAuthList($uid) {
        static $_authList = array();
        if (isset($_authList[$uid])) {
            return $_authList[$uid];
        }
        if(isset($_SESSION['_AUTH_LIST_'.$uid])){
            return $_SESSION['_AUTH_LIST_'.$uid];
        }
        //读取用户所属用户组
        $groups = $this->getGroups($uid);
        $ids = array();
        foreach ($groups as $g) {
            $ids = array_merge($ids, explode(',', trim($g['rules'], ',')));
        }
        $ids = array_unique($ids);
        $ids = implode(',',$ids);
        if (empty($ids)) {
            $_authList[$uid] = array();
            return array();
        }
        $sql = "select * from dp_auth_rule where id in($ids) and status = 1";
        $rules = Db::getInstance()->execute($sql);
        //循环规则，判断结果。
        $authList = array();
        foreach ($rules as $r) {
            if (!empty($r['condition'])) {
                //条件验证
                $user = $this->getUserInfo($uid);
                $command = preg_replace('/\{(\w*?)\}/', '$user[\'\\1\']', $r['condition']);
               // @(eval('$condition=( '. $command .' );'));
                include_once(ROOT."/core/library/stringtophpstream.php");
                stream_register_wrapper("annotate", "Stringtophpstream");
                $condition = include ("annotate://{$command}");
                if ($condition) {
                    $authList[] = $r['rule'];
                }
            } else {
                //存在就通过
                $authList[] = $r['rule'];
            }
        }
        $_authList[$uid] = $authList;
        if($this->_config['AUTH_TYPE'] ==2 ){
            //session结果
            $_SESSION['_AUTH_LIST_'.$uid] = $authList;
        }
        return $authList;
    }


    public function getUserInfo($uid) {
        $userinfo = array();
        if(!isset($userinfo[$uid])){
            $sql = "select * from dp_staff where id = :uid";
            $rs = Db::getInstance()->execute($sql,array('uid'=>$uid));
            $userinfo[$uid] = $rs;
        }
        return $userinfo[$uid];
    }


    public function isLogin($isajax = false){
        $userinfo = $_SESSION['userinfo'];
        if(!$userinfo['username']) {
            if($isajax){
                $msg = "请你登录后在来操作。";
                $ref = $this->data['config']['default_php'].'/user/login';
                $code = -1;
                Response::getInstance()->ajax(array('code'=>$code,'msg'=>$msg,'url'=>$ref));
            }else{
                $ref = $this->data['config']['default_php'].'/user/login';
                Response::getInstance()->redirect($ref);
            }

        }
        $userinfo['menus'] = $this->getNodes($userinfo['id']);
        return $userinfo;
    }

    public function getLoginInfo(){
        $userinfo = $_SESSION['userinfo'];
        $userinfo['menus'] = $this->getNodes($userinfo['id']);
        return $userinfo;
    }

    public function getNodes($uid){
        $user_nodes = Db::getInstance()->execute("SELECT * FROM `dp_auth_group_access` as a left JOIN dp_auth_group as g on a.group_id = g.id WHERE uid = $uid");
        foreach($user_nodes as $v){
            $tmp[] =  $v['rules'];
        }
        $gid = implode(',',$tmp);
       if($gid){
           $rs = Db::getInstance()->execute("select A.* from dp_node as A left join dp_node as B on A.nid = B.pid where A.role in($gid) and A.status = 1 group by A.nid union select B.* from dp_node as A left join dp_node as B on A.nid = B.pid where A.role in($gid) and A.status = 1 group by B.nid");

           foreach ($rs as $k => $v) {
               if($v['role'] != 0) {
                   $route = Db::getInstance()->select("dp_auth_rule","*",array('id' =>$v['role']),'','',1);
                   $route = $route['name'];
                   if(!$route){
                       $route = $v['url'];
                   }
                   $rs[$k]['route']  = $route;
               } else {
                   $rs[$k]['route'] = '';
               }
           }
           $datya = Node::channelLevel($rs, 0,"&nbsp", "nid");
           return $datya;
       }

    }
}