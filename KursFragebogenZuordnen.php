<?php
include 'includes/header.php';
include 'includes/functions.php';
?>

<h2 align="center">Fragebogen einem Kurs zuordnen</h2>

<?php
// Fehlermeldungen bzw. Erfolgsmeldungen, die bei Unstimmigkeiten 
// bzw. Erfolg bei der Anmeldung geworfen werden 
if (isset($_GET["fragebogenzuordnen"])) {
    if ($_GET["fragebogenzuordnen"] == "erfolgreich") {
        echo '<p align="center" style="color: red;">Der Fragebogen wurde erfolgreich dem ausgewählten Kurs zugeordnet!</p>';
    }
}
?>

<form action="includes/FragebogenKursZuordnen.inc.php" method="post">

    <fieldset>
        <legend>Zuordnung</legend>
        <label for="kurskuerzel"><b>Kurs</b></label>
        <select style="padding: 12px 7px" name="kurskuerzel" size="0" readonly>
            <?php
            // Funktion, die alle Kurse die in der Datenbank gespeichert sind, anzeigt
            kurse($conn, $sql);
            ?>
        </select>
        <br><br>
        <label for="fragebogentitel"><b>Fragebogen</b></label>
        <select style="padding: 12px 7px" name="fragebogentitel" size="0" readonly>
            <?php
            // Funktion, die alle Fragebögen die in der Datenbank gespeichert sind, anzeigt
            frageboegen($conn, $sql, $befrager);
            ?>
        </select>
        <br><br>
        <button type="submit" name="fragebogenzuordnen">Fragebogen dem Kurs zuordnen!</button>
    </fieldset>
</form>

<div align="right" style="padding-top: 10px">
    <a href=Befrager.php>Zurück zur Startseite der Befrager</a>
</div>