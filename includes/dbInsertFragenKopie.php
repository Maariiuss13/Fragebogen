<!-- Autor: Dajana Thoebes, Lukas Ströbele (Cross-Site-Scripting) -->
<?php
include 'dbHandler.php';
include 'functions.php';
session_start();


// Deklaration Variablen
$frage = htmlspecialchars(stripslashes(trim($_POST["neueFrage"])));
$titel = $_SESSION["KopieFB"];
$befrager = $_SESSION["session_bname"];

//FrageNr festlegen
$sqlFr = "SELECT MAX(FrageNr) AS maxAnz FROM Fragen Where Titel='$titel';";
$frageNr = defineFrageNr($conn, $sqlFr);


//neuen Fragebogen speichern
if (isset($_POST["speichernNeueFrage"])) {
    //Prüfen, ob Felder befüllt 
    if (empty($frage)) {
        header("Location: ../FragenBearbeiten.php?error=leerefelder");
        exit();
    }
    //Prüfen, ob Titel länger als 10 Char
    elseif (strlen($frage) > 100) {
        header("Location: ../FragenBearbeiten.php?error=TitelZuLang");
        exit();
    } 
    else {
        //Insert SQL-Befehl Frage
        $sql = "INSERT INTO fragen(FrageNr, Titel, Fragestellung) VALUES(?, ?, ?);";
        $sqlerror="Location: ../FragenKopieBearbeiten.php?error=SQLBefehlFehlerFB";
        insertFrage($conn, $sql, $frageNr, $titel, $frage, $sqlerror);
    }
}

//Aktualisieren Seite FragenBearbeiten
header("Location: ../FragenKopieBearbeiten.php?FrageEinfügen=erfolgreich");
