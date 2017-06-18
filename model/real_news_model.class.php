<?php

class Real_News_Model extends Base_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function insert_real_time_news($array)
    {
        $insert_sql = "insert into real_news (id,content) VALUES (null,'{$array}')";
        $res = mysqli_query($this->conn, $insert_sql);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function get_real_time_news()
    {
        $real_news_info = parent::fetch_all("SELECT *FROM real_news");
        return $real_news_info;
    }

    function get_limit_real_news($set1, $set2)
    {
        $real_news_info = parent::fetch_all("select * from real_news limit $set1,$set2");
        return $real_news_info;
    }

    function get_one_real_news_($real_news_id)
    {
        $real_news_id = mysqli_real_escape_string($this->conn, $real_news_id);
        $news_info = parent::fetch_one("select content from real_news where id=$real_news_id");
        return $news_info;
    }
    function delete_real_news()
    {
        $delete_sql = "DELETE FROM real_news";
        mysqli_query($this->conn, $delete_sql);
    }
}