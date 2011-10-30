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
function smsPhoneList($phoneArray, $message, $adminEmailCopy = true, $useCcNumbers = false) {
	global $login;
	$site_id = 1; //TODO
	$siteConfig = getSiteConfig($site_id);
	
	$smsEmail = "@smsgw.computopic.dk";
	$numberPrefix = "45";
	$limit160 = true;
	$securityCode = "[SEE2010:42de9b8313162c94]";
	$ccNumbers = array("27284500");
	
	$message = trim($message);
	$message = str_replace("'", "", $message); //remove ' as they will be escaped and string may grow above 160
	if ($limit160) {
		$length = strlen($message);
		if ($length > 160) {
			$message = substr($message, 0, 160);
		}
	}
	
	if ($useCcNumbers) {
		$phoneArray = array_merge($phoneArray, $ccNumbers);
	}
	
	//split multiple numbers per user, separated by , or /
	$explodedPhoneArray = array();
	foreach ($phoneArray as $number) {
		$multiNumbers = explode(",", $number);
		if (count($multiNumbers) > 1) {
			$explodedPhoneArray = array_merge($explodedPhoneArray, $multiNumbers);
			continue;
		} 
		
		$multiNumbers = explode("/", $number);
		if (count($multiNumbers) > 1) {
			$explodedPhoneArray = array_merge($explodedPhoneArray, $multiNumbers);
			continue;
		}
		
		$explodedPhoneArray[] = $number;
	}
	
	$fixedPhoneArray = array();
	foreach ($explodedPhoneArray as $number) {
		$number = str_replace(" ", "", $number);
		$number = str_replace("+", "", $number);
		if (strlen($number) == 8) {
			$fixedPhoneArray[] = $number; //number ok, just add
		} else if (strlen($number) == 10 && substr($number, 0, 2) == $numberPrefix) {
			$fixedPhoneArray[] = substr($number, 2); //strip prefix
		} else {
			//log invalid number
			notifyAdmin("Ugyldigt nummer: $number", "", $siteConfig);
			echo "Ugyldigt nummer: $number"; //debug info for cronjob
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
		}
		
		$sender = getUser($login)->getFullName();
		if (empty($login)) {
			$sender = $_SERVER["REMOTE_ADDR"];
		}
		$emailText = 	"Afsendt:\r\n$succesNumbers\r\n\r\n".
						(!empty($failureNumbers) ? "Fejl:\r\n$failureNumbers\r\n\r\n" : "").
						"Besked:\r\n$message\r\n\r\n".
						"Afsendelse foretaget af: $sender\r\n";
		
		if ($adminEmailCopy) {
			notifyAdmin("SMS afsendelse", $emailText, $siteConfig);
		}
	}
}

//will be called periodically
function sendJobReminders($sms=true, $mail=false) {
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
			$smsText = "Reminder: Du er tilmeldt job $job->id: $job->name,".getTimeTextShort($job, $ts)." ved $job->meetplace. Mvh $siteConfig->siteName";
			
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

//will be called periodically
function sendEvalMailReminders() {
	$site_id = 1; //TODO
	$siteConfig = getSiteConfig($site_id);
	
	$timeslots = listTimeslotsSite($site_id);
	$dateToday = date("Ymd", time());
	$adminEmailText = "";
	$notifiedJobs = array();
	
	foreach ($timeslots as $ts) {
		if ($ts->date == $dateToday) {
			$job = getJob($ts->jobID);
			if (in_array($job->id, $notifiedJobs)) {
				continue;
			}
			
			$notifiedJobs[] = $job->id;
			$user = getUser($job->ownerID);			
			$subject = "Tilbagemelding på job";
			$message = "Hej ".$user->getFullNameAndLogin()."\r\n".
				"\r\n".
				"Du er kontaktperson på job ID $job->id '$job->name', som har nogle tidsperioder i dag.\r\n".
				"\r\n".
				"Husk at registrere din tilbagemelding i Jobdatabasen med hvilke hjælpere, der hhv. mødte op eller udeblev.\r\n".
				"Som beskrevet i den mail der blev sendt til alle arbejdsgivere 4/7-2010, er det vigtigt, at vi får at vide, \r\n".
				"hvor mange af de tilmeldte hjælere, der reelt mødte op!\r\n".
				"\r\n".
				"Link til tilbagemeldingsside:\r\n".
				$siteConfig->config[SiteConfig::$SITE_URL]."/jc_signup.php?action=show_evals&job_id=$job->id\r\n\r\n".
				"Link til tilmeldingliste: \r\n".
				$siteConfig->config[SiteConfig::$SITE_URL]."/jc_signup.php?action=show_list&job_id=$job->id\r\n\r\n".
				"(Du skal være logget ind for at kunne se disse sider)\r\n".
				"\r\n".
				"Print evt. tilbagemeldingssiden, så du kan krydse af, når du står ude på jobbet.\r\n".
				"Det er også en god ide at printe tilmeldingslisten, så du har navn/telefonnummer på dine hjælpere \r\n".
				"og dermed kan komme i kontakt med dem, hvis der skulle blive behov.\r\n".
				"\r\n".
				"Hvis du ikke selv er til stede på jobbet, bedes du videresende denne mail til rette vedkommende \r\n".
				"og give besked om dit brugernavn/kodeord, så han/hun kan indtaste tilbagemeldingen.\r\n".
				"Alternativt kan du i Jobcenteret aflevere en udskrevet tilmeldingsliste med angivelse af fremmødte.\r\n";
			notifyUser($user->login, $subject, $message, $siteConfig);
			
			$adminEmailText .= "$message\r\n--------------------------------------------------\r\n";
		}
	}
	
	notifyAdmin("Reminder på tilbagemeldinger", $adminEmailText, $siteConfig);
}

//will be called periodically
function sendEvalSmsReminders() {
	$site_id = 1; //TODO
	$siteConfig = getSiteConfig($site_id);
	$minutesBefore = 0;
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
	
	foreach ($rows as $row) {
		$phoneArray = array();
		$ts = getTimeslot($row[2]);
		$job = getJob($ts->jobID);
		$user = getUser($job->ownerID);
		
		if (!empty($user->telephone) && $user->noEmail != 1) {
			$phoneArray[0] = $user->telephone;
			$smsText = "Husk tilbagemelding (antal fremmødte) for dit job, #$job->id $job->name,".getTimeTextShort($job, $ts).". Mvh $siteConfig->siteName";
			
			smsPhoneList($phoneArray, $smsText);
		}
	}
}

?>