<?php
include './helpers/global_helper.php';
include './cache/base_cache.class.php';
$host = "https://ali-weather.showapi.com";
$path = "/area-to-weather";
$method = "GET";
$app_code = "b43a537436e24c95aa3e7bbf69d0ef1c";
$headers = array();
array_push($headers, "Authorization:APPCODE " . $app_code);
//'武汉'的UTF8(URL)编码为=%E6%AD%A6%E6%B1%89
$areaid = 10120010;
$query = "areaid=101200101&need3HourForcast=0&needAlarm=0&needHourData=0&needIndex=0&needMoreDay=1";
$body = "";
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
$out_put = curl_exec($curl);
curl_close($curl);
dump($out_put);
$data = json_decode($out_put, true);
$redis = new Base_Cache();
$redis->set($data['showapi_res_body']['cityInfo']['c2'], json_encode($data['showapi_res_body']['now']), 1800);
//$redis->set('city_info',json_encode(($data['showapi_res_body']['cityInfo'])));
$today_weather_redis = $redis->get('today_weather');
$today_weather_info = json_decode($today_weather_redis, true);
dump($data);
dump($today_weather_info);
dump($today_weather_info['aqiDetail']['area']);


