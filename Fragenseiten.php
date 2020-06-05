<?php
include 'includes/header.php';
include 'includes/functions.php';

//aus DB freigegebene Fragebogen des Studenten holen
$mnr = $_SESSION['session_mnr'];

if (isset($_POST["FragebogenBearbeiten"])) {

  $FbTitel = $_POST['fbTitel'];

  $neuerStatus = 'B';

  $sql = "INSERT INTO bearbeitenfb (Titel, MNR, Status) VALUES (?, ?, ?)";
  // Funktion, die den Status eines Fragebogens ändert
  statusInBearbeitung($conn, $sql, $FbTitel, $mnr, $neuerStatus);
}

//DB-Abfrage Anzahl Fragen
if (isset($_POST["FragebogenBearbeiten"])) {
  $titelFB = $_POST["fbTitel"];
  $sqlAnzFr = "SELECT COUNT(FrageNr) AS anzFr from fragen where Titel = '$titelFB';";
  $resultAnzFr = mysqli_query($conn, $sqlAnzFr);
  $anzFr = mysqli_fetch_assoc($resultAnzFr);
  $_SESSION["anzFr"] = $anzFr["anzFr"];
}

//Deklaration Session-Variablen
if (isset($_POST["FragebogenBearbeiten"])) {
  $_SESSION["aktSeite"] = 1;
  $_SESSION["titelFB"] = $_POST["fbTitel"];
}



$sql = "SELECT * FROM fragen WHERE titel = 'Studium';";
$result = mysqli_query($conn, $sql);
if ($result) {
  $resultArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<link href="Fragenseitendesign.css" rel="stylesheet">

<section class="welcome">
  <h1>Willkommen auf der Fragenseite!</h1>
  <p>Some subtitle message</p>
  <?php
  echo "<p> Student: " . $_SESSION['session_mnr'] . "</p><br/>";
  echo "<p> Fragebogen: " . $_SESSION["titelFB"] . "</p><br/>";
  ?>
</section>

<section class="questions">
  <p class="abc">Seite: <?php echo $_SESSION["aktSeite"] ?> von <?php echo $_SESSION["anzFr"] ?></p>

  <fieldset>
    <?php
    //aus DB aktuelle Frage holen
    //Template für prepared statement
    $sql = "SELECT * FROM fragen, bearbeitenfb where fragen.Titel=bearbeitenfb.Titel AND FrageNr=?;";
    // prepared statement erstellt
    $stmt = mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../Fragenseiten.php?error=SQLBefehlFehler");
    } else {
      //Verknüpfung Parameter zu Placeholder
      $aktFr = $_SESSION["aktSeite"];
      mysqli_stmt_bind_param($stmt, "s", $aktFr);
      //Parameter in DB verwenden
      mysqli_stmt_execute($stmt);
      //Daten/Ergebnis aus execute-Fkt in Variable verwenden
      $result = mysqli_stmt_get_result($stmt);
      //Ergebnis ausgeben
      while ($row = mysqli_fetch_assoc($result)) {
        echo $row['Fragestellung'];
      }
    }
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
    <!-- Select einfügen 
    <input />-->
    </br>
    </br>
    <input type="submit" value="Zurück" name="Bzurück" <?php
                                                        //Deaktivieren Button auf Seite 1 
                                                        if ($_SESSION["aktSeite"] <= 1) {
                                                          echo "disabled";
                                                        }
                                                        ?> />
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