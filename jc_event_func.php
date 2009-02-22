<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/Event.class';

/*
 * Event is used as timeperiod for a Job
 */

function createEvent(Event $e) {
	//auto-increment id
	$sql = 'INSERT INTO job () VALUES (?)';
	dbi_execute($sql, array());

	dbi_clear_cache();
	//	return $id;
}

function updateEvent(Event $e) {
	$sql = 'UPDATE webcal_entry SET ';
	dbi_execute($sql, array());

	dbi_clear_cache();
}

function deleteEvent(Event $e) {
	//TODO: delete from other tables or use builtin func
	$sql = 'DELETE FROM webcal_entry WHERE cal_id=?';
	dbi_execute($sql, array($e->getID()));

	dbi_clear_cache();
}

function listEvents($jobID) {
	//webcal_entry cols: 
	//cal_id, cal_group_id, cal_ext_for_id, cal_create_by, cal_date, cal_time, cal_mod_date,
	//cal_mod_time, cal_duration, cal_due_date, cal_due_time, cal_priority, cal_type,
	//cal_access, cal_name, cal_location, cal_url, cal_completed, cal_description, job_id

	$sql = 'SELECT cal_id, cal_group_id, cal_ext_for_id, cal_create_by, cal_date, cal_time, cal_mod_date,
			cal_mod_time, cal_duration, cal_due_date, cal_due_time, cal_priority, cal_type, 
			cal_access, cal_name, cal_location, cal_url, cal_completed, cal_description 
			FROM webcal_entry WHERE job_id=?';
	$rows = dbi_get_cached_rows($sql, array($jobID));

	$events = array();
	foreach ($rows as $row) {
		$id = $row[0];
		$group_id = $row[1];
		$ext_for_id = $row[2];
		$create_by = $row[3]; //owner
		$date = $row[4];
		$time = $row[5];
		$mod_date = $row[6];
		$mod_time = $row[7];
		$duration = $row[8];
		$due_date = $row[9];
		$due_time = $row[10];
		$priority = $row[11];
		$type = $row[12];
		$access = $row[13];
		$name = $row[14];
		$location = $row[15];
		$url = $row[16];
		$completed = $row[17];
		$description = $row[18];

		//from webcal_entry_user
		$status = null;
		$category = null;
		$login = null;
		$percent = null;
		
		//TODO: add job_id
		
		$e = new Event($name, $description, $date, $time, $id, $ext_for_id, $priority, $access, 
			$duration, $status, $create_by, $category, $login, $type, $location, $url, $due_date, 
			$due_time, $percent, $mod_date, $mod_time);
		
		$events[] = $e;
	}

	return $events;
}

?>