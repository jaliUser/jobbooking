<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/Area.php';

function createArea(Area $a) {
	global $login;	

	//auto-increment id
	$sql = "INSERT INTO area (site_id, name, description, contact_id, def_date, def_user, upd_user) VALUES (?,?,?,?,now(),'$login','$login')";
	dbi_execute($sql, array($a->siteID, $a->name, $a->description, $a->contactID));

	dbi_clear_cache();
}

function updateArea(Area $a) {
	global $login;
	$sql = "UPDATE area SET name=?, description=?, contact_id=?, upd_user=? WHERE id=?";
	dbi_execute($sql, array($a->name, $a->description, $a->contactID, $login, $a->id));

	dbi_clear_cache();
}

function deleteArea(Area $a) {
	if (!isAreaUsed($a->id)) {
		$sql = "DELETE FROM area WHERE id=?";
		dbi_execute($sql, array($a->id));
	
		dbi_clear_cache();
	}
}

function isAreaUsed($area_id) {
	$sql = 'SELECT count(*) FROM job WHERE area_id=?';
	$rows = dbi_get_cached_rows($sql, $area_id);
	
	if ($rows[0][0] == 0) {
		return false;
	} else {
		return true;
	}
}

function listAreas($site_id) {
	$sql = 'SELECT id, site_id, name, description, contact_id FROM area WHERE site_id=? ORDER BY name';
	$rows = dbi_get_cached_rows($sql, array($site_id));
	
	$areas = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$a = new Area($row[0], $row[1], $row[2], $row[3], $row[4]);
		$areas[] = $a;
	}
	
	return $areas;
}

function getArea($job_id) {
	$sql = 'SELECT area.id, area.site_id, area.name, area.description, area.contact_id 
			FROM area, job 
			WHERE area.id=job.area_id AND job.id=?';
	$rows = dbi_get_cached_rows($sql, array($job_id));
	
	$area = null;
	if(count($rows == 1)) {
		$row = $rows[0];
		$area = new Area($row[0], $row[1], $row[2], $row[3], $row[4]);
	}
	
	return $area;
}

function getAreaFromId($area_id) {
	$sql = 'SELECT area.id, area.site_id, area.name, area.description, area.contact_id 
			FROM area
			WHERE area.id=?';
	$rows = dbi_get_cached_rows($sql, array($area_id));
	
	$area = null;
	if(count($rows == 1)) {
		$row = $rows[0];
		$area = new Area($row[0], $row[1], $row[2], $row[3], $row[4]);
	}
	
	return $area;
}

function getAreaFromContact($user_id) {
	$sql = 'SELECT area.id, area.site_id, area.name, area.description, area.contact_id 
			FROM area 
			WHERE area.contact_id=?';
	$rows = dbi_get_cached_rows($sql, array($user_id));
	
	$area = null;
	if(count($rows == 1)) {
		$row = $rows[0];
		$area = new Area($row[0], $row[1], $row[2], $row[3], $row[4]);
	}
	
	return $area;
}

?>