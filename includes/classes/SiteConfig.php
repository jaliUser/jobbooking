<?php

class SiteConfig {
	var $siteID;
	var $siteName;
	var $config;

	function SiteConfig($siteID, $siteName, $config) {
		$this->siteID = $siteID;
		$this->siteName = $siteName;
		$this->config = $config;
	}

	static function cast(SiteConfig $siteConfig) {
		return $siteConfig;
	}
	
	static $EMAIL = "JC_EMAIL";
	static $EMAIL_FROM = "JC_EMAIL_FROM";
	static $HELP_URL = "JC_HELP_URL";
	static $SITE_URL = "JC_SITE_URL";
}

?>