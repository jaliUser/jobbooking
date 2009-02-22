<?php

class Area {
	var $id;
	var $siteID;
	var $name;
	var $description;
	
	function Area($id, $siteID, $name, $description) {
		$this->id = $id;
		$this->siteID = $siteID;
		$this->name = $name;
		$this->description = $description;
	}

	static function cast(Area $area) {
		return $area;
	}
	
}

?>