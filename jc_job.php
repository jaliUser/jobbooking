<?php
include_once 'includes/init.php';
include_once 'jc_init.php';
//use reject_public_access() in individual functions

$usePredefPlaces = false;
$showOthersSignups = false;

$notesExample = "F.eks. noget om:
- drikkevarer
- s�rlig bekl�dning
- transport";

function getPlaces() {
	$places[] = "";
	$places[] = "N�rreport";
	$places[] = "�sterport";
	$places[] = "S�nderport";
	$places[] = "Vesterport";
	$places[] = "Andet";
	return $places;
}

function sortById(Job $jobA, Job $jobB) {
	if ($jobA->id == $jobB->id) {
		return 0;
	}
	return ($jobA->id < $jobB->id) ? -1 : 1;
}

function sortByName(Job $jobA, Job $jobB) {
	if ($jobA->name == $jobB->name) {
		return 0;
	}
	return ($jobA->name < $jobB->name) ? -1 : 1;
}

function sortByOwner(Job $jobA, Job $jobB) {
	if ($jobA->ownerID == $jobB->ownerID) {
		return 0;
	}
	return ($jobA->ownerID < $jobB->ownerID) ? -1 : 1;
}

function sortByMeetplace(Job $jobA, Job $jobB) {
	if ($jobA->meetplace == $jobB->meetplace) {
		return 0;
	}
	return ($jobA->meetplace < $jobB->meetplace) ? -1 : 1;
}

function sortByJobplace(Job $jobA, Job $jobB) {
	if ($jobA->jobplace == $jobB->jobplace) {
		return 0;
	}
	return ($jobA->jobplace < $jobB->jobplace) ? -1 : 1;
}

function sortByArea(Job $jobA, Job $jobB) {
	if ($jobA->areaID == $jobB->areaID) {
		return 0;
	}
	return ($jobA->areaID < $jobB->areaID) ? -1 : 1;
}

function sortByPriority(Job $jobA, Job $jobB) {
	if ($jobA->priority == $jobB->priority) {
		return 0;
	}
	return ($jobA->priority < $jobB->priority) ? -1 : 1;
}

function sortByPersonsNeeded(Job $jobA, Job $jobB) {
	if ($jobA->totalNeed == $jobB->totalNeed) {
		return 0;
	}
	return ($jobA->totalNeed < $jobB->totalNeed) ? -1 : 1;
}

function sortByPersonsRemaining(Job $jobA, Job $jobB) {
	if ($jobA->remainingNeed == $jobB->remainingNeed) {
		return 0;
	}
	return ($jobA->remainingNeed < $jobB->remainingNeed) ? -1 : 1;
}

function sortByPersonsRemainingPercent(Job $jobA, Job $jobB) {
	if ($jobA->getRemainingPersonsPercent() == $jobB->getRemainingPersonsPercent()) {
		return 0;
	}
	return ($jobA->getRemainingPersonsPercent() < $jobB->getRemainingPersonsPercent()) ? -1 : 1;
}

function sortByHoursNeeded(Job $jobA, Job $jobB) {
	if ($jobA->totalHours == $jobB->totalHours) {
		return 0;
	}
	return ($jobA->totalHours < $jobB->totalHours) ? -1 : 1;
}

function sortByHoursRemaining(Job $jobA, Job $jobB) {
	if ($jobA->remainingHours == $jobB->remainingHours) {
		return 0;
	}
	return ($jobA->remainingHours < $jobB->remainingHours) ? -1 : 1;
}

function sortByHoursRemainingPercent(Job $jobA, Job $jobB) {
	if ($jobA->getRemainingHoursPercent() == $jobB->getRemainingHoursPercent()) {
		return 0;
	}
	return ($jobA->getRemainingHoursPercent() < $jobB->getRemainingHoursPercent()) ? -1 : 1;
}

function show_list() {
	global $PHP_SELF, $login, $site_id, $site_name, $showOthersSignups;
	$site_id = (!empty($_GET['site_id']) ? $_GET['site_id'] : $site_id);
	html_top($site_name . " - Jobliste");
	
	if (empty($_GET['sort'])) {
		$_GET['sort'] = "name"; //SETTING DEFAULT SORT
	}
	
	$role = getRole($login);
	$area = getAreaFromContact($login);
	$sumNeedPers = 0;
	$sumNeedHour = 0;
	$sumRestPers = 0;
	$sumRestHour = 0;
	
	$areaSumNeedPers = 0;
	$areaSumNeedHour = 0;
	$areaSumRestPers = 0;
	$areaSumRestHour = 0;
	$lastArea = null;
	
	if (!empty($_GET['user_id']) && !empty($_GET['status'])) {
		$title = "Jobs under <i>$area->description</i> der afventer godkendelse";
	} else if (!empty($_GET['user_id'])) {
		$title = "<a href=\"jc_user.php?action=show_one&login=".$_GET['user_id']."\">".getUser($_GET['user_id'])->getFullName()."</a>'s jobs";
	} elseif (!empty($_GET['filter'])) {
		$title = "Ledige jobs";
	} elseif (!empty($_GET['status'])) {
		$title = "Afventende jobs";
	} else {
		$title = "Alle godkendte jobs";
	}
	echo '<h1>'.$title.'</h1>';
	echo "<p align='center' class='help'>TIP: Klik p� kolonnenavnene for at sortere.</p>";
	echo '<table align="center" class="border1" width="1000px">
		<tr>
			<th><i>Handlinger</i></th>
			<th>'.sortHeader("id", "ID").'</th>
			<th>'.sortHeader("name", "Overskrift").'</th>
			<th>Beskrivelse</th>
			<th>'.sortHeader("owner", "Kontakt").'</th>
			<th>'.sortHeader("meetplace", "M�dested").'</th>
			<th>'.sortHeader("jobplace", "Jobsted").'</th>
			<th>Noter</th>
			<th>'.sortHeader("area", "Omr�de").'</th>
			<th title="Person Behov">'.sortHeader("persons_needed", "B").'</th> 
			<th title="Person Rest">'.sortHeader("persons_remaining", "R").'</th>
			<th title="Person rest i procent">'.sortHeader("persons_remaining_percent", "R%").'</th>'
		.(user_is_admin() || $_GET['user_id'] == $login ?'
			<th title="Status">S</th>':'')
		.(user_is_admin() ?'
			<th title="Prioritet">'.sortHeader("priority", "P").'</th>
			<th title="Time Behov">'.sortHeader("hours_needed", "TB").'</th>
			<th title="Time Rest">'.sortHeader("hours_remaining", "TR").'</th>
			<th title="Time Rest i procent">'.sortHeader("hours_remaining_percent", "TR%").'</th>
			':'')
		.'</tr>';
	
	$jobs = listJobs($site_id, $_GET['status'], $_GET['user_id'], $_GET['filter']);
	switch ($_GET['sort']) {
		case "name":
			usort($jobs, "sortByName");
			break;
		case "owner":
			usort($jobs, "sortByOwner");
			break;
		case "meetplace":
			usort($jobs, "sortByMeetplace");
			break;
		case "jobplace":
			usort($jobs, "sortByJobplace");
			break;
		case "area":
			usort($jobs, "sortByArea");
			break;
		case "priority":
			usort($jobs, "sortByPriority");
			break;
		case "persons_needed":
			usort($jobs, "sortByPersonsNeeded");
			break;
		case "persons_remaining":
			usort($jobs, "sortByPersonsRemaining");
			break;
		case "persons_remaining_percent":
			usort($jobs, "sortByPersonsRemainingPercent");
			break;
		case "hours_needed":
			usort($jobs, "sortByHoursNeeded");
			break;
		case "hours_remaining":
			usort($jobs, "sortByHoursRemaining");
			break;
		case "hours_remaining_percent":
			usort($jobs, "sortByHoursRemainingPercent");
			break;
		default:
			usort($jobs, "sortById");
			break;
	}
	
	foreach ($jobs as $job) {
		$job = Job::cast($job);
		$area = Area::cast(getArea($job->id));
		
		//In vacant jobs list, filter those without need - implement in SQL instead
		if (!empty($_GET['filter']) && $job->remainingNeed <= 0) {
			continue;
		}
		
		if (user_is_admin() && $_GET['sort'] == "area" && $lastArea != $area && $lastArea != null) {
			print_sum_need($areaSumNeedPers, $areaSumRestPers, $areaSumNeedHour, $areaSumRestHour, "Subtotal '$lastArea->name'");
			$areaSumNeedPers = 0;
			$areaSumRestPers = 0;
			$areaSumNeedHour = 0;
			$areaSumRestHour = 0;
		}
		$areaSumNeedPers += $job->totalNeed;
		$areaSumRestPers += $job->remainingNeed;
		$areaSumNeedHour += $job->totalHours;
		$areaSumRestHour += $job->remainingHours;
		$lastArea = $area;
		
		echo "<tr><td>";
		//start menu links
		if(user_is_arearesponsible() == false) {
			echo "<a href='jc_signup.php?action=show_update".($job->type == "NN" ? '_noneed' : '')."&job_id=$job->id'>Tilmeld</a><br>";				
		}
		if(user_is_admin() || user_is_consultant() || $job->ownerID == $login || ($showOthersSignups && user_is_employer())) {
			echo "<a href='jc_signup.php?action=show_list".($job->type == "NN" ? '_noneed' : '')."&job_id=$job->id'>Vis&nbsp;tilmeldinger</a><br>";
		}
		echo '<a href="jc_timeslot.php?action=show_print_vacant&job_id='.$job->id.'">Print ledige tider</a><br/>';
		if(user_is_admin() || $job->ownerID == $login) {
			echo "<a href='$PHP_SELF?action=show_update&job_id=$job->id'>Redig�r&nbsp;job</a><br>";
		}
		if(user_is_admin() || $job->ownerID == $login && $job->type == "WN") {
			echo "<a href='jc_timeslot.php?action=show_update&job_id=$job->id'>Redig�r&nbsp;behov</a><br>";
		}
		if(user_is_admin()  && $job->type == "WN") {
			echo "<a href='jc_signup.php?action=show_move&job_id=$job->id'>Flyt tilmeldinger</a><br>";
		}
		if(user_is_admin() || user_is_consultant() || $job->ownerID == $login && $job->type == "WN") {
			echo "<a href='jc_signup.php?action=show_evals&job_id=$job->id'>Redig�r&nbsp;tilbagemeldinger</a><br>";
		}
		if(user_is_admin() || user_is_consultant() && $job->type == "WN") {
			echo "<a href='jc_timeslot.php?action=show_assign&job_id=$job->id'>Tildel&nbsp;jobkonsulenter</a>";
		}
		if(user_is_arearesponsible() && !empty($_GET['user_id']) && !empty($_GET['status'])) {
			echo "<a href='$PHP_SELF?action=do_approve&job_id=$job->id'>Godkend</a>";
		}
		//end menu links
		echo "</td>
				<td>$job->id</td>
				<td><a href='$PHP_SELF?action=show_one&job_id=$job->id'>$job->name</a></td>";
		
		if (strlen($job->description) > 100) {
			echo "<td title='$job->description'>".nl2br(substr($job->description, 0, 100)) . "... <div align='right'><a href='$PHP_SELF?action=show_one&job_id=$job->id'>L�s mere</a></div></td>";
		} else {
			echo "<td>".nl2br($job->description)."</td>";
		}
		
		echo "<td><a href=\"jc_user.php?action=show_one&login=$job->ownerID\">".getUser($job->ownerID)->getFullName()."</a></td>
				<td>$job->meetplace</td>
				<td>$job->jobplace</td>";
		
		if (strlen($job->notes) > 100) {
			echo "<td title='$job->notes'>".nl2br(substr($job->notes, 0, 100)) . "... <div align='right'><a href='$PHP_SELF?action=show_one&job_id=$job->id'>L�s mere</a></div></td>";
		} else {
			echo "<td>".nl2br($job->notes)."</td>";
		}
		
		echo "<td title='$area->description'>$area->name</td>
				<td title='Behov'>$job->totalNeed</td>
				<td title='Rest'>$job->remainingNeed</td>
				<td title='Rest procent'>".$job->getRemainingPersonsPercent()."%</td>
				".(user_is_admin() || $_GET['user_id'] == $login ? "<td title='".$job->getLongStatus()."'>".$job->getShortStatus()."</td>":'')."
				".(user_is_admin() ?"<td>$job->priority</td><td>$job->totalHours</td><td>$job->remainingHours</td><td>".$job->getRemainingHoursPercent()."%</td>":'')."
				</tr>";
		
		$sumNeedPers += $job->totalNeed;
		$sumRestPers += $job->remainingNeed;
		$sumNeedHour += $job->totalHours;
		$sumRestHour += $job->remainingHours;
	}
	
	if(user_is_admin() && $_GET['sort'] == "area") {
		print_sum_need($areaSumNeedPers, $areaSumRestPers, $areaSumNeedHour, $areaSumRestHour, "Subtotal '$area->name'");
	}
	if(user_is_admin() && empty($_GET['filter'])) {
		print_sum_need($sumNeedPers, $sumRestPers, $sumNeedHour, $sumRestHour, "Total");
	}
	echo "</table>";
	
	// show user list for admins
	if (user_is_admin() && !empty($_GET['user_id'])) {
		show_user_table("V�lg bruger der skal vises jobopslag for", "$PHP_SELF?action=show_list", listUsers($site_id, 2), $_GET['lovtype']);
	}
	
	menu_link();
}

function print_sum_need($sumNeedPers, $sumRestPers, $sumNeedHour, $sumRestHour, $totalText) {
	echo "<tr><td colspan='9'>$totalText</td>
			<td>$sumNeedPers</td>
			<td>$sumRestPers</td>
			<td>". ($sumNeedPers > 0 ? round($sumRestPers/$sumNeedPers*100, 0) : 0) ."%</td>
			<td colspan='2'></td>
			<td>$sumNeedHour</td>
			<td>$sumRestHour</td>
			<td>". ($sumNeedHour > 0 ? round($sumRestHour/$sumNeedHour*100, 0) : 0) ."%</td>
		</tr>";
}

function show_list_noneed() {
	global $PHP_SELF, $login, $site_id, $site_name;
	$site_id = (!empty($_GET['site_id']) ? $_GET['site_id'] : $site_id);
	html_top($site_name . " - Underlejrjobs");
	
	$role = getRole($login);
	$area = getAreaFromContact($login);
	$jobs = listJobsNoNeed($site_id);
	$title = "Underlejrjobs";
	
	echo '<h1>'.$title.'</h1>
		<table align="center" class="border1" width="1000px">
		<tr> <th><i>Handlinger</i></th> <th>ID</th> <th>Overskrift</th> <th>Beskrivelse</th> <th>Kontakt</th> <th>M�dested</th> <th>Jobsted</th> <th>Noter</th> <th>Omr�de</th>'
		.(user_is_admin() || $_GET['user_id'] == $login ?'<th title="Status">S</th>':'')
		.(user_is_admin() ?'<th title="Prioritet">P</th>':'')
		.'</tr>';
	foreach ($jobs as $job) {
		$job = Job::cast($job);
		$area = Area::cast(getArea($job->id));

		echo "<tr><td>";
		echo "<a href='jc_signup.php?action=show_update_noneed&job_id=$job->id'>Tilmeld</a><br>";
		if(user_is_admin() || user_is_consultant() || $job->ownerID == $login) {
			echo "<a href='jc_signup.php?action=show_list_noneed&job_id=$job->id'>Vis&nbsp;tilmeldinger</a><br>
				<a href='$PHP_SELF?action=show_update&job_id=$job->id'>Redig�r&nbsp;job</a><br>";
		}
		echo "</td>
				<td>$job->id</td>
				<td><a href='$PHP_SELF?action=show_one&job_id=$job->id'>$job->name</a></td>
				<td>";
		if (strlen($job->description) > 200) {
			echo nl2br(substr($job->description, 0, 200)) . "... <div align='right'><a href='$PHP_SELF?action=show_one&job_id=$job->id'>L�s mere</a></div>";
		} else {
			echo nl2br($job->description);
		}
		
		echo "</td>
				<td><a href=\"jc_user.php?action=show_one&login=$job->ownerID\">".getUser($job->ownerID)->getFullName()."</a></td>
				<td>$job->meetplace</td>
				<td>$job->jobplace</td>
				<td>$job->notes</td>
				<td title='$area->description'>$area->name</td>
				".(user_is_admin() || $_GET['user_id'] == $login ? "<td title='".$job->getLongStatus()."'>".$job->getShortStatus()."</td>":'')."
				".(user_is_admin() ?"<td>$job->priority</td>":'')."
				</tr>";
	}
	
	echo "</table>";	
	menu_link();
}

function show_create() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name, $usePredefPlaces;
	html_top($site_name . " - Opret job");
	echo "<h1>Opret job</h1>";
	
	$minutesBeforeUpdateFreeze = 60*24*14; //14 days
	$disabled = "";
	if (time() + $minutesBeforeUpdateFreeze*60 > getFirstDay($site_id)->getDateTS()) {
		echo "<p align='center' class='redalert'><b>Bem�rk:</b> Tidsgr�nsen for oprettelse er overskredet!<br/>
			Kontakt <a href='mailto:".$siteConfig->config[SiteConfig::$EMAIL]."'>$site_name</a>, hvis du har behov for at oprette et job.</p>";
		
		if (!user_is_admin()) {
			$disabled = "disabled";
		}
	}
	
	//generate html for all areas
	$areasHTML = '<select name="area_id" '.$disabled.'>';
	$areas = listAreas($site_id);
	foreach ($areas as $area) {
		$area = Area::cast($area);
		$areasHTML .= '<option value="'.$area->id.'">'.$area->description.' ('.$area->name.')</option>';
	}	
	$areasHTML .= '</select>';

	//generate html for users with employer role
	$ownerHTML = '<select name="owner_id" '.$disabled.'>';
	if (user_is_admin() || user_is_consultant()) {
		$employers = listUsers($site_id, 2);
		$consultants = listUsers($site_id, 4);
		$admins = listUsers($site_id, 1);
		$users = array_merge($employers, $consultants, $admins);
		//sort(&$users);
		
		foreach ($users as $user) {
			$user = User::cast($user);
			$ownerHTML .= '<option value="'.$user->login.'">'.$user->getFullName().'</option>';
		}
	} else {
		$ownerHTML .= '<option value="'.$login.'">'.getUser($login)->getFullName().'</option>';
	}
	$ownerHTML .= '</select>';
	
	$statusHTML =  '<select name="status" '.$disabled.'>
					<option value="A">'.Job::jobStatus('A').'</option>
					<option value="W">'.Job::jobStatus('W').'</option>
					</select>';
					
	$priorityHTML = '<select name="priority" '.$disabled.'>
					<option>1</option> <option>2</option> <option selected>3</option> <option>4</option> <option>5</option>
					</select>';
	
	$typeHTML = '<select name="type" '.$disabled.'>
				<option value="WN">'.Job::jobType('WN').'</option>
				<option value="NN">'.Job::jobType('NN').'</option>
				</select>';
	
	if ($usePredefPlaces) {
		$places = getPlaces();
		$meetplacesHTML = '<select name="meetplace-predef" '.$disabled.'>';
		foreach ($places as $place) {
			$meetplacesHTML .= "<option>$place</option>";
		}
		$meetplacesHTML .= '</select>';
		
		$jobplacesHTML = '<select name="jobplace-predef" '.$disabled.'>';
		foreach ($places as $place) {
			$jobplacesHTML .= "<option>$place</option>";
		}
		$jobplacesHTML .= '</select>'; 
	}

	echo '<form action="'.$PHP_SELF.'" method="POST">
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		
		<tr><td>Kontaktperson:</td><td>'.$ownerHTML.'</td></tr>
		<tr><td>Omr�de:</td><td>'.$areasHTML.'</td></tr>
		<tr><td>Overskrift:</td><td><input type="text" name="name" size="64" maxlength="64" '.$disabled.'/> *</td></tr>
		<tr><td>Beskrivelse af opgaven:</td><td><textarea name="description" cols="48" rows="5" '.$disabled.'></textarea> *</td></tr>
		<tr><td>M�dested:</td><td>'.($usePredefPlaces ? $meetplacesHTML.' Hvis andet: ' : '').'<input type="text" name="meetplace" size="25" maxlength="25" '.$disabled.'/> *</td></tr>
		<tr><td>Jobsted:</td><td>'.($usePredefPlaces ? $jobplacesHTML.' Hvis andet: ' : '').'<input type="text" name="jobplace" size="25" maxlength="25" '.$disabled.'/> <span class="help">Udfyldes kun hvis forskelligt fra m�dested.</span></td></tr>
		<tr><td>Bem�rkninger:</td><td><textarea name="notes" cols="48" rows="5" '.$disabled.'>'.$notesExample.'</textarea></td></tr>
		<tr><td>Status:</td><td>'.(user_is_admin() ? $statusHTML : 'Afventer <input type="hidden" name="status" value="W">').'</td></tr>
		'.(user_is_admin() ? '<tr><td>Prioritet:</td><td>'.$priorityHTML.'</td></tr>' : '<input type="hidden" name="priority" value="3">').'
		'.(user_is_admin() || user_is_consultant() ? '<tr><td>Type:</td><td>'.$typeHTML.'</td></tr>' : '<input type="hidden" name="type" value="WN">').'
		<tr><td colspan="2" class="help">* markerer et obligatorisk felt</td></tr>

		<tr><td colspan="2"><input type="submit" value="Opret" '.$disabled.'/></td></tr>
		<input type="hidden" name="action" value="do_create">
		
		</table>
		</form>';
	
	menu_link();
}

function do_create() {
	reject_public_access();
	global $PHP_SELF, $site_id, $siteConfig;

	$meetplace = "";
	if (!empty($_POST['meetplace-predef']) && $_POST['meetplace-predef'] != "Andet") {
		$meetplace = $_POST['meetplace-predef'];
	} else {
		$meetplace = $_POST['meetplace'];
	}
	
	$jobplace = "";
	if (!empty($_POST['jobplace-predef']) && $_POST['jobplace-predef'] != "Andet") {
		$jobplace = $_POST['jobplace-predef'];
	} else {
		$jobplace = $_POST['jobplace'];
	}
	
	$error = "";
	if (empty($_POST['area_id'])) {
		$error .= "Intet omr�de valgt.<br>";
	} 
	if (empty($_POST['owner_id'])) {
		$error .= "Ingen ansvarlig valgt.<br>";
	}
	if (strlen($_POST['name']) < 4) {
		$error .= "Jobnavn skal v�re mindst 4 karakterer.<br>";
	}
	if (strlen($_POST['description']) < 10) {
		$error .= "Jobbeskrivelsen skal v�re mindst 10 karakterer.<br>";
	}
	if (strlen($meetplace) < 2) {
		$error .= "M�dested skal v�re mindst 2 karakterer.<br>";
	}
	if (empty($_POST['status'])) {
		$error .= "Ingen status valgt.<br>";
	}
	if (empty($_POST['priority'])) {
		$error .= "Ingen prioritet valgt.<br>";
	}
	if (!empty($error)) {
		echo print_error($error);
		exit;
	}
	
	//always create NoNeed jobs as approved (consultants cannot choose status)
	if ($_POST['type'] == "NN" && $_POST['status'] = "W") {
		$_POST['status'] = "A";
	}
	
	$job = new Job(null, $site_id, $_POST['area_id'], $_POST['owner_id'], $_POST['name'], $_POST['description'], $meetplace, $jobplace, $_POST['notes'], $_POST['status'], $_POST['priority'], $_POST['type']);

	$jobID = createJob($job);
	
	if ($job->status == "W") {
		$area = getAreaFromId($job->areaID);
		$contact = getUser($area->contactID);
		$subject = "Nyt job afventer din godkendelse";
		$message =	"Hej ".$contact->getFullNameAndLogin()."\r\n".
					"\r\n". 
					"Et nyt jobopslag afventer din godkendelse.\r\n".	
					"\r\n".
					"Jobnavn: ".$job->name."\r\n".
					"Jobansvarlig: ".getUser($job->ownerID)->getFullName()."\r\n".
					"\r\n".
					"Det er din opgave som omr�deansvarlig, at vurdere de enkelte jobs og sortere 'skidt fra kanel', s� ikke jobdatabasen fyldes med jobopslag lavet for sjov. Hvis der er blevet oprettet et jobopslag, som du ikke kan st� inde for, b�r du kontakte den jobansvarlige.\r\n".
					"\r\n".
					"Logind og godkend jobbet, s� hj�lpere kan tilmelde sig det.\r\n";
		notifyUser($contact->login, $subject, $message);
	}
	
	if ($job->type == "NN") {
		$ts = new Timeslot(null, 01012000, 0, 0, $jobID, 0, null);
		createTimeslot($ts);
	}
	
	do_redirect($PHP_SELF.'?action=show_list&user_id='.$_REQUEST['owner_id']);
}

function show_update() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name, $usePredefPlaces;
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
	if (user_is_admin()) {
		$employers = listUsers($site_id, 2);
		$consultants = listUsers($site_id, 4);
		$admins = listUsers($site_id, 1);
		$users = array_merge($employers, $consultants, $admins);
		//sort(&$users);
		
		foreach ($users as $user) {
			$user = User::cast($user);
			$ownerHTML .= '<option value="'.$user->login.'" '.($user->login == $job->ownerID ? "selected" : "").'>'.$user->getFullName().'</option>';
		}
	} else {
		$ownerHTML .= '<option value="'.$login.'">'.getUser($login)->getFullName().'</option>';
	}
	$ownerHTML .= '</select>';
	
	$statusHTML =  '<select name="status">
					<option value="A" '.($job->status=='A' ? 'selected':'').'>'.Job::jobStatus('A').'</option>
					<option value="W" '.($job->status=='W' ? 'selected':'').'>'.Job::jobStatus('W').'</option>
					</select>';
	
	$priorityHTML = '<select name="priority">
					<option '.($job->priority=='1' ? 'selected' : '').'>1</option>
					<option '.($job->priority=='2' ? 'selected' : '').'>2</option>
					<option '.($job->priority=='3' ? 'selected' : '').'>3</option>
					<option '.($job->priority=='4' ? 'selected' : '').'>4</option>
					<option '.($job->priority=='5' ? 'selected' : '').'>5</option>
					</select>';
	
	if ($usePredefPlaces) {
		$places = getPlaces();
		$meetplacesHTML = '<select name="meetplace-predef">';
		foreach ($places as $place) {
			$meetplacesHTML .= "<option>$place</option>";
		}
		$meetplacesHTML .= '</select>'; 
		
		$jobplacesHTML = '<select name="jobplace-predef">';
		foreach ($places as $place) {
			$jobplacesHTML .= "<option>$place</option>";
		}
		$jobplacesHTML .= '</select>'; 
	}

	echo '<h1>Rediger job</h1>
		<table align="center" border="0" cellspacing="3" cellpadding="3">
		<form action="'.$PHP_SELF.'" method="POST">
		
		<tr><td>Kontaktperson:</td><td>'.$ownerHTML.'</td></tr>
		<tr><td>Omr�de:</td><td>'.$areasHTML.'</td></tr>
		<tr><td>Overskrift:</td><td><input type="text" name="name" size="64" maxlength="64" value="'.$job->name.'" /> *</td></tr>
		<tr><td>Beskrivelse af opgaven:</td><td><textarea name="description" cols="48" rows="5">'.$job->description.'</textarea> *</td></tr>
		<tr><td>M�dested:</td><td>'.($usePredefPlaces ? $meetplacesHTML.' Hvis andet: ' : '').'<input type="text" name="meetplace" size="25" maxlength="25" value="'.$job->meetplace.'" /> *</td></tr>
		<tr><td>Jobsted:</td><td>'.($usePredefPlaces ? $jobplacesHTML.' Hvis andet: ' : '').'<input type="text" name="jobplace" size="25" maxlength="25" value="'.$job->jobplace.'" /> <span class="help">Udfyldes kun hvis forskelligt fra m�dested.</span></td></tr>
		<tr><td>Bem�rkninger:</td><td><textarea name="notes" cols="48" rows="5">'.$job->notes.'</textarea></td></tr>
		<tr><td>Status:</td><td>'.(user_is_admin() ? $statusHTML : Job::jobStatus($job->status).'<input type="hidden" name="status" value="'.$job->status.'">' ).'</td></tr>
		'.(user_is_admin() ? '<tr><td>Prioritet:</td><td>'.$priorityHTML.'</td></tr>' : '<input type="hidden" name="priority" value="'.$job->priority.'">').'
		<tr><td>Type:</td><td>'.Job::jobType($job->type).'</td></tr> <input type="hidden" name="type" value="'.$job->type.'">
		<tr><td colspan="2" class="help">* markerer et obligatorisk felt</td></tr>

		<tr><td colspan="2"><input type="submit" value="Opdater"/></td></tr>';
	
	if ($job->type == "WN") {
		echo '<tr><td colspan="2"><a href="jc_timeslot.php?action=show_update&job_id='.$job->id.'">Rediger behov</a></td></tr>';
	}
	
	echo '<input type="hidden" name="action" value="do_update">
		<input type="hidden" name="nextaction" value="'.referer_action().'">
		'.($job->ownerID == $login ? '<input type="hidden" name="user_id" value="'.$login.'">' : '').'
		<input type="hidden" name="job_id" value="'.$job->id.'">
		</form>';
		
		if (user_is_admin() || $user->login == $job->ownerID) {
			echo '<form action="'.$PHP_SELF.'" method="POST" onsubmit="return OkCancel(\'Er du sikker p� du vil slette?\')">			
				<tr><td colspan="2"><br/><br/>Hvis du sletter jobbet, fjernes alle hj�lpernes tilmeldinger til dette job!</td></tr>
				<tr><td colspan="2"><input type="submit" value="Slet"/></td></tr>
				<input type="hidden" name="action" value="do_delete">
				<input type="hidden" name="nextaction" value="'.referer_action().'">
				<input type="hidden" name="job_id" value="'.$job->id.'" />
				</form>';
		}
		echo '</table>';
	menu_link();
}

function do_update() {
	reject_public_access();
	global $PHP_SELF, $site_id;

	$meetplace = "";
	if (!empty($_POST['meetplace-predef']) && $_POST['meetplace-predef'] != "Andet") {
		$meetplace = $_POST['meetplace-predef'];
	} else {
		$meetplace = $_POST['meetplace'];
	}
	
	$jobplace = "";
	if (!empty($_POST['jobplace-predef']) && $_POST['jobplace-predef'] != "Andet") {
		$jobplace = $_POST['jobplace-predef'];
	} else {
		$jobplace = $_POST['jobplace'];
	}
	
	//require_params(array($_REQUEST['job_id'], $_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['meetplace'], $_REQUEST['status'], $_REQUEST['priority']));
	$error = "";
	if (empty($_POST['job_id'])) {
		$error .= "JobID mangler.<br>";
	}
	if (empty($_POST['area_id'])) {
		$error .= "Intet omr�de valgt.<br>";
	} 
	if (empty($_POST['owner_id'])) {
		$error .= "Ingen ansvarlig valgt.<br>";
	}
	if (strlen($_POST['name']) < 4) {
		$error .= "Jobnavn skal v�re mindst 4 karakterer.<br>";
	}
	if (strlen($_POST['description']) < 10) {
		$error .= "Jobbeskrivelsen skal v�re mindst 10 karakterer.<br>";
	}
	if (strlen($meetplace) < 2) {
		$error .= "M�dested skal v�re mindst 2 karakterer.<br>";
	}
	if (empty($_POST['status'])) {
		$error .= "Ingen status valgt.<br>";
	}
	if (empty($_POST['priority'])) {
		$error .= "Ingen prioritet valgt.<br>";
	}
	if (!empty($error)) {
		echo print_error($error);
		exit;
	}
	
	$job = new Job($_REQUEST['job_id'], $site_id, $_REQUEST['area_id'], $_REQUEST['owner_id'], $_REQUEST['name'], $_REQUEST['description'], $meetplace, $jobplace, $_REQUEST['notes'], $_REQUEST['status'], $_REQUEST['priority'], $_REQUEST['type']);

	updateJob($job);
	do_redirect($PHP_SELF.'?action='.$_POST['nextaction'].(!empty($_POST['user_id']) ? '&user_id='.$_POST['user_id'] : ''));
}

function do_approve() {
	reject_public_access();
	global $PHP_SELF, $login;

	if (empty($_GET['job_id'])) {
		echo print_error("JobID mangler");
		exit;
	}

	updateJobStatus($_GET['job_id'], "A");
	do_redirect($PHP_SELF.'?action=show_list&status=W&user_id='.$login);
}

function do_delete() {
	reject_public_access();
	global $PHP_SELF, $login;

	if (empty($_POST['job_id'])) {
		echo print_error("JobID mangler");
		exit;
	}

	$job = getJob($_POST['job_id']);
	if (user_is_admin() || $login == $job->ownerID) {
		deleteJob($_POST['job_id']);
		do_redirect($PHP_SELF.'?action='.$_POST['nextaction']);
	} else {
		echo "Not authorized!";
	}
}

function show_one() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Vis job");

	$job = getJob($_GET['job_id']);
	$job = Job::cast($job);
	print_job_details($job);
	
	menu_link();
}

if ($_REQUEST['action'] == 'show_create') {
	show_create();
} elseif ($_REQUEST['action'] == 'do_create') {
	do_create();
} elseif ($_REQUEST['action'] == 'show_update') {
	show_update();
} elseif ($_REQUEST['action'] == 'do_update') {
	do_update();
} elseif ($_REQUEST['action'] == 'do_approve') {
	do_approve();
} elseif ($_REQUEST['action'] == 'do_delete') {
	do_delete();
} elseif ($_REQUEST['action'] == 'show_list') {
	show_list();
} elseif ($_REQUEST['action'] == 'show_list_noneed') {
	show_list_noneed();
} elseif ($_REQUEST['action'] == 'show_one') {
	show_one();
} else {
	echo 'Error: Page parameter missing!';
}

html_bottom();

?>
