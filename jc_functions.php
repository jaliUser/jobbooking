<?php

function bool2char($bool) {
	if ($bool == true) {
		return "1";
	} else {
		return "0";
	}
}

function char2bool($char) {
	if ($char == "1") {
		return true;
	} else {
		return false;
	}
}

function checkbox2char($postValue) {
	if (!empty($postValue)) {
		return "1";
	} else {
		return "";
	}
}

function char2checkbox($char) {
	if ($char == "1") {
		return " checked ";
	}
}

function one2x($char) {
	if ($char == "1") {
		return "X";
	}
}

function sortHeader($sort, $header) {
	$url = $_SERVER['REQUEST_URI'];
	//TODO: strip old sort
	if ($_GET['sort'] == $sort) {
		$header = "<span class='redalert'>$header</span>";
	}
	return "<a href=\"$url&sort=$sort\">$header</a>";
}

function referer_action() {
	$actionStart = strpos($_SERVER['HTTP_REFERER'], "action=") + 7;
	$actionEnd = strpos($_SERVER['HTTP_REFERER'], "&", $actionStart);
	if ($actionEnd === false) {
		return substr($_SERVER['HTTP_REFERER'], $actionStart);
	} else {
		$length = $actionEnd - $actionStart;
		return substr($_SERVER['HTTP_REFERER'], $actionStart, $length);
	}
}

function referer_sort() {
	$sortExists = strpos($_SERVER['HTTP_REFERER'], "sort=") !== false;
	$sortStart = strpos($_SERVER['HTTP_REFERER'], "sort=") + 5;
	$sortEnd = strpos($_SERVER['HTTP_REFERER'], "&", $sortStart);
	if (!$sortExists) {
		return "";
	} else if ($sortEnd === false) {
		return substr($_SERVER['HTTP_REFERER'], $sortStart);
	} else {
		$length = $sortEnd - $sortStart;
		return substr($_SERVER['HTTP_REFERER'], $sortStart, $length);
	}
}

function show_user_table($headertext, $link, $users, $lovtype) {
	global $PHP_SELF, $site_id, $login; 
	echo "<hr/><h3>$headertext:</h3>";
	if ($lovtype == "full") {
		$subcamps = listSubcamps($site_id);
		$districts = listDistricts($site_id);
		$groups = listAllGroups($site_id);
		echo '<table align="center" class="border1">
			<tr> <th>Brugernavn</th> <th>Navn</th> <th>E-mail</th> <th>Telefon</th> <th>Gruppe</th> <th>Underlejr</th> </tr>';
		foreach ($users as $user) {
			$user = User::cast($user);
			$role = Role::cast(getRole($user->login));
			$group = $groups[$user->groupID];
			$district = $districts[$group->districtID];
			$subcamp = $subcamps[$district->subcampID];
	
			echo "<tr> 
				<td><a href=\"$link&user_id=$user->login\">$user->login</a></td>
				<td><a href=\"jc_user.php?action=show_one&login=$user->login\">".$user->getFullName()."</a></td>
				<td>$user->email</td>
				<td>$user->telephone</td>
				<td>$group->name</td>
				<td>$subcamp->name</td>
				</tr>";
		}
		echo '</table>';	
	} else {
		$userHTML = "<select name='user_id'>";
		foreach ($users as $user) {
			$userHTML .= "<option value='$user->login'>".$user->getFullName()." [$user->login]</option>";
		}
		$userHTML .= "</select>";
		
		$hiddenFields = "";
		$ampIndex = strpos($link, "?");
		if ($ampIndex > 0) {
			$urlParams = substr($link, $ampIndex+1);
			$paramArray = explode("&", $urlParams);
			foreach ($paramArray as $param) {
				$equalIndex = strpos($param, "=");
				if ($equalIndex > 0 && strlen($param) > $equalIndex+1) {
					$nameValue = explode("=", $param);
					$hiddenFields .= "<input type='hidden' name='$nameValue[0]' value='$nameValue[1]' />";
				}
			}
		}
		
		echo "<div align='center'>
				<form method='get' action='$link'>
					V�lg bruger: $userHTML <input type='submit' value='V�lg' />
					$hiddenFields
				</form>
				<p>eller</p>
				<form method='get' action='$PHP_SELF'>
					<input type=hidden name='lovtype' value='full' />
					<input type=hidden name='user_id' value='$login' />
					<input type='submit' value='Vis fuld brugerliste' />
					$hiddenFields
				</form>
			</div>";
	}
}

function get_mail_headers($siteConfig, $withoutCC = false) {
	$headers =  'From: "'.$siteConfig->config[SiteConfig::$EMAIL_FROM].'" <'.$siteConfig->config[SiteConfig::$EMAIL].'>'. "\r\n" .
				($withoutCC == true ? '' : 'Cc: "'.$siteConfig->config[SiteConfig::$EMAIL_FROM].'" <'.$siteConfig->config[SiteConfig::$EMAIL].'>'. "\r\n") .
    			'X-Mailer: PHP/' . phpversion();
	return $headers;
}

function notifyUser($login, $subject, $message, $siteConfig = null) {
	if ($siteConfig == null) {
		global $siteConfig;
	}
	$user = getUser($login);
	$headers = get_mail_headers($siteConfig, false);
	$message = $message .
				"\r\n".
				"Med venlig hilsen\r\n".
				$siteConfig->siteName."\r\n".
				$siteConfig->config[SiteConfig::$SITE_URL]."\r\n";
	
	if ($user != null && !empty($user->email) && valid_email($user->email)) {
		$to = $user->email;
	} else {
		$to = $siteConfig->config[SiteConfig::$EMAIL];
		$subject = "BRUGER HAR INGEN EMAIL - " . $subject;
		$headers = get_mail_headers($siteConfig, true);
	}
	
	mail($to, $subject, $message, $headers);
}

function notifyAdmin($subject, $message, $siteConfig = null) {
	if ($siteConfig == null) {
		global $siteConfig;
	}
	$to = $siteConfig->config[SiteConfig::$EMAIL];
	
	mail($to, $subject, $message, get_mail_headers($siteConfig, true));
}

function valid_time($hour, $min) {
if ((is_numeric($hour) && $hour >= 0 && $hour <= 23) &&
	(is_numeric($min) && $min >= 0 && $min <= 59)) {
		return true;
	} else {
		return false;
	}
}

function getTimeText($job, $ts) {
	if ($job->type == "WN") {
		return " i tidsperioden ".$ts->getStartHour().":".$ts->getStartMin()."-".$ts->getEndHour().":".$ts->getEndMin()." ".strftime("%a %d/%m-%Y", $ts->getStartTS());
	} else {
		return "";
	}
}

function getTimeTextShort($job, $ts) {
	if ($job->type == "WN") {
		return " kl ".$ts->getStartHour().":".$ts->getStartMin()."-".$ts->getEndHour().":".$ts->getEndMin()." ".strftime("%a %d/%m", $ts->getStartTS());
	} else {
		return "";
	}
}

function get_caltime($hour, $min) {
	if (strlen($min) != 2) {
		$min = "0".$min;
	}
	return $hour.$min."00";
}

function get_caltime_date() {
	return date("His");
}

function get_caldate_date() {
	return date("Ymd");
}

function get_calduration($start_time, $end_time) {
	$tmpdate = 20000101;
	if ($end_time < $start_time) {
		//overnight
		return (get_cal_unixtime($tmpdate+1, $end_time) - get_cal_unixtime($tmpdate, $start_time))/60;
	} else {
		return (get_cal_unixtime($tmpdate, $end_time) - get_cal_unixtime($tmpdate, $start_time))/60;
	}
}

function user_is_admin() {
	global $current_role;
	return $current_role->id == 1;
}

function user_is_employer() {
	global $current_role;
	return $current_role->id == 2;
}

function user_is_helper() {
	global $current_role;
	return $current_role->id == 3;
}

function user_is_consultant() {
	global $current_role;
	return $current_role->id == 4;
}

function user_is_arearesponsible() {
	global $current_role;
	return $current_role->id == 5;
}

function get_cal_unixtime($cal_date, $cal_time) {
	$hour = ($cal_time == 0 || strlen($cal_time) <= 4) ? 0 : substr($cal_time,0,-4);
	$min = ($cal_time == 0) ? 0 : substr($cal_time,-4,-2);
	$sec = ($cal_time == 0) ? 0 : substr($cal_time,-2);
	$month = substr($cal_date,4,2);
	$day = substr($cal_date,6,2);
	$year = substr($cal_date,0,4);
	return gmmktime($hour, $min, $sec, $month, $day, $year);
}

function html_top($title, $refreshInterval = null) {
	global $PHP_SELF, $site_id;
	if (empty($site_id)) {
		echo print_error("SiteID mangler.");
		exit;
	}
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="da" lang="da">
		<head><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
		<link href="jc_style-'.$site_id.'.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="jc_script.js"></script>
		<title>'.$title.'</title>
		<meta http-equiv="Pragma" content="no-cache"/>
		<meta http-equiv="Expires" content="-1"/>';
	if (!empty($refreshInterval)) {
		echo '<meta http-equiv="refresh" content="'.$refreshInterval.'"/> ';
	}
	echo '</head><body>';
	if ($PHP_SELF != "/jc_menu.php") {
		echo '<a href="jc_menu.php">Hovedmenu</a> | <a onclick="javascript:history.back()">Tilbage</a>';
	}
}

function html_bottom() {
	echo '
	<!-- Start of StatCounter Code -->
	<script type="text/javascript">
	var sc_project=5386328; 
	var sc_invisible=1; 
	var sc_partition=49; 
	var sc_click_stat=1; 
	var sc_security="7db961e6"; 
	</script>
	
	<script type="text/javascript"
	src="http://www.statcounter.com/counter/counter.js"></script><noscript><div
	class="statcounter"><a title="wordpress visitor counter"
	href="http://www.statcounter.com/wordpress.com/"
	target="_blank"><img class="statcounter"
	src="http://c.statcounter.com/5386328/0/7db961e6/1/"
	alt="wordpress visitor counter" ></a></div></noscript>
	<!-- End of StatCounter Code -->
	</body></html>';
}

function menu_link() {
	echo '<br/><a href="jc_menu.php">Hovedmenu</a> | <a onclick="javascript:history.back()">Tilbage</a>';
}

function back_link() {
	return '<input type="button" value="Tilbage" onclick="javascript:history.back()"/>';
}

function reject_public_access() {
	global $login;
	if ($login == '__public__') {
		do_redirect('login.php');
	}
}

### GENERAL FUNCTIONS ###

function vertical($text) {
	if (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE") === false) {
		$result = "<div align=\"center\">";
		$chars = str_split($text);
		foreach ($chars as $char) {
			$result .= $char."<br/>";
		}
		$result .= "</div>";
		return $result;
	} else {
		return "<span style=\"writing-mode: tb-rl; filter: flipV flipH;\">$text</span>";
	}
}

function sqlNULL($obj) {
	if($obj != null) {
		return $obj;
	}
	return "NULL";
}

function DBint($val) {
	if (is_numeric($val)) {
		return $val;
	} else {
		return null;
	}
}

function vname(&$var, $scope=false, $prefix='unique', $suffix='value') {
    if($scope) $vals = $scope;
    else      $vals = $GLOBALS;
    $old = $var;
    $var = $new = $prefix.rand().$suffix;
    $vname = FALSE;
    foreach($vals as $key => $val) {
      if($val === $new) $vname = $key;
    }
    $var = $old;
    return $vname;
}

function require_params($params) {
	for ($i = 0; $i < sizeof($params); $i++) {
		$p = $params[$i];
		if (empty($p)) {
			$vname = vname($p);
			echo '<b>Error:</b> Parameter missing in function: # '.$i.$vname;
			exit();
		}
	}
}

function nonempty_params($params) {
	for ($i = 0; $i < sizeof($params); $i++) {
		if (empty($params[$i])) {
			return false;
		}
	}
	return true;
}

function select_day($day) {
	if (empty($day)) {
		$day = date("d",time());
	}
	$ret = '';
	for ($i = 1; $i <= 31; $i++) {
		$ret .= '<option'.($day == $i ? ' selected' : '').'>'. (strlen($i)==1 ? '0'.$i : $i) .'</option>'."\n";
	}
	return $ret;
}

function select_month($month) {
	if (empty($month)) {
		$month = date("m",time());
	}
	$text[1] = 'Jan';
	$text[2] = 'Feb';
	$text[3] = 'Mar';
	$text[4] = 'Apr';
	$text[5] = 'Maj';
	$text[6] = 'Jun';
	$text[7] = 'Jul';
	$text[8] = 'Aug';
	$text[9] = 'Sep';
	$text[10] = 'Okt';
	$text[11] = 'Nov';
	$text[12] = 'Dec';
	$ret = '';
	for ($i = 1; $i <= 12; $i++) {
		$ret .= '<option value="'.(strlen($i)==1 ? '0'.$i : $i).'" '.($month == $i ? ' selected' : '').'>'. $text[$i] .'</option>'."\n";
	}
	return $ret;
}

function select_year($year) {
	if (empty($year)) {
		$year = date("Y",time());
	}
	$ret = '';
	for ($i = date("Y",time()), $j = $i+5; $i <= $j; $i++) {
		$ret .= '<option'.($year == $i ? ' selected' : '').'>'. $i .'</option>'."\n";
	}
	return $ret;
}

function valid_email($email) {
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}

?>
