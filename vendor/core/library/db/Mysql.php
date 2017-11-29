<?php
namespace Core\library\db;
class Mysql {
    private $connection = null;
    private $statement = null;
    private $config;

    public function __construct($param=null) {
        if($param){
            $this->config = $param;
        }else{
            $param = include_once CONFIG.'/mysql.php';
            $this->config = $param;
        }

    }

    public function conn($type){
        $param = $this->config[$type];

        if($type == 'slave' && isset($param)){
            $param['hostname'] = $param['hostname'][rand(0,(count($param['hostname'])-1))];
        }
        try {
            $this->connection = new \PDO("mysql:host=" . $param['hostname'] . ";port=" . $param['port'] . ";dbname=" . $param['database'], $param['username'], $param['password'], array(\PDO::ATTR_PERSISTENT => true));
        } catch(\PDOException $e) {
            throw new \Exception('Failed to connect to database. Reason: \'' . $e->getMessage() . '\'');
        }

        $this->connection->exec("SET NAMES 'utf8'");
        $this->connection->exec("SET CHARACTER SET utf8");
        $this->connection->exec("SET CHARACTER_SET_CONNECTION=utf8");
        $this->connection->exec("SET SQL_MODE = ''");
    }

    public function prepare($sql) {
        $this->isMaster($sql);
        $this->statement = $this->connection->prepare($sql);
    }

    public function bindParam($parameter, $variable, $data_type = \PDO::PARAM_STR, $length = 0) {
        if ($length) {
            $this->statement->bindParam($parameter, $variable, $data_type, $length);
        } else {
            $this->statement->bindParam($parameter, $variable, $data_type);
        }
    }

    public function execute() {
        try {
            if ($this->statement && $this->statement->execute()) {
                $data = array();

                while ($row = $this->statement->fetch(\PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

                $result = new \stdClass();
                $result->row = (isset($data[0])) ? $data[0] : array();
                $result->rows = $data;
                $result->num_rows = $this->statement->rowCount();
                return $result;
            }
        } catch(\PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage() . ' Error Code : ' . $e->getCode());
        }
    }

    public function query($sql, $params = array()) {
        $this->isMaster($sql);
        $this->statement = $this->connection->prepare($sql);

        $result = false;

        try {
            if ($this->statement && $this->statement->execute($params)) {
                $data = array();

                while ($row = $this->statement->fetch(\PDO::FETCH_ASSOC)) {
                    $data[] = $row;
                }

                $result = new \stdClass();
                $result->row = (isset($data[0]) ? $data[0] : array());
                $result->rows = $data;
                $result->num_rows = $this->statement->rowCount();
            }
        } catch (\PDOException $e) {
            throw new \Exception('Error: ' . $e->getMessage() . ' Error Code : ' . $e->getCode() . ' <br />' . $sql);
        }

        if ($result) {
            return $result;
        } else {
            $result = new \stdClass();
            $result->row = array();
            $result->rows = array();
            $result->num_rows = 0;
            return $result;
        }
    }

    public function escape($value) {
        return str_replace(array("\\", "\0", "\n", "\r", "\x1a", "'", '"'), array("\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"'), $value);
    }

    public function countAffected() {
        if ($this->statement) {
            return $this->statement->rowCount();
        } else {
            return 0;
        }
    }

    public function getLastId() {
        return $this->connection->lastInsertId();
    }

    public function isConnected() {
        if ($this->connection) {
            return true;
        } else {
            return false;
        }
    }

    public function isMaster($sql){
        $querystr = trim($sql);
        $querystr = substr($querystr,0,6);
        if($querystr == 'select'){
            $db = 'slave';
        }else{
            $db = 'master';
        }
        $this->conn($db);
    }

    public function __destruct() {
        $this->connection = null;
    }

}
