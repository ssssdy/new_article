<?php
require_once 'base_cache.class.php';

class Access_Times_Cache extends Base_Cache
{
    function __construct()
    {
        parent::__construct();
    }

    function increase_access_time($ip)
    {
        $key = 'access_times_rank';
//        return $this->redis_instance->zIncrBy($key, 1, $ip);
        return $this->z_increase_by($key, 1, $ip);
    }

    function get_access_times_range()
    {
        return $this->z_rev_range('access_times_rank', 0, -1, true);
    }

    function get_access_times_rank($member)
    {
        return $this->get_ranking('access_times_rank', $member) + 1;
    }

    function access_limit($ip, $limit, $timeout)
    {
        $key = "rate.limiting:{$ip}";
        $check = $this->increase($key);
        if ($check == 1) {
            $this->expire($key, $timeout);
        } else {
            $count = $this->get($key);
            if ($count > $limit) {
                header("location:../error.php?error_type=rate_limiting");
            }
        }
        $count = $this->get($key);
        echo $limit . '秒内第 ' . $count . ' 次访问' . '<br>';
    }
}