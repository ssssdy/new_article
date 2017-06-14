<?php
define("HOST", "localhost");
define("USER", "root");
define("PASS", "15827398906");
define("DB_NAME", "newsdb");
define("DB_CHARSET", "utf8");

class Base_Mysql_Model
{
    public $host_name = HOST;
    public $user_name = USER;
    public $password = PASS;
    public $db_name = DB_NAME;
    public $db_charset = DB_CHARSET;
    public $conn;

    function __construct()
    {
        $config = mysqli_connect($this->host_name, $this->user_name, $this->password);
        if (!$config) {
            echo "数据库连接失败!";
            exit;
        }
        $this->conn = $config;
        $res = mysqli_select_db($config, $this->db_name);
        if (!$res) {
            echo "数据库连接失败!";
            exit;
        }
        mysqli_set_charset($config, $this->db_charset);
    }

    function __destruct()
    {
        mysqli_close($this->conn);
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
        $sql = "insert into {$table}({$keys}) VALUES ({$values})";
        $res = mysqli_query($this->conn, $sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function update_by_id($table, $arr, $id)
    {
        foreach ($arr as $key => $value) {
            $value = mysqli_real_escape_string($this->conn, $value);
            $keyAndvalueArr[] = $key . "='" . $value . "'";        //合成类似：var = 'var1'var2='var3'这样的字符串
        }
        $keyAndvalues = join(',', $keyAndvalueArr);           //将字符串用','隔开,变成：var = 'var1',var2='var3'
        $sql = "update {$table} set {$keyAndvalues} where id={$id}";//修改操作 格式 update 表名 set 字段=值 where 条件
        mysqli_query($this->conn, $sql);
    }

    function delete($table, $where = null)
    {
        $where = $where == null ? '' : ' WHERE ' . $where;
        $sql = "DELETE FROM {$table}{$where}";
        $res = mysqli_query($this->conn,$sql);
        if ($res) {
            return mysqli_affected_rows($this->conn);
        } else {
            return false;
        }
    }
}