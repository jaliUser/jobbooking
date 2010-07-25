<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/Job.php';
include_once 'jc_timeslot_func.php';

function createJob(Job $j) {
	global $login;
	$id = 0;
	$res = dbi_execute ( 'SELECT MAX(id) FROM job' );
    if ( $res ) {
      $row = dbi_fetch_row ( $res );
      $id = $row[0] + 1;
      dbi_free_result ( $res );
    } else {
      $id = 1;
    }
    
	//auto-increment id
	$sql = "INSERT INTO job (id, site_id, area_id, owner_id, name, description, meetplace, jobplace, notes, status, priority, type, def_date, def_user, upd_user) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,now(),'$login','$login')";
	dbi_execute($sql, array($id, $j->siteID, $j->areaID, $j->ownerID, $j->name, $j->description, $j->meetplace, $j->jobplace, $j->notes, $j->status, $j->priority, $j->type));

	dbi_clear_cache();
	return $id;
}

function updateJob(Job $j) {
	global $login;
	$sql = "UPDATE job SET area_id=?, owner_id=?, name=?, description=?, meetplace=?, jobplace=?, notes=?, status=?, priority=?, type=?, upd_user='$login' WHERE id=?";
	dbi_execute($sql, array($j->areaID, $j->ownerID, $j->name, $j->description, $j->meetplace, $j->jobplace, $j->notes, $j->status, $j->priority, $j->type, $j->id));

	dbi_clear_cache();
}

function deleteJob($job_id) {
	//NOTE: update status to D (deleted) instead)
	
	$sql = 'DELETE FROM webcal_entry_user WHERE cal_id 
			IN (SELECT cal_id FROM webcal_entry WHERE job_id=?)';
	dbi_execute($sql, array($job_id));
	
	$sql = 'DELETE FROM webcal_entry WHERE job_id=?';
	dbi_execute($sql, array($job_id));
	
	$sql = 'DELETE FROM job WHERE id=?';
	dbi_execute($sql, array($job_id));

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
		$sql = "SELECT j.id, j.site_id, j.area_id, j.owner_id, j.name, j.description, j.meetplace, j.jobplace, j.notes, j.status, j.priority, j.type, SUM(we.person_need), SUM(we.cal_duration * we.person_need), j.def_date, j.def_user, j.upd_date, j.upd_user
				FROM job j 
				LEFT JOIN webcal_entry we ON we.job_id=j.id
				LEFT JOIN area a on j.area_id=a.id
				WHERE j.type='WN' AND j.site_id=? AND j.status=? AND a.contact_id=?
				GROUP BY j.id";
		$rows = dbi_get_cached_rows($sql, array($site_id, $status, $owner_id));
	}
	elseif(!empty($status)) {
		//not approved
		$sql = "SELECT j.id, j.site_id, j.area_id, j.owner_id, j.name, j.description, j.meetplace, j.jobplace, j.notes, j.status, j.priority, j.type, SUM(we.person_need), SUM(we.cal_duration * we.person_need), j.def_date, j.def_user, j.upd_date, j.upd_user
				FROM job j 
				LEFT JOIN webcal_entry we ON we.job_id=j.id
				WHERE j.type='WN' AND j.site_id=? AND j.id>0 AND j.status=?
				GROUP BY j.id";
		$rows = dbi_get_cached_rows($sql, array($site_id, $status));
	}
	elseif (!empty($owner_id)) {
		//user X's jobs - no WHERE on j.type
		$sql = "SELECT j.id, j.site_id, j.area_id, j.owner_id, j.name, j.description, j.meetplace, j.jobplace, j.notes, j.status, j.priority, j.type, SUM(we.person_need), SUM(we.cal_duration * we.person_need), j.def_date, j.def_user, j.upd_date, j.upd_user
				FROM job j 
				LEFT JOIN webcal_entry we ON we.job_id=j.id
				WHERE j.site_id=? AND j.id>0 AND j.owner_id=?
				GROUP BY j.id";
		$rows = dbi_get_cached_rows($sql, array($site_id, $owner_id));
	}
	elseif (!empty($filter)) {
		//filter vacant
		$sql = "SELECT j.id, j.site_id, j.area_id, j.owner_id, j.name, j.description, j.meetplace, j.jobplace, j.notes, j.status, j.priority, j.type, SUM(we.person_need) AS need, SUM(we.cal_duration * we.person_need), j.def_date, j.def_user, j.upd_date, j.upd_user
				FROM job j 
				LEFT JOIN webcal_entry we ON we.job_id=j.id
				WHERE j.type='WN' AND j.site_id=? AND j.id>0 AND j.status='A'
				GROUP BY j.id 
				HAVING need > 0";
		$rows = dbi_get_cached_rows($sql, array($site_id));
	}
	else {
		//all approved
		$sql = "SELECT j.id, j.site_id, j.area_id, j.owner_id, j.name, j.description, j.meetplace, j.jobplace, j.notes, j.status, j.priority, j.type, SUM(we.person_need), SUM(we.cal_duration * we.person_need), j.def_date, j.def_user, j.upd_date, j.upd_user  
				FROM job j 
				LEFT JOIN webcal_entry we ON we.job_id=j.id
				WHERE j.type='WN' AND j.site_id=? AND j.id>0 AND j.status='A'
				GROUP BY j.id";
		$rows = dbi_get_cached_rows($sql, array($site_id));
	}
	
	$sql_signups = "SELECT j.id, SUM(weu.count), SUM(we.cal_duration * weu.count)
					FROM job j 
					LEFT JOIN webcal_entry we ON we.job_id=j.id
					LEFT JOIN webcal_entry_user weu ON we.cal_id=weu.cal_id
					WHERE j.type='WN' AND j.site_id=? AND j.id>0 AND j.status='A' AND weu.count IS NOT NULL
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
		$j = new Job($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]);
		$j->totalNeed = $row[12];
		$j->remainingNeed = $row[12] - $signups[$row[0]][1];
		$j->totalHours = round($row[13] / 60, 1);
		$j->remainingHours = round(($row[13] - $signups[$row[0]][2]) / 60, 1);
		$j->defDate = $row[14];
		$j->defUser = $row[15];
		$j->updDate = $row[16];
		$j->updUser = $row[17];
		$jobs[] = $j;
	}
	
	return $jobs;
}

function listJobsNoNeed($site_id, $status=null, $owner_id=null) {
	if(!empty($status)) {
		//not approved
		$sql = "SELECT j.id, j.site_id, j.area_id, j.owner_id, j.name, j.description, j.meetplace, j.jobplace, j.notes, j.status, j.priority, j.type
				FROM job j 
				WHERE j.type='NN' AND j.site_id=? AND j.status=?";
		$rows = dbi_get_cached_rows($sql, array($site_id, $status));
	}
	elseif (!empty($owner_id)) {
		//user X's jobs
		$sql = "SELECT j.id, j.site_id, j.area_id, j.owner_id, j.name, j.description, j.meetplace, j.jobplace, j.notes, j.status, j.priority, j.type
				FROM job j 
				WHERE j.type='NN' AND j.site_id=? AND j.owner_id=?";
		$rows = dbi_get_cached_rows($sql, array($site_id, $owner_id));
	}
	else {
		//all approved
		$sql = "SELECT j.id, j.site_id, j.area_id, j.owner_id, j.name, j.description, j.meetplace, j.jobplace, j.notes, j.status, j.priority, j.type  
				FROM job j 
				WHERE j.type='NN' AND j.site_id=? AND j.status='A'";
		$rows = dbi_get_cached_rows($sql, array($site_id));
	}
	
	$jobs = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$j = new Job($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]);
		$jobs[] = $j;
	}
	
	return $jobs;
}

function getJob($job_id) {
	$sql = 'SELECT id, site_id, area_id, owner_id, name, description, meetplace, jobplace, notes, status, priority, type, def_date, def_user, upd_date, upd_user FROM job WHERE id=?';
	$rows = dbi_get_cached_rows($sql, array($job_id));
	
	$job = null;
	if(count($rows) == 1) { 
		$row = $rows[0];
		$job = new Job($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11]);
		$job->defDate = $row[12];
		$job->defUser = $row[13];
		$job->updDate = $row[14];
		$job->updUser = $row[15];
	}
	
	return $job;
}

function print_job_details(Job $job, $showCreatedUpdatedBy = true) {
	$owner = getUser($job->ownerID);
	echo '<h1><i>'.$job->name.'</i> (ID '.$job->id.')</h1>
		<table align="center" class="border1">
		<tr><th align="left">Ansvarlig:</th><td><a href="jc_user.php?action=show_one&login='.$job->ownerID.'">'.$owner->getFullName().'</a> (tlf. '.$owner->telephone.')</td></tr>
		<tr><th align="left">Område:</th><td>'.getArea($job->id)->description.' ('.getArea($job->id)->name.')</td></tr>
		<tr><th align="left">Beskrivelse af opgaven:</th><td>'.nl2br($job->description).'</td></tr>
		<tr><th align="left">Mødested:</th><td>'.$job->meetplace.'</td></tr>
		<tr><th align="left">Jobsted:</th><td>'.$job->jobplace.'</td></tr>
		<tr><th align="left">Bemærkninger:</th><td>'.$job->notes.'</td></tr>
		<tr><th align="left">Status:</th><td>'.$job->getLongStatus().'</td></tr>';
	if (user_is_admin() && $showCreatedUpdatedBy) {
		echo "
		<tr><th align='left'>Oprettet:</th><td>$job->defDate (<a href='jc_user.php?action=show_one&login=$job->defUser'>".getUser($job->defUser)->getFullName()."</a>)</td></tr>
		<tr><th align='left'>Opdateret:</th><td>$job->updDate (<a href='jc_user.php?action=show_one&login=$job->updUser'>".getUser($job->updUser)->getFullName()."</a>)</td></tr>
		";
	}
	echo '</table>';
}

?>
