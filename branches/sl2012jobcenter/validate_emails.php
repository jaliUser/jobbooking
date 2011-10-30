<p>
Verify emails<br>
<form method="post" action="<?php echo $PHP_SELF; ?>">
<textarea name="verify-emails" rows="20" cols="100"><?php echo $_POST['verify-emails']; ?></textarea>
<input type="submit" value="send"/>
</form>
</p>

<p>
Filter duplicates<br>
<form method="post" action="<?php echo $PHP_SELF; ?>">
<textarea name="emails1" rows="20" cols="100"><?php echo $_POST['emails1']; ?></textarea>
<textarea name="emails2" rows="20" cols="100"><?php echo $_POST['emails2']; ?></textarea>
<input type="submit" value="Merge"/>
</form>
</p>

<?php

include_once 'jc_functions.php';

if(!empty($_POST['verify-emails'])) {
	$mail_arr = explode(", ", $_POST['verify-emails']);
	
	echo count($mail_arr)."<br>";
	foreach ($mail_arr as $mail) {
		if (!valid_email($mail)) {
			echo "$mail <br>";
		}
	}
}

if(!empty($_POST['emails1']) && !empty($_POST['emails2'])) {
	$mail_arr_1 = explode(", ", $_POST['emails1']);
	$mail_arr_2 = explode(", ", $_POST['emails2']);
	$mail_no_dubs = "";
	$mail_dubs = "";
	
	echo count($mail_arr_1)."<br>";
	echo count($mail_arr_2)."<br>";
	foreach ($mail_arr_1 as $mail) {
		$mail = strtolower($mail);
		if (strpos($mail_no_dubs, $mail) === false) {
			$mail_no_dubs .= "$mail, ";
		} else {
			$mail_dubs .= "$mail, ";
		}
	}
	
	foreach ($mail_arr_2 as $mail) {
		$mail = strtolower($mail);
		if (strpos($mail_no_dubs, $mail) === false) {
			$mail_no_dubs .= "$mail, ";
		} else {
			$mail_dubs .= "$mail, ";
		}
	}
	
	echo "Unique: <br>$mail_no_dubs <br><br>";
	echo "Dubs: <br>$mail_dubs";
}

?>