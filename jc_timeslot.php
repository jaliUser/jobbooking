<?php
include_once 'includes/init.php';
include_once 'jc_init.php';
//use reject_public_access() in individual functions

function show_update() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Rediger behov");

	$job = getJob($_GET['job_id']);
	$job = Job::cast($job);
	
	echo "<h1>Redigér behov for <i> $job->name</i></h1>";
	//generate rows for existing timeslots
	echo '<table align="center" border="1" cellspacing="3" cellpadding="3">
		<form action="'.$PHP_SELF.'" method="POST">
		<tr><th>Tid</th>';
	$days = listDays($site_id);
	
	//generate header with days
	foreach ($days as $day) {
		$day = Day::cast($day);
		echo '<th>'.date("D d/m", $day->getDateTS()).'</th>';
	}
	
	$timeslots = listTimeslots($job->id);
	$groupedTimeslots = groupTimeslotsByTime($timeslots);
	
	foreach ($groupedTimeslots as $distinctTimeArr) {
		//build time-row from first TS in distinctTimeArr			
		$firstTS = $distinctTimeArr[0];
		echo '<tr><td><input type="text" name="start_hour" size="1" maxlength="2" value="'.$firstTS->getStartHour().'" disabled/>:<input type="text" name="start_min" size="1" maxlength="2" value="'.$firstTS->getStartMin().'" disabled/>
			        - <input type="text" name="end_hour" size="1" maxlength="2" value="'.$firstTS->getEndHour().'" disabled    />:<input type="text" name="end_min" size="1" maxlength="2" value="'.$firstTS->getEndMin().'" disabled/></td>';

		for ($dayNo=0; $dayNo<count($days); $dayNo++) {
			$timeslot = Timeslot::cast($distinctTimeArr[$dayNo]);
			$signup = $signups[$timeslot->id];
			echo '<td align="center">
				<input type="text" name="timeslot-'.$timeslot->id.'" value="'.$timeslot->personNeed.'" size="2" maxlength="3"/>
				</td>';
		}
		echo '</tr>';
	}
	echo '<tr><td colspan="'.(count($days)+1).'"><input type="submit" value="Opdatér"/></td></tr>
		<input type="hidden" name="action" value="do_update">
		<input type="hidden" name="job_id" value="'.$job->id.'">
		</form>';
	
	//show form for creating new timeslot
	echo '<tr><td colspan="'.(count($days)+1).'">Opret ny tidsperiode: Angiv starttid & sluttid, samt behov på de enkelte dage.</td></tr>';
	echo '<form action="'.$PHP_SELF.'" method="POST">
		<tr><td><input type="text" name="start_hour" size="1" maxlength="2" value="00" />:<input type="text" name="start_min" size="1" maxlength="2" value="00" />
		 - <input type="text" name="end_hour" size="1" maxlength="2" value="00" />:<input type="text" name="end_min" size="1" maxlength="2" value="00" /></td>';
	for ($i=0; $i<count($days); $i++) {
		echo '<td align="center"><input type="text" name="person_need-'.$i.'" size="2" maxlength="3" />	</td>';
	}	
	echo '</tr>
		<tr><td colspan="'.(count($days)+1).'"><input type="submit" value="Indsæt"/></td></tr>
		<input type="hidden" name="action" value="do_create">
		<input type="hidden" name="job_id" value="'.$job->id.'">
		</form>';
	
	echo '</table>';
	menu_link();
}

function do_update() {
	reject_public_access();
	global $PHP_SELF;
	$timeslots = listTimeslots($_POST['job_id']);
	foreach ($timeslots as $ts) {
		updateTimeslotNeed($ts->id, $_POST['timeslot-'.$ts->id]);
	}
	do_redirect($PHP_SELF.'?action=show_update&job_id='.$_POST['job_id']);
}

function do_create() {
	reject_public_access();
	global $PHP_SELF, $site_id, $login;
	//require_params();
	
	$days = listDays($site_id);
	
	$start_hour = $_POST['start_hour'];
	$start_min = $_POST['start_min'];
	$end_hour = $_POST['end_hour'];
	$end_min = $_POST['end_min'];
	if (!valid_time($start_hour, $start_min) || !valid_time($end_hour, $end_min)) {
		echo "Fejl: Ugyldig tidsperiode!";
		exit;
	}
	
	for ($i=0; $i<count($days); $i++) {
		if (!Timeslot::isValidPersonNeed($_POST['person_need-'.$i])) {
			echo "Fejl: Ugyldigt behov for dag ".($i+1)."!";
			exit;
		}
	}
	
	$start_caltime = get_caltime($start_hour, $start_min);
	$end_caltime = get_caltime($end_hour, $end_min);
	$duration = get_calduration($start_caltime, $end_caltime);
	
	$j = getJob($_POST['job_id']);
	$j = Job::cast($j);
	
	for ($i=0; $i<count($days); $i++) {
		$day = $days[$i];
		$date = $day->getDateYMD();
		$timeslot = new Timeslot(null, $date, $start_caltime, $duration, $_POST['job_id'], $_POST['person_need-'.$i]);
		if (existTimeslot($timeslot)) {
			echo 'Fejl: Der findes allerede en registrering for det job, på den dag, på det tidspunkt!<br>
			      Redigér eksisterende registrering i stedet for at oprette en ny.';
			exit;
		} else {
			createTimeslot($timeslot);
		}
	}
	
	do_redirect($PHP_SELF.'?action=show_update&job_id='.$_POST['job_id']);
}

if ($_REQUEST['action'] == 'show_update') {
	show_update();
} elseif ($_REQUEST['action'] == 'do_create') {
	do_create();
} elseif ($_REQUEST['action'] == 'do_update') {
	do_update();
} else {
	echo 'Error: Page parameter missing!';
}

html_bottom();

?>