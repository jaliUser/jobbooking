<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/Signup.php';

function createSignup(Signup $s) {
	global $login, $siteConfig;
	//cal_id + cal_login is primary key
	$sql = "INSERT INTO webcal_entry_user (cal_id, cal_login, cal_status, cal_category, cal_percent, count, notes, def_date, def_user, upd_user) 
			VALUES (?,?,?,?,?,?,?,now(),'$login','$login')";
	dbi_execute($sql, array($s->timeslotID, $s->userID, $s->status, $s->category, DBint($s->percent), $s->count, $s->notes));

	dbi_clear_cache();
	
	$ts = getTimeslot($s->timeslotID);
	$job = getJob($ts->jobID);
	if (!empty($ts->contactID)) {
		$subject = "JK: Ny tilmelding til job $job->id, ".$job->name;
		$user = getUser($ts->contactID);
		$message = "Hej ".$user->getFullNameAndLogin()."\r\n".
					"\r\n".
					"Du er for job $job->id '".$job->name."' tildelt tidsperioden ".$ts->getStartHour().":".$ts->getStartMin()."-".$ts->getEndHour().":".$ts->getEndMin()." ".$ts->get_DD_MM_YYYY().".\r\n".
					"Som jobkonsulent er det din opgave at skaffe arbejdskraft til de tidsperioder, som du er tildelt.\r\n".
					"\r\n".
					"Der er netop kommet en ny tilmelding p� ".$s->count." personer for denne tidsperiode, \r\n".
					"s� det resterende behov er ".$ts->remainingNeed." personer.\r\n";
		
		notifyUser($ts->contactID, $subject, $message);
		
		if ($user->noEmail != 1 && !empty($user->telephone)) {
			$smsText = date("H:i:s")." - Ny tilmelding til ID $job->id $job->name,".getTimeTextShort($job, $ts)." s� rest behov er ".$ts->remainingNeed." pers. Mvh $siteConfig->siteName";
			$phoneArray = array($user->telephone);
			smsPhoneList($phoneArray, $smsText, true, false);
		}
	}
	
	$subject = "Ny tilmelding til job $job->id, ".$job->name;
	$user = getUser($s->userID);
	$message = "Hej ".$user->getFullNameAndLogin()."\r\n".
				"\r\n".
				"Du er nu tilmeldt job $job->id '".$job->name."'".getTimeText($job, $ts)." med ".$s->count." personer.\r\n";
	if ($login != $s->userID) {
		$editUser = getUser($login);
		$message .= "\r\nTilmeldingen er foretaget af: ".$editUser->getFullName().".\r\n";
	}

	notifyUser($s->userID, $subject, $message);
}

function updateSignup(Signup $s) {
	global $login, $siteConfig;
	$oldSignup = getSignup($s->timeslotID, $s->userID);
	
	//cal_id + cal_login is primary key
	$sql = "UPDATE webcal_entry_user SET cal_status=?, cal_category=?, cal_percent=?, count=?, notes=?, upd_user='$login' 
			WHERE cal_id=? AND cal_login=?";
	dbi_execute($sql, array($s->status, $s->category, DBint($s->percent), $s->count, $s->notes, $s->timeslotID, $s->userID));

	dbi_clear_cache();
	
	$ts = getTimeslot($s->timeslotID);
	$job = getJob($ts->jobID);
	if (!empty($ts->contactID)) {
		$subject = "JK: Opdateret tilmelding til job $job->id, ".$job->name;
		$user = getUser($ts->contactID);
		$message = "Hej ".$user->getFullNameAndLogin()."\r\n".
					"\r\n".
					"Du er for job $job->id '".$job->name."' tildelt tidsperioden ".$ts->getStartHour().":".$ts->getStartMin()."-".$ts->getEndHour().":".$ts->getEndMin()." ".$ts->get_DD_MM_YYYY().".\r\n".
					"Som jobkonsulent er det din opgave at skaffe arbejdskraft til de tidsperioder, som du er tildelt.\r\n".
					"\r\n".
					"Der er netop opdateret en tilmelding for denne tidsperiode, \r\n".
					"s� det resterende behov er ".$ts->remainingNeed." personer.\r\n";
		
		notifyUser($ts->contactID, $subject, $message);
		
		if ($user->noEmail != 1 && !empty($user->telephone)) {
			$smsText = date("H:i:s")." - Opdateret tilmelding til ID $job->id $job->name,".getTimeTextShort($job, $ts)." s� rest behov er ".$ts->remainingNeed." pers. Mvh $siteConfig->siteName";
			$phoneArray = array($user->telephone);
			smsPhoneList($phoneArray, $smsText, true, false);
		}
	}
	
	$subject = "Opdateret tilmelding til job $job->id, ".$job->name;
	$user = getUser($s->userID);
	$message = "Hej ".$user->getFullNameAndLogin()."\r\n".
				"\r\n".
				"Din tilmelding til job $job->id '".$job->name."'".getTimeText($job, $ts)." er nu �ndret fra $oldSignup->count til ".$s->count." personer.\r\n";
	if ($login != $s->userID) {
		$editUser = getUser($login);
		$message .= "\r\nOpdateringen er foretaget af: ".$editUser->getFullName().".\r\n";
	}

	notifyUser($s->userID, $subject, $message);
}

function deleteSignup(Signup $s) {
	global $login, $siteConfig;
	$oldSignup = getSignup($s->timeslotID, $s->userID);
	
	$sql = 'DELETE FROM webcal_entry_user WHERE cal_id=? AND cal_login=?';
	dbi_execute($sql, array($s->timeslotID, $s->userID));

	dbi_clear_cache();
	
	$ts = getTimeslot($s->timeslotID);
	$job = getJob($ts->jobID);
	if (!empty($ts->contactID)) {
		$subject = "JK: Slettet tilmelding til job $job->id, ".$job->name;
		$user = getUser($ts->contactID);
		$message = "Hej ".$user->getFullNameAndLogin()."\r\n".
					"\r\n".
					"Du er for job $job->id '".$job->name."' tildelt tidsperioden ".$ts->getStartHour().":".$ts->getStartMin()."-".$ts->getEndHour().":".$ts->getEndMin()." ".$ts->get_DD_MM_YYYY().".\r\n".
					"Som jobkonsulent er det din opgave at skaffe arbejdskraft til de tidsperioder, som du er tildelt.\r\n".
					"\r\n".
					"Der er netop slettet en tilmelding for denne tidsperiode, \r\n".
					"s� det resterende behov er ".$ts->remainingNeed." personer.\r\n";
		
		notifyUser($ts->contactID, $subject, $message);
		
		if ($user->noEmail != 1 && !empty($user->telephone)) {
			$smsText = date("H:i:s")." - Slettet tilmelding til ID $job->id $job->name,".getTimeTextShort($job, $ts)." s� rest behov er ".$ts->remainingNeed." pers. Mvh $siteConfig->siteName";
			$phoneArray = array($user->telephone);
			smsPhoneList($phoneArray, $smsText, true, false);
		}
	}
	
	$subject = "Slettet tilmelding til job $job->id, ".$job->name;
	$user = getUser($s->userID);
	$message = "Hej ".$user->getFullNameAndLogin()."\r\n".
				"\r\n".
				"Din tilmelding til job $job->id '".$job->name."'".getTimeText($job, $ts)." med $oldSignup->count personer er nu slettet.\r\n";
	if ($login != $s->userID) {
		$editUser = getUser($login);
		$message .= "\r\nSletningen er foretaget af: ".$editUser->getFullName().".\r\n";
	}

	notifyUser($s->userID, $subject, $message);
}

function updateEval(Signup $s) {
	global $login;
	
	//use old updDate to maintain date for actual signup, instead of overwriting with date for eval
	//cal_id + cal_login is primary key
	$sql = "UPDATE webcal_entry_user SET cal_percent=?, notes=?, upd_date=? 
			WHERE cal_id=? AND cal_login=?";
	dbi_execute($sql, array(DBint($s->percent), $s->notes, $s->updDate, $s->timeslotID, $s->userID));

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

function listJobSignups($job_id, $order='cal_id') {
	$sql = 'SELECT weu.cal_id, cal_login, cal_status, cal_category, cal_percent, count, notes, weu.def_date, weu.def_user, weu.upd_date, weu.upd_user  
			FROM webcal_entry_user weu, webcal_entry we 
			WHERE we.cal_id=weu.cal_id AND we.job_id=? AND count IS NOT NULL
			ORDER BY weu.'.$order;
	$rows = dbi_get_cached_rows($sql, array($job_id));
	
	$signupArr = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];		
		$s = new Signup($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
		$s->defDate = $row[7];
		$s->defUser = $row[8];
		$s->updDate = $row[9];
		$s->updUser = $row[10];
		$signupArr[] = $s;
	}
	
	return $signupArr;
}

function listTimeslotSignups($timeslot_id, $order='def_date') {
	$sql = 'SELECT cal_id, cal_login, cal_status, cal_category, cal_percent, count, notes, def_date, def_user, upd_date, upd_user
			FROM webcal_entry_user 
			WHERE cal_id=?
			ORDER BY '.$order;
	$rows = dbi_get_cached_rows($sql, array($timeslot_id));

	$signupArr = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];		
		$s = new Signup($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]);
		$s->defDate = $row[7];
		$s->defUser = $row[8];
		$s->updDate = $row[9];
		$s->updUser = $row[10];
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
	$oldSignup = getSignup($s->timeslotID, $s->userID);
	if ($oldSignup != null) {
		if (empty($s->count)) {
			deleteSignup($s); //TODO: disable signup instead
		} else if (!empty($s->count) && $s->count != $oldSignup->count) {
			updateSignup($s);
		}
		//if new same as old - do nothing
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

function isUserFree($login, Timeslot $timeslot, $clashNumber = 0) {
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
	$rows = dbi_get_cached_rows($sql, array($login, $timeslot->date, $timeslot->startTime, $timeslot->startTime, $timeslot->getEndTime(), $timeslot->getEndTime(), $timeslot->startTime, $timeslot->getEndTime()));
	//echo $sql.",". $login .",". $timeslot->date .",". $timeslot->startTime .",". $timeslot->startTime .",". $timeslot->getEndTime() .",". $timeslot->getEndTime() .",". $timeslot->startTime .",". $timeslot->getEndTime() . "<br><br>\r\n";
	
	if ($rows[0][0] > $clashNumber) {
		return false;
	}
	return true;
}

?>