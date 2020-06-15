<?php include 'includes/header.php';
include 'includes/functions.php';

//Variablen deklarieren
$titelFB = htmlspecialchars(stripslashes(trim($_POST["fbTitel"])));
$befrager = $_SESSION["session_bname"];

if (isset($_POST["FragebogenAuswerten"])) {
  //Echo Befrager
  echo "<p> Befrager: " . $_SESSION['session_bname'] . "</p><br/>";
  //Echo FragebogenTitel
  echo "<p> Fragebogen: " . $titelFB . "</p><br/>";
  //Echo Zeitstempel
  date_default_timezone_set("Europe/Berlin");
  echo "<p> Zeitstempel: " . date("d.m.Y") . "  " . date("h:i:sa") . "</p><br/>";

  //Echo Anzahl Teilnehmer
  $sql = "SELECT COUNT(*) AS AnzahlTeiln FROM `bearbeitenfb` WHERE Status='F' AND Titel=?;";
  echoAnzahlTeilnehmer($conn, $sql, $titelFB);

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
  <?php

  $sqlKomm = "SELECT * FROM `bearbeitenfb` WHERE titel=?";

  // prepared statement erstellt
  $stmt = mysqli_stmt_init($conn);
  // prepared statement vorbereiten
  if (!mysqli_stmt_prepare($stmt, $sqlKomm)) {
    header("Location: ../Auswertungsseite2.php?error=SQLBefehlFehler45");
  } else {
    //Verknüpfung Parameter zu Placeholder
    mysqli_stmt_bind_param($stmt, "s", $titelFB);
    //Parameter in DB verwenden
    mysqli_stmt_execute($stmt);
    //Daten/Ergebnis aus execute-Fkt in Variable verwenden
    $result = mysqli_stmt_get_result($stmt);
    //Ergebnis ausgeben
    while ($row = mysqli_fetch_assoc($result)) {
      echo "- ".$row['Kommentar'] . "</br>";
    }
  }

  ?>
</div>

<div>
  <?php
  /*$fbtitel = "Sport";
  $kurs = "WWI";
  auswertungFunktion($conn, $sql, $fbtitel, $kurs);*/
  ?>
</div>

</body>
</html>