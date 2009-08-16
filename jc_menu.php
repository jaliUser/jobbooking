<?php
include_once 'includes/init.php';
include_once 'jc_init.php';

reject_public_access();

html_top("$site_name - Menu");

dbi_clear_cache(); //DEBUG

echo '
	<h1>'.$site_name.' - Menu</h1>
	<h3>Du er logget ind som: <i>'.$current_user->getFullName().' ('.$login.')</i> - ['.$current_role->name.']</h3>
	<table border="0" cellpadding="2" cellspacing="3" align="left">
	'.($current_role->id == 1 ? '' :'').'
	<tr><th>Handlinger:</th></tr>
	
	'.($current_role->id != 3 ? '<tr><td><a href="jc_job.php?action=show_create">Opret job</a></td></tr>' :'').'
	<tr><td><a href="jc_job.php?action=show_list">Vis alle jobopslag</a></td></tr>
	<tr><td><a href="jc_job.php?action=show_list&filter=vacant">Vis ledige jobopslag</a></td></tr>
	<tr><td><a href="jc_job.php?action=show_list&filter=mine">Vis mine jobopslag</a></td></tr>
	
	<tr><td>-</td></tr>
	<tr><td><a href="jc_signup.php?action=show_mine">Vis mine jobtilmeldinger</a></td></tr>
	
	'.($current_role->id == 1 ? '<tr><td>-</td></tr>' :'').'
	'.($current_role->id == 1 ? '<tr><td><a href="jc_user.php?action=show_create">Opret bruger</a></td></tr>' :'').'
	'.($current_role->id == 1 ? '<tr><td><a href="jc_user.php?action=show_list">Vis brugere</a></td></tr>' :'').'
	
	<tr><td>-</td></tr>
	<tr><td><a href="jc_subcamp.php?action=show_list">Vis jobkonsulenter i underlejrene</a></td></tr>
	<tr><td>-</td></tr>
	<!-- <tr><td><a href="month.php">Kalendervisning</a></td></tr> --><!-- goto users startview, e.g. week.php or chosen view -->
	<tr><td><a href="jc_user.php?action=show_update&amp;login='.$login.'">Rediger egen bruger</a></td></tr> 
	<tr><td><a href="login.php?action=logout">Log ud</a></td></tr>
	</table>
	';

html_bottom();

?>