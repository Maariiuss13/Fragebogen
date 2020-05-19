<?php
include 'includes/header.php';
?>

<link href="Logindesign.css" rel="stylesheet">

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

    <div class="container">
        <label for="kurskuerzel"><b>Kurs</b></label>
        <select style="padding: 12px 7px" name="kurskuerzel" size="0" readonly>
            <?php
            $sql = "SELECT Kuerzel FROM kurse";
            //Speicherung Ergebnis in Variable
            $result = mysqli_query($conn, $sql);
            while ($rows = $result->fetch_assoc()) {
                $Kuerzel = $rows['Kuerzel'];
                echo "<option value='$Kuerzel'>$Kuerzel</option>";
            }
            ?>
        </select>
        <br><br>
        <label for="fragebogentitel"><b>Fragebogen</b></label>
        <select style="padding: 12px 7px" name="fragebogentitel" size="0" readonly>
            <?php
            $sql = "SELECT Titel FROM frageboegen";
            //Speicherung Ergebnis in Variable
            $result2 = mysqli_query($conn, $sql);
            while ($rows = $result2->fetch_assoc()) {
                $Titel = $rows['Titel'];
                echo "<option value='$Titel'>$Titel</option>";
            }
            ?>
        </select>

        <button type="submit" name="fragebogenzuordnen">Fragebogen dem Kurs zuordnen!</button>
    </div>
</form>

<div align="right" style="padding-top: 10px">
    <a href=Befrager.php>Zurück zur Startseite der Befrager</a>
</div>