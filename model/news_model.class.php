<?php
define("HOST","localhost");
define("USER","root");
define("PASS","15827398906");
define("DBNAME","newsdb");
define('DS', DIRECTORY_SEPARATOR);                 // 设置目录分隔符
define('LOG_PATH',dirname('/var/www/article.sssssdy.top/model').DS.'news1_log'.DS); // 日志文件目录
//此文件下LOG_PATH:/var/www/git/model/news_log/
require '/var/www/article.ssssdy.top/lib/log.class.php';
Log::set_size(1024*1024*10);
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
//            Log::write('数据库用户名或密码错误！','error');
            exit;
        }
        else{
            Log::write('Connection success!','log');
        }
        $this->conn = $config;
        $res = mysqli_select_db($config, $db_name);
        if (!$res) {
//            Log::write('请检查您的数据库名！','error');
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
        }else{
//            Log::write('您查找的信息不存在!','error');
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

    /**
     * @param $news_id
     * @return array|null
     */
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




