<?php
require_once MODEL_PATH . 'news_model.class.php';
require_once 'base_cache.class.php';

class News_Details_Cache extends Base_Cache
{
    function __construct()
    {
        parent::__construct();
    }

    function show_news_details($news_id)
    {
        $news_model = new News_Model();
        $news_info = $this->get($news_id);
        if ($news_info == null) {
            $news_info = $news_model->get_one_news_info($news_id);
            $this->set($news_id, json_encode($news_info), ONE_DAY);
            $news_info = $this->get($news_id);
            echo "先存后取";
        } else {
            echo "直接从缓存取";
        }
        $news_info_redis = json_decode($news_info, true);
        return $news_info_redis;
    }
}