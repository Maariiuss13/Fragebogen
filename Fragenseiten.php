<?php include 'includes/header.php';
include 'includes/dbHandler.php';
$sql= "SELECT * FROM fragen WHERE titel = 'Studium';";
$result = mysqli_query($conn, $sql);
if ($result) {
  $resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
}



?>
<link href = "Fragenseitendesign.css" rel = "stylesheet">

<section class = "welcome">
<h1>Willkommen auf der Fragenseite!</h1>
<p>Some subtitle message</p>
</section>
<section class="questions">
    <p class="abc">Anzeige Frage 1 von X</p>
    <?php
    echo '<input class="def" type="text" value="'.$resultArray[0]["Fragestellung"].'" readonly>';
    ?>
<div class = "question-wrapper">

<p>
<span class="sternebewertung">
<span id="Bewertung"><label>Bewertung:</label></span>
</br>
 <input type="radio" id="stern1" name="bewertung" value="1"><label for="stern5" title="1 Stern">1 Stern</label>
 <input type="radio" id="stern2" name="bewertung" value="2"><label for="stern4" title="2 Sterne">2 Sterne</label>
 <input type="radio" id="stern3" name="bewertung" value="3"><label for="stern3" title="3 Sterne">3 Sterne</label>
 <input type="radio" id="stern4" name="bewertung" value="4"><label for="stern2" title="4 Sterne">4 Sterne</label>
 <input type="radio" id="stern5" name="bewertung" value="5"><label for="stern1" title="5 Sterne">5 Sterne</label>
 
</span>
</p>
<p id="question"></p>
</div>
<div class = "actions">
<button id = "back-btn" class = 'hidden'>Zurück!</button>
<button id = "continue-btn">Nächste Frage</button>
</div>
</section>


<script src ="./FragenseiteIndex.js"></script>
</body>
</html>






