
<table class="main">
  <tr>
    <td class ="postLinkBackAlt" style='width:200px'>
        <ul>
        <a class='menuLink' href = '?controller=pages&action=index'><li>Home</li></a>
        <a class='menuLink'  href = '?controller=pages&action=about'><li>About</li></a>
        <a class='menuLink' href = '?controller=portfolio&action=index'><li>Portfolio</li></a>
        <!-- <li class='menuLink'><a class='menuLink' href = '?controller=pages&action=mobilelab'>Mobile Lab</a></li> -->
        <!-- <li class='menuLink'><a class='menuLink' href = '?controller=pages&action=services'>Services</a></li> -->
        <!-- <li class='menuLink'><a href = '?controller=pages&action=food'>Food</a></li> -->
        <a class='menuLink' href = '?controller=pages&action=sandbox'><li>Sandbox</li></a>
        <!-- <li class='menuLink'><a class='menuLink' href = '?controller=evaluation&action=index'>Evaluation</a></li> -->
        <?php
          if(isset($_SESSION['user']) && $_SESSION['user']->admin == "1")
          {
            echo "<a class='menuLink' href = '?controller=admin&action=index'><li>Administration</li></a>";
          }
        ?>
      </ul>
    </td>
    <td class = "viewer" rowspan='3'>
        <?php require_once('routes.php'); ?>
    </td>
  </tr>
  <tr>
    <td class='contentAlt' style='width:200px'>
        <?php
        if(!isset($_SESSION['user']))
        {
          echo "<form action='?controller=user&action=login' method='post'>";
          echo "<input class='input' type='text' name='username' placeholder='Email'><br>";
          echo "<input class='input' type='password' name='password' placeholder='Password'><br>";
          echo "<input class='input' type='submit' value='Login'></form>";
          echo "<form action='?controller=user&action=addUser' method='post'>";
          echo "<input class='input' type='submit' value='Register'></form>";
        }
        else
        {
          echo "Logged in as: <br>";
          $user = $_SESSION['user'];
          echo $user->firstName." ".$user->lastName."<br>";

          echo "<form action='?controller=user&action=logout' method='post'><input class='input' type='submit' value='LogOut'></a>";
        }
      ?>
    </td>
  </tr>
  <tr>
    <td>
    </td>
  </tr>
</table>
