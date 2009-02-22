<?php
include_once 'includes/init.php';
include_once 'jc_init.php';
reject_public_access();

function show_list() {
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Jobliste");

	$jobs = listJobs(1);
	echo '<h1>Jobliste</h1>
		<table align="center">
		<tr> <th>ID</th> <th>Område</th> <th>Navn</th> <th>Beskrivelse</th> <th>Kontakt</th> <th>Sted</th> <th>Noter</th> </tr>';
	foreach ($jobs as $job) {
		$job = Job::cast($job);
		$area = Area::cast(getArea($job->id));

		echo "<tr> <td><a href='$PHP_SELF?action=show_update&job_id=$job->id'>$job->id</a></td> <td>$area->name</td> <td>$job->name</td> <td>$job->description</td> <td>$job->ownerID</td> <td>$job->place</td> <td>$job->notes</td> </tr>";

	}
	echo '</table>';
	menu_link();
}

function show_create() {
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
	$users = listUsersWithRole($site_id, 2);
	foreach ($users as $user) {
		$user = User::cast($user);
		$ownerHTML .= '<option value="'.$user->login.'">'.$user->getFullName().'</option>';
	}
	$ownerHTML .= '</select>';
	
	echo '<h1>Opret job</h1>
		<form action="'.$PHP_SELF.'" method="POST">
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		
		<tr><td>Ansvarlig:</td><td>'.$ownerHTML.'</td></tr>
		<tr><td>Område:</td><td>'.$areasHTML.'</td></tr>
		<tr><td>Navn:</td><td><input type="text" name="name" size="25" maxlength="25" /></td></tr>
		<tr><td>Beskrivelse af opgaven:</td><td><input type="text" name="description" size="25" maxlength="25" /></td></tr>
		<tr><td>Mødested:</td><td><input type="text" name="place" size="25" maxlength="25" /></td></tr>
		<tr><td>Bemærkninger:</td><td><input type="text" name="notes" size="25" maxlength="25" /></td></tr>

		<tr><td colspan="2"><input type="submit" value="Opret"/></td></tr>
		<input type="hidden" name="action" value="do_create">
		
		</table>
		</form>';

	echo '<table align="center" border="1" cellspacing="3" cellpadding="3">
		<tr><th>Tid</th>';
	$days = listDays(1);
	
	//generate header with days
	foreach ($days as $day) {
		$day = Day::cast($day);
		echo '<th>'.date("D d/m", $day->getDateTS()).'</th>';
	}
	
	//generate rows for existing timeslots
	$events = listEvents(1);
	foreach ($events as $event) {
		$event = Event::cast($event);
		echo '';
	}
	
	//show form for creating new timeslot
	echo '<tr><td colspan="'.(count($days)+1).'">Opret ny tidsperiode: Angiv starttid & sluttid, samt behov på den enkelte dage.</td></tr>';
	echo '<form action="'.$PHP_SELF.'" method="POST">
		<tr><td><input type="text" name="newstart" size="2" maxlength="2" value="00" /> : <input type="text" name="newend" size="2" maxlength="2" value="00" /></td>';
	for ($i=0; $i<count($days); $i++) {
		echo '<td align="center"><input type="text" name="new'.$i.'" size="5" maxlength="25" />	</td>';
	}
	
	echo '</tr>
		</form>';
	
	echo '</table>';
	menu_link();
}

function do_create() {
	global $PHP_SELF, $site_id;
	require_params(array($_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name']));
	$job = new Job(null, $site_id, $_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['description'], $_REQUEST['place'], $_REQUEST['notes']);
	if ($job) {
		createJob($job);
		do_redirect($PHP_SELF.'?action=show_list');
	}
	else {
		html_top($title . " - Jobs");
		echo '<b>Fejl:</b> Navnet er ugyldigt eller findes allerede!<br/>Kun tegnene A-Z og _ er tilladte, ikke &AElig;, &Oslash; og &Aring;.';
	}
}

function show_update() {
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
	$users = listUsersWithRole($site_id, 2);
	foreach ($users as $user) {
		$user = User::cast($user);
		$ownerHTML .= '<option value="'.$user->login.'" '.($user->login == $job->ownerID ? "selected" : "").'>'.$user->getFullName().'</option>';
	}
	$ownerHTML .= '</select>';
	
	echo '<h1>Rediger job</h1>
		<form action="'.$PHP_SELF.'" method="POST">
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		
		<tr><td>Ansvarlig:</td><td>'.$ownerHTML.'</td></tr>
		<tr><td>Område:</td><td>'.$areasHTML.'</td></tr>
		<tr><td>Navn:</td><td><input type="text" name="name" size="25" maxlength="25" value="'.$job->name.'" /></td></tr>
		<tr><td>Beskrivelse af opgaven:</td><td><input type="text" name="description" size="25" maxlength="25" value="'.$job->description.'" /></td></tr>
		<tr><td>Mødested:</td><td><input type="text" name="place" size="25" maxlength="25" value="'.$job->place.'" /></td></tr>
		<tr><td>Bemærkninger:</td><td><input type="text" name="notes" size="25" maxlength="25" value="'.$job->notes.'" /></td></tr>

		<tr><td colspan="2"><input type="submit" value="Opdater"/></td></tr>
		<input type="hidden" name="action" value="do_update">
		
		</table>
		</form>';

	menu_link();
}

function do_update() {
	global $PHP_SELF, $login, $site_id, $site_name;
//	require_params(array($_POST['login'], $_POST['lastname'], $_POST['firstname'], $_POST['telephone'], $_POST['address'], $_POST['birthday'], $_POST['role_id']));
//	
//	$user = new User($_POST['login'], null, $_POST['lastname'], $_POST['firstname'], null, $_POST['email'], null, $_POST['telephone'], $_POST['address'], null, $_POST['birthday'], null, $_POST['role_id'], $site_id);
//	
//	updateUser($user);
//
//	if($_POST['password']) {
//		$user->setPasswd($_POST['password']);
//		updateUserPasswd($user);
//	}
//	
//	//if editing own profile return to menu, otherwise assume admin-mode and return to menu
//	if($login == $user->login) {
//		do_redirect('jc_menu.php');
//	} else {		
//		do_redirect($PHP_SELF.'?action=show_list');
//	}
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