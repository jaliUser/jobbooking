<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/District.php';

function listDistricts($site_id) {
	$sql = 'SELECT id, site_id, name FROM district WHERE site_id=?';
	$rows = dbi_get_cached_rows($sql, array($site_id));
	
	$districts = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$r = new District($row[0], $row[1], $row[2]);
		$districts[] = $r;
	}
	
	return $districts;
}

?>