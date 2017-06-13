<?php
require '../helpers/global_helper.php';
define('DS', DIRECTORY_SEPARATOR);
define('LOG_PATH',dirname(__FILE__).DS.'news_log'.DS);
dump(LOG_PATH);
$s_now_time = date('[Y-m-d H:i:s]');
$s_now_day  = date('Y_m_d');
$s_target   = LOG_PATH;
$s_target .= 'Out_' . $s_now_day . '.log';
dump($s_target);
dump(basename($s_target));
$s_file_name = substr(basename($s_target), 0, strrpos(basename($s_target), '.log')). '_' . time() . '.log';
dump($s_file_name);
echo $s_file_name;