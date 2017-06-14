<?php
//方法1:
//$url = 'http://news.hustonline.net/';
//$lines_array = file($url);
//$lines_string = implode('',$lines_array);
//echo $lines_string;
//方法2:
$url = 'http://t.qq.com';
//file_get_contents函数远程读取数据
$lines_string = file_get_contents($url);
//输出内容，嘿嘿，大家也可以保存在自己的服务器上
echo htmlspecialchars($lines_string);