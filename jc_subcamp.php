<?php
include_once 'includes/init.php';
include_once 'jc_init.php';

//use reject_public_access() for all functions, except show_create() and do_create()

function show_list() {
	reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top("$site_name - Underlejre");

	$subcamps = listSubcamps($site_id);
	echo '<h1>Underlejre</h1>
		<table align="center" border="1">
		<tr> <th>Underlejr</th> <th></th> <th>Jobkonsulent</th> <th>Telefon</th> <th>E-mail</th></tr>';
	foreach ($subcamps as $subcamp) {
		$subcamp = Subcamp::cast($subcamp);
		$user = getUser($subcamp->contactID);
		
		echo "<tr> 
			<td>$subcamp->name</td>
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