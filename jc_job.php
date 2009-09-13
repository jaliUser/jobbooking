<?php
include_once 'includes/init.php';
include_once 'jc_init.php';
//use reject_public_access() in individual functions

function getPlaces() {
	$places[] = "";
	$places[] = "Nørreport";
	$places[] = "Østerport";
	$places[] = "Sønderport";
	$places[] = "Vesterport";
	$places[] = "Andet";
	return $places;
}

function show_list() {
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Jobliste");
	$role = getRole($login);
	
	$area = getAreaFromContact($login);
	
	$jobs = listJobs($site_id, $_GET['status'], $_GET['user_id'], $_GET['filter']);
	if (!empty($_GET['user_id']) && !empty($_GET['status'])) {
		$title = "Jobs under <i>$area->description</i> der afventer godkendelse";
	} else if (!empty($_GET['user_id'])) {
		$title = "<a href=\"jc_user.php?action=show_one&login=".$_GET['user_id']."\">".getUser($_GET['user_id'])->getFullName()."</a>'s jobs";
	} elseif (!empty($_GET['filter'])) {
		$title = "Ledige jobs";
	} elseif (!empty($_GET['status'])) {
		$title = "Afventende jobs";
	} else {
		$title = "Alle godkendte jobs";
	}
	echo '<h1>'.$title.'</h1>
		<table align="center" class="border1" width="1000px">
		<tr> <th><i>Handlinger</i></th> <th>ID</th> <th>Område</th> <th>Navn</th> <th>Beskrivelse</th> <th>Kontakt</th> <th>Mødested</th> <th>Jobsted</th> <th>Noter</th> 
		<th title="Behov">B</th> 
		<th title="Rest">R</th>'
		.(user_is_admin() || $job->ownerID == $login ?'<th title="Status">S</th>':'')
		.(user_is_admin() ?'<th title="Prioritet">P</th>':'')
		.'</tr>';
	foreach ($jobs as $job) {
		$job = Job::cast($job);
		$area = Area::cast(getArea($job->id));

		echo "<tr><td>";
		if(user_is_admin() || user_is_consultant() || user_is_helper()) {
			echo "<a href='jc_signup.php?action=show_update&job_id=$job->id'>Tilmeld</a><br>";
		}
		if(user_is_admin() || $job->ownerID == $login) {
			echo "<a href='jc_signup.php?action=show_list&job_id=$job->id'>Vis&nbsp;tilmeldinger</a><br>
				<a href='$PHP_SELF?action=show_update&job_id=$job->id'>Redigér&nbsp;job</a><br>
				<a href='jc_timeslot.php?action=show_update&job_id=$job->id'>Redigér&nbsp;behov</a><br>";
		}
		if(user_is_admin()) {
			echo "<a href='jc_timeslot.php?action=show_assign&job_id=$job->id'>Tilknyt&nbsp;jobkonsulenter</a><br>
				  <a href='jc_signup.php?action=show_evals&job_id=$job->id'>Redigér&nbsp;evalueringer</a>";
		}
		if(user_is_arearesponsible() && !empty($_GET['user_id']) && !empty($_GET['status'])) {
			echo "<a href='$PHP_SELF?action=do_approve&job_id=$job->id'>Godkend</a>";
		}
		echo "</td>
				<td>$job->id</td>
				<td>$area->name</td>
				<td><a href='$PHP_SELF?action=show_one&job_id=$job->id'>$job->name</a></td>
				<td>$job->description</td>
				<td><a href=\"jc_user.php?action=show_one&login=$job->ownerID\">".getUser($job->ownerID)->getFullName()."</a></td>
				<td>$job->meetplace</td>
				<td>$job->jobplace</td>
				<td>$job->notes</td>
				<td>$job->totalNeed</td>
				<td>$job->remainingNeed</td>
				".(user_is_admin() || $job->ownerID == $login ?"<td title='".$job->getLongStatus()."'>".$job->getShortStatus()."</td>":'')."
				".(user_is_admin() ?"<td>$job->priority</td>":'')."
				</tr>";
	}
	echo '</table>';
	
	// show user list for admins
	if (user_is_admin() && !empty($_GET['user_id'])) {
		show_user_table("Vælg bruger der skal vises jobopslag for", "$PHP_SELF?action=show_list", listUsers($site_id, 2));
	}
	
	menu_link();
}

function show_create() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Opret job");

	//generate html for all areas
	$areasHTML = '<select name="area_id">';
	$areas = listAreas($site_id);
	foreach ($areas as $area) {
		$area = Area::cast($area);
		$areasHTML .= '<option value="'.$area->id.'">'.$area->description.' ('.$area->name.')</option>';
	}	
	$areasHTML .= '</select>';

	//generate html for users with employer role
	$ownerHTML = '<select name="owner_id">';
	if (user_is_admin()) {
		$users = listUsers($site_id, 2);
		foreach ($users as $user) {
			$user = User::cast($user);
			$ownerHTML .= '<option value="'.$user->login.'">'.$user->getFullName().'</option>';
		}
	} else {
		$ownerHTML .= '<option value="'.$login.'">'.getUser($login)->getFullName().'</option>';
	}
	$ownerHTML .= '</select>';
	
	$statusHTML =  '<select name="status">'
					.(user_is_admin() ? '<option value="A">'.Job::jobStatus('A').'</option>' : '').
					'<option value="W">'.Job::jobStatus('W').'</option>
					</select>';
					
	$priorityHTML = '<select name="priority">'
					.(user_is_admin() ? '<option>1</option><option>2</option><option selected>3</option><option>4</option><option>5</option>':'<option selected>3</option>')
					.'</select>';
	
	$places = getPlaces();
	$meetplacesHTML = '<select name="meetplace-predef">';
	foreach ($places as $place) {
		$meetplacesHTML .= "<option>$place</option>";
	}
	$meetplacesHTML .= '</select>';
	
	$jobplacesHTML = '<select name="jobplace-predef">';
	foreach ($places as $place) {
		$jobplacesHTML .= "<option>$place</option>";
	}
	$jobplacesHTML .= '</select>'; 

	echo '<h1>Opret job</h1>
		<form action="'.$PHP_SELF.'" method="POST">
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		
		<tr><td>Ansvarlig:</td><td>'.$ownerHTML.'</td></tr>
		<tr><td>Område:</td><td>'.$areasHTML.'</td></tr>
		<tr><td>Navn:</td><td><input type="text" name="name" size="64" maxlength="64" /> *</td></tr>
		<tr><td>Beskrivelse af opgaven:</td><td><textarea name="description" cols="48" rows="5"></textarea> *</td></tr>
		<tr><td>Mødested:</td><td>'.$meetplacesHTML.' Hvis andet: <input type="text" name="meetplace" size="25" maxlength="25" /> *</td></tr>
		<tr><td>Jobsted:</td><td>'.$jobplacesHTML.' Hvis andet: <input type="text" name="jobplace" size="25" maxlength="25" /> <span class="help">Udfyldes kun hvis forskelligt fra mødested.</span></td></tr>
		<tr><td>Bemærkninger:</td><td><textarea name="notes" cols="48" rows="5">F.eks. noget om:
- drikkevarer
- særlig beklædning
- transport</textarea></td></tr>
		<tr><td>Status:</td><td>'.$statusHTML.'</td></tr>
		<tr><td>Prioritet:</td><td>'.$priorityHTML.'</td></tr>
		<tr><td colspan="2" class="help">* markerer et obligatorisk felt</td></tr>

		<tr><td colspan="2"><input type="submit" value="Opret"/></td></tr>
		<input type="hidden" name="action" value="do_create">
		
		</table>
		</form>';

	
	menu_link();
}

function do_create() {
	reject_public_access();
	global $PHP_SELF, $site_id, $siteConfig;

	$meetplace = "";
	if (!empty($_POST['meetplace-predef'])) {
		$meetplace = $_POST['meetplace-predef'];
	} else {
		$meetplace = $_POST['meetplace'];
	}
	
	$jobplace = "";
	if (!empty($_POST['jobplace-predef'])) {
		$jobplace = $_POST['jobplace-predef'];
	} else {
		$jobplace = $_POST['jobplace'];
	}
	
	//require_params(array($_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['meetplace'], $_REQUEST['status'], $_REQUEST['priority']));
	$error = "";
	if (empty($_POST['area_id'])) {
		$error .= "Intet område valgt.<br>";
	} 
	if (empty($_POST['owner_id'])) {
		$error .= "Ingen ansvarlig valgt.<br>";
	}
	if (strlen($_POST['name']) < 4) {
		$error .= "Jobnavn skal være mindst 4 karakterer.<br>";
	}
	if (strlen($_POST['description']) < 10) {
		$error .= "Jobbeskrivelsen skal være mindst 10 karakterer.<br>";
	}
	if (strlen($meetplace) < 2) {
		$error .= "Mødested skal være mindst 2 karakterer.<br>";
	}
	if (empty($_POST['status'])) {
		$error .= "Ingen status valgt.<br>";
	}
	if (empty($_POST['priority'])) {
		$error .= "Ingen prioritet valgt.<br>";
	}
	if (!empty($error)) {
		echo print_error($error);
		exit;
	}
	
	$job = new Job(null, $site_id, $_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['description'], $meetplace, $jobplace, $_REQUEST['notes'], $_REQUEST['status'], $_REQUEST['priority']);

	createJob($job);
	
	if ($job->status == "W") {
		$area = getAreaFromId($job->areaID);
		$contact = getUser($area->contactID);
		if (!empty($contact->email) && valid_email($contact->email)) {
			$to = $contact->email;
		} else {
			$to = $siteConfig->config[SiteConfig::$EMAIL];
		}
		$subject = "Nyt job afventer din godkendelse";
		$message =	"Hej $contact->firstname \r\n".
					"\r\n". 
					"Et nyt job i Jobdatabasen for ".$siteConfig->siteName." afventer din godkendelse.\r\n".
					"Logind på http://see2010jobcenter.wh.spejdernet.dk og godkend jobbet, så hjælpere kan tilmelde sig det.\r\n".
					"\r\n".
					"Med venlig hilsen\r\n".
					$siteConfig->siteName."\r\n".
					"";		
		mail($to, $subject, $message, get_mail_headers());
	}
	
	do_redirect($PHP_SELF.'?action=show_list&user_id='.$_REQUEST['owner_id']);
}

function show_update() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Rediger job");

	$job = getJob($_GET['job_id']);
	$job = Job::cast($job);
	
	//generate html for all areas
	$areasHTML = '<select name="area_id">';
	$areas = listAreas($site_id);
	foreach ($areas as $area) {
		$area = Area::cast($area);
		$areasHTML .= '<option value="'.$area->id.' "'.($area->id == $job->areaID ? "selected" : "").'>'.$area->description.' ('.$area->name.')</option>';
	}
	$areasHTML .= '</select>';

	//generate html for users with employer role
	$ownerHTML = '<select name="owner_id">';
	if (user_is_admin()) {
		$users = listUsers($site_id, 2);
		foreach ($users as $user) {
			$user = User::cast($user);
			$ownerHTML .= '<option value="'.$user->login.'" '.($user->login == $job->ownerID ? "selected" : "").'>'.$user->getFullName().'</option>';
		}
	} else {
		$ownerHTML .= '<option value="'.$login.'">'.getUser($login)->getFullName().'</option>';
	}
	$ownerHTML .= '</select>';
	
	$statusHTML =  '<select name="status">'
					.(user_is_admin() ? '<option value="A">'.Job::jobStatus('A').'</option>' : '').
					'<option value="W">'.Job::jobStatus('W').'</option>
					</select>';
	
	$priorityHTML = '<select name="priority">'
					.(user_is_admin() ? '<option>1</option><option>2</option><option selected>3</option><option>4</option><option>5</option>':'<option selected>3</option>')
					.'</select>';
	
	$places = getPlaces();
	$meetplacesHTML = '<select name="meetplace-predef">';
	foreach ($places as $place) {
		$meetplacesHTML .= "<option>$place</option>";
	}
	$meetplacesHTML .= '</select>'; 
	
	$jobplacesHTML = '<select name="jobplace-predef">';
	foreach ($places as $place) {
		$jobplacesHTML .= "<option>$place</option>";
	}
	$jobplacesHTML .= '</select>'; 

	echo '<h1>Rediger job</h1>
		<form action="'.$PHP_SELF.'" method="POST">
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		
		<tr><td>Ansvarlig:</td><td>'.$ownerHTML.'</td></tr>
		<tr><td>Område:</td><td>'.$areasHTML.'</td></tr>
		<tr><td>Navn:</td><td><input type="text" name="name" size="64" maxlength="64" value="'.$job->name.'" /> *</td></tr>
		<tr><td>Beskrivelse af opgaven:</td><td><textarea name="description" cols="48" rows="5">'.$job->description.'</textarea> *</td></tr>
		<tr><td>Mødested:</td><td>'.$meetplacesHTML.' Hvis andet: <input type="text" name="meetplace" size="25" maxlength="25" value="'.$job->meetplace.'" /> *</td></tr>
		<tr><td>Jobsted:</td><td>'.$jobplacesHTML.' Hvis andet: <input type="text" name="jobplace" size="25" maxlength="25" value="'.$job->jobplace.'" /> <span class="help">Udfyldes kun hvis forskelligt fra mødested.</span></td></tr>
		<tr><td>Bemærkninger:</td><td><textarea name="notes" cols="48" rows="5">'.$job->notes.'</textarea></td></tr>
		<tr><td>Status:</td><td>'.$statusHTML.'</td></tr>
		<tr><td>Prioritet:</td><td>'.$priorityHTML.'</td></tr>
		<tr><td colspan="2" class="help">* markerer et obligatorisk felt</td></tr>

		<tr><td colspan="2"><input type="submit" value="Opdater"/></td></tr>
		<tr><td colspan="2"><a href="jc_timeslot.php?action=show_update&job_id='.$job->id.'">Rediger behov</a></td></tr>
		<input type="hidden" name="action" value="do_update">
		<input type="hidden" name="job_id" value="'.$job->id.'">
		</table>
		</form>';
	menu_link();
}

function do_update() {
	reject_public_access();
	global $PHP_SELF, $site_id;

	$meetplace = "";
	if (!empty($_POST['meetplace-predef'])) {
		$meetplace = $_POST['meetplace-predef'];
	} else {
		$meetplace = $_POST['meetplace'];
	}
	
	$jobplace = "";
	if (!empty($_POST['jobplace-predef'])) {
		$jobplace = $_POST['jobplace-predef'];
	} else {
		$jobplace = $_POST['jobplace'];
	}
	
	//require_params(array($_REQUEST['job_id'], $_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['meetplace'], $_REQUEST['status'], $_REQUEST['priority']));
	$error = "";
	if (empty($_POST['job_id'])) {
		$error .= "JobID mangler.<br>";
	}
	if (empty($_POST['area_id'])) {
		$error .= "Intet område valgt.<br>";
	} 
	if (empty($_POST['owner_id'])) {
		$error .= "Ingen ansvarlig valgt.<br>";
	}
	if (strlen($_POST['name']) < 4) {
		$error .= "Jobnavn skal være mindst 4 karakterer.<br>";
	}
	if (strlen($_POST['description']) < 10) {
		$error .= "Jobbeskrivelsen skal være mindst 10 karakterer.<br>";
	}
	if (strlen($meetplace) < 2) {
		$error .= "Mødested skal være mindst 2 karakterer.<br>";
	}
	if (empty($_POST['status'])) {
		$error .= "Ingen status valgt.<br>";
	}
	if (empty($_POST['priority'])) {
		$error .= "Ingen prioritet valgt.<br>";
	}
	if (!empty($error)) {
		echo print_error($error);
		exit;
	}
	
	$job = new Job($_REQUEST['job_id'], $site_id, $_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['description'], $meetplace, $jobplace, $_REQUEST['notes'], $_REQUEST['status'], $_REQUEST['priority']);

	updateJob($job);
	do_redirect($PHP_SELF.'?action=show_list');
}

function do_approve() {
	reject_public_access();
	global $PHP_SELF, $login;

	if (empty($_GET['job_id'])) {
		echo print_error("JobID mangler");
		exit;
	}

	updateJobStatus($_GET['job_id'], "A");
	do_redirect($PHP_SELF.'?action=show_list&status=W&user_id='.$login);
}

function show_one() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Vis job");

	$job = getJob($_GET['job_id']);
	$job = Job::cast($job);
	
	echo '<h1>Vis job <i>'.$job->name.'</i></h1>
		<table align="center" class="border1">
		<tr><th align="left">Ansvarlig:</th><td><a href="jc_user.php?action=show_one&login='.$job->ownerID.'">'.getUser($job->ownerID)->getFullName().'</a></td></tr>
		<tr><th align="left">Område:</th><td>'.getArea($job->id)->description.' ('.getArea($job->id)->name.')</td></tr>
		<tr><th align="left">Beskrivelse af opgaven:</th><td>'.$job->description.'</td></tr>
		<tr><th align="left">Mødested:</th><td>'.$job->meetplace.'</td></tr>
		<tr><th align="left">Jobsted:</th><td>'.$job->jobplace.'</td></tr>
		<tr><th align="left">Bemærkninger:</th><td>'.$job->notes.'</td></tr>
		<tr><th align="left">Status:</th><td>'.$job->getLongStatus().'</td></tr>
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
} elseif ($_REQUEST['action'] == 'do_approve') {
	do_approve();
} elseif ($_REQUEST['action'] == 'show_list') {
	show_list();
} elseif ($_REQUEST['action'] == 'show_one') {
	show_one();
} else {
	echo 'Error: Page parameter missing!';
}

html_bottom();

?>
