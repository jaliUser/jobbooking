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

function show_update() {
	//reject_public_access();
	global $PHP_SELF, $login, $site_id, $site_name;
	html_top("$site_name - Rediger områder");

	$areaResponsibles = listUsers(1, 5);
	$admins = listUsers(1, 1);
	$users = array_merge($areaResponsibles, $admins);
	
	$areas = listAreas($site_id);
	echo '<h1>Rediger områder</h1>
		<form action="'.$PHP_SELF.'" method="POST">';
	
	if (!empty($_GET['updated'])) {
		$updArea = getAreaFromId($_GET['updated']);
		echo "<p align='center' class='redalert'>$updArea->name er opdateret.</p>";
	}
	
	echo '<table align="center" class="border1">
		<tr>
			<th>Navn</th>
			<th>Beskrivelse</th>
			<th>Ansvarlig</th>
			<th><i>Handlinger</i></th>
		</tr>';
	
	foreach ($areas as $area) {
		$area = Area::cast($area);
		
		$contactOptionsHTML = "";
		foreach ($users as $user) {
			$selected = "";
			if ($user->login == $area->contactID) {
				$selected = "selected";
			}
			$contactOptionsHTML .= "<option value='$user->login' $selected>".$user->getFullName()."</option>";
		}
		$contactsHTML = "<select name='contact-$area->id'>$contactOptionsHTML</select>";
		
		echo "<tr> 
			<td><input name='name-$area->id' type='text' size='10' maxlength='64' value='$area->name'/></td>
			<td><input name='description-$area->id' type='text' size='20' maxlength='255' value='$area->description'/></td>
			<td>$contactsHTML</td>
			<td><input name='update-$area->id' type='submit' value='Opdater'/>";
		if (!isAreaUsed($area->id)) {
			echo " <input name='delete-$area->id' type='submit' value='Slet'/>";
		}
		echo "</td>
			</tr>";
	}
	
	//Create new
	$contactsHTML = "<select name='contact'>$contactOptionsHTML</select>";
	echo '<tr><td colspan="4">&nbsp;</td></tr>
		<tr><th colspan="4">Opret nyt område</td></tr>
		<tr> 
			<td><input name="name" type="text" size="10" maxlength="64"/></td>
			<td><input name="description" type="text" size="20" maxlength="255"/></td>
			<td>'.$contactsHTML.'</td>
			<td><input name="create" type="submit" value="Opret"/></td>
			</tr>
		</table>
		<input name="action" type="hidden" value="do_update"/>
		</form>';
	menu_link();
}

function do_update() {
	reject_public_access();
	global $PHP_SELF, $site_id, $siteConfig;
	
	$updated = "";
	if (!empty($_POST['create'])) {
		//create
		$error = "";
		if (empty($_POST['name'])) {
			$error .= "Navn mangler.<br>";
		} 
		if (empty($_POST['description'])) {
			$error .= "Beskrivelse mangler.<br>";
		}
		if (!empty($error)) {
			echo print_error($error);
			exit;
		}
		
		$area = new Area(null, $site_id, $_POST['name'], $_POST['description'], $_POST['contact']);
		createArea($area);
	} else {
		$areas = listAreas($site_id);
		foreach ($areas as $area) {
			if (!empty($_POST['update-'.$area->id])) {
				//update
				$error = "";
				if (empty($_POST['name-'.$area->id])) {
					$error .= "Navn mangler.<br>";
				} 
				if (empty($_POST['description-'.$area->id])) {
					$error .= "Beskrivelse mangler.<br>";
				}
				if (!empty($error)) {
					echo print_error($error);
					exit;
				}
				
				$area = new Area($area->id, $site_id, $_POST['name-'.$area->id], $_POST['description-'.$area->id], $_POST['contact-'.$area->id]);
				updateArea($area);
				$updated = "&updated=$area->id";
				break;
			} else if (!empty($_POST['delete-'.$area->id])) {
				//delete
				deleteArea($area);
				break;
			}
		}
	}
	
	do_redirect("$PHP_SELF?action=show_update$updated");
}

if ($_REQUEST['action'] == 'show_list') {
	show_list();
} else if ($_REQUEST['action'] == 'show_update') {
	show_update();
} else if ($_REQUEST['action'] == 'do_update') {
	do_update();
} else {
	echo 'Error: Page parameter missing!';
}

html_bottom();

?>