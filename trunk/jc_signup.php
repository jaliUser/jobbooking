<?php
include_once 'includes/init.php';
include_once 'jc_init.php';
//use reject_public_access() in individual functions

function show_update() {
	//reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Tilmelding til job");
	
	$job = getJob($_GET['job_id']);
	$job = Job::cast($job);
	
	if (!empty($_GET['user_id'])) {
		$user = User::cast(getUser($_GET['user_id']));
	} else {
		$user = User::cast(getUser($login));
	}
	
	echo "<h1>Tilmelding til <i> $job->name</i> for <i>".$user->getFullName()."</i></h1>";
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
	
	$signups = listJobUserSignups($job->id, $user->login);	
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
				<input type="text" name="required-'.$timeslot->id.'" value="'.$timeslot->remainingNeed.'" size="2" maxlength="3" disabled/>
				<input type="text" name="signup-'.$timeslot->id.'" value="'.$signup->count.'" size="2" maxlength="3"/>
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
	
	if (user_is_admin()) {
			$users = listUsers($site_id);
		echo '<h3 align="center">Vælg bruger der skal tilmeldes for:</h3>
			<table align="center" border="1">
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
	//reject_public_access();
	global $PHP_SELF;
	require_params($_POST['job_id'], $_POST['user_id']);
	$timeslots = listTimeslots($_POST['job_id']);
	foreach ($timeslots as $ts) {
		$ts = Timeslot::cast($ts);
		if (!Signup::isValidCount($_POST['signup-'.$ts->id])) {
			echo "Fejl: Ugyldigt antal!";
			exit;
		}
		$signup = new Signup($ts->id, $_POST['user_id'], 'A', null, 0, $_POST['signup-'.$ts->id]);
		createOrUpdateSignup($signup);
	}
	
	do_redirect($PHP_SELF.'?action=show_update&job_id='.$_POST['job_id'].'&user_id='.$_POST['user_id']);
}

function show_list() {
	//reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	require_params(array($_GET['job_id']));
	html_top($site_name . " - Tilmeldinger til job");
	
	$job = getJob($_GET['job_id']);
	$job = Job::cast($job);
		
	echo "<h1>Tilmeldinger til <i> $job->name</i></h1>";
	//generate rows for existing timeslots
	echo '<table name="outer" width="400" align="center" border="0" cellspacing="3" cellpadding="3">';

	$days = listDays($site_id);
	$signups = listJobSignups($job->id);	
	$timeslots = listTimeslots($job->id);
	$groupedTimeslots = groupTimeslotsByTime($timeslots);

	foreach ($groupedTimeslots as $distinctTimeArr) {
		$firstTS = $distinctTimeArr[0];
		//build time-row from first TS in distinctTimeArr
		echo '<tr><td><table name="timeperiod_and_days" border="1" width="100%">
				<tr><td align="center" style="font-weight:bold">Tidsperiode: '.$firstTS->getStartHour().':'.$firstTS->getStartMin().' - '.$firstTS->getEndHour().':'.$firstTS->getEndMin().'</td></tr>';
		
		for ($dayNo=0; $dayNo<count($days); $dayNo++) {
			$timeslot = Timeslot::cast($distinctTimeArr[$dayNo]);
			$signup = $signups[$timeslot->id];
			
			if (!empty($timeslot->personNeed)) {
				$day = Day::cast($days[$dayNo]);
				echo '<tr><td><table name="day_and_signups" width="100%">
						<tr><td width="40%" style="font-weight:bold">'.date("D d/m", $day->getDateTS()).'</td>
							<td width="30%">Behov: '.$timeslot->personNeed.'</td>
							<td width="30%">Rest: '.$timeslot->remainingNeed.'</td></tr>';				
			
				//TODO: use dictionery
				foreach ($signups as $signup) {
					$signup = Signup::cast($signup);
					if ($signup->timeslotID == $timeslot->id) {
						$user = getUser($signup->userID);
						echo '<tr><td colspan="2">'.$user->getFullName().'</td>
								  <td align="right">'.$signup->count.'</td></tr>';
					}
				}
				echo '</table></td></tr>';
			}
		}
		echo '</table></td></tr>';
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
} else {
	echo 'Error: Page parameter missing!';
}

html_bottom();

?>