<?php
namespace App\controller;
use Service\Auth;
use Core\engine\Controller;
use Core\library\db\Db;
use Core\library\Response;
class Product extends Controller
{

    private $data = array();

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->load->bootstrap($registry);
    }


    public function index()
    {
        $pagesize = 20;
        $curpage = max($this->request->get('page'), 1);
        $title = $this->request->get('title');
        $where = array();
        if ($title) {
            $where['title'] = $title;
        }
        $offset = ($curpage - 1) * $pagesize;
        $list = Db::getInstance()->select("product",'*',$where,'order by id desc', "limit $offset,$pagesize");
        $count = Db::getInstance()->select("product",'*',$where,'', "",2);
        $this->data['list'] = $list;
        $this->data['count'] = $count;
        $this->data['pagination'] = $this->pagination->show($count, $pagesize);
        $this->data['userinfo'] = $this->userinfo;
        $this->data['title'] = $title;
        Response::getInstance()->view('product/index', $this->data);
    }

    public function add(){
        if($this->request->isPost()){
            $data = $this->request->post['data'];
            unset($data['id']);
            unset($data['submit']);
            //var_dump($data);exit;
            $rs = Db::getInstance()->insert('product',$data);
            if ($rs) {
                $msg = "操作成功 ! <-_-> ";
                $ref = $_SERVER['HTTP_REFERER'];
                $code = 200;
            } else {
                $msg = "操作失败";
                $ref = '';
                $code = -1;
            }
            $data = array('code'=>$code,'msg'=>$msg,'url'=>$ref);
            Response::getInstance()->ajax($data);
        }else{
            $this->data['userinfo'] = $this->userinfo;
            $this->data['action'] = 'add';

            Response::getInstance()->view('product/detail', $this->data);
        }
    }

    public function del(){
        $id = $this->request->get('id');
        if($id){
            $rs = Db::getInstance()->delete('product',array('id'=>$id));
            if ($rs) {
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

    public function edit(){
        if($this->request->isPost()){
            $data = $this->request->post;
            $id = $data['id'];
            unset($data['id']);
            unset($data['submit']);
            $rs = Db::getInstance()->update('product',$data,array('id'=>$id));
            if ($rs) {
                $msg = "操作成功 ! <-_-> ";
                $ref = $_SERVER['HTTP_REFERER'];
                $code = 200;
            } else {
                $msg = "操作失败";
                $ref = '';
                $code = -1;
            }
            $data = array('code'=>$code,'msg'=>$msg,'url'=>$ref);
            Response::getInstance()->ajax($data);
        }else{
            $id = $this->request->get('id');
            $this->data['userinfo'] = $this->userinfo;
            $this->data['info'] = Db::getInstance()->select("product",'*',array('id'=>$id),'', "",1);
            $this->data['action'] = 'edit';
            Response::getInstance()->view('product/detail', $this->data);
        }
    }
}