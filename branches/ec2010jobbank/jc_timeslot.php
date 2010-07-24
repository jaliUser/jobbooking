<?php
include_once 'includes/init.php';
include_once 'jc_init.php';
reject_public_access();

function show_update() {
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Rediger behov");

	$minutesBeforeUpdateFreeze = 120;
	
	$job = getJob($_GET['job_id']);
	$job = Job::cast($job);
	
	echo "<h1>Redig�r behov for <i> $job->name</i></h1>
		  <p class='help'>Tidsperioder b�r ikke vare mere end 4 timer!</p>";
	//generate rows for existing timeslots
	echo '<table align="center" class="border1">
		<form action="'.$PHP_SELF.'" method="POST">
		<tr><th width="250">Tid</th>';
	$days = listDays($site_id);
	
	//generate header with days
	foreach ($days as $day) {
		$day = Day::cast($day);
		echo '<th valign="top">'.strftime("%a %d/%m", $day->getDateTS());
		if (!empty($day->time) && $day->date == $days[0]->date) {
			echo '<br>Tidligst '.$day->getTimeHM();
		}
		if (!empty($day->time) && $day->date == $days[count($days)-1]->date) {
			echo '<br>Senest '.$day->getTimeHM();
		}
		echo '</th>';
	}
		
	$timeslots = listTimeslots($job->id);
	$groupedTimeslots = groupTimeslotsByTime($timeslots);

//	// fix missing day
//	if (count($timeslots) > 0 && count($groupedTimeslots[0]) != count($days)) {
//		foreach ($groupedTimeslots as $distinctTimeArr) {
//			$newTimeslot = Timeslot::cast($distinctTimeArr[0]);
//			$newTimeslot->date = 20100801;
//			$newTimeslot->personNeed = null;
//			createTimeslot($newTimeslot);
//		}
//		$timeslots = listTimeslots($job->id);
//		$groupedTimeslots = groupTimeslotsByTime($timeslots);
//	}
	
	$disTScnt = 0;
	foreach ($groupedTimeslots as $distinctTimeArr) {		
		//build time-row from first TS in distinctTimeArr
		$disTScnt++;
		$TSids = "";
		for ($dayNo=0; $dayNo<count($days); $dayNo++) {
			$timeslot = Timeslot::cast($distinctTimeArr[$dayNo]);
			$TSids .= $timeslot->id . "-";
		}
		
		$firstTS = $distinctTimeArr[0];
		echo '<tr><td><input type="text" name="start_hour-'.$disTScnt.'" size="1" maxlength="2" value="'.$firstTS->getStartHour().'" />:<input type="text" name="start_min-'.$disTScnt.'" size="1" maxlength="2" value="'.$firstTS->getStartMin().'" />
			        - <input type="text" name="end_hour-'.$disTScnt.'" size="1" maxlength="2" value="'.$firstTS->getEndHour().'"     />:<input type="text" name="end_min-'.$disTScnt.'" size="1" maxlength="2" value="'.$firstTS->getEndMin().'" />
				'.($firstTS->duration > 4*60 ? '<span class="redalert">OBS: > 4 t.</span>':'').'</td>
			<input type="hidden" name="TSids-'.$disTScnt.'" value="'.$TSids.'">';

		for ($dayNo=0; $dayNo<count($days); $dayNo++) {
			$timeslot = Timeslot::cast($distinctTimeArr[$dayNo]);
			echo '<td align="center">';
			if (time()+$minutesBeforeUpdateFreeze*60 > $timeslot->getStartTS() && !user_is_admin()) {
				echo '<input type="text" value="'.$timeslot->personNeed.'" size="1" disabled class="disabled"/>
					  <input type="hidden" name="timeslot-'.$timeslot->id.'" value="'.$timeslot->personNeed.'"/>';
			} else {
				echo '<input type="text" name="timeslot-'.$timeslot->id.'" value="'.$timeslot->personNeed.'" size="1" maxlength="3"/>';
			}
			echo '</td>';
		}
		echo '</tr>';
	}
	echo '<tr>
		<td>
			<input type="submit" name="send" value="Opdat�r tidspunkter"/>
			<span class="help">
				<br/><br/><b>Vigtigt: Brug denne funktion med omtanke!</b>
				<br/>N�r du �ndrer en tidsperiode, vil systemet kontrollere for alle hj�lpere tilmeldt jobbet, 
				om de stadig kan v�re tilmeldt med den nye tidsperiode, og de f�r alle tilsendt en email om �ndringen. 
				De som er forhindret i den nye tidsperiode vil blive afmeldt jobbet!
			</span><br><br>
		</td>
		<td colspan="'.(count($days)).'">
			<input type="submit" name="send" value="Opdat�r antal"/>
			<span class="help">
				<br/><br/>Hvis du nedjusterer et behov og der er flere hj�lpere tilmeldt end der nu er behov for, 
				<br/>vil Jobcenteret f� en email herom, s� de overskydende hj�lpere kan flyttes til et andet job.
			</span><br><br>
		</td></tr>
		<input type="hidden" name="action" value="do_update">
		<input type="hidden" name="job_id" value="'.$job->id.'">
		<input type="hidden" name="disTScnt" value="'.$disTScnt.'">
		</form>';
	
	//show form for creating new timeslot
	echo '<tr><th colspan="'.(count($days)+1).'">Opret ny tidsperiode: Angiv starttid & sluttid, samt behov p� de enkelte dage.</th></tr>';
	echo '<form action="'.$PHP_SELF.'" method="POST">
		<tr><td><input type="text" name="start_hour" size="1" maxlength="2" value="00" />:<input type="text" name="start_min" size="1" maxlength="2" value="00" />
		 - <input type="text" name="end_hour" size="1" maxlength="2" value="00" />:<input type="text" name="end_min" size="1" maxlength="2" value="00" /></td>';
	for ($i=0; $i<count($days); $i++) {
		echo '<td align="center"><input type="text" name="person_need-'.$i.'" size="1" maxlength="3" />	</td>';
	}	
	echo '</tr>
		<tr><td colspan="'.(count($days)+1).'"><input type="submit" value="Inds�t"/></td></tr>
		<input type="hidden" name="action" value="do_create">
		<input type="hidden" name="job_id" value="'.$job->id.'">
		</form>';
	
	echo '</table>';
	menu_link();
}

function do_update() {
	global $PHP_SELF, $site_id;
	
	if (strpos($_POST['send'], "tidspunkter") && is_numeric($_POST['disTScnt'])) {
		// update start/end times
		$days = listDays($site_id);
		$disTScnt = $_POST['disTScnt'];
		// loop distinct timeslots (rows)
		for ($n=1; $n <= $disTScnt; $n++) {
			$start_hour = $_POST['start_hour-'.$n];
			$start_min = $_POST['start_min-'.$n];
			$end_hour = $_POST['end_hour-'.$n];
			$end_min = $_POST['end_min-'.$n];
			
			$start_caltime = get_caltime($start_hour, $start_min);
			$end_caltime = get_caltime($end_hour, $end_min);
			$duration = get_calduration($start_caltime, $end_caltime);
			
			if ($duration > 4*60) {
				//show warning
			}
			
			$TSids = explode("-", trim($_POST['TSids-'.$n], "-"));
			$firstTS = getTimeslot($TSids[0]); //get TS from DB to check against
			
			if ($firstTS->startTime == $start_caltime && $firstTS->duration == $duration) {
				continue; //no times changed in distinct timeslot
			}
			
			if (!valid_time($start_hour, $start_min) || !valid_time($end_hour, $end_min) || 
				($start_hour == 00 && $start_min == 00 && $start_min == 00 && $start_min== 00 )) {
				echo print_error("Ugyldig tidsperiode!");
				exit;
			}
			
			$j = getJob($_POST['job_id']);
			$j = Job::cast($j);
			
			// loop days and check for errors
			for ($i=0; $i<count($days); $i++) {
				$ts = getTimeslot($TSids[$i]); // assume 1-1 order in days and TSids
				$oldTS = clone $ts;
				$ts->startTime = $start_caltime; // set new time and date
				$ts->duration = $duration; // set new duration

				$day = $days[$i];
				$date = $day->getDateYMD();

				if ($i == 0 && $ts->personNeed > 0 && $start_caltime < $day->time) {
					echo print_error('Starttidspunktet for '.$day->date.' ligger f�r det tidligst mulige.');
					exit;
				}
				if ($i == count($days)-1 && $ts->personNeed > 0 && $end_caltime > $day->time) {
					echo print_error('Sluttidspunktet for '.$day->date.' ligger efter det senest mulige.');
					exit;
				}
				if (existTimeslot($ts)) {
					echo print_error('Der findes allerede en registrering for det job, p� den dag, p� det tidspunkt!<br>
					      Redig�r eksisterende registrering i stedet for at oprette en ny.');
					exit;
				}
				
				updateTimeslotTime($ts, $oldTS);
			}
		}
	} else {
		// update timeslot needs
		$days = listDays($site_id);
		$firstDay = Day::cast($days[0]);
		$lastDay = Day::cast($days[count($days)-1]);
		$job = getJob($_POST['job_id']);
		$timeslots = listTimeslots($_POST['job_id']);
		// no validation, just remove person_need if non-numeric or negative
		foreach ($timeslots as $ts) {
			$ts = Timeslot::cast($ts);
			if (!Timeslot::isValidPersonNeed($_POST['timeslot-'.$ts->id])) {
				echo print_error('Behovet for '.$day->date.' er ikke et gyldigt tal!');
				exit;	
			}
			if ($ts->date == $firstDay->getDateYMD() && $_POST['timeslot-'.$ts->id] > 0 && $ts->startTime < $firstDay->time) {
				echo print_error('Starttidspunktet for '.$ts->date.' '.$ts->getStartHour().':'.$ts->getStartMin().' ligger f�r det tidligst mulige.');
				exit;
			}
			if ($ts->date == $lastDay->getDateYMD() && $_POST['timeslot-'.$ts->id] > 0 && $ts->getEndTime() > $lastDay->time) {
				echo print_error('Sluttidspunktet for '.$ts->date.' '.$ts->getEndHour().':'.$ts->getEndMin().' ligger efter det senest mulige.');
				exit;
			}
			
			if ($ts->personNeed != $_POST['timeslot-'.$ts->id]) {
				updateTimeslotNeed($ts, $job, $_POST['timeslot-'.$ts->id]);
			}
		}
	}
	
	do_redirect($PHP_SELF.'?action=show_update&job_id='.$_POST['job_id']);
}

function show_assign() {
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Tilknyt jobkonsulenter");

	$job = getJob($_GET['job_id']);
	$job = Job::cast($job);
	
	echo "<h1>Tilknyt jobkonsulenter for <i> $job->name</i></h1>";
	//generate rows for existing timeslots
	echo '<table align="center" class="border1">
		<form action="'.$PHP_SELF.'" method="POST">
		<tr><th>Tid</th>';
	$days = listDays($site_id);
	
	//generate header with days
	foreach ($days as $day) {
		$day = Day::cast($day);
		echo '<th>'.strftime("%a %d/%m", $day->getDateTS()).'</th>';
	}
	echo '</tr><tr><td></td>';
	
	foreach ($days as $day) {
		echo '<td><table class="border0" width="100%"><tr><td align="center">'.vertical("Behov").'</td><td align="center">'.vertical("Rest").'</td></tr></table></td>';
	}
	echo '</tr>';
	
	$timeslots = listTimeslots($job->id);
	$groupedTimeslots = groupTimeslotsByTime($timeslots);
	$contacts = listUsers($site_id, 4);
	
	foreach ($groupedTimeslots as $distinctTimeArr) {
		//build time-row from first TS in distinctTimeArr
		$firstTS = $distinctTimeArr[0];
		echo '<tr><td>'.$firstTS->getStartHour().':'.$firstTS->getStartMin().' - '.$firstTS->getEndHour().':'.$firstTS->getEndMin().'</td>';

		for ($dayNo=0; $dayNo<count($days); $dayNo++) {
			$timeslot = Timeslot::cast($distinctTimeArr[$dayNo]);
			$signup = $signups[$timeslot->id];
			
			$contactsHTML = '<option></option>';
			foreach ($contacts as $contact) {
				$contact = User::cast($contact);
				$selected = ($contact->login == $timeslot->contactID) ? ' selected' : '';
				$subcamp = getSubcampForContact($contact->login);
				$subcampShort = ($subcamp != null ? $subcamp->getShortName() : null);
				$contactsHTML .= '<option value="'.$contact->login.'"'.$selected.'>'.$contact->firstname.' '.$subcampShort.'</option>';			
			}
			
			echo '<td align="center">
				<input type="text" value="'.$timeslot->personNeed.'" size="1" maxlength="3" disabled/>
				<input type="text" value="'.$timeslot->remainingNeed.'" size="1" maxlength="3" disabled/>
				<select name="contactID-'.$timeslot->id.'" '.($timeslot->personNeed > 0 ? '':' disabled').'>'.$contactsHTML.'</select>
				</td>';
		}
		echo '</tr>';
	}
	echo '<tr><td colspan="'.(count($days)+1).'"><input type="submit" value="Opdat�r"/></td></tr>
		<input type="hidden" name="action" value="do_assign">
		<input type="hidden" name="job_id" value="'.$job->id.'">
		</form>';
		
	echo '</table>';
	menu_link();
}

function do_assign() {
	global $PHP_SELF;
	$timeslots = listTimeslots($_POST['job_id']);
	foreach ($timeslots as $ts) {
		updateContact($ts->id, $_POST['contactID-'.$ts->id]);
	}
	do_redirect($PHP_SELF.'?action=show_assign&job_id='.$_POST['job_id']);
}

function do_create() {
	global $PHP_SELF, $site_id, $login;
	
	$start_hour = $_POST['start_hour'];
	$start_min = $_POST['start_min'];
	$end_hour = $_POST['end_hour'];
	$end_min = $_POST['end_min'];
	if (!valid_time($start_hour, $start_min) || !valid_time($end_hour, $end_min) || 
		($start_hour == 00 && $start_min == 00 && $end_hour == 00 && $end_min == 00 )) {
		echo print_error("Ugyldig tidsperiode!");
		exit;
	}
		
	$start_caltime = get_caltime($start_hour, $start_min);
	$end_caltime = get_caltime($end_hour, $end_min);
	$duration = get_calduration($start_caltime, $end_caltime);
	
	if ($duration > 4*60) {
		//show warning
	}
	
	$days = listDays($site_id);
	$j = getJob($_POST['job_id']);
	$j = Job::cast($j);
	
	// loop days and check for errors
	$anyneed = false;
	for ($i=0; $i<count($days); $i++) {
		$day = $days[$i];
		$date = $day->getDateYMD();
		$timeslot = new Timeslot(null, $date, $start_caltime, $duration, $_POST['job_id'], $_POST['person_need-'.$i], null);
		if (!Timeslot::isValidPersonNeed($_POST['person_need-'.$i])) {
			echo print_error('Behovet for '.$day->date.' er ikke et gyldigt tal!');
			exit;	
		}
		if ($i == 0 && $_POST['person_need-'.$i] > 0 && $start_caltime < $day->time) {
			echo print_error('Starttidspunktet for '.$day->date.' ligger f�r det tidligst mulige.');
			exit;
		}
		if ($i == count($days)-1 && $_POST['person_need-'.$i] > 0 && $end_caltime > $day->time) {
			echo print_error('Sluttidspunktet for '.$day->date.' ligger efter det senest mulige.');
			exit;
		}
		if (existTimeslot($timeslot)) {
			echo print_error('Der findes allerede en registrering for det job, p� den dag, p� det tidspunkt!<br>
			      Redig�r eksisterende registrering i stedet for at oprette en ny.');
			exit;
		}
		if (is_numeric($_POST['person_need-'.$i])) {
			$anyneed = true;
		}
	}
	
	if ($anyneed == false) {
		echo print_error('Der er ikke angivet noget behov!');
		exit;
	}
	
	// loop days and create timeslots
	for ($i=0; $i<count($days); $i++) {
		$day = $days[$i];
		$date = $day->getDateYMD();
		$timeslot = new Timeslot(null, $date, $start_caltime, $duration, $_POST['job_id'], $_POST['person_need-'.$i], null);
		
		createTimeslot($timeslot);
	}
	
	do_redirect($PHP_SELF.'?action=show_update&job_id='.$_POST['job_id']);
}

function show_mine() {
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Mine tidsperioder");
	
	$contact = getUser($_GET['user_id']);
	if ($contact->login == null) {
		echo print_error("Brugernavn <i>".$_GET['user_id']."</i> eksisterer ikke!");
		exit();
	}
	$timeslots = listTimeslotsForContact($contact->login);
	
	echo "<h1>Tidsperioder tildelt <i>".$contact->getFullName()."</i></h1>";
	echo '<table align="center" class="border1">
			<th>Dato</th> <th>Tid</th> <th>Job</th> <th>Behov</th> <th>Rest</th> <th>Handlinger</th> ';
	
	foreach ($timeslots as $timeslot) {
		$timeslot = Timeslot::cast($timeslot);
		$job = getJob($timeslot->jobID);
		echo '<tr>
				<td>'.date("d/m", $timeslot->getStartTS()).'</td>
				<td>'.date("H:i", $timeslot->getStartTS()).date(" - H:i", $timeslot->getEndTS()).'</td>
				<td><a href="jc_job.php?action=show_one&job_id='.$job->id.'">'.$job->name.'</a></td>
				<td>'.$timeslot->personNeed.'</td>
				<td '.($timeslot->remainingNeed > 0 ? 'class="redalert"':'').'>'.$timeslot->remainingNeed.'</td>
				<td>
					<a href="jc_signup.php?action=show_list&job_id='.$job->id.'">Vis tildelinger</a><br/>
					<a href="jc_signup.php?action=show_update&job_id='.$job->id.'">Tilmeld hj�lpere</a><br/>
					<a href="jc_timeslot.php?action=show_assign&job_id='.$job->id.'">Videregiv tildeling<br/>
				</td>';
		echo '</tr>';
	}
	echo '</table>';
	
	// show user list for admins
	if (user_is_admin() || user_is_consultant()) {
		show_user_table("V�lg bruger at se tildelte tidsperioder for", "$PHP_SELF?action=show_mine", listUsers($site_id, 4));
	}
	
	menu_link();
}

function show_unassigned() {
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Ikke-tildelte tidsperioder");
	
	$minutesInPast = 30;
	$timeslots = listTimeslotsUnassigned($site_id);
	
	echo "<h1>Ikke-tildelte tidsperioder</h1>";
	echo '<table align="center" class="border1">
			<th>Dato</th> <th>Tid</th> <th>Job</th> <th>Behov</th> <th>Rest</th> <th></th>';
	
	foreach ($timeslots as $timeslot) {
		if ($timeslot->remainingNeed == 0 || $timeslot->getStartTS() < time()-60*$minutesInPast) {
			continue;
		}
		
		$timeslot = Timeslot::cast($timeslot);
		$job = getJob($timeslot->jobID);
		echo '<tr>
				<td>'.date("d/m", $timeslot->getStartTS()).'</td>
				<td>'.date("H:i", $timeslot->getStartTS()).date(" - H:i", $timeslot->getEndTS()).'</td>
				<td><a href="jc_job.php?action=show_one&job_id='.$timeslot->jobID.'">'.$job->name.'</a></td>
				<td>'.$timeslot->personNeed.'</td>
				<td '.($timeslot->remainingNeed > 0 ? 'class="redalert"':'').'>'.$timeslot->remainingNeed.'</td>
				<td><a href="jc_timeslot.php?action=show_assign&job_id='.$timeslot->jobID.'">Tildel</a></td>';
		echo '</tr>';
	}		
	echo '</table>';
		
	menu_link();
}

function show_list() {
	global $PHP_SELF, $login, $site_id, $site_name;
		
	if (!empty($_GET['filter'])) {
		html_top($site_name . " - Ledige tidsperioder");
		echo "<h1>Ledige tidsperioder</h1>";
	} else {
		html_top($site_name . " - Alle tidsperioder");
		echo "<h1>Alle tidsperioder</h1>";
	}
	
	echo '<table align="center" class="border1">
			<th>Dato</th> <th>Tid</th> <th>Job</th> <th>Behov</th> <th>Rest</th> <th></th>';
	
	$timeslots = listTimeslotsSite($site_id);
	foreach ($timeslots as $timeslot) {
		if (!empty($_GET['filter']) && ($timeslot->remainingNeed == 0 || $timeslot->getStartTS() < time()-30*60)) {
			continue;
		}
		
		$timeslot = Timeslot::cast($timeslot);
		$job = getJob($timeslot->jobID);
		echo '<tr>
				<td>'.date("d/m", $timeslot->getStartTS()).'</td>
				<td>'.date("H:i", $timeslot->getStartTS()).date(" - H:i", $timeslot->getEndTS()).'</td>
				<td><a href="jc_job.php?action=show_one&job_id='.$timeslot->jobID.'">'.$job->name.'</a></td>
				<td>'.$timeslot->personNeed.'</td>
				<td '.($timeslot->remainingNeed > 0 ? 'class="redalert"':'').'>'.$timeslot->remainingNeed.'</td>
				<td>
					<a href="jc_signup.php?action=show_update&job_id='.$timeslot->jobID.'">Tilmeld</a><br/>
					'.(user_is_admin() ? '<a href="jc_signup.php?action=show_list&job_id='.$timeslot->jobID.'">Vis tilmeldinger</a><br/>' : '').'
					</td>';
		echo '</tr>';
	}		
	echo '</table>';
		
	menu_link();
}

if ($_REQUEST['action'] == 'show_update') {
	show_update();
} elseif ($_REQUEST['action'] == 'do_create') {
	do_create();
} elseif ($_REQUEST['action'] == 'show_assign') {
	show_assign();
} elseif ($_REQUEST['action'] == 'do_assign') {
	do_assign();
} elseif ($_REQUEST['action'] == 'do_update') {
	do_update();
} elseif ($_REQUEST['action'] == 'show_mine') {
	show_mine();
} elseif ($_REQUEST['action'] == 'show_unassigned') {
	show_unassigned();
} elseif ($_REQUEST['action'] == 'show_list') {
	show_list();
} else {
	echo 'Error: Page parameter missing!';
}

html_bottom();

?>