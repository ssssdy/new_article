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

    function set($key, $value, $timeout = 0)
    {
        $this->redis_instance->set($key, $value);
        if ($timeout > 0) {
            $this->redis_instance->expire('$key', $timeout);
        }
    }

    function sets($key_array, $timeout)
    {
        if (is_array($key_array)) {
            $result_res = $this->redis_instance->mset($key_array);
            if ($timeout > 0) {
                foreach ($key_array as $key => $value) {
                    $this->redis_instance->expire($key, $timeout);
                }
            }
            return $result_res;
        } else {
            return "Call  " . __FUNCTION__ . " method  parameter  Error !";
        }
    }

    function get($key)
    {
        $result = $this->redis_instance->get($key);
        return $result;
    }

    function gets($key_array)
    {
        if (is_array($key_array)) {
            return $this->redis_instance->mget($key_array);
        } else {
            return "Call  " . __FUNCTION__ . " method  parameter  Error !";
        }
    }

    function rPush($key, $value, $timeout = 0)
    {
        $this->redis_instance->rPush($key, $value);
        if ($timeout > 0) {
            $this->redis_instance->expire('$key', $timeout);
        }
    }

    function lRange($key, $start, $end)
    {
        return $this->redis_instance->lRange($key, $start, $end);
    }

    function hSet($tableName, $field, $value)
    {
        return $this->redis_instance->hset($tableName, $field, $value);
    }

    function hmSet($key, $value, $timeout = 0)
    {
        if (!is_array($value))
            return false;
        if ($timeout > 0) {
            $this->redis_instance->expire('$key', $timeout);
        }
        return $this->redis_instance->hMset($key, $value);
    }

    function hmGet($key, $field)
    {
        if (!is_array($field))
            $field = explode(',', $field);
        return $this->redis_instance->hMget($key, $field);
    }

    function hGet($tableName, $field)
    {
        return $this->redis_instance->hget($tableName, $field);
    }

    function delete($key)
    {
        return $this->redis_instance->del($key);
    }

    function lLen($list)
    {
        return $this->redis_instance->lLen($list);
    }

    function flush_db()
    {
        return $this->redis_instance->flushDB();
    }

    function isExists($key)
    {
        return $this->redis_instance->exists($key);
    }
}