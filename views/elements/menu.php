

<div class='popup menu' id='menu'>
  <div class='exit'>X</div>
  <div>
    <h2>Menu</h2>
    <ul>
      <a class='menuLink' href = '?controller=pages&action=index'><li>Home</li></a>
      <a class='menuLink' href = '?controller=pages&action=about'><li>About</li></a>
      <a class='menuLink' href = '?controller=portfolio&action=index'><li>Portfolio</li></a>
      <a class='menuLink' href = '?controller=pages&action=sandbox'><li>Sandbox</li></a>
      <a class='menuLink' href = '?controller=pages&action=contact'><li>Contact</li></a>
      <?php
        if(isset($_SESSION['user']) && $_SESSION['user']->admin == "1")
        {
          echo "<a class='menuLink' href = '?controller=admin&action=index'><li>Administration</li></a>";
        }
      ?>
    </ul>
  </div>
</div>
