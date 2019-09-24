<?php

    require_once(dirname(__DIR__)."/config/db.php");
    include(dirname(__DIR__)."/models/facility.php");

    class FacilityDAO{

        private $db_conn;

        public function __construct(){
            $this->db_conn = get_db_connection();
        }

        public function get_facility($facility_id){
            $this->query_db_facility($facility_id);
        }

        public function get_all_facilities(){
            $this->query_db_facility();
        }

        private function query_db_facility($facility_id=null){

            if(is_null($facility_id)){

                $stmt = $this->db_conn->prepare("SELECT * FROM `facility`");
            
                if ($stmt->execute()) {

                    $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'facility');

                    echo json_encode($result);
                }
            }else{

                $stmt = $this->db_conn->prepare("SELECT *FROM `facility` WHERE `FacilityNum` = ?");

                if ($stmt->execute(array($facility_id))) {
                    $stmt->setFetchMode(PDO::FETCH_CLASS, 'facility');
                    $result = $stmt->fetch();
                    echo json_encode($result);
                }
            }
        }
    }
?>