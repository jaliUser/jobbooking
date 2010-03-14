<?php

class Area {
	var $id;
	var $siteID;
	var $name;
	var $description;
	var $contactID;
	
	function Area($id, $siteID, $name, $description, $contactID) {
		$this->id = $id;
		$this->siteID = $siteID;
		$this->name = $name;
		$this->description = $description;
		$this->contactID = $contactID;
	}

	static function cast(Area $area) {
		return $area;
	}
	
}

?>