<?
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);

    $x = explode('?', trim($_SERVER['REQUEST_URI'], '/'));
    $request_uri = explode('/', $x[0]);

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
                $url_components = parse_url($_SERVER['REQUEST_URI']);

                $scheduleid = null;
                
                if(isset($url_components['query'])){
                    parse_str($url_components['query'], $params);
                    $staff_id = $params['scheduleid'];
                }
                
                require(__DIR__."/dao/scheduledao.php");
                $scheduledao = new ScheduleDAO();

                if(is_null($scheduleid)){
                    $scheduledao->get_all_schedules();
                }else{
                    $scheduledao->get_schedule($scheduleid);
                }
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
            case "staff":

                $url_components = parse_url($_SERVER['REQUEST_URI']);

                $staff_id = null;
                
                if(isset($url_components['query'])){
                    parse_str($url_components['query'], $params);
                    $staff_id = $params['staffid'];
                }
                
                require(__DIR__."/dao/staffdao.php");
                $staffdao = new StaffDAO();

                if(is_null($staff_id)){
                    $staffdao->get_all_staff();
                }else{
                    $staffdao->get_staff($staff_id);
                }
                
                break;
            case "":
            case "app":
            case "home":
                require(__DIR__."/views/home.php");
                break;
            default:
                header('HTTP/1.0 404 Not Found');
                echo "<h1>Error 404 Not Found</h1>";
                echo "The page that you have requested could not be found.";
                exit();
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