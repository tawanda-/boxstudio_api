<?php

    require_once(dirname(__DIR__)."/config/db.php");
    include(dirname(__DIR__)."/models/schedule.php");

    class ScheduleDAO{

        private $db_conn;

        public function __construct(){
            $this->db_conn = get_db_connection();
        }

        public function get_schedule($schedule_id){
            $this->query_db_schedule($schedule_id);
        }

        public function get_all_schedules(){
            $this->query_db_schedule();
        }

        private function query_db_schedule($schedule_id=null){

            if(is_null($schedule_id)){

                $stmt = $this->db_conn->prepare("SELECT schedule.*, staff.*, activity.* FROM schedule AS schedule INNER JOIN staff AS staff on schedule.staffID = staff.staffID INNER JOIN activity AS activity on schedule.actvityID = activity.actvityID");
            
                if ($stmt->execute()) {

                    $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'schedule');

                    echo json_encode($result);
                }
            }else{

                $stmt = $this->db_conn->prepare("SELECT schedule.*, staff.*, activity.* FROM schedule AS schedule INNER JOIN staff AS staff on schedule.staffID = staff.staffID INNER JOIN activity AS activity on schedule.actvityID = activity.actvityID WHERE `scheduleID` = ?");

                if ($stmt->execute(array($schedule_id))) {
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $stmt->fetch();
                    echo json_encode($result);
                }
            }
        }
    }
?>