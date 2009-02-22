<?php

class User {
	var $login;
	var $passwd;
	var $lastname;
	var $firstname;
	var $isAdmin;
	var $email;
	var $enabled;
	var $telephone;
	var $address;
	var $title;
	var $birthday;
	var $lastLogin;
	var $roleID;
	var $siteID;
	
	function User($login, $passwd, $lastname, $firstname, $isAdmin, $email, $enabled, $telephone, $address, $title, $birthday, $lastLogin, $roleID, $siteID) {
		$this->login = $login;
		$this->passwd = $passwd;
		$this->lastname = $lastname;
		$this->firstname = $firstname;
		$this->isAdmin = $isAdmin;
		$this->email = $email;
		$this->enabled = $enabled;
		$this->telephone = $telephone;
		$this->address = $address;
		$this->title = $title;
		$this->birthday = $birthday;
		$this->lastLogin = $lastLogin;
		$this->roleID = $roleID;
		$this->siteID = $siteID;
	}

	static function cast(User $user) {
		return $user;
	}
	
	function setPasswd($plaintextPasswd) {
		$this->passwd = md5($plaintextPasswd); //calculate MD5
	}
	
	function getFullName() {
		return $this->firstname . " " . $this->lastname;
	}
}

?>