<?php
include 'dbHandler.php';
include 'functions.php';
session_start();


// Deklaration Variablen
$frage = $_POST["fragen"];
$befrager = $_SESSION["session_bname"];
$titelFB = $_SESSION['bearbeitenFB'];


if (isset($_POST["löschenFrage"])) {
    //Select Fragennr zu ausgewählter Frage
    $sqlNr= "SELECT * FROM Fragen WHERE Titel = '$titelFB' AND Fragestellung = '$frage'";
    $result = mysqli_query($conn, $sqlNr);
    $row = mysqli_fetch_assoc($result);
    $frageNr = $row['FrageNr'];

    //Prüfen, ob DS zu Befrager gehört, fehlt!!!!!!!!!!!!
    //Delete Frage
    $sql = "DELETE FROM Fragen WHERE Titel = ? AND FrageNr= ?;";
    deleteFragen($conn, $sql, $titelFB, $frageNr);
    //Update Fragennr notwendig? !!!!!!!!!!!!!!!!!!
}


//Aktualisierung FragenBearbeiten-Seite
if (!$sql) {
    echo mysqli_error($sql);
} else {
    header("Location: ../FragenBearbeiten.php?FrageLöschen=erfolgreich");
}