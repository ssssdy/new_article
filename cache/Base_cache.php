<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 17-6-17
 * Time: 下午8:02
 */
class Base_cache
{
    public $redis_instance;
    function __construct()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->select(1);
        $this->redis_instance = $redis;
    }

    function get($key)
    {

    }

    function set($key)
    {

    }
}