<?php
require_once '../static/dbconfig.php';

class News_Model
{
    public $hostname;
    public $username;
    public $password;
    public $dbname;
    public $conn;

    function __construct($hostname = HOST, $username = USER, $password = PASS, $dbname = DBNAME, $charset = 'utf8')
    {
        $config = mysqli_connect($hostname, $username, $password);
        if (!$config) {
            echo '连接失败，请联系管理员';
            exit;
        }
        $this->conn = $config;
        $res = mysqli_select_db($config, $dbname);
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

    function fetchOne($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        $data = array();
        if (!empty($result)) {
            $data = mysqli_fetch_array($result);            //存储的为一维数组
        }
        return $data;
    }

    function fetchAll($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        $data = array();
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;                             //注意此处与fetchOne不同，为二位数组
            }
        }
        return $data;
    }

    function get_OneNews_info($news_id)
    {
        $news_info = $this->fetchOne("select * from news where id = $news_id");
        return $news_info;
    }

    function get_LimitNews_info($set1, $set2)
    {
        $news_info = $this->fetchAll("select * from news limit $set1,$set2");
        return $news_info;
    }

    function get_AllNews_info()
    {
        $news_info = $this->fetchAll("select *from news");
        return $news_info;
    }

    function insert($array, $table)
    {
        $keys = join(',', array_keys($array));
        $values = "'" . join("','", array_values($array)) . "'";
        $sql = "insert into {$table}({$keys}) VALUES ({$values})";
        $res = mysqli_query($this->conn, $sql);
        if ($res) {
            echo "<h3>添加成功！</h3>";
            return true;
        } else {
            echo "<h3>添加失败！</h3>";
            return false;
        }
    }

    function update_ById($table, $arr, $id)
    {
        foreach ($arr as $key => $value) {
            $value = mysqli_real_escape_string($this->conn, $value);
            $keyAndvalueArr[] = $key . "='" . $value . "'";        //合成类似：var = 'var1'var2='var3'这样的字符串
        }
        $keyAndvalues = join(',', $keyAndvalueArr);           //将字符串用','隔开,变成：var = 'var1',var2='var3'
        $sql = "update {$table} set {$keyAndvalues} where id={$id}";//修改操作 格式 update 表名 set 字段=值 where 条件
        mysqli_query($this->conn, $sql);
    }

    function delete_ById($id)
    {
        $sql = "DELETE FROM news where id=$id";
        mysqli_query($this->conn, $sql);
    }


    //对mysql_query()、mysql_fetch_array()、mysql_num_rows()函数进行封装

    function myArray($result)
    {
        return mysqli_fetch_array($result);
    }

    function rows($result)
    {
        return mysqli_num_rows($result);
    }
}




