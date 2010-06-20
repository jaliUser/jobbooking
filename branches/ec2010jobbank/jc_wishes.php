<?php
include_once 'includes/init.php';
include_once 'jc_init.php';
reject_public_access();

function show_update() {
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Ledighedsperioder");
	
	$user = getUser(!empty($_GET['user_id']) ? $_GET['user_id'] : $login);
	$job = getJob(-2);
	$timeslots = listTimeslotWishes($user->login);
	$days = listDays($site_id);
	
	$daysHTML = '<select name="date">';
	foreach ($days as $day) {
		$day = Day::cast($day);
		$daysHTML .= '<option value="'.$day->getDateYMD().'">'.strftime("%d/%m %a",$day->getDateTS()).'</option>';
	}
	$daysHTML .= '</select>';
	
	echo '<h1>Ledighedsperioder for <i><a href="jc_user.php?action=show_one&login='.$user->login.'">'.$user->getFullName().'</a></i> ('.$user->count.' pers.)</h1>';
	echo '<table align="center" class="border1">
			<form action="'.$PHP_SELF.'" method="POST">
			<tr><th>Dato</th><th>Tidsperiode</th><th>Antal</th><th></th></tr>';

	foreach ($timeslots as $timeslot) {
		$timeslot = Timeslot::cast($timeslot);
		echo '<tr>
				<td>'.date("d/m", $timeslot->getStartTS()).'</td>
				<td>'.date("H:i", $timeslot->getStartTS()).date(" - H:i", $timeslot->getEndTS()).'</td>
				<td><input type="text" name="timeslot-'.$timeslot->id.'" value="'.$timeslot->personNeed.'" size="1" maxlength="2"/></td>
				<td><a href="'.$PHP_SELF.'?action=do_delete&cal_id='.$timeslot->id.'&user_id='.$user->login.'">Slet</a></td>
			</tr>';
	}		
	echo '  <tr><td colspan="4"><input type="submit" value="Opdatér"/></td></tr>
			<input type="hidden" name="action" value="do_update"/>
			<input type="hidden" name="user_id" value="'.$user->login.'"/>
			</form></table><p>';
	
	echo '<table align="center" class="border1">
			<form action="'.$PHP_SELF.'" method="POST">
			<tr><th colspan="2">Opret ny ledighedsperiode</th></tr>
			<tr><td>Dato:</td><td>'.$daysHTML.'</td></tr>
			<tr><tr><td>Tidsperiode:</td>
					<td><input type="text" name="start_hour" size="1" maxlength="2" value="00" /> :
					<input type="text" name="start_min" size="1" maxlength="2" value="00" /> - 
					<input type="text" name="end_hour" size="1" maxlength="2" value="00" /> :
					<input type="text" name="end_min" size="1" maxlength="2" value="00" /></td></tr>
			<tr><tr><td>Antal:</td><td><input type="text" name="count" size="1" maxlength="2" /></td></tr>
			<tr><td colspan="3"><input type="submit" value="Opret"/></td></tr>
			<input type="hidden" name="user_id" value="'.$user->login.'"/>
			<input type="hidden" name="action" value="do_create"/>
			</form></table>';
	
	// show user list for admins
	if (user_is_admin()) {
		show_user_table("Vælg bruger der skal vises ledighedsperioder for", "$PHP_SELF?action=show_update", listUsers($site_id, 3));
	}
	
	menu_link();
}

function do_create() {
	global $PHP_SELF, $login;
	
	$start_hour = $_POST['start_hour'];
	$start_min = $_POST['start_min'];
	$end_hour = $_POST['end_hour'];
	$end_min = $_POST['end_min'];
	if (!valid_time($start_hour, $start_min) || !valid_time($end_hour, $end_min)) {
		echo print_error("Ugyldig tidsperiode!");
		exit;
	}
		
	$start_caltime = get_caltime($start_hour, $start_min);
	$end_caltime = get_caltime($end_hour, $end_min);
	$duration = get_calduration($start_caltime, $end_caltime);

	$timeslot = new Timeslot(null, $_POST['date'], $start_caltime, $duration, -2, $_POST['count'], $_POST['user_id']);
	if (empty($timeslot->personNeed) || !Timeslot::isValidPersonNeed($timeslot->personNeed)) {
		echo print_error('Antal er ikke et gyldigt tal!');
		exit;	
	}
	if (existTimeslot($timeslot)) {
		echo print_error('Der findes allerede tilsvarende ledighedsperiode!<br>
						Redigér eksisterende ledighedsperiode i stedet for at oprette en ny.');
		exit;
	}
	
	createTimeslot($timeslot);
	
	do_redirect($PHP_SELF.'?action=show_update&user_id='.$_POST['user_id']);
}

function do_delete() {
	global $PHP_SELF;
		
	deleteTimeslot($_GET['cal_id']);
	
	do_redirect($PHP_SELF.'?action=show_update&user_id='.$_GET['user_id']);
}

function show_list() {
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top($site_name . " - Ledighedsperioder");
	
	$start_hour = (!empty($_POST['start_hour']) ? $_POST['start_hour'] : '01');
	$start_min = (!empty($_POST['start_min']) ? $_POST['start_min'] : '00');
	$end_hour = (!empty($_POST['end_hour']) ? $_POST['end_hour'] : '23');
	$end_min = (!empty($_POST['end_min']) ? $_POST['end_min'] : '00');
	if (!valid_time($start_hour, $start_min) || !valid_time($end_hour, $end_min)) {
		echo print_error("Ugyldig tidsperiode!");
		exit;
	}
	
	$start_caltime = get_caltime($start_hour, $start_min);
	$end_caltime = get_caltime($end_hour, $end_min);
	$duration = get_calduration($start_caltime, $end_caltime);
	
	$days = listDays($site_id);
	$daysHTMLfrom = '<select name="start_date">';
	foreach ($days as $day) {
		$day = Day::cast($day);
		$daysHTMLfrom .= '<option value="'.$day->getDateYMD().'" '.($_POST['start_date'] == $day->getDateYMD() ? 'selected':'').'>'.strftime("%d/%m %A",$day->getDateTS()).'</option>';
	}
	$daysHTMLfrom .= '</select>';
	
	$daysHTMLto = '<select name="end_date">';
	foreach ($days as $day) {
		$day = Day::cast($day);
		$daysHTMLto .= '<option value="'.$day->getDateYMD().'" '.($_POST['end_date'] == $day->getDateYMD() ? 'selected':'').'>'.strftime("%d/%m %A",$day->getDateTS()).'</option>';
	}
	$daysHTMLto .= '</select>';
	
	echo '<h1>Ledighedsperioder for hjælpere</h1>';
//	echo '<table align="center" border="0">
//		<form action="" method="POST">
//		<tr><td>Fra dato:</td><td>'.$daysHTMLfrom.'</td></tr>
//		<tr><td>Fra tid:</td><td><input type="text" name="start_hour" size="1" maxlength="2" value="'.$start_hour.'" /> :
//								 <input type="text" name="start_min" size="1" maxlength="2" value="'.$start_min.'" /></td></tr>
//		<tr><td>Til dato:</td><td>'.$daysHTMLto.'</td></tr>
//		<tr><td>Til tid:</td><td><input type="text" name="end_hour" size="1" maxlength="2" value="'.$end_hour.'" /> :
//								 <input type="text" name="end_min" size="1" maxlength="2" value="'.$end_min.'" /></td></tr>
//		
//		<tr><td colspan="3"><input type="submit" value="Søg"/></td></tr>
//		<input type="hidden" name="action" value="show_list"/>
//		</form>
//		</table><p>';
	
	$job = getJob(-2);
//	$timeslots = listTimeslotWishesInPeriod($site_id, $_POST['start_date'], $start_caltime, $_POST['end_date'], $end_caltime);
	$timeslots = listTimeslotWishesForSite($site_id);
	
	echo '<table align="center" class="border1">
			<tr> <th>Navn</th> <th>Fra</th> <th>Til</th><th>Antal</th> </tr>';
	foreach ($timeslots as $timeslot) {
		$timeslot = Timeslot::cast($timeslot);
		$user = getUser($timeslot->contactID);
		echo '<tr>
				<td><a href="jc_user.php?action=show_one&login='.$user->login.'">'.$user->getFullName().'</a></td>
				<td>'.strftime("%d/%m %H:%M", $timeslot->getStartTS()).'</td>
				<td>'.strftime("%d/%m %H:%M", $timeslot->getEndTS()).'</td>
				<td>'.$timeslot->personNeed.'</td>
			</tr>';
	}
	
	echo '</table>';
	
	menu_link();
}

function do_update() {
	global $PHP_SELF, $site_id;
	$days = listDays($site_id);
	$firstDay = Day::cast($days[0]);
	$lastDay = Day::cast($days[count($days)-1]);
	$timeslots = listTimeslotWishes($_POST['user_id']);
	// no validation, just remove person_need if non-numeric or negative
	foreach ($timeslots as $ts) {
		$ts = Timeslot::cast($ts);
		if (!Timeslot::isValidPersonNeed($_POST['timeslot-'.$ts->id])) {
			echo print_error('Behovet for '.$day->date.' er ikke et gyldigt tal!');
			exit;	
		}
		if ($ts->date == $firstDay->getDateYMD() && $_POST['timeslot-'.$ts->id] > 0 && $ts->startTime < $firstDay->time) {
			echo print_error('Starttidspunktet for '.$ts->date.' '.$ts->getStartHour().':'.$ts->getStartMin().' ligger før det tidligst mulige.');
			exit;
		}
		if ($ts->date == $lastDay->getDateYMD() && $_POST['timeslot-'.$ts->id] > 0 && $ts->getEndTime() > $lastDay->time) {
			echo print_error('Sluttidspunktet for '.$ts->date.' '.$ts->getEndHour().':'.$ts->getEndMin().' ligger efter det senest mulige.');
			exit;
		}
		updateTimeslotWishes($ts->id, $_POST['timeslot-'.$ts->id]);
	}
	do_redirect($PHP_SELF.'?action=show_update&user_id='.$_POST['user_id']);
}

if ($_REQUEST['action'] == 'show_update') {
	show_update();
} elseif ($_REQUEST['action'] == 'do_create') {
	do_create();
} elseif ($_REQUEST['action'] == 'do_update') {
	do_update();
} elseif ($_REQUEST['action'] == 'do_delete') {
	do_delete();
} elseif ($_REQUEST['action'] == 'show_list') {
	show_list();
} else {
	echo 'Error: Page parameter missing!'.$_POST['action'];
}

html_bottom();

?>