<?php

class Role {
	var $id;
	var $name;

	function Role($id, $name) {
		$this->id = $id;
		$this->name = $name;
	}

	static function cast(Role $role) {
		return $role;
	}
	
}

?>