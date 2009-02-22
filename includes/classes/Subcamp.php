<?php

class Subcamp {
	var $id;
	var $siteID;
	var $name;
	var $districtID;
	
	function Subcamp($id, $siteID, $name, $districtID) {
		$this->id = $id;
		$this->siteID = $siteID;
		$this->name = $name;
		$this->districtID = $districtID;
	}

	static function cast(Subcamp $subcamp) {
		return $subcamp;
	}

}

?>