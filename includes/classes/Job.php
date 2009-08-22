<?php

class Job {
	var $id;
	var $siteID;
	var $areaID;
	var $ownerID;
	var $name;
	var $description;
	var $place;
	var $notes;
	var $status;
	var $priority;

	function Job($id, $siteID, $areaID, $ownerID, $name, $description, $place, $notes, $status, $priority) {
		$this->id = $id;
		$this->siteID = $siteID;
		$this->areaID = $areaID;
		$this->ownerID = $ownerID;
		$this->name = $name;
		$this->description = $description;
		$this->place = $place;
		$this->notes = $notes;
		$this->status = $status;
		$this->priority = $priority;
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
/*	
	function getID() {
		return $this->id;
	}
	
	function getSiteID() {
		return $this->siteID;
	}
	
	function getAreaID() {
		return $this->areaID;
	}
	
	function getOwnerID() {
		return $this->ownerID;
	}
	
	function getName() {
		return $this->name;
	}
	
	function getDescription() {
		return $this->description;
	}
	
	function getPlace() {
		return $this->place;
	}
	
	function getNotes() {
		return $this->notes;
	}
*/	
}

?>