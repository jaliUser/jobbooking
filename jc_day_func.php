<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/Day.php';

function listDays($site_id) {
	$sql = 'SELECT id, site_id, date FROM days WHERE site_id=?';
	$rows = dbi_get_cached_rows($sql, array($site_id));
	
	$days = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$d = new Day($row[0], $row[1], $row[2]);
		$days[] = $d;
	}
	
	return $days;
}

?>