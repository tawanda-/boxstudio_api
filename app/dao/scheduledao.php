<?php

    require_once(dirname(__DIR__)."/config/db.php");
    include(dirname(__DIR__)."/models/schedule.php");

    class ScheduleDAO{

        private $db_conn;

        public function __construct(){
            $this->db_conn = get_db_connection();
        }

        public function get_schedule($schedule_id){
            return $this->query_db_schedule($schedule_id);
        }

        public function get_all_schedules(){
            return $this->query_db_schedule();
        }

        private function query_db_schedule($schedule_id=null){

            if(is_null($schedule_id)){

                $stmt = $this->db_conn->prepare("
                    SELECT schedule.*, staff.*, activity.*, facility.* FROM schedule AS schedule 
                    INNER JOIN staff AS staff on schedule.staffID = staff.staffID 
                    INNER JOIN activity AS activity on schedule.actvityID = activity.actvityID
                    INNER JOIN facility AS facility on schedule.FacilityNum = facility.FacilityNum");
            
                if ($stmt->execute()) {
                    return $stmt->fetchAll(PDO::FETCH_CLASS, 'schedule');
                }
            }else{

                $stmt = $this->db_conn->prepare("
                    SELECT schedule.*, staff.*, activity.*, facility.* FROM schedule AS schedule 
                    INNER JOIN staff AS staff on schedule.staffID = staff.staffID 
                    INNER JOIN activity AS activity on schedule.actvityID = activity.actvityID 
                    WHERE `scheduleID` = ?");

                if ($stmt->execute(array($schedule_id))) {
                    return $stmt->fetch();;
                }
            }
        }
    }
?>