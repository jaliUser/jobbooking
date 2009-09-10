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
	$sql = "INSERT INTO webcal_entry (cal_id, cal_date, cal_time, cal_duration, job_id, person_need, cal_create_by, cal_name, contact_id, def_date, def_user, upd_user) 
			VALUES (?,?,?,?,?,?,?,?,?,now(),'$login','$login')";
	dbi_execute($sql, array($id, $t->date, $t->startTime, $t->duration, $t->jobID, $t->personNeed, $login, "autogen", $t->contactID));

	dbi_clear_cache();
	//	return $id;
}

function updateTimeslot(Timeslot $t) {
	global $login;
	$sql = "UPDATE webcal_entry SET cal_date, cal_time, cal_duration, job_id, person_need, contact_id, upd_user='$login' WHERE cal_id=?";
	dbi_execute($sql, array($t->date, $t->startTime, $t->duration, $t->jobID, $t->personNeed, $t->contactID, $t->id));	

	dbi_clear_cache();
}

function updateTimeslotNeed($timeslot_id, $person_need) {
	global $login;
	if (is_numeric($person_need) && intval($person_need) > 0) {
		$sql = "UPDATE webcal_entry SET person_need=?, upd_user='$login' WHERE cal_id=?";
		dbi_execute($sql, array($person_need, $timeslot_id));
	} else {
		$sql = "UPDATE webcal_entry SET person_need=NULL, upd_user='$login' WHERE cal_id=?";
		dbi_execute($sql, array($timeslot_id));
	}

	dbi_clear_cache();
}

function updateContact($timeslot_id, $contact_id) {
	global $login;
	if (!empty($contact_id)) {
		$sql = "UPDATE webcal_entry SET contact_id=?, upd_user='$login' WHERE cal_id=?";
		dbi_execute($sql, array($contact_id, $timeslot_id));
	} else {
		$sql = "UPDATE webcal_entry SET contact_id=NULL, upd_user='$login' WHERE cal_id=?";
		dbi_execute($sql, array($timeslot_id));
	}

	dbi_clear_cache();
}

function deleteTimeslot(Timeslot $t) {
	$sql = 'DELETE FROM webcal_entry WHERE cal_id=?';
	dbi_execute($sql, array($t->id));

	dbi_clear_cache();
}

function listTimeslotsOrderBy($job_id, $orderBy) {
	$sql = 'SELECT we.cal_id, cal_date, cal_time, cal_duration, job_id, person_need, contact_id, SUM(count)
			FROM webcal_entry we
			LEFT JOIN webcal_entry_user weu
			ON we.cal_id=weu.cal_id 
			WHERE job_id=? 
			GROUP BY we.cal_id
			ORDER BY '.$orderBy;
	$rows = dbi_get_cached_rows($sql, array($job_id));
		
	$tsArr = array();
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];		
		$t = new Timeslot($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
		if ($row[5] != 0) {
			 $t->remainingNeed = $row[5] - $row[7];
		}
		$tsArr[] = $t;
	}
	
	return $tsArr;
}

function listTimeslots($job_id) {
	return listTimeslotsOrderBy($job_id, "cal_time, cal_duration, cal_date");
}

function listTimeslotsByDate($job_id) {
	return listTimeslotsOrderBy($job_id, "cal_date, cal_time, cal_duration");
}

function listTimeslotsForContact($user_id) {
	$sql = 'SELECT we.cal_id, cal_date, cal_time, cal_duration, job_id, person_need, contact_id, SUM(count)
			FROM webcal_entry we
			LEFT JOIN webcal_entry_user weu
			ON we.cal_id=weu.cal_id 
			WHERE contact_id=? 
			GROUP BY we.cal_id
			ORDER BY cal_date, cal_time, cal_id';
	$rows = dbi_get_cached_rows($sql, array($user_id));
		
	$tsArr = array();
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];		
		$t = new Timeslot($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
		if ($row[5] != 0) {
			 $t->remainingNeed = $row[5] - $row[7];
		}
		$tsArr[] = $t;
	}
	
	return $tsArr;
}

function listTimeslotsUnassigned($site_id) {
	$sql = 'SELECT we.cal_id, cal_date, cal_time, cal_duration, job_id, person_need, contact_id, SUM(count)
			FROM webcal_entry we
			LEFT JOIN webcal_entry_user weu ON we.cal_id=weu.cal_id
			LEFT JOIN job j ON we.job_id=j.id 
			WHERE person_need IS NOT NULL AND contact_id IS NULL AND j.id=we.job_id AND j.site_id=?  
			GROUP BY we.cal_id
			ORDER BY cal_date, cal_time, cal_id';
	$rows = dbi_get_cached_rows($sql, array($site_id));
		
	$tsArr = array();
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];		
		$t = new Timeslot($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
		if ($row[5] != 0) {
			 $t->remainingNeed = $row[5] - $row[7];
		}
		$tsArr[] = $t;
	}
	
	return $tsArr;
}

function groupTimeslotsByTime($timeslots) {
	$distinctTimes = array();
	$distinctTimesIdx = -1;
	$previousTS = null;
	foreach ($timeslots as $ts) {
		$ts = Timeslot::cast($ts);
		if ($ts->startTime == $previousTS->startTime && $ts->duration == $previousTS->duration) {
			$distinctTimes[$distinctTimesIdx][] = $ts;
		} else {
			$distinctTimesIdx++;
			$distinctTimes[$distinctTimesIdx][] = $ts;
		}
		$previousTS = $ts;
	}
	return $distinctTimes;
}

function groupTimeslotsByDate($timeslots) {
	$distinctDays = array();
	$distinctDaysIdx = -1;
	$previousTS = null;
	foreach ($timeslots as $ts) {
		$ts = Timeslot::cast($ts);
		if ($ts->date == $previousTS->date) {
			$distinctDays[$distinctDaysIdx][] = $ts;
		} else {
			$distinctDaysIdx++;
			$distinctDays[$distinctDaysIdx][] = $ts;
		}
		$previousTS = $ts;
	}
	return $distinctDays;
}

function getTimeslot($timeslot_id) {
	$sql = 'SELECT cal_id, cal_date, cal_time, cal_duration, job_id, person_need, contact_id FROM webcal_entry WHERE cal_id=?';
	$rows = dbi_get_cached_rows($sql, array($timeslot_id));
	
	$t = null;
	if(count($rows) == 1) { 
		$row = $rows[0];
		$t = new Timeslot($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
	}
	
	return $t;
}

function existTimeslot(Timeslot $t) {
	$sql = 'SELECT COUNT(cal_id) FROM webcal_entry WHERE job_id=? AND cal_date=? AND cal_time=? AND cal_duration=?';
	$rows = dbi_get_cached_rows($sql, array($t->jobID, $t->date, $t->startTime, $t->duration));
	
	if($rows[0][0] > 0) { 
		return true;
	} else {
		return false;		
	}
}

?>
