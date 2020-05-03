<?php
include 'includes/header.php';
?>
  
  <h2 align="center">Fragebogen Bearbeiten</h2>
  <div>
    <p>Bitte wählen Sie einen Fragebogen aus, bei welchem Sie die Fragen bearbeiten möchten. <br/>
    Der Titel kann nicht geändert werden. <br/>
    </p>
    
    <!-- Echo Befrager-->
    <?php
        $befrager=$_SESSION['session_bname'];
        echo "<p> Ersteller Fragebogen: ".$befrager."</p><br/>";
    ?>

    <form action="Fragenseiten.php" method="post">
        <fieldset>
            <legend>Fragebogen zur Bearbeitung auswählen</legend>
            <label for="fbTitel">Fragebogen</label>
            <select name="fbTitel">
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
        <input type="submit" name="FragebogenBearbeiten" value="Fragebogen bearbeiten">
    </form>

</div>


</body>
</html>