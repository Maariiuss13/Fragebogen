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
  $sqlcheck = "SELECT * FROM freischaltenfb WHERE Titel=? AND Kurs=?;";
  checkFragebogenKursZuordnung($conn, $sqlcheck, $titelFB, $kurs);

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

    <?php
    $auswert = array();

    $sqlAusw = "SELECT FrageNr, MIN(Bewertungswert) AS min, MAX(Bewertungswert)AS max, AVG(Bewertungswert) AS avg
          FROM beantwortenf AS b JOIN studenten AS s ON b.MNR=s.MNR JOIN bearbeitenfb AS fb ON b.Titel= fb.titel
          WHERE b.Titel = ? AND s.kurs=? AND fb.status='F'
          GROUP BY b.FrageNr;";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sqlAusw)) {
      header("Location: Auswertungsseite2.php?error=SQLBefehlFehler");
    } else {
      mysqli_stmt_bind_param($stmt, "ss", $titelFB, $kurs);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      while ($row = mysqli_fetch_assoc($result)) {
        $auswert["FrageNr"] = $row['FrageNr'];
        $auswert["Minimum"] = $row['min'];
        $auswert["Maximum"] = $row['max'];
        $auswert["Durchschnitt"] = $row['avg'];

        $avg = $auswert["Durchschnitt"];
        $frageNr = $row['FrageNr'];

        $sqlbewert = "SELECT * FROM beantwortenf JOIN studenten ON beantwortenf.mnr=studenten.MNR 
              WHERE titel=? AND Kurs=? AND frageNr=$frageNr";

        $var = varianzBerechnen($conn, $sqlbewert, $titelFB, $kurs, $avg);

        //Berechnung Standardabweichung
        $stdabw = sqrt($var);
        $auswert["Standardabweichung"] = $stdabw;

        echo "<tr><td>" . $auswert['FrageNr'] . "</td>";
        echo "<td>" . $auswert['Durchschnitt'] . "</td>";
        echo "<td>" . $auswert['Minimum'] . "</td>";
        echo "<td>" . $auswert['Maximum'] . "</td>";
        echo "<td>" . $auswert['Standardabweichung'] . "</td> </tr>";
      }
    }
    mysqli_stmt_close($stmt);
    ?>
  </table>
</div>
<br />

<div class="comments">
  <p>Liste Kommentare</p>
  <table border="1">
    <tr>
      <th>Kommentar</th>
    </tr>
    <?php
    $sqlKomm = "SELECT * FROM bearbeitenfb JOIN studenten ON bearbeitenfb.mnr=studenten.MNR 
                  WHERE titel=? AND Kurs=?";
    echoKommentare($conn, $sqlKomm, $titelFB, $kurs);
    ?>
  </table>
</div>


<div align="right" style="padding-top: 10px">
  <a href=Befrager.php>Zurück zur Startseite der Befrager</a>
</div>


</body>

</html>