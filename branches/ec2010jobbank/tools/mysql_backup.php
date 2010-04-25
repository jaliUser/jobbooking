#!/usr/local/bin/php -q
<?php

/**
 * @name mysql_backup
 * @author Henrik Jepsen <hekjje@gmail.com>
 */

set_time_limit(0); //  that shouldnt HANG!

/**
 * Oplysninger om databasen
 */
$DB_HOST[0] = "localhost";
$DB_USERNAME[0] = "see2010jobcenter";
$DB_PASSWORD[0] = "";
$DB_NAME[0] = "dbsee2010jobcenter"; 

//$DB_HOST[1] = "";
//$DB_USERNAME[1] = "";
//$DB_PASSWORD[1] = "";
//$DB_NAME[1] = "";

/**
 * Oplysninger om ftp
 */
$FTP_REMOTE = "home.thodata.dk";
$FTP_LOGIN  = "jc_backup";
$FTP_PASSWORD = "spejder";
$FTP_PATH = "/jc_backup/"; //Tilføj evt. en mappe /backup/

/**
 * Sti til lokal backup, det er altid rart at have en lige ved hånden
 * Skrives som: /home/webroot/mappe/ eller hvad der passer
 */

$LOCAL_DUMP_PATH = "/srv/webhotel/see2010jobcenter/tmp-back/";

/**
 * For hver database, lav dump og upload via ftp 
 */
for ($i=0; $i < count($DB_HOST); $i++) {
	// Laver filnavn
	date_default_timezone_set('Europe/Copenhagen');
	$tid = date('YmdHis', time());
	$filename = $DB_NAME[$i].$tid.".sql";
	 
	//  Laver MySQL dump kald
	$dump_cmd = "mysqldump -h$DB_HOST[$i] -u$DB_USERNAME[$i] -p$DB_PASSWORD[$i]";
	$dump_cmd .= " $DB_NAME[$i]";
	$dump_cmd .= " > $LOCAL_DUMP_PATH$filename";
	
	//Køre MySQL dump
	exec($dump_cmd);
	
	// Forbinder til FTP server
	$conn_id = ftp_connect($FTP_REMOTE);
	
	//Logger ind på FTP server
	$login_result = ftp_login($conn_id, $FTP_LOGIN, $FTP_PASSWORD);
	
	//Uploader MySQl dump til FTP server
	if ((!$conn_id) || (!$login_result)) {
	    echo "The connection to $FTP_REMOTE failed !\r\n";
	    exit;
	} else {
	    echo "Connected on $FTP_REMOTE with user $FTP_LOGIN\r\n";
	    
	    if (ftp_put($conn_id,$FTP_PATH.$filename ,$LOCAL_DUMP_PATH.$filename, FTP_BINARY)) {
	        echo "$filename have been sent...\r\n";
	    } else {
	        echo "Upload have failed\r\n";
	    }
	    ftp_close($conn_id);
	    echo "Done.!\r\n";
	}
}

//Backup external DB
//fopen("http://ec2010jobbank.thodata.dk/tools/mysql_backup.php", "r"); 
   
?>