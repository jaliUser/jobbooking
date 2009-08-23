<?php

function valid_time($hour, $min) {
if ((is_numeric($hour) && $hour >= 0 && $hour <= 23) &&
	(is_numeric($min) && $min >= 0 && $min <= 59)) {
		return true;
	} else {
		return false;
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
	return (get_cal_unixtime('20000101', $end_time) - get_cal_unixtime('20000101', $start_time))/60;
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

function user_is_subcampcontact() {
	global $current_role;
	return $current_role->id == 4;
}

function get_cal_unixtime($cal_date, $cal_time) {
	$hour = ($cal_time == 0) ? 0 : substr($cal_time,0,-4);
	$min = ($cal_time == 0) ? 0 : substr($cal_time,-4,-2);
	$sec = ($cal_time == 0) ? 0 : substr($cal_time,-2);
	$month = substr($cal_date,4,2);
	$day = substr($cal_date,6,2);
	$year = substr($cal_date,0,4);
	return gmmktime($hour, $min, $sec, $month, $day, $year);
}

function html_top($title) {
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'.
		'<html><head><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>'.
		'<link href="jc_style.css" rel="stylesheet" type="text/css"/>'.
		'<script type="text/javascript" src="jc_script.js"></script>'.
		'<title>'.$title.'</title>'.
		'</head><body>';
}

function html_bottom() {
	echo '</body></html>';
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
