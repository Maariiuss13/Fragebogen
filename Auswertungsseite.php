<?php include 'includes/header.php';
include 'includes/dbHandler.php';
$sql= "SELECT * FROM frageboegen WHERE befrager = 'Marius';";
        $result = mysqli_query($conn, $sql);
        if ($result) {
          $resultArray = mysqli_fetch_all($result,MYSQLI_ASSOC);
          //print_r($resultArray);
        } 

$sql= "SELECT * FROM bearbeitenfb WHERE titel = 'Studium';";
$result = mysqli_query($conn, $sql);
if ($result) {
  $resultArray2 = mysqli_fetch_all($result,MYSQLI_ASSOC);
}

$sql= "SELECT * FROM fragen WHERE titel = 'Studium';";
$result = mysqli_query($conn, $sql);
if ($result) {
  $resultArray3 = mysqli_fetch_all($result,MYSQLI_ASSOC);
}

?>
  <link href="Auswertungsdesign.css" rel="stylesheet">


  <div class="container">
    <h1 align="center"><b>Willkommen auf der Auswertungsseite des Fragebogens!</b></h1>   
</div>

 
  <br />
  <div class="main">
    <?php 
    echo '<p>Name Fragenbogen: '.$resultArray[1]["Titel"].'</p>';
    echo '<p>Zeitstempel Auswertung: <input type="number" name="mwst" size="2" value="" readonly></p>';
    echo '<p>Anzahl Teilnehmer: <input type="number" name="mwst" size="2" value="" readonly></p>';
    ?>
  </div>
  <br />
  <div class="table">
    <table border="1">
      <tr>
        <th>Frage</th>
        <th>Durchschnitt</th>
        <th>Min</th>
        <th>Max</th>
        <th>Standardabweichung</th>
      </tr>
      <tr>
      <?php
      echo '<td>'.$resultArray3[0]["Fragestellung"].'</td>';
      ?>
      </tr>
    </table>
  </div>
  <br />
  <div class="comments">
    <p>Liste Kommentare</p>
    <table border="1">
    
      <tr>
      <?php
        echo '<th>Kommentare</th>';
        

      
      echo '</tr>';
      echo '<tr>';
      echo '<td>'.$resultArray2[0]["Kommentar"].'</td>';
      ?>
   </tr>
   
    </table>
  </div>

</body>

</html>