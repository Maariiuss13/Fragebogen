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
            offeneFragebogen($conn, $sql, $student);
            ?>
        </select>
        <button type="submit" name="FragebogenBearbeiten">Fragebogen starten!</button>
    </fieldset>
</form>

<form action="Fragenseiten.php" method="post">
    <fieldset>
        <legend>Fragebogen in Bearbeitung</legend>
        <select style="padding: 12px 7px" name="fbTitel" size="0" readonly>
            <?php
            fragebogenInBearbeitung($conn, $sql, $student);
            ?>
        </select>
        <button type="submit" name="FragebogenBearbeiten" value="Fragebogen bearbeiten">Fragebogen starten!</button>
    </fieldset>
</form>