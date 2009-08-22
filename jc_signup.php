<?php
include_once 'includes/init.php';
include_once 'jc_init.php';
//use reject_public_access() in individual functions

function show_update() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Tilmelding til job");
	
	$job = getJob($_GET['job_id']);
	$job = Job::cast($job);
	
	if (!empty($_GET['user_id'])) {
		$user = User::cast(getUser($_GET['user_id']));
	} else {
		$user = User::cast(getUser($login));
	}
	
	echo "<h1>Tilmelding til <i><a href=\"jc_job.php?action=show_one&job_id=$job->id\">$job->name</a></i> for <i><a href=\"jc_user.php?action=show_one&login=$user->login\">".$user->getFullName()."</a></i> (".$user->count." pers.)</h1>".
		'<p class="help">I kolonnerne <i>Behov</i> kan du se det aktuelle behov for personer til de forskellige tidsperioder. Hvis du eller dit hold ønsker at hjælpe med dette job, udfyld det antal personer du/I kan stille med, for en given tidsperiode. Efter du har klikket på <i>Opdatér</i>, vil du se behovet blive reduceret med det antal personer du har tilmeldt.</p>';
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
	echo '</tr><tr><td>';
	
	foreach ($days as $day) {
		echo '<td><table class="border0" width="100%"><tr><td align="center">'.vertical("Behov").'</td><td align="center">'.vertical("Tilmeld").'</td></tr></table></td>';
	}
	echo '</tr>';
	
	$signups = listJobUserSignups($job->id, $user->login);
	$timeslots = listTimeslots($job->id);
	$groupedTimeslots = groupTimeslotsByTime($timeslots);
	
	foreach ($groupedTimeslots as $distinctTimeArr) {
		//build time-row from first TS in distinctTimeArr			
		$firstTS = $distinctTimeArr[0];
		echo '<tr><td>'.$firstTS->getStartHour().':'.$firstTS->getStartMin().' - '.$firstTS->getEndHour().':'.$firstTS->getEndMin().'</td>';

		for ($dayNo=0; $dayNo<count($days); $dayNo++) {
			$timeslot = Timeslot::cast($distinctTimeArr[$dayNo]);
			$signup = $signups[$timeslot->id];
			echo '<td align="center">
				<input type="text" name="required-'.$timeslot->id.'" value="'.$timeslot->remainingNeed.'" size="1" maxlength="3" disabled/>
				<input type="text" name="signup-'.$timeslot->id.'" value="'.$signup->count.'" size="1" maxlength="3"/>
				<input type="hidden" name="notes-'.$timeslot->id.'" value="'.$signup->notes.'"/>
				</td>';
		}
		echo '</tr>';
	}
	echo '<tr><td colspan="'.(count($days)+1).'"><input type="submit" value="Opdatér"/></td></tr>
		<input type="hidden" name="action" value="do_update">
		<input type="hidden" name="job_id" value="'.$job->id.'">
		<input type="hidden" name="user_id" value="'.$user->login.'">
		</form>';
	echo '</table>';
	
	// show user list for admins
	if (user_is_admin()) {
			$users = listUsers($site_id);
		echo '<h3>Vælg bruger der skal tilmeldes for:</h3>
			<table align="center" class="border1">
			<tr> <th>Brugernavn</th> <th>Fornavn</th> <th>Efternavn</th> <th>E-mail</th> <th>Telefon</th> <th>Adresse</th> <th>Alder</th> <th>Gruppe</th> <th>Rolle</th> <th>(Underlejr)</th> </tr>';
		foreach ($users as $user) {
			$user = User::cast($user);
			$role = Role::cast(getRole($user->login));
			$group = getGroup($user->groupID);
			$subcamp = getSubcampForUser($user->login); 
	
			echo "<tr> 
				<td><a href=\"$PHP_SELF?action=show_update&user_id=$user->login&job_id=$job->id\">$user->login</a></td>
				<td>$user->firstname</td>
				<td>$user->lastname</td>
				<td>$user->email</td>
				<td>$user->telephone</td>
				<td width='50'>$user->address</td>
				<td>$user->birthday</td>
				<td>$group->name</td>
				<td>$role->name</td>
				<td>$subcamp->name</td>
				</tr>";
		}
		echo '</table>';		 
	}
	
	menu_link();
}

function do_update() {
	reject_public_access();
	global $PHP_SELF;
	require_params($_POST['job_id'], $_POST['user_id']);
	$timeslots = listTimeslots($_POST['job_id']);
	foreach ($timeslots as $ts) {
		$ts = Timeslot::cast($ts);
		if (!Signup::isValidCount($_POST['signup-'.$ts->id])) {
			echo "Fejl: Ugyldigt antal!";
			exit;
		}
		
		$signup = new Signup($ts->id, $_POST['user_id'], 'A', null, 0, $_POST['signup-'.$ts->id], $_POST['notes-'.$ts->id]);
		//TODO: check available count
		if ($signup->count > 0 && !isUserFree($signup->userID, $ts)) {
			echo "Fejl: Brugeren er optaget i tidsperioden ". $ts->date." ".$ts->getStartHour().":".$ts->getStartMin()."-".$ts->getEndHour().":".$ts->getEndMin()."<br>";
			exit; 
		} else {
			createUpdateDeleteSignup($signup);
		}
	}
	
	do_redirect($PHP_SELF.'?action=show_update&job_id='.$_POST['job_id'].'&user_id='.$_POST['user_id']);
}

function show_list() {
	//reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	require_params(array($_GET['job_id'], $site_id));
	html_top($site_name . " - Tilmeldinger til job");
	
	$job = getJob($_GET['job_id']);
	$job = Job::cast($job);
		
	echo "<h1>Tilmeldinger til <i> $job->name</i></h1>";
	//generate rows for existing timeslots
	echo '<table name="outer" width="800" align="center" border="0">';

	$days = listDays($site_id);
	//$signups = listJobSignups($job->id);
	$timeslots = listTimeslotsByDate($job->id);
	$groupedTimeslots = groupTimeslotsByDate($timeslots);
	foreach ($days as $key => $day) {
		$day = Day::cast($day);
		$distinctDateArr = $groupedTimeslots[$key];
		
		echo '<tr><td><table align="center" class="border1" width="100%">
			<tr><th width="15%">'.strftime("%a %d/%m", $day->getDateTS()).'</th>
				<th width="5%">Behov</th>
				<th width="5%">Rest</th>
				<th width="15%">Jobkonsulent</th>
				<th width="30%">Klannavn</th>
				<th width="10%">Tilmeldt</th>
			</tr>';
		
		foreach ($distinctDateArr as $timeslot) {
			$timeslot = Timeslot::cast($timeslot);
			if ($timeslot->personNeed != "" && (empty($_GET['filter']) || $timeslot->remainingNeed > 0)) {
				$contact = User::cast(getUser($timeslot->contactID));
				echo '<tr class="subth">
					<td>'.strftime("%H:%M", $timeslot->getStartTS()).strftime("-%H:%M", $timeslot->getEndTS()).'</td>
					<td>'.$timeslot->personNeed.'</td>
					<td '.($timeslot->remainingNeed > 0 ? 'class="redalert"':'').'>'.$timeslot->remainingNeed.'</td>
					<td>'.$contact->firstname.'</td>
					<td colspan="2"></td>
			  	  </tr>';

				$signups = listTimeslotSignups($timeslot->id);
				foreach ($signups as $signup) {
					$signup = Signup::cast($signup);
					$user = getUser($signup->userID);
					echo "<tr><td colspan=\"4\"><a href=\"jc_user.php?action=show_one&login=$user->login\">".$user->getFullName()."</a></td>
							<td>$user->title</td>
							<td>$signup->count</td>
						</tr>";
				}
			}
		}
		echo '</table></td></tr><tr><td>&nbsp;</td></tr>';	
	}
	echo '</table>';
	menu_link();
}

function show_evals() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Evaluering af job");
	
	$job = Job::cast(getJob($_GET['job_id']));
	$user = User::cast(getUser($login));

	$days = listDays($site_id);
	$signups = listJobSignups($job->id);	
	$timeslots = listTimeslotsByDate($job->id);
	$groupedTimeslots = groupTimeslotsByDate($timeslots);
	
	echo "<h1>Evaluering af <i> $job->name</i></h1>";
	echo '<table align="center" class="border1" >
			<form action="'.$PHP_SELF.'" method="POST">';
	
	foreach ($days as $key => $day) {
		$day = Day::cast($day);
		echo '<tr><th>'.strftime("%a %d/%m", $day->getDateTS()).'</th><th>Kommentar</th><th>Tilmeldt</th><th>Fremmødt</th></tr>';
	
		$distinctDateTimeslotArr = $groupedTimeslots[$key];
		foreach ($distinctDateTimeslotArr as $timeslot) {
			$timeslot = Timeslot::cast($timeslot);
			echo '<tr class="subth"><td colspan="4">'.$timeslot->getStartHour().':'.$timeslot->getStartMin().' - '.$timeslot->getEndHour().':'.$timeslot->getEndMin().'</td></tr>';
			
			//TODO: use dictionery
			foreach ($signups as $signup) {
				$signup = Signup::cast($signup);
				if ($signup->timeslotID == $timeslot->id) {
					$user = getUser($signup->userID);
					echo '<tr>'."<td><a href=\"jc_user.php?action=show_one&login=$user->login\">".$user->getFullName()."</a></td>".'
							  <td><input type="text" name="notes-'.$signup->timeslotID.'~'.$signup->userID.'" value="" size="100" maxlength="255" /></td>
							  <td align="center">'.$signup->count.'</td>
							  <td align="center"><input type="text" name="percent-'.$signup->timeslotID.'~'.$signup->userID.'" size="1" maxlength="3"/></td></tr>';
				}
			}
		}
	}
	
	echo '<tr><td colspan="4"><input type="submit" value="Opdatér"/></td></tr>
		<input type="hidden" name="action" value="do_evals">
		<input type="hidden" name="job_id" value="'.$job->id.'">
		</form>';
	echo '</table>';
	
	menu_link();
}

function show_mine() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - ". (empty($_GET['show_block'])? "Jobtilmeldinger" : "Blokeringer"));
	
	if (!empty($_GET['user_id'])) {
		$user = User::cast(getUser($_GET['user_id']));
	} else {
		$user = User::cast(getUser($login));
	}

	$days = listDays($site_id);
	$signups = empty($_GET['show_block'])? listUserSignups($user->login) : listUserSignups($user->login, true);	
	
	echo "<h1>".(empty($_GET['show_block'])? "Jobtilmeldinger" : "Blokeringer")." for <i><a href=\"jc_user.php?action=show_one&login=$user->login\">".$user->getFullName()."</a></i></h1>";
	echo '<table align="center" class="border1">
			<tr><th>Dato</th><th>Tid</th><th>Personer</th>'.(empty($_GET['show_block'])? "<th>Job</th>" : "").'</tr>';
	
	foreach ($signups as $signup) {
		$signup = Signup::cast($signup);
		$timeslot = getTimeslot($signup->timeslotID);
		$job = getJob($timeslot->jobID);
		
		echo '<tr><td>'.strftime("%a %d/%m", $timeslot->getStartTS()).'</td>
				  <td>'.strftime("%H:%M", $timeslot->getStartTS()).strftime("-%H:%M", $timeslot->getEndTS()).'</td>
				  <td>'.$signup->count.'</td>
				  '.(empty($_GET['show_block'])? '<td><a href="jc_job.php?action=show_one&job_id='.$job->id.'">'.$job->name.'</a></td>' : "").'
				  </tr>';
	
	}
	echo '</table>';
	
	menu_link();
}

if ($_REQUEST['action'] == 'show_update') {
	show_update();
} elseif ($_REQUEST['action'] == 'do_update') {
	do_update();
} elseif ($_REQUEST['action'] == 'show_list') {
	show_list();
} elseif ($_REQUEST['action'] == 'show_evals') {
	show_evals();
} elseif ($_REQUEST['action'] == 'show_mine') {
	show_mine();
} else {
	echo 'Error: Page parameter missing!';
}

html_bottom();

?>