<?php
include 'includes/header.php';
?>


<h2 align="center">Fragebogen Kopieren</h2>

<div>
    <p>Bitte wählen Sie einen Fragebogen aus, welchen Sie kopieren möchten. <br/>
    Wählen Sie einen neuen Titel für den Fragebogen aus. <br/>
    Sollte der gewählte Titel bereits vergeben sein, erhalten Sie eine entsprechende Fehlermeldung.
    </p>
    
    <!-- Echo Befrager-->
    <?php
        $befrager=$_SESSION['session_bname'];
        echo "<p> Ersteller Fragebogen: ".$befrager."</p><br/>";
    ?>

    <form action="includes/dbInsertFragebogenKopie.php" method="post">
        <fieldset>
            <legend>Fragebogen auswählen und neuen Titel eingeben</legend>
            <label for="fbTitelAlt">Alter Fragebogen</label>
            <select name="fbTitelAlt">
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
            </br> </br>
            <label for="fbTitelNeu">Neuer Titel Fragebogen</label>
            <input type="text" placeholder="Titel" name="fbTitelNeu">
        </fieldset>
        </br> </br>
        <input type="submit" name="speichernFragebogenKopie" value="Fragebogen kopieren und speichern">
    </form>

</div>


</body>
</html>