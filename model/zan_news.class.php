<?php
require_once 'base_model.class.php';

class Zan_News_Model extends Base_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function insert_zan_info($array, $table)
    {
        return $this->insert($array, $table);
    }

    function zan_num_of_news($news_id)
    {
        $sql = "select * from zan_of_news where news_id = $news_id";
        $num = $this->num_of_rows($this->query($sql));
        return $num;
    }

    function check_zan_to_new($news_id, $user_id)
    {
        $sql = "select * from zan_of_news where news_id=$news_id AND user_id=$user_id";
        $rs = $this->query($sql);
        $num = $this->num_of_rows($rs);
        return $num;
    }
}