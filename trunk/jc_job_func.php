<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/Job.php';

function createJob(Job $j) {
	//auto-increment id
	$sql = 'INSERT INTO job (site_id, area_id, owner_id, name, description, place, notes) VALUES (?,?,?,?,?,?,?)';
	dbi_execute($sql, array($j->siteID, $j->areaID, $j->ownerID, $j->name, $j->description, $j->place, $j->notes));

	dbi_clear_cache();
	//	return $id;
}

function updateJob(Job $j) {
	$sql = 'UPDATE job SET area_id=?, owner_id=?, name=?, description=?, place=?, notes=? WHERE id=?';
	dbi_execute($sql, array($j->areaID, $j->ownerID, $j->name, $j->description, $j->place, $j->notes, $j->id));	

	dbi_clear_cache();
}

function deleteJob(Job $j) {
	$sql = 'DELETE FROM job WHERE id=?';
	dbi_execute($sql, array($j->_id));

	dbi_clear_cache();
}

function listJobs($site_id) {
	$sql = 'SELECT id, site_id, area_id, owner_id, name, description, place, notes FROM job WHERE site_id=?';
	$rows = dbi_get_cached_rows($sql, array($site_id));
	
	$jobs = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$j = new Job($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7]);
		$jobs[] = $j;
	}
	
	return $jobs;
}

function getJob($job_id) {
	$sql = 'SELECT id, site_id, area_id, owner_id, name, description, place, notes FROM job WHERE id=?';
	$rows = dbi_get_cached_rows($sql, array($job_id));
	
	$job = null;
	if(count($rows) == 1) { 
		$row = $rows[0];
		$job = new Job($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7]);
	}
	
	return $job;
}

?>
