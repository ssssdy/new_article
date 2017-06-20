<?php
require_once '/var/www/article.ssssdy.top/config/config.php';

/**
 * Created by PhpStorm.
 * User: root
 * Date: 17-6-17
 * Time: 下午8:02
 */
class Base_Cache
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
            $this->redis_instance->expire($key, $timeout);
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

    function r_push($key, $value, $timeout = 0)
    {
        $this->redis_instance->rpush($key, $value);
        if ($timeout > 0) {
            $this->redis_instance->expire($key, $timeout);
        }
    }

    function l_range($key, $start, $end)
    {
        return $this->redis_instance->lrange($key, $start, $end);
    }

    function h_set($tableName, $field, $value)
    {
        return $this->redis_instance->hset($tableName, $field, $value);
    }

    function hm_set($key, $value, $timeout = 0)
    {
        if (!is_array($value))
            return false;
        if ($timeout > 0) {
            $this->redis_instance->expire($key, $timeout);
        }
        return $this->redis_instance->hmset($key, $value);
    }

    function hm_get($key, $field)
    {
        if (!is_array($field))
            $field = explode(',', $field);
        return $this->redis_instance->hmget($key, $field);
    }

    function h_get($table_name, $field)
    {
        return $this->redis_instance->hget($table_name, $field);
    }

    function delete($key)
    {
        return $this->redis_instance->del($key);
    }

    function list_length($list)
    {
        return $this->redis_instance->lLen($list);
    }

    function flush_db()
    {
        return $this->redis_instance->flushDB();
    }

    function is_exists($key)
    {
        return $this->redis_instance->exists($key);
    }

    function rest_survival_time($key)
    {
        return $this->redis_instance->ttl($key);
    }

    function increase($key)
    {
        return $this->redis_instance->incr($key);
    }

    function expire($key, $timeout)
    {
        return $this->redis_instance->expire($key, $timeout);
    }
}