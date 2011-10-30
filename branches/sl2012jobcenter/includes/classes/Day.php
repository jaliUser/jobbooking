<?php

class Day {
	var $id;
	var $siteID;
	var $date;
	var $time;

	function Day($id, $siteID, $date, $time) {
		$this->id = $id;
		$this->site_id = $siteID;
		$this->date = $date;
		$this->time = $time;
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
	
	function getTimeHM() {		 
		$tmp = get_cal_unixtime($this->getDateYMD(), $this->time);
		return gmdate("H:i", $tmp);
	}
	
}

?>