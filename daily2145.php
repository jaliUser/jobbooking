<?php
include_once 'includes/init.php';
include_once 'jc_init.php';

$site_id = 1;

mail("27284500@smsgw.computopic.dk", "Tak", "Start sending...");
$phoneArray = array();
$users = listUsersWithSignupInfo($site_id);
foreach ($users as $user) {
	if ($user->signups > 0 && !empty($user->telephone) && 
		$user->telephone != "00000000" && $user->telephone != "11111111" && $user->telephone != "12345678") 
	{	
		$phoneArray[] = $user->telephone;
	}
}
mail("27284500@smsgw.computopic.dk", "Tak", "Finished sending...");

$message = "Hej hj�lpere. Jobcenteret siger tak for hj�lpen til dig/dit hold. Uden din/jeres hj�lp kunne spejderne ikke have f�et de samme oplevelser! Kom godt hjem :)";

smsPhoneList($phoneArray, $message, true, false);

//$numbers = "";
//foreach ($phoneArray as $number) {
//	$numbers .= "$number, ";
//}
//echo "$numbers --- $message";

?>