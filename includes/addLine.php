<?php
//session_start();
?>

<!DOCTYPE html>

<html lang="de">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Titel</title>
  </head>

  <body>
      <?php
      /*if (isset ($_POST["addLine"]) == false){
          $_SESSION["initSeite"]=true;
      }

      if (isset ($_POST["addLine"]) == true){
        $_SESSION["initSeite"]=false;
      } */
      ?>
      <h4>Inhalt</h4>

  <form action="addLine.php" method="post">
      <input type="submit" 
        <?php
            echo "new line";
        ?>
      name="addLine" value="Add"/>
  </form>

  </body>
</html>