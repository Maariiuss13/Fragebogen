<?php
include 'dbHandler.php';
include 'functions.php';
session_start();


// Deklaration Variablen
$titel = $_POST["titelFragebogen"];
$beschreibung = $_POST["beschreibungFB"];
$befrager = $_SESSION["session_bname"];

//Deklaration Session-Variablen für Fragenseiten
$_SESSION["anzFragen"] = $_POST["anzahlFragen"];
$_SESSION["aktFB"] = $_POST["titelFragebogen"];
$_SESSION["aktSeite"] = 1;


if(isset($_POST["speichernFragebogen"])){
    //Prüfen, ob Felder befüllt 
    if(empty($titel) || empty($beschreibung)){
        header("Location: ../FragebogenNeu.php?error=leerefelder");
        exit();
    }
    //Prüfen, ob AnzahlFragen > 0
    if(($_POST["anzahlFragen"]<=0)){
        header("Location: ../FragebogenNeu.php?error=AnzahlFragenKleinerGleichNull");
        exit();
    }
    //Prüfen, ob Titel länger als 10 Char
    if(strlen($titel)>10){
        header("Location: ../FragebogenNeu.php?error=TitelZuLang");
        exit();
    } 
    else{
        //Prüfung doppelter Titel
        $sqlTitel="SELECT titel FROM frageboegen WHERE titel=?;";
        //Funktion zum Prüfen, ob Titel bereits in DB vorhanden
        checkTitelDB($conn, $sqlTitel, $titel);


        //Insert Fragebogen
        $sql= "INSERT INTO frageboegen(titel, beschreibung, befrager) VALUES(?, ?, ?);";
        //prepared statement erstellen
        insertFragebogenNeu($conn, $sql, $titel, $beschreibung, $befrager);
    }
}



//Weiterleitung auf Fragen-Seite
if (!$sql) {
    echo mysqli_error($sql);
}
else {
    header("Location: ../FragenseitenNeu.php?FragebogenSpeichern=erfolgreich");
}
