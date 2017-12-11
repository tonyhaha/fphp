<?php
namespace App\controller;

use Core\engine\Controller;
use Service\Auth;
class Product extends Controller
{

    private $data = array();

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->bootstrap($registry);
        $this->auth = new Auth($registry);
        session_start();
    }


    public function info()
    {
        $pagesize = 20;
        $curpage = max($this->request->get('page'), 1);
        $title = $this->request->get('title');
        $where = 'where 1=1';
        if ($title) {
            $where = " and title = '$title'";
        }
        $offset = ($curpage - 1) * $pagesize;
        $rs = $this->mysql->query("select * from dp_product $where limit $offset,$pagesize");
        $count = $this->mysql->query("select count(*) as count from dp_product $where");
        $this->data['list'] = $rs->rows;
        $this->data['count'] = $count->row['count'];
        $this->data['pagination'] = $this->pagination->show($this->data['count'], $pagesize);
        $this->data['userinfo'] = $this->auth->getLoginInfo();
        $this->data['title'] = $title;
        $this->data['header'] = $this->load->view('common/header', $this->data);
        echo $this->load->view('index', $this->data);
    }
}