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
	var $groupID;
	var $count;
	var $ageRange;
	var $qualifications;
	var $notes;
	var $extLogin;
	
	function User($login, $passwd, $lastname, $firstname, $isAdmin, $email, $enabled, $telephone, $address, $title, $birthday, $lastLogin, $roleID, $siteID, $groupID, $count, $ageRange, $qualifications, $notes, $extLogin) {
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
		$this->groupID = $groupID;
		$this->count = $count;
		$this->ageRange = $ageRange;
		$this->qualifications = $qualifications;
		$this->notes = $notes;
		$this->extLogin = $extLogin;
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
	
	static function isValidUsername($login) {
		if (!preg_match("!^[a-z0-9_]{0,25}$!i", $login)) {
			return false;
		} else {
			return true;
		}
	}
}

?>