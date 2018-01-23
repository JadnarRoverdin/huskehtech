<h2> Edit User</h2>

<form action='?controller=user&action=editUser'method = 'post' enctype="multipart/form-data">
<input class='input' name = 'userID' type='hidden' value='<?php echo $user->id;?>'>
<input class='input'  name = 'firstName' type='text' value='<?php echo $user->firstName;?>'>
<input class='input'  name = 'lastName' type='text' value='<?php echo $user->lastName;?>'><br>
<input class='input'  name = 'email' type='email' value='<?php echo $user->email;?>'><br>
<input class='input'  name = 'admin' type='number' value = '<?php echo $user->admin;?>'>
<hr>
<input name='profileID' type='hidden' value='<?php echo $user->profile->id;?>'>
<input class='input'  name='dob' type='date' value='<?php echo $user->profile->dob;?>'><br>
<input class='input'  name='location' type='text' value='<?php echo $user->profile->location;?>'><br>
<textarea class='input'  rows='15' cols='100' name='biography'><?php echo $user->profile->biography;?></textarea><br>
<input class="input" type ="file" name ="avatar" id="avatar"><br>
<input type='submit' value='Update User'>
</form><br>
<?php if(isset($message)) echo $message;?>
