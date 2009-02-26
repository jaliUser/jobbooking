<?php
include_once 'includes/init.php';
include_once 'jc_init.php';

//use reject_public_access() for all functions, except show_create() and do_create()

function show_list() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top("$site_name - Brugerliste");

	$users = listUsers($site_id);
	echo '<h1>Brugerliste</h1>
		<table align="center" border="1">
		<tr> <th>Brugernavn</th> <th>Fornavn</th> <th>Efternavn</th> <th>E-mail</th> <th>Telefon</th> <th>Adresse</th> <th>Alder</th> <th>Rolle</th></tr>';
	foreach ($users as $user) {
		$user = User::cast($user);
		$role = Role::cast(getRole($user->login));

		echo "<tr> 
			<td><a href=\"$PHP_SELF?action=show_update&login=$user->login\">$user->login</a></td>
			<td>$user->firstname</td>
			<td>$user->lastname</td>
			<td>$user->email</td>
			<td>$user->telephone</td>
			<td width='50'>$user->address</td>
			<td>$user->birthday</td>
			<td>$role->name</td> 
			</tr>";

	}
	echo '</table>';
	menu_link();
}

//allow public access
function show_create() {
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top("$site_name - Opret bruger");

	//generate rolesHTML: if not admin, only show 1 role  
	$rolesHTML = '<select name="role_id">';
	if(user_is_admin()) {
		$roles = listRoles();
		foreach ($roles as $role) {
			$role = Role::cast($role);
			$rolesHTML .= '<option value="'.$role->id.'">'.$role->name.'</option>';
		}
	} else {
		$roles = listRoles();
		$role = Role::cast($roles[2]);
		$rolesHTML .= '<option value="'.$role->id.'">'.$role->name.'</option>';
	}
	$rolesHTML .= '</select>';
	
	echo '<h1>Opret bruger</h1>
		<form action="'.$PHP_SELF.'" method="POST">
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		
		<tr><td>Brugernavn:</td><td><input type="text" name="login" size="25" maxlength="25" /> * <span class="help">Kun tegnene A-Z og _ er tilladte (IKKE mellemrum, &AElig;, &Oslash; og &Aring;)</span></td></tr>
		<tr><td>Kodeord:</td><td><input type="password" name="password" size="25" maxlength="32" /> *</td></tr>
		<tr><td>Fornavn:</td><td><input type="text" name="firstname" size="25" maxlength="25" /> *</td></tr>
		<tr><td>Efternavn:</td><td><input type="text" name="lastname" size="25" maxlength="25" /> *</td></tr>
		<tr><td>E-mail:</td><td><input type="text" name="email" size="25" maxlength="75" /></td></tr>
		<tr><td>Telefon (mobil):</td><td><input type="text" name="telephone" size="25" maxlength="50" /> *</td></tr>
		<tr><td>Adresse/postnr/by:</td><td><input type="text" name="address" size="25" maxlength="75" /> *</td></tr>
		<tr><td>Alder under lejren:</td><td><input type="text" name="birthday" size="2" maxlength="2" /> *</td></tr>
		<tr><td>Rolle:</td><td>'.$rolesHTML.'</td></tr>
		<tr><td colspan="2" class="help">* markerer et obligatorisk felt</td></tr>

		<tr><td colspan="2"><input type="submit" value="Opret"/></td></tr>
		<input type="hidden" name="action" value="do_create">
		
		</table>
		</form>';

	//dont show menu if user is __public__
	if($login != "__public__") {	
		menu_link();
	}
}

//allow public access
function do_create() {
	global $PHP_SELF, $login, $site_id, $site_name;
	require_params(array($_POST['login'], $_POST['password'], $_POST['lastname'], $_POST['firstname'], $_POST['telephone'], $_POST['address'], $_POST['birthday'], $_POST['role_id']));
	
	$user = new User($_POST['login'], null, $_POST['lastname'], $_POST['firstname'], null, $_POST['email'], null, $_POST['telephone'], $_POST['address'], null, $_POST['birthday'], null, $_POST['role_id'], $site_id);
	$user->setPasswd($_POST['password']);
	
	$ok = createUser($user);
	if ($ok) {
		if($login == "__public__") {
			do_redirect('login.php');
		} else {
			do_redirect($PHP_SELF.'?action=show_list');
		}
	}
	else {
		html_top($title);
		echo '<b>Fejl:</b> Brugernavnet er ugyldigt eller findes allerede!<br/>Kun tegnene A-Z og _ er tilladte, ikke &AElig;, &Oslash; og &Aring;.';
	}
}

function show_update() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top("$site_name - Rediger bruger");
	require_params(array($_GET['login']));
	
	$user = getUser($_GET['login']);
	$user = User::cast($user);
	$role = getRole($user->login);
	
	$rolesHTML = '<select name="role_id" disabled>';
	$roles = listRoles();
	foreach ($roles as $role) {
		$role = Role::cast($role);
		$rolesHTML .= '<option value="'.$role->id.'" '.($role->id == $user->roleID ? "selected" : "").'>'.$role->name.'</option>';
	}
	$rolesHTML .= '</select>';
	
	echo '<h1>Rediger bruger</h1>
		<form action="'.$PHP_SELF.'" method="POST">
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		
		<tr><td>Brugernavn:</td><td><input type="text" name="login" size="25" maxlength="25" value="'.$user->login.'" disabled /></td></tr>
			<input type="hidden" name="login" value="'.$user->login.'" />
		<tr><td>Kodeord:</td><td class="help"><input type="password" name="password" size="25" maxlength="32" value="" /> Efterlad tomt, hvis uændret</td></tr>
		<tr><td>Fornavn:</td><td><input type="text" name="firstname" size="25" maxlength="25" value="'.$user->firstname.'" /> *</td></tr>
		<tr><td>Efternavn:</td><td><input type="text" name="lastname" size="25" maxlength="25" value="'.$user->lastname.'" /> *</td></tr>
		<tr><td>E-mail:</td><td><input type="text" name="email" size="25" maxlength="75" value="'.$user->email.'" /></td></tr>
		<tr><td>Telefon (mobil):</td><td><input type="text" name="telephone" size="25" maxlength="50" value="'.$user->telephone.'" /> *</td></tr>
		<tr><td>Adresse/postnr/by:</td><td><input type="text" name="address" size="25" maxlength="75" value="'.$user->address.'" /> *</td></tr>
		<tr><td>Alder under lejren:</td><td><input type="text" name="birthday" size="2" maxlength="2" value="'.$user->birthday.'" /> *</td></tr>
		<tr><td>Rolle:</td><td>'.$rolesHTML.'</td></tr>
			<input type="hidden" name="role_id" value="'.$user->roleID.'" />
		<tr><td colspan="2" class="help">* markerer et obligatorisk felt</td></tr>

		<tr><td colspan="2"><input type="submit" value="Opdater"/></td></tr>
		<input type="hidden" name="action" value="do_update">
		
		</table>
		</form>';

	menu_link();
}

function do_update() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	require_params(array($_POST['login'], $_POST['lastname'], $_POST['firstname'], $_POST['telephone'], $_POST['address'], $_POST['birthday'], $_POST['role_id']));
	
	$user = new User($_POST['login'], null, $_POST['lastname'], $_POST['firstname'], null, $_POST['email'], null, $_POST['telephone'], $_POST['address'], null, $_POST['birthday'], null, $_POST['role_id'], $site_id);
	
	updateUser($user);

	if($_POST['password']) {
		$user->setPasswd($_POST['password']);
		updateUserPasswd($user);
	}
	
	//if editing own profile return to menu, otherwise assume admin-mode and return to menu
	if($login == $user->login) {
		do_redirect('jc_menu.php');
	} else {		
		do_redirect($PHP_SELF.'?action=show_list');
	}
}

if ($_REQUEST['action'] == 'show_create') {
	show_create();
} elseif ($_REQUEST['action'] == 'do_create') {
	do_create();
} elseif ($_REQUEST['action'] == 'show_update') {
	show_update();
} elseif ($_REQUEST['action'] == 'do_update') {
	do_update();
} elseif ($_REQUEST['action'] == 'show_list') {
	show_list();
} elseif ($_REQUEST['action'] == 'do_delete') {
	do_delete();
} else {
	echo 'Error: Paramers missing!';
}

html_bottom();

?>