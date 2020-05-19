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
</form>