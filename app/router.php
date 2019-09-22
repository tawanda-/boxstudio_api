<?
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);

    $request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

    switch($_SERVER['REQUEST_METHOD']){
        
        case "GET":
            if( count($request_uri) > 1 ) {
                process_get_request($request_uri[1]);
            }else{
                process_get_request($request_uri[0]);
            }
        break;
        
        case "POST":
            process_post_request($request_uri[0]);
        break;

        default:
        break;
    }

    function process_get_request($uri){
        
        switch($uri){
            case "schedule":
                require(__DIR__."/views/shop.php");
                break;
            case "about":
                require(__DIR__."/views/about.php");
                break;
            case "contact":
                require(__DIR__."/views/contact.php");
                break;
            case "login":
                require(__DIR__."/views/login.php");
                break;
            case "":
            case "app":
            case "home":
                require(__DIR__."/views/home.php");
                break;
            default:
                break;
        }
    }

    function process_post_request($uri){

        switch($uri){
            case "subscribe":
                include("/views/shop.php");
            break;
            case "about":
                include("/views/about.php");
            break;
            case "contact":
                include("/views/about.php");
            break;
            case "":
            case "home":
            default:
                echo "";
                header('HTTP/1.0 404 Not Found');
            break;
        }
    }
?>