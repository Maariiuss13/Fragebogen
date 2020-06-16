<!-- Autor: Marius Müller, Dajana Thoebes, Lukas Ströbele (Cross-Site-Scripting) -->

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
    //Auswertungsergebnisse ausgeben
    $auswert = array();
    $sqlAusw = "SELECT FrageNr, MIN(Bewertungswert) AS min, MAX(Bewertungswert)AS max, AVG(Bewertungswert) AS avg
          FROM beantwortenf AS b JOIN studenten AS s ON b.MNR=s.MNR JOIN bearbeitenfb AS fb ON b.Titel= fb.titel
          WHERE b.Titel = ? AND s.kurs=? AND fb.status='F'
          GROUP BY b.FrageNr;";
    
    //Funktion, die die Ergebnisse des Auswertungsarray ausgibt
    auswertungFunktion($conn, $sqlAusw, $titelFB, $kurs);

    ?>
  </table>
</div>
<br />

<div class="comments">
  <p>Liste Kommentare</p>
    <?php
    //Kommentare ausgeben
    $sqlKomm = "SELECT * FROM bearbeitenfb JOIN studenten ON bearbeitenfb.mnr=studenten.MNR 
                  WHERE titel=? AND Kurs=?";
    //Funktion, welche die Kommentare ausgibt
    echoKommentare($conn, $sqlKomm, $titelFB, $kurs);
    ?>
</div>


<div align="right" style="padding-top: 10px">
  <a href=Befrager.php>Zurück zur Startseite der Befrager</a>
</div>


</body>

</html>