<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Anmeldung - Studenten</title>
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

  <h2 align="center">Anmeldung - Studenten</h2>

  <form action="Student.php" method="post">

    <div class="container">
      <label for="mnr"><b>Matrikelnummer</b></label>
      <input type="text" placeholder="Matrikelnummer" name="mnr" minlength="7" maxlength="7" required>

      <button type="submit">Jetzt anmelden!</button>
    </div>
  </form>

  <div align="right" style="padding-top: 10px">
    <a href=Startseite.php>Zurück zur Startseite</a>
  </div>

</body>
</html>