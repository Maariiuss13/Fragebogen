<?php
include 'includes/header.php';
?>


<h2 align="center">Studenten Startseite</h2>

<table border=1>
    <tr>
        <td>Fragebogen</td>
        <td>Status</td>
        <td>An Fragebogen teilnehmen</td>
    </tr>
    <td>
        <?php
        $sql= "SELECT titel FROM frageboegen";
        //Speicherung Ergebnis in Variable
        $result= mysqli_query($conn, $sql);
        while ($rows = $result->fetch_assoc()) {
            $Titel = $rows['titel'];
            echo "<option value='$Titel'>$Titel</option>";
        }
        ?>
    </td>
</table>