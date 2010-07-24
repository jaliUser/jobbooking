<?php
include_once 'includes/dbi4php.php';

//Emaze
//function smsPhoneList($phoneArray, $message) {
//	global $siteConfig;
//	$smsEmail = "sms@emaze.dk";
//	$numberSeparator = ", ";
//	$numberPrefix = "45";
//	$limit160 = false;
//	$ccNumbers = array("27284500");
//	
//	if ($limit160) {
//		$length = strlen($message);
//		if ($length > 160) {
//			$message = substr($message, 0, 160);
//		}
//	}
//	
//	$numberList = "";
//	$mergedArray = array_merge($phoneArray, $ccNumbers);
//	foreach ($mergedArray as $number) {
//		$number = str_replace(" ", "", $number);
//		$number = str_replace("+", "", $number);
//		if (strlen($number) == 8) {
//			$numberList .= $numberPrefix.$number.$numberSeparator;
//		} else if (strlen($number) == 10 && substr($number, 0, 2) == $numberPrefix) {
//			$numberList .= $number.$numberSeparator;
//		} else {
//			//log invalid number
//			notifyUser("tho", "Ugyldigt nummer: $number", "", $siteConfig);
//		}
//	}
//	$numberList = trim($numberList, $numberSeparator);
//	
//	if (strlen($numberList) >= 8) {
//		$headers = get_mail_headers($siteConfig, true); //true=NoAdminCC
//		$sent = mail($smsEmail, $numberList, $message, $headers);
//		if ($sent == true) {
//			notifyAdmin("SMS afsendelse succes", date("H:i:s Y-m-d", mktime())."\r\n\r\n $numberList \r\n\r\n $message \r\n", $siteConfig);
//		} else {
//			notifyAdmin("SMS afsendelse fejlet", date("H:i:s Y-m-d", mktime())."\r\n\r\n $numberList \r\n\r\n $message \r\n", $siteConfig);
//		}
//	}
//}

//Computopic
function smsPhoneList($phoneArray, $message, $adminEmailCopy = true) {
	global $siteConfig;
	$smsEmail = "@smsgw.computopic.dk";
	$numberPrefix = "45";
	$limit160 = true;
	$securityCode = "[SEE2010:42de9b8313162c94]";
	
	$message = trim($message);
	if ($limit160) {
		$length = strlen($message);
		if ($length > 160) {
			$message = substr($message, 0, 160);
		}
	}
	
	$fixedPhoneArray = array();
	foreach ($phoneArray as $number) {
		$number = str_replace(" ", "", $number);
		$number = str_replace("+", "", $number);
		if (strlen($number) == 8) {
			$fixedPhoneArray[] = $number; //number ok, just add
		} else if (strlen($number) == 10 && substr($number, 0, 2) == $numberPrefix) {
			$fixedPhoneArray[] = substr($number, 2); //strip prefix
		} else {
			//log invalid number
			notifyAdmin("Ugyldigt nummer: $number", "", $siteConfig);
		}
	}
	
	if (count($fixedPhoneArray) > 0) {
		//From address will get email if message is too large etc.
//		$headers = get_mail_headers($siteConfig, true); //true=NoAdminCC
		$headers =  "From: SEE2010 Jobcenter (THO) <tho@thodata.dk>\r\n" .
					"X-Mailer: PHP/" . phpversion();
		
		$succesNumbers = "";
		$failureNumbers = "";
		foreach ($fixedPhoneArray as $number) {
			$phoneEmail = $number . $smsEmail;
			$fixedMessage = $message . $securityCode;
			
			$sent = mail($phoneEmail, "SMS fra SEE2010 Jobcenter", $fixedMessage, $headers);
			if ($sent == true) {
				$succesNumbers .= "$number, ";
			} else {
				$failureNumbers .= "$number, ";
			}	
			
			//debug
//			echo "$number: $message<br>\r\n";
		}
		
		if ($adminEmailCopy) {
			$emailText = "Afsendt: $succesNumbers\r\n\r\nFejl: $failureNumbers\r\n\r\nBesked: $message\r\n";
			notifyAdmin("SMS afsendelse", $emailText, $siteConfig);
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
				if (!empty($user->telephone) && $user->noEmail != 1) {
					$phoneArray[$numIdx] = $user->telephone;
					$numIdx++;
				}
			}
			
			$ts = getTimeslot($row[2]);
			$job = getJob($ts->jobID);
			$smsText = "Reminder: Du er tilmeldt job $job->id: '$job->name'".getTimeTextShort($job, $ts)." ved $job->meetplace. Mvh $siteConfig->siteName";
			
			if(count($phoneArray) > 0) {
				smsPhoneList($phoneArray, $smsText);
			}
		}
	}
}

//will be called periodically
function sendNextdayStatus($sms=true, $mail=false) {
	$site_id = 1; //TODO
	$siteConfig = getSiteConfig($site_id);
	
	$timeslots = listTimeslotsSite($site_id);
	$dateTomorrow = date("Ymd", time() + 60*60*24);
	$adminEmailText = "";
	
	foreach ($timeslots as $ts) {
		if ($ts->date == $dateTomorrow) {
			$job = getJob($ts->jobID);
			$user = getUser($job->ownerID);
			
			if ($sms && !empty($user->telephone) && $user->noEmail != 1) {
				$smsText = "Jobstatus: #$job->id $job->name," . getTimeTextShort($job, $ts) . ": Behov $ts->personNeed, rest $ts->remainingNeed. Mvh $siteConfig->siteName";
				$adminEmailText .= "$user->telephone: $smsText\r\n";
				$phoneArray = array();
				$phoneArray[] = $user->telephone;
				
				smsPhoneList($phoneArray, $smsText, false); //false=noAdminCopy, send bulk below
			}
		}
	}
	
	notifyAdmin("Job status i morgen", $adminEmailText, $siteConfig);
}

?>