<?php
require_once '/var/www/article.ssssdy.top/config/config.php';
//require_once CONFIG_PATH . 'config.php';
class Base_Model
{
    private $host_name = HOST;
    private $user_name = USER;
    private $password = PASS;
    private $db_name = DB_NAME;
    private $db_charset = DB_CHARSET;
    public $conn;

    function __construct()
    {
        $config = mysqli_connect($this->host_name, $this->user_name, $this->password);
        if (!$config) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $this->conn = $config;
        $res = mysqli_select_db($config, $this->db_name);
        if (!$res) {
            echo "Failed to connect to MySQL: " . mysqli_error($config);
            exit;
        }
        mysqli_set_charset($config, $this->db_charset);
    }

    function __destruct()
    {
        mysqli_close($this->conn);
    }

    function query($sql)
    {
        return mysqli_query($this->conn, $sql);
    }

    function fetch_one($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        $data = array();
        if (!empty($result)) {
            $data = mysqli_fetch_array($result);
        }
        return $data;
    }

    function fetch_all($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        $data = array();
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;                             //注意此处与fetch_one不同，为二位数组
            }
        }
        return $data;
    }

    function insert($array, $table)
    {
        $keys = join(',', array_keys($array));
        $values = "'" . join("','", array_values($array)) . "'";
        $sql = "insert into $table ({$keys}) VALUES ({$values})";
        $res = mysqli_query($this->conn, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function update_by_id($table, $arr, $id)
    {
        $key_and_value = array();
        foreach ($arr as $key => $value) {
            $value = mysqli_real_escape_string($this->conn, $value);
            $key_and_value[] = $key . "='" . $value . "'";        //合成类似：var = 'var1'var2='var3'这样的字符串
        }
        $key_and_values = join(',', $key_and_value);           //将字符串用','隔开,变成：var = 'var1',var2='var3'
        $sql = "update {$table} set {$key_and_values} where id={$id}";//修改操作 格式 update 表名 set 字段=值 where 条件
        mysqli_query($this->conn, $sql);
    }

    function num_of_rows($result)
    {
        return mysqli_num_rows($result);
    }
}
