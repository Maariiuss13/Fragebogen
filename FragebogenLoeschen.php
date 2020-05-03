<?php
include 'includes/header.php';
?>

<h2 align="center">Fragebogen Löschen</h2>
  <div>
    <p>Bitte wählen Sie einen Fragebogen aus, bei welchem Sie die Fragen löschen möchten. <br/>
    Dieser Vorgang kann nicht rückgängig gemacht werden, alle zu dem Fragebogen zugehörigen Fragen werden ebenfalls gelöscht. <br/>
    </p>
    
    <!-- Echo Befrager-->
    <?php
        $befrager=$_SESSION['session_bname'];
        echo "<p> Ersteller Fragebogen: ".$befrager."</p><br/>";
    ?>

    <form action="includes/dbDeleteFragebogen.php" method="post">
        <fieldset>
            <legend>Fragebogen zum Löschen auswählen</legend>
            <label for="titelFragebogen">Fragebogen</label>
            <select name="titelFragebogen">
                <?php
                    //Abfrage SQL
                    $befrager=$_SESSION['session_bname'];
                    $sql= "SELECT titel FROM frageboegen WHERE Befrager='$befrager';";
                    //Speicherung Ergebnis in Variable
                    $result= mysqli_query($conn, $sql);
                    //Ausgabe Ergebnis
                    while($row= mysqli_fetch_assoc($result)){
                    echo "<option>".$row['titel']."</option>";
                    }
                ?>
            </select>
        </fieldset>
        </br> </br>
        <input type="submit" name="FragebogenLöschen" value="Fragebogen löschen">
    </form>

</div>