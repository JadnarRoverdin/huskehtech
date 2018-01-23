<h2>Contact</h2>
<div><?php echo $result; ?></div>
<form action="?controller=pages&action=contact" method="post">
  <input class='input' type='email' name='email' placeholder='Your Email Address' required><br>
  <input class='input' type='text' name='firstname' placeholder='First Name' required>
  <input class='input' type='text' name='lastname' placeholder='Last Name' required><br>
  <textarea id='scroller' class='input' name='message' placeholder='Message' rows='10' cols='50' required></textarea><br>
  <input class='input' type='submit' value='Send Email'>

</form>
