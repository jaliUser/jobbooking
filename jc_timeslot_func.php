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
	return $id;
}

function updateTimeslotNeed(Timeslot $ts, Job $job, $person_need) {
	global $login;
	if (is_numeric($person_need) && intval($person_need) > 0) {
		//update existing person_need
		$sql = "UPDATE webcal_entry SET person_need=?, upd_user='$login' WHERE cal_id=?";
		dbi_execute($sql, array($person_need, $ts->id));
		
		$diffNeed = $person_need - $ts->personNeed;
		$newRemainingNeed = $ts->remainingNeed + $diffNeed;
		if ($newRemainingNeed < 0) {
			$subject = "Behov nedjusteret: Job $job->id overbemandet med ".-1*$newRemainingNeed;
			$message = "Behovet".getTimeText($job, $ts)." for jobID $job->id '$job->name'\r\n".
						"er netop blevet nedjusteret fra $ts->personNeed til $person_need personer,\r\n".
						"så der nu er overbemanding med ".-1*$newRemainingNeed." personer.\r\n".
						"TODO: Find nye jobs/tidsperioder til de overskydende!\r\n";
			
			notifyAdmin($subject, $message);
		}
	} else {
		//clear previous person_need
		$sql = "UPDATE webcal_entry SET person_need=NULL, upd_user='$login' WHERE cal_id=?";
		dbi_execute($sql, array($ts->id));
		
		$deletedSignupUsernames = "";
		$signups = listTimeslotSignups($ts->id);
		foreach ($signups as $signup) {
			//delete signup and notify user
			deleteSignup($signup);
			$deletedSignupUsernames .= "$signup->userID, ";
		}
		
		if (count($signups) > 0) {
			$subject = "Behov på tidsperiode er slettet for job $job->id";
			$message = "Behovet".getTimeText($job, $ts)." for jobID $job->id '$job->name' er netop blevet slettet.\r\n".
						"Følgende brugernavne var tilmeldt og deres tilmeldinger er blevet slettet (de har fået mail om sletningen).\r\n".
						"TODO: Find nye jobs/tidsperioder til disse personer!\r\n\r\n".
						"Brugernavne: $deletedSignupUsernames\r\n";
			
			notifyAdmin($subject, $message);
		}
	}

	dbi_clear_cache();
}

function updateTimeslotWished($timeslot_id, $person_need) {
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
	$oldTS = getTimeslot($timeslot_id);
	
	if ($oldTS->contactID != $contact_id) {		
		$job = getJob($oldTS->jobID);
		$newUser = getUser($contact_id);
		
		if (!empty($contact_id)) {
			$sql = "UPDATE webcal_entry SET contact_id=?, upd_user='$login' WHERE cal_id=?";
			dbi_execute($sql, array($contact_id, $timeslot_id));
			dbi_clear_cache();
			
			$subject = "Ny tildeling af tidsperiode";
			$message = "Hej ".$newUser->getFullNameAndLogin()."\r\n".
						"\r\n".
						"Du er netop for job '".$job->name."' blevet tildelt tidsperioden ".$oldTS->getStartHour().":".$oldTS->getStartMin()."-".$oldTS->getEndHour().":".$oldTS->getEndMin()." ".$oldTS->get_DD_MM_YYYY().",\r\n".
						"hvor der er et resterende behov på ".$oldTS->remainingNeed." personer.\r\n".
						"Som jobkonsulent er det din opgave at skaffe arbejdskraft til de tidsperioder, som du er tildelt.\r\n";
			
			notifyUser($contact_id, $subject, $message);
		} else {
			$sql = "UPDATE webcal_entry SET contact_id=NULL, upd_user='$login' WHERE cal_id=?";
			dbi_execute($sql, array($timeslot_id));
			dbi_clear_cache();
		}
		
		if (!empty($oldTS->contactID)) {
			$oldUser = getUser($oldTS->contactID);
			
			$subject = "Slettet tildeling af tidsperiode";
			$message = "Hej ".$oldUser->getFullNameAndLogin()."\r\n".
						"\r\n".
						"Din tildeling af tidsperioden ".$oldTS->getStartHour().":".$oldTS->getStartMin()."-".$oldTS->getEndHour().":".$oldTS->getEndMin()." ".$oldTS->get_DD_MM_YYYY()." for job '".$job->name."' er netop blevet slettet.\r\n".
						"Der var et resterende behov på ".$oldTS->remainingNeed." personer.\r\n".
						"Som jobkonsulent er det din opgave at skaffe arbejdskraft til de tidsperioder, som du er tildelt.\r\n";
			
			notifyUser($oldTS->contactID, $subject, $message);
		}
	}
}

function deleteTimeslot($timeslot_id) {
	$sql = 'DELETE FROM webcal_entry WHERE cal_id=?';
	dbi_execute($sql, array($timeslot_id));

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
			WHERE contact_id=? and job_id > 0
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

function listTimeslotsSite($site_id) {
	$sql = 'SELECT we.cal_id, cal_date, cal_time, cal_duration, job_id, person_need, contact_id, SUM(count)
			FROM webcal_entry we
			LEFT JOIN webcal_entry_user weu ON we.cal_id=weu.cal_id
			LEFT JOIN job j ON we.job_id=j.id 
			WHERE person_need IS NOT NULL AND j.id=we.job_id AND j.site_id=?  
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

function listTimeslotWishes($user_id) {
	$sql = 'SELECT we.cal_id, we.cal_date, we.cal_time, we.cal_duration, we.job_id, we.person_need, we.contact_id
			FROM webcal_entry we
			WHERE we.job_id=-2 AND we.contact_id=? 
			ORDER BY we.cal_date, we.cal_time';
	$rows = dbi_get_cached_rows($sql, array($user_id));
	
	$tsArr = array();
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];		
		$t = new Timeslot($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
		$tsArr[] = $t;
	}
	
	return $tsArr;
}

function listTimeslotWishesInPeriod($site_id, $start_date, $start_caltime, $end_date, $end_caltime) {
	$sql = 'SELECT we.cal_id, we.cal_date, we.cal_time, we.cal_duration, we.job_id, we.person_need, we.contact_id
			FROM webcal_entry we
			LEFT JOIN webcal_user u ON u.cal_login=we.contact_id
			WHERE we.job_id=-2 AND u.site_id=? AND 
				we.cal_date>=? AND cal_date<=? AND 
				cal_time<=? AND (cal_time+(cal_duration %60)*100+FLOOR(cal_duration/60)*10000) >=?
			ORDER BY we.cal_date, we.cal_time';
	$rows = dbi_get_cached_rows($sql, array($site_id, $start_date, $end_date, $start_caltime, $end_caltime)); 
	
	$tsArr = array();
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];		
		$t = new Timeslot($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
		$tsArr[] = $t;
	}
	
	return $tsArr;
}

function listTimeslotWishesForSite($site_id) {
	$sql = 'SELECT we.cal_id, we.cal_date, we.cal_time, we.cal_duration, we.job_id, we.person_need, we.contact_id
			FROM webcal_entry we
			LEFT JOIN webcal_user u ON u.cal_login=we.contact_id
			WHERE we.job_id=-2 AND u.site_id=?
			ORDER BY we.cal_date, we.cal_time';
	$rows = dbi_get_cached_rows($sql, array($site_id)); 
	
	$tsArr = array();
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];		
		$t = new Timeslot($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
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
		if ($previousTS != null && $ts->startTime == $previousTS->startTime && $ts->duration == $previousTS->duration) {
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
	$sql = 'SELECT we.cal_id, cal_date, cal_time, cal_duration, job_id, person_need, contact_id, SUM(count)
			FROM webcal_entry we
			LEFT JOIN webcal_entry_user weu
			ON we.cal_id=weu.cal_id 
			WHERE we.cal_id=?
			GROUP BY we.cal_id';
	$rows = dbi_get_cached_rows($sql, array($timeslot_id));
	
	$t = null;
	if(count($rows) == 1) { 
		$row = $rows[0];
		$t = new Timeslot($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
		if ($row[5] != 0) {
			$t->remainingNeed = $row[5] - $row[7];
		}
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

function updateTimeslotTime(Timeslot $t, Timeslot $oldTS) {
	global $login;
	$sql = "UPDATE webcal_entry SET cal_date=?, cal_time=?, cal_duration=?, upd_user='$login' WHERE cal_id=?";
	dbi_execute($sql, array($t->date, $t->startTime, $t->duration, $t->id));	

	dbi_clear_cache();
	
	notifyOrUnsignupTimeslotAttendees($t, $oldTS);
}

function notifyOrUnsignupTimeslotAttendees(Timeslot $t, Timeslot $oldTS) {
	global $siteConfig;
	$job = getJob($t->jobID);
	$signups = listTimeslotSignups($t->id);
	
	foreach ($signups as $signup) {
		$signup = Signup::cast($signup);
		$contact = getUser($signup->userID);
		
		// check user is free then notify - else unsignup
		if (isUserFree($signup->userID, $t, 1)) {
			$subject = "Tidsperiode flyttet - din jobtilmelding er ændret";
			$message =	"Hej ".$contact->getFullNameAndLogin()."\r\n".
						"\r\n". 
						"Du er tilmeldt som hjælper til følgende job:\r\n".
						"\r\n".
						"JobID: ".$job->id."\r\n".
						"Jobnavn: ".$job->name."\r\n".
						"\r\n".
						"i tidsperioden: ".$oldTS->get_DD_MM_YYYY()." kl. ".$oldTS->getStartHour().":".$oldTS->getStartMin()."-".$oldTS->getEndHour().":".$oldTS->getEndMin()."\r\n".
						"\r\n".
						"Denne tidsperiode er nu ændret til:\r\n".
						$t->get_DD_MM_YYYY().". kl. ".$t->getStartHour().":".$t->getStartMin()."-".$t->getEndHour().":".$t->getEndMin()."\r\n".
						"\r\n".
						"Hvis den nye tidsperiode passer dig fint skal du ikke gøre mere,\r\n".
						"men hvis ændringen ikke passer dig, beder vi dig gå ind og fjerne din tilmelding.\r\n";
		} else {
			deleteSignup($signup);
			
			$subject = "Tidsperiode flyttet - din jobtilmelding er slettet";
			$message =	"Hej ".$contact->getFullNameAndLogin()."\r\n".
						"\r\n". 
						"Du er tilmeldt som hjælper til følgende job:\r\n".
						"\r\n".
						"JobID: ".$job->id."\r\n".
						"Jobnavn: ".$job->name."\r\n".
						"\r\n".
						"i tidsperioden: ".$oldTS->get_DD_MM_YYYY()." kl. ".$oldTS->getStartHour().":".$oldTS->getStartMin()."-".$oldTS->getEndHour().":".$oldTS->getEndMin()."\r\n".
						"\r\n".
						"Denne tidsperiode er nu ændret til:\r\n".
						$t->get_DD_MM_YYYY().". kl. ".$t->getStartHour().":".$t->getStartMin()."-".$t->getEndHour().":".$t->getEndMin()."\r\n".
						"\r\n".
						"Men ifølge systemet er du enten optaget af et andet job eller har en blokering i denne periode,\r\n".
						"så din tilmelding til dette job er blevet slettet.\r\n".
						"\r\n".
						"Du kan logge ind og se om du kan finde et andet ledigt job, som du synes er interessant.\r\n";
		}
		
		notifyUser($contact->login, $subject, $message);
	}
}

?>