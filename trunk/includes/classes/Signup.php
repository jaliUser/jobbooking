<?php

class Signup {
	var $timeslotID;
	var $userID;
	var $status;
	var $category;
	var $percent;
	var $count;
	var $notes;
	var $defDate;
	var $defUser;
	var $updDate;
	var $updUser;

	function signup($timeslotID, $userID, $status, $category, $percent, $count, $notes) {
		$this->timeslotID = $timeslotID;
		$this->userID = $userID;
		$this->status = $status;
		$this->category = $category;
		$this->percent = $percent;
		//$this->notes = $notes;
		if (!empty($notes)) {
			$this->notes = $notes; //dont initialise empty value (dbi4php will write empty string instead of NULL to DB)
		}
		if (!empty($count)) {
			$this->count = $count; //dont initialise empty value (dbi4php will fail)
		}
	}

	static function cast(Signup $signup) {
		return $signup;
	}
	
	static function isValidCount($count) {
		if ((!empty($count) && !is_numeric($count)) || $count < 0) {
			return false;
		} else {
			return true;
		}
	}
}

?>