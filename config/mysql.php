<?php
/**
 * Created by PhpStorm.
 * User: zhangxiaobin
 * Date: 2017/6/15
 * Time: 17:40
 */

return array(
   "master" => array(
       'hostname'=>"127.0.0.1",
       "username"=>"root",
       "password"=>"123456",
       "database"=>"pp",
       "port"=>3306
   ),
    "slave" => array(
        'hostname'=>array('127.0.0.1'),
        "username"=>"root",
        "password"=>"123456",
        "database"=>"pp",
        "port"=>3306
    )

);