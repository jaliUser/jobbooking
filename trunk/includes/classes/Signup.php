<?php

class Signup {
	var $timeslotID;
	var $userID;
	var $status;
	var $category;
	var $percent;
	var $count;

	function signup($timeslotID, $userID, $status, $category, $percent, $count) {
		$this->timeslotID = $timeslotID;
		$this->userID = $userID;
		$this->status = $status;
		$this->category = $category;
		$this->percent = $percent;
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