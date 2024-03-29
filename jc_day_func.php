<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/Day.php';

function listDays($site_id) {
	$sql = 'SELECT id, site_id, date, time 
			FROM days 
			WHERE site_id=?
			ORDER BY date';
	$rows = dbi_get_cached_rows($sql, array($site_id));
	
	$days = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$d = new Day($row[0], $row[1], $row[2], $row[3]);
		$days[] = $d;
	}
	
	return $days;
}

function getFirstDay($site_id) {
	$sql = 'SELECT id, site_id, date, time 
			FROM days 
			WHERE site_id=?
			ORDER BY date';
	$rows = dbi_get_cached_rows($sql, array($site_id));
	
	if (count($rows) > 0) {
		$day = new Day($row[0], $row[1], $row[2], $row[3]);
	}
	
	return $day;
}

?>