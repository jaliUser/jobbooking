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
$DB_HOST = "localhost";
$DB_USERNAME = "see2010jobcenter";
$DB_PASSWORD = "p3jd3rJobC3nt3r";
$DB_NAME = "dbsee2010jobcenter"; 

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
 * Prefix til dump
 */
$FILENAME_PREFFIX = "sqldump";

/******************************************************
 * 
 * Her under skal du kun rette hvis du ved hvad du gør!
 * 
 *****************************************************/

// Laver filnavn
date_default_timezone_set('Europe/Copenhagen');
$tid = date('YmdHis', time());
$filename = $FILENAME_PREFFIX.$tid.".sql";
 
//  Laver MySQL dump kald
$dump_cmd = "mysqldump -h$DB_HOST -u$DB_USERNAME -p$DB_PASSWORD";
$dump_cmd .= " $DB_NAME";
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
   
?>