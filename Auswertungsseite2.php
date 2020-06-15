<!-- Autor: Marius Müller, Dajana Thoebes -->
<?php include 'includes/header.php';
include 'includes/functions.php';

//Variablen deklarieren
$titelFB = htmlspecialchars(stripslashes(trim($_POST["fbTitel"])));
$kurs = htmlspecialchars(stripslashes(trim($_POST["kurs"])));
$befrager = $_SESSION["session_bname"];

if (isset($_POST["FragebogenAuswerten"])) {
  //Echo Befrager
  echo "<p> Befrager: " . $_SESSION['session_bname'] . "</p><br/>";
  //Echo FragebogenTitel
  echo "<p> Fragebogen: " . $titelFB . "</p><br/>";
  //Echo Kurs
  echo "<p> Kurs: " . $kurs . "</p><br/>";
  //Echo Zeitstempel
  date_default_timezone_set("Europe/Berlin");
  echo "<p> Zeitstempel: " . date("d.m.Y") . "  " . date("h:i:sa") . "</p><br/>";

  //Prüfe, ob ausgewählter Kurs für den ausgewählten Fragebogen freigeschalten ist
  $sqlcheck= "SELECT * FROM freischaltenfb WHERE Titel=? AND Kurs=?;";
  $stmt= mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sqlcheck)){
    header("Location: ../Auswertungsseite2.php?error=sqlerror");
    exit();
  }
  else{
    mysqli_stmt_bind_param($stmt, "ss", $titelFB, $kurs);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $resultcheck = mysqli_stmt_num_rows($stmt);
    if ($resultcheck<=0) {
      header("Location: Auswertungsseite.php?error=KursFBerror");
      exit;
    }

  }



  //Echo Anzahl Teilnehmer
  $sql = "SELECT COUNT(*) AS AnzahlTeiln FROM `bearbeitenfb` JOIN studenten on bearbeitenfb.mnr=studenten.MNR 
          WHERE Status='F' AND Titel=? AND kurs=?";
  echoAnzahlTeilnehmer($conn, $sql, $titelFB, $kurs);
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
      <th>Kommentar</th>
    </tr>
    <tr>
      <?php
      $sqlKomm = "SELECT * FROM `bearbeitenfb` WHERE titel=?";
      echoKommentare($conn, $sqlKomm, $titelFB);
      ?>
    </tr>
  </table>
</div>

<div>
  <?php
  /*
  $min = 0;
  $max = 0;
  $avg = 0.0;
  $stdabw = 0.0;

  $sqlAusw = "SELECT FrageNr, MIN(Bewertungswert) AS min, MAX(Bewertungswert)AS max, AVG(Bewertungswert) AS avg
          FROM beantwortenf AS b JOIN studenten AS s ON b.MNR=s.MNR JOIN bearbeitenfb AS fb ON b.Titel= fb.titel
          WHERE b.Titel = ? AND s.kurs=? AND fb.status='F'
          GROUP BY b.FrageNr;";

  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sqlAusw)) {
    header("Location: ../Auswertungsseite2.php?error=SQLBefehlFehler");
  } else {
    mysqli_stmt_bind_param($stmt, "ss", $titelFB, );
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
      echo "Anzahl Teilnehmer: " . $row['AnzahlTeiln'] . "</br>";
    }
  }
  mysqli_stmt_close($stmt);




  $auswert = array(
    "frage" => $fragenr,
    "Min" => $min,
    "Max" => $max,
    "Durchschnitt" => $avg,
    "Standardabweichung" => $stdabw
  );
  echo $auswert["Min"];
  */
  ?>
</div>

<div align="right" style="padding-top: 10px">
    <a href=Befrager.php>Zurück zur Startseite der Befrager</a>
</div>


</body>

</html>