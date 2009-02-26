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

	function Job($id, $siteID, $areaID, $ownerID, $name, $description, $place, $notes, $status) {
		$this->id = $id;
		$this->siteID = $siteID;
		$this->areaID = $areaID;
		$this->ownerID = $ownerID;
		$this->name = $name;
		$this->description = $description;
		$this->place = $place;
		$this->notes = $notes;
		$this->status = $status;
	}

	static function cast(Job $job) {
		return $job;
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