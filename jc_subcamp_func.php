<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/Subcamp.php';

function getSubcamp($subcamp_id) {
	$sql = 'SELECT id, site_id, name, contact_id FROM subcamp WHERE id=?';
	$rows = dbi_get_cached_rows($sql, array($subcamp_id));
	
	$subcamp = null;
	if(count($rows) == 1) { 
		$row = $rows[0];
		$subcamp = new Subcamp($row[0], $row[1], $row[2], $row[3]);
	}
	
	return $subcamp;
}

function listSubcamps($site_id) {
	$sql = 'SELECT id, site_id, name, contact_id FROM subcamp WHERE site_id=?';
	$rows = dbi_get_cached_rows($sql, array($site_id));
	
	$subcamps = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$r = new Subcamp($row[0], $row[1], $row[2], $row[3]);
		$subcamps[$r->id] = $r;
	}
	
	return $subcamps;
}

function getSubcampForUser($cal_login) {
	$sql = 'SELECT s.id, s.site_id, s.name, s.contact_id FROM subcamp s, `group` g, district d, webcal_user u 
			WHERE u.cal_login=? AND u.group_id=g.id AND g.district_id=d.id AND d.subcamp_id=s.id';
	$rows = dbi_get_cached_rows($sql, array($cal_login));
	
	$subcamp = null;
	if (count($rows) == 1) {
		$row = $rows[0];
		$subcamp = new Subcamp($row[0], $row[1], $row[2], $row[3]);
	}
	
	return $subcamp;
}

function getSubcampForContact($cal_login) {
	$sql = 'SELECT s.id, s.site_id, s.name, s.contact_id FROM subcamp s 
			WHERE s.contact_id=?';
	$rows = dbi_get_cached_rows($sql, array($cal_login));
	
	$subcamp = null;
	if (count($rows) == 1) {
		$row = $rows[0];
		$subcamp = new Subcamp($row[0], $row[1], $row[2], $row[3]);
	}
	
	return $subcamp;
}

?>