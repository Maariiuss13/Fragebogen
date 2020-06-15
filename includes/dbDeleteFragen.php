<!-- Autor: Dajena Thoebes, Lukas Ströbele (Cross-Site-Scripting) -->
<?php
include 'dbHandler.php';
include 'functions.php';
session_start();


// Deklaration Variablen
$frage = htmlspecialchars(stripslashes(trim($_POST["fragen"])));
$befrager = $_SESSION["session_bname"];
$titelFB = $_SESSION["KopieFB"];


if (isset($_POST["löschenFrage"])) {

    $sqlNr= "SELECT * FROM Fragen WHERE Titel = '$titelFB' AND Fragestellung = '$frage'";
    $result = mysqli_query($conn, $sqlNr);
    $row = mysqli_fetch_assoc($result);
    $frageNr = $row['FrageNr'];

    
    //Delete Frage
    $sql = "DELETE FROM Fragen WHERE Titel = ? AND FrageNr= ?;";
    $sqlerror="Location: ../FragenKopieBearbeiten.php?error=SQLBefehlFehler";
    deleteFragen($conn, $sql, $titelFB, $frageNr, $sqlerror);
    
    
    //Update Fragennr
    $sqlSel= "SELECT * FROM fragen WHERE titel=? ORDER BY 'FrageNr';";
    $sqlerror="Location: ../FragenKopieBearbeiten.php?error=SQLBefehlFehler";
    updatefragenr($conn, $sqlSel, $titelFB, $sqlerror);

}


//Aktualisierung FragenBearbeiten-Seite
header("Location: ../FragenKopieBearbeiten.php?FrageLöschen=erfolgreich");

