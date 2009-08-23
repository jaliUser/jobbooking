<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/Job.php';
include_once 'jc_timeslot_func.php';

function createJob(Job $j) {
	//auto-increment id
	$sql = 'INSERT INTO job (site_id, area_id, owner_id, name, description, meetplace, jobplace, notes, status, priority) VALUES (?,?,?,?,?,?,?,?,?,?)';
	dbi_execute($sql, array($j->siteID, $j->areaID, $j->ownerID, $j->name, $j->description, $j->meetplace, $j->jobplace, $j->notes, $j->status, $j->priority));

	dbi_clear_cache();
	//	return $id;
}

function updateJob(Job $j) {
	$sql = 'UPDATE job SET area_id=?, owner_id=?, name=?, description=?, meetplace=?, jobplace=?, notes=?, status=?, priority=? WHERE id=?';
	dbi_execute($sql, array($j->areaID, $j->ownerID, $j->name, $j->description, $j->meetplace, $j->jobplace, $j->notes, $j->status, $j->priority, $j->id));	

	dbi_clear_cache();
}

function deleteJob(Job $j) {
	$sql = 'DELETE FROM job WHERE id=?';
	dbi_execute($sql, array($j->id));

	dbi_clear_cache();
}

function disableJob(Job $j) {
	$sql = 'UPDATE job SET status="D" WHERE id=?';
	dbi_execute($sql, array($j->id));

	dbi_clear_cache();
}

function listJobs($site_id, $status=null, $show_negative=false, $owner_id=null, $filter=null) {
	if(!empty($status)) {
		$sql = 'SELECT id, site_id, area_id, owner_id, name, description, meetplace, jobplace, notes, status, priority 
				FROM job WHERE site_id=? AND status=?';
		$rows = dbi_get_cached_rows($sql, array($site_id, $status));
	}
	elseif (!empty($owner_id)) {
		$sql = 'SELECT id, site_id, area_id, owner_id, name, description, meetplace, jobplace, notes, status, priority 
				FROM job WHERE site_id=? AND id>0 AND owner_id=?';
		
		$rows = dbi_get_cached_rows($sql, array($site_id, $owner_id));
	}
	elseif (!empty($filter)) {
		$sql = 'SELECT id, site_id, area_id, owner_id, name, description, meetplace, jobplace, notes, status, priority  
				FROM job 
				WHERE site_id=? AND id>0';
		$all_jobs = dbi_get_cached_rows($sql, array($site_id));
		
		for ($ji=0; $ji<count($all_jobs); $ji++) {
			$sql = 'SELECT we.cal_id, we.person_need, SUM(weu.count)
					FROM webcal_entry we
					LEFT JOIN webcal_entry_user weu
					ON we.cal_id=weu.cal_id 
					WHERE job_id=? 
					GROUP BY we.cal_id';
			$timeslot_rows = dbi_get_cached_rows($sql, array($all_jobs[$ji][0]));
			
			$all_job_timeslots_full = true;
			for ($ti=0; $ti<count($timeslot_rows); $ti++) {
				if ($timeslot_rows[$ti][1] > $timeslot_rows[$ti][2]) {
					$all_job_timeslots_full = false;
				}
			}
			
			if ($all_job_timeslots_full == false) {
				$rows[] = $all_jobs[$ji];
			}
		}
	}
	else {
		$sql = 'SELECT id, site_id, area_id, owner_id, name, description, meetplace, jobplace, notes, status, priority 
				FROM job WHERE site_id=? AND id '.($show_negative==true? '<0' : '>0');
		$rows = dbi_get_cached_rows($sql, array($site_id));
	}
	
	$jobs = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$j = new Job($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]);
		$jobs[] = $j;
	}
	
	return $jobs;
}

function getJob($job_id) {
	$sql = 'SELECT id, site_id, area_id, owner_id, name, description, meetplace, jobplace, notes, status, priority FROM job WHERE id=?';
	$rows = dbi_get_cached_rows($sql, array($job_id));
	
	$job = null;
	if(count($rows) == 1) { 
		$row = $rows[0];
		$job = new Job($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]);
	}
	
	return $job;
}

?>
