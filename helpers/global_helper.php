<?php
function check_login()
{
    session_start();
    if (isset($_SESSION['user_name'])) {
        echo "<li><p class='navbar-text navbar-right'>欢迎" . $_SESSION['role_name'] . $_SESSION['user_name'] . " 登录！" . "</p></li>";
        echo '<li><a href="../action.php?action=logout"><span class="glyphicon glyphicon-log-out"></span> 注销</a></li>';
    } else {
        echo '<li><a href="../register.php"><span class="glyphicon glyphicon-user"></span> 注册</a></li>';
        echo '<li><a href="../login.php"><span class="glyphicon glyphicon-log-in"></span> 登录</a></li>';
    }
}

function access_limit($ip, $limit, $timeout)
{
    $redis = new Base_Cache();
    $key = "rate.limiting:{$ip}";
    $check = $redis->increase($key);
    if ($check == 1) {
        $redis->expire($key, $timeout);
    } else {
        $count = $redis->get($key);
        if ($count > $limit) {
            header("location:../error.php?error_type=rate_limiting");
        }
    }
    $count = $redis->get($key);
    echo $limit . '秒内第 ' . $count . ' 次访问' . '<br>';
}

function str_rand()
{
    $str = "abcdefghijkmnpqrstuvwxyz0123456789ABCDEFGHIGKLMNPQRSTUVWXYZ";//设置被随机采集的字符串
    $codeLen = '5';//设置生成的随机数个数
    $rand = "";
    for ($i = 0; $i < $codeLen - 1; $i++) {
        $rand .= $str[mt_rand(0, strlen($str) - 1)];  //如：随机数为30  则：$str[30]
    }
    return $rand;
}

function dump($var, $echo = true, $label = null, $strict = true)
{
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = "<pre>" . $label . htmlspecialchars($output, ENT_QUOTES) . "</pre>";
        } else {
            $output = $label . " : " . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    } else
        return $output;
}

function qiniu_image_display($url)
{
    $dir = "http://orc8koj7r.bkt.clouddn.com/";
    $img_model = "?imageView2/2/w/600/h/300/q/75|watermark/2/text/d3d3LnNzc3NkeS50b3A=/font/5a6L5L2T/fontsize/300/fill/IzAwMDAwMA==/dissolve/100/gravity/SouthEast/dx/10/dy/10|imageslim";
    return $dir . $url . $img_model;
}

function seconds_to_date($seconds)
{
    $hours = floor($seconds / SECONDS_PER_HOUR);
    $minutes = floor(($seconds / SECONDS_PER_MINUTE) % SECONDS_PER_MINUTE);
    $seconds = $seconds % SECONDS_PER_MINUTE;
    return "$hours" . "小时" . "$minutes" . "分钟" . "$seconds" . "秒";
}

function get_weather_info_from_new($area_id = WEATHER_DEFAULT_CITY)
{
//    require_once '/var/www/article.ssssdy.top/cache/base_cache.class.php';
    $host = "https://ali-weather.showapi.com";
    $path = "/area-to-weather";
    $method = "GET";
    $app_code = "b43a537436e24c95aa3e7bbf69d0ef1c";
    $headers = array();
    array_push($headers, "Authorization:APPCODE " . $app_code);
    $query = "areaid={$area_id}&need3HourForcast=0&needAlarm=0&needHourData=0&needIndex=0&needMoreDay=1";
//    $body = "";
    $url = $host . $path . "?" . $query;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, 0);//取消头部信息,不然无法用json解析
    if (1 == strpos("$" . $host, "https://")) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    $out_put_info = curl_exec($curl);
    if (empty($out_put_info)) {
        echo "查询的城市不存在!";
    }
    $data_weather_info = json_decode($out_put_info, true);
    $redis = new Base_Cache();
    //$data_weather_info['showapi_res_body']['cityInfo']['c1']为城市编号
    $redis->set($data_weather_info['showapi_res_body']['cityInfo']['c1'], json_encode($data_weather_info['showapi_res_body']['now']), SURVIVAL_TIME_OF_WEATHER);
    $today_weather_redis = $redis->get($data_weather_info['showapi_res_body']['cityInfo']['c1']);
    $redis->set('now_city_id', $data_weather_info['showapi_res_body']['cityInfo']['c1']);
    $today_weather_info = json_decode($today_weather_redis, true);
    return $today_weather_info;
}

function area_to_id($city_name)
{
    $host = "https://ali-weather.showapi.com";
    $path = "/area-to-id";
    $method = "GET";
    $app_code = "b43a537436e24c95aa3e7bbf69d0ef1c";
    $headers = array();
    $code = urlencode($city_name);
//    dump($code);
    array_push($headers, "Authorization:APPCODE " . $app_code);
    $query = "area=$code";
//    $bodys = "";
    $url = $host . $path . "?" . $query;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    if (1 == strpos("$" . $host, "https://")) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    $out_put_info = curl_exec($curl);
//    dump($out_put_info);
    $data = json_decode($out_put_info, true);
    $city_id = $data['showapi_res_body']['list']['0']['cityInfo']['c1'];
    $redis = new Base_Cache();
    $redis->set($city_name, $city_id, SURVIVAL_TIME_OF_CITY_NAME);
    return $city_id;
}