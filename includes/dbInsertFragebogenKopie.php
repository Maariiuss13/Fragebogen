<?php
include 'dbHandler.php';
include 'functions.php';
session_start();


// Deklaration Variablen
$titelAlt = $_POST["fbTitelAlt"];
$titelNeu = $_POST["fbTitelNeu"];
$befrager = $_SESSION["session_bname"];

//Deklaration Session-Variablen für Fragenseiten
$_SESSION["alterFB"] = $_POST["fbTitelAlt"];
$_SESSION["KopieFB"] = $_POST["fbTitelNeu"];


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
    } 
    else {
        //Prüfung doppelter Titel
        $sqlTitel = "SELECT titel FROM frageboegen WHERE titel=?;";
        //Funktion zum Prüfen, ob Titel bereits in DB vorhanden
        checkTitelDB($conn, $sqlTitel, $titel);
        // Initialisieren mit der richtigen Verbindung
        /*$stmt = mysqli_stmt_init($conn);
        // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
        if (!mysqli_stmt_prepare($stmt, $sqlTitel)) {
            // Wenn ja, dann SQL-Fehler
            header("Location: ../FragebogenKopieren.php?error=sqlerrordouble");
            exit();
        } 
        else {
            // Benutzereingaben Titel
            mysqli_stmt_bind_param($stmt, "s", $titelNeu);
            // Ausführen der Anweisung in der Datenbank
            mysqli_stmt_execute($stmt);
            // Nimmt das Ergebnis aus der Datenbank und speichert es in der Variablen $stmt
            mysqli_stmt_store_result($stmt);
            // Prüft die Anzahl der Ergebnisse der Variable $stmt
            $resultCheck = mysqli_stmt_num_rows($stmt);
            // Wenn größer 0 -> Titel schon vergeben
            if ($resultCheck > 0) {
                header("Location: ../FragebogenKopieren.php?error=TitelBereitsVergeben");
                exit();
            }
            
        }
        */
        //Insert SQL-Befehl Fragebogen
        $sql = "INSERT INTO frageboegen(titel, beschreibung, befrager) VALUES(?, ?, ?);";
        //prepared statement erstellen
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../FragebogenKopieren.php?error=SQLBefehlFehlerFB");
            exit();
        } else {
            //Verknüpfung Parameter mit Placeholdern
            mysqli_stmt_bind_param($stmt, "sss", $titelNeu, $beschrRow['Beschreibung'], $befrager);
            //Run Code in DB
            mysqli_stmt_execute($stmt);
            //mysqli_stmt_close($stmt);

            //Fragen kopieren und neuem FB zuordnen --> bei Fehler trotzdem FB in DB!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $sqlInsFr = "INSERT INTO fragen(FrageNr, Titel, Fragestellung) SELECT FrageNr, '$titelNeu', Fragestellung FROM fragen WHERE Titel= '$titelAlt';";
            $erg = mysqli_query($conn, $sqlInsFr);
            if ($erg == false) {
                header("Location: ../FragebogenKopieren.php?error=SQLBefehlFehlerFragen");
                exit();
            }
        }
    }
}




//Weiterleitung auf Fragen-Seite
if (!$sql) {
    echo mysqli_error($sql);
} else {
    header("Location: ../FragenKopieBearbeiten.php?FragebogenKopieren=erfolgreich");
}
