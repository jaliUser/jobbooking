<?php
include_once 'includes/init.php';
include_once 'jc_functions.php';
//include_once 'jc_init.php';

function show_reset() {
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top("$site_name - Glemt kodeord");

	if (!empty($_GET['email'])) {
		echo '<p align="center">Fejl: <i>'.$_GET['email'].'</i> findes ikke i databasen!</p>';
	}
	
	echo '<h1>Glemt kodeord</i></h1>
		<form action="'.$PHP_SELF.'" method="POST">
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		<tr><td>E-mail:</td><td><input type="text" name="email" size="25" maxlength="75" /></td></tr>
		<tr><td colspan="2"><input type="submit" value="Send nyt kodeord"/></td></tr>
		<input type="hidden" name="action" value="do_reset">		
		</table>
		</form>';
	
	menu_link();
}

function do_reset() {
	if (!empty($_POST['email'])) {
		$exist = resetPassword($_POST['email']);
	}
	
	if($exist == true) {
		do_redirect('login.php');
	} else {		
		do_redirect($PHP_SELF.'?action=show_reset&email='.$_POST['email']);
	}
}

if ($_REQUEST['action'] == 'show_reset') {
	show_reset();
} elseif ($_REQUEST['action'] == 'do_reset') {
	do_reset();
} else {
	echo 'Error: Page parameter missing!';
}

html_bottom();

?>