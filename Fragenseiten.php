<?php include 'includes/header.php'
?>
<link href = 'Fragenseitendesign.css' rel = 'stylesheet'>


<section class = 'welcome'>
<h1>Willkommen auf der Fragenseite!</h1>
<p>Some subtitle message</p>
</section>
<section class = 'questions'>
<p class = 'abc'>Anzeige Frage 1 von X</p>
<input class = 'def' type = 'text' value = 'Frage ?!?!?'>
<div class = 'question-wrapper'>
<p id = 'question'></p>
<input class = 'rating' type = 'number' placeholder = 'Rating (1 - 5)'>
</div>
<div class = 'actions'>
<button id = 'back-btn' class = 'hidden'>Zurück!</button>
<button id = 'continue-btn'>Weiter</button>
</div>
</section>
<script src = './Fragenseite.index.js'></script>
</body>
</html>
