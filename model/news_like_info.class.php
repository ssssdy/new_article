<?php
require_once 'base_model.class.php';

class News_Like_Model extends Base_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function insert_news_like_info($array, $table)
    {
        return $this->insert($array, $table);
    }

    function num_of_news_like($news_id)
    {
        $sql = "select * from news_like_info where news_id = $news_id";
        $num = $this->num_of_rows($this->query($sql));
        return $num;
    }

    function check_news_like($news_id, $user_id)
    {
        $sql = "select * from news_like_info where news_id=$news_id AND user_id=$user_id";
        $rs = $this->query($sql);
        $num = $this->num_of_rows($rs);
        return $num;
    }
}