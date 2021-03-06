<!-- Autor: Dajana Thoebes -->
<?php
include 'includes/header.php';
?>

<h2 align="center">Fragebogen Löschen</h2>
  <div>
    <p>Bitte wählen Sie einen Fragebogen aus, bei welchem Sie die Fragen löschen möchten. <br/>
    Es können nur Fragebogen gelöscht werden, welche noch nicht von Studenten bearbeitet worden sind. </br>
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
                // Echo Erstellte Fragebögen des angemeldeten Befragers
                    $befrager=$_SESSION['session_bname'];
                    //Template für prepared statement
                    $sql= "SELECT titel FROM frageboegen WHERE Befrager=? AND frageboegen.titel NOT IN (SELECT bearbeitenfb.Titel from bearbeitenfb);";
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
        <input type="submit" name="FragebogenLöschen" value="Fragebogen löschen">
    </form>

    <form action="Befrager.php" method="post">
        <input type="submit" name="fragenAbschluss" value="Bearbeitung beenden">
    </form>

</div>