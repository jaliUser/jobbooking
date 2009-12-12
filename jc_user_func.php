<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/User.php';

function resetPassword($email) {
	$sql = "SELECT cal_login FROM webcal_user where cal_login=?";
	$rows = dbi_get_cached_rows($sql, array($email));

	if(count($rows == 1)) { 
		$login = $rows[0][0];
		$newPass = "1234";
		$md5Pass = md5($newPass);
		
		$sql = "UPDATE webcal_user SET cal_passwd=? where cal_login=?";
		dbi_execute($sql, array($md5Pass, $login));
		
		dbi_clear_cache();
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
	$sql = "INSERT INTO webcal_user (cal_login, cal_passwd, cal_lastname, cal_firstname, cal_email, cal_telephone, cal_address, cal_title, cal_birthday, role_id, site_id, group_id, count, age_range, qualifications, notes, ext_login, def_date, def_user, upd_user) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now(),'$login','$login')";
	dbi_execute($sql, array($u->login, $u->passwd, $u->lastname, $u->firstname, $u->email, $u->telephone, $u->address, $u->title, $u->birthday, $u->roleID, $u->siteID, $u->groupID, $u->count, $u->ageRange, $u->qualifications, $u->notes, $u->extLogin));

	dbi_clear_cache();
	return true;
}

function updateUser(User $u) {
	global $login;
	$sql = "UPDATE webcal_user SET cal_lastname=?, cal_firstname=?, cal_email=?, cal_telephone=?, cal_address=?, cal_title=?, cal_birthday=?, role_id=?, group_id=?, count=?, age_range=?, qualifications=?, notes=?, ext_login=?, upd_user='$login' WHERE cal_login=?";
	dbi_execute($sql, array($u->lastname, $u->firstname, $u->email, $u->telephone, $u->address, $u->title, $u->birthday, $u->roleID, $u->groupID, $u->count, $u->ageRange, $u->qualifications, $u->notes, $u->extLogin, $u->login));

	dbi_clear_cache();
}

function updateUserPasswd(User $u) {
	global $login;
	$sql = "UPDATE webcal_user SET cal_passwd=?, upd_user='$login' WHERE cal_login=?";
	dbi_execute($sql, array($u->passwd, $u->login));

	dbi_clear_cache();
}

function deleteUser($login) {
	//webcal_entry_user
	$sql = 'DELETE FROM webcal_entry_user WHERE cal_id IN 
			(SELECT cal_id FROM webcal_entry we
			LEFT JOIN job j ON j.id=we.job_id
			where j.owner_id=?)';
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
	$sql = 'SELECT cal_login, cal_passwd, cal_lastname, cal_firstname, cal_is_admin, cal_email, cal_enabled, cal_telephone, cal_address, cal_title, cal_birthday, cal_last_login, role_id, site_id, group_id, count, age_range, qualifications, notes, ext_login FROM webcal_user WHERE cal_login=?';
	$rows = dbi_get_cached_rows($sql, array($login));
	
	$user = null; 
	if(count($rows == 1)) { 
		$row = $rows[0];
		$user = new User($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13], $row[14], $row[15], $row[16], $row[17], $row[18], $row[19]);
	}

	return $user;
}

function listUsers($site_id, $role_id=null) {
	if(!empty($role_id)) {
		$sql = 'SELECT cal_login, cal_passwd, cal_lastname, cal_firstname, cal_is_admin, cal_email, cal_enabled, cal_telephone, cal_address, cal_title, cal_birthday, cal_last_login, role_id, site_id, group_id, count, age_range, qualifications, notes, ext_login FROM webcal_user 
		WHERE site_id=? AND role_id=? ORDER BY role_id, cal_firstname';
		$rows = dbi_get_cached_rows($sql, array($site_id, $role_id));		
	} else {
		$sql = 'SELECT cal_login, cal_passwd, cal_lastname, cal_firstname, cal_is_admin, cal_email, cal_enabled, cal_telephone, cal_address, cal_title, cal_birthday, cal_last_login, role_id, site_id, group_id, count, age_range, qualifications, notes, ext_login FROM webcal_user 
		WHERE site_id=? ORDER BY role_id, cal_firstname';
		$rows = dbi_get_cached_rows($sql, array($site_id));	
	}
	
	$users = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$u = new User($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13], $row[14], $row[15], $row[16], $row[17], $row[18], $row[19]);
		$users[] = $u;
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

?>