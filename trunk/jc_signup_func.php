<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/Signup.php';

function createSignup(Signup $s) {
	//cal_id + cal_login is primary key
	$sql = 'INSERT INTO webcal_entry_user (cal_id, cal_login, cal_status, cal_category, cal_percent, count, notes) 
			VALUES (?,?,?,?,?,?,?)';
	dbi_execute($sql, array($s->timeslotID, $s->userID, $s->status, $s->category, $s->percent, $s->count, $s->notes));

	dbi_clear_cache();
}

function updateSignup(Signup $s) {
	//cal_id + cal_login is primary key
	$sql = 'UPDATE webcal_entry_user SET cal_status=?, cal_category=?, cal_percent=?, count=?, notes=? 
			WHERE cal_id=? AND cal_login=?';
	dbi_execute($sql, array($s->status, $s->category, $s->percent, $s->count, $s->notes, $s->timeslotID, $s->userID));

	dbi_clear_cache();
}

function deleteSignup(Signup $s) {
	$sql = 'DELETE FROM webcal_entry_user WHERE cal_id=? AND cal_login=?';
	dbi_execute($sql, array($s->timeslotID, $s->userID));

	dbi_clear_cache();
}

function signupsContainsTimeslot($signups, $timeslotID) {
	foreach ($signups as $signup) {
		$signup = Signup::cast($signup);
		if ($signup->timeslotID == $timeslotID) {
			return true;
		}
	}
	return false;
}

function listJobUserSignups($job_id, $user_id) {
	$sql = 'SELECT weu.cal_id, weu.cal_login, weu.cal_status, weu.cal_category, weu.cal_percent, weu.count, weu.notes  
			FROM webcal_entry we, webcal_entry_user weu
			WHERE weu.cal_id=we.cal_id AND we.job_id=? AND weu.cal_login=? AND count IS NOT NULL
			ORDER BY weu.cal_id';
	$rows = dbi_get_cached_rows($sql, array($job_id, $user_id));
	
	$signupArr = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];		
		$s = new Signup($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
		$signupArr[$row[0]] = $s; //use timeslot_id as array keys
	}
	
	return $signupArr;
}

function listJobSignups($job_id) {
	$sql = 'SELECT weu.cal_id, cal_login, cal_status, cal_category, cal_percent, count, notes  
			FROM webcal_entry_user weu, webcal_entry we 
			WHERE we.cal_id=weu.cal_id AND we.job_id=? AND count IS NOT NULL
			ORDER BY weu.cal_id';
	$rows = dbi_get_cached_rows($sql, array($job_id));
	
	$signupArr = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];		
		$s = new Signup($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
		$signupArr[] = $s;
	}
	
	return $signupArr;
}

function listTimeslotSignups($timeslot_id) {
	$sql = 'SELECT cal_id, cal_login, cal_status, cal_category, cal_percent, count, notes
			FROM webcal_entry_user 
			WHERE cal_id=?';
	$rows = dbi_get_cached_rows($sql, array($timeslot_id));

	$signupArr = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];		
		$s = new Signup($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
		$signupArr[] = $s;
	}
	
	return $signupArr;
}

function listUserSignups($user_id, $show_negative=false) {
	$sql = 'SELECT s.cal_id, s.cal_login, s.cal_status, s.cal_category, s.cal_percent, s.count, s.notes
			FROM webcal_entry_user s, webcal_entry e, job j 
			WHERE s.cal_login=?
			AND s.cal_id=e.cal_id AND j.id=e.job_id AND j.id '.($show_negative==true? '<0' : '>0').'
			ORDER BY e.cal_date, e.cal_time';
	$rows = dbi_get_cached_rows($sql, array($user_id));
	
	$signupArr = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];		
		$s = new Signup($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
		$signupArr[] = $s;
	}
	
	return $signupArr;
}

function getSignup($timeslot_id, $user_id) {
	$sql = 'SELECT cal_id, cal_login, cal_status, cal_category, cal_percent, count, notes
			FROM webcal_entry_user WHERE cal_id=? AND cal_login=?';
	$rows = dbi_get_cached_rows($sql, array($timeslot_id, $user_id));
	
	$s = null;
	if(count($rows) == 1) { 
		$row = $rows[0];
		$s = new Signup($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
	}
	
	return $s;
}

function createUpdateDeleteSignup(Signup $s) {
	if (existSignup($s->timeslotID, $s->userID)) {
		if (!empty($s->count)) {
			updateSignup($s);
		} else {
			deleteSignup($s); //TODO: disable signup instead
		}
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

function isUserFree($login, Timeslot $timeslot) {
	$sql = 'SELECT COUNT(webcal_entry.cal_id) FROM webcal_entry, webcal_entry_user' .
			' WHERE webcal_entry.cal_id=webcal_entry_user.cal_id' .
			' AND cal_login=?' .
			' AND cal_date=?' .
			' AND cal_status="A"' . //entries stay in webcal_entry_user with status=D when deleted
			//' AND webcal_entry_user.count' .
			' AND (' .
			'    (cal_time<? AND (cal_time+(cal_duration %60)*100+FLOOR(cal_duration/60)*10000) >?)' . //cal_starttime <= Q_start <= cal_endtime
			' OR (cal_time<? AND (cal_time+(cal_duration %60)*100+FLOOR(cal_duration/60)*10000) >?)' . //cal_starttime <= Q_end <= cal_endtime
			' OR (cal_time>=? AND cal_time<?)' . //Q_start <= cal_starttime <= Q_end
			' )';
	$rows = dbi_get_cached_rows($sql, array($login, $timeslot->date, $timeslot->startTime, $timeslot->startTime, $timeslot->getEndTime(), $timeslot->getEndTime(), $timeslot->starttime, $timeslot->getEndTime()));
	//echo $sql.",". $login .",". $timeslot->date .",". $timeslot->startTime .",". $timeslot->startTime .",". $timeslot->getEndTime() .",". $timeslot->getEndTime() .",". $timeslot->starttime .",". $timeslot->getEndTime() . "<br><br>\r\n";

	if ($rows[0][0] > 0) {
		return false;
	}
	return true;
}

?>