<?php
function check_login()
{
    session_start();
    if (isset($_SESSION['user_name'])) {
        echo "欢迎 " . $_SESSION['role_name'] . "  " . $_SESSION['user_name'] . " 登录！";
        echo "<br/>";
        echo "<a href='../action.php?action=logout'>注销登录  </a>";
        echo "<a href='../register.php'>  注册</a>";
    } else {
        echo "您还没有登录哦！请先 ";
        echo "<a href='../login.php'>登录 </a>";
        echo "<a href='../register.php'>注册</a>";
    }
}

function  str_rand(){
    $str="abcdefghijkmnpqrstuvwxyz0123456789ABCDEFGHIGKLMNPQRSTUVWXYZ";//设置被随机采集的字符串
    $codeLen='5';//设置生成的随机数个数
    $rand="";
    for($i=0; $i<$codeLen-1; $i++){
        $rand .= $str[mt_rand(0, strlen($str)-1)];  //如：随机数为30  则：$str[30]
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
