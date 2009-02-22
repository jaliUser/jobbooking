<?php

class District {
	var $id;
	var $siteID;
	var $name;
	
	function District($id, $siteID, $name) {
		$this->id = $id;
		$this->siteID = $siteID;
		$this->name = $name;
	}

	static function cast(District $district) {
		return $district;
	}
	
}

?>