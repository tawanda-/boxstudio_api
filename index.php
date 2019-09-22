<?php
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);

    $request = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

    switch ($request[0]) {
        case '' :
            require __DIR__.'/indexhtml.php';
            break;
        case 'app' :
            require __DIR__.'/app/router.php';
            break;
        default:
            echo 'not found';
            break;
    }
?>