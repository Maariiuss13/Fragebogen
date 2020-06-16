<!-- Autor: Lukas Ströbele -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrierung - Befrager</title>
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

  <h2 align="center">Registrierung - Befrager</h2>

  <?php
  // Fehlermeldungen, die bei Unstimmigkeiten bei der Registrierung geworfen werden
  if (isset($_GET["error"])) {
    if ($_GET["error"] == "leerefelder") {
      echo '<p align="center" style="color: red;">Füllen Sie bitte alle Felder aus!</p>';
    }
    else if($_GET["error"] == "ungültigerbefragername") {
      echo '<p align="center" style="color: red;">Dieser Befragername ist ungültig! Erlaubt sind: Buchstaben (inklusive ß, ä, ö, ü) und Zahlen.</p>';
    }
    else if($_GET["error"] == "überprüfepasswörter") {
      echo '<p align="center" style="color: red;">Ihre Passwörter stimmen nicht miteinander überein!</p>';
    }
    else if($_GET["error"] == "befragernamebereitsvergeben") {
      echo '<p align="center" style="color: red;">Dieser Befragername ist bereits vergeben!</p>';
    }
  } 
  ?>

  <form action="includes/Befragerregistrierung.inc.php" method="post">

    <div class="container">
      <label for="befragername"><b>Befragername</b></label>
      <input type="text" placeholder="Tragen Sie hier Ihren Befragername ein." name="befragername">

      <label for="passwort"><b>Passwort</b></label>
      <label style="color: grey; font-size: smaller">(Voraussetzung:
        mindestens 8 Zeichen, 1 Großbuchstabe, 1 Kleinbuchstabe und 1
        Zahl)</label>
      <input type="password" name="passwort" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Geben Sie hier Ihr Passwort ein." title="Muss beinhalten: eine Zahl, ein Großbuchstabe, ein Kleinbuchstabe und 8 oder mehr Eingaben" id="password">

      <label for="passwortWiederholen"><b>Passwort bestätigen</b></label>
      <input type="password" name="passwortWiederholen" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Wiederholen Sie Ihr Passwort." title="Muss beinhalten: eine Zahl, ein Großbuchstabe, ein Kleinbuchstabe und 8 oder mehr Eingaben" id="passwordConfirm">

      <button type="submit" name="befragerregistrierung">Jetzt registrieren!</button>
    </div>
  </form>

  <div align="right" style="padding-top: 10px">
    <a href=Startseite.php>Zurück zur Startseite</a>
  </div>

</body>

</html>