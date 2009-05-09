<?php

class Subcamp {
	var $id;
	var $siteID;
	var $name;
	
	function Subcamp($id, $siteID, $name) {
		$this->id = $id;
		$this->siteID = $siteID;
		$this->name = $name;
	}

	static function cast(Subcamp $subcamp) {
		return $subcamp;
	}

}

?>