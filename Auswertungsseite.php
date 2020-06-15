<!-- Autor: Marius Müller -->
<?php include 'includes/header.php';
include 'includes/functions.php';

/*$sql= "SELECT * FROM frageboegen WHERE befrager = 'Marius';";
        $result = mysqli_query($conn, $sql);
        if ($result) {
          $resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
          //print_r($resultArray);
        } */

//Echo Befrager
echo "<p> Befrager: " . $_SESSION['session_bname'] . "</p><br/>";


/*$sql = "SELECT * FROM bearbeitenfb WHERE titel = 'Studium';";
$result = mysqli_query($conn, $sql);
if ($result) {
  $resultArray2 = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$sql = "SELECT * FROM fragen WHERE titel = 'Studium';";
$result = mysqli_query($conn, $sql);
if ($result) {
  $resultArray3 = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$befrager=$_SESSION['session_bname'];
        echo "<p> Ersteller Fragebogen: ".$befrager."</p><br/>";*/

?>
<link href="Auswertungsdesign.css" rel="stylesheet">

<div class="container">
  <h1 align="center"><b>Willkommen auf der Auswertungsseite des Fragebogens!</b></h1>
</div>

<br />
<div class="main">
  <form action="Auswertungsseite2.php" method="post">

    <label for="fbTitel">Fragebogen: </label>
    <select name="fbTitel">
      <?php
      //titelFragebogen($conn, $sql, $befrager);

      $befrager = $_SESSION['session_bname'];
      //Template für prepared statement
      $sql = "SELECT titel FROM frageboegen WHERE Befrager=? AND frageboegen.titel IN (SELECT bearbeitenFB.titel FROM bearbeitenFB);";
      $sqlerror = "Location: ../Auswertungsseite.php?error=SQLBefehlFehler";
      auswahlFbBefragerBearbeiten($conn, $sql, $befrager, $sqlerror);
      ?>
    </select>
    </br> </br>
    <input type="submit" name="FragebogenAuswerten" value="Fragebogen auswerten">
  </form>
</div>


</body>

</html>