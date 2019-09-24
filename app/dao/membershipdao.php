<?php

    require_once(dirname(__DIR__)."/config/db.php");
    include(dirname(__DIR__)."/models/member.php");
    include(dirname(__DIR__)."/models/membership.php");

    class MembershipDAO{

        private $db_conn;

        public function __construct(){
            $this->db_conn = get_db_connection();
        }

        public function get_membership($membership_id){
            $this->query_db_membership($membership_id);
        }

        public function get_membership_by_memberid($member_id){
            $stmt = $this->db_conn->prepare(
                "SELECT * FROM membership AS m_ship
                INNER JOIN members AS member on m_ship.memberID = member.memberID 
                INNER JOIN membership_type AS m_type on m_ship.membershipTypeId = m_type.membershipTypeId
                WHERE `memberID` = ?"
            );

            if ($stmt->execute(array($member_id))) {
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $result = $stmt->fetch();
                echo json_encode($result);
            }
        }

        public function get_all_memberships(){
            $this->query_db_membership();
        }

        private function query_db_membership($membership_id=null){

            if(is_null($membership_id)){

                $stmt = $this->db_conn->prepare("
                    SELECT * FROM membership AS m_ship
                    INNER JOIN members AS member on  m_ship.memberID = member.memberID
                    INNER JOIN membership_type AS m_type on m_ship.membershipTypeId = m_type.membershipTypeId
                ");
            
                if ($stmt->execute()) {

                    $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'membership');

                    echo json_encode($result);
                }
            }else{
                
                $stmt = $this->db_conn->prepare(
                    "SELECT * FROM membership AS m_ship
                    INNER JOIN members AS member on  m_ship.memberID = member.memberID
                    INNER JOIN membership_type AS m_type on m_ship.membershipTypeId = m_type.membershipTypeId
                    WHERE membershipId = ?"
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