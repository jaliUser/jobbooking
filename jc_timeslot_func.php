<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/Timeslot.php';

function createTimeslot(Timeslot $t) {
	global $login;
	$id = 0;
	$res = dbi_execute ( 'SELECT MAX(cal_id) FROM webcal_entry' );
    if ( $res ) {
      $row = dbi_fetch_row ( $res );
      $id = $row[0] + 1;
      dbi_free_result ( $res );
    } else {
      $id = 1;
    }
	
	//auto-increment id
	$sql = 'INSERT INTO webcal_entry (cal_id, cal_date, cal_time, cal_duration, job_id, person_need, cal_create_by, cal_name) VALUES (?,?,?,?,?,?,?,?)';
	dbi_execute($sql, array($id, $t->date, $t->startTime, $t->duration, $t->jobID, $t->personNeed, $login, "autogen"));

	dbi_clear_cache();
	//	return $id;
}

function updateTimeslot(Timeslot $t) {
	$sql = 'UPDATE webcal_entry SET cal_date, cal_time, cal_duration, job_id, person_need WHERE cal_id=?';
	dbi_execute($sql, array($t->date, $t->startTime, $t->duration, $t->jobID, $t->personNeed, $t->id));	

	dbi_clear_cache();
}

function updateTimeslotNeed($timeslot_id, $person_need) {
	if (is_numeric($person_need) && intval($person_need) > 0) {
		$sql = 'UPDATE webcal_entry SET person_need=? WHERE cal_id=?';
		dbi_execute($sql, array($person_need, $timeslot_id));
	} else {
		$sql = 'UPDATE webcal_entry SET person_need=NULL WHERE cal_id=?';
		dbi_execute($sql, array($timeslot_id));
	}
	dbi_clear_cache();
}

function deleteTimeslot(Timeslot $t) {
	$sql = 'DELETE FROM webcal_entry WHERE cal_id=?';
	dbi_execute($sql, array($t->id));

	dbi_clear_cache();
}

function listTimeslots($job_id) {
	$sql = 'SELECT cal_id, cal_date, cal_time, cal_duration, job_id, person_need  
			FROM webcal_entry WHERE job_id=? 
			ORDER BY cal_time, cal_duration, cal_date';
	$rows = dbi_get_cached_rows($sql, array($job_id));
	
	$tsArr = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];		
		$t = new Timeslot($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
		$tsArr[] = $t;
	}
	
	return $tsArr;
}

function getTimeslot($timeslot_id) {
	$sql = 'SELECT cal_id, cal_date, cal_time, cal_duration, job_id, person_need FROM webcal_entry WHERE cal_id=?';
	$rows = dbi_get_cached_rows($sql, array($timeslot_id));
	
	$t = null;
	if(count($rows) == 1) { 
		$row = $rows[0];
		$t = new Timeslot($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
	}
	
	return $t;
}

function isDuplicateTimeslot(Timeslot $t) {
	$sql = 'SELECT COUNT(cal_id) FROM webcal_entry WHERE job_id=? AND cal_date=? AND cal_time=? AND cal_duration=?';
	$rows = dbi_get_cached_rows($sql, array($t->jobID, $t->date, $t->startTime, $t->duration));
	
	if($rows[0][0] > 0) { 
		return true;
	} else {
		return false;		
	}
}

?>
