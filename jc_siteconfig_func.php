<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/SiteConfig.php';

function getSiteConfig($site_id) {
	$sql = 'SELECT c.cal_setting, c.cal_value, s.name 
			FROM site s
			LEFT JOIN webcal_config c ON s.id = c.site_id 
			WHERE s.id=?';
	$rows = dbi_get_cached_rows($sql, array($site_id));
	
	$configs = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$configs[$row[0]] = $row[1]; 
	}
	
	$siteConfig = new SiteConfig($site_id, $rows[0][2], $configs);
	return $siteConfig;
}

function listSiteConfigs() {
	$sql = 'SELECT id
			FROM site';
	$rows = dbi_get_cached_rows($sql, array($site_id));
	
	$list = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$list[] = getSiteConfig($rows[$i][0]); 
	}
	
	return $list;
}

?>