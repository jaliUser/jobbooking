<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/SiteConfig.php';

function getSiteConfig($site_id) {
	$sql = 'SELECT c.cal_setting, c.cal_value, s.name 
			FROM webcal_config c, site s 
			WHERE c.site_id=? AND c.site_id=s.id';
	$rows = dbi_get_cached_rows($sql, array($site_id));
	
	$configs = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$configs[$row[0]] = $row[1]; 
	}
	
	$siteConfig = new SiteConfig($site_id, $row[2], $configs);
	
	return $siteConfig;
}

?>