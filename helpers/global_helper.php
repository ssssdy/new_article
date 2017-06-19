<?php
function check_login()
{
    session_start();
    if (isset($_SESSION['user_name'])) {
        echo "欢迎 " . $_SESSION['role_name'] . "  " . $_SESSION['user_name'] . " 登录！";
        echo "<br/>";
        echo "<a href='../action.php?action=logout'>注销登录  </a>";
        echo "<a href='../register.php'>  注册</a><br>";
        echo "<a href='../show_weather_info.php'>天气预报</a>";
    } else {
        echo "您还没有登录哦！请先 ";
        echo "<a href='../login.php'>登录 </a>";
        echo "<a href='../register.php'>注册</a>";
    }
}

function access_limit($ip, $limit, $timeout)
{
    $redis = new Base_Cache();
    $key = "rate.limiting:{$ip}";
    $check = $redis->is_exists($key);
    if ($check) {
        $redis->increase($key);
        $count = $redis->get($key);
        if ($count > $limit) {
            exit('请求太频繁，请稍后再试！');
        }
    } else {
        $redis->increase($key);
        $redis->expire($key, $timeout);
    }
    $count = $redis->get($key);
    echo '第 ' . $count . ' 次访问';
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
//    $img_model = "?imageView2/2/w/200/h/200/q/75|watermark/1/image/aHR0cHM6Ly9vanBibHkxdW4ucW5zc2wuY29tL2xvZ28ucG5n/dissolve/100/gravity/SouthEast/dx/10/dy/10|imageslim";
//    $img_model = "?	imageView2/1/w/200/h/200/q/75|imageslim";
    return $dir . $url;
}

function seconds_to_date($seconds)
{
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds / 60) % 60);
    $seconds = $seconds % 60;
    return "$hours" . "小时" . "$minutes" . "分钟" . "$seconds" . "秒";
}

function get_real_weather_info($area_id)
{
    require_once '/var/www/article.ssssdy.top/cache/base_cache.class.php';
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
    $redis->set('today_weather', json_encode($data_weather_info['showapi_res_body']['now']));
    $redis->set('city_info', json_encode(($data_weather_info['showapi_res_body']['cityInfo'])));
    $today_weather_redis = $redis->get('today_weather');
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
    $data = json_decode($out_put_info, true);
    $city_id = $data['showapi_res_body']['list']['0']['cityInfo']['c1'];
    return $city_id;

}