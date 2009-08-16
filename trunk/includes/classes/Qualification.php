<?php

class Qualification {
	var $id;
	var $name;
	var $siteID;

	function Qualification($id, $name, $siteID) {
		$this->id = $id;
		$this->name = $name;
		$this->siteID = $siteID;
	}

	static function cast(Qualification $qualification) {
		return $qualification;
	}
	
}

?>