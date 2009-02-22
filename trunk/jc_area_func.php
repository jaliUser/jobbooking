<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/Area.php';

function listAreas($site_id) {
	$sql = 'SELECT id, site_id, name, description FROM area WHERE site_id=?';
	$rows = dbi_get_cached_rows($sql, array($site_id));
	
	$areas = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$a = new Area($row[0], $row[1], $row[2], $row[3]);
		$areas[] = $a;
	}
	
	return $areas;
}

function getArea($job_id) {
	$sql = 'SELECT area.id, area.site_id, area.name, area.description 
			FROM area, job 
			WHERE area.id=job.area_id AND job.id=?';
	$rows = dbi_get_cached_rows($sql, array($job_id));
	
	$area = null;
	if(count($rows == 1)) {
		$row = $rows[0];
		$area = new Area($row[0], $row[1], $row[2], $row[3]);
	}
	
	return $area;
}

?>