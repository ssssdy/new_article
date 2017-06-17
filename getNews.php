<?php
echo "<meta charset='utf-8'>";
require './helpers/global_helper.php';
require './model/base_model.class.php';
require './model/real_news_model.class.php';
//session_start();
$ch = curl_init();
//$url = 'http://news.hustonline.net/category/highlights';
$url = 'http://hb.qq.com/news/';
//$ru = "/<li><a\sclass=\"partition\"\stitle=\"(.*)\"\shref=\"(.*)\">(.*)<\/a>(.*)<\/li>/";
//$ru = "/<h3>(.*)<a\shref=\"(.*)\">(.*)<\/a>)(.*)<\/h3>/";
$ru = "/<div\sclass=\"txtarea\"><h3><a\shref=\"(.*)\">(.*)<\/a><\/h3>/";
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
//print_r($output);
$arr = array();
preg_match_all($ru, $output, $arr);
dump($arr);
//$redis = new Redis();
//$redis->connect('127.0.0.1', 6379);
//$page = isset($_GET['page']) ? intval($_GET['page']) : 0;
//$page_size = 10;
//$offset1 = ($page) * $page_size;
//$offset2 = ($page + 1) * $page_size;
//$info_model = new Real_News_Model();
//echo $page . "</br>";
//$news = array();
//for ($i = $offset1; $i < $offset2; $i++) {
//    $news[$i] = $arr[0][$i];
////    $info_model->insert_real_time_news($news[$i]);
////    $redis->lPush('news_list', "$news[$i]");
//    print_r($news[$i]);
////    dump($news);
//}
//echo $news[1];
//dump($news[0]);
////$arList = $redis->lRange("new_list",0,10);
//$_SESSION['page'] = ++$page;
//echo "{$_SESSION['page']}";
//session_destroy();
//header("refresh:5;url='getNews.php?page={$_SESSION['page']}'");
