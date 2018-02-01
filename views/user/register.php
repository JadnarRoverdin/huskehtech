<div class='exit'><i class="glyphicon glyphicon-remove"></i></div>

<h2>Registration</h2>
<hr>

<form action='?controller=user&action=register' method='post'>
  <input type='text' name='firstname' placeholder='First Name' required>
  <input type='text' name='lastname'  placeholder='Last Name' required><br>
  <input type='email' name='email'    placeholder='Email' required><br>
  <input type='password' name ='new-password' placeholder='Password' required><br>
  <input type='password' name ='confirm-password' placeholder='Confirm Password' required><br>
  <input type='hidden' name='level' value='5'>
  <input type='submit' value='Register'>
</form>
