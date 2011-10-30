<?php
include_once 'includes/init.php';
include_once 'jc_init.php';
include_once 'includes/dbi4php.php';

dbi_clear_cache();

$sqlUsers = 'select group_id, cal_title, notes from webcal_user';
$rowsUsers = dbi_get_cached_rows($sqlUsers);

$sqlLedere = "select gruppenr, fornavn, efternavn, email, mobiltlf, telefon, funktion, enhedsnavn, gruppe
			from import_enhedsledere el
			left join webcal_user u on u.group_id=el.gruppenr
			where `Enhedstype`='Rovere' and deltager=1 
			group by el.gruppenr
			order by funktion desc";
$rowsLedere = dbi_get_cached_rows($sqlLedere);

foreach ($rowsUsers as $user) {
	echo "<html>";

	foreach ($rowsLedere as $leder) {
		if ($user[0] == $leder[0]) {
			$sqlUpdate = "update webcal_user set cal_firstname=?, cal_lastname=?, cal_email=?, cal_telephone=?, cal_title=?, notes=? where group_id=?";
			$tlf = (empty($leder[4]) ? $leder[5] : $leder[4]);
			
			if (!empty($user[1])) {
				if ($leder[7] != "Rovere") {
					$title = "$user[1] + $leder[7]";
				} else {
					$title = $user[1];
				}
			} else {
				if ($leder[7] != "Rovere") {
					$title = "$leder[7]";
				} else {
					$title = "";
				}
			}
						
			if (!empty($user[2])) {
				$notes = "F: $user[2] og $leder[6]";
			} else {
				$notes = "F: $leder[6]";
			}
			
			dbi_execute($sqlUpdate, array($leder[1], $leder[2], $leder[3], $tlf, $title, $notes, $user[0]));
//			echo "<p>updater $user[0] med <br>$leder[1], <br>$leder[2], <br>$leder[3], <br>$tlf, <br>klan=$title, <br>funktion/noter=$notes </p>";
		}
	}
}


?>