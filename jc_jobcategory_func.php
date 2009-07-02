<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/JobCategory.php';

function getJobCategory($id) {
	$sql = 'SELECT id, name, site_id 
			FROM jobcategory 
			WHERE id=?';
	$rows = dbi_get_cached_rows($sql, array($id));
	
	$jobcat = null;
	if(count($rows) == 1) {
		$row = $rows[0];
		$jobcat = new JobCategory($row[0], $row[1], $row[2]);
	}

	return $jobcat;
}

function listAllJobCategories($site_id) {
	$sql = 'SELECT id, name, site_id FROM jobcategory WHERE site_id=?';
	$rows = dbi_get_cached_rows($sql, array($site_id));
	
	$jobcats = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$jc = new JobCategory($row[0], $row[1], $row[2]);
		$jobcats[] = $jc;
	}
	
	return $jobcats;
}

function listUserJobCategories($login) {
	$sql = 'SELECT jc.id, jc.name 
			FROM jobcategory jc, user_jobcategory uj
			WHERE uj.cal_login=? AND uj.jobcategory_id=jc.id';
	$rows = dbi_get_cached_rows($sql, array($login));
	
	$jobcats = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$jc = new JobCategory($row[0], $row[1], $row[2]);
		$jobcats[] = $jc;
	}
	
	return $jobcats;
}

function updateUserJobCategories($login, $categoryArr) {
	$sql = 'DELETE FROM user_jobcategory WHERE cal_login=?';
	dbi_execute($sql, array($login));
	
	if (!empty($categoryArr)) {
		foreach ($categoryArr as $cat) {
			$sql = 'INSERT INTO user_jobcategory(cal_login, jobcategory_id) VALUES (?,?)';
			dbi_execute($sql, array($login, $cat, $site_id));				
		}
	}
	
	dbi_clear_cache();
}

?>