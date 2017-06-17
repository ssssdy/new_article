<?php
//include '../helpers/global_helper.php';
//include '../model/base_model.class.php';
//$real_news = new Base_News_Model();
//$info = $real_news->get_all_news_info();
//echo json_encode($info[1]);
//$redis = new Redis();
//$redis->connect('127.0.0.1', '6379');
//$redis->ping();
//$redis->select(5);
//for($i=0;$i<count($info);$i++){
//$redis->lPush('news_list',json_encode($info[$i]));
//}
//$out_put = $redis->lRange('news_list',0,count($info)-1);
//dump($out_put);
//$news = json_decode($out_put[0],true);
//dump($news);
////$redis->set('news_list',json_encode($info[2]));
////$out_info = $redis->get('news_list');
////dump($out_info[0]);
////$news = json_decode($out_info[0],true);
////dump($news['id']);
require '../model/base_model.class.php';
require '../model/news_model.class.php';
include '../helpers/global_helper.php';
$news_model = new  News_Model();
$tag_id = $_POST['tag_id'];
$title = $_POST['title'];
$keywords = $_POST['keywords'];
$author = $_POST['author'];
$content = $_POST['content'];
$image_name = $_POST['image_name'];
$id = $_POST['id'];
echo $id;
$arr = array('tag_id' => $tag_id, 'title' => $title, 'keywords' => $keywords, 'author' => $author,
    'content' => $content, 'image_name' => $image_name);
dump($arr);
$news_model->update_news('news', $arr, $id);
//header("Location:index.php");
//$arr = array('tag_id' => 15, 'title' => 12, 'keywords' => 12, 'author' => 12,
//    'content' => 14, 'image_name' => '006.jpg');
////$news_model->update_by_id('news', $arr, 68);
//$table = 'news';
//$id = 68;
//$key_and_value = array();
//foreach ($arr as $key => $value) {
//    $value = mysqli_real_escape_string($news_model->conn, $value);
//    $key_and_value[] = $key . "='" . $value . "'";}
//    $key_and_values = join(',', $key_and_value);
//    $sql = "update {$table} set {$key_and_values} where id={$id}";
//    mysqli_query($news_model->conn, $sql);
//
