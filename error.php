<?php
switch ($_GET['error_type']) {
    case 'rate_limiting':
        echo "请求太频繁,请 " . "<a style='color: red' href='index.php'>返回主页</a>" . " 稍后重试!";
        break;
    case 'city_not_exist':
        echo "您输入的城市名不存在!请 " . "<a style='color: red' href='show_weather_info.php'>返回</a>" . " 重新输入!";
        break;
}
