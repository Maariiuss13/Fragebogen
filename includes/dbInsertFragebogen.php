<!-- Autor: Dajena Thoebes -->
<?php
include 'dbHandler.php';
include 'functions.php';
session_start();


// Deklaration Variablen
$titel = htmlspecialchars(stripslashes(trim($_POST["titelFragebogen"])));
$beschreibung = htmlspecialchars(stripslashes(trim($_POST["beschreibungFB"])));
$befrager = $_SESSION["session_bname"];

//Deklaration Session-Variablen für Fragenseiten
$_SESSION["anzFragen"] = htmlspecialchars(stripslashes(trim($_POST["anzahlFragen"])));
$_SESSION["aktFB"] = htmlspecialchars(stripslashes(trim($_POST["titelFragebogen"])));
$_SESSION["aktSeite"] = 1;


if(isset($_POST["speichernFragebogen"])){
    //Prüfen, ob Felder befüllt 
    if(empty($titel) || empty($beschreibung)){
        header("Location: ../FragebogenNeu.php?error=leerefelder");
        exit();
    }
    //Prüfen, ob AnzahlFragen > 0
    if((htmlspecialchars(stripslashes(trim($_POST["anzahlFragen"])))<=0)){
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
        $sqlerror= "Location: ../FragebogenNeu.php?error=sqlerror";
        $error= "Location: ../FragebogenNeu.php?error=TitelBereitsVorhanden";
        checkTitelDB($conn, $sqlTitel, $titel, $sqlerror, $error);

        //Insert Fragebogen
        $sql= "INSERT INTO frageboegen(titel, beschreibung, befrager) VALUES(?, ?, ?);";
        //prepared statement erstellen
        $sqlerror="Location: ../dbInsertFragebogen.php?error=SQLBefehlFehler";
        insertFragebogen($conn, $sql, $titel, $beschreibung, $befrager, $sqlerror);
    }
}



//Weiterleitung auf Fragen-Seite
header("Location: ../FragenseitenNeu.php?FragebogenSpeichern=erfolgreich");
