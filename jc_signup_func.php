<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/Signup.php';

function createSignup(Signup $s) {
	//cal_id + cal_login is primary key
	$sql = 'INSERT INTO webcal_entry_user (cal_id, cal_login, cal_status, cal_category, cal_percent, count) 
			VALUES (?,?,?,?,?,?)';
	dbi_execute($sql, array($s->timeslotID, $s->userID, $s->status, $s->category, $s->percent, $s->count));

	dbi_clear_cache();
}

function updateSignup(Signup $s) {
	//cal_id + cal_login is primary key
	$sql = 'UPDATE webcal_entry_user SET cal_status=?, cal_category=?, cal_percent=?, count=? 
			WHERE cal_id=? AND cal_login=?';
	dbi_execute($sql, array($s->status, $s->category, $s->percent, $s->count, $s->timeslotID, $s->userID));

	dbi_clear_cache();
}

function deleteSignup(Signup $s) {
	$sql = 'DELETE FROM webcal_entry_user WHERE cal_id=? AND cal_login=?';
	dbi_execute($sql, array($s->timeslotID, $s->userID));

	dbi_clear_cache();
}

function listJobUserSignups($job_id, $user_id) {
	$sql = 'SELECT weu.cal_id, weu.cal_login, weu.cal_status, weu.cal_category, weu.cal_percent, weu.count  
			FROM webcal_entry we, webcal_entry_user weu
			WHERE weu.cal_id=we.cal_id AND we.job_id=? AND weu.cal_login=? AND count IS NOT NULL
			ORDER BY weu.cal_id';
	$rows = dbi_get_cached_rows($sql, array($job_id, $user_id));
	
	$signupArr = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];		
		$s = new Signup($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
		$signupArr[$row[0]] = $s; //use timeslot_id as array keys
	}
	
	return $signupArr;
}

function listJobSignups($job_id) {
	$sql = 'SELECT weu.cal_id, cal_login, cal_status, cal_category, cal_percent, count  
			FROM webcal_entry_user weu, webcal_entry we 
			WHERE we.cal_id=weu.cal_id AND we.job_id=? AND count IS NOT NULL
			ORDER BY weu.cal_id';
	$rows = dbi_get_cached_rows($sql, array($job_id));
	
	$signupArr = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];		
		$s = new Signup($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
		$signupArr[] = $s;
	}
	
	return $signupArr;
}

function listTimeslotSignups($timeslot_id) {
	$sql = 'SELECT cal_id, cal_login, cal_status, cal_category, cal_percent, count  
			FROM webcal_entry 
			WHERE cal_id=?
			ORDER BY cal_id';
	$rows = dbi_get_cached_rows($sql, array($job_id));
	
	$signupArr = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];		
		$s = new Signup($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
		$signupArr[] = $s;
	}
	
	return $signupArr;
}

function listUserSignups($user_id) {
	$sql = 'SELECT cal_id, cal_login, cal_status, cal_category, cal_percent, count  
			FROM webcal_entry 
			WHERE cal_login=?
			ORDER BY cal_login';
	$rows = dbi_get_cached_rows($sql, array($user_id));
	
	$signupArr = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];		
		$s = new Signup($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
		$signupArr[] = $s;
	}
	
	return $signupArr;
}

function getSignup($timeslot_id, $user_id) {
	$sql = 'SELECT cal_id, cal_login, cal_status, cal_category, cal_percent, count 
			FROM webcal_entry_user WHERE cal_id=? AND cal_login=?';
	$rows = dbi_get_cached_rows($sql, array($timeslot_id, $user_id));
	
	$s = null;
	if(count($rows) == 1) { 
		$row = $rows[0];
		$s = new Signup($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
	}
	
	return $s;
}

function createOrUpdateSignup(Signup $s) {
	if (existSignup($s->timeslotID, $s->userID)) {
		updateSignup($s);
	} else {
		if (!empty($s->count)) {
			createSignup($s);
		}
	}
}

function existSignup($timeslot_id, $user_id) {
	$sql = 'SELECT COUNT(cal_id) FROM webcal_entry_user WHERE cal_id=? AND cal_login=?';
	$rows = dbi_get_cached_rows($sql, array($timeslot_id, $user_id));
	
	if($rows[0][0] > 0) { 
		return true;
	} else {
		return false;		
	}
}

?>