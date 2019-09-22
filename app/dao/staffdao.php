<?php

    require_once(dirname(__DIR__)."/config/db.php");
    include(dirname(__DIR__)."/models/staff.php");

    class StaffDAO{
        private $db_conn;

        public function __construct(){
            $this->db_conn = get_db_connection();
        }

        public function get_staff($staffid){
            $this->query_db_staff($staffid);
        }

        public function get_all_staff(){
            $this->query_db_staff();
        }
        
        private function query_db_staff($staffid=null){

            if(is_null($staffid)){
                $stmt = $this->db_conn->prepare("SELECT * FROM `staff`");
            
                if ($stmt->execute()) {

                    $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'Staff');

                    echo json_encode($result->UserName);

                    /*
                    foreach($result as $user){
                        echo json_encode($user);
                    }
                    */
                }
            }else{
                $stmt = $this->db_conn->prepare("SELECT * FROM `staff` WHERE `staffID` = ?");

                if ($stmt->execute(array($staffid))) {
                    $row = $stmt->fetch();
                    var_dump($row);
                }
            }
        }
    }
?>