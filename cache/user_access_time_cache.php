<?php
require_once 'base_cache.class.php';

class Access_time_Cache extends Base_Cache
{
    function __construct()
    {
        parent::__construct();
    }

    function increase_access_time($ip)
    {
        $key = 'access_times_rank';
        return $this->z_increase_by($key, intval(1), $ip);
    }


    function get_access_time_range()
    {
        return $this->z_rev_range('access_times_rank', 0, -1, true);
    }

    function get_access_time_rank($member)
    {
        return $this->get_ranking('access_times_rank', $member) + 1;
    }

//    function access_limit1($ip, $limit, $timeout)
//    {
//        $key = "rate.limiting:{$ip}";
//        $check = $this->increase($key);
//        if ($check == 1) {
//            $this->expire($key, $timeout);
//        } else {
//            if ($check > $limit) {
//                header("location:../error.php?error_type=rate_limiting");
//            }
//        }
//        echo $timeout . '秒内第 ' . $check . ' 次访问' . '<br>';
//    }

    function access_limit($ip)
    {
        $limit_arr = [];
        $timeout_arr = [];
        foreach (RATE_LIMITING_ARR as $limit => $timeout) {
            $limit_arr[] = $limit;
            $timeout_arr[] = $timeout;
        }
        for ($i = 0; $i < count($limit_arr); $i++) {
            $key = "rate.limiting" . $i . ":{$ip}";
            $check = $this->increase($key);
            if ($check == 1) {
                $this->expire($key, $timeout_arr[$i]);
            } else {
                if ($check > $limit_arr[$i]) {
                    header("location:../error.php?error_type=rate_limiting");
                }
            }
            echo $timeout_arr[$i] . '秒内第 ' . $check . ' 次访问' . '<br>';
            echo "访问限制" . $key . "过期时间剩余:" . $this->rest_survival_time($key) . "<br>";
        }
    }
}