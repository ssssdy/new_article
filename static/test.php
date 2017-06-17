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
include '../helpers/global_helper.php';
$user_model = new Base_User_Model();
$user_id = 26;
$id = $user_model->get_role_id_by_user_id($user_id);
dump($id);
$result = $user_model->change_admin_role($user_id,$id);
dump($result);