<?php
    require_once("db.php");
    
    class staff{
        var $id;
        var $username;
        var $name;
        var $surname;
        var $position;
        var $contact;
        var $email;
        var $address;
        private $db_conn;
        
        public function __construct() {
            $this->db_conn = get_db_connection();
        }
        
        public function get_staff($staffid){
            $this->query_db_staff($staffid);
        }
        
        private function query_db_staff($staffid){
            $stmt = $this->db_conn->prepare("SELECT * FROM `staff` WHERE `staffID` = ?");
            if ($stmt->execute(array($staffid))) {
                $row = $stmt->fetch();
                $this->id = $row["staffID"];
                $this->username = $row["UserName"];
                $this->name = $row["staffName"];
                $this->surname = $row["staffSurname"];
                $this->position = $row["positionID"];
                $this->contact = $row["staffContact"];
                $this->email = $row["staffEmail"];
                $this->address = $row["staffAddress"];
            }
        }
        
        public function get_staff_id(){
            return $this->staff_id;
        }
        
        public function get_staff_username(){
            return $this->staff_username;
        }
        
        public function get_staff_name(){
            return $this->staff_name;
        }
        public function get_staff_surname(){
            return $this->staff_surname;
        }
        
        public function get_staff_position(){
            return $this->staff_position;
        }
        
        public function get_staff_contact(){
            return $this->staff_contact;
        }
        
        public function get_staff_email(){
            return $this->staff_email;
        }
        
        public function get_staff_address(){
            return $this->staff_address;
        }
        
        public function toString(){
            
        }
    }
    
?>