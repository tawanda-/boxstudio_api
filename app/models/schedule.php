<?php
    
    include 'activity.php';
    include 'facility.php';
    include 'staff.php';
    
    class schedule{
        var $id;
        var $venue;
        var $start_time;
        var $end_time;
        var $instructor;
        var $activity;
        
        public function __constructor(){
        }
        
        public function update($param){
            $this->set_id($param['scheduleID']);
            $this->set_venue($param['FacilityNum']);
            $this->set_start_time($param['scheduleTime']);
            $this->set_end_time($param['ScheduleEndTime']);
            $this->set_activity($param['actvityID']);
            $this->set_instructor($param['staffID']);
        }
        
        private function set_id($a_id){
            $this->id = $a_id;
        }
        
        private function set_venue($a_venue){
            $facility = new Facility();
            $facility->get_facility($a_venue);
            $this->venue = $facility;
        }
        
        private function set_start_time($a_time){
            $this->start_time = $a_time;
        }
        
        private function set_end_time($a_time){
            $this->end_time = $a_time;
        }
        
        private function set_instructor($a_instructor){
            $staff = new Staff();
            $staff->get_staff($a_instructor);
            $this->instructor = $staff;
        }
        
        private function set_activity($a_activity){
            $activity = new Activity();
            $activity->get_activity($a_activity);
            $this->activity = $activity;
        }
    }
?>