<?php

class Day {
	var $id;
	var $siteID;
	var $date;

	function Day($id, $siteID, $date) {
		$this->id = $id;
		$this->site_id = $siteID;
		$this->date = $date;
	}

	static function cast(Day $day) {
		return $day;
	}
	
	function getDateYMD() {
		return date("Ymd", $this->getDateTS());
	}
	
	function getDateTS() {
		return strtotime($this->date);
	}
	
}

?>