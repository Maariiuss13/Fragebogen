<?php include 'includes/header.php';
require 'includes/dbHandler.php';
include 'includes/functions.php';

if (isset($_POST['aktion']) and $_POST['aktion']=='Speichern') {
  
  $kommentar = "";
  if (isset($_POST['kommentar'])) {
      $kommentar = trim($_POST['kommentar']);
  }
  $erstellt = date("Y-m-d H:i:s");
  if ( $kommentar != '' )
  {
      // speichern
      $einfuegen = $db->prepare("
              INSERT INTO kontakte (kommentar, erstellt) 
              VALUES ( ?, NOW())
              ");
      $einfuegen->bind_param('s', $kommentar);
      if ($einfuegen->execute()) {
          header('Location: ../Startseite.php?aktion=feedbackgespeichert');
          die();
          echo "<h1>gespeichert</h1>";
      }
  }   
}
if (isset($_GET['aktion']) and $_GET['aktion']=='feedbackgespeichert') {
  echo '<p class="feedbackerfolg">Datensatz wurde gespeichert</p>';
}
$daten = array();
if ($erg = $conn->query("SELECT * FROM bearbeitenfb")) {
  if ($erg->num_rows) {
      while($datensatz = $erg->fetch_object()) {
          $daten[] = $datensatz;
      }
      $erg->free();
  }   
}
if (!count($daten)) {
  echo "<p>Es liegen keine Daten vor :(</p>";
} else {
?>
  <table>
      <thead>
          <tr>
              <th>Kommentar</th>
              <th>erstellt</th>
          </tr>
      </thead>
      <tbody>
          <?php
          foreach ($daten as $inhalt) {
          ?>
              <tr>
                  
                  <td><?php echo bereinigen($inhalt->kommentar); ?></td>
                  <td><?php echo $inhalt->erstellt; ?></td>
              </tr>
          <?php
          }
          ?>
      </tbody>
  </table>
<?php   
}
function bereinigen($inhalt='') {
  $inhalt = trim($inhalt);
  $inhalt = htmlentities($inhalt, ENT_QUOTES, "UTF-8");
  return($inhalt);
}
?>




  <link href="Abschlussseitedesign.css" rel="stylesheet">



<div class="container">
    <h1 align="center"><b>Willkommen auf der Abschlussseite des Fragebogens!</b></h1>   
</div>
<br/>
<div class="text">
<label for="fbTitel">Wählen Sie einen Fragebogen aus: </label>
            <select name="fbTitel">
                <?php
                    titelFragebogen($conn, $sql, $befrager);
                ?>
            </select>
  <p>Wir bedanken uns recht herzlich bei Ihrer aktiven Teilnahme! Bis zum nächsten Mal!</p>
  <p>Falls es noch Anmerkungen geben sollte, können Sie diese gerne hier eintragen:</p>
  <label for="text">Anmerkung</label><br/>
      <textarea id="text" name="text" cols="35" rows="4"></textarea><br/> 	
      <input type="hidden" name="aktion" value="Speichern">
      <input type="submit" value="Speichern">
</div>

</body>

</html>