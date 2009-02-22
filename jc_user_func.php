<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/User.php';

/*
 * Returns false if username/login already exist
 */
function createUser(User $u) {
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
	$sql = 'INSERT INTO webcal_user (cal_login, cal_passwd, cal_lastname, cal_firstname, cal_email, cal_telephone, cal_address, cal_title, cal_birthday, role_id, site_id) VALUES (?,?,?,?,?,?,?,?,?,?,?)';
	dbi_execute($sql, array($u->login, $u->passwd, $u->lastname, $u->firstname, $u->email, $u->telephone, $u->address, $u->title, $u->birthday, $u->roleID, $u->siteID)); 		
//		sqlNULL($u->passwd), 
//		sqlNULL($u->lastname), 
//		sqlNULL($u->firstname), 
//		sqlNULL($u->email), 
//		sqlNULL($u->telephone), 
//		sqlNULL($u->address), 
//		sqlNULL($u->title), 
//		sqlNULL($u->birthday), 
//		sqlNULL($u->roleID), 
//		sqlNULL($u->siteID)));

	dbi_clear_cache();
	return true;
}

function updateUser(User $u) {
	$sql = 'UPDATE webcal_user SET cal_lastname=?, cal_firstname=?, cal_email=?, cal_telephone=?, cal_address=?, cal_title=?, cal_birthday=?, role_id=? WHERE cal_login=?';
	dbi_execute($sql, array($u->lastname, $u->firstname, $u->email, $u->telephone, $u->address, $u->title, $u->birthday, $u->roleID, $u->login));
//		sqlNULL($u->lastname), 
//		sqlNULL($u->firstname), 
//		sqlNULL($u->email), 
//		sqlNULL($u->telephone), 
//		sqlNULL($u->address), 
//		sqlNULL($u->title), 
//		sqlNULL($u->birthday), 
//		sqlNULL($u->roleID), 
//		$u->login));

	dbi_clear_cache();
}

function updateUserPasswd(User $u) {
	$sql = 'UPDATE webcal_user SET cal_passwd=? WHERE cal_login=?';
	dbi_execute($sql, array($u->passwd, $u->login));

	dbi_clear_cache();
}

function deleteUser(User $u) {
	$sql = 'DELETE FROM webcal_user WHERE cal_login=?';
	dbi_execute($sql, array($u->login));

	//TODO: delete user prefs also
	
	dbi_clear_cache();
}

function getUser($login) {
	$sql = 'SELECT cal_login, cal_passwd, cal_lastname, cal_firstname, cal_is_admin, cal_email, cal_enabled, cal_telephone, cal_address, cal_title, cal_birthday, cal_last_login, role_id, site_id FROM webcal_user WHERE cal_login=?';
	$rows = dbi_get_cached_rows($sql, array($login));
	
	$user = null; 
	if(count($rows == 1)) { 
		$row = $rows[0];
		$user = new User($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13]);
	}

	return $user;
}

function listUsers($site_id) {
	$sql = 'SELECT cal_login, cal_passwd, cal_lastname, cal_firstname, cal_is_admin, cal_email, cal_enabled, cal_telephone, cal_address, cal_title, cal_birthday, cal_last_login, role_id, site_id FROM webcal_user WHERE site_id=?';
	$rows = dbi_get_cached_rows($sql, array($site_id));
	
	$users = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$u = new User($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13]);
		$users[] = $u;
	}
	
	return $users;
}

function listUsersWithRole($site_id, $role_id) {
	$sql = 'SELECT cal_login, cal_passwd, cal_lastname, cal_firstname, cal_is_admin, cal_email, cal_enabled, cal_telephone, cal_address, cal_title, cal_birthday, cal_last_login, role_id, site_id FROM webcal_user WHERE site_id=? AND role_id=?';
	$rows = dbi_get_cached_rows($sql, array($site_id, $role_id));
	
	$users = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$u = new User($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13]);
		$users[] = $u;
	}
	
	return $users;
}

?>