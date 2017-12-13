<?php
namespace Core\library\db;

class Db{

    protected $pdo;
    protected $res;
    protected $config;

    private static $instance;

    function __construct(){

        $this->connect();
    }

    static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new Db();
        }
        return self::$instance;
    }



    public function connect(){
        try {
            $this->pdo = new \PDO('mysql:host=localhost;dbname=pp', 'root', '123456');
            // $this->pdo = new \PDO($config['dsn'], $config['username'], $config['password']);
            //$dbh = new PDO('oci:dbname=//192.168.4.12:1521/ORCL;charset=UTF8', $user, $pass);
            $this->pdo->query("set names utf8");
        }catch(\Exception $e){
            echo '数据库连接失败,详情: ' . $e->getMessage () . ' 请在配置文件中数据库连接信息';
            exit ();
        }
        //把结果序列化成stdClass
        //$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        //自己写代码捕获Exception
        //$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE,\PDO::FETCH_ASSOC);//属性名 属性值 数组以关联数组返回
    }

    /*数据库关闭*/
    public function close(){
        $this->pdo = null;
    }

    //用于有记录结果返回的操作，特别是SELECT操作
    public function query($sql,$return=false){
        $res = $this->pdo->query($sql);
        if($res){
            $this->res = $res; // 未返回 return $this->res;
        }
        if($return){
            return $res;
        }
    }

    //主要是针对没有结果集合返回的操作，比如INSERT、UPDATE、DELETE等操作
    public function exec($sql,$return=false){
        $res = $this->pdo->exec($sql);
        if($res){
            $this->res = $res;
        }
        if($return){//返回操作是否成功 成功返回1 失败0
            return $res;
        }
    }

    //绑定参数操作
    public function execute($sql, $params = array()){
        $smt = $this->pdo->prepare($sql);
        if($params){
            foreach ($params as $key => $value) {
                $smt->bindParam($key, $params[$key]);
            }
        }
        $rs = $smt->execute();
        if($rs){
            return $smt->fetchAll();
        }else{
            return false;
        }
    }

    //将$this->res以数组返回(全部返回)
    public function fetchAll(){
        return $this->res->fetchAll();
    }
    //将$this->res以数组返回(一条记录)
    public function fetch(){
        return $this->res->fetch();
    }
    //返回所有字段
    public function fetchColumn(){
        return $this->res->fetchColumn();
    }
    //返回最后插入的id
    public function lastInsertId(){
        return $this->res->lastInsertId();
    }


    public function select($table, $fields="*", $sqlwhere="", $orderby="",$limit="", $mode=0){
        //参数处理
        if(is_array($table)){
            $table = implode(', ', $table);
        }
        if(is_array($fields)){
            $fields = implode(',',$fields);

        }
        if(is_array($sqlwhere) && count($sqlwhere) > 0){
            $sqlwhere = 'where ' . $this->formatWheresData($sqlwhere);
        }else{
            $sqlwhere = '';
        }
        if($this->config['type']=='oracle'){
            if($limit){
                $limit = explode(',',$limit);
                $this->query("select * from (select rownum as rn,$fields from $table $sqlwhere $orderby) where rn > $limit[0] and rn <= $limit[1] ;");
            }else{
                $this->query("select $fields from $table $sqlwhere $orderby");
            }

            $return = $this->fetchAll();
            return $return;
        }
        if($mode === 2){ //统计
            $this->query("select count(*) from $table $sqlwhere");
            $return = $this->fetchColumn();
        }else if($mode === 1){ //返回一条
            $this->query("select $fields from $table $sqlwhere $orderby $limit");
            $return = $this->fetch();
        }else{
            $this->query("select $fields from $table $sqlwhere $orderby $limit");
            $return = $this->fetchAll();//如果 $this->res为空即sql语句错误 会提示Call to a member function fetchAll() on a non-object
        }
        return  $return;

    }


    public function insert($table, $set){
        if(is_array($table)){
            $table = implode(',', $table);
        }
        if(is_array($set)){
            $key = "(`".implode("`,`",array_keys($set))."`)";
            $val  = "('".implode("','",array_values($set))."')";
        }
       // echo "insert into $table $key VALUES $val";
        $this->query("insert into $table $key VALUES $val");
        $return = $this->pdo->lastInsertId();
        return $return;

    }

    public function update($table, $set, $sqlwhere=""){
        //参数处理
        if(is_array($table)){
            $table = implode(', ', $table);
        }
        if(is_array($set)){
            $s='';
            foreach($set as $k=>$v){
                $s .= $k."='".$v."',";
            }
            $set = substr($s,0,strlen($s)-1);
        }
        if(is_array($sqlwhere)){
            $sqlwhere = 'where ' . $this->formatWheresData($sqlwhere);
        }

        $this->exec("update $table set $set  $sqlwhere");
        $return = $this->res;
        return $return;

    }

    public function delete($table, $sqlwhere=""){
        //参数处理
        if(is_array($sqlwhere)){
            $sqlwhere = 'where ' . $this->formatWheresData($sqlwhere);
        }

        $this->exec("delete from $table $sqlwhere");
        $return = $this->res;
        return $return;

    }

    public function formatWheresData($wheres){
        unset($wheres['order']);
        $keys = array_keys($wheres);
        $return = array();
        for ($i=0;$i<count($keys);$i++){
            $return[] = ' `'.$keys[$i].'` = '.'\''.$wheres[$keys[$i]].'\' ';
        }
        return join(' AND ', $return);
    }
}

?>