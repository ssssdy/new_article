<?php
//define('DS', DIRECTORY_SEPARATOR);                 // 设置目录分隔符
//define('LOG_PATH', dirname('/var/www/article.ssssdy.top/lib') . DS . 'log' . DS); // 日志文件目录
//define('LOG_PATH',dirname('./model').DS.'log'.DS); // 日志文件目录
//require '/var/www/article.ssssdy.top/lib/log.class.php';
//require './lib/log.class.php';
//Log::set_size(1024 * 1024 * 10);
class News_Model extends Base_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function insert_news($array, $table)
    {
        return $this->insert($array, $table);
    }

    function update_news($table, $arr, $id)
    {
        $this->update_by_id($table, $arr, $id);
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
        $news_info = $this->fetch_all("SELECT *FROM news");
        return $news_info;
    }

    function delete_by_id($id)
    {
        $sql = "DELETE FROM news where id=$id";
        mysqli_query($this->conn, $sql);
    }

}





