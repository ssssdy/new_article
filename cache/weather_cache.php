<?php
require_once 'base_cache.class.php';
include '../lib/weather/get_weather_info_from_api.php';
class Weather_cache extends Base_Cache
{
    function __construct()
    {
        parent::__construct();
    }

    function get_weather_info_from_cache($city_id = WEATHER_DEFAULT_CITY)
    {
        $today_weather_redis = $this->redis_instance->get($city_id);
        $today_weather_info = json_decode($today_weather_redis, true);
        return $today_weather_info;
    }
}