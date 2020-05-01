<?php include 'includes/header.php';
include 'includes/dbHandler.php';
$sql= "SELECT * FROM frageboegen WHERE befrager = 'Marius';";
        $result = mysqli_query($conn, $sql);
        if ($result) {
          $resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
          print_r($resultArray);
        } 
?>
  <link href="Auswertungsdesign.css" rel="stylesheet">


  <div class="container">
    <h1 align="center"><b>Willkommen auf der Auswertungsseite des Fragebogens!</b></h1>   
</div>

 
  <br />
  <div class="main">
    <?php 
    echo '<p>Name Fragenbogen: '.$resultArray[0]["Titel"].'</p>';
    echo '<p>Zeitstempel Auswertung: <input type="number" name="mwst" size="2" value="" readonly></p>';
    echo '<p>Anzahl Teilnehmer: <input type="number" name="mwst" size="2" value="" readonly></p>';
    ?>
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