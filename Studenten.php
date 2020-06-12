<?php
include 'includes/header.php';
include 'includes/functions.php';

//aus DB freigegebene Fragebogen des Studenten holen
$mnr = $_SESSION['session_mnr'];
?>

<h2 align="center">Studenten Startseite</h2>

<form action="Fragenseiten.php" method="post">
    <fieldset>
        <legend>Offene Fragebogen</legend>
        <select style="padding: 12px 7px" name="fbTitel" size="0" readonly>
            <?php
            // Funktion, die alle offenen Fragebögen für den Student die in der Datenbank gespeichert sind, anzeigt
            offeneFragebogen($conn, $sql, $mnr);
            ?>
        </select>
        <button type="submit" name="FragebogenBearbeiten">Fragebogen starten!</button>
    </fieldset>
</form>

<form action="Fragenseiten2.php" method="post">
    <fieldset>
        <legend>Fragebogen in Bearbeitung</legend>
        <select style="padding: 12px 7px" name="fbTitel" size="0" readonly>
            <?php
            // Funktion, die alle Fragebögen für den Student, welche in Bearbeitung sind, die in der Datenbank gespeichert sind, anzeigt
            fragebogenInBearbeitung($conn, $sql, $student);
            ?>
        </select>
        <button type="submit" name="FragebogenBearbeiten2" value="Fragebogen bearbeiten">Fragebogen starten!</button>
    </fieldset>
</form>