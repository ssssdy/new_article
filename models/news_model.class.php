<?php
define("HOST","localhost");
define("USER","root");
define("PASS","15827398906");
define("DBNAME","newsdb");

class News_Model
{
    public $host_name;
    public $user_name;
    public $password;
    public $db_name;
    public $conn;

    function __construct($host_name = HOST, $user_name = USER, $password = PASS, $db_name = DBNAME, $charset = 'utf8')
    {
        $config = mysqli_connect($host_name, $user_name, $password);
        if (!$config) {
            echo '连接失败，请联系管理员';
            exit;
        }
        $this->conn = $config;
        $res = mysqli_select_db($config, $db_name);
        if (!$res) {
            echo '连接失败，请联系管理员';
            exit;
        }
        mysqli_set_charset($config, $charset);
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
            $data = mysqli_fetch_array($result);            //存储的为一维数组
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

    function get_one_news_info($news_id)
    {
        $news_info = $this->fetch_one("select * from news where id = $news_id");
        return $news_info;
    }

    function get_limit_news_info($set1, $set2)
    {
        $news_info = $this->fetch_all("select * from news limit $set1,$set2");
        return $news_info;
    }

    function get_all_news_info()
    {
        $news_info = $this->fetch_all("select *from news");
        return $news_info;
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

    function delete_by_id($id)
    {
        $sql = "DELETE FROM news where id=$id";
        mysqli_query($this->conn, $sql);
    }

}




