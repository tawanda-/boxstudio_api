<?php

    require_once(dirname(__DIR__)."/config/db.php");

    /**
     * `memberID`, `memberName`, `memberSurname`, `membershipID`, `memberContact`, `memberEmail`, `memberAddress`, `memberGender`, `approved_YN`, `memberDOB`, `approvedBy`, `approvalDate`, `deleted_YN`
     */

    class AuthDao{

        private $db_conn;

        public function __construct(){
            $this->db_conn = get_db_connection();
        }

        public function login($memberEmail, $password){

            if(isset($memberEmail) && !empty($memberEmail) && isset($password) && !empty($password) ){

                $sql = $this->db_conn->prepare("SELECT * FROM `members` WHERE `memberEmail` = ?");

                if ($sql->execute(array($memberEmail))) {
                    $res = $sql->fetch();
                    if(password_verify($password, $res["password"])){
                        return $res;
                    }else{
                        return ["error"];
                    }
                }
            }else{
                return ["error"];
            }
        }

        public function register($memberDetails){

            if(!isset($memberDetails) || empty($memberDetails)){
                return ["missing fields 1"];
            }

            if( empty($memberDetails["memberID"]) || empty($memberDetails["memberEmail"]) || empty($memberDetails["password"]) ){
                return ["missing fields 2"];
            }

            if($this->checkMember($memberDetails["memberID"], $memberDetails["memberEmail"]) === true){ //memberid found in db or problem
                return ["user already exists"];
            }

            $password =  password_hash($memberDetails['password'], PASSWORD_DEFAULT);

            /*
            $data = [
                $memberDetails['memberID'],$memberDetails['memberName'],$memberDetails['memberSurname'],$memberDetails['membershipID'],
                $memberDetails['memberContact'],$memberDetails['memberEmail'],$memberDetails['memberAddress'],$memberDetails['memberGender'],
                $memberDetails['approved_YN'],$memberDetails['memberDOB'],$memberDetails['approvedBy'],$memberDetails['approvalDate'],
                $memberDetails['deleted_YN'],$memberDetails['dateDeleted_D'],$memberDetails['deletedBy_C'],$password,
            ];
            */

            $data = [
                $memberDetails['memberID'],$memberDetails['memberName'],$memberDetails['memberSurname'],$memberDetails['membershipID'],"",$memberDetails['memberEmail'],"","","","","","","","","",$password
            ];


            $sql = "INSERT INTO members (`memberID`, `memberName`, `memberSurname`, `membershipID`, `memberContact`, `memberEmail`, `memberAddress`, `memberGender`, `approved_YN`, `memberDOB`, `approvedBy`, `approvalDate`, `deleted_YN`, `dateDeleted_D`, `deletedBy_C`, `password`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $stmt= $this->db_conn->prepare($sql);
            
            if($stmt->execute($data)){
                $sql = $this->db_conn->prepare("SELECT * FROM `members` WHERE `memberID` = ? OR `memberEmail` = ?");
                if ($sql->execute( array($memberDetails['memberID'], $memberDetails['memberEmail']))) {
                    $res= $sql->fetch();
                    return $res;
                }else{
                    return ["error"];
                }
            }else{
                return ["error"];
            }
        }

        private function checkMember($memberId, $memberEmail){

            if(!isset($memberId) || empty($memberId) || !isset($memberEmail) || empty($memberEmail)){
                return true;
            }

            $sql = $this->db_conn->prepare("SELECT * FROM `members` WHERE `memberID` = ? OR `memberEmail` = ?");

            if ($sql->execute( array($memberId, $memberEmail))) {
                $res= $sql->fetchAll();
                //$number_of_rows = $res->fetchColumn();
                if(count($res) > 0){
                    return true; //found
                }else{
                    return false; //not found
                }
            }

            return true; 
        }
    }
?>