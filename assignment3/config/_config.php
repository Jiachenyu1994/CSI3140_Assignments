<?php

session_start();

function resolve_path($path) {
    return __DIR__ . '/../' . $path;
}

spl_autoload_register(function ($class) {
    $file = resolve_path(str_replace('\\', '/', $class) . '.php');
    
    
    if (file_exists($file)) {
        require $file;
    }
});

define('APP_NAME', 'Paku Paku Game');
define('APP_VERSION', '1.0.0');
