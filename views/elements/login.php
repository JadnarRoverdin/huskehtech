
<div id='login' class='popup'>
  <div class='exit'>X</div>
  <form action='?controller=user&action=login' method='post'>
    <input class='input' type='text' name='username' placeholder='Email'><br>
    <input class='input' type='password' name='password' placeholder='Password'>
    <input class='input' type='submit' value='Login'>
  </form><br>
  <form action='?controller=user&action=addUser' method='post'><input class='input' type='submit' value='Register'></form>
</div>
