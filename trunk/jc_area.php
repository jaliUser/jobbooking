<?php
include_once 'includes/init.php';
include_once 'jc_init.php';

function show_list() {
	//reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top("$site_name - Områdeansvarlige");

	$areas = listAreas($site_id);
	echo '<h1>Områdeansvarlige</h1>
		<table align="center" class="border1">
		<tr> <th>Område</th> <th></th> <th>Ansvarlig</th> <th>Telefon</th> <th>E-mail</th></tr>';
	foreach ($areas as $area) {
		$area = Area::cast($area);
		$user = getUser($area->contactID);
		
		echo "<tr> 
			<td>$area->description ($area->name)</td>
			<td></td>
			<td>".$user->getFullName()."</td>
			<td>".$user->telephone."</td>
			<td>".$user->email."</td>
			</tr>";
	}
	echo '</table>';
	menu_link();
}

if ($_REQUEST['action'] == 'show_list') {
	show_list();
} else {
	echo 'Error: Page parameter missing!';
}

html_bottom();

?>