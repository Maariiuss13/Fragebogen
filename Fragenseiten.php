<?php include 'includes/header.php';
include 'includes/functions.php';

//aus DB freigegebene Fragebogen des Studenten holen
$mnr = $_SESSION['session_mnr'];

if (isset($_POST["FragebogenBearbeiten"])) {

  $FbTitelIB = $_POST['fbTitel'];

  $sql = "SELECT * FROM bearbeitenfb WHERE Titel='$FbTitelIB'";
  $statement = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($statement, $sql)) {
    header("Location: ../Studenten.php?error=sqlerror");
    exit();
  } else {
    $sql = "INSERT INTO bearbeitenfb (Titel, MNR, Status, Kommentar) VALUES ('$FbTitelIB', ?, 'in Bearbeitung', ?)";
    $statement = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($statement, $sql)) {
      header("Location: ../Studenten.php?error=sqlerror");
      exit();
    } 
  }
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
          aktuelleFrageFB($sql, $conn);
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