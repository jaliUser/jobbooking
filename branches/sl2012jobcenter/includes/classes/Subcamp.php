<?php

class Subcamp {
	var $id;
	var $siteID;
	var $name;
	var $contactID;
	
	function Subcamp($id, $siteID, $name, $contactID) {
		$this->id = $id;
		$this->siteID = $siteID;
		$this->name = $name;
		$this->contactID = $contactID;
	}

	static function cast(Subcamp $subcamp) {
		return $subcamp;
	}

	function getShortName() {
		return substr($this->name, 0, 3);
	}
}

?>