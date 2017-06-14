<?php
//define("HOST", "localhost");
//define("USER", "root");
//define("PASS", "15827398906");
//define("DB_NAME", "newsdb");
//define('DS', DIRECTORY_SEPARATOR);                 // 设置目录分隔符
//define('LOG_PATH', dirname('/var/www/article.ssssdy.top/lib') . DS . 'news1_log' . DS); // 日志文件目录
//define('LOG_PATH',dirname('./model').DS.'news1_log'.DS); // 日志文件目录
//require '/var/www/article.ssssdy.top/lib/log.class.php';
include "base_mysql_model.class.php";
//require './lib/log.class.php';
//Log::set_size(1024 * 1024 * 10);

class News_Model
{
    function get_one_news_info($news_id)
    {
        $db = new Base_Mysql_Model();
        $news_info = $db->fetch_one("select * from news where id = $news_id");
        return $news_info;
    }

    function get_limit_news_info($set1, $set2)
    {
        $db = new Base_Mysql_Model();
        $news_info = $db->fetch_all("select * from news limit $set1,$set2");
        return $news_info;
    }

    function get_all_news_info()
    {
        $db = new Base_Mysql_Model();
        $news_info = $db->fetch_all("SELECT *FROM news");
        return $news_info;
    }

    function  insert_news($array,$table){
        $db =new Base_Mysql_Model();
        return $db->insert($array,$table);
    }

    function update_news($table,$arr,$id){
        $db =new Base_Mysql_Model();
        $db->update_by_id($table,$arr,$id);
    }
//    function update_by_id($table, $arr, $id)
//    {
//        $db = new Base_Mysql_Model();
//        foreach ($arr as $key => $value) {
//            $value = mysqli_real_escape_string($db->conn, $value);
//            $keyAndvalueArr[] = $key . "='" . $value . "'";        //合成类似：var = 'var1'var2='var3'这样的字符串
//        }
//        $keyAndvalues = join(',', $keyAndvalueArr);           //将字符串用','隔开,变成：var = 'var1',var2='var3'
//        $sql = "update {$table} set {$keyAndvalues} where id={$id}";//修改操作 格式 update 表名 set 字段=值 where 条件
//        mysqli_query($db->conn, $sql);
//    }

    function delete_by_id($id)
    {
        $db = new Base_Mysql_Model();
        $sql = "DELETE FROM news where id=$id";
        mysqli_query($db->conn, $sql);
    }

}




