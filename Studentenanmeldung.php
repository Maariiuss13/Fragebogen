<!-- Autor: Lukas Ströbele -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Anmeldung - Studenten</title>
  <link href="css/Logindesign.css" rel="stylesheet">
</head>

<body bgcolor="e2e2e2">

  <div align="center">
    <table>
      <tr>
        <th><img src="Fragen.jpg" width="100%" height="15%"></th>
      </tr>
    </table>
  </div>

  <h2 align="center">Anmeldung - Studenten</h2>

  <?php
  // Fehlermeldungen, die bei Unstimmigkeiten bei der Anmeldung geworfen werden
  if (isset($_GET["error"])) {
    if ($_GET["error"] == "leeresFeld") {
      echo '<p align="center" style="color: red;">Tragen Sie bitte Ihre Matrikelnummer ein, um fortfahren zu können!</p>';
    }
    if ($_GET["error"] == "matrikelnummernichtvergeben") {
      echo '<p align="center" style="color: red;">Hierbei handelt es sich um keine gültige Matrikelnummer!</p>';
    }
  }
  ?>

  <form action="includes/Studentenanmeldung.inc.php" method="post">

    <div class="container">
      <label for="mnr"><b>Matrikelnummer</b></label>
      <input type="text" placeholder="Geben Sie hier Ihre Matrikelnummer ein." name="mnr" minlength="7" maxlength="7">

      <button type="submit" name="studentenanmeldung">Jetzt anmelden!</button>
    </div>
  </form>

  <div align="right" style="padding-top: 10px">
    <a href=Startseite.php>Zurück zur Startseite</a>
  </div>

</body>

</html>