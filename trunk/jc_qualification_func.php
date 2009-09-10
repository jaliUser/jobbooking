<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/Qualification.php';

function getQualification($id) {
	$sql = 'SELECT id, name, site_id 
			FROM qualification 
			WHERE id=?';
	$rows = dbi_get_cached_rows($sql, array($id));
	
	$qual = null;
	if(count($rows) == 1) {
		$row = $rows[0];
		$qual = new Qualification($row[0], $row[1], $row[2]);
	}

	return $qual;
}

function listAllQualifications($site_id) {
	$sql = 'SELECT id, name, site_id FROM qualification WHERE site_id=?';
	$rows = dbi_get_cached_rows($sql, array($site_id));
	
	$quals = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$qual = new Qualification($row[0], $row[1], $row[2]);
		$quals[] = $qual;
	}
	
	return $quals;
}

function listUserQualifications($login) {
	$sql = 'SELECT qual.id, qual.name 
			FROM qualification qual, user_qualification uq
			WHERE uq.cal_login=? AND uq.qualification_id=qual.id';
	$rows = dbi_get_cached_rows($sql, array($login));
	
	$quals = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$qual = new Qualification($row[0], $row[1], $row[2]);
		$quals[] = $qual;
	}
	
	return $quals;
}

function updateUserQualifications($login, $qualificationIdArr) {
	global $login;
	$sql = 'DELETE FROM user_qualification WHERE cal_login=?';
	dbi_execute($sql, array($login));
	
	if (!empty($qualificationIdArr)) {
		foreach ($qualificationIdArr as $qualID) {
			$sql = "INSERT INTO user_qualification(cal_login, qualification_id, upd_user) VALUES (?,?,'$login')";
			dbi_execute($sql, array($login, $qualID, $site_id));				
		}
	}
	
	dbi_clear_cache();
}

?>