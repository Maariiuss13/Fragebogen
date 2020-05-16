<?php
include 'dbHandler.php';
session_start();


// Deklaration Variablen
$frage = $_POST["fragen"];
$befrager = $_SESSION["session_bname"];


if (isset($_POST["löschenFrage"])) {
    //Prüfen, ob DS zu Befrager gehört, fehlt!!!!!!!!!!!!
    //Delete Frage
    $sql = "DELETE FROM Fragen WHERE Fragestellung = '$frage';";
    mysqli_query($conn, $sql);
    //Update Fragennr notwendig? !!!!!!!!!!!!!!!!!!
}


//Aktualisierung FragenBearbeiten-Seite
if (!$sql) {
    echo mysqli_error($sql);
} else {
    header("Location: ../FragenBearbeiten.php?FrageLöschen=erfolgreich");
}