<?php
namespace Module;

use Core\library\db\Db;
use Core\library\cache\Redis;
use Core\engine\Loader;

class Login {

    private $db ;

    public function __construct()
    {
        $this->db = new Db();
        $this->load = new Loader();
    }

    function user(){

    }

}