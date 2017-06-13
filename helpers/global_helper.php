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
