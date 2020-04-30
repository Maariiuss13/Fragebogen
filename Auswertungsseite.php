<?php include 'includes/header.php'
?>
  <link href="Auswertungsdesign.css" rel="stylesheet">


  <div class="container">
    <h1 align="center"><b>Willkommen auf der Auswertungsseite des Fragebogens!</b></h1>   
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