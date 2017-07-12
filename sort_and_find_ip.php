<?php
include './helpers/sort_and_search.php';
include './cache/base_cache.class.php';

//排序算法耗时比较
//$arr = array_rand(range(1, 10000), 3000);
//shuffle($arr);//打乱顺序
$t1 = microtime(true);
bubble_sort($arr);
$t2 = microtime(true);
echo "冒泡排序耗时：" . (($t2 - $t1) * 1000) . 'ms' . "<br>";
$t3 = microtime(true);
select_sort($arr); //选择排序
$t4 = microtime(true);
echo "选择排序用时：" . (($t4 - $t3) * 1000) . 'ms' . "<br>";
$t5 = microtime(true);
insert_sort($arr); //插入排序
$t6 = microtime(true);
echo "插入排序用时：" . (($t6 - $t5) * 1000) . 'ms' . "<br>";
$t7 = microtime(true);
quick_sort($arr); //快速排序
$t8 = microtime(true);
echo "快速排序用时：" . (($t8 - $t7) * 1000) . 'ms' . "<br>";
$t9 = microtime(true);
merge_sort($arr);
$t10 = microtime(true);
echo "并归排序用时：" . (($t10 - $t9) * 1000) . 'ms' . "<br>";

$redis = new Base_Cache();
//$ip =[];
//$ip_arr = [];
//for ($i = 1; $i < 1000; $i++) {
//    $ip = rand(0, 255).'.'.rand(0, 255). '.' . rand(0, 255) . '.' . rand(0, 255);
//    $ip_arr[] = $ip;
//}
////$new_arr = quick_sort($ip);
//foreach ($ip_arr as $value){
//    $redis->r_push('ip_list',$value,86400);
//}
//来自随机生成且无重复的并存入缓存的1000个ip地址
$ip_list = $redis->l_range('ip_list', 0, 999);
//顺序查找
$t_1 = microtime(true);
order_search($ip_list, "98.111.158.233");
echo "<br>";
$t_2 = microtime(true);
echo "顺序查找耗时：" . (($t_2 - $t_1) * 1000) . 'ms' . "<br>";
//二分法查找
$t_3 = microtime(true);
$int_ip = [];
foreach ($ip_list as $value) {
    $int_ip[] = ip2long($value);
}
//dump($int_ip[6]);
//echo "要查找的位置为:第".dichotomous_search($int_ip, $int_ip[6])."位<br>";
echo dichotomous_search($int_ip, $int_ip[123]);
$t_4 = microtime(true);
echo "二分法查找耗时：" . (($t_4 - $t_3) * 1000) . 'ms' . "<br>";
//dump($ip_list);
$t_5 = microtime(true);
$locate = array_search("98.111.158.233", $ip_list);
$t_6 = microtime(true);
echo "array_search函数查找位置为:" . ++$locate . ".耗时：" . (($t_6 - $t_5) * 1000) . 'ms' . "<br>";
dump($ip_list);
dump($int_ip);