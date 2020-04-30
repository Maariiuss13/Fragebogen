<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Auswertungsseite</title>
  <link href="Auswertungsdesign.css" rel="stylesheet">
</head>

<body>

  <div align="center">
    <table>
      <tr>
        <th><img src="Fragen.jpg" width="100%" height="15%"></th>
      </tr>
    </table>
  </div>
  <br />
  <div class="container">
    <h1 align="center"><b>Willkommen bei der Auswertung!</b></h3>
      <p align="center">Hier sehen Sie die Auswertungen der Fragen.</p>

  </div>
  <br />
  <div class="main">
    <p>Name Fragenbogen: <input type="number" name="mwst" size="2" value="" readonly></p>
    <p>Zeitstempel Auswertung: <input type="number" name="mwst" size="2" value="" readonly></p>
    <p>Anzahl Teilnehmer: <input type="number" name="mwst" size="2" value="" readonly></p>
  </div>
  <br />
  <div class="table">
    <table border="3">
      <tr>
        <th>Frage</th>
        <th>Durchschnitt</th>
        <th>Min</th>
        <th>Max</th>
        <th>Standardabweichung</th>

    </table>
  </div>
  <br />
  <div class="comments">
    <p>Liste Kommentare</p>
    <table border="3">
      <tr>
        <th>Kommentare</th>


    </table>
  </div>

</body>

</html>