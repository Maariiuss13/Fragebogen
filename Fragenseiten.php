<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Fragenseiten</title>
  <link href="Fragenseitendesign.css" rel="stylesheet">
</head>
<body>
  <header>
    Header Text
  </header>
  <section class="welcome">
    <h1>Willkommen auf der Fragenseite!</h1>
    <p>Some subtitle message</p>
  </section>
  <section class="questions">
    <p class="abc">Anzeige Seite 1</p>
    <input class="def" type="text" value="Frage ?!?!?">
    <div class="question-wrapper">
      <p id="question"></p>
      <input class="rating" type="number" placeholder="Rating (0 - 9)">
    </div>
    <div class="actions">
      <button id="back-btn" class="hidden">Zurück!</button>
      <button id="continue-btn">Weiter</button>
    </div>
  </section>
  <script src="./Fragenseite.index.js"></script>
</body>
</html>
