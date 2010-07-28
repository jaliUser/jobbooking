<?php
include_once 'includes/init.php';
include_once 'jc_init.php';

//use reject_public_access() for all functions, except show_create() and do_create()

function show_list() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top("$site_name - Brugerliste");

	$roles = listRoles();
	$users = listUsers($site_id);
	echo '<h1>Brugerliste</h1>
		<table align="center" class="border1">
		<tr> <th>Brugernavn<br/><span class="help">Ret bruger</span></th> <th>Spejdernet</th> <th>Fornavn<br/><span class="help">Vis bruger</span></th> <th>Efternavn</th> <th>Klan/Pladsnr</th> <th>E-mail</th> <th>Telefon</th> <th>Adresse</th> <th>Alder</th> <th>Gruppe</th> <th>Rolle</th> <th>Antal</th> <th>Underlejr</th> <th>Noter</th> </tr>';
	$lastRole = null;
	$emailSum = null;
	$userCount = 0;
	$count = 0;
	foreach ($users as $user) {
		$user = User::cast($user);
		$role = Role::cast(getRole($user->login));
		$group = getGroup($user->groupID);
		$subcamp = getSubcampForUser($user->login); 
		
		if ($lastRole != null && $lastRole != $user->roleID) {
			if ($lastRole == 3) {
				echo "<tr><td colspan='11'></td><td>$userCount</td><td colspan='2'></td></tr>";
			}
			print_role_summary($emailSum, $count, $roles, $lastRole);
			$emailSum = "";
			$userCount = 0;
			$count = 0;
		}
		if ($user->email != "") {
			$emailSum .= "$user->email, ";
		}
		$lastRole = $user->roleID;
		$userCount += $user->count;
		$count++;
		
		echo "<tr> 
			<td>".(user_is_admin()? "<a href=\"$PHP_SELF?action=show_update&login=$user->login\">$user->login</a>": $user->login)."</td>
			<td>$user->extLogin</td>
			<td><a href=\"$PHP_SELF?action=show_one&login=$user->login\">$user->firstname</a></td>
			<td>$user->lastname</td>
			<td>$user->title</td>
			<td>$user->email</td>
			<td>$user->telephone</td>
			<td width='50'>$user->address</td>
			<td>$user->ageRange</td>
			<td>".($group != null ? $group->name : '')."</td>
			<td>$role->name</td>
			<td>$user->count</td>
			<td>".($subcamp != null ? $subcamp->name : '')."</td>
			<td>$user->notes</td>
			</tr>";
	}
	print_role_summary($emailSum, $count, $roles, $lastRole);
	echo '</table>';
	menu_link();
}

function print_role_summary($emailSum, $count, $roles, $lastRole) {
	$currentRole = Role::cast($roles[$lastRole - 1]);
	echo "<tr><td colspan='14'>
			Antal: $count<br/>
			<b>Alle <i>$currentRole->name</i> kommasepareret:</b> $emailSum<br/><br/>
			<b>Alle <i>$currentRole->name</i> semikolonsepareret:</b> ".str_replace(",",";",$emailSum)."
			</td></tr>";
}

function show_helpers_limit() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top("$site_name - Hjælpere over/under grænse");

	if (empty($_GET['sort'])) {
		$_GET['sort'] = "firstname"; //SETTING DEFAULT SORT
	}
	
	$hourLimit = 7;
	$users = listUsersWithSignupInfo($site_id, 3);
	
	switch ($_GET['sort']) {
		case "login":
			usort($users, "User::sortByLogin");
			break;
		case "firstname":
			usort($users, "User::sortByFirstname");
			break;
		case "count":
			usort($users, "User::sortByCount");
			break;
		case "signups":
			usort($users, "User::sortBySignups");
			break;
		case "signupsDuration":
			usort($users, "User::sortBySignupsDuration");
			break;
		case "signupsDurationEach":
			usort($users, "User::sortBySignupsDurationEach");
			break;
	}
	
	echo '<h1>Hjælpere over/under grænse</h1>
		<table align="center" class="border1">
		<tr> 
			<th>Handlinger</th>
			<th>'.sortHeader("login", "Brugernavn").'</th>
			<th>'.sortHeader("firstname", "Fuldt navn").'<br/><span class="help">Vis bruger</span></th>
			<th>Klan/Pladsnr</th>
			<th>E-mail</th>
			<th>Telefon</th>
			<th>'.sortHeader("count", "Antal").'</th>
			<th>Noter (fuld tekst i ToolTip)</th>
			<th title="Tilmeldinger">'.sortHeader("signups", "Tilme.").'</th>
			<th>'.sortHeader("signupsDuration", "Timer").'</th>
			<th title="Timer/person">'.sortHeader("signupsDurationEach", "T/p").'</th>
			<!-- <th>Foretrukne</th> -->
			<th title="Ingen email">IM</th>
			<th title="Er kontaktet">EK</th>
		</tr>';
	$emailSumOver = null;
	$emailSumUnder = null;
	$countOver = 0;
	$countUnder = 0;
	foreach ($users as $user) {
		$user = User::cast($user);
		
		if ($user->signupsDurationEach >= $hourLimit) {
			if (!empty($_POST['show_emails']) && $user->email != "" && !$user->noEmail) {
				$emailSumOver .= "$user->email, ";
			}
			$countOver++;
		} else {
			if (!empty($_POST['show_emails']) && $user->email != "" && !$user->noEmail) {
				$emailSumUnder .= "$user->email, ";
			}
			$countUnder++;
		}
		
//		$catString = "";
//		$categories = listUserJobCategories($user->login);
//		foreach ($categories as $cat) {
//			$cat = JobCategory::cast($cat);
//			$catString .= $cat->name . ", ";
//		}
				
		echo "<tr> 
			<td><a href=\"jc_signup.php?action=show_mine&user_id=$user->login\">Tilmeldinger</a><br/>
				<a href=\"$PHP_SELF?action=show_update&login=$user->login\">Ret bruger</a></td>
			<td>$user->login</td>
			<td><a href=\"$PHP_SELF?action=show_one&login=$user->login\">".$user->getFullName()."</a></td>
			<td>$user->title</td>
			<td>$user->email</td>
			<td>$user->telephone</td>
			<td>$user->count</td>
			<td title='".$user->notes."'>".(strlen($user->notes) > 30 ? substr($user->notes, 0, 30) . '...' : substr($user->notes, 0, 30))."</td>
			<td>$user->signups</td>
			<td>$user->signupsDuration</td>
			<td>$user->signupsDurationEach</td>
			<!-- <td>$catString</td>-->
			<td>".one2x($user->noEmail)."</td>
			<td>".one2x($user->isContacted)."</td>
			</tr>";		
	}
	
	echo "<tr><td colspan='13'>
			Antal <i>over $hourLimit</i>: $countOver<br/>
			Antal <i>under $hourLimit</i>: $countUnder<br/><br/>";
	
	if (!empty($_POST['show_emails']) && !empty($emailSumOver)) {
	  echo "<b>Alle <i>over $hourLimit</i> kommasepareret:</b> $emailSumOver<br/><br/>
			<b>Alle <i>over $hourLimit</i> semikolonsepareret:</b> ".str_replace(",",";",$emailSumOver)."
			<br/><br/>
			<b>Alle <i>under $hourLimit</i> kommasepareret:</b> $emailSumUnder<br/><br/>
			<b>Alle <i>under $hourLimit</i> semikolonsepareret:</b> ".str_replace(",",";",$emailSumUnder);
	} else {
		echo "<form action='".$_SERVER['REQUEST_URI']."' method='POST'><input type='submit' name='show_emails' value='Vis emails' /></form>";
	}	

	echo '</td></tr>
		</table>';
	menu_link();
}

//allow public access
function show_create() {
	global $PHP_SELF, $login, $site_id;
	$site_id = (!empty($_GET['site_id']) ? $_GET['site_id'] : $site_id);
	$siteConfig = getSiteConfig($site_id);
	html_top("$siteConfig->siteName - Opret bruger");
	
	//if not admin, only show 1 role  
	$rolesHTML = '<select name="role_id" onChange="role_id_changed(this);">';
	if(user_is_admin()) {
		$roles = listRoles();
		foreach ($roles as $role) {
			$role = Role::cast($role);
			$rolesHTML .= '<option value="'.$role->id.'" '.($_GET['role_id'] == $role->id ? 'selected':'').'>'.$role->name.'</option>';
		}
	} else {
		$roles = listRoles();
		$role = Role::cast($roles[2]);
		$rolesHTML .= '<option value="'.$role->id.'" '.($_GET['role_id'] == $role->id ? 'selected':'').'>'.$role->name.'</option>';
		$role = Role::cast($roles[1]);
		$rolesHTML .= '<option value="'.$role->id.'" '.($_GET['role_id'] == $role->id ? 'selected':'').'>'.$role->name.'</option>';
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
		$jobcategoryHTML .= '<input type="checkbox" name="jobcategory[]" value="'.$jobcat->id.'">'.$jobcat->name.'</input><br/>';
	}
	
	$qualificationHTML = '';
	$quals = listAllQualifications($site_id);
	foreach ($quals as $qual) {
		$qual = Qualification::cast($qual);
		$qualificationHTML .= '<input type="checkbox" name="qualification[]" value="'.$qual->id.'">'.$qual->name.'</input><br/>
		';
	}
	
	echo '<h1>Opret bruger til <i>'.$siteConfig->siteName.'</i></h1>
		<form action="'.$PHP_SELF.'" method="POST">
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		<tr><td>Rolle:</td><td>'.$rolesHTML.'</td></tr>
		<tr><td>Brugernavn:</td><td><input type="text" name="login" size="25" maxlength="25" /> * <span class="help">Kun tegnene A-Z og _ er tilladte (IKKE mellemrum, &AElig;, &Oslash; og &Aring;)</span></td></tr>
		<tr><td>Kodeord:</td><td><input type="password" name="password" size="25" maxlength="32" /> * <span class="help">Minimum 4 karakterer</span></td></tr>
		<tr><td>Fornavn:</td><td><input type="text" name="firstname" size="25" maxlength="25" /> *</td></tr>
		<tr><td>Efternavn:</td><td><input type="text" name="lastname" size="25" maxlength="25" /> *</td></tr>
		<!-- <tr><td>Spejdernet-brugernavn:</td><td><input type="text" name="ext_login" size="25" maxlength="25" /></td></tr> -->
		<tr><td>E-mail:</td><td><input type="text" name="email" size="25" maxlength="75" /> <span class="help">Vigtig!</span></td></tr>
		<tr><td>Telefon (helst mobil):</td><td><input type="text" name="telephone" size="25" maxlength="50" /> * <span class="help">Bruges til SMS-service for påmindelse og evt. ændringer af jobs.</span></td></tr>
		<!-- <tr><td>Adresse/postnr/by:</td><td><input type="text" name="address" size="25" maxlength="75" /> *</td></tr> -->';

	if (empty($_GET['role_id']) || $_GET['role_id'] == 3) {
	echo '<!-- <tr><td>Alder under lejren:</td><td><input type="text" name="age_range" size="10" maxlength="10" /> *</td></tr> -->
		<tr><td>Antal:</td><td><input type="text" name="count" size="2" maxlength="3" /> * <span class="help">Hvor mange hjælpere er I?</span></td></tr>
		<tr><td>Kvalifikationer:</td><td>'.$qualificationHTML.'<br><span class="help">Hvis der kr&aelig;ves certifikater, skal disse medbringes på lejren!</span></td></tr>
		<tr><td>Specielle kvalifikationer:</td><td><input type="text" name="qualifications" size="25" maxlength="255" /></td></tr>
		<tr><td>Klan/holdnavn/pladsnr:</td><td><input type="text" name="title" size="25" maxlength="75" /></td></tr>
		<!-- <tr><td>Foretrukne jobkategorier:</td><td>'.$jobcategoryHTML.'</td></tr> -->';
	}

	if (user_is_admin()) {
		echo '<tr><td>Ingen email:</td><td><input type="checkbox" name="no_email" /></td></tr>
			  <tr><td>Er kontaktet:</td><td><input type="checkbox" name="is_contacted" /></td></tr>';
	}
	
	echo '<tr><td>Gruppe:</td><td>'.$groupsHTML.' *</td></tr>
		<tr><td>Noter:</td><td><textarea name="notes" cols="50" rows="3"></textarea></td></tr>
		<tr><td colspan="2" class="help">* markerer et obligatorisk felt</td></tr>

		<tr><td colspan="2"><input type="submit" value="Opret"/></td></tr>
		<input type="hidden" name="action" value="do_create">
		<input type="hidden" name="site_id" value="'.$site_id.'">';
		
	if (empty($_GET['role_id']) || $_GET['role_id'] == 3) {
		echo '<tr><td colspan="2" class="redalert">Når du er oprettet skal du huske at tilmelde dig et job!</td></tr>';
	}
	echo '</table>
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
	if (!User::isValidUsername($_POST['login'])) {
		$error .= "Ugyldige karakterer i brugernavn.<br>";
	} 
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
//	if (strlen($_POST['address']) < 4) {
//		$error .= "Adresse skal være mindst 4 karakterer.<br>";
//	}
//	if ($_POST['role_id'] == 3 && strlen($_POST['age_range']) < 1) {
//		$error .= "Alder skal være mindst 1 karakter.<br>";
//	}
	if ($_POST['role_id'] == 3 && (strlen($_POST['count']) < 1 || !is_numeric($_POST['count']))) {
		$error .= "Antal skal være et tal og mindst 1 ciffer.<br>";
	}
	if (!empty($_POST['email']) && !valid_email($_POST['email'])) {
		$error .= "Ugyldig email.<br>";
	}
	if (empty($_POST['site_id'])) {
		$error .= "SiteID mangler.<br>";
	}
	if ($_POST['role_id'] == 3 && empty($_POST['group_id']) || $_POST['group_id'] == "0") {
		$error .= "Ugyldig gruppe.<br>";
	}
//	if (existTelephone($_POST['telephone'])) {
//		$error .= "Anden bruger er allerede registreret med samme telefonnummer!<br>";
//		$error .= "Hvis du har glemt dit kodeord, anvend 'Glemt kodeord' på loginsiden.<br>";
//	}
	if (!empty($_POST['email']) && existEmail($_POST['email'])) {
		$error .= "Anden bruger er allerede registreret med samme emailadresse!<br>";
		$error .= "Hvis du har glemt dit kodeord, anvend 'Glemt kodeord' på loginsiden.<br>";
	}
	if (!empty($error)) {
		echo print_error($error);
		exit;
	}
	
	$user = new User($_POST['login'], null, $_POST['lastname'], $_POST['firstname'], null, $_POST['email'], null, $_POST['telephone'], $_POST['address'], $_POST['title'], null, null, $_POST['role_id'], $_POST['site_id'], $_POST['group_id'], $_POST['count'], $_POST['age_range'], $_POST['qualifications'], $_POST['notes'], $_POST['ext_login'], $_POST['no_email'], $_POST['is_contacted']);
	$user->setPasswd($_POST['password']);
	
	$ok = createUser($user);
	if ($ok) {
		updateUserJobCategories($_POST['login'], $_POST['jobcategory']);
		updateUserQualifications($_POST['login'], $_POST['qualification']);
		
		if($login == "__public__") {
			do_redirect('login.php?site_id='.$_POST['site_id'].'&user_id='.$_POST['login']);
		} else {
			do_redirect('jc_menu.php');
		}
	}
	else {
		echo print_error('Brugernavnet er ugyldigt eller findes allerede!<br/>
						  Kun tegnene A-Z og _ er tilladte, ikke &AElig;, &Oslash; og &Aring;.');
		exit;
	}
}

function show_update() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	
	if (!(user_is_admin() || user_is_consultant()) && $login != $_GET['login']) {
		echo "Unauthorized access!";
		exit;
	}
	
	html_top("$site_name - Rediger bruger");
	require_params(array($_GET['login']));
	
	$user = User::cast(getUser($_GET['login']));
	$role = getRole($user->login);
	
	$rolesHTML = '<select name="role_id" '.(!user_is_admin() ? 'disabled' : '').' onChange="role_id_changed(this);">';
	$roles = listRoles();
	foreach ($roles as $role) {
		if (!empty($_GET['role_id'])) {
			$selected = ($role->id == $_GET['role_id'] ? "selected" : "");
		} else {			
			$selected = ($role->id == $user->roleID ? "selected" : "");
		}
		$role = Role::cast($role);
		$rolesHTML .= '<option value="'.$role->id.'" '.$selected.'>'.$role->name.'</option>';
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
		$jobcategoryHTML .= '>'.$jobcat->name.'</input><br/>';
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
		$qualificationHTML .= '>'.$qual->name.'</input><br/>';
	}
	
	echo '<h1>Rediger bruger</h1>
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		<form action="'.$PHP_SELF.'" method="POST">
		
		<tr><td>Rolle:</td><td>'.$rolesHTML.'</td></tr>
		<tr><td>Brugernavn:</td><td><input type="text" name="login" size="25" maxlength="25" value="'.$user->login.'" disabled /></td></tr>
			<input type="hidden" name="login" value="'.$user->login.'" />
		<tr><td>Kodeord:</td><td class="help"><input type="password" name="password" size="25" maxlength="32" value="" /> <span class="help">Efterlad tomt, hvis uændret - ellers minimum 4 karakterer</span></td></tr>
		<tr><td>Fornavn:</td><td><input type="text" name="firstname" size="25" maxlength="25" value="'.$user->firstname.'" /> *</td></tr>
		<tr><td>Efternavn:</td><td><input type="text" name="lastname" size="25" maxlength="25" value="'.$user->lastname.'" /> *</td></tr>
		<!-- <tr><td>Spejdernet-brugernavn:</td><td><input type="text" name="ext_login" size="25" maxlength="25" value="'.$user->extLogin.'" /></td></tr> -->
		<tr><td>E-mail:</td><td><input type="text" name="email" size="25" maxlength="75" value="'.$user->email.'" /> <span class="help">Vigtig!</span></td></tr>
		<tr><td>Telefon (helst mobil):</td><td><input type="text" name="telephone" size="25" maxlength="50" value="'.$user->telephone.'" /> * <span class="help">Bruges til SMS-service for påmindelse og evt. ændringer af jobs.</span></td></tr>
		<!-- <tr><td>Adresse/postnr/by:</td><td><input type="text" name="address" size="25" maxlength="75" value="'.$user->address.'" /> *</td></tr> -->';

	if ($user->roleID == 3 || $_GET['role_id'] == 3) {
	echo '<!-- <tr><td>Alder under lejren:</td><td><input type="text" name="age_range" size="10" maxlength="10" value="'.$user->ageRange.'" /> *</td></tr> -->
		<tr><td>Antal:</td><td><input type="text" name="count" size="2" maxlength="3" value="'.$user->count.'" /> * <span class="help">Hvor mange hjælpere er I?</span></td></tr>
		<tr><td>Kvalifikationer:</td><td>'.$qualificationHTML.'<br><span class="help">Hvis der kr&aelig;ves certifikater, skal disse medbringes på lejren!</span></td></tr>
		<tr><td>Specielle kvalifikationer:</td><td><input type="text" name="qualifications" size="25" maxlength="255" value="'.$user->qualifications.'" /></td></tr>
		<tr><td>Klan/holdnavn/pladsnr:</td><td><input type="text" name="title" size="25" maxlength="75" value="'.$user->title.'" /></td></tr>
		<tr><td>Gruppe:</td><td>'.$groupsHTML.' *</td></tr>
		<!-- <tr><td>Foretrukne jobkategorier:</td><td>'.$jobcategoryHTML.'</td></tr> -->';
	}	
	
	if (user_is_admin()) {
		echo '<tr><td>Ingen email:</td><td><input type="checkbox" name="no_email" '.char2checkbox($user->noEmail).' /></td></tr>
			  <tr><td>Er kontaktet:</td><td><input type="checkbox" name="is_contacted" '.char2checkbox($user->isContacted).' /></td></tr>';
	} else {
		echo '<input type="hidden" name="no_email" '.char2checkbox($user->noEmail).' />
			  <input type="hidden" name="is_contacted" '.char2checkbox($user->isContacted).' />';
	}
	
	echo '<tr><td>Noter:</td><td><textarea name="notes" cols="50" rows="3">'.$user->notes.'</textarea></td></tr>
		<tr><td colspan="2" class="help">* markerer et obligatorisk felt</td></tr>

		<tr><td colspan="2"><input type="submit" value="Opdater"/></td></tr>
		<input type="hidden" name="action" value="do_update">
		<input type="hidden" name="nextaction" value="'.(referer_action() != "show_update" ? referer_action() : 'show_list').'">
		<input type="hidden" name="nextsort" value="'.referer_sort().'">
		'.(!user_is_admin() ? '<input type="hidden" name="role_id" value="'.$user->roleID.'" />' : '').'
		</form>

		<form action="'.$PHP_SELF.'" method="POST" onsubmit="return OkCancel(\'Er du sikker på du vil slette?\')">			
		<tr><td colspan="2"><br/><br/>Hvis du sletter din brugerprofil, fjernes alle jobopslag, jobtilmeldinger osv.!</td></tr>
		<tr><td colspan="2"><input type="submit" value="Slet"/></td></tr>
		<input type="hidden" name="action" value="do_delete">
		<input type="hidden" name="nextaction" value="'.(referer_action() != "show_update" ? referer_action() : 'show_list').'">
		<input type="hidden" name="nextsort" value="'.referer_sort().'">
		<input type="hidden" name="login" value="'.$user->login.'" />
		</form>
		</table>';

	menu_link();
}

function do_update() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	//require_params(array($_POST['login'], $_POST['lastname'], $_POST['firstname'], $_POST['telephone'], $_POST['address'], $_POST['age_range'], $_POST['count'], $_POST['role_id']));
	$error = "";
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
//	if (strlen($_POST['address']) < 4) {
//		$error .= "Adresse skal være mindst 4 karakterer.<br>";
//	}
//	if ($_POST['role_id'] == 3 && strlen($_POST['age_range']) < 1) {
//		$error .= "Alder skal være mindst 1 karakter.<br>";
//	}
	if ($_POST['role_id'] == 3 && (strlen($_POST['count']) < 1 || !is_numeric($_POST['count']))) {
		$error .= "Antal skal være et tal og mindst 1 ciffer.<br>";
	}
	if (!empty($_POST['email']) && !valid_email($_POST['email'])) {
		$error .= "Ugyldig email.<br>";
	}
	if ($_POST['role_id'] == 3 && empty($_POST['group_id']) || $_POST['group_id'] == "0") {
		$error .= "Ugyldig gruppe.<br>";
	}
	if (!empty($error)) {
		echo print_error($error);
		exit;
	}
	
	$user = new User($_POST['login'], null, $_POST['lastname'], $_POST['firstname'], null, $_POST['email'], null, $_POST['telephone'], $_POST['address'], $_POST['title'], null, null, $_POST['role_id'], $site_id, $_POST['group_id'], $_POST['count'], $_POST['age_range'], $_POST['qualifications'], $_POST['notes'], $_POST['ext_login'], checkbox2char($_POST['no_email']), checkbox2char($_POST['is_contacted']));
	
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
		do_redirect($PHP_SELF.'?action='.$_POST['nextaction'].'&sort='.$_POST['nextsort']);
	}
}

function do_delete() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	
	$error = "";
	if (empty($_POST['login'])) {
		$error .= "Brugernavn mangler..<br>";
	}
	if (!empty($error)) {
		echo print_error($error);
		exit;
	}
	
	deleteUser($_POST['login']);
	
	//if deleting own profile then logout, otherwise assume admin-mode and return to menu
	if($login == $user->login) {
		do_redirect('login.php?action=logout&site_id='.$site_id);
	} else {		
		do_redirect($PHP_SELF.'?action='.$_POST['nextaction'].'&sort='.$_POST['nextsort']);
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
		<tr><th align="left">Spejdernet-brugernavn:</th><td>'.$user->extLogin.'</td></tr>
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
} elseif ($_REQUEST['action'] == 'show_helpers_limit') {
	show_helpers_limit();
} elseif ($_REQUEST['action'] == 'do_delete') {
	do_delete();
} elseif ($_REQUEST['action'] == 'show_one') {
	show_one();
} else {
	echo 'Error: Page parameter missing!';
}

html_bottom();

?>