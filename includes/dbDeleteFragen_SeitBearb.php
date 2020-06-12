<?php
include 'dbHandler.php';
include 'functions.php';
session_start();


// Deklaration Variablen
$frage = htmlspecialchars(stripslashes(trim($_POST["fragen"])));
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
    $sqlerror="Location: ../FragenBearbeiten.php?error=SQLBefehlFehler";
    deleteFragen($conn, $sql, $titelFB, $frageNr, $sqlerror);
    
    //Update Fragennr
    $sqlSel= "SELECT * FROM fragen WHERE titel=? ORDER BY 'FrageNr';";
    $sqlerror="Location: ../FragenBearbeiten.php?error=SQLBefehlFehler";
    updatefragenr($conn, $sqlSel, $titelFB, $sqlerror);
}


//Aktualisierung FragenBearbeiten-Seite
header("Location: ../FragenBearbeiten.php?FrageLöschen=erfolgreich");