<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/Subcamp.php';

function listSubcamps($site_id) {
	$sql = 'SELECT id, site_id, name, district_id FROM subcamp WHERE site_id=?';
	$rows = dbi_get_cached_rows($sql, array($site_id));
	
	$subcamps = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$r = new Subcamp($row[0], $row[1], $row[2], $row[3]);
		$subcamps[] = $r;
	}
	
	return $subcamps;
}

?>