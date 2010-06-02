<?php

class Job {
	var $id;
	var $siteID;
	var $areaID;
	var $ownerID;
	var $name;
	var $description;
	var $meetplace;
	var $jobplace;
	var $notes;
	var $status;
	var $priority;
	var $type;
	var $totalNeed; //not in DB
	var $remainingNeed; //not in DB
	var $totalHours; //not in DB
	var $remainingHours; //not in DB
	var $defDate;
	var $defUser;
	var $updDate;
	var $updUser;

	function Job($id, $siteID, $areaID, $ownerID, $name, $description, $meetplace, $jobplace, $notes, $status, $priority, $type) {
		$this->id = $id;
		$this->siteID = $siteID;
		$this->areaID = $areaID;
		$this->ownerID = $ownerID;
		$this->name = $name;
		$this->description = $description;
		$this->meetplace = $meetplace;
		$this->jobplace = $jobplace;
		$this->notes = $notes;
		$this->status = $status;
		$this->priority = $priority;
		$this->type = $type;
	}

	static function cast(Job $job) {
		return $job;
	}
	
	function getLongStatus() {
		switch($this->status) {
			case 'A':
				return 'Godkendt';
			case 'W':
				return 'Afventer';
			case 'D':
				return 'Slettet'; 
		}
	}
	
	function getShortStatus() {
		switch($this->status) {
			case 'A':
				return 'G';
			case 'W':
				return 'A';
			case 'D':
				return 'S'; 
		}
	}
	
	static function jobStatus($status) {
		switch($status) {
			case 'A':
				return 'Godkendt';
			case 'W':
				return 'Afventer';
			case 'D':
				return 'Slettet'; 
		}
	}

    static function jobType($type) {
		switch($type) {
			case 'NN': //No Need
				return 'Underlejr (uden behov)';
			case 'WN': //With Need
				return 'Normal (med behov)';
		}
	}
	
}

?>