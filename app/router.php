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
                    $scheduleid = $params['scheduleid'];
                }
                
                require(__DIR__."/dao/scheduledao.php");
                $scheduledao = new ScheduleDAO();

                if(is_null($scheduleid)){
                    $scheduledao->get_all_schedules();
                }else{
                    $scheduledao->get_schedule($scheduleid);
                }
                break;

            case "member":
                
                $url_components = parse_url($_SERVER['REQUEST_URI']);

                require(__DIR__."/dao/memberdao.php");
                $memberdao = new MemberDAO();
                
                if(isset($url_components['query'])){
                    parse_str($url_components['query'], $params);
                    if(isset($params['memberid'])){
                        $memberdao->get_member($params['memberid']);
                    }else if(isset($params['membershipid'])){
                        $memberdao->get_member_by_membershipid($params['membershipid']);
                    }
                }else{
                    $memberdao->get_all_members();
                }

                break;

            case "membership":
                
                $url_components = parse_url($_SERVER['REQUEST_URI']);

                require(__DIR__."/dao/membershipdao.php");
                $membershipdao = new MembershipDAO();
                
                if(isset($url_components['query'])){
                    parse_str($url_components['query'], $params);
                    if(isset($params['membershipid'])){
                        $membershipdao->get_membership($params['membershipid']);
                    }else if(isset($params['memberid'])){
                        $membershipdao->get_membership_by_memberid($params['memberid']);
                    }
                }else{
                    $membershipdao->get_all_memberships();
                }

                break;
            case "login":
                require(__DIR__."/views/login.php");
                break;

            case "facility":

                $url_components = parse_url($_SERVER['REQUEST_URI']);

                $facility_id = null;
                
                if(isset($url_components['query'])){
                    parse_str($url_components['query'], $params);
                    $facility_id = $params['facilityid'];
                }
                
                require(__DIR__."/dao/facilitydao.php");
                $facilitydao = new FacilityDAO();

                if(is_null($facility_id)){
                    $facilitydao->get_all_facilities();
                }else{
                    $facilitydao->get_facility($facility_id);
                }
                
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