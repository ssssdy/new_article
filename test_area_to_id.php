<?php
include "/var/www/article.ssssdy.top/helpers/global_helper.php";
$host = "https://ali-weather.showapi.com";
$path = "/area-to-id";
$method = "GET";
$app_code = "b43a537436e24c95aa3e7bbf69d0ef1c";
$headers = array();
$code = urlencode('武汉');
array_push($headers, "Authorization:APPCODE " . $app_code);
$query = "area=$code";
//    $bodys = "";%E4%B8%BD%E6%B1%9F
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
$out_put = curl_exec($curl);
dump(area_to_id('湖南'));
dump(get_weather_info_from_new(101200107));
//dump($out_put);
$data = json_decode($out_put, true);
dump($data['showapi_res_body']['list']['0']['cityInfo']['c1']);
dump($data);