<?php
include_once 'includes/init.php';
include_once 'jc_init.php';
//use reject_public_access() in individual functions

function show_update_timeslots() {
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
		
		$rowNo = 0;
		//use builded $distinct_timeslots (2D-array)
		foreach ($distinct_timeslots as $distinctTSarr) {
			//build time-row from first TS in first distinctTSarr
			echo '<tr><td><input type="text" name="start_hour" size="1" maxlength="2" value="'.$distinctTSarr[0]->getStartHour().'" disabled/>:<input type="text" name="start_min" size="1" maxlength="2" value="'.$distinctTSarr[0]->getStartMin().'" disabled/>
				 - <input type="text" name="end_hour" size="1" maxlength="2" value="'.$distinctTSarr[0]->getEndHour().'" disabled/>:<input type="text" name="end_min" size="1" maxlength="2" value="'.$distinctTSarr[0]->getEndMin().'" disabled/></td>';
			$daysWithValues = null;
			foreach ($distinctTSarr as $ts) {
				$ts = Timeslot::cast($ts);
				//loop through days and echo personNeed if matching TS->date, copy into joint daysArray
				for ($i=0; $i<count($days); $i++) {
					$day = Day::cast($days[$i]);
					if ($ts->date == $day->getDateYMD()) {
						$daysWithValues[$i][0] = $ts->personNeed;
						$daysWithValues[$i][1] = $ts->id;
					} 
				}
			}
			for ($dayNo=0; $dayNo<count($days); $dayNo++) {
				echo '<td align="center"><input type="text" name="timeslot-'.$daysWithValues[$dayNo][1].'" value="'.$daysWithValues[$dayNo][0].'" size="2" maxlength="3" /></td>';
			}
			echo '</tr>';
			$rowNo++;
		}
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
		echo '<td align="center"><input type="text" name="person_need[]" size="2" maxlength="3" />	</td>';
	}	
	echo '</tr>
		<tr><td colspan="'.(count($days)+1).'"><input type="submit" value="Indsæt"/></td></tr>
		<input type="hidden" name="action" value="do_create">
		<input type="hidden" name="job_id" value="'.$job->id.'">
		</form>';
	
	echo '</table>';
	menu_link();
}

function do_update_timeslots() {
	reject_public_access();
	global $PHP_SELF;
	//$temps = list_templates($login);
	$timeslots = listTimeslots($_POST['job_id']); //$all_groups = list_resource_groups($login);
	foreach ($timeslots as $ts) {
		$person_need = $_POST['timeslot-'.$ts->id];
		updateTimeslotNeed($ts->id, $person_need);
	}
	do_redirect($PHP_SELF.'?action=show_update&job_id='.$_POST['job_id']);
}

function do_create_timeslot() {
	reject_public_access();
	global $PHP_SELF, $site_id, $login;
	//require_params();
	
	$start_hour = $_POST['start_hour'];
	$start_min = $_POST['start_min'];
	$end_hour = $_POST['end_hour'];
	$end_min = $_POST['end_min'];
	if (!valid_time($start_hour, $start_min) || !valid_time($end_hour, $end_min)) {
		echo "Fejl: Ugyldig tidsperiode!";
		exit;
	}
	
	$need_list = $_POST['person_need'];
	foreach ($need_list as $need) {
		if (!empty($need) && !is_numeric($need)) {
			echo "Fejl: Ugyldigt behov!";
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
			
			$exist = isDuplicateTimeslot($timeslot);
			if ($exist) {
				echo 'Fejl: Der findes allerede en registrering for det job, på den dag, på det tidspunkt!<br>
				      Redigér eksisterende registrering i stedet for at oprette en ny.';
				exit;
			} else {
				createTimeslot($timeslot);
			}
		}
	}
	
	do_redirect($PHP_SELF.'?action=show_update&job_id='.$_POST['job_id']);
}

function show_signup() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Tilmelding til job");
	
	$job = getJob($_GET['job_id']);
	$job = Job::cast($job);
	
	echo "<h1>Tilmelding til <i> $job->name</i></h1>";
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
		
		$rowNo = 0;
		//use builded $distinct_timeslots (2D-array)
		foreach ($distinct_timeslots as $distinctTSarr) {
			//build time-row from first TS in first distinctTSarr
			echo '<tr><td><input type="text" name="start_hour" size="1" maxlength="2" value="'.$distinctTSarr[0]->getStartHour().'" disabled/>:<input type="text" name="start_min" size="1" maxlength="2" value="'.$distinctTSarr[0]->getStartMin().'" disabled/>
				 - <input type="text" name="end_hour" size="1" maxlength="2" value="'.$distinctTSarr[0]->getEndHour().'" disabled/>:<input type="text" name="end_min" size="1" maxlength="2" value="'.$distinctTSarr[0]->getEndMin().'" disabled/></td>';
			$daysWithValues = null;
			foreach ($distinctTSarr as $ts) {
				$ts = Timeslot::cast($ts);
				//loop through days and echo personNeed if matching TS->date, copy into joint daysArray
				for ($i=0; $i<count($days); $i++) {
					$day = Day::cast($days[$i]);
					if ($ts->date == $day->getDateYMD()) {
						$daysWithValues[$i][0] = $ts->personNeed;
						$daysWithValues[$i][1] = $ts->id;
					} 
				}
			}
			for ($dayNo=0; $dayNo<count($days); $dayNo++) {
				echo '<td align="center">
					<input type="text" name="required-'.$daysWithValues[$dayNo][1].'" value="'.$daysWithValues[$dayNo][0].'" size="2" maxlength="3" disabled/>
					<input type="text" name="signup-'.$daysWithValues[$dayNo][1].'" value="" size="2" maxlength="3"/>
					</td>';
			}
			echo '</tr>';
			$rowNo++;
		}
	}
	echo '<tr><td colspan="'.(count($days)+1).'"><input type="submit" value="Opdatér"/></td></tr>
		<input type="hidden" name="action" value="do_update">
		<input type="hidden" name="job_id" value="'.$job->id.'">
		</form>';
	echo '</table>';
	menu_link();
}

if ($_REQUEST['action'] == 'show_update') {
	show_update_timeslots();
} elseif ($_REQUEST['action'] == 'show_signup') {
	show_signup();
} elseif ($_REQUEST['action'] == 'do_create') {
	do_create_timeslot();
} elseif ($_REQUEST['action'] == 'do_update') {
	do_update_timeslots();
} else {
	echo 'Error: Paramers missing!';
}

html_bottom();

?>