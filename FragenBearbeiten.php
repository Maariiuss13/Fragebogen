<?php
include 'includes/header.php';
?>


<h2 align="center">Fragebogen bearbeiten</h2>

<div>
    <p>Es stehen Ihnen die Fragen des ausgewählten Fragebogens zur Auswahl. <br/>
    Sie können für den Fragebogen bestehende Fragen löschen oder neue an das Ende des Fragebogens hinzufügen. <br/>
    </p>
    
    <!-- Echo Befrager-->
    <?php
        //Deklaration Variablen
        if (isset($_POST['FragebogenBearbeiten'])){
            $_SESSION['bearbeitenFB'] = htmlspecialchars(stripslashes(trim($_POST["fbTitel"])));
        }
        echo "<p> Ersteller Fragebogen: ".$_SESSION['session_bname']."</p><br/>";
        echo "<p> Ersteller Fragebogen: ".$_SESSION['bearbeitenFB']."</p><br/>";
    ?>

    <form action="includes/dbDeleteFragen_SeitBearb.php" method="post">
        <fieldset>
            <label for="fbTitelAlt">Fragen</label>
            <select name="fragen">
                <?php
                    //Template für prepared statement
                    $sql= "SELECT * FROM fragen WHERE Titel=?;";
                    // prepared statement erstellt
                    $stmt= mysqli_stmt_init($conn);
                    // prepared statement vorbereiten
                    if (!mysqli_stmt_prepare($stmt, $sql)){
                        header("Location: ../FragenBearbeiten.php?error=SQLBefehlFehler");
                    }
                    else{
                        //Verknüpfung Parameter zu Placeholder
                        mysqli_stmt_bind_param($stmt, "s", $_SESSION['bearbeitenFB']);
                        //Parameter in DB verwenden
                        mysqli_stmt_execute($stmt);
                        //Daten/Ergebnis aus execute-Fkt in Variable verwenden
                        $result= mysqli_stmt_get_result($stmt);
                        //Ergebnis ausgeben
                        while($row= mysqli_fetch_assoc($result)){
                            echo "<option>".$row['Fragestellung']."</option>";
                        }
                    } 
                ?>
            </select>
            </br> </br>
            <input type="submit" name="löschenFrage" value="Frage löschen">
        </fieldset>
        </br> </br>
    </form>

    <form action="includes/dbInsertFragenBearbeiten.php" method="post">
        <fieldset>
            <label for="neueFrage">Neue Frage</label>
            <input type="text" placeholder="Titel" name="neueFrage">
                </br></br>
            <input type="submit" name="speichernNeueFrage" value="Frage speichern">
        </fieldset>
    </form>
    </br> </br>
    <form action="Befrager.php" method="post">
        <input type="submit" name="fragenAbschluss" value="Bearbeitung beenden">
    </form>

</div>


</body>
</html>