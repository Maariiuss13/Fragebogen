<?php
include 'includes/header.php';
?>

<link href="Logindesign.css" rel="stylesheet">

<h2 align="center">Neuer Kurs anlegen</h2>

<?php
// Fehlermeldungen bzw. Erfolgsmeldungen, die bei Unstimmigkeiten 
// bzw. Erfolg bei der Anmeldung geworfen werden 
if (isset($_GET["error"])) {
    if ($_GET["error"] == "leerefelder") {
        echo '<p align="center" style="color: red;">Füllen Sie bitte alle Felder aus!</p>';
    } else if ($_GET["error"] == "kursnamebereitsvergeben") {
        echo '<p align="center" style="color: red;">Dieser Kursname ist bereits vergeben!</p>';
    }
} else if (isset($_GET["kursanlegen"])) {
    if ($_GET["kursanlegen"] == "erfolgreich") {
        echo '<p align="center" style="color: red;">Der Kurs wurde erfolgreich angelegt!</p>';
    }
}
?>

<form action="includes/Kursanlegen.inc.php" method="post">

    <div class="container">
        <label for="kursname"><b>Kursname</b></label>
        <input type="text" placeholder="Geben Sie hier den Namen des Kurses an." name="kursname">

        <label for="kurskuerzel"><b>Kürzel des Kurses</b></label>
        <label style="color: grey; font-size: smaller">(bestehend aus Großbuchstaben und Zahlen)</label>
        <input type="text" placeholder="Hier steht das Kürzel des Kurses." name="kurskuerzel">

        <button type="submit" name="kursanlegen">Kurs anlegen!</button>
    </div>
</form>
<br>

<h2 align="center">Neuer Student anlegen</h2>

<?php
$mysqli = new MySQLi('localhost', 'root', '', 'fragebogen_projekt');

$result = $mysqli->query("SELECT Kuerzel FROM kurse");
?>

<?php
// Fehlermeldungen bzw. Erfolgsmeldungen, die bei Unstimmigkeiten 
// bzw. Erfolg bei der Anmeldung geworfen werden 
if (isset($_GET["error"])) {
    if ($_GET["error"] == "leerefelder") {
        echo '<p align="center" style="color: red;">Füllen Sie bitte alle Felder aus!</p>';
    } else if ($_GET["error"] == "matrikelnummerbereitsvergeben") {
        echo '<p align="center" style="color: red;">Diese Matrikelnummer ist bereits vergeben!</p>';
    }
} else if (isset($_GET["studentanlegen"])) {
    if ($_GET["studentanlegen"] == "erfolgreich") {
        echo '<p align="center" style="color: red;">Der Student wurde erfolgreich angelegt!</p>';
    }
}
?>

<form action="includes/Studentanlegen.inc.php" method="post">

    <div class="container">
        <label for="kurs"><b>Kurs</b></label>
        <select style="padding: 12px 7px" name="kurs" size="0" readonly>
            <option>-- Kurs des Studenten auswählen --</option>
            <?php
            while ($rows = $result->fetch_assoc()) {
                $Kuerzel = $rows['Kuerzel'];
                echo "<option value='$Kuerzel'>$Kuerzel</option>";
            }
            ?>
        </select>
        <br><br>
        <label for="mnr"><b>Matrikelnummer des Studenten</b></label>
        <input type="text" placeholder="Geben Sie hier die Matrikelnummer des Studenten ein." name="mnr" minlength="7" maxlength="7">

        <button type="submit" name="studentanlegen">Student anlegen!</button>
    </div>
</form>

<div align="right" style="padding-top: 10px">
    <a href=Befrager.php>Zurück zur Startseite der Befrager</a>
</div>