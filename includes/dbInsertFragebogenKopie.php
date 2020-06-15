<!-- Autor: Dajena Thoebes -->
<?php
include 'dbHandler.php';
include 'functions.php';
session_start();


// Deklaration Variablen
$titelAlt = htmlspecialchars(stripslashes(trim($_POST["fbTitelAlt"])));
$titelNeu = htmlspecialchars(stripslashes(trim($_POST["fbTitelNeu"])));
$befrager = $_SESSION["session_bname"];

//Deklaration Session-Variablen für Fragenseiten
$_SESSION["alterFB"] = htmlspecialchars(stripslashes(trim($_POST["fbTitelAlt"])));
$_SESSION["KopieFB"] = htmlspecialchars(stripslashes(trim($_POST["fbTitelNeu"])));


//Beschreibung kopieren
$sqlBeschr = "SELECT * FROM frageboegen WHERE Titel='$titelAlt';";
//Senden Befehl an DB und Ausführen
$beschrErg = mysqli_query($conn, $sqlBeschr);
//Zuweisung Ergebnis einer Variable
$beschrRow = mysqli_fetch_assoc($beschrErg);


//neuen Fragebogen speichern
if (isset($_POST["speichernFragebogenKopie"])) {
    //Prüfen, ob Felder befüllt 
    if (empty($titelNeu)) {
        header("Location: ../FragebogenKopieren.php?error=leerefelder");
        exit();
    }
    //Prüfen, ob Titel neu und alt gleich
    elseif ($titelAlt == $titelNeu) {
        header("Location: ../FragebogenKopieren.php?error=TitelGleich");
        exit();
    }
    //Prüfen, ob Titel länger als 10 Char
    elseif (strlen($titelNeu) > 10) {
        header("Location: ../FragebogenKopieren.php?error=TitelZuLang");
        exit();
    } else {
        //Prüfung doppelter Titel
        $sqlTitel = "SELECT titel FROM frageboegen WHERE titel=?;";

        //Funktion zum Prüfen, ob Titel bereits in DB vorhanden
        $sqlerror = "Location: ../FragebogenKopieren.php?error=sqlerror";
        $error = "Location: ../FragebogenKopieren.php?error=TitelBereitsVorhanden";
        checkTitelDB($conn, $sqlTitel, $titelNeu, $sqlerror, $error);

        //Insert SQL-Befehl Fragebogen

        $sql = "INSERT INTO frageboegen(titel, beschreibung, befrager) VALUES(?, ?, ?);";
        $beschreibung = $beschrRow['Beschreibung'];
        $sqlerror = "Location: ../FragebogenKopieren.php?error=SQLBefehlFehlerFB";
        insertFragebogen($conn, $sql, $titelNeu, $beschreibung, $befrager, $sqlerror);
        //TODO
        //Fragen kopieren und neuem FB zuordnen
        $sqlInsFr = "INSERT INTO fragen(FrageNr, Titel, Fragestellung) SELECT FrageNr, '$titelNeu', Fragestellung FROM fragen WHERE Titel= '$titelAlt';";
        $erg = mysqli_query($conn, $sqlInsFr);
        if ($erg == false) {
            header("Location: ../FragebogenKopieren.php?error=SQLBefehlFehlerFragen");
            exit();
        }
    }
}

//Weiterleitung auf Fragen-Seite
header("Location: ../FragenKopieBearbeiten.php?FragebogenKopieren=erfolgreich");

