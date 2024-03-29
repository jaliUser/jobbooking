<?php
include_once 'includes/init.php';
include_once 'jc_init.php';
//use reject_public_access() in individual functions

function show_blockings() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Blokeringer");
	
	$job = getJob(-1);
	
	if (!empty($_GET['user_id'])) {
		$user = getUser($_GET['user_id']);
	} else {
		$user = getUser($login);
	}

	echo "<h1>Blokeringer for <i><a href=\"jc_user.php?action=show_one&login=$user->login\">".$user->getFullName()."</a></i> (".$user->count." pers.)</h1>".
		'<p class="help">Nedenfor er angive nogle tidsperioder, hvor du/dit hold har mulighed for at oprette en blokeret (fredning) s� du/I ikke kan tildeles arbejde i disse perioder. Angiv hvor mange personer I �nsker blokeret for. Du kan maksimalt oprette 4 blokeringer.</p>';

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
		echo '<td align="center">'.vertical("Antal").'</td>';
	}
	echo '</tr>';
	
	$signups = listJobUserSignups($job->id, $user->login);
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
	
	foreach ($groupedTimeslots as $distinctTimeArr) {
		//build time-row from first TS in distinctTimeArr			
		$firstTS = $distinctTimeArr[0];
		echo '<tr><td>'.$firstTS->getStartHour().':'.$firstTS->getStartMin().' - '.$firstTS->getEndHour().':'.$firstTS->getEndMin().'</td>';

		for ($dayNo=0; $dayNo<count($days); $dayNo++) {
			$timeslot = Timeslot::cast($distinctTimeArr[$dayNo]);
			$signup = $signups[$timeslot->id];
			echo '<td align="center">
				<input type="text" name="signup-'.$timeslot->id.'" value="'.$signup->count.'" size="1" maxlength="3"/>
				</td>';
		}
		echo '</tr>';
	}
	echo '<tr><td colspan="'.(count($days)+1).'"><input type="submit" value="Opdat�r"/></td></tr>
		<input type="hidden" name="action" value="do_update">
		<input type="hidden" name="redir_action" value="show_blockings">
		<input type="hidden" name="job_id" value="'.$job->id.'">
		<input type="hidden" name="user_id" value="'.$user->login.'">
		</form>';
	echo '</table>';
	
	// show user list for admins
	if (user_is_admin() || user_is_consultant()) {
		show_user_table("V�lg bruger der skal blokeres for", "$PHP_SELF?action=show_blockings", listUsers($site_id), $_GET['lovtype']);
	}
	
	menu_link();
}

function show_update() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name, $siteConfig;
	html_top($site_name . " - Tilmelding til job");
	
	$minutesBeforeUpdateFreeze = 60*24*21; //21 days
	
	$job = getJob($_GET['job_id']);
	$job = Job::cast($job);
	$days = listDays($site_id);
	
	if (!empty($_GET['user_id'])) {
		$user = User::cast(getUser($_GET['user_id']));
	} else {
		$user = User::cast(getUser($login));
	}
	
	echo "<h1>Tilmelding til <i><a href=\"jc_job.php?action=show_one&job_id=$job->id\">$job->name</a></i> (ID $job->id) for <i><a href=\"jc_user.php?action=show_one&login=$user->login\">".$user->getFullName()."</a></i> (".$user->count." pers.)</h1>".
		'<p class="help">I kolonnerne <i>Behov</i> kan du se det aktuelle behov for personer til de forskellige tidsperioder. Hvis du eller dit hold �nsker at hj�lpe med dette job, udfyld det antal personer du/I kan stille med, for en given tidsperiode. Efter du har klikket p� <i>Opdat�r</i>, vil du se behovet blive reduceret med det antal personer du har tilmeldt.</p>';
	
	$firstDay = $days[0];
	if (time() + $minutesBeforeUpdateFreeze*60 > $firstDay->getDateTS()) {
		echo "<p align='center' class='redalert'><b>Bem�rk:</b> Tidsgr�nsen for �ndringer i eksisterende tilmeldinger er overskredet!<br/>
			Felter med eksisterende tilmeldinger er derfor l�ste og gr� herunder.<br/>
			Du kan stadig godt lave nye tilmeldinger, men ikke �ndre i dem efterf�lgende.<br/>
			Hvis du vil �ndre en l�st tilmelding, kontakt <a href='mailto:".$siteConfig->config[SiteConfig::$EMAIL]."'>$site_name</a>.</p>";
	}
	
	if (!empty($_GET['submit'])) {
		echo '<p align="center" class="redalert">Din tilmelding er nu opdateret.<br/>
			Du kan se dine jobtilmeldinger nederst p� siden,<br/>
			og det resterende behov for dette job er reduceret med antallet for din tilmelding.</p>';
	}
	
	//generate rows for existing timeslots
	echo '<table align="center" class="border1">
		<form action="'.$PHP_SELF.'" method="POST">
		<tr><th>Tid</th>';
	
	//generate header with days
	foreach ($days as $day) {
		$day = Day::cast($day);
		echo '<th>'.strftime("%a %d/%m", $day->getDateTS()).'</th>';
	}
	echo '</tr><tr><td></td>';
	
	foreach ($days as $day) {
		echo '<td><table class="border0" width="100%"><tr><td align="center">'.vertical("Behov").'</td><td align="center">'.vertical("Tilmeld").'</td></tr></table></td>';
	}
	echo "</tr>\r\n";

	$hiddenPercent = "";
	$hiddenNotes = "";
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

			echo '<td align="center">'.$timeslot->remainingNeed.'&nbsp;&nbsp;';
			
			//if signup exist
			if ($signup->count > 0) {
				//if now + minutesBeforeUpdateFreeze is past timeslot time, lock field
				if (time() + $minutesBeforeUpdateFreeze*60 > $timeslot->getStartTS() && !(user_is_admin() || user_is_consultant())) {
					echo '<input type="text" value="'.$signup->count.'" size="1" maxlength="3" disabled/>';
				//else allow editing existing signup
				} else {
					echo '<input type="text" name="signup-'.$timeslot->id.'" value="'.$signup->count.'" size="1" maxlength="3"/>';
					$hiddenPercent .= "$timeslot->id=$signup->percent;";
					$hiddenNotes .= "$timeslot->id=$signup->notes;";
				}
			//if no signup, make field for creating new signup, unless timeslot time is past now and user is not admin
			} else if ($timeslot->remainingNeed > 0 && (time() < $timeslot->getStartTS() || user_is_admin())) {
				echo '<input type="text" name="signup-'.$timeslot->id.'" size="1" maxlength="3"/>';
			//empty spaces just to align columns
			} else {
				echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			}
			
			echo "</td>\r\n";
		}
		echo "</tr>\r\n";
	}
	if ($_GET['job_id'] > 0) {
		echo '<tr><td colspan="'.(count($days)+1).'"><input type="checkbox" name="override_double_booking"/>Gennemtving tilmelding p� trods af dobbeltbookning (overlappende tidsperioder)</td></tr>';
	}
	
	echo '<tr><td colspan="'.(count($days)+1).'">
		<input type="hidden" name="action" value="do_update"/>
		<input type="hidden" name="job_id" value="'.$job->id.'"/>
		<input type="hidden" name="user_id" value="'.$user->login.'"/>
		<input type="hidden" name="percent" value="'.$hiddenPercent.'"/>
		<input type="hidden" name="notes" value="'.$hiddenNotes.'"/>
		<input type="submit" value="Opdat�r"/></td></tr>
		</form>';
	echo '</table>';
	
	// show resulting signups
	$signups = listUserSignups($user->login);
	if (count($signups) > 0) {
		$days = listDays($site_id);
	
		echo "<h3>Jobtilmeldinger for <i><a href=\"jc_user.php?action=show_one&login=$user->login\">".$user->getFullName()."</a></i></h3>";
		echo '<table align="center" class="border1">
				<tr><th>Dato</th><th>Tid</th><th>Personer</th><th>Job</th><th></th><th><i>Handling</i></th></tr>';
		
		foreach ($signups as $signup) {
			$signup = Signup::cast($signup);
			$timeslot = getTimeslot($signup->timeslotID);
			$userjob = getJob($timeslot->jobID);
			
			echo '<tr><td>'.strftime("%a %d/%m", $timeslot->getStartTS()).'</td>
					  <td>'.strftime("%H:%M", $timeslot->getStartTS()).strftime("-%H:%M", $timeslot->getEndTS()).'</td>
					  <td>'.$signup->count.'</td>
					  <td><a href="jc_job.php?action=show_one&job_id='.$userjob->id.'">'.$userjob->name.'</a></td>
					  <td></td>
					  <td>'.($userjob->id != $_GET['job_id'] ? '<a href="jc_signup.php?action=show_update&job_id='.$userjob->id.'&user_id='.$user->login.'">Redig�r</a>' : '(Ovenst�ende)').'</td>
					  </tr>';
		}
		echo '</table>';
	}
	
	// show user list for admins
	if (user_is_admin() || user_is_consultant()) {
		show_user_table("V�lg bruger der skal tilmeldes for", "$PHP_SELF?action=show_update&job_id=$job->id", listUsers($site_id), $_GET['lovtype']);
	}
	
	menu_link();
}

function do_update() {
	reject_public_access();
	global $PHP_SELF, $login;
	//require_params($_POST['job_id'], $_POST['user_id']);
	$error = "";
	if (empty($_POST['job_id'])) {
		$error .= "JobID mangler.<br>";
	}
	if (empty($_POST['user_id'])) {
		$error .= "BrugerID mangler.";
	}
	if (!empty($error)) {
		echo print_error($error);
		exit;
	}
	
	$notesArray = array();
	$notesPairs = explode(";", $_POST['notes']);
	foreach ($notesPairs as $pair) {
		$idAndValue = explode("=", $pair);
		$notesArray[$idAndValue[0]] = $idAndValue[1]; 
	}
	
	$percentArray = array();
	$percentPairs = explode(";", $_POST['percent']);
	foreach ($percentPairs as $pair) {
		$idAndValue = explode("=", $pair);
		$percentArray[$idAndValue[0]] = $idAndValue[1]; 
	}
	
	$timeslots = listTimeslots($_POST['job_id']);
	foreach ($timeslots as $ts) {
		$ts = Timeslot::cast($ts);
		if (!isset($_POST['signup-'.$ts->id])) {
			continue;
		}
		
		if (!Signup::isValidCount($_POST['signup-'.$ts->id])) {
			echo print_error("Ugyldigt antal for ".date("d/m H:i", $ts->getStartTS()).date(" - H:i", $ts->getEndTS()));
			exit;
		}

		$signup = new Signup($ts->id, $_POST['user_id'], 'A', null, $percentArray[$ts->id], $_POST['signup-'.$ts->id], $notesArray[$ts->id]);
		
		//check user has not more than X blockings
		$userBlockSignups = listJobUserSignups(-1, $_POST['user_id']);
		if (!empty($_POST['redir_action']) && 
			count($userBlockSignups) >= 4 && 
			signupsContainsTimeslot($userBlockSignups, $signup->timeslotID) == false &&
			$signup->count > 0) {
				echo print_error("Brugeren har allerede maks. antal blokeringer (4)");
				exit;
		}
		
		$userSignupForTS = getSignup($ts->id, $_POST['user_id']);
		
		if ($signup->count > 0 && ($signup->count - $userSignupForTS->count) > $ts->remainingNeed) {
			echo print_error("Der kan ikke tilmeldes flere end der er behov for");
			exit;
		}
		
		if (empty($_POST['override_double_booking']) && $signup->count > 0 && !isUserFree($signup->userID, $ts) && $userSignupForTS == null) {
			echo print_error("Brugeren er optaget af andet job eller blokering i tidsperioden ". $ts->date." ".$ts->getStartHour().":".$ts->getStartMin()."-".$ts->getEndHour().":".$ts->getEndMin());
			exit; 
		} else {
			createUpdateDeleteSignup($signup);
		}
	}
	
	if (!empty($_POST['redir_action'])) {
		do_redirect($PHP_SELF.'?action=show_blockings&user_id='.$_POST['user_id']);
	} else {
		do_redirect($PHP_SELF.'?action=show_update&job_id='.$_POST['job_id'].'&user_id='.$_POST['user_id'].'&submit=1');
	}
}

function show_update_noneed() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Tilmelding til job");
	
	$job = getJob($_GET['job_id']);
	$job = Job::cast($job);
	
	if ($job->type != "NN") {
		echo print_error("Job er ikke af typen NoNeed.");
		exit;
	}
	
	if (!empty($_GET['user_id'])) {
		$user = User::cast(getUser($_GET['user_id']));
	} else {
		$user = User::cast(getUser($login));
	}
	
	echo "<h1>Tilmelding til <i><a href=\"jc_job.php?action=show_one&job_id=$job->id\">$job->name</a></i> for <i><a href=\"jc_user.php?action=show_one&login=$user->login\">".$user->getFullName()."</a></i> (".$user->count." pers.)</h1>".
		'<p class="help">Hvis du eller dit hold har aftalt med underlejren at hj�lpe med et underlejrjob, 
			<br/>s� udfyld det antal personer du/I stiller med, og skriv en note om hvad opgaven/aftalen lyder p�.
			<br/>OBS: Tilmeld dig kun dette job, hvis du p� forh�nd har aftalt det med jobkonsulenten/den jobansvarlige.!
			<br/>Efter du har klikket p� <i>Opdat�r</i>, vil du se din tilmelding nederst p� siden.
		</p>';
	
	if (!empty($_GET['submit'])) {
		echo '<p align="center" class="redalert">Din tilmelding er nu opdateret.<br/>
			Du kan se dine jobtilmeldinger nederst p� siden.</p>';
	}
	
	$signups = listJobUserSignups($job->id, $user->login);
	$signupValues = array_values($signups);
	$signup = $signupValues[0];
	
	echo '<table align="center" class="border1">
		<form action="'.$PHP_SELF.'" method="POST">
		<tr><td>Antal:</td><td><input type="text" name="count" value="'.$signup->count.'" size="1" maxlength="3" /> person(er)</td></tr>
		<tr><td>Note:</td><td><input type="text" name="notes" value="'.$signup->notes.'" size="100" maxlength="255" /></td></tr>';
	
	echo '<tr><td colspan="2"><input type="submit" value="Opdat�r"/></td></tr>
		<input type="hidden" name="action" value="do_update_noneed">
		<input type="hidden" name="job_id" value="'.$job->id.'">
		<input type="hidden" name="user_id" value="'.$user->login.'">
		</form>';
	echo '</table>';
	
	//TODO: flyt til separat metode
	// show resulting signups
	$signups = listUserSignups($user->login);
	if (count($signups) > 0) {
		$days = listDays($site_id);
	
		echo "<h3>Jobtilmeldinger for <i><a href=\"jc_user.php?action=show_one&login=$user->login\">".$user->getFullName()."</a></i></h3>";
		echo '<table align="center" class="border1">
				<tr><th>Dato</th><th>Tid</th><th>Personer</th><th>Job</th><th></th><th><i>Handling</i></th></tr>';
		
		foreach ($signups as $signup) {
			$signup = Signup::cast($signup);
			$timeslot = getTimeslot($signup->timeslotID);
			$job = getJob($timeslot->jobID);
			
			echo '<tr><td>'.strftime("%a %d/%m", $timeslot->getStartTS()).'</td>
					  <td>'.strftime("%H:%M", $timeslot->getStartTS()).strftime("-%H:%M", $timeslot->getEndTS()).'</td>
					  <td>'.$signup->count.'</td>
					  <td><a href="jc_job.php?action=show_one&job_id='.$job->id.'">'.$job->name.'</a></td>
					  <td></td>
					  <td>'.($job->id != $_GET['job_id'] ? '<a href="jc_signup.php?action=show_update&job_id='.$job->id.'&user_id='.$user->login.'">Redig�r</a>' : '(Ovenst�ende)').'</td>
					  </tr>';
		}
		echo '</table>';
	}
	
	// show user list for admins
	if (user_is_admin() || user_is_consultant()) {
		show_user_table("V�lg bruger der skal tilmeldes for", "$PHP_SELF?action=show_update&job_id=$job->id", listUsers($site_id), $_GET['lovtype']);
	}
	
	menu_link();
}

function do_update_noneed() {
	reject_public_access();
	global $PHP_SELF;
	$error = "";
	if (empty($_POST['job_id'])) {
		$error .= "JobID mangler.<br>";
	}
	if (empty($_POST['user_id'])) {
		$error .= "BrugerID mangler.";
	}
	if (!empty($_POST['count']) && empty($_POST['notes'])) {
		$error .= "Note mangler.";
	}
	if (!Signup::isValidCount($_POST['count'])) {
		$error .= "Ugyldigt antal.";
	}
	if (!empty($error)) {
		echo print_error($error);
		exit;
	}
	
	$timeslots = listTimeslots($_POST['job_id']);
	$ts = $timeslots[0];
	$signup = new Signup($ts->id, $_POST['user_id'], 'A', null, 0, $_POST['count'], $_POST['notes']);		
	createUpdateDeleteSignup($signup);
	
	do_redirect($PHP_SELF.'?action=show_update_noneed&job_id='.$_POST['job_id'].'&user_id='.$_POST['user_id'].'&submit=1');
}

function show_move() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id;
	html_top($site_name . " - Flytning af tilmeldinger");
	
	$job = getJob($_GET['job_id']);
	$job = Job::cast($job);
	$jobs = listJobs($site_id);
	
	
	$days = listDays($site_id);
	$fromTimeslots = listTimeslots($job->id);
	
	$fromHTML = "<select name='from_ts'>";
	foreach ($fromTimeslots as $ts) {
		if (!$ts->personNeed > 0) {
			continue;
		}
		$signups = listTimeslotSignups($ts->id);
		$fromHTML .= "<option value='$ts->id'>".$ts->getDateText()." - ".$ts->getTimeText()." (".count($signups)." tilmeldinger)</option>";
	}
	$fromHTML = "/select>";
	
	
	echo "<h1>Flytning af tilmeldinger for <i><a href=\"jc_job.php?action=show_one&job_id=$job->id\">$job->name</a></i> (ID $job->id)</h1>";
	echo "<table align='center' class='border1'>
		<form action='$PHP_SELF' method='post'>
			<tr><td>$fromHTML</td></tr>
			<tr><td>$toHTML</td></tr>
		</form></table>";
	
	print_job_signups($job, listUsers($site_id), $days);
	
	menu_link();
}

function do_send_sms() {
	reject_public_access();
	global $PHP_SELF;
	$error = "";
	if (empty($_POST['numbers'])) {
		$error .= "Ingen numre indtastat.<br>";
	}
	if (empty($_POST['sms_text'])) {
		$error .= "Ingen SMS-tekst indtastet.";
	}
	if (!empty($error)) {
		echo print_error($error);
		exit;
	}
	
	$trimmedNumbers = trim($_POST['numbers']); //trim spaces
	$trimmedNumbers = trim($trimmedNumbers, ","); //trim comma
	$phoneArray = explode(",", $trimmedNumbers);

	smsPhoneList($phoneArray, $_POST['sms_text']);

	do_redirect($PHP_SELF.'?action=show_list&job_id='.$_POST['job_id'].'&sms_sent=1');
}

function show_list() {
	//reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	require_params(array($_GET['job_id'], $site_id));
	
	$users = listUsers($site_id);
	$days = listDays($site_id);
	$job = getJob($_GET['job_id']);
	$job = Job::cast($job);
	html_top($site_name . " - Tilmeldinger til $job->name");

	//generate rows for existing timeslots
	echo '<table name="outer" width="1000" align="center" border="0">';

	$emails = "";
	$phoneNumbers = "";
	print_job_signups($job, $users, $days, $emails, $phoneNumbers);
	
	//show sms box
	echo "<tr><td><h3>Send SMS til hj�lperne</h3></td></tr>";
	if (!empty($_GET['sms_sent'])) {
		echo "<tr><td align='center' class='redalert'>SMSer afsendt</td></tr>";
	}
	echo "<tr><td>
			<form action='$PHP_SELF' method='post'>
				<table border='0' align='center' class='border1'>
					<tr><td>Mobilnumre: </td><td><input type='text' name='numbers' value='$phoneNumbers' size='160' /> (flere numre adskilles af komma)</td></tr>
					<tr><td>SMS-tekst: </td><td><input type='text' name='sms_text' size='160' maxlength='160' /> (maks. 160 tegn)</td></tr>
					<tr><td colspan='2'><input type='submit' name='sms_sent' value='Send SMSer' /></td></tr>
				</table>
				<input type='hidden' name='action' value='do_send_sms' />
				<input type='hidden' name='job_id' value='$job->id' />
			</form>
		</td></tr><tr><td>&nbsp;</td></tr>";
	
	//show emails
	if (!empty($_POST['show_emails'])) {
		if (!empty($emails)) {
			$emailsCS = trim(trim($emails), ",");
			$emailsSS = str_replace(",", ";", $emailsCS);
			echo "<tr><td>
					<p><b>Hj�lper-emails komma-separeret:</b><br/>$emailsCS</p>
					<p><b>Hj�lper-emails semikolon-separeret:</b><br/>$emailsSS</p>
				</td></tr>";
		}
	} else {
		echo "<tr><td><form action='".$_SERVER['REQUEST_URI']."' method='POST'><input type='submit' name='show_emails' value='Vis hj�lper-emails' /></form></td></tr>";
	}
	
	echo '</table>';
	menu_link();
}

function show_list_print() {
	//reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	require_params(array($site_id));
	html_top($site_name . " - Tilmeldinger for alle jobs - " . date("d/m-Y, H:i"));

	$jobs = listJobs($site_id);
	$users = listUsers($site_id);
	$days = listDays($site_id);
	
	foreach ($jobs as $job) {
		$dummy1;
		$dummy2;
		print_job_details($job);
		print_job_signups($job, $users, $days, $dummy1, $dummy2, $_GET['filter']);
		echo '<div style="page-break-after:always"></div>';
	}
	
	menu_link();
}

function print_job_signups(Job $job, $users, $days, &$emails = null, &$phoneNumbers = null, $filter = null) {
	$emails = "";
	$phoneNumbers = "";
	
	echo "<tr><td>
			<h1>Tilmeldinger til <i><a href=\"jc_job.php?action=show_one&job_id=$job->id\">$job->name</a></i> (ID $job->id)</h1>
			<p align='center' class='help'>TIP: Print denne side som vagtplan, inden dit job begynder!</p>";
	if (! (user_is_admin() || user_is_consultant() || $login == $job->ownerID)) {
		echo "<p align='center' class='redalert'>Du st�r ikke som kontaktperson p� dette job, og kan derfor kun se tilmeldingerne, men ikke rette i dem!</p>";
	}
	echo "</td></tr>";

	//$signups = listJobSignups($job->id);
	$timeslots = listTimeslotsByDate($job->id);
	$groupedTimeslots = groupTimeslotsByDate($timeslots);
	foreach ($days as $key => $day) {
		$day = Day::cast($day);
		if ($filter != null && $day->getDateYMD() <= date("Ymd")) {
			continue;
		}
		
		$distinctDateArr = array();
		$distinctDateArr = ($groupedTimeslots[$key] != null ? $groupedTimeslots[$key] : array());
		//Avoid printing days with no need (empty timeslots may exist)
		$dayHasPersonNeed = false;
		foreach ($distinctDateArr as $timeslot) {
			$timeslot = Timeslot::cast($timeslot);
			if (!empty($timeslot->personNeed)) {
				$dayHasPersonNeed = true;
			}
		}
		if (!$dayHasPersonNeed) {
			continue;
		}
		
		echo '<tr><td><table align="center" class="border1" width="100%">
			<tr>
				<th width="2%"></th>
				<th width="18%">'.strftime("%a %d/%m", $day->getDateTS()).'</th>
				<th width="5%">Behov</th>
				<th width="5%">Rest</th>
				<th width="10%">Jobkonsulent</th>
				<th width="10%">Telefon</th>
				<th width="10%">Klannavn</th>
				<th width="3%">Antal</th>
				<th width="22%">Tilmeldt</th>
			</tr>';
		
		foreach ($distinctDateArr as $timeslot) {
			$timeslot = Timeslot::cast($timeslot);
			if (!empty($timeslot->personNeed)) {
				$contact = User::cast(getUser($timeslot->contactID));
				echo '<tr class="subth">
					<td></td>
					<td>'.strftime("%H:%M", $timeslot->getStartTS()).strftime("-%H:%M", $timeslot->getEndTS()).'</td>
					<td>'.$timeslot->personNeed.'</td>
					<td '.($timeslot->remainingNeed > 0 ? 'class="redalert"':'').'>'.$timeslot->remainingNeed.'</td>
					<td>'.$contact->firstname.'</td>
					<td colspan="4"></td>
			  	  </tr>';

				$signups = listTimeslotSignups($timeslot->id);
				foreach ($signups as $signup) {
					$signup = Signup::cast($signup);
					$user = $users[$signup->userID];
					if (!empty($user->email) && false === strpos($emails, $user->email)) {
						$emails .= "$user->email, ";
					}
					if (!empty($user->telephone) && false === strpos($phoneNumbers, $user->telephone)) {
						$phoneNumbers .= "$user->telephone, ";
					}
					
					$defUserLink = "";
					if ($signup->defUser != $user->login) {
						$defUser = getUser($signup->defUser); 
						$defUserLink = "<br/>(<a href='jc_user.php?action=show_one&login=$defUser->login'>".$defUser->getFullName()."</a>)";
					}
					echo "<tr><td>";
					if (user_is_admin() || user_is_consultant() || $job->ownerID == $login) {
						echo "<a href='jc_signup.php?action=show_update&job_id=$job->id&user_id=$user->login'>Ret</a>";
					}
					echo "</td><td colspan=\"4\"><a href=\"jc_user.php?action=show_one&login=$user->login\">".$user->getFullName()."</a></td>
							<td>$user->telephone</td>
							<td>$user->title</td>
							<td>$signup->count</td>
							<td>$signup->defDate <span class='help'>$defUserLink</span></td>
						</tr>";
				}
			}
		}
		echo '</table></td></tr><tr><td>&nbsp;</td></tr>';	
	}
}

function show_list_noneed() {
	//reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	require_params(array($_GET['job_id'], $site_id));
	html_top($site_name . " - Tilmeldinger til job");
	
	$job = getJob($_GET['job_id']);
	$job = Job::cast($job);
		
	echo "<h1>Tilmeldinger til <i><a href=\"jc_job.php?action=show_one&job_id=$job->id\">$job->name</a></i></h1>";
	//generate rows for existing timeslots
	echo '<table width="1000" align="center" class="border1">
			<tr>
				<th width="3%"></th>
				<th width="27%">Navn</th>
				<th width="15%">Klan/holdnavn</th>
				<th width="5%">Antal</th>
				<th width="30%">Note</th>
				<th width="20%">Tilmeldt</th>
			</tr>';

	$signups = listJobSignups($job->id, "def_date");
	foreach ($signups as $signup) {
		$signup = Signup::cast($signup);
		$user = getUser($signup->userID);
		echo "<tr>
				<td><a href='jc_signup.php?action=show_update_noneed&job_id=$job->id&user_id=$user->login'>Ret</td>
				<td><a href='jc_user.php?action=show_one&login=$user->login'>".$user->getFullName()."</td>
				<td>$user->title</td>
				<td>$signup->count</td>
				<td>$signup->notes</td>
				<td>$signup->defDate <span class='help'>(<a href='jc_user.php?action=show_one&login=$signup->defUser'>$signup->defUser</a>)</span></td>
			</tr>";	
	}
	echo '</table>';
	menu_link();
}

function show_evals() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Tilbagemeldinger p� job");
	
	$job = Job::cast(getJob($_GET['job_id']));
	$user = User::cast(getUser($login));

	$days = listDays($site_id);
	$signups = listJobSignups($job->id);
	$timeslots = listTimeslotsByDate($job->id);
	$groupedTimeslots = groupTimeslotsByDate($timeslots);
	$signupCount = 0;
	$maxSignupsPerForm = (200-10) / 2;
	
	$tsIDsWithSignups = array();
	foreach ($timeslots as $ts) {
		$tsIDsWithSignups[$ts->id] = false;
	}
	foreach ($signups as $signup) {
		$tsIDsWithSignups[$signup->timeslotID] = true;  
	}
	
	echo "<h1>Tilbagemeldinger p� <i>$job->name</i> (ID $job->id)</h1>";
	if (count($signups) > $maxSignupsPerForm) {
		echo "<p align='center' class='redalert'>
			Bem�rk: Dette job har mange tilmeldinger, s� grundet begr�nsninger p� serveren, er denne side delt op i sektioner, <br>
			med en Opdat�r-knap for hver 95 r�kker. Indtast kun tilbagemeldinger for �n sektion ad gangen.
		</p>";
	}
	
	if (!empty($_GET['submit'])) {
		echo '<p align="center" class="redalert">Din tilbagemelding er nu opdateret.</p>';
	}
	
	echo "<table align='center' class='border1'>";
	printStartEvalForm();
	
	foreach ($days as $key => $day) {
		$day = Day::cast($day);
		$distinctDateTimeslotArr = $groupedTimeslots[$key];
		$dayHasSignups = false;
		foreach ($distinctDateTimeslotArr as $timeslot) {
			//TODO: use dictionery
			foreach ($signups as $signup) {
				$signup = Signup::cast($signup);
				if ($signup->timeslotID == $timeslot->id) {
					$dayHasSignups = true;
				}
			}
		}
		if (!$dayHasSignups) {
			continue;
		}
		
		echo '<tr><th>'.strftime("%a %d/%m", $day->getDateTS()).'</th><th>Kommentar</th><th>Tilmeldt</th><th>Fremm�dt</th></tr>';
		foreach ($distinctDateTimeslotArr as $timeslot) {
			$timeslot = Timeslot::cast($timeslot);
			if ($tsIDsWithSignups[$timeslot->id] == false) {
				continue;
			}
			
			echo '<tr class="subth"><td colspan="4">'.$timeslot->getStartHour().':'.$timeslot->getStartMin().' - '.$timeslot->getEndHour().':'.$timeslot->getEndMin().'</td></tr>';
			
			//TODO: use dictionery
			foreach ($signups as $signup) {
				$signup = Signup::cast($signup);
				if ($signup->timeslotID == $timeslot->id) {
					$signupCount++;
					if ($signupCount > $maxSignupsPerForm) {
						printEndEvalForm($job);
						printStartEvalForm();
						$signupCount = 0;
					}
					
					$user = getUser($signup->userID);
					echo "<tr><td><a href='jc_user.php?action=show_one&login=$user->login'>".$user->getFullName()."</a></td>
							  <td><input type='text' name='notes-$signup->timeslotID--$signup->userID' value='$signup->notes' size='100' maxlength='255' /></td>
							  <td align='center'>$signup->count</td>
							  <td align='center'><input type='text' name='percent-$signup->timeslotID--$signup->userID' value='$signup->percent' size='1' maxlength='3'/></td></tr>";
				}
			}
		}
	}
	
	printEndEvalForm($job);
	echo '</table>';
	menu_link();
}

function printStartEvalForm() {
	echo "<form action='$PHP_SELF' method='post'>";
}

function printEndEvalForm($job) {
	echo '<tr><td colspan="4" align="center"><input type="submit" value="Opdat�r"/></td></tr>
		<input type="hidden" name="action" value="update_evals">
		<input type="hidden" name="job_id" value="'.$job->id.'">
		</form>';
}

function show_evals_list() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Tilbagemeldinger p� job");
	
	if ($_GET['filter'] == "missing") {
		echo "<h1>Manglende tilbagemeldinger</h1>";
	} else if ($_GET['filter'] == "existing") {
		echo "<h1>Udfyldte tilbagemeldinger</h1>";
	} else {
		echo "<h1>Alle tilbagemeldinger</h1>";
	}

	$days = listDays($site_id);
	$jobs = listJobs($site_id);
	$users = listUsers($site_id);
	$timeslots = listTimeslotsSite($site_id);
	$signupSum = 0;
	$showupSum = 0;
	
	echo "<table align='center' class='border1'>
			<tr>
				<th></th>
				<th>ID</th>
				<th>Job</th>
				<th>Dato</th>
				<th>Tid</th>
				<th>Navn</th>
				<th>Kommentar</th>
				<th title='Tilmeldt'>T</th>
				<th title='Fremm�dt'>F</th>
				<th title='Fremm�dt i procent'>F%</th>
			</tr>";
	foreach ($timeslots as $ts) {
		$job = $jobs[$ts->jobID];
		$signups = listTimeslotSignups($ts->id);
		foreach ($signups as $signup) {
			if ($_GET['filter'] == "missing" && $signup->percent != null) {
				continue;
			} else if ($_GET['filter'] == "existing" && $signup->percent == null) {
				continue;
			}
			
			$user = $users[$signup->userID];
			echo "<tr>
					<td><a href='jc_signup.php?action=show_evals&job_id=$job->id'>Ret</a></td>
					<td>$job->id</td>
					<td><a href='jc_job.php?action=show_one&job_id=$job->id'>$job->name</a></td>
					<td>".$ts->getDateTextNoYear()."</td>
					<td>".$ts->getTimeText()."</td>
					<td><a href='jc_user.php?action=show_one&login=$user->login'>".$user->getFullNameAndLogin()."</a></td>
					<td>$signup->notes</td>
					<td>$signup->count</td>
					<td ".($signup->percent < $signup->count ? "class='redalert'":"").">$signup->percent</td>
					<td>";
			if ($signup->percent != null) {
				echo round($signup->percent / $signup->count * 100, 1)."%";
			}
			echo "</td>
				</tr>";
			$signupSum += $signup->count;
			$showupSum += $signup->percent;
		}
	}
	echo "<tr>
			<td colspan='7'></td>
			<td>$signupSum</td>
			<td>$showupSum</td>
			<td>".(round($showupSum / $signupSum * 100, 1))."%</td>
		</tr>
		</table>";
	
	menu_link();
}

function update_evals() {
	reject_public_access();
	global $PHP_SELF;
	
	$timeslots = listTimeslots($_POST['job_id']);
	$signups = listJobSignups($_POST['job_id']);
	
	$error = "";
	if (empty($_POST['job_id'])) {
		$error .= "JobID mangler.<br>";
	}
	foreach ($timeslots as $timeslot) {
		if (!empty($_POST["percent-$timeslot->id"]) && !is_numeric($_POST["percent-$timeslot->id"])) {
			$error .= "Ugyldigt antal.<br>";
		}
	}
	if (!empty($error)) {
		echo print_error($error);
		exit;
	}
	
	foreach ($timeslots as $timeslot) {
		//TODO: use dictionery
		foreach ($signups as $signup) {
			if ($signup->timeslotID == $timeslot->id && isset($_POST["percent-$signup->timeslotID--$signup->userID"])) {
				if ($_POST["percent-$signup->timeslotID--$signup->userID"] != $signup->percent || $_POST["notes-$signup->timeslotID--$signup->userID"] != $signup->notes) {
					$signup->percent = $_POST["percent-$signup->timeslotID--$signup->userID"];
					$signup->notes = $_POST["notes-$signup->timeslotID--$signup->userID"];
					updateEval($signup);
				}
			}
		}
	}
	
	do_redirect($PHP_SELF.'?action=show_evals&job_id='.$_POST['job_id'].'&submit=1');
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
	echo "<p align='center' class='help'>TIP: Print denne side til at tage med, inden du skal p� job!<br/>Klik ogs� ind p� hvert job og se evt. bem�rkninger.</p>";
	echo '<table align="center" class="border1">
			<tr>
				<th>Dato</th>
				<th>Tid</th>
				<th>Personer</th>';
	if (empty($_GET['show_block'])) {
		echo   "<th>Job</th>
				<th>M�dested</th>
				<th>Kontakt</th>
				<th>Kontakt tlf</th>
				<th></th>
				<th><i>Handling</i></th>";
	}
	echo "</tr>";
	
	foreach ($signups as $signup) {
		$signup = Signup::cast($signup);
		$timeslot = getTimeslot($signup->timeslotID);
		$job = getJob($timeslot->jobID);
		
		echo '<tr><td>'.strftime("%a %d/%m", $timeslot->getStartTS()).'</td>
				  <td>'.strftime("%H:%M", $timeslot->getStartTS()).strftime("-%H:%M", $timeslot->getEndTS()).'</td>
				  <td>'.$signup->count.'</td>';
		if (empty($_GET['show_block'])) {
			$owner = getUser($job->ownerID);
			echo '<td><a href="jc_job.php?action=show_one&job_id='.$job->id.'">'.$job->name.'</a></td>
				<td>'.$job->meetplace.'</td>
				<td><a href="jc_user.php?action=show_one&login='.$owner->login.'">'.$owner->getFullName().'</a></td>
				<td>'.$owner->telephone.'</td>
				<td></td>
				<td><a href="jc_signup.php?action=show_update'.($job->type == "NN" ? '_noneed' : '').'&job_id='.$job->id.'&user_id='.$user->login.'">Redig�r</a></td>';
		}
		echo '</tr>';	
	}
	echo '</table>';
	
	// show user list for admins
	if (user_is_admin() || user_is_consultant()) {
		show_user_table("V�lg bruger der skal vises jobtilmeldinger for", "$PHP_SELF?action=show_mine".(!empty($_GET['show_block']) ? '&show_block=1':''), listUsers($site_id), $_GET['lovtype']);
	}
	
	menu_link();
}

function show_subcamp_signups() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top("$site_name - Jobtilmeldinger for underlejr");
	
	$subcampHTML = '<select name="subcamp_id">';
		$subcamps = listSubcamps($site_id);
		foreach ($subcamps as $subcamp) {
			$selected = ($subcamp->id == $_POST['subcamp_id'] ? 'selected' : '');
			$subcamp = Subcamp::cast($subcamp);
			$subcampHTML .= "<option value='$subcamp->id' $selected>$subcamp->name</option>";
		}
	$subcampHTML .= '</select>';
	
	echo "<form method='post'>
			<div align='center'><h3>V�lg underlejr:</h3>
			$subcampHTML
			<input type='submit' name='all_signups' value='Vis alle tilmeldinger for underlejr'/>
			<input type='submit' name='only_sums' value='Vis kun timesum for underlejr'/>
			</div>
		</form>";
		
	if (empty($_POST['subcamp_id'])) {
		return;
	}
	$subcamp = getSubcamp($_POST['subcamp_id']);

	echo "<h1>Jobtilmeldinger for <i>$subcamp->name</i></h1>
			<table align='center' width='1000' align='center' border='0'>";
	
	$districts = listDistricts($site_id, $subcamp->id);
	foreach ($districts as $district) {
		echo "<tr><td><h2 align='center'>$district->name</h2></td></td>
			  <tr><td>
				<table name='district' class='border1' width='100%' align='center' border='0'>";
		
		$groups = listGroupsinDistrict($district->id);
		foreach ($groups as $group) {
			$groupHourSum = 0;
			echo "<tr><td class='bigsubth'>$group->name</th></tr>
				  <tr><td>
					<table name='group' class='border1' width='100%' align='center' border='0'>";
			
			$users = listUsers($site_id, null, $group->id);			
			foreach ($users as $user) {
				$signups = listUserSignups($user->login, false);
				
				if (!empty($_POST['all_signups'])) {
					echo "<tr>
							<td colspan='5'><table width='100%' align='center' border='0'>
								<tr class='subth'>
									<td width='30%'>Navn</td>
									<td width='20%'>Brugernavn</td>
									<td width='15%'>Tlf.</td>
									<td width='25%'>E-mail</td>
									<td width='10%'>Antal</td>
								</tr>
								<tr>
									<td>".$user->getFullName()."</td>
									<td>$user->login</td>
									<td>$user->telephone</td>
									<td>$user->email</td>
									<td>$user->count</td>
								</tr>
							</table></td>
						</tr>";
				}
				
				if (count($signups) == 0) {
					continue;
				} else if (!empty($_POST['all_signups'])) {
					echo "<tr>
							<th>Dato</th>
							<th>Tid</th>
							<th>Personer</th>
							<th>Timer i alt</th>
							<th>Job</th>
						</tr>";
				}
				
				foreach ($signups as $signup) {
					$signup = Signup::cast($signup);
					$timeslot = getTimeslot($signup->timeslotID);
					$job = getJob($timeslot->jobID);
					
					if (!empty($_POST['all_signups'])) {
						echo '<tr>
								<td>'.strftime("%a %d/%m", $timeslot->getStartTS()).'</td>
								<td>'.strftime("%H:%M", $timeslot->getStartTS()).strftime("-%H:%M", $timeslot->getEndTS()).'</td>
								<td>'.$signup->count.'</td>
								<td>'.round(($signup->count * $timeslot->duration/60),1).'</td>
								<td><a href="jc_job.php?action=show_one&job_id='.$job->id.'">'.$job->name.'</a></td>
							</tr>';
					}
					$groupHourSum += $signup->count * $timeslot->duration/60;
				}
			}
			echo "</table>";
			if (count($users) > 0) {
				if (empty($_POST['all_signups'])) {
					$persons = 0;
					foreach ($users as $user) {
						$persons += $user->count;
					}
					echo "<tr><td>Antal brugere: ".count($users)." ($persons pers.)</td></tr>";
				}
				echo "<tr><td>Total timer for gruppe: ".round($groupHourSum, 1)."</td></tr>";
			}
			echo "</td></tr>"; // end group
		}
		echo "</table>
			</td></tr>"; //end district
	}
	
	echo '</table>'; //end subcamp
		
	menu_link();
}

if ($_REQUEST['action'] == 'show_update') {
	show_update();
} elseif ($_REQUEST['action'] == 'do_update') {
	do_update();
} elseif ($_REQUEST['action'] == 'show_update_noneed') {
	show_update_noneed();
} elseif ($_REQUEST['action'] == 'do_update_noneed') {
	do_update_noneed();
} elseif ($_REQUEST['action'] == 'show_blockings') {
	show_blockings();
} elseif ($_REQUEST['action'] == 'show_list') {
	show_list();
} elseif ($_REQUEST['action'] == 'show_list_print') {
	show_list_print();
} elseif ($_REQUEST['action'] == 'show_list_noneed') {
	show_list_noneed();
} elseif ($_REQUEST['action'] == 'show_evals') {
	show_evals();
} elseif ($_REQUEST['action'] == 'update_evals') {
	update_evals();
} elseif ($_REQUEST['action'] == 'show_evals_list') {
	show_evals_list();
} elseif ($_REQUEST['action'] == 'show_mine') {
	show_mine();
} elseif ($_REQUEST['action'] == 'show_subcamp_signups') {
	show_subcamp_signups();
} elseif ($_REQUEST['action'] == 'show_move') {
	show_move();
} elseif ($_REQUEST['action'] == 'do_send_sms') {
	do_send_sms();
} else {
	echo 'Error: Page parameter missing!';
}

html_bottom();

?>