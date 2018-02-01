<div class='exit'><i class="glyphicon glyphicon-remove"></i></div>

<h2>Login</h2>
<hr>
      <form action='?controller=user&action=login' method='post'>
        <input type='text' name='email' placeholder='email'>
        <input type='password' name='current-password' placeholder='password'>
        <input type='submit' value='Login'>
        <button class='popupmaker smalllink' id='passwordReset'>Reset Password</button>
      </form>
 <div id='passwordReset' class='popup'><?php include_once('views/user/passwordResetRequest.php');?></div>
