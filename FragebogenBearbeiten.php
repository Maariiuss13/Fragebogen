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

    <form action="FragenBearbeiten.php" method="post">
        <fieldset>
            <legend>Fragebogen zur Bearbeitung auswählen</legend>
            <label for="fbTitel">Fragebogen</label>
            <select name="fbTitel">
                <?php
                    $befrager=$_SESSION['session_bname'];
                    //Template für prepared statement
                    $sql= "SELECT titel FROM frageboegen WHERE Befrager=?;";
                    // prepared statement erstellt
                    $stmt= mysqli_stmt_init($conn);
                    // prepared statement vorbereiten
                    if (!mysqli_stmt_prepare($stmt, $sql)){
                        header("Location: ../Befrager.php?error=SQLBefehlFehler");
                    }
                    else{
                        //Verknüpfung Parameter zu Placeholder
                        mysqli_stmt_bind_param($stmt, "s", $befrager);
                        //Parameter in DB verwenden
                        mysqli_stmt_execute($stmt);
                        //Daten/Ergebnis aus execute-Fkt in Variable verwenden
                        $result= mysqli_stmt_get_result($stmt);
                        //Ergebnis ausgeben
                        while($row= mysqli_fetch_assoc($result)){
                            echo "<option>".$row['titel']."</option>";
                        }
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