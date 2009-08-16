<?php

class Timeslot {
	var $id;
	var $date;
	var $startTime;
	//var $endTime;
	var $duration;
	var $jobID;
	var $personNeed;
	var $contactID;
	var $remainingNeed; //calcualted (not in DB)

	function Timeslot($id, $date, $startTime, $duration, $jobID, $personNeed, $contactID) {
		$this->id = $id;
		$this->date = $date;
		$this->startTime = $startTime;
		$this->duration = $duration;
		$this->jobID = $jobID;
		$this->contactID = $contactID;
		if (!empty($personNeed)) {
			$this->personNeed = $personNeed; //dont initialise empty value (dbi4php will fail) 
		}
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
		$hour = substr($this->startTime,0,-4);
		if(empty($hour)) {
			return '00';
		} else {
			return $hour;
		}
	}
	
	function getStartMin() {
		$min = substr($this->startTime,-4,-2);
		if(empty($min)) {
			return '00';
		} else {
			return $min;
		}
	}
	
	function getEndHour() {
		$hour = substr($this->getEndTime(),0,-4);
		if(empty($hour)) {
			return '00';
		} else {
			return $hour;
		}
	}
	
	function getEndMin() {
		$min = substr($this->getEndTime(),-4,-2);
		if(empty($min)) {
			return '00';
		} else {
			return $min;
		}
	}
	
	function getStartTS() {
		$hour = ($this->startTime == 0) ? 0 : substr($this->startTime,0,-4);
		$min = ($this->startTime == 0) ? 0 : substr($this->startTime,-4,-2);
		$sec = ($this->startTime == 0) ? 0 : substr($this->startTime,-2);
		$month = substr($this->date,4,2);
		$day = substr($this->date,6,2);
		$year = substr($this->date,0,4);
		return mktime($hour, $min, $sec, $month, $day, $year);
	}
	
	function getEndTS() {
		$endTime = $this->getEndTime();
		$hour = ($endTime == 0) ? 0 : substr($endTime,0,-4);
		$min = ($endTime == 0) ? 0 : substr($endTime,-4,-2);
		$sec = ($endTime == 0) ? 0 : substr($endTime,-2);
		$month = substr($this->date,4,2);
		$day = substr($this->date,6,2);
		$year = substr($this->date,0,4);
		return mktime($hour, $min, $sec, $month, $day, $year);
	}
		
	static function isValidPersonNeed($personNeed) {
		if ((!empty($personNeed) && !is_numeric($personNeed)) || $personNeed < 0) {
			return false;
		} else {
			return true;
		}
	}
	
//	function setEndTime($duration) {
//		$startTS = get_cal_unixtime($this->date, $this->startTime);
//		$endTS = $startTS + $duration*60;
//		$this->endTime = date("His", $endTS); 
//	}
}

?>