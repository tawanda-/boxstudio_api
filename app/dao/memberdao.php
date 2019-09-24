<?php

    require_once(dirname(__DIR__)."/config/db.php");
    include(dirname(__DIR__)."/models/member.php");
    include(dirname(__DIR__)."/models/membership.php");

    class MemberDAO{

        private $db_conn;

        public function __construct(){
            $this->db_conn = get_db_connection();
        }

        public function get_member($member_id){
            $this->query_db_member($member_id);
        }

        public function get_member_by_membershipid($membership_id){
            $this->query_db_membershipid($membership_id);
        }

        public function get_all_members(){
            $this->query_db_member();
        }

        private function query_db_member($member_id=null){

            if(is_null($member_id)){

                $stmt = $this->db_conn->prepare("SELECT * FROM `members`");
            
                if ($stmt->execute()) {

                    $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'member');

                    echo json_encode($result);
                }
            }else{
                
                $stmt = $this->db_conn->prepare(
                    "SELECT * FROM members WHERE `id` = ?"
                );

                if ($stmt->execute(array($member_id))) {
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $stmt->fetch();
                    echo json_encode($result);
                }
            }
        }

        private function query_db_membershipid($membership_id){
            if(is_null($membership_id)){
                echo json_encode('Oops');
            }else{
                $stmt = $this->db_conn->prepare(
                    "SELECT * FROM membership AS m_ship
                    INNER JOIN members AS member on m_ship.memberID = member.memberID 
                    INNER JOIN membership_type AS m_type on m_ship.membershipTypeId = m_type.membershipTypeId
                    WHERE `membershipID` = ?"
                );

                if ($stmt->execute(array($membership_id))) {
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $stmt->fetch();
                    echo json_encode($result);
                }
            }
        }
    }
?>