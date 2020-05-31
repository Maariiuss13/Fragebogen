<?php
include 'includes/header.php';
include 'includes/functions.php';
?>
  
  <h2 align="center">Fragebogen Bearbeiten</h2>
  <div>
    <p>Bitte wählen Sie einen Fragebogen aus, bei welchem Sie die Fragen bearbeiten möchten. <br/>
    Fragebogen, die bereits von Studenten bearbeitet worden, können nicht bearbeitet werden.<br/>
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
                    $sql= "SELECT titel FROM frageboegen WHERE Befrager=? AND frageboegen.titel NOT IN (SELECT bearbeitenFB.titel FROM bearbeitenFB);";
                    auswahlFbBefragerBearbeiten($conn, $sql, $befrager);  
                ?>
            </select>
        </fieldset>
        </br> </br>
        <input type="submit" name="FragebogenBearbeiten" value="Fragebogen bearbeiten">
    </form>

</div>


</body>
</html>