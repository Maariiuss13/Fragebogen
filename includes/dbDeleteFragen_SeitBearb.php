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

    //Delete Frage
    $sql = "DELETE FROM Fragen WHERE Titel = ? AND FrageNr= ?;";
    deleteFragen($conn, $sql, $titelFB, $frageNr);
    
    //Update Fragennr
    $sqlSel= "SELECT * FROM fragen WHERE titel=? ORDER BY 'FrageNr';";
    updatefragenr($conn, $sqlSel, $titelFB);
}


//Aktualisierung FragenBearbeiten-Seite
header("Location: ../FragenBearbeiten.php?FrageLöschen=erfolgreich");