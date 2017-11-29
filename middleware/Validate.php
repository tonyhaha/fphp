<?php
namespace Middleware;

use Core\engine\Middleware;
use Core\engine\Router;
use Service\Auth;

class Validate extends Middleware{

    public function __construct($registry)
    {
        parent::__construct($registry);
        $registry->set('auth',new Auth($registry));
        $this->registry = $registry;
    }

    function handle(){
        $route = \Core\engine\Router::get();
        $userinfo = $this->auth->isLogin();
        //$adopt = $this->auth->validate('level',$userinfo['id']);
/*        $adopt = $this->auth->validate($route,$userinfo['id']);
        if(!$adopt){
            $msg = "Error: 没有权限";
            echo $msg;exit;
        }*/
        $this->registry->set('userinfo',$userinfo);
    }

    function terminate(){
        // echo 'complete'.PHP_EOL;
        //yield;
        // echo  "complete ok".PHP_EOL;
    }
}