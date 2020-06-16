<!-- Autor: Lukas Ströbele -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Anmeldung - Befrager</title>
  <link href="Logindesign.css" rel="stylesheet">
</head>

<body bgcolor="e2e2e2">

  <div align="center">
    <table>
      <tr>
        <th><img src="Fragen.jpg" width="100%" height="15%"></th>
      </tr>
    </table>
  </div>

  <h2 align="center">Anmeldung - Befrager</h2>

  <?php
  // Fehlermeldungen bzw. Erfolgsmeldungen, die bei Unstimmigkeiten 
  // bzw. Erfolg bei der Anmeldung geworfen werden 
  if (isset($_GET["error"])) {
    if ($_GET["error"] == "leerefelder") {
      echo '<p align="center" style="color: red;">Füllen Sie bitte alle Felder aus!</p>';
    }
    else if ($_GET["error"] == "falscherbefragernameoderpasswort") {
      echo '<p align="center" style="color: red;">Passwort oder Befragername ist nicht korrekt!</p>';
    }
    else if ($_GET["error"] == "keineübereinstimmung") {
      echo '<p align="center" style="color: red;">Stellen Sie sicher, dass Sie sich bereits <a href=Befragerregistrierung.php>registriert</a> haben!</p>';
    }
    else if ($_GET["error"] == "keinbefrager") {
      echo '<p align="center" style="color: red;">Sie müssen sich zunächst <a href=Befragerregistrierung.php>registrieren</a> um sich erfolgreich anzumelden!</p>';
    }
  }
  else if (isset($_GET["anmeldung"])) {
    if ($_GET["anmeldung"] == "erfolgreich") {
      echo '<p align="center" style="color: red;">Ihre Registrierung war erfolgreich! Melden Sie sich jetzt mit Ihren Daten an.</p>';
    }
  }
  ?>

  <form action="includes/Befrageranmeldung.inc.php" method="post">

    <div class="container">
      <label for="befragername"><b>Befragername</b></label>
      <input type="text" placeholder="Geben Sie hier Ihren Befragername ein." name="befragername">

      <label for="password"><b>Passwort</b></label>
      <label style="color: grey; font-size: smaller">(Voraussetzung:
        mindestens 8 Zeichen, 1 Großbuchstabe, 1 Kleinbuchstabe und 1
        Zahl)</label>
      <input type="password" name="passwort" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Geben Sie hier Ihr Passwort ein." title="Muss beinhalten: eine Zahl, ein Großbuchstabe, ein Kleinbuchstabe und 8 oder mehr Eingaben">

      <button type="submit" name="befrageranmeldung">Jetzt anmelden!</button>

      <span style="font-size: small">Haben Sie sich noch nicht <a href=Befragerregistrierung.php>registriert</a>?</span>
    </div>
  </form>

  <div align="right" style="padding-top: 10px">
    <a href=Startseite.php>Zurück zur Startseite</a>
  </div>

</body>

</html>