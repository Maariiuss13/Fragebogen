<?php
include 'includes/header.php';

$mnr = $_SESSION['session_mnr'];
?>
<link href="Logindesign.css" rel="stylesheet">

<h2 align="center">Studenten Startseite</h2>

<form action="includes/FragebogenBearbeiten.inc.php" method="post">

    <div class="container">
        <label for="fragebogen"><b>Fragebogen (offen)</b></label>
        <select style="padding: 12px 7px" name="fragebogen" size="0" readonly>
            <?php
            $sql = "SELECT titel FROM freischaltenfb f, kurse k, studenten s WHERE f.Kurs = k.Kuerzel AND s.Kurs = k.Kuerzel AND s.MNR = '" . $mnr . "'";
            //Speicherung Ergebnis in Variable
            $result = mysqli_query($conn, $sql);
            while ($rows = $result->fetch_assoc()) {
                $Titel = $rows['titel'];
                echo "<option value='$Titel'>$Titel</option>";
            }
            ?>
        </select>
        <br><br>
        <label for="fragebogen"><b>Fragebogen (in Bearbeitung)</b></label>
        <select style="padding: 12px 7px" name="fragebogen" size="0" readonly>
            <?php
            $sql = "SELECT titel FROM freischaltenfb f, kurse k, studenten s WHERE f.Kurs = k.Kuerzel AND s.Kurs = k.Kuerzel AND s.MNR = '" . $mnr . "'";
            //Speicherung Ergebnis in Variable
            $result = mysqli_query($conn, $sql);
            while ($rows = $result->fetch_assoc()) {
                $Titel = $rows['titel'];
                echo "<option value='$Titel'>$Titel</option>";
            }
            ?>
        </select>

        <button type="submit" name="FragebogenBearbeiten">Fragebogen starten!</button>
    </div>

<form action="Fragenseiten.php" method="post">
    <h3>Erstellte Fragebögen</h3>
    <select name="fbTitel">
        <!-- Select und echo erstellte Fragebogen vom angemeldeten Student -->
        <?php
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
        ?>
    </select>
    </br></br>
    <input type="submit" name="FragebogenBearbeiten" value="Fragebogen bearbeiten">

</form>