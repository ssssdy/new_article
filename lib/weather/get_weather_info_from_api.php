<?php
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