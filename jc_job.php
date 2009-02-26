<?php
include_once 'includes/init.php';
include_once 'jc_init.php';
//reject_public_access();

function show_list() {
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Jobliste");

	$jobs = listJobs(1);
	echo '<h1>Jobliste</h1>
		<table align="center">
		<tr> <th>ID</th> <th>Område</th> <th>Navn</th> <th>Beskrivelse</th> <th>Kontakt</th> <th>Sted</th> <th>Noter</th> <th>Status</th></tr>';
	foreach ($jobs as $job) {
		$job = Job::cast($job);
		$area = Area::cast(getArea($job->id));

		echo "<tr> <td>";
		if(user_is_admin() || $job->ownerID == $login) {
			echo "<a href='$PHP_SELF?action=show_update&job_id=$job->id'>$job->id</a>";
		} else {
			echo $job->id;
		}
		echo "</td> <td>$area->name</td> <td>$job->name</td> <td>$job->description</td> <td>$job->ownerID</td> <td>$job->place</td> <td>$job->notes</td> <td>".jobStatus($job->status)."</td></tr>";

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
	global $PHP_SELF, $site_id;
	require_params(array($_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['status']));
	$job = new Job(null, $site_id, $_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['description'], $_REQUEST['place'], $_REQUEST['notes'], $_REQUEST['status']);

	createJob($job);
	do_redirect($PHP_SELF.'?action=show_list');
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
		<input type="hidden" name="action" value="do_update">
		<input type="hidden" name="job_id" value="'.$job->id.'">
		
		</table>
		</form>';
	menu_link();
}

function do_update() {
	global $PHP_SELF, $site_id;
	require_params(array($_REQUEST['job_id'], $_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['status']));
	$job = new Job($_REQUEST['job_id'], $site_id, $_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['description'], $_REQUEST['place'], $_REQUEST['notes'], $_REQUEST['status']);

	updateJob($job);
	do_redirect($PHP_SELF.'?action=show_list');
}

function show_update_timeslots() {
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Rediger timeslots");

	$job = getJob($_GET['job_id']);
	$job = Job::cast($job);
	
	//generate rows for existing timeslots
	echo '<table align="center" border="1" cellspacing="3" cellpadding="3">
		<tr><th>Tid</th>';
	$days = listDays($site_id);
	
	//generate header with days
	foreach ($days as $day) {
		$day = Day::cast($day);
		echo '<th>'.date("D d/m", $day->getDateTS()).'</th>';
	}
	
	//find distinct timeslots
	$timeslots = listTimeslots($job->id);
	if (count($timeslots) > 0) {
		$dts_idx = 0;
		$distinct_timeslots[0][0] = $timeslots[0];
		
		for ($ts_idx=1; $ts_idx<=(count($timeslots)-1); $ts_idx++) {
			$prevTS = Timeslot::cast($distinct_timeslots[$dts_idx][0]);
			$ts = Timeslot::cast($timeslots[$ts_idx]);
			
			//if TS equal to prevTS, add to same distinctTS
			//else create new distinctTS (increase dts_idx) 
			if ($ts->startTime == $prevTS->startTime && $ts->duration == $prevTS->duration) {
				$distinct_timeslots[$dts_idx][] = $timeslots[$ts_idx]; 
			} else {
				$dts_idx++;
				$distinct_timeslots[$dts_idx][] = $timeslots[$ts_idx];
			}
		}
		
		//use builded $distinct_timeslots (2D-array)
		foreach ($distinct_timeslots as $distinctTSarr) {
			//build time-row from first TS in first distinctTSarr
			echo '<tr><td><input type="text" name="start_hour" size="2" maxlength="2" value="'.$distinctTSarr[0]->getStartHour().'" />:<input type="text" name="start_min" size="2" maxlength="2" value="'.$distinctTSarr[0]->getStartMin().'" />
				 - <input type="text" name="end_hour" size="2" maxlength="2" value="'.$distinctTSarr[0]->getEndHour().'" />:<input type="text" name="end_min" size="2" maxlength="2" value="'.$distinctTSarr[0]->getEndMin().'" /></td>';
			$daysWithValues = null;
			foreach ($distinctTSarr as $ts) {
				$ts = Timeslot::cast($ts);
				//loop through days and echo personNeed if matching TS->date, copy into joint daysArray
				for ($i=0; $i<count($days); $i++) {
					$day = Day::cast($days[$i]);
					if ($ts->date == $day->getDateYMD()) {
						$daysWithValues[$i] = $ts->personNeed;
					} 
				}
			}
			for ($dayNo=0; $dayNo<count($days); $dayNo++) {
				echo '<td align="center"><input type="text" name="person_need[]" value="'.$daysWithValues[$dayNo].'" size="5" maxlength="25" />	</td>';
			}
			echo '</tr>';
		}
	}
	
	//show form for creating new timeslot
	echo '<tr><td colspan="'.(count($days)+1).'">Opret ny tidsperiode: Angiv starttid & sluttid, samt behov på de enkelte dage.</td></tr>';
	echo '<form action="'.$PHP_SELF.'" method="POST">
		<tr><td><input type="text" name="start_hour" size="2" maxlength="2" value="00" />:<input type="text" name="start_min" size="2" maxlength="2" value="00" />
		 - <input type="text" name="end_hour" size="2" maxlength="2" value="00" />:<input type="text" name="end_min" size="2" maxlength="2" value="00" /></td>';
	for ($i=0; $i<count($days); $i++) {
		echo '<td align="center"><input type="text" name="person_need[]" size="5" maxlength="25" />	</td>';
	}	
	echo '</tr>
		<tr><td colspan="'.(count($days)+1).'"><input type="submit" value="Indsæt"/></td></tr>
		<input type="hidden" name="action" value="do_create_timeslot">
		<input type="hidden" name="job_id" value="'.$job->id.'">
		</form>';
	
	echo '</table>';
}

function do_create_timeslot() {
	global $PHP_SELF, $site_id, $login;
	//require_params();
	
	$start_hour = $_POST['start_hour'];
	$start_min = $_POST['start_min'];
	$end_hour = $_POST['end_hour'];
	$end_min = $_POST['end_min'];
	if (!valid_time($start_hour, $start_min) || !valid_time($end_hour, $end_min)) {
		echo "Ugyldig tidsperiode!";
		exit;
	}
	
	$need_list = $_POST['person_need'];
	foreach ($need_list as $need) {
		if (!empty($need) && !is_numeric($need)) {
			echo "Ugyldigt behov!";
			exit;
		}
	}
	
	$start_caltime = get_caltime($start_hour, $start_min);
	$end_caltime = get_caltime($end_hour, $end_min);
	$duration = get_calduration($start_caltime, $end_caltime);
	
	$j = getJob($_POST['job_id']);
	$j = Job::cast($j);
		
	$days = listDays($site_id);
	
	for ($i=0; $i<count($need_list); $i++) {
		if (!empty($need_list[$i])) {
			$day = $days[$i];
			//$event = new Event($j->name, $j->description, $day->getDateYMD(), $start_caltime, null, null, 5, 'P', $duration, 'A', $j->ownerID, null, $j->ownerID, 'E', $j->place, null, $day->getDateYMD(), $start_caltime, 0, get_caldate_date(), get_caltime_date());
			$date = $day->getDateYMD();
			$timeslot = new Timeslot(null, $date, $start_caltime, $duration, $_POST['job_id'], $need_list[$i]);
			createTimeslot($timeslot);
		}
	}
	
	do_redirect($PHP_SELF.'?action=show_update_timeslots&job_id='.$_POST['job_id']);
}

//show_timeslots();

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
} elseif ($_REQUEST['action'] == 'show_update_timeslots') {
	show_update_timeslots();
} elseif ($_REQUEST['action'] == 'do_create_timeslot') {
	do_create_timeslot();
} else {
	echo 'Error: Paramers missing!';
}

html_bottom();

?>