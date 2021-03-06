<!-- Autoren: Dajana Thoebes, Lukas Ströbele, Marius Müller -->
<?php include 'includes/header.php';
include 'includes/functions.php';

//Beim Start Fragebogen Ausfüllen ausführen
if (isset($_POST["FragebogenBearbeiten"])) {

  $mnr = $_SESSION["session_mnr"];
  $FbTitel = htmlspecialchars(stripslashes(trim($_POST["fbTitel"])));
  
  //Status Fragebogen auf B - in Bearbeitung setzen
  $neuerStatus = 'B';
  $sql = "INSERT INTO bearbeitenfb (Titel, MNR, Status) VALUES (?, ?, ?)";
  // Funktion, die den Status eines Fragebogens ändert
  statusInBearbeitung($conn, $sql, $FbTitel, $mnr, $neuerStatus);

  //DB-Abfrage Anzahl Fragen in Session-Variable speichern
  $sqlAnzFr = "SELECT COUNT(FrageNr) AS anzFr from fragen where Titel = '$FbTitel';";
  $resultAnzFr = mysqli_query($conn, $sqlAnzFr);
  $anzFr = mysqli_fetch_assoc($resultAnzFr);
  $_SESSION["anzFr"] = $anzFr["anzFr"];

  //Deklaration Session-Variablen für weiteres Ausfüllen Fragebogen
  $_SESSION["aktSeite"] = 1;
  $_SESSION["titelFB"] = $FbTitel;
}

//Wenn kein Fragebogen ausgewählt, Rücksendung auf Studentenseite
if ($_SESSION["titelFB"] == '') {
  header("Location: Studenten.php?KeinFragebogenAusgewaehlt");
}
?>

<link href="css/Fragenseitendesign.css" rel="stylesheet">

<section class="welcome">
  <h1>Willkommen auf der Fragenseite!</h1>
  <p>Bitte wählen Sie eine Bewertung aus</p>
  <?php
  echo "<p> Student: " . $_SESSION['session_mnr'] . "</p><br/>";
  echo "<p> Fragebogen: " . $_SESSION["titelFB"] . "</p><br/>";
  ?>
</section>

<section class="questions">
  <p class="abc">Seite: <?php echo $_SESSION["aktSeite"] ?> von <?php echo $_SESSION["anzFr"] ?></p>

  <fieldset>
    <?php
      $aktFr = $_SESSION["aktSeite"];
      $titelFb = $_SESSION["titelFB"];
      $mnr = $_SESSION['session_mnr'];
      //aktuelle Frage aus DB holen und ausgeben
      $sqlFr = "SELECT * FROM fragen, bearbeitenfb where fragen.Titel=bearbeitenfb.Titel AND fragen.titel=? AND FrageNr=? AND MNR=?;";
      aktFrageFB($conn, $sqlFr, $titelFb, $aktFr, $mnr);
    ?>
  </fieldset>


  <form action="includes/dbInsertBewertung.php" method="POST">

    <fieldset>
      <input type="radio" id="1" name="bewertung" value=1>
      <label for="1"> 1 Stern</label>
      <input type="radio" id="2" name="bewertung" value=2>
      <label for="2"> 2 Sterne</label>
      <input type="radio" id="3" name="bewertung" value=3>
      <label for="3"> 3 Sterne</label>
      <input type="radio" id="4" name="bewertung" value=4>
      <label for="4"> 4 Sterne</label>
      <input type="radio" id="5" name="bewertung" value=5>
      <label for="5"> 5 Sterne</label>
    </fieldset>
    </br>
    </br>
    
    <input type="submit" value="Weiter" name="Bweiter" style="float: right;" <?php
              //Deaktivieren Button, wenn akt. Seite = Gesamtanzahl Seiten
             if ($_SESSION["aktSeite"] >= $_SESSION["anzFr"]) {
              echo "disabled";
              }
             ?> />
    </br>
    </br>
    <input type="submit" value="Abschließen" name="Babschluss" style="float: right;" <?php
          //Button solange aktiviert, wie akt. Seite != Gesamtanzahl Seiten
          if ($_SESSION["aktSeite"] != $_SESSION["anzFr"]) {
          echo "disabled";
       }
      ?> />
  </form>

</section>

</body>

</html>