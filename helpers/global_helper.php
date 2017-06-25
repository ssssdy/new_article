<?php
function check_login()
{
    session_start();
    if (isset($_SESSION['user_name'])) {
        echo "<li><p class='navbar-text navbar-right'>欢迎" . $_SESSION['role_name'] . $_SESSION['user_name'] . " 登录！" . "</p></li>";
        echo '<li><a href="../action.php?action=logout"><span class="glyphicon glyphicon-log-out"></span> 注销</a></li>';
    } else {
        echo '<li><a href="../register.php"><span class="glyphicon glyphicon-user"></span> 注册</a></li>';
        echo '<li><a href="../login.php"><span class="glyphicon glyphicon-log-in"></span> 登录</a></li>';
    }
}

function str_rand()
{
    $str = "abcdefghijkmnpqrstuvwxyz0123456789ABCDEFGHIGKLMNPQRSTUVWXYZ";//设置被随机采集的字符串
    $codeLen = '5';//设置生成的随机数个数
    $rand = "";
    for ($i = 0; $i < $codeLen - 1; $i++) {
        $rand .= $str[mt_rand(0, strlen($str) - 1)];  //如：随机数为30  则：$str[30]
    }
    return $rand;
}

function dump($var, $echo = true, $label = null, $strict = true)
{
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = "<pre>" . $label . htmlspecialchars($output, ENT_QUOTES) . "</pre>";
        } else {
            $output = $label . " : " . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    } else
        return $output;
}

function qiniu_image_display($url)
{
    $dir = "http://orc8koj7r.bkt.clouddn.com/";
//    $img_model = "?imageView2/1/w/200/h/200/q/75|imageslim";
    return $dir . $url;
}

function seconds_to_date($seconds)
{
    $hours = floor($seconds / SECONDS_PER_HOUR);
    $minutes = floor(($seconds / SECONDS_PER_MINUTE) % SECONDS_PER_MINUTE);
    $seconds = $seconds % SECONDS_PER_MINUTE;
    return "$hours" . "小时" . "$minutes" . "分钟" . "$seconds" . "秒";
}
