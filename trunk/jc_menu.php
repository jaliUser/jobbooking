<?php
include_once 'includes/init.php';
include_once 'jc_init.php';

reject_public_access();

html_top("$site_name - Menu");

//dbi_clear_cache(); //DEBUG

echo '
	<h1>'.$site_name.' - Menu</h1>
	<h3>Du er logget ind som: <i>'.$current_user->getFullName().' ('.$login.')</i> - ['.$current_role->name.']</h3>
	<table border="0" cellpadding="2" cellspacing="3" align="left">
	<tr><th align="left">Handling</th><th></th></tr>
	
	'.(user_is_admin() || user_is_employer() || user_is_consultant() ? '<tr><td><a href="jc_job.php?action=show_create">Opret jobopslag</a></td><td class="help"></td></tr>' :'').'
	<tr><td><a href="jc_job.php?action=show_list">Vis alle jobopslag</a></td><td class="help"></td></tr>
	<tr><td><a href="jc_job.php?action=show_list&filter=vacant">Vis ledige jobopslag</a></td><td class="help"></td></tr>
	'.(user_is_arearesponsible() ? '<tr><td><a href="jc_job.php?action=show_list&status=W&user_id='.$login.'">Vis jobopslag der afventer min godkendelse</a></td><td class="help"></td></tr>':'').'
	'.(user_is_admin() ? '<tr><td><a href="jc_job.php?action=show_list&status=W">Vis afventende jobopslag</a></td><td class="help"></td></tr>':'').'
	'.(user_is_admin() || user_is_employer() ? '<tr><td><a href="jc_job.php?action=show_list&user_id='.$login.'">Vis mine jobopslag</a></td><td class="help"></td></tr>' :'').'
	
	'.(user_is_admin() || user_is_helper() ? '<tr><td colspan="2">-</td></tr>
	<tr><td><a href="jc_signup.php?action=show_update&job_id=-1">Redigér mine blokeringer</a></td><td class="help">Perioder hvor du/I ikke kan blive tildelt arbejde</td></tr>
	<tr><td><a href="jc_signup.php?action=show_mine&show_block=1">Vis mine blokeringer</a></td><td class="help"></td></tr>
	<tr><td><a href="jc_signup.php?action=show_mine">Vis mine jobtilmeldinger</a></td><td class="help"></td></tr>
	' :'').'
	
	'.(user_is_admin() || user_is_consultant() ? '<tr><td colspan="2">-</td></tr>
	<tr><td><a href="jc_timeslot.php?action=show_mine&user_id='.$login.'">Vis mine tildelte tidsperioder</a></td><td class="help"></td></tr>
	<tr><td><a href="jc_timeslot.php?action=show_unassigned">Vis ikke-tildelte tidsperioder</a></td><td class="help"></td></tr>
	' :'').'
	
	'.(user_is_admin() ? '<tr><td colspan="2">-</td></tr>' :'').'
	'.(user_is_admin() ? '<tr><td><a href="jc_user.php?action=show_create">Opret bruger</a></td><td class="help"></td></tr>' :'').'
	'.(user_is_admin() ? '<tr><td><a href="jc_user.php?action=show_list">Vis brugere</a></td><td class="help"></td></tr>' :'').'
	
	<tr><td colspan="2">-</td></tr>
	<tr><td><a href="jc_subcamp.php?action=show_list">Vis jobkonsulenter i underlejrene</a></td><td class="help"></td></tr>
	'.(!user_is_helper() ? '<tr><td><a href="jc_area.php?action=show_list">Vis områdeansvarlige</a></td><td class="help"></td></tr>' :'').'
	
	<tr><td colspan="2">-</td></tr>
	<!-- <tr><td><a href="month.php">Kalendervisning</a></td><td class="help"></td></tr> --><!-- goto users startview, e.g. week.php or chosen view -->
	<tr><td><a href="jc_user.php?action=show_update&amp;login='.$login.'">Redigér min profil</a></td><td class="help"></td></tr> 
	<tr><td><a href="login.php?action=logout">Log ud</a></td><td class="help"></td></tr>
	</table>
	';

html_bottom();

?>