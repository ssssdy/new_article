<?php
//define('DS', DIRECTORY_SEPARATOR);                 // 设置目录分隔符
//define('LOG_PATH', dirname('/var/www/article.ssssdy.top/lib') . DS . 'log' . DS); // 日志文件目录
//define('LOG_PATH',dirname('./model').DS.'log'.DS); // 日志文件目录
//require '/var/www/article.ssssdy.top/lib/log.class.php';
//require './lib/log.class.php';
//Log::set_size(1024 * 1024 * 10);
//include '../cache/base_cache.class.php';
require_once 'base_model.class.php';

class News_Model extends Base_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function insert_news($array, $table)
    {
        $redis = new Base_Cache();
        $redis->delete('news_list');
        return $this->insert($array, $table);
    }

    function update_news($table, $arr, $id)
    {
        $this->update_by_id($table, $arr, $id);
        $redis = new Base_Cache();
        $redis->delete('news_list');
        $redis->delete($id);
    }

    function get_one_news_info($news_id)
    {
        $news_info = $this->fetch_one("select * from news where id = $news_id");
        return $news_info;
    }

    function get_limit_news_info($start, $end)
    {
        $news_info = $this->fetch_all("select * from news limit $start,$end");
        return $news_info;
    }

    function get_all_news_info()
    {
        $news_info = $this->fetch_all("SELECT *FROM news");
        return $news_info;
    }

    function delete_by_news_id($id)
    {
        $sql = "DELETE FROM news where id=$id";
        $this->query($sql);
        $redis = new Base_Cache();
        $redis->delete('news_list');
        $redis->delete($id);
    }

}





