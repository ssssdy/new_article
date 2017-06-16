<html>
<?php
require './model/news_info_model.class.php';
require './helpers/global_helper.php';
session_start();
$ch = curl_init();
$url = 'http://news.hustonline.net/category/highlights';
$aid = 'sd';
$ru = "/<li><a\sclass=\"partition\"\stitle=\"(.*)\"\shref=\"(.*)\">(.*)<\/a>(.*)<\/li>/";
//设置选项，包括URL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//不自动输出内容
curl_setopt($ch, CURLOPT_HEADER, 0);//不返回头部信息
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 0);
//执行curl
$output = curl_exec($ch);
//错误提示
if (curl_exec($ch) === false) {
    die(curl_error($ch));
}
// 检查是否有错误发生
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
    exit;
}
curl_close($ch);
$arr = array();
preg_match_all($ru, $output, $arr);
dump($arr);
$page = isset($_GET['page']) ? intval($_GET['page']) : 0;
$page_size = 10;
$offset1 = ($page)*$page_size;
$offset2 = ($page+1)*$page_size;
$info_model = new Real_Time_News_Model();
echo $page."</br>";
for($i=$offset1;$i<$offset2;$i++){
//    dump($arr[0][$i]);
    $news[$i] = $arr[0][$i];
    $res =$info_model->insert_real_time_news($news[$i]);
    print_r($arr[0][$i]);
}
//for($j=0;$j<10;$j++){
//    $res =$info_model->insert_news_info($news[$j]);
////    dump($res);
//}
$_SESSION['page'] = ++$page;
echo "{$_SESSION['page']}";
session_destroy();
//header("refresh:5;url='get_news_info.php?page={$_SESSION['page']}'");
?>
</html>