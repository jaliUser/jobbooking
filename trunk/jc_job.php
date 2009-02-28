<?php
include_once 'includes/init.php';
include_once 'jc_init.php';
//use reject_public_access() in individual functions

function show_list() {
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Jobliste");

	$jobs = listJobs($site_id);
	echo '<h1>Jobliste</h1>
		<table align="center">
		<tr> <th>ID</th> <th>Område</th> <th>Navn</th> <th>Beskrivelse</th> <th>Kontakt</th> <th>Sted</th> <th>Noter</th> <th>Status</th> <th></th> </tr>';
	foreach ($jobs as $job) {
		$job = Job::cast($job);
		$area = Area::cast(getArea($job->id));

		echo "<tr> <td>";
		if(user_is_admin() || $job->ownerID == $login) {
			echo "<a href='$PHP_SELF?action=show_update&job_id=$job->id'>$job->id</a>";
		} else {
			echo $job->id;
		}
		echo "</td> <td>$area->name</td> <td>$job->name</td> <td>$job->description</td> <td>$job->ownerID</td> <td>$job->place</td> <td>$job->notes</td> <td>".jobStatus($job->status)."</td> <td>";
		if(user_is_admin() || $job->ownerID == $login) {
			echo "<a href='jc_timeslot.php?action=show_update&job_id=$job->id'>Behov</a> - 
				<a href='jc_timeslot.php?action=show_signup&job_id=$job->id'>Tilmelding</a>";
		}
		echo "</td></tr>";

	}
	echo '</table>';
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
	$users = listUsersWithRole($site_id, 2);
	foreach ($users as $user) {
		$user = User::cast($user);
		$ownerHTML .= '<option value="'.$user->login.'">'.$user->getFullName().'</option>';
	}
	$ownerHTML .= '</select>';
	
	$statusHTML =  '<select name="status">'
					.(user_is_admin() ? '<option value="A">'.jobStatus('A').'</option>' : '').
					'<option value="W">'.jobStatus('W').'</option>
					</select>';
	
	echo '<h1>Opret job</h1>
		<form action="'.$PHP_SELF.'" method="POST">
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		
		<tr><td>Ansvarlig:</td><td>'.$ownerHTML.'</td></tr>
		<tr><td>Område:</td><td>'.$areasHTML.'</td></tr>
		<tr><td>Navn:</td><td><input type="text" name="name" size="25" maxlength="25" /></td></tr>
		<tr><td>Beskrivelse af opgaven:</td><td><input type="text" name="description" size="25" maxlength="25" /></td></tr>
		<tr><td>Mødested:</td><td><input type="text" name="place" size="25" maxlength="25" /></td></tr>
		<tr><td>Bemærkninger:</td><td><input type="text" name="notes" size="25" maxlength="25" /></td></tr>
		<tr><td>Status:</td><td>'.$statusHTML.'</td></tr>

		<tr><td colspan="2"><input type="submit" value="Opret"/></td></tr>
		<input type="hidden" name="action" value="do_create">
		
		</table>
		</form>';

	
	menu_link();
}

function do_create() {
	reject_public_access();
	global $PHP_SELF, $site_id;
	require_params(array($_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['status']));
	$job = new Job(null, $site_id, $_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['description'], $_REQUEST['place'], $_REQUEST['notes'], $_REQUEST['status']);

	createJob($job);
	do_redirect($PHP_SELF.'?action=show_list');
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
	$users = listUsersWithRole($site_id, 2);
	foreach ($users as $user) {
		$user = User::cast($user);
		$ownerHTML .= '<option value="'.$user->login.'" '.($user->login == $job->ownerID ? "selected" : "").'>'.$user->getFullName().'</option>';
	}
	$ownerHTML .= '</select>';
	
	$statusHTML =  '<select name="status">'
					.(user_is_admin() ? '<option value="A">'.jobStatus('A').'</option>' : '').
					'<option value="W">'.jobStatus('W').'</option>
					</select>';
	
	echo '<h1>Rediger job</h1>
		<form action="'.$PHP_SELF.'" method="POST">
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		
		<tr><td>Ansvarlig:</td><td>'.$ownerHTML.'</td></tr>
		<tr><td>Område:</td><td>'.$areasHTML.'</td></tr>
		<tr><td>Navn:</td><td><input type="text" name="name" size="25" maxlength="25" value="'.$job->name.'" /></td></tr>
		<tr><td>Beskrivelse af opgaven:</td><td><input type="text" name="description" size="25" maxlength="25" value="'.$job->description.'" /></td></tr>
		<tr><td>Mødested:</td><td><input type="text" name="place" size="25" maxlength="25" value="'.$job->place.'" /></td></tr>
		<tr><td>Bemærkninger:</td><td><input type="text" name="notes" size="25" maxlength="25" value="'.$job->notes.'" /></td></tr>
		<tr><td>Status:</td><td>'.$statusHTML.'</td></tr>

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
	require_params(array($_REQUEST['job_id'], $_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['status']));
	$job = new Job($_REQUEST['job_id'], $site_id, $_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['description'], $_REQUEST['place'], $_REQUEST['notes'], $_REQUEST['status']);

	updateJob($job);
	do_redirect($PHP_SELF.'?action=show_list');
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