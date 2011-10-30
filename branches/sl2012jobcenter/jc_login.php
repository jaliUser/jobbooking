<?php
include_once 'jc_init.php';

$title = "SEE"; //TODO: get from config

function show_login() {
	global $PHP_SELF, $title;
	html_top($title);
	
	do_logout();
	
	echo '<h1>Log ind</h1>
		<form action="'.$PHP_SELF.'" method="POST">
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		
		<tr><td>Brugernavn:</td><td><input type="text" name="username" size="25" maxlength="25" /></td></tr>
		<tr><td>Kodeord:</td><td><input type="password" name="password" size="25" maxlength="32" /></td></tr>

		<tr><td colspan="2"><input type="submit" value="Log ind"/></td></tr>
		<input type="hidden" name="action" value="do_login">
		
		</table>
		</form>';
}

function do_login() {
	if($_POST['username'] == "" || $_POST['password'] == "") {
		show_login();
		echo '<p align="center"><b>Fejl: </b>Brugernavn eller kodeord ikke udfyldt!</p>';
	}
	
	//create cookie
	do_redirect('jc_menu.php');
}

function do_logout() {
	echo "logout";
}

if ($_REQUEST['action'] == 'do_login') {
	do_login();
} elseif ($_REQUEST['action'] == 'logout') {
	do_logout();
} else {
	show_login();
}

html_bottom();

?>