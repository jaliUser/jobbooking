<p>
Ved tryk på SEND, bliver teksten sendt til alle danskere tilmeldt
</p>
<p>
Tekst<br>
<form method="post" action="<?php echo $PHP_SELF; ?>">
<textarea name="verify-emails" rows="20" cols="100"><?php echo $_POST['verify-emails']; ?></textarea>
<input type="submit" value="Send SMS'er"/>
</form>
</p>

<?php
include 'jc_sms_func.php';

if(!empty($_POST['verify-emails'])) {
	$mail_arr = explode(", ", $_POST['verify-emails']);
	
	echo count($mail_arr)."<br>";
	foreach ($mail_arr as $mail) {
		if (!valid_email($mail)) {
			echo "$mail <br>";
		}
	}
}

?>