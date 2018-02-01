<h2>Reset Password</h2>
<?php
	if($message != "")
		echo $message."<br>";
?>
<form name="form" action="" method="post">
	<input type="password" name="password" id="new-password" placeholder='New Password'><br>
	<input type="password" name="passwordConfirm" id="passwordConfirm" placeholder='Confirm New Password'><br>
	<input type="submit" name="submit" id="submit">
</form>
