<?php

namespace Service;

use Core\engine\Service;


class Passport extends Service{

    public function __construct($registry)
    {
        parent::__construct($registry);

    }

    public function getUserInfo($username){
        $rs = $this->mysql->query("select * from dp_staff where username =:username limit 1",array('username'=>$username));
        return $rs->row;
    }

    public function addUser($data = array()){
        $this->mysql->prepare("insert into dp_staff(username,email,department,password,phone,addtime)values(:username,:email,:department,:password,:phone,:addtime)");
        $this->mysql->bindParam(':username',$data['username']);
        $this->mysql->bindParam(':email',$data['email']);
        $this->mysql->bindParam(':department',$data['department']);
        $this->mysql->bindParam(':password',$data['password']);
        $this->mysql->bindParam(':phone',$data['phone']);
        $this->mysql->bindParam(':addtime',date('Y-m-d H:i:s'));
        $this->mysql->execute();
        $rst = $this->mysql->getLastId();
        return $rst;
    }
    public function reset($data = array()){
        $this->mysql->prepare("UPDATE `dp_staff` SET `password` = :password WHERE `dp_staff`.`id` = :id");
        $this->mysql->bindParam(':id',$data['id']);
        $this->mysql->bindParam(':password',$data['password']);
        $rst = $this->mysql->execute();
        return $rst->num_rows;
    }
    
    /**
     * 根据用户名获取用户信息
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public function resetByUsername($data = array())
    {
        $this->mysql->prepare("UPDATE `dp_staff` SET `password` = :password WHERE `dp_staff`.`username` = :username");
        $this->mysql->bindParam(':username',$data['username']);
        $this->mysql->bindParam(':password',$data['password']);
        $rst = $this->mysql->execute();
        return $rst->num_rows;
    }

}