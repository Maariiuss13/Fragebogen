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

  <form action="Befrager.php" method="post">

    <div class="container">
      <label for="befragername"><b>Befragername</b></label>
      <input type="text" placeholder="Befragername" name="befragername" required>

      <label for="password"><b>Passwort</b></label> 
      <label style="color: grey; font-size: smaller">(Voraussetzung:
        mindestens 8 Zeichen, 1 Großbuchstabe, 1 Kleinbuchstabe und 1
        Zahl)</label>
      <input type="password" class="form-control" name="password" placeholder="Passwort"
        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
        title="Muss beinhalten: eine Zahl, ein Großbuchstabe, ein Kleinbuchstabe und 8 oder mehr Eingaben" required
        id="password">

      <label for="passwordConfirm"><b>Passwort bestätigen</b></label>
      <input type="password" class="form-control" name="passwordConfirm" placeholder="Passwort wiederholen"
        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
        title="Muss beinhalten: eine Zahl, ein Großbuchstabe, ein Kleinbuchstabe und 8 oder mehr Eingaben" required
        id="passwordConfirm">

      <button type="submit">Jetzt registrieren!</button>
    </div>
    <script src="Register.js"></script>
  </form>

  <div align="right" style="padding-top: 10px">
    <a href=Startseite.php>Zurück zur Startseite</a>
  </div>

</body>
</html>