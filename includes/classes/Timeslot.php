<?php

class Timeslot {
	var $id;
	var $date;
	var $startTime;
	//var $endTime;
	var $duration;
	var $jobID;
	var $personNeed;

	function Timeslot($id, $date, $startTime, $duration, $jobID, $personNeed) {
		$this->id = $id;
		$this->date = $date;
		$this->startTime = $startTime;
		$this->duration = $duration;
		$this->jobID = $jobID;
		$this->personNeed = $personNeed;
	}

	static function cast(Timeslot $timeslot) {
		return $timeslot;
	}
	
	function getEndTime() {
		$startTS = get_cal_unixtime($this->date, $this->startTime); 
		return gmdate("His", $startTS + $this->duration*60);
	}
	
	static function getDuration($date, $startTime, $endTime) {
		return (get_cal_unixtime($date, $endTime) - get_cal_unixtime($date, $startTime))/60;
	}
	
	function getStartHour() {
		return substr($this->startTime,0,-4);
	}
	
	function getStartMin() {
		return substr($this->startTime,-4,-2);
	}
	
	function getEndHour() {
		return substr($this->getEndTime(),0,-4);
	}
	
	function getEndMin() {
		return substr($this->getEndTime(),-4,-2);
	}
	
//	function setEndTime($duration) {
//		$startTS = get_cal_unixtime($this->date, $this->startTime);
//		$endTS = $startTS + $duration*60;
//		$this->endTime = date("His", $endTS); 
//	}
}

?>