<?php
require_once 'base_cache.class.php';

class News_Like_Cache extends Base_Cache
{
    function __construct()
    {
        parent::__construct();
    }

//所有被点赞的文章集合
    function be_liked_news_add($news_id)
    {
        return $this->set_add('be_liked_news_set', $news_id);
    }

//添加用户到点赞某一文章的集合
    function like_news_user_add($name_of_news_id, $user_id)
    {
        return $this->set_add($name_of_news_id, $user_id);
    }

    function check_news_be_liked($news_id, $user_id)
    {
        return $this->set_is_member($news_id, $user_id);
    }

    function insert_news_like_info_hash($key, $array)
    {

        return $this->hm_set($key, $array, ONE_MONTH);

    }

    function count_of_news_like($name_of_news_like_key)
    {
        return $this->count_of_set_member($name_of_news_like_key);
    }
}