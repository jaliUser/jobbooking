<?php
include_once 'includes/init.php';
include_once 'jc_init.php';
//use reject_public_access() in individual functions

function getPlaces() {
	$places[] = "";
	$places[] = "Storetorv";
	$places[] = "Parkeringspladsen";
	$places[] = "Andet";
	return $places;
}

function show_list() {
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Jobliste");
	$role = getRole($login);
	
	$jobs = listJobs($site_id, null, null, $_GET['user_id'], $_GET['filter']);
	if (!empty($_GET['user_id'])) {
		$title = "<a href=\"jc_user.php?action=show_one&login=".$_GET['user_id']."\">".getUser($_GET['user_id'])->getFullName()."</a>'s jobs";
	} elseif (!empty($_GET['filter'])) {
		$title = "Ledige jobs";
	} else {
		$title = "Alle jobs";
	}
	echo '<h1>'.$title.'</h1>
		<table align="center" class="border1">
		<tr> <th>ID</th> <th>Område</th> <th>Navn</th> <th>Beskrivelse</th> <th>Kontakt</th> <th>Sted</th> <th>Noter</th> '
		.(!empty($_GET['show_status'])?'<th>Status</th>':'')
		.(!empty($_GET['show_priority'])?'<th>Prioritet</th>':'')
		.' <th></th> </tr>';
	foreach ($jobs as $job) {
		$job = Job::cast($job);
		$area = Area::cast(getArea($job->id));

		echo "<tr>
				<td>$job->id</td>
				<td>$area->name</td>
				<td>".(user_is_admin() || $job->ownerID == $login ? "<a href='$PHP_SELF?action=show_one&job_id=$job->id'>$job->name</a>" : $job->name)."</td>
				<td>$job->description</td>
				<td><a href=\"jc_user.php?action=show_one&login=$job->ownerID\">".getUser($job->ownerID)->getFullName()."</a></td>
				<td>$job->place</td>
				<td>$job->notes</td>
				".(!empty($_GET['show_status'])?"<td title='".$job->getLongStatus()."'>".$job->getShortStatus()."</td>":'')."
				".(!empty($_GET['show_priority'])?"<td>$job->priority</td>":'')."
				<td>";
		if(user_is_helper()) {
			echo "<a href='jc_signup.php?action=show_update&job_id=$job->id'>Tilmeld</a><br>";
		}
		if(user_is_admin() || $job->ownerID == $login) {
			echo "<a href='jc_signup.php?action=show_list&job_id=$job->id'>Vis tilmeldinger</a><br>
				<a href='$PHP_SELF?action=show_update&job_id=$job->id'>Redigér job</a><br>
				<a href='jc_timeslot.php?action=show_update&job_id=$job->id'>Redigér behov</a><br>";
		}
		if(user_is_admin()) {
			echo "<a href='jc_timeslot.php?action=show_assign&job_id=$job->id'>Redigér jobkonsulenter</a><br>
				  <a href='jc_signup.php?action=show_evals&job_id=$job->id'>Redigér evalueringer</a>";
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
	$users = listUsers($site_id, 2);
	foreach ($users as $user) {
		$user = User::cast($user);
		$ownerHTML .= '<option value="'.$user->login.'">'.$user->getFullName().'</option>';
	}
	$ownerHTML .= '</select>';
	
	$statusHTML =  '<select name="status">'
					.(user_is_admin() ? '<option value="A">'.Job::jobStatus('A').'</option>' : '').
					'<option value="W">'.Job::jobStatus('W').'</option>
					</select>';
					
	$priorityHTML = '<select name="priority">
					<option>1</option><option>2</option><option selected>3</option><option>4</option><option>5</option>
					</select>';
	
	$places = getPlaces();
	$placesHTML = '<select name="place-predef">';
	foreach ($places as $place) {
		$placesHTML .= "<option>$place</option>";
	}
	$placesHTML .= '</select>'; 

	echo '<h1>Opret job</h1>
		<form action="'.$PHP_SELF.'" method="POST">
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		
		<tr><td>Ansvarlig:</td><td>'.$ownerHTML.'</td></tr>
		<tr><td>Område:</td><td>'.$areasHTML.'</td></tr>
		<tr><td>Navn:</td><td><input type="text" name="name" size="64" maxlength="64" /></td></tr>
		<tr><td>Beskrivelse af opgaven:</td><td><textarea name="description" cols="48" rows="5"></textarea></td></tr>
		<tr><td>Mødested:</td><td>'.$placesHTML.' Hvis andet: <input type="text" name="place" size="25" maxlength="25" /></td></tr>
		<tr><td>Bemærkninger:</td><td><textarea name="notes" cols="48" rows="5">F.eks. noget om:
- drikkevarer
- særlig beklædning
- transport</textarea></td></tr>
		<tr><td>Status:</td><td>'.$statusHTML.'</td></tr>
		<tr><td>Prioritet:</td><td>'.$priorityHTML.'</td></tr>

		<tr><td colspan="2"><input type="submit" value="Opret"/></td></tr>
		<input type="hidden" name="action" value="do_create">
		
		</table>
		</form>';

	
	menu_link();
}

function do_create() {
	reject_public_access();
	global $PHP_SELF, $site_id;
	require_params(array($_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['status'], $_REQUEST['priority']));

	$place = "";
	if (!empty($_POST['place-predef'])) {
		$place = $_POST['place-predef'];
	} else {
		$place = $_POST['place'];
	}
	
	$job = new Job(null, $site_id, $_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['description'], $place, $_REQUEST['notes'], $_REQUEST['status'], $_REQUEST['priority']);

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
	$users = listUsers($site_id, 2);
	foreach ($users as $user) {
		$user = User::cast($user);
		$ownerHTML .= '<option value="'.$user->login.'" '.($user->login == $job->ownerID ? "selected" : "").'>'.$user->getFullName().'</option>';
	}
	$ownerHTML .= '</select>';
	
	$statusHTML =  '<select name="status">'
					.(user_is_admin() ? '<option value="A">'.Job::jobStatus('A').'</option>' : '').
					'<option value="W">'.Job::jobStatus('W').'</option>
					</select>';
	
	$priorityHTML = '<select name="priority">
					<option>1</option><option>2</option><option selected>3</option><option>4</option><option>5</option>
					</select>';
	
	$places = getPlaces();
	$placesHTML = '<select name="place-predef">';
	foreach ($places as $place) {
		$placesHTML .= "<option".($job->place == $place ? ' selected' : '').">$place</option>";
	}
	$placesHTML .= '</select>'; 

	echo '<h1>Rediger job</h1>
		<form action="'.$PHP_SELF.'" method="POST">
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		
		<tr><td>Ansvarlig:</td><td>'.$ownerHTML.'</td></tr>
		<tr><td>Område:</td><td>'.$areasHTML.'</td></tr>
		<tr><td>Navn:</td><td><input type="text" name="name" size="64" maxlength="64" value="'.$job->name.'" /></td></tr>
		<tr><td>Beskrivelse af opgaven:</td><td><textarea name="description" cols="48" rows="5">'.$job->description.'</textarea></td></tr>
		<tr><td>Mødested:</td><td>'.$placesHTML.' Hvis andet: <input type="text" name="place" size="25" maxlength="25" value="'.$job->place.'" /></td></tr>
		<tr><td>Bemærkninger:</td><td><textarea name="notes" cols="48" rows="5">'.$job->notes.'</textarea></td></tr>
		<tr><td>Status:</td><td>'.$statusHTML.'</td></tr>
		<tr><td>Prioritet:</td><td>'.$priorityHTML.'</td></tr>

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
	require_params(array($_REQUEST['job_id'], $_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['status'], $_REQUEST['priority']));
	
	$place = "";
	if (!empty($_POST['place-predef'])) {
		$place = $_POST['place-predef'];
	} else {
		$place = $_POST['place'];
	}
	
	$job = new Job($_REQUEST['job_id'], $site_id, $_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['description'], $place, $_REQUEST['notes'], $_REQUEST['status'], $_REQUEST['priority']);

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
} elseif ($_REQUEST['action'] == 'show_one') {
	show_update();
} else {
	echo 'Error: Page parameter missing!';
}

html_bottom();

?>