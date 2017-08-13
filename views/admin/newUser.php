<h2>Register as a new User</h2>

<div><?php
      if(isset($message))
      echo $message;?></div>

<div>
  <form action='?controller=user&action=insertUser' method='post'>
    <table>

          <tr><td>Email Address</td><td><input class='input' type='email' name='email'></td></tr>
          <tr><td>First Name</td><td><input class='input' type='text' name='firstname'></td></tr>
          <tr><td>Last Name</td><td><input class='input' type='text' name='lastname'></td></tr>
          <tr><td>Password</td><td><input class='input' type='text' name='password'></td></tr>
          <tr><td>Confirm Password</td><td><input class='input' type='text' name='passwordconfirm'></td></tr>
      </tr>

</table>



        <input class = 'input' type='submit' value='Register'></td>

  </form>
</div>
