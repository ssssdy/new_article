<?php
function log_error() {
    $arg_list = func_get_args();
    log_trace("ERROR", $arg_list, "logdir/error_log_" . date("m_d"));
}

function log_php_error()
{
    $arg_list = func_get_args();
    log_trace("PHP_ERROR", $arg_list, "logdir/php_error_log_" . date("m_d"));
}

function log_warn()
{
    $arg_list = func_get_args();
    log_trace("WARN", $arg_list, "logdir/warn_log_" . date("m_d"));
}

function log_info()
{
    $arg_list = func_get_args();
    log_simple("INFO", $arg_list, "logdir/info_log_" . date("m_d"));
}

function log_order()
{
    $arg_list = func_get_args();
    log_trace("ORDER", $arg_list, "logdir/order_log_" . date("m_d"));
}

function log_nickname_error()
{
    $arg_list = func_get_args();
    log_trace("ERROR", $arg_list, "logdir/nickname_error_log_" . date("m_d"));
}

function log_trace($level, $arg_list, $path)
{
    $e = new Exception;
    $stack_trace = $e->getTraceAsString();
    $str = " [$level] ";
    foreach ($arg_list as $arg) {
        if (is_array($arg) || is_object($arg)) {
            $str .= json_encode($arg);
        } else {
            $str .= $arg;
        }
        $str .= "; ";
    }
    $str .= "\n" . $stack_trace;
    $fp = @fopen($path, 'a+');
    if (!$fp) {
        $fp = fopen($path . "_temp", "a+");
    }
    fwrite($fp, date("Y-m-d H:i:s") . $str . "\n");
    fclose($fp);
}
