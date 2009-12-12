<?php
include_once 'includes/init.php';
include_once 'jc_functions.php';
include_once 'jc_init.php';

function show_reset() {
	global $PHP_SELF, $site_id;
	$site_id = (!empty($_GET['site_id']) ? $_GET['site_id'] : $site_id);
	$siteConfig = getSiteConfig($site_id);
	html_top("$siteConfig->siteName - Glemt kodeord");

	if (!empty($_GET['email'])) {
		echo '<p align="center">Fejl: Emailadressen <i>'.$_GET['email'].'</i> findes ikke i databasen!</p>';
	} else if (!empty($_GET['login'])) {
		echo '<p align="center">Fejl: Brugernavnet <i>'.$_GET['login'].'</i> findes ikke i databasen!</p>';
	}
	
	echo '<h1>Glemt kodeord</i></h1>
		<form action="'.$PHP_SELF.'" method="POST">
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		<tr><td colspan="2">Indtast dit brugernavn ELLER din emailadresse, hvorefter du vil få tilsendt en ny adgangskode.</td></tr>
		<tr><td>Brugernavn:</td><td><input type="text" name="login" size="25" maxlength="75" /></td></tr>
		<tr><td>E-mail:</td><td><input type="text" name="email" size="25" maxlength="75" /></td></tr>
		<tr><td colspan="2"><input type="submit" value="Send nyt kodeord"/></td></tr>
		<input type="hidden" name="action" value="do_reset">
		<input type="hidden" name="site_id" value="'.$site_id.'">
		</table>
		</form>';
	
	menu_link();
}

function do_reset() {
	if (!empty($_POST['email'])) {
		$exist = resetPasswordFromEmail($_POST['email'], $_POST['site_id']);
	} else if (!empty($_POST['login'])) {
		$exist = resetPasswordFromLogin($_POST['login'], $_POST['site_id']);
	}
	
	if($exist === true) {
		do_redirect('login.php');
	} else {		
		do_redirect($PHP_SELF.'?action=show_reset&email='.$_POST['email'].'&login='.$_POST['login'].'&site_id='.$_POST['site_id']);
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