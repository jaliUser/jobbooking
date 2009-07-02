<?php
include_once 'includes/functions.php';
include_once 'includes/dbi4php.php';

include_once 'jc_functions.php';

include_once 'jc_area_func.php';
include_once 'jc_day_func.php';
include_once 'jc_district_func.php';
include_once 'jc_event_func.php';
include_once 'jc_group_func.php';
include_once 'jc_job_func.php';
include_once 'jc_jobcategory_func.php';
include_once 'jc_role_func.php';
include_once 'jc_subcamp_func.php';
include_once 'jc_timeslot_func.php';
include_once 'jc_user_func.php';
include_once 'jc_signup_func.php';

include_once 'includes/classes/Area.php';
include_once 'includes/classes/Day.php';
include_once 'includes/classes/District.php';
include_once 'includes/classes/Event.class';
include_once 'includes/classes/Group.php';
include_once 'includes/classes/Job.php';
include_once 'includes/classes/JobCategory.php';
include_once 'includes/classes/Role.php';
include_once 'includes/classes/Subcamp.php';
include_once 'includes/classes/Timeslot.php';
include_once 'includes/classes/User.php';

//get site id and name
$sql = 'SELECT site.id, site.name FROM site, webcal_user WHERE webcal_user.cal_login=? AND site.id=webcal_user.site_id';
$rows = dbi_get_cached_rows($sql, array($login));
if(count($rows) == 1) {
	$site_id = $rows[0][0];
	$site_name = $rows[0][1];
} else {
	if($login != "__public__") {
		echo "No site found for user '$login'... aborting!";
		exit();		
	}
}

//get user/role object for logged-in-user
$current_user = User::cast(getUser($login)); 
if($login != "__public__") {	
	$current_role = Role::cast(getRole($login));
}

$phpdbiVerbose = true;

?>