<?php include 'includes/header.php';
include 'includes/functions.php';

//Beim Start Fragebogen Ausfüllen ausführen
if (isset($_POST["FragebogenBearbeiten2"])) {
  //Variablen deklarieren
  $mnr = $_SESSION["session_mnr"];
  $FbTitel = htmlspecialchars(stripslashes(trim($_POST["fbTitel"])));
  
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

<link href="Fragenseitendesign.css" rel="stylesheet">

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
      //aktuelle Frage aus DB holen und ausgeben
      $sqlFr = "SELECT * FROM fragen, bearbeitenfb where fragen.Titel=bearbeitenfb.Titel AND fragen.titel=? AND FrageNr=? AND mnr=?;";
      aktFrageFB($conn, $sqlFr, $titelFb, $aktFr, $mnr);
    ?>
  </fieldset>


  <form action="includes/dbUpdateBewertung.php" method="POST">
    <fieldset>    
      <p><?php
        $mnr = $_SESSION["session_mnr"];
        $titelFB = $_SESSION["titelFB"];
        $frageNr = $_SESSION["aktSeite"];
        //Bewertungswert in Variable $bewertung speichern 
        $sqlV= "SELECT * FROM beantwortenf WHERE mnr=? AND FrageNr=? AND Titel=?";
        $bewertung = aktAntwF($conn, $sqlV, $mnr, $frageNr, $titelFB);
      ?>
      </p>

      <input type="radio" id="1" name="bewertung" value=1 <?php
            //Setzen des Radio-Buttons
            if ($bewertung == 1) {
              echo "checked";
            }
            ?> />
      <label for="1"> 1 Stern</label>
      <input type="radio" id="2" name="bewertung" value=2 <?php
            //Setzen des Radio-Buttons
            if ($bewertung == 2) {
              echo "checked";
            }
            ?> />
      <label for="2"> 2 Sterne</label>
      <input type="radio" id="3" name="bewertung" value=3 <?php
            //Setzen des Radio-Buttons
            if ($bewertung == 3) {
              echo "checked";
            }
            ?> />
      <label for="3"> 3 Sterne</label>
      <input type="radio" id="4" name="bewertung" value=4 <?php
            //Setzen des Radio-Buttons
            if ($bewertung == 4) {
              echo "checked";
            }
            ?> />
      <label for="4"> 4 Sterne</label>
      <input type="radio" id="5" name="bewertung" value=5 <?php
            //Setzen des Radio-Buttons
            if ($bewertung == 5) {
              echo "checked";
            }
            ?> />
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