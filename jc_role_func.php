<?php
include_once 'includes/dbi4php.php';
include_once 'includes/classes/Role.php';

/*
function createUser(User $u) {
	//auto-increment id
	$sql = 'INSERT INTO webcal_user () VALUES (?)';
	dbi_execute($sql, array());

	dbi_clear_cache();
	//	return $id;
}


function updateUser(User $u) {
	$sql = 'UPDATE webcal_user SET cal_passwd=?, cal_lastname=?, cal_firstname=?, cal_is_admin=?, cal_email=?, cal_enabled=?, cal_telephone=?, cal_address=?, cal_title=?, cal_birthday=?, role_id=?';
	dbi_execute($sql, array($u->passwd, $u->lastname, $u->firstname, $u->isAdmin, $u->email, $u->enabled, $u->telephone, $u->address, $u->title, $u->birthday, $u->roleID));

	dbi_clear_cache();
}

function deleteUser(User $u) {
	$sql = 'DELETE FROM webcal_user WHERE cal_login=?';
	dbi_execute($sql, array($u->login));

	//TODO: delete user prefs also
	
	dbi_clear_cache();
}
*/

function getRole($login) {
	$sql = 'SELECT role.id, role.name 
			FROM role, webcal_user 
			WHERE role.id=webcal_user.role_id AND cal_login=?';
	$rows = dbi_get_cached_rows($sql, array($login));
	
	$role = null;
	if(count($rows) == 1) {
		$row = $rows[0];
		$role = new Role($row[0], $row[1]);
	}

	return $role;
}

function listRoles() {
	$sql = 'SELECT id, name FROM role';
	$rows = dbi_get_cached_rows($sql, array());
	
	$roles = array(); 
	for ($i=0; $i<count($rows); $i++) { 
		$row = $rows[$i];
		$r = new Role($row[0], $row[1]);
		$roles[] = $r;
	}
	
	return $roles;
}

?>