<?php
include 'dbHandler.php';
//include 'functions.php';
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
    elseif(($_POST["anzahlFragen"]<=0)){
        header("Location: ../FragebogenNeu.php?error=AnzahlFragenKleinerGleichNull");
        exit();
    }
    //Prüfen, ob Titel länger als 10 Char
    elseif(strlen($titel)>10){
        header("Location: ../FragebogenNeu.php?error=TitelZuLang");
        exit();
    } 
    else{
    //Prüfung doppelter Titel
        $sqlTitel="SELECT titel FROM frageboegen WHERE titel=?;";
        //Funktion zum Prüfen, ob Titel bereits in DB vorhanden
        //checkTitelDB($conn, $sqlTitel, $titel);
                // Initialisieren mit der richtigen Verbindung
                $stmt = mysqli_stmt_init($conn);
                // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
                if (!mysqli_stmt_prepare($stmt, $sqlTitel)) {
                    // Wenn ja, dann SQL-Fehler
                    header("Location: ../FragebogenNeu.php?error=sqlerror");
                    exit();
                } 
                else {
                    // Benutzereingaben Titel
                    mysqli_stmt_bind_param($stmt, "s", $titel);
                    // Ausführen der Anweisung in der Datenbank
                    mysqli_stmt_execute($stmt);
                    // Nimmt das Ergebnis aus der Datenbank und speichert es in der Variablen $stmt
                    mysqli_stmt_store_result($stmt);
                    // Prüft die Anzahl der Ergebnisse der Variable $stmt
                    $resultCheck = mysqli_stmt_num_rows($stmt);
                    // Wenn größer 0 -> Titel schon vergeben
                    if ($resultCheck > 0) {
                        header("Location: ../FragebogenNeu.php?error=TitelBereitsVergeben");
                    exit();
                    }
                }


    //Insert SQL-Befehl Fragebogen
        $sql= "INSERT INTO frageboegen(titel, beschreibung, befrager) VALUES(?, ?, ?);";
        //prepared statement erstellen
        $stmt=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../dbInsertFragebogen.php?error=SQLBefehlFehler");
        }
        else{
           //Verknüpfung Parameter mit Placeholdern
           mysqli_stmt_bind_param($stmt, "sss", $titel, $beschreibung, $befrager);
           //Run Code in DB
           mysqli_stmt_execute($stmt);
        }
    }
}



//Weiterleitung auf Fragen-Seite
if (!$sql) {
    echo mysqli_error($sql);
}
else {
    header("Location: ../FragenseitenNeu.php?FragebogenSpeichern=erfolgreich");
}
