<?php

class Group {
	var $id;
	var $siteID;
	var $name;
	var $districtID;
	
	function Group($id, $siteID, $name, $districtID) {
		$this->id = $id;
		$this->siteID = $siteID;
		$this->name = $name;
		$this->districtID = $districtID;
	}

	static function cast(Group $group) {
		return $group;
	}
	
}

?>