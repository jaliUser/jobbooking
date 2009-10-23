<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/Job.php';
include_once 'jc_timeslot_func.php';

function createJob(Job $j) {
	global $login;
	//auto-increment id
	$sql = "INSERT INTO job (site_id, area_id, owner_id, name, description, meetplace, jobplace, notes, status, priority, def_date, def_user, upd_user) VALUES (?,?,?,?,?,?,?,?,?,?,now(),'$login','$login')";
	dbi_execute($sql, array($j->siteID, $j->areaID, $j->ownerID, $j->name, $j->description, $j->meetplace, $j->jobplace, $j->notes, $j->status, $j->priority));

	dbi_clear_cache();
	//	return $id;
}

function updateJob(Job $j) {
	global $login;
	$sql = "UPDATE job SET area_id=?, owner_id=?, name=?, description=?, meetplace=?, jobplace=?, notes=?, status=?, priority=?, upd_user='$login' WHERE id=?";
	dbi_execute($sql, array($j->areaID, $j->ownerID, $j->name, $j->description, $j->meetplace, $j->jobplace, $j->notes, $j->status, $j->priority, $j->id));	

	dbi_clear_cache();
}

function deleteJob(Job $j) {
	//NOTE: update status to D (deleted) instead)
	
	$sql = 'DELETE FROM webcal_entry_user WHERE cal_id 
			IN (SELECT cal_id FROM webcal_entry WHERE job_id=?)';
	dbi_execute($sql, array($j->id));
	
	$sql = 'DELETE FROM webcal_entry WHERE job_id=?';
	dbi_execute($sql, array($j->id));
	
	$sql = 'DELETE FROM job WHERE id=?';
	dbi_execute($sql, array($j->id));

	dbi_clear_cache();
}

function updateJobStatus($job_id, $status) {
	global $login;
	$sql = "UPDATE job SET status=?, upd_user='$login' WHERE id=?";
	dbi_execute($sql, array($status, $job_id));	

	dbi_clear_cache();
}

function listJobs($site_id, $status=null, $owner_id=null, $filter=null) {
	if(!empty($status) && !empty($owner_id)) {
		//arearesponsible's nonapproved
		$sql = "SELECT j.id, j.site_id, j.area_id, j.owner_id, j.name, j.description, j.meetplace, j.jobplace, j.notes, j.status, j.priority, SUM(we.person_need), SUM(we.cal_duration * we.person_need)
				FROM job j 
				LEFT JOIN webcal_entry we ON we.job_id=j.id
				LEFT JOIN area a on j.area_id=a.id
				WHERE j.site_id=? AND j.status=? AND a.contact_id=?
				GROUP BY j.id";
		$rows = dbi_get_cached_rows($sql, array($site_id, $status, $owner_id));
	}
	elseif(!empty($status)) {
		//not approved
		$sql = "SELECT j.id, j.site_id, j.area_id, j.owner_id, j.name, j.description, j.meetplace, j.jobplace, j.notes, j.status, j.priority, SUM(we.person_need), SUM(we.cal_duration * we.person_need)
				FROM job j 
				LEFT JOIN webcal_entry we ON we.job_id=j.id
				WHERE j.site_id=? AND j.id>0 AND j.status=?
				GROUP BY j.id";
		$rows = dbi_get_cached_rows($sql, array($site_id, $status));
	}
	elseif (!empty($owner_id)) {
		//user X's jobs
		$sql = "SELECT j.id, j.site_id, j.area_id, j.owner_id, j.name, j.description, j.meetplace, j.jobplace, j.notes, j.status, j.priority, SUM(we.person_need), SUM(we.cal_duration * we.person_need)
				FROM job j 
				LEFT JOIN webcal_entry we ON we.job_id=j.id
				WHERE j.site_id=? AND j.id>0 AND j.owner_id=?
				GROUP BY j.id";
		$rows = dbi_get_cached_rows($sql, array($site_id, $owner_id));
	}
	elseif (!empty($filter)) {
		//filter vacant
		$sql = "SELECT j.id, j.site_id, j.area_id, j.owner_id, j.name, j.description, j.meetplace, j.jobplace, j.notes, j.status, j.priority, SUM(we.person_need) AS need, SUM(we.cal_duration * we.person_need)
				FROM job j 
				LEFT JOIN webcal_entry we ON we.job_id=j.id
				WHERE j.site_id=? AND j.id>0 AND j.status='A'
				GROUP BY j.id 
				HAVING need > 0";
		$rows = dbi_get_cached_rows($sql, array($site_id));
	}
	else {
		//all approved
		$sql = "SELECT j.id, j.site_id, j.area_id, j.owner_id, j.name, j.description, j.meetplace, j.jobplace, j.notes, j.status, j.priority, SUM(we.person_need), SUM(we.cal_duration * we.person_need)  
				FROM job j 
				LEFT JOIN webcal_entry we ON we.job_id=j.id
				WHERE j.site_id=? AND j.id>0 AND j.status='A'
				GROUP BY j.id";
		$rows = dbi_get_cached_rows($sql, array($site_id));
	}
	
	$sql_signups = "SELECT j.id, SUM(weu.count), SUM(we.cal_duration * weu.count)
					FROM job j 
					LEFT JOIN webcal_entry we ON we.job_id=j.id
					LEFT JOIN webcal_entry_user weu ON we.cal_id=weu.cal_id
					WHERE j.site_id=? AND j.id>0 AND j.status='A' AND weu.count IS NOT NULL
					GROUP BY j.id";
	$rows_signups = dbi_get_cached_rows($sql_signups, array($site_id));
	
	$signups = array();
	for ($i=0; $i<count($rows_signups); $i++) { 
		$jobid = $rows_signups[$i][0];
		$signups[$jobid] = $rows_signups[$i];
	}
	
	$jobs = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$j = new Job($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]);
		$j->totalNeed = $row[11];
		$j->remainingNeed = $row[11] - $signups[$row[0]][1];
		$j->totalHours = $row[12] / 60;
		$j->remainingHours = ($row[12] - $signups[$row[0]][2]) / 60;
		$jobs[] = $j;
	}
	
	return $jobs;
}

function getJob($job_id) {
	$sql = 'SELECT id, site_id, area_id, owner_id, name, description, meetplace, jobplace, notes, status, priority, def_date, def_user, upd_date, upd_user FROM job WHERE id=?';
	$rows = dbi_get_cached_rows($sql, array($job_id));
	
	$job = null;
	if(count($rows) == 1) { 
		$row = $rows[0];
		$job = new Job($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]);
		$job->defDate = $row[11];
		$job->defUser = $row[12];
		$job->updDate = $row[13];
		$job->updUser = $row[14];
	}
	
	return $job;
}

?>
