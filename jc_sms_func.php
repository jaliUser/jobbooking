<?php
include_once 'includes/dbi4php.php';

function smsPhoneList($phoneArray, $message) {
	global $siteConfig;
	$smsEmail = "sms@emaze.dk";
	$numberSeparator = ", ";
	$numberPrefix = "45";
	$limit160 = false;
	
	if ($limit160) {
		$length = strlen($message);
		if ($length > 160) {
			$message = substr($message, 0, 160);
		}
	}
	
	$numberList = "";
	foreach ($phoneArray as $number) {
		$number = str_replace(" ", "", $number);
		$number = str_replace("+", "", $number);
		if (strlen($number) == 8) {
			$numberList .= $numberPrefix.$number.$numberSeparator;
		} else if (strlen($number) == 10 && substr($number, 0, 2) == $numberPrefix) {
			$numberList .= $number.$numberSeparator;
		} else {
			//log invalid number
			notifyUser("tho", "Invalid phone number: $number", "");
		}
	}
	$numberList = trim($numberList, $numberSeparator);
	
	if (strlen($numberList) >= 8) {
		$headers = get_mail_headers($siteConfig, true); //true=NoAdminCC
		$sent = mail($smsEmail, $numberList, $message, $headers);
		if ($sent == true) {
//			notifyAdmin("SMS afsendelse succes", "$numberList\r\n\r\n$message\r\n");
			notifyUser("tho", "SMS afsendelse succes", "$numberList\r\n\r\n$message\r\n");
		} else {
//			notifyAdmin("SMS afsendelse fejlet", "$numberList\r\n\r\n$message\r\n");
			notifyUser("tho", "SMS afsendelse fejlet", "$numberList\r\n\r\n$message\r\n");
		}
	}
}

//will be called periodically
function sendReminders($sms=true, $mail=false) {
	$site_id = 1; //TODO
	$siteConfig = getSiteConfig($site_id);
	$minutesBefore = 60;
	$checkInterval = 15;
	
	//assume method is called 'on minute' (00/15/30/45) and set 00 as seconds
	$startFrameDate = date("Ymd", mktime() + $minutesBefore*60); //insecurity around midnight???
	$startFrameTime = date("Hi00", mktime() + $minutesBefore*60);
	$endFrameTime = date("Hi00", mktime() + $minutesBefore*60 + ($checkInterval-1)*60);

	//timeslots with starttime between startFrameTime (not including) and endFrameTime (including)
	$sql = "SELECT job.id, job.name, cal_id, cal_date, cal_time, cal_duration FROM webcal_entry
			LEFT JOIN job ON job.id=webcal_entry.job_id
			WHERE job_id > 0 AND person_need > 0
			AND cal_date = ? AND cal_time >= ? AND cal_time <= ?
			ORDER BY cal_date, cal_time";
	$rows = dbi_get_cached_rows($sql, array($startFrameDate, $startFrameTime, $endFrameTime));
	
	if ($sms) {
		foreach ($rows as $row) {
			$numIdx = 0;
			$phoneArray = array();
			$signups = listTimeslotSignups($row[2]);
			foreach ($signups as $signup) {
				$user = getUser($signup->userID);
				if (!empty($user->telephone)) {
					$phoneArray[$numIdx] = $user->telephone;
					$numIdx++;
				}
			}
			
			$ts = getTimeslot($row[2]);
			$job = getJob($ts->jobID);
			$smsText = "Hej, hermed en reminder om, at du er tilmeldt job $job->id: '$job->name'".getTimeText($job, $ts).". Mvh $siteConfig->siteName";
			
			smsPhoneList($phoneArray, $smsText);
		}
	}
}

?>