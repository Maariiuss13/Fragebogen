<?php
include 'dbHandler.php';
session_start();


// Deklaration Variablen
$frage = $_POST["neueFrage"];
$titel = $_SESSION["KopieFB"];
$befrager = $_SESSION["session_bname"];

//FrageNr festlegen
$sqlFr = "SELECT MAX(FrageNr) AS maxAnz FROM Fragen Where Titel='$titel';";
//Senden Befehl an DB und Ausführen
$frErg = mysqli_query($conn, $sqlFr);
//Zuweisung Ergebnis einer Variable
$anzFr = mysqli_fetch_assoc($frErg);
//FrageNr definieren
$frageNr = $anzFr['maxAnz']+1;

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
        //prepared statement erstellen
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../FragenBearbeiten.php?error=SQLBefehlFehlerFB");
            exit();
        } else {
            //Verknüpfung Parameter mit Placeholdern
            mysqli_stmt_bind_param($stmt, "sss", $frageNr, $titel, $frage);
            //Run Code in DB
            mysqli_stmt_execute($stmt);
            //mysqli_stmt_close($stmt);
        }
    }
}




//Aktualisieren Seite FragenBearbeiten
if (!$sql) {
    echo mysqli_error($sql);
} else {
    header("Location: ../FragenKopieBearbeiten.php?FrageEinfügen=erfolgreich");
}