<?php
//require './helpers/global_helper.php';
require MODEL_PATH . '/base_model.class.php';
require MODEL_PATH . 'real_news_model.class.php';
$ch = curl_init();
//$url = 'http://news.hustonline.net/category/highlights';
$url = 'http://hb.qq.com/news/';
//$ru1 = "/<li><a\sclass=\"partition\"\stitle=\"(.*)\"\shref=\"(.*)\">(.*)<\/a>(.*)<\/li>/";
//$ru2 = "/<h3>\s<a\shref=\"(.*)\">(.*)<\/a><\/h3>/";
//$ru3 = "/<span><a\shref=\"(.*)\"\starget=\"(.*)\">(.*)<\/a><\/span><span>(.*)<\/span>/";
$ru = "/<h3>(.*)<\/h3>/";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//不自动输出内容
curl_setopt($ch, CURLOPT_HEADER, 0);//不返回头部信息
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 0);
$output = curl_exec($ch);
if (curl_exec($ch) === false) {
    die(curl_error($ch));
}
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
    exit;
}
curl_close($ch);
$output = mb_convert_encoding($output, "utf-8", "gb2312");
$arr = array();
preg_match_all($ru, $output, $arr);

$info_model = new Real_News_Model();
$news = array();
for ($i = 0; $i < 10; $i++) {
    $news[$i] = $arr[0][$i];
    $info_model->insert_real_time_news($news[$i]);
    print_r($news[$i]);

}

