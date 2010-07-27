<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/User.php';
include_once 'includes/classes/SiteConfig.php';

function generate_password () {
  $pass = '';
  $pass_length = 8;
  $salt = 'abchefghjkmnpqrstuvwxyz0123456789';
  srand ( ( double ) microtime () * 1000000 );
  $i = 0;
  while ( $i < $pass_length ) {
    $pass .= substr ( $salt, rand () % 33, 1 );
    $i++;
  }
  return $pass;
}

function emailNewPassword($login, $password, $site_id) {
	$siteConfig = getSiteConfig($site_id);
	$contact = getUser($login);
	$subject = "Nyt kodeord til Jobdatabasen";
	$message =	"Hej ".$contact->getFullNameAndLogin()."\r\n".
				"\r\n". 
				"Du (eller en anden) har bedt om nyt kodeord til din bruger i Jobdatabasen på ".$siteConfig->siteName.".\r\n".	
				"\r\n".
				"Brugernavn: ".$login."\r\n".
				"Nyt kodeord: ".$password."\r\n";
	notifyUser($login, $subject, $message, $siteConfig); //giving siteConfig since user is not logged in
}

function resetPasswordFromLogin($login, $site_id) {
	$sql = "SELECT cal_login FROM webcal_user where cal_login=?";
	$rows = dbi_get_cached_rows($sql, array($login));

	if(count($rows) == 1) { 
		$cal_login = $rows[0][0];
		$newPass = generate_password();
		$md5Pass = md5($newPass);
		
		$sql = "UPDATE webcal_user SET cal_passwd=? where cal_login=?";
		dbi_execute($sql, array($md5Pass, $cal_login));
		dbi_clear_cache();
		
		emailNewPassword($cal_login, $newPass, $site_id);
		return true;
	} else {
		return false;
	}
}

function resetPasswordFromEmail($email, $site_id) {
	$sql = "SELECT cal_login FROM webcal_user where cal_email=?";
	$rows = dbi_get_cached_rows($sql, array($email));

	if(count($rows) == 1) { 
		$cal_login = $rows[0][0];
		$newPass = generate_password();
		$md5Pass = md5($newPass);
		
		$sql = "UPDATE webcal_user SET cal_passwd=? where cal_login=?";
		dbi_execute($sql, array($md5Pass, $cal_login));
		dbi_clear_cache();
		
		emailNewPassword($cal_login, $newPass, $site_id);
		return true;
	} else {
		return false;
	}
}

/*
 * Returns false if username/login already exist
 */
function createUser(User $u) {
	global $login;
	# check that cal_login is unique, otherwise abort
	$sql = 'SELECT COUNT(cal_login) FROM webcal_user WHERE cal_login=?';
	$res = dbi_execute ($sql, array($u->login));
    if ( $res ) {
    	$row = dbi_fetch_row ( $res );
      	if ($row[0] != 0) {
      		return false;
      	}
      	dbi_free_result ( $res );
    } else {
      	return false;
    }
	
	//auto-increment id
	$sql = "INSERT INTO webcal_user (cal_login, cal_passwd, cal_lastname, cal_firstname, cal_email, cal_telephone, cal_address, cal_title, cal_birthday, role_id, site_id, group_id, count, age_range, qualifications, notes, ext_login, no_email, is_contacted, def_date, def_user, upd_user) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now(),'$login','$login')";
	dbi_execute($sql, array($u->login, $u->passwd, $u->lastname, $u->firstname, $u->email, $u->telephone, $u->address, $u->title, $u->birthday, $u->roleID, $u->siteID, $u->groupID, $u->count, $u->ageRange, $u->qualifications, $u->notes, $u->extLogin, $u->noEmail, $u->isContacted));

	dbi_clear_cache();

	$subject = "Oprettelse af bruger";
	$message = "Hej ".$u->getFullNameAndLogin()."\r\n".
				"\r\n".
				"Du er nu oprettet som bruger i jobdatabasen med følgende brugernavn: $u->login\r\n".
				"(Bemærk der er forskel på store og små bogstaver!)\r\n".
				"\r\n".
				"Hvis du glemmer dit kodeord, kan du få tilsendt et nyt ved at anvende funktionen 'Glemt kodeord' fra login-siden.\r\n";

	notifyUser($u->login, $subject, $message);
	
	return true;
}

function updateUser(User $u) {
	global $login;
	$sql = "UPDATE webcal_user SET cal_lastname=?, cal_firstname=?, cal_email=?, cal_telephone=?, cal_address=?, cal_title=?, cal_birthday=?, role_id=?, group_id=?, count=?, age_range=?, qualifications=?, notes=?, ext_login=?, no_email=?, is_contacted=?, upd_user='$login' WHERE cal_login=?";
	dbi_execute($sql, array($u->lastname, $u->firstname, $u->email, $u->telephone, $u->address, $u->title, $u->birthday, $u->roleID, $u->groupID, $u->count, $u->ageRange, $u->qualifications, $u->notes, $u->extLogin, $u->noEmail, $u->isContacted, $u->login));

	dbi_clear_cache();
}

function updateUserPasswd(User $u) {
	global $login;
	$sql = "UPDATE webcal_user SET cal_passwd=?, upd_user='$login' WHERE cal_login=?";
	dbi_execute($sql, array($u->passwd, $u->login));

	dbi_clear_cache();
}

function deleteUser($login) {
//	global $site_id;
//
//	$jobsText = "Nedenstående jobs var dine og er også blevet slettet:";
//	$jobs = listJobs($site_id, null, $login);
//	foreach ($jobs as $job) {
//		$jobsText .= "Job $job->id: $job->name\r\n";
//	}
//	$jobsText .= "\r\n";
//
//	$signupsText = "Nedenstående tilmeldinger var dine og er også blevet slettet:";
//	$signups = listUserSignups($login, false);
//	foreach ($signups as $signup) {
//		$ts = getTimeslot($signup->timeslotID);
//		$job = getJob($ts->jobID);
//		$signupsText .= "$job->name ".getTimeText($job, $ts)."\r\n";
//	}
//	$signupsText .= "\r\n";
//	
//	$user = getUser($login);
//	$subject = "Sletning af bruger";
//	$message = "Hej ".$user->getFullNameAndLogin()."\r\n".
//				"\r\n".
//				"Din bruger i jobdatabasen er nu slettet.\r\n";
//				"\r\n".
//				$jobsText.
//				$signupsText;
//	
//	notifyUser($login, $subject, $message);
	
	//TODO: notify other users of their deleted signups!
	
	//START DELETE
	//webcal_entry_user - associated signups to own jobs
	$sql = 'DELETE FROM webcal_entry_user WHERE cal_id IN 
			(SELECT cal_id FROM webcal_entry we
			LEFT JOIN job j ON j.id=we.job_id
			where j.owner_id=?)';
	dbi_execute($sql, array($login));
	
	//webcal_entry_user - own signups
	$sql = 'DELETE FROM webcal_entry_user WHERE cal_login=?';
	dbi_execute($sql, array($login));
	
	//webcal_entry
	$sql = 'DELETE FROM webcal_entry WHERE job_id IN (SELECT id FROM job WHERE owner_id=?)';
	dbi_execute($sql, array($login));
	
	//job
	$sql = 'DELETE FROM job WHERE owner_id=?';
	dbi_execute($sql, array($login));

	//user_qualification
	$sql = 'DELETE FROM user_qualification WHERE cal_login=?';
	dbi_execute($sql, array($login));
	
	//user_jobcategory
	$sql = 'DELETE FROM user_jobcategory WHERE cal_login=?';
	dbi_execute($sql, array($login));
	
	//webcal_user
	$sql = 'DELETE FROM webcal_user WHERE cal_login=?';
	dbi_execute($sql, array($login));
	
	//webcal_user_pref
	$sql = 'DELETE FROM webcal_user_pref WHERE cal_login=?';
	dbi_execute($sql, array($login));
	
	dbi_clear_cache();
}

function getUser($login) {
	$sql = 'SELECT cal_login, cal_passwd, cal_lastname, cal_firstname, cal_is_admin, cal_email, cal_enabled, cal_telephone, cal_address, cal_title, cal_birthday, cal_last_login, role_id, site_id, group_id, count, age_range, qualifications, notes, ext_login, no_email, is_contacted FROM webcal_user WHERE cal_login=?';
	$rows = dbi_get_cached_rows($sql, array($login));
	
	$user = null; 
	if(count($rows == 1)) { 
		$row = $rows[0];
		$user = new User($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13], $row[14], $row[15], $row[16], $row[17], $row[18], $row[19], $row[20], $row[21]);
	}

	return $user;
}

function listUsers($site_id, $role_id=null, $group_id=null) {
	if(!empty($role_id)) {
		$sql = 'SELECT cal_login, cal_passwd, cal_lastname, cal_firstname, cal_is_admin, cal_email, cal_enabled, cal_telephone, cal_address, cal_title, cal_birthday, cal_last_login, role_id, site_id, group_id, count, age_range, qualifications, notes, ext_login, no_email, is_contacted  
				FROM webcal_user 
				WHERE site_id=? AND role_id=? 
				ORDER BY role_id, cal_firstname';
		$rows = dbi_get_cached_rows($sql, array($site_id, $role_id));
	} else if(!empty($group_id)) {
		$sql = 'SELECT cal_login, cal_passwd, cal_lastname, cal_firstname, cal_is_admin, cal_email, cal_enabled, cal_telephone, cal_address, cal_title, cal_birthday, cal_last_login, role_id, site_id, group_id, count, age_range, qualifications, notes, ext_login, no_email, is_contacted  
				FROM webcal_user 
				WHERE site_id=? AND group_id=? 
				ORDER BY cal_firstname';
		$rows = dbi_get_cached_rows($sql, array($site_id, $group_id));
	} else {
		$sql = 'SELECT cal_login, cal_passwd, cal_lastname, cal_firstname, cal_is_admin, cal_email, cal_enabled, cal_telephone, cal_address, cal_title, cal_birthday, cal_last_login, role_id, site_id, group_id, count, age_range, qualifications, notes, ext_login, no_email, is_contacted  
				FROM webcal_user 
				WHERE site_id=? 
				ORDER BY role_id, cal_firstname';
		$rows = dbi_get_cached_rows($sql, array($site_id));	
	}
	
	$users = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$u = new User($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13], $row[14], $row[15], $row[16], $row[17], $row[18], $row[19], $row[20], $row[21]);
		$users[$row[0]] = $u;
	}
	
	return $users;
}

function listUsersWithSignupInfo($site_id, $role_id = null) {
	$users = listUsers($site_id, $role_id);
	
	if(!empty($role_id)) {
		$sql = 'SELECT u.cal_login, 
				SUM(weu.count),
				SUM(we.cal_duration*weu.count/60), 
				SUM(we.cal_duration*weu.count/60)/u.count
				FROM webcal_user u 
				LEFT JOIN webcal_entry_user weu on weu.cal_login=u.cal_login
				LEFT JOIN webcal_entry we on we.cal_id=weu.cal_id
				WHERE site_id=? AND role_id=? AND job_id > 0
				GROUP BY cal_login';
		$rows = dbi_get_cached_rows($sql, array($site_id, $role_id));
	} else {
		$sql = 'SELECT u.cal_login, 
				SUM(weu.count),
				SUM(we.cal_duration*weu.count/60), 
				SUM(we.cal_duration*weu.count/60)/u.count
				FROM webcal_user u 
				LEFT JOIN webcal_entry_user weu on weu.cal_login=u.cal_login
				LEFT JOIN webcal_entry we on we.cal_id=weu.cal_id
				WHERE site_id=? AND job_id > 0
				GROUP BY cal_login';
		$rows = dbi_get_cached_rows($sql, array($site_id));
	}
	
	//attach signup info to each user having signups (for jobs with id > 0)
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];		
		if ($users[$row[0]] != null) {
			$users[$row[0]]->signups = $row[1];
			$users[$row[0]]->signupsDuration = round($row[2], 1);
			$users[$row[0]]->signupsDurationEach = round($row[3], 1);
		}
	}
	
	return $users;
}

function existEmail($email) {
	$sql = 'SELECT count(cal_login) FROM webcal_user WHERE cal_email=?';
	$rows = dbi_get_cached_rows($sql, array($email));
	
	return $rows[0][0];
}

function existTelephone($telephone) {
	$sql = 'SELECT count(cal_login) FROM webcal_user WHERE cal_telephone=?';
	$rows = dbi_get_cached_rows($sql, array($telephone));
	
	return $rows[0][0];
}

function print_create_user() {
	echo '<h1>Opret bruger</i></h1>
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		<tr><td>Brugernavn:</td><td><input type="text" name="login" size="25" maxlength="25" disabled /> * <span class="help">Kun tegnene A-Z og _ er tilladte (IKKE mellemrum, &AElig;, &Oslash; og &Aring;)</span></td></tr>
		<tr><td>Kodeord:</td><td><input type="password" name="password" size="25" maxlength="32" disabled /> * <span class="help">Minimum 4 karakterer</span></td></tr>
		<tr><td>Fornavn:</td><td><input type="text" name="firstname" size="25" maxlength="25" disabled /> *</td></tr>
		<tr><td>Efternavn:</td><td><input type="text" name="lastname" size="25" maxlength="25" disabled /> *</td></tr>
		<!-- <tr><td>Spejdernet-brugernavn:</td><td><input type="text" name="ext_login" size="25" maxlength="25" disabled /></td></tr> -->
		<tr><td>E-mail:</td><td><input type="text" name="email" size="25" maxlength="75" disabled /> <span class="help">Vigtig!</span></td></tr>
		<tr><td>Telefon (helst mobil):</td><td><input type="text" name="telephone" size="25" maxlength="50" disabled /> * <span class="help">Bruges til SMS-service for påmindelse og evt. ændringer af jobs.</span></td></tr>
		<!-- <tr><td>Adresse/postnr/by:</td><td><input type="text" name="address" size="25" maxlength="75" disabled /> *</td></tr> -->
		<!-- <tr><td>Alder under lejren:</td><td><input type="text" name="age_range" size="10" maxlength="10" disabled /> *</td></tr> -->
		<tr><td>Antal:</td><td><input type="text" name="count" size="2" maxlength="3" disabled /> * <span class="help">Hvor mange hjælpere er I?</span></td></tr>
		<tr><td>Klan/holdnavn/pladsnr:</td><td><input type="text" name="title" size="25" maxlength="75" disabled /></td></tr>
		<!-- <tr><td>Foretrukne jobkategorier:</td><td>'.$jobcategoryHTML.'</td></tr> -->
		<tr><td>Gruppe:</td><td><input type="text" name="title" size="25" maxlength="75" disabled /> *</td></tr>
		<tr><td>Noter:</td><td><textarea name="notes" cols="50" rows="3" disabled></textarea></td></tr>
		<tr><td colspan="2" class="help">* markerer et obligatorisk felt</td></tr>
		</table>';
}

?>