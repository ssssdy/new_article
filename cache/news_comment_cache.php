<?php
require_once 'base_cache.class.php';

class News_Comment_Cache extends Base_Cache
{
    function __construct()
    {
        parent::__construct();
    }

    function insert_news_comment($news_id, $array)
    {
        $key = 'news_comment:' . $news_id;
        return $this->r_push($key, json_encode($array), ONE_MONTH);

    }

    function get_comment_info($news_id)
    {
        $key = 'news_comment:' . $news_id;
        return $this->l_range($key, 0, -1);
    }
}