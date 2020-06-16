<!-- Autor: Marius Müller, Dajana Thoebes -->

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
  <?php
  //Fehlermeldung ausgeben, wenn Fragebogen und Kurs nicht einander zugeordnet sind
  if (isset($_GET["error"])) {
    if ($_GET["error"] == "KursFBerror") {
      echo '<p align="center" style="color: red;">Der ausgewählte Fragebogen ist nicht dem ausgewählten Kurs zugeordnet.</p>';
    }
    if ($_GET["error"] == "keineErgebnisse") {
      echo '<p align="center" style="color: red;">Für den ausgewählten Fragebogen liegen noch keine Ergebnisse zu jeder Frage vor.</p>';
    }
  }
  ?>
</div>

<br />
<div class="main">
  <form action="Auswertungsseite2.php" method="post">

    <label for="fbTitel">Fragebogen: </label>
    <select name="fbTitel">
      <?php
      $befrager = $_SESSION['session_bname'];
      //Template für prepared statement
      $sqlFB = "SELECT titel FROM frageboegen WHERE Befrager=? AND frageboegen.titel IN (SELECT bearbeitenFB.titel FROM bearbeitenFB);";
      $sqlerror = "Location: ../Auswertungsseite.php?error=SQLBefehlFehler";
      auswahlFbBefragerBearbeiten($conn, $sqlFB, $befrager, $sqlerror);
      ?>
    </select>

    <label for="kurs">Kurs: </label>
    <select name="kurs">
      <?php
      //Ausgabe Kurse, für die Fragebögen freigeschaltet sind
      $sqlKurs = "SELECT DISTINCT kurs FROM freischaltenFB;";
      echokursfreischalten($conn, $sqlKurs);
      ?>
    </select>
    </br> </br>
    <input type="submit" name="FragebogenAuswerten" value="Fragebogen auswerten">
  </form>
</div>

<div align="right" style="padding-top: 10px">
  <a href=Befrager.php>Zurück zur Startseite der Befrager</a>
</div>


</body>

</html>