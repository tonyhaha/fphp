<?php
namespace Core\engine;

class Router{


    public function __construct()
    {

    }

    public static function set(){

    }

    public static function get(){
        $request_uri = str_replace("index.php/","",trim((string)$_SERVER['REQUEST_URI']));
        $url  = explode("?",substr($request_uri,1,strlen($request_uri)));
        $route = !empty($url[0])?$url[0]:DEFAULT_ROUTE;
        return $route;

    }

}