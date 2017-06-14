<?php

class Log
{
    private static $i_log_size = 5242880; // 1024 * 1024 * 5 = 5M
    public static function set_size($i_size)
    {
        if( is_numeric($i_size) ){
            self::$i_log_size = $i_size;
        }
    }
    public static function write($s_message, $s_type = 'log')
    {
        // 检查日志目录是否可写
        if ( !file_exists(LOG_PATH) ) {
            @mkdir(LOG_PATH);
        }
        chmod(LOG_PATH,0777);
        if (!is_writable(LOG_PATH)) exit('LOG_PATH is not writeable !');
        $s_now_time = date('[Y-m-d H:i:s]');
        $s_now_day  = date('Y_m_d');
        // 根据类型设置日志目标位置
        $s_target   = LOG_PATH;
        switch($s_type)
        {
            case 'debug':
                $s_target .= 'Out_' . $s_now_day . '.log';
                break;
            case 'error':
                $s_target .= 'Err_' . $s_now_day . '.log';
                break;
            case 'log':
                $s_target .= 'Log_' . $s_now_day . '.log';
                break;
            default:
                $s_target .= 'Log_' . $s_now_day . '.log';
                break;
        }
        //检测日志文件大小, 超过配置大小则重命名
        if (file_exists($s_target) && self::$i_log_size <= filesize($s_target)) {
            $s_file_name = substr(basename($s_target), 0, strrpos(basename($s_target), '.log')). '_' . time() . '.log';
            rename($s_target, dirname($s_target) . DS . $s_file_name);
        }
        clearstatcache();
        // 写日志, 返回成功与否
        return error_log("$s_now_time $s_message\n", 3, $s_target);
    }
}