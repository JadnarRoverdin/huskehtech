<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src ="java/postTrimmer.js"></script>
<div>
  <?php
    foreach($posts as $post)
    {
      $areImages = false;
      if(sizeof($post->images) > 0)
        $areImages =true;
      ?>
          <table class='postCard'>
            <tr>
              <?php if($areImages) echo "<td class='postLinkBack'>"; else echo "<td class='postLinkBackAlt'>"; ?>
                <a class='postLink' href='?controller=pages&action=viewPost&postID=<?php echo $post->id; ?>'><?php echo $post->title; ?></a>
                <br><?php echo $post->author; ?>
                <br><?php echo $post->date; ?>
              </td>
              <?php
                if($areImages)
                {
                  echo "<td class ='postImages' rowspan='2'>";
                    foreach($post->images as $image)
                    {
                      if(substr($image,0,15) === "img/postImages/" && strlen($image) > 15)
                      echo "<a href'".$image."'><img src='".$image."' width='200'></a>";
                    }
                    echo "</td>";
                  }
                ?>
            </tr>
            <tr>
              <?php if($areImages) echo "<td class='content'>"; else echo "<td class='contentAlt'>"; ?>
                  <?php
                    if($post->content >0)
                      foreach($post->content as $content)
                        echo $content;
                  ?>
              </td>
            </tr>
            <tr>
              <td colspan='2' class='adminLink'>
                <?php
                  if(isset($_SESSION['admin']) && $_SESSION['admin']=="1")
                  {
                    echo "<a href='?controller=admin&action=editPost&postID=".$post->id."'>Edit</a> ";
                    echo "<a href='?controller=admin&action=removePost&postID=".$post->id."'>Delete</a>";
                  }
                ?>
              </td>
            </tr>
          </table>
      <?php
    }
  ?>
