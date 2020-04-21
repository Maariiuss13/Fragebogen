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

  <form action="Befrager.php" method="post">

    <div class="container">
      <label for="befragername"><b>Befragername</b></label>
      <input type="text" placeholder="Befragername" name="befragername" required>

      <label for="psw"><b>Passwort</b></label>  
      <label style="color: grey; font-size: smaller">(Voraussetzung:
        mindestens 8 Zeichen, 1 Großbuchstabe, 1 Kleinbuchstabe und 1
        Zahl)</label>
      <input type="password" placeholder="Passwort" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" placeholder="Passwort"
        title="Muss beinhalten: eine Zahl, ein Großbuchstabe, ein Kleinbuchstabe und 8 oder mehr Eingaben" required>

        <button type="submit">Jetzt anmelden!</button>

      <span style="font-size: small">Haben Sie sich noch nicht <a
          href=Befragerregistrierung.php>registriert</a>?</span>
    </div>
  </form>

  <div align="right" style="padding-top: 10px">
    <a href=Startseite.php>Zurück zur Startseite</a>
  </div>

</body>
</html>