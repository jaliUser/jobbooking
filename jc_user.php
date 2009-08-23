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
		<table align="center" class="border1">
		<tr> <th>Brugernavn</th> <th>Fornavn</th> <th>Efternavn</th> <th>Klan/Pladsnr</th> <th>E-mail</th> <th>Telefon</th> <th>Adresse</th> <th>Alder</th> <th>Gruppe</th> <th>Rolle</th> <th>Antal</th> <th>Underlejr</th> <th>Noter</th> </tr>';
	foreach ($users as $user) {
		$user = User::cast($user);
		$role = Role::cast(getRole($user->login));
		$group = getGroup($user->groupID);
		$subcamp = getSubcampForUser($user->login); 

		echo "<tr> 
			<td>".(user_is_admin()? "<a href=\"$PHP_SELF?action=show_update&login=$user->login\">$user->login</a>": $user->login)."</td>
			<td><a href=\"$PHP_SELF?action=show_one&login=$user->login\">$user->firstname</a></td>
			<td>$user->lastname</td>
			<td>$user->title</td>
			<td>$user->email</td>
			<td>$user->telephone</td>
			<td width='50'>$user->address</td>
			<td>$user->ageRange</td>
			<td>$group->name</td>
			<td>$role->name</td>
			<td>$user->count</td>
			<td>$subcamp->name</td>
			<td>$user->notes</td>
			</tr>";
	}
	echo '</table>';
	menu_link();
}

//allow public access
function show_create() {
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top("$site_name - Opret bruger");

	$site_id = (empty($site_id) ? $_GET['site_id'] : $site_id);
	
	//if not admin, only show 1 role  
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
		$role = Role::cast($roles[1]);
		$rolesHTML .= '<option value="'.$role->id.'">'.$role->name.'</option>';
	}
	$rolesHTML .= '</select>';
	  
	$groupsHTML = '<select name="group_id">';
		$groups = listAllGroups($site_id);
		foreach ($groups as $group) {
			$group = Group::cast($group);
			$groupsHTML .= '<option value="'.$group->id.'">'.$group->name.'</option>';
		}
	$groupsHTML .= '</select>';

	$jobcategoryHTML = '';
	$jobcats = listAllJobCategories($site_id);
	foreach ($jobcats as $jobcat) {
		$jobcat = JobCategory::cast($jobcat);
		$jobcategoryHTML .= '<input type="checkbox" name="jobcategory[]" value="'.$jobcat->id.'">'.$jobcat->name.'</input>&nbsp;&nbsp;';
	}
	
	$qualificationHTML = '';
	$quals = listAllQualifications($site_id);
	foreach ($quals as $qual) {
		$qual = Qualification::cast($qual);
		$qualificationHTML .= '<input type="checkbox" name="qualification[]" value="'.$qual->id.'">'.$qual->name.'</input>&nbsp;&nbsp;';
	}
	
	echo '<h1>Opret bruger</h1>
		<form action="'.$PHP_SELF.'" method="POST">
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		
		<tr><td>Brugernavn:</td><td><input type="text" name="login" size="25" maxlength="25" /> * <span class="help">Kun tegnene A-Z og _ er tilladte (IKKE mellemrum, &AElig;, &Oslash; og &Aring;)</span></td></tr>
		<tr><td>Kodeord:</td><td><input type="password" name="password" size="25" maxlength="32" /> *</td></tr>
		<tr><td>Fornavn:</td><td><input type="text" name="firstname" size="25" maxlength="25" /> *</td></tr>
		<tr><td>Efternavn:</td><td><input type="text" name="lastname" size="25" maxlength="25" /> *</td></tr>
		<tr><td>E-mail:</td><td><input type="text" name="email" size="25" maxlength="75" /></td></tr>
		<tr><td>Telefon (helst mobil):</td><td><input type="text" name="telephone" size="25" maxlength="50" /> * <span class="help">Bruges til SMS-service for påmindelse og evt. ændringer af jobs.</span></td></tr>
		<tr><td>Adresse/postnr/by:</td><td><input type="text" name="address" size="25" maxlength="75" /> *</td></tr>
		<tr><td>Alder under lejren:</td><td><input type="text" name="age_range" size="10" maxlength="10" /> *</td></tr>
		<tr><td>Antal:</td><td><input type="text" name="count" size="2" maxlength="3" /> * <span class="help">Hvor mange hjælpere er I?</span></td></tr>
		<tr><td>Kvalifikationer:</td><td>'.$qualificationHTML.'<br><span class="help">Hvis der kr&aelig;ves certifikater, skal disse medbringes på lejren!</span></td></tr>
		<tr><td>Specielle kvalifikationer:</td><td><input type="text" name="qualifications" size="25" maxlength="255" /></td></tr>
		<tr><td>Klan/holdnavn/pladsnr:</td><td><input type="text" name="title" size="25" maxlength="75" /></td></tr>
		<tr><td>Gruppe:</td><td>'.$groupsHTML.'</td></tr>
		<tr><td>Rolle:</td><td>'.$rolesHTML.'</td></tr>
		<tr><td>Foretrukne jobkategorier:</td><td>'.$jobcategoryHTML.'</td></tr>
		<tr><td>Noter:</td><td><textarea name="notes" cols="50" rows="3"></textarea></td></tr>
		<tr><td colspan="2" class="help">* markerer et obligatorisk felt</td></tr>

		<tr><td colspan="2"><input type="submit" value="Opret"/></td></tr>
		<input type="hidden" name="action" value="do_create">
		<input type="hidden" name="site_id" value="'.$site_id.'">
		
		</table>
		</form>';

	//dont show menu if user is __public__
	if($login != "__public__") {	
		menu_link();
	}
}

//allow public access
function do_create() {
	global $PHP_SELF, $login;
	//require_params(array($_POST['login'], $_POST['password'], $_POST['lastname'], $_POST['firstname'], $_POST['telephone'], $_POST['address'], $_POST['age_range'], $_POST['count'], $_POST['role_id'], $_POST['site_id']));
	$error = "";
	if (strlen($_POST['login']) < 2) {
		$error .= "Brugernavn skal være mindst 2 karakterer.<br>";
	} 
	if (strlen($_POST['password']) < 4) {
		$error .= "Kodeordet skal være mindst 4 karakterer.<br>";
	}
	if (strlen($_POST['lastname']) < 2) {
		$error .= "Efternavn skal være mindst 2 karakterer.<br>";
	}
	if (strlen($_POST['firstname']) < 2) {
		$error .= "Fornavn skal være mindst 2 karakterer.<br>";
	}
	if (strlen($_POST['telephone']) < 8) {
		$error .= "Telefonnr. skal være mindst 8 karakterer.<br>";
	}
	if (strlen($_POST['address']) < 4) {
		$error .= "Adresse skal være mindst 4 karakterer.<br>";
	}
	if (strlen($_POST['age_range']) < 1) {
		$error .= "Alder skal være mindst 1 karakter.<br>";
	}
	if (strlen($_POST['count']) < 1 || !is_numeric($_POST['count'])) {
		$error .= "Antal skal være et tal og mindst 1 ciffer.<br>";
	}
	if (empty($_POST['site_id'])) {
		$error .= "SiteID mangler.";
	}
	if (!empty($error)) {
		echo print_error($error);
		exit;
	}
	
	$user = new User($_POST['login'], null, $_POST['lastname'], $_POST['firstname'], null, $_POST['email'], null, $_POST['telephone'], $_POST['address'], $_POST['title'], null, null, $_POST['role_id'], $_POST['site_id'], $_POST['group_id'], $_POST['count'], $_POST['age_range'], $_POST['qualifications'], $_POST['notes']);
	$user->setPasswd($_POST['password']);
	
	$ok = createUser($user);
	if ($ok) {
		updateUserJobCategories($_POST['login'], $_POST['jobcategory']);
		updateUserQualifications($_POST['login'], $_POST['qualification']);
		
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
	
	$user = User::cast(getUser($_GET['login']));
	$role = getRole($user->login);
	
	$rolesHTML = '<select name="role_id" disabled>';
	$roles = listRoles();
	foreach ($roles as $role) {
		$role = Role::cast($role);
		$rolesHTML .= '<option value="'.$role->id.'" '.($role->id == $user->roleID ? "selected" : "").'>'.$role->name.'</option>';
	}
	$rolesHTML .= '</select>';
	  
	$groupsHTML = '<select name="group_id">';
	$groups = listAllGroups($site_id);
	foreach ($groups as $group) {
		$group = Group::cast($group);
		$groupsHTML .= '<option value="'.$group->id.'" '.($user->groupID == $group->id ? "selected" : "").'>'.$group->name.'</option>';
	}
	$groupsHTML .= '</select>';
	
	$jobcategoryHTML = '';
	$jobcats = listAllJobCategories($site_id);
	$userJobcats = listUserJobCategories($user->login);
	foreach ($jobcats as $jobcat) {
		$jobcat = JobCategory::cast($jobcat);
		$jobcategoryHTML .= '<input type="checkbox" name="jobcategory[]" value="'.$jobcat->id.'"';
		foreach ($userJobcats as $userJobcat) {
			if ($jobcat->id == $userJobcat->id) {
				$jobcategoryHTML .= ' checked';
			}
		}
		$jobcategoryHTML .= '>'.$jobcat->name.'</input>&nbsp;&nbsp;';
	}
	
	$qualificationHTML = '';
	$quals = listAllQualifications($site_id);
	$userQuals = listUserQualifications($user->login);
	foreach ($quals as $qual) {
		$qual = Qualification::cast($qual);
		$qualificationHTML .= '<input type="checkbox" name="qualification[]" value="'.$qual->id.'"';
		foreach ($userQuals as $userQual) {
			if ($qual->id == $userQual->id) {
				$qualificationHTML .= ' checked';
			}
		}
		$qualificationHTML .= '>'.$qual->name.'</input>&nbsp;&nbsp;';
	}
	
	echo '<h1>Rediger bruger</h1>
		<form action="'.$PHP_SELF.'" method="POST">
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		
		<tr><td>Brugernavn:</td><td><input type="text" name="login" size="25" maxlength="25" value="'.$user->login.'" disabled /></td></tr>
			<input type="hidden" name="login" value="'.$user->login.'" />
		<tr><td>Kodeord:</td><td class="help"><input type="password" name="password" size="25" maxlength="32" value="" /> Efterlad tomt, hvis uændret</td></tr>
		<tr><td>Fornavn:</td><td><input type="text" name="firstname" size="25" maxlength="25" value="'.$user->firstname.'" /> *</td></tr>
		<tr><td>Efternavn:</td><td><input type="text" name="lastname" size="25" maxlength="25" value="'.$user->lastname.'" /> *</td></tr>
		<tr><td>E-mail:</td><td><input type="text" name="email" size="25" maxlength="75" value="'.$user->email.'" /></td></tr>
		<tr><td>Telefon (helst mobil):</td><td><input type="text" name="telephone" size="25" maxlength="50" value="'.$user->telephone.'" /> * <span class="help">Bruges til SMS-service for påmindelse og evt. ændringer af jobs.</span></td></tr>
		<tr><td>Adresse/postnr/by:</td><td><input type="text" name="address" size="25" maxlength="75" value="'.$user->address.'" /> *</td></tr>
		<tr><td>Alder under lejren:</td><td><input type="text" name="age_range" size="10" maxlength="10" value="'.$user->ageRange.'" /> *</td></tr>
		<tr><td>Antal:</td><td><input type="text" name="count" size="2" maxlength="3" value="'.$user->count.'" /> * <span class="help">Hvor mange hjælpere er I?</span></td></tr>
		<tr><td>Kvalifikationer:</td><td>'.$qualificationHTML.'<br><span class="help">Hvis der kr&aelig;ves certifikater, skal disse medbringes på lejren!</span></td></tr>
		<tr><td>Specielle kvalifikationer:</td><td><input type="text" name="qualifications" size="25" maxlength="255" value="'.$user->qualifications.'" /></td></tr>
		<tr><td>Klan/holdnavn/pladsnr:</td><td><input type="text" name="title" size="25" maxlength="75" value="'.$user->title.'" /></td></tr>
		<tr><td>Gruppe:</td><td>'.$groupsHTML.'</td></tr>
		<tr><td>Rolle:</td><td>'.$rolesHTML.'</td></tr>
		<tr><td>Foretrukne jobkategorier:</td><td>'.$jobcategoryHTML.'</td></tr>
		<tr><td>Noter:</td><td><textarea name="notes" cols="50" rows="3">'.$user->notes.'</textarea></td></tr>
		<tr><td colspan="2" class="help">* markerer et obligatorisk felt</td></tr>

		<tr><td colspan="2"><input type="submit" value="Opdater"/></td></tr>
		<input type="hidden" name="action" value="do_update">
		<input type="hidden" name="role_id" value="'.$user->roleID.'" />
		
		</table>
		</form>';

	menu_link();
}

function do_update() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	//require_params(array($_POST['login'], $_POST['lastname'], $_POST['firstname'], $_POST['telephone'], $_POST['address'], $_POST['age_range'], $_POST['count'], $_POST['role_id']));
	$error = "";
	if (strlen($_POST['login']) < 2) {
		$error .= "Brugernavn skal være mindst 2 karakterer.<br>";
	} 
	if (!empty($_POST['password']) && strlen($_POST['password']) < 4) {
		$error .= "Kodeordet skal være mindst 4 karakterer.<br>";
	}
	if (strlen($_POST['lastname']) < 2) {
		$error .= "Efternavn skal være mindst 2 karakterer.<br>";
	}
	if (strlen($_POST['firstname']) < 2) {
		$error .= "Fornavn skal være mindst 2 karakterer.<br>";
	}
	if (strlen($_POST['telephone']) < 8) {
		$error .= "Telefonnr. skal være mindst 8 karakterer.<br>";
	}
	if (strlen($_POST['address']) < 4) {
		$error .= "Adresse skal være mindst 4 karakterer.<br>";
	}
	if (strlen($_POST['age_range']) < 1) {
		$error .= "Alder skal være mindst 1 karakter.<br>";
	}
	if (strlen($_POST['count']) < 1 || !is_numeric($_POST['count'])) {
		$error .= "Antal skal være et tal og mindst 1 ciffer.<br>";
	}
	if (!empty($error)) {
		echo print_error($error);
		exit;
	}
	
	$user = new User($_POST['login'], null, $_POST['lastname'], $_POST['firstname'], null, $_POST['email'], null, $_POST['telephone'], $_POST['address'], $_POST['title'], null, null, $_POST['role_id'], $site_id, $_POST['group_id'], $_POST['count'], $_POST['age_range'], $_POST['qualifications'], $_POST['notes']);
	
	updateUser($user);
	updateUserJobCategories($_POST['login'], $_POST['jobcategory']);
	updateUserQualifications($_POST['login'], $_POST['qualification']);

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

function show_one() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top("$site_name - Vis bruger");
	require_params(array($_GET['login']));
	
	$user = getUser($_GET['login']);
	$role = getRole($user->login);
	
	$jobcategoryHTML = '';
	$jobcats = listAllJobCategories($site_id);
	$userJobcats = listUserJobCategories($user->login);
	foreach ($jobcats as $jobcat) {
		$jobcat = JobCategory::cast($jobcat);
		foreach ($userJobcats as $userJobcat) {
			if ($jobcat->id == $userJobcat->id) {
				$jobcategoryHTML .= $jobcat->name.'<br/>';
			}
		}
	}
	
	$qualificationHTML = '';
	$quals = listAllQualifications($site_id);
	$userQuals = listUserQualifications($user->login);
	foreach ($quals as $qual) {
		$qual = Qualification::cast($qual);
		foreach ($userQuals as $userQual) {
			if ($qual->id == $userQual->id) {
				$qualificationHTML .= $qual->name.'<br/>';
			}
		}
	}
	
	echo '<h1>Vis bruger <i>'.$user->getFullName().'</i></h1>
		<table align="center" class="border1">
		<tr><th align="left">Brugernavn:</th><td>'.$user->login.'</td></tr>
		<tr><th align="left">Fornavn:</th><td>'.$user->firstname.'</td></tr>
		<tr><th align="left">Efternavn:</th><td>'.$user->lastname.'</td></tr>
		<tr><th align="left">E-mail:</th><td>'.$user->email.'</td></tr>
		<tr><th align="left">Telefon:</th><td>'.$user->telephone.'</td></tr>
		<tr><th align="left">Adresse/postnr/by:</th><td>'.$user->address.'</td></tr>
		<tr><th align="left">Alder under lejren:</th><td>'.$user->ageRange.'</td></tr>
		<tr><th align="left">Antal:</th><td>'.$user->count.'</td></tr>
		<tr><th align="left">Kvalifikationer:</th><td>'.$qualificationHTML.'</td></tr>
		<tr><th align="left">Specielle kvalifikationer:</th><td>'.$user->qualifications.'</td></tr>
		<tr><th align="left">Klan/holdnavn/pladsnr:</th><td>'.$user->title.'</td></tr>
		<tr><th align="left">Gruppe:</th><td>'.getGroup($user->groupID)->name.'</td></tr>
		<tr><th align="left">Underlejr:</th><td>'.getSubcampForUser($user->login)->name.'</td></tr>
		<tr><th align="left">Rolle:</th><td>'.$role->name.'</td></tr>
		<tr><th align="left">Foretrukne jobkategorier:</th><td>'.$jobcategoryHTML.'</td></tr>
		<tr><th align="left">Noter:</th><td>'.$user->notes.'</td></tr>
		</table>';

	menu_link();
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
} elseif ($_REQUEST['action'] == 'show_one') {
	show_one();
} else {
	echo 'Error: Page parameter missing!';
}

html_bottom();

?>