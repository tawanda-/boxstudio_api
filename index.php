<?php
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);

    $request = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

    if ($request[0] === '') {
            require __DIR__.'/indexhtml.php';
    }else{
        require __DIR__.'/app/router.php';
    }
?>