<?php
require_once 'base_cache.class.php';
include '/var/www/article.ssssdy.top/lib/weather/get_weather_info_from_api.php';

class Weather_Cache extends Base_Cache
{
    function __construct()
    {
        parent::__construct();
    }

    function get_weather_info_from_cache()
    {
        $city_id = $this->get('now_city_id');
        $today_weather_redis = $this->get($city_id);
        $today_weather_info = json_decode($today_weather_redis, true);
        if ($today_weather_redis == null) {
            $today_weather_info = get_weather_info_from_new($city_id);
        }
        return $today_weather_info;
    }
}