<?php

class Zan_Cache extends Base_Cache
{
    function __construct()
    {
        parent::__construct();
    }

//所有被点赞的文章集合
    function be_praised_news_add($news_id)
    {
        return $this->set_add('be_praised_news', $news_id);
    }

//点赞该文章的用户集合
    function user_post_news_add($news_id, $user_id)
    {
        $key = "praise_news_user_set:$news_id";
        return $this->set_add($key, $user_id);
    }
}