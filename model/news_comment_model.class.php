<?php
require_once 'base_model.class.php';

class News_comment_Model extends Base_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function insert_comment($array, $table)
    {
        return $this->insert($array, $table);
    }

    function get_comment($news_id)
    {
        $sql = "select * from news_comment where news_id = $news_id";
        $data = $this->fetch_all($sql);
        return $data;
    }

    function del_comment_by_news_id($news_id)
    {
        $sql = "delete from news_comment WHERE news_id = $news_id";
        return $this->query($sql);
    }

    function del_comment_by_comment_id($comment_id)
    {
        $sql = "delete from news_comment WHERE id = $comment_id";
        return $this->query($sql);
    }

    function num_of_news_comment($news_id)
    {
        $sql = "select * from news_comment where news_id = $news_id";
        $rs = $this->query($sql);
        $num = $this->num_of_rows($rs);
        return $num;
    }
}