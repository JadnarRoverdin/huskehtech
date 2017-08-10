
<table class="main">
  <tr>

    <td class ="links">
        <ul>
        <li class='menuLink'><a  href = '?controller=pages&action=index'>Home</a></li>
        <li class='menuLink'><a  href = '?controller=pages&action=about'>About</a></li>
        <li class='menuLink'><a  href = '?controller=portfolio&action=index'>Portfolio</a></li>
        <!-- <li class='menuLink'><a class='menuLink' href = '?controller=pages&action=mobilelab'>Mobile Lab</a></li> -->
        <!-- <li class='menuLink'><a class='menuLink' href = '?controller=pages&action=services'>Services</a></li> -->
        <!-- <li class='menuLink'><a href = '?controller=pages&action=food'>Food</a></li> -->
        <li class='menuLink'><a  href = '?controller=pages&action=sandbox'>Sandbox</a></li>
        <!-- <li class='menuLink'><a class='menuLink' href = '?controller=evaluation&action=index'>Evaluation</a></li> -->
        <?php
          if(isset($_SESSION['admin']) && $_SESSION['admin'] == "1")
          {
            echo "<li class='menuLink'><a href = '?controller=admin&action=index'>Administration</a></li>";
          }
        ?>
      </ul>
      <br><br>
      <div>
        <?php
        if(!isset($_SESSION['admin']))
        {
          // echo "<form action='?controller=user&action=login' method='post'>";
          // echo "<input class='input' type='text' name='username' placeholder='Email'><br>";
          // echo "<input class='input' type='password' name='password' placeholder='Password'><br>";
          // echo "<input class='input' type='submit' value='Login'> <a href='?controller=user&action=addUser'>Register</a>";
          // echo "</form>";
        }
        else
        {
          echo "Logged in as: <br>";
          echo $_SESSION['fname']." ".$_SESSION['lname']."<br>";
          echo "<a href='?controller=user&action=logout'>LogOut</a>";
        }
      ?>
    </div>
    </td>

    <td class = "viewer">
        <?php require_once('routes.php'); ?>
    </td>

  </tr>
</table>
