<?php

class District {
	var $id;
	var $siteID;
	var $name;
	var $subcampID;
	
	function District($id, $siteID, $name, $subcampID) {
		$this->id = $id;
		$this->siteID = $siteID;
		$this->name = $name;
		$this->subcampID = $subcampID;
	}

	static function cast(District $district) {
		return $district;
	}
	
}

?>