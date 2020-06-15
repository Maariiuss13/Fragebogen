<?php include 'includes/header.php';
include 'includes/functions.php';

//Variablen deklarieren
$titelFB = htmlspecialchars(stripslashes(trim($_POST["fbTitel"])));
$befrager = $_SESSION["session_bname"];

//Echo Befrager
echo "<p> Befrager: " . $_SESSION['session_bname'] . "</p><br/>";
//Echo FragebogenTitel
echo "<p> Fragebogen: " . $titelFB . "</p><br/>";
//Echo Zeitstempel
date_default_timezone_set("Europe/Berlin");
echo "<p> Zeitstempel: " . date("d.m.Y") . "  " . date("h:i:sa") . "</p><br/>";

//Echo Anzahl Teilnehmer
if (isset($_POST["FragebogenAuswerten"])){
  $sql= "SELECT COUNT(*) AS AnzahlTeiln FROM `bearbeitenfb` WHERE Status='F' AND Titel=?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../FragebogenBearbeiten2.php?error=SQLBefehlFehler");
} else {
  mysqli_stmt_bind_param($stmt, "s", $titelFBr);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  while ($row = mysqli_fetch_assoc($result)) {
      echo $row['AnzahlTeiln'] . "</br>";
    }
  }

}

?>
<link href="Auswertungsdesign.css" rel="stylesheet">

<br />

<br />
<div class="table">
  <table border="1">
    <tr>
      <th>Frage</th>
      <th>Durchschnitt</th>
      <th>Min</th>
      <th>Max</th>
      <th>Standardabweichung</th>
    </tr>
    <tr>
      <?php
      echo '<td>' . $resultArray3[0]["Fragestellung"] . '</td>';
      ?>
    </tr>
  </table>
</div>
<br />
<div class="comments">
  <p>Liste Kommentare</p>
  <table border="1">

    <tr>
      <?php
      echo '<th>Kommentare</th>';



      echo '</tr>';
      echo '<tr>';
      echo '<td>' . $resultArray2[0]["Kommentar"] . '</td>';
      ?>
    </tr>

  </table>
</div>
<div>


  <?php

  $fbtitel = "Sport";
  $kurs = "WWI";
  auswertungFunktion($conn, $sql, $fbtitel, $kurs);



  ?>


</div>



</body>

</html>