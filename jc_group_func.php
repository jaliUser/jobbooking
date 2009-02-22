<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/Group.php';

function listGroups($district_id) {
	$sql = 'SELECT id, site_id, name, district_id FROM group WHERE district_id=?';
	$rows = dbi_get_cached_rows($sql, array($district_id));
	
	$groups = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$r = new Group($row[0], $row[1], $row[2], $row[3]);
		$groups[] = $r;
	}
	
	return $groups;
}

?>