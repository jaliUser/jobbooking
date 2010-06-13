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
	var $noEmail;
	var $isContacted;
	var $signups; //not in DB
	var $signupsDuration; //not in DB
	var $signupsDurationEach; //not in DB
	
	function User($login, $passwd, $lastname, $firstname, $isAdmin, $email, $enabled, $telephone, $address, $title, $birthday, $lastLogin, $roleID, $siteID, $groupID, $count, $ageRange, $qualifications, $notes, $extLogin, $noEmail, $isContacted) {
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
		$this->noEmail = $noEmail;
		$this->isContacted = $isContacted;
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
	
	function getFullNameAndLogin() {
		return $this->firstname . " " . $this->lastname . " (" . $this->login . ")";
	}
	
	static function isValidUsername($login) {
		if (!preg_match("!^[a-z0-9_]{0,25}$!i", $login)) {
			return false;
		} else {
			return true;
		}
	}

	static function sortByFirstname(User $userA, User $userB) {
		if ($userA->firstname == $userB->firstname) {
			return 0;
		}
		return ($userA->firstname < $userB->firstname) ? -1 : 1;
	}

	static function sortByLogin(User $userA, User $userB) {
		if ($userA->login == $userB->login) {
			return 0;
		}
		return ($userA->login < $userB->login) ? -1 : 1;
	}
	
	static function sortByCount(User $userA, User $userB) {
		if ($userA->count == $userB->count) {
			return 0;
		}
		return ($userA->count < $userB->count) ? -1 : 1;
	}
	
	static function sortBySignups(User $userA, User $userB) {
		if ($userA->signups == $userB->signups) {
			return 0;
		}
		return ($userA->signups < $userB->signups) ? -1 : 1;
	}
	
	static function sortBySignupsDuration(User $userA, User $userB) {
		if ($userA->signupsDuration == $userB->signupsDuration) {
			return 0;
		}
		return ($userA->signupsDuration < $userB->signupsDuration) ? -1 : 1;
	}
}
?>