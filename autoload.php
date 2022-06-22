<?php

spl_autoload_register(function ($className) {
    $folders = [
        'controllers',
        'classes',
    ];

    foreach ($folders as $folderName) {
        $path = "app/$folderName/$className.php";
        if (file_exists($path)) {
            require_once $path;
            break;
        }
    }
});

require_once 'app/routes.php';
