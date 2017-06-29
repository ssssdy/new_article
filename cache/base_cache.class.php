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
        $redis->connect(LOCAL_IP, PORT);
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
        $this->redis_instance->mset($key_array);
        if ($timeout > 0) {
            foreach ($key_array as $key => $value) {
                $this->redis_instance->expire($key, $timeout);
            }
        }
    }

    function get($key)
    {
        return $this->redis_instance->get($key);
    }

    function gets($key_array)
    {
        return $this->redis_instance->mget($key_array);

    }

    function r_push($key, $value, $timeout = 0)
    {
        $rs = $this->redis_instance->rpush($key, $value);
        if ($timeout > 0) {
            $this->redis_instance->expire($key, $timeout);
        }
        return $rs;
    }

    function l_range($key, $start, $end)
    {
        return $this->redis_instance->lrange($key, $start, $end);
    }

    function h_set($tableName, $field, $value)
    {
        return $this->redis_instance->hset($tableName, $field, $value);
    }

    function hm_set($key, $array, $timeout = 0)
    {
        $res = $this->redis_instance->hmset($key, $array);
        if ($timeout > 0) {
            $this->redis_instance->expire($key, $timeout);
        }
        return $res;
    }

    function hm_get($key, $array)
    {
        $value = [];
        foreach ($array as $field) {
            $value[] = $this->redis_instance->hGet($key, $field);
        }
        return $value;
    }

    function h_get($key, $field)
    {
        return $this->redis_instance->hget($key, $field);
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

    function z_increase_by($key, $value, $member)
    {
        return $this->redis_instance->zIncrBy($key, intval($value), $member);
    }

    function z_rev_range($key, $start, $end, $with_scores = true)
    {
        return $this->redis_instance->zRevRange($key, $start, $end, $with_scores);
    }

    function get_ranking($key, $member)
    {
        return $this->redis_instance->zRevRank($key, $member);
    }

    function set_add($key, $member)
    {
        return $this->redis_instance->sAdd($key, $member);
    }

    function set_is_member($key, $member)
    {
        return $this->redis_instance->sIsMember($key, $member);
    }

    function count_of_set_member($key)
    {
        return $this->redis_instance->sCard($key);
    }
}