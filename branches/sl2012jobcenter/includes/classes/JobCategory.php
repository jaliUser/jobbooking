<?php

class JobCategory {
	var $id;
	var $name;
	var $siteID;

	function JobCategory($id, $name, $siteID) {
		$this->id = $id;
		$this->name = $name;
		$this->siteID = $siteID;
	}

	static function cast(JobCategory $jobCategory) {
		return $jobCategory;
	}
	
}

?>