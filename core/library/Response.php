<?php
namespace Core\library;


class Response{

    private static $instance;

    function __construct(){


    }

    static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function json($data = array()){
        header('Content-type','application/json;charset=utf-8');
        $rst =  json_encode($data);
        $this->output($rst);
    }

    public function html($html){

        $this->output($html);
    }

    public function xml($xml){
        header("Content-type: text/xml");
        $this->output($xml);
    }

    public function download($file){
        $fileName = basename($file);
        header("Content-Type:application/octet-stream");
        header("Content-Disposition:attachment;filename=".$fileName);
        header("Accept-ranges:bytes");
        header("Accept-Length:".filesize($file));
        header("Expires: 0");
        header("Pragma: no-cache");
        $h = fopen($file, 'r');
        echo fread($h, filesize($file));
    }

    public function output($data){

        echo $data;

    }
    public function redirect($url, $status = 302) {
        header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url), true, $status);
        exit();
    }
}