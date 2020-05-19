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
            // Echo Erstellte Fragebögen des angemeldeten Befragers
            $befrager = $_SESSION['session_bname'];
            //Template für prepared statement
            $sql = "SELECT Kuerzel FROM kurse";
            // prepared statement erstellt
            $stmt = mysqli_stmt_init($conn);
            // prepared statement vorbereiten
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../Studenten.php?error=SQLBefehlFehler");
            } else {
                //Verknüpfung Parameter zu Placeholder
                mysqli_stmt_bind_param($stmt, "s", $befrager);
                //Parameter in DB verwenden
                mysqli_stmt_execute($stmt);
                //Daten/Ergebnis aus execute-Fkt in Variable verwenden
                $result = mysqli_stmt_get_result($stmt);
                //Ergebnis ausgeben
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option>" . $row['Kuerzel'] . "</option>";
                }
            }
            ?>
        </select>
        <br><br>
        <label for="fragebogentitel"><b>Fragebogen</b></label>
        <select style="padding: 12px 7px" name="fragebogentitel" size="0" readonly>
            <?php
            // Echo Erstellte Fragebögen des angemeldeten Befragers
            $befrager = $_SESSION['session_bname'];
            //Template für prepared statement
            $sql = "SELECT Titel FROM frageboegen";
            // prepared statement erstellt
            $stmt = mysqli_stmt_init($conn);
            // prepared statement vorbereiten
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../Studenten.php?error=SQLBefehlFehler");
            } else {
                //Verknüpfung Parameter zu Placeholder
                mysqli_stmt_bind_param($stmt, "s", $befrager);
                //Parameter in DB verwenden
                mysqli_stmt_execute($stmt);
                //Daten/Ergebnis aus execute-Fkt in Variable verwenden
                $result = mysqli_stmt_get_result($stmt);
                //Ergebnis ausgeben
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option>" . $row['Titel'] . "</option>";
                }
            }
            ?>
        </select>

        <button type="submit" name="fragebogenzuordnen">Fragebogen dem Kurs zuordnen!</button>
    </div>
</form>

<div align="right" style="padding-top: 10px">
    <a href=Befrager.php>Zurück zur Startseite der Befrager</a>
</div>