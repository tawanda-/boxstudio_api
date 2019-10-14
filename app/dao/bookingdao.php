<?php
    require_once(dirname(__DIR__)."/config/db.php");

    // `email`, `phone`, `activity`, `additional_notes` FROM `booking_requests` WHERE 1

    class BookingDao{

        private $db_conn;

        public function __construct(){
            $this->db_conn = get_db_connection();
        }

        public function bookingRequest($booking){

            if($this->validate($booking) === false){
                return false;
            }

            $sql = "INSERT INTO booking_requests (`email`, `phone`, `activity`, `additional_notes`) VALUES (?,?,?,?)";

            $stmt= $this->db_conn->prepare($sql);

            $data = [
                $booking['email'],$booking['phone'],$booking['activity'],$booking['additional_notes']
            ];
            
            if($stmt->execute($data)){
                return true;
            }
            return false;
        }

        public function sendEmail($booking){

            if($this->validate($booking) === false){
                return false;
            }

            $to = "tsikayitaffy@gmail.com, tmuhwati@gmail.com";
            $subject = "Booking request";
            $body = "A booking request hss been with the following details\n
            email: ".$booking["email"]."\n
            phone number: ".$booking["phone"]."\n
            activities: ".$booking["activity"]."\n
            additional notes: ".$booking["additional_notes"]."\n
            Regards \n
            Box Studio Android App";
            $headers = "From: android.app@boxstudio.esikolweni.co.za";

            mail($to,$subject,$body,$headers);

            return true;
        }

        private function validate($booking){

            if(empty($booking['email']) || empty($booking['phone']) || empty($booking['activity'])){
                return false;
            }

            return true;

        }
    }

?>