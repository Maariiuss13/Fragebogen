
<?php
include 'includes/header.php';
?>

  <h2 align="center">Neuer Fragebogen</h2>

    <div>
        <p>Bitte geben Sie einen Titel für Ihren Fragebogen sowie eine Beschreibung und die Anzahl der gewünschten Fragen an. <br/>
        Beachten Sie, dass der Titel des Fragebogens einmalig sein muss. <br/>
        Sollte der gewählte Titel bereits vergeben sein, erhalten Sie eine entsprechende Fehlermeldung.
        </p>
        
        <!-- Echo Befrager-->
        <?php
            $befrager=$_SESSION['session_bname'];
            echo "<p> Ersteller Fragebogen: ".$befrager."</p><br/>";
        ?>

        <form action="includes/dbInsertFragebogen.php" method="post">
            <fieldset>
            <legend>Neuen Fragebogen erstellen</legend>

            
                <label for="titelFragebogen"><b>Titel Fragebogen</b></label>
                <input type="text" placeholder="Titel" name="titelFragebogen" required>
                <br/>

                <label for="beschreibungFB"><b>Beschreibung Fragebogen</b></label>
                <input type="text" placeholder="Beschreibung" name="beschreibungFB" required>
                <br/>
        
                <label for="anzahlFragen"><b>Anzahl Fragen</b></label>
                <input type="number" value="0" name="anzahlFragen" required>

            </fieldset>
            <br/>
            <input type="submit" name="speichernFragebogen" value="Fragebogen speichern">
        </form>
        
    </div>


</body>
</html>