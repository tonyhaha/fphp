<?php
namespace App\controller;

use Core\engine\Controller;
use Service\Passport;
use Core\library\mailer\Mailer;
use Core\library\db\Db;
use Service\Auth;

class User extends Controller{

    private $data = array();


    public function __construct($registry)
    {
        parent::__construct($registry);
        session_start();
        $this->load->bootstrap($registry);
        $this->auth = new Auth($registry);
        $registry->set('passport',new Passport($registry));
        $this->data['config'] = $this->config;
    }


    public function index(){
        redirect($this->data['config']['default_php'].'/user/register');
    }


    public function login(){
        $ret = isset($_SESSION['userinfo']);
        if($ret){
            redirect($this->data['config']['default']);
        }
        echo $this->load->view('login',$this->data);


    }

    public function info(){
        $ret = isset($_SESSION['userinfo']);
        if(!$ret){
            redirect($this->data['config']['default_php'].'/user/login');
        }
        $pagesize = 20;
        $curpage = max($this->request->get('page'),1);
        $phone = $this->request->get('phone');
        if($phone){
            $where = "where phone = '$phone'";
        }else{
            $where = '';
        }
        $offset = ($curpage-1)*$pagesize;
        $rs = $this->mysql->query("select * from dp_info $where limit $offset,$pagesize");
        $count = $this->mysql->query("select count(*) as count from dp_info $where");
        $this->data['list'] = $rs->rows;
        $this->data['count'] = $count->row['count'];
        $this->data['pagination'] = $this->pagination->show($this->data['count'],$pagesize);
        $this->data['userinfo'] = $this->auth->getLoginInfo();
        $this->data['phone'] = $phone;
        $this->data['header'] = $this->load->view('common/header',$this->data);
        echo $this->load->view('index',$this->data);
    }

    public function register(){

        $this->data['register'] = array();
        echo $this->load->view('register',$this->data);

    }
    public function ajaxLogin(){
        if ($this->request->isPost()) {
            $username = $this->request->post('username');
            $password = $this->request->post('password');
            if ($username && $password) {
                $ret = $this->passport->getUserInfo($username);
                $user_password = md5($password);
                if ($ret) {
                    $db_password = $ret['password'];
                    if ($user_password != $db_password) {
                        $msg = '密码不正确';
                        $ref = '';
                        $code = -1;
                    } else {
                        $_SESSION['userinfo'] = $ret;
                        $msg = '登录成功 <-_-> 正在为你转跳..';
                        $ref = '/user/info';
                        $code = 200;
                    }
                } else {
                    $msg = '你还没有注册';
                    $ref = $this->data['config']['default_php'] . '/user/register';
                    $code = -1;
                }
            } else {
                $msg = '用户名不能为空';
                $ref = '';
                $code = -1;
            }

        } else {
            $msg = "参数不正确";
            $ref = '';
            $code = -1;
        }

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            ajax(array('code' => $code, 'msg' => $msg, 'url' => $ref));
        }else{
            redirect($ref);
        }
    }

    public function ajaxRegister(){
        if($this->request->isPost()){
            $name = $this->request->post('name');
            $user = $this->request->post('user');
            $activationdate 	 = $this->request->post('activationdate');
            $passport  = $this->request->post('passport');
            $country  = $this->request->post('country');
            $birthday = $this->request->post('birthday');
            $sex   = $this->request->post('sex');
            $image   = $this->request->post('image');
            $phone = $this->request->post('phone');
            if($name && $image && $sex && $birthday && $phone && $country && $passport && $activationdate){
                $data['name'] = trim($name);
                $data['user'] = trim($user);
                $data['activationdate'] = $activationdate;
                $data['passport'] = $passport;
                $data['country'] = $country;
                $data['birthday'] = $birthday;
                $data['sex'] = $sex;
                $data['image'] = $image;
                $data['phone'] = $phone;
                $data['addtime'] = date('Y-m-d H:i:s');
                //$db = new Db();
                $rs = DB::getInstance()->insert('dp_info',$data);
                if($rs){
                    $msg = "提交成功 <-_-> 正在为你转跳..";
                    $ref = $this->data['config']['default_php'].'/user/register';
                    $code = 200;
                }else{
                    $msg = "提交失败";
                    $ref = $this->data['config']['default_php'].'/user/register';
                    $code = -1;
                }


            }else{
                $msg = "确实参数";
                $ref = '';
                $code = -1;
            }

        }else{
            $msg = "参数不正确";
            $ref = '';
            $code = -1;
        }
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            ajax(array('code' => $code, 'msg' => $msg, 'url' => $ref));
        }else{
            redirect($ref);
        }
    }

    public function ajaxReset(){
        $ret = $this->auth->islogin(true);
        $userid = $ret['id'];
        $password = $this->request->post('password');
        if($password){
            $data['id'] = $userid;
            $data['password'] = md5($password);
            $rs = $this->passport->reset($data);
            if($rs){
                $msg = "修改成功";
                $ref = $this->data['config']['default'];
                $code = 200;
            }else{
                $msg = "修改失败";
                $ref = '';
                $code = -1;
            }

        }else{
            $msg = "参数不正确";
            $ref = '';
            $code = -1;
        }
        ajax(array('code'=>$code,'msg'=>$msg,'url'=>$ref));
    }


    public function reset(){
        $ret = $this->auth->islogin();
        $this->data['userinfo'] = $ret;
        $this->data['header'] = $this->load->view('common/header',$this->data);
        echo $this->load->view('reset',$this->data);

    }


    public function isLogin($isajax = false){
        $userinfo = $_SESSION['userinfo'];
        if(!$userinfo['username']) {
            if($isajax){
                $msg = "请你登录后在来操作。";
                $ref = $this->data['config']['default_php'].'/user/login';
                $code = -1;
                ajax(array('code'=>$code,'msg'=>$msg,'url'=>$ref));
            }else{
                $msg = '你还没有登录';
                $ref = $this->data['config']['default_php'].'/user/login';
                redirect($ref);
            }

        }
        return $userinfo;
    }


    public function outlogin(){
        unset($_SESSION['userinfo']);
        redirect($this->data['config']['default_php'].'/user/login');
    }

    /**
     * 找回密码
     * @return [type] [description]
     */
    public function findPwd()
    {
        echo $this->load->view('find/findpassword',$this->data);
    }

    /**
     * 发送邮件
     * @return [type] [description]
     */
    public function sendEmail()
    {
        $email = trim($_POST['email']);
        //基本判断
        if (empty($email)) {
            ajax(array('code'=>-1,'msg'=>"邮箱不能为空 :-(",'url'=>''));
        }
        //判断邮箱是否合法
        if(! $this->isEmail($email)) {
            ajax(array('code'=>-1,'msg'=>"邮箱格式不正确",'url'=>''));
        }
        //判断邮箱是否存在
        $rs = $this->mysql->query("select * from dp_staff where email =:email limit 1",array('email'=>$email));
        if($rs->num_rows == 0) {
            ajax(array('code'=>-2,'msg'=>"此邮箱还未注册，请注册新用户",'url'=>$this->data['config']['default_php'].'/user/register'));
        }
        $pstr = $rs->row["username"]."++".$email."++".time();
        $notify = encode($pstr);
        $info = array(
            'username' => $rs->row["username"],
            'email'    => $email,
            'url'      => HOST.'/user/changePwd' . "?_status=".$notify
        );
        $is_success = $this->send($email,$info);
        if($is_success == true){
            ajax(array('code'=> 1,'msg'=>"邮件发送成功",'url'=>$this->data['config']['default_php'].'/user/success'));
        } else {
            ajax(array('code'=>-1,'msg'=>"邮件发送失败，请重试",'url'=>''));
        }
    }

    /**
     * 邮件成功的时候的success页面
     */
    public function success()
    {
        echo $this->load->view('find/success',$this->data);
    }

    /**
     * 修改密码
     * @return [type] [description]
     */
    public function changePwd()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pass = $_POST['password'];
            $repass = $_POST['repassword'];
            $username = $_POST['username'];
            if($pass !== $repass) {
                ajax(array('code'=>-1,'msg'=>"两次输入密码不一致,请重试",'url'=>''));
            }
            if(0 >= preg_match("/^[a-zA-Z](?=.*[\d]+)(?=.*[a-zA-Z]+)(?=.*[^a-zA-Z0-9]+).{5,11}$/",$pass))
            {
                ajax(array('code'=>-1,'msg'=>"以字母开头，长度在6-12之间，必须包含数字和特殊字符",'url'=>''));
            }
            if($pass){
                $data['username'] = $username;
                $data['password'] = md5($pass);
                if(empty($data['username'])) {
                    ajax(array('code'=>-1,'msg'=>"缺少参数，请联系管理员",'url'=>""));
                }
                $rs = $this->passport->resetByUsername($data);
                if($rs){
                    $msg = "修改成功";
                    $ref = $this->data['config']['default_php'].'/user/login';
                    $code = 1;
                }else{
                    $msg = "修改失败";
                    $ref = '';
                    $code = -1;
                }

            }else{
                $msg = "参数不正确";
                $ref = '';
                $code = -1;
            }
            ajax(array('code'=>$code,'msg'=>$msg,'url'=>$ref));
        } else {
              $uinfo = $this->request->get('_status');
              if(empty($uinfo))
              {
                echo "<h1>Notice:</h1><h2>Missing parameter contact administrator </h2>";exit;
              }
              list($username,$email,$time) = explode("++",decode($uinfo));
              if(($time+15*60) < time())
              {
                  echo "<h1>Notice:</h1><h2>Fifteen minutes have passed, the mail has expired, <br> please resend mail or contact administrator </h2>";exit;
              }
              else
              {
                 $this->data['userinfo'] = array('username'=>$username);
                 echo $this->load->view('find/resetpwd',$this->data);
              }
        }
    }

    /**
     * 通过PHPMailer发送邮件
     * @deepend PHPMailer
     * @param  [string] $email [description]
     * @param  [array] $data  [description]
     * @return [bool]        [description]
     */
    private function send($email,$data)
    {

        $mail = new Mailer();

        $mail->isSMTP();                                          // Set mailer to use SMTP
        $mail->Host = 'smtp.139.com';                             // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = 'test@139.com';                      // SMTP username
        $mail->Password = 'test';                            // SMTP password
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('test@139.com', 'test');
        $mail->addAddress($email);             // Add a recipient
        // $mail->addReplyTo('17186787852@163.com', '163');

        $mail->isHTML(true);                                      // Set email format to HTML

        $mail->Subject = $data['username'].' 您好，这是发送给您的密码重置邮件';
        $mail->Body    = $data['username'].'，你好，这是来自密码重置邮件。 点击下面的链接重置您的密码：<br>'.
           '<a href="'.$data['url'].'">'.$data['url'].'</a>，15分钟有效<br>'.
           '如果链接无法点击，请将链接粘贴到浏览器的地址栏中访问。<br><br><br>'.
           date("Y-m-d H:i:s");

        if(! $mail->send()) {
            return $mail->ErrorInfo;
        } else {
            return true;
        }
    }

    /**
     * 验证是否是合法的邮箱名
     * @param  [type]  $string [邮箱]
     * @return boolean         [false 邮箱格式不对]
     */
    private function isEmail($string) 
    {
        return 0 < preg_match("/^\w+(?:[-+.']\w+)*@\w+(?:[-.]\w+)*\.\w+(?:[-.]\w+)*$/", $string);
    }

    public function upload(){
        $dir_base = ROOT."/static/files/";     //文件上传根目录
        $host = HOST.'/static/files/';
        //没有成功上传文件，报错并退出。
        $output = "<textarea>";
        $index = 0;        //$_FILES 以文件name为数组下标，不适用foreach($_FILES as $index=>$file)
        foreach($_FILES as $file){
            $upload_file_name = 'upload_file' . $index;        //对应index.html FomData中的文件命名
            $filename = $_FILES[$upload_file_name]['name'];
            $gb_filename = iconv('utf-8','gb2312',$filename);    //名字转换成gb2312处理
            //文件不存在才上传
            if(!file_exists($dir_base.$gb_filename)) {
                $isMoved = false;  //默认上传失败
                $MAXIMUM_FILESIZE = 1 * 1024 * 1024;     //文件大小限制    1M = 1 * 1024 * 1024 B;
                $rEFileTypes = "/^\.(jpg|jpeg|gif|png){1}$/i";
                if ($_FILES[$upload_file_name]['size'] <= $MAXIMUM_FILESIZE &&
                    preg_match($rEFileTypes, strrchr($gb_filename, '.'))) {
                    $isMoved = @move_uploaded_file ( $_FILES[$upload_file_name]['tmp_name'], $dir_base.$gb_filename);        //上传文件
                }
            }else{
                $isMoved = true;    //已存在文件设置为上传成功
            }
            if($isMoved){
                //输出图片文件<img>标签
                //注：在一些系统src可能需要urlencode处理，发现图片无法显示，
                //请尝试 urlencode($gb_filename) 或 urlencode($filename)，不行请查看HTML中显示的src并酌情解决。
                $output .= "<img src='{$host}{$filename}' title='{$filename}' alt='{$filename}'/>";
                $output .= "<input name='image' type='hidden' value='{$host}{$filename}'>";
            }else {
                //上传失败则把error.jpg传回给前端
                $output .= "<img src='{$dir_base}error.jpg' title='{$filename}' alt='{$filename}'/>";
            }
            $index++;
        }
        echo $output."</textarea>";
    }

    public function member(){
        redirect('/manage/member');
    }

    public function department(){
        redirect('/manage/member');
    }
}