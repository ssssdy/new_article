<?php

function classLoader($class)
{
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . '/src/' . $path . '.php';

    if (file_exists($file)) {
        require $file;
    }
}
spl_autoload_register('classLoader');

require __DIR__ . '/src/Qiniu/functions.php';
