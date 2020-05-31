<?php
include 'includes/header.php';

//aus DB freigegebene Fragebogen des Studenten holen
$mnr = $_SESSION['session_mnr'];
?>
<link href="Logindesign.css" rel="stylesheet">

<h2 align="center">Studenten Startseite</h2>

<form action="Fragenseiten.php" method="post">
    <div class="container">
        <label for="fragebogen"><b>Fragebogen (offen)</b></label>
        <br><br>
        <select style="padding: 12px 7px" name="fbTitel" size="0" readonly>
            <?php
            //Template für prepared statement
            $sql = "SELECT titel FROM freischaltenfb WHERE freischaltenfb.Titel NOT IN (SELECT bearbeitenfb.Titel from bearbeitenfb)";
            // prepared statement erstellt
            $stmt = mysqli_stmt_init($conn);
            // prepared statement vorbereiten
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../Studenten.php?error=SQLBefehlFehler");
            } else {
                //Verknüpfung Parameter zu Placeholder
                mysqli_stmt_bind_param($stmt, "s", $student);
                //Parameter in DB verwenden
                mysqli_stmt_execute($stmt);
                //Daten/Ergebnis aus execute-Fkt in Variable verwenden
                $result = mysqli_stmt_get_result($stmt);
                //Ergebnis ausgeben
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option>" . $row['titel'] . "</option>";
                }
            }
            ?>
        </select>
        <button type="submit" name="FragebogenBearbeiten">Fragebogen starten!</button>
    </div>
</form>

<form action="Fragenseiten.php" method="post">

    <div class="container">
        <label for="fragebogen"><b>Fragebogen (in Bearbeitung)</b></label>
        <br><br>
        <select style="padding: 12px 7px" name="fbTitel" size="0" readonly>
            <?php
            //Template für prepared statement
            $sql = "SELECT titel FROM freischaltenfb f, kurse k, studenten s WHERE f.Kurs = k.Kuerzel AND s.Kurs = k.Kuerzel AND s.MNR = '" . $mnr . "'";
            // prepared statement erstellt
            $stmt = mysqli_stmt_init($conn);
            // prepared statement vorbereiten
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../Studenten.php?error=SQLBefehlFehler");
            } else {
                //Verknüpfung Parameter zu Placeholder
                mysqli_stmt_bind_param($stmt, "s", $student);
                //Parameter in DB verwenden
                mysqli_stmt_execute($stmt);
                //Daten/Ergebnis aus execute-Fkt in Variable verwenden
                $result = mysqli_stmt_get_result($stmt);
                //Ergebnis ausgeben
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option>" . $row['titel'] . "</option>";
                }
            }
            ?>
        </select>
        <button type="submit" name="FragebogenBearbeiten" value="Fragebogen bearbeiten">Fragebogen starten!</button>
    </div>
</form>





<?php
/*
        //aus DB freigegebene Fragebogen des Studenten holen
        $student = $_SESSION['session_mnr'];
        //Template für prepared statement
        $sql = "SELECT titel FROM bearbeitenFB WHERE MNR=?;";
        // prepared statement erstellt
        $stmt = mysqli_stmt_init($conn);
        // prepared statement vorbereiten
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../Studenten.php?error=SQLBefehlFehler");
        } else {
            //Verknüpfung Parameter zu Placeholder
            mysqli_stmt_bind_param($stmt, "s", $student);
            //Parameter in DB verwenden
            mysqli_stmt_execute($stmt);
            //Daten/Ergebnis aus execute-Fkt in Variable verwenden
            $result = mysqli_stmt_get_result($stmt);
            //Ergebnis ausgeben
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option>" . $row['titel'] . "</option>";
            }
        }
        */
?>