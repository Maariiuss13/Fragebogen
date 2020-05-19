<?php

include 'dbHandler.php';
session_start();


// Deklaration Variablen
$frage = $_POST["frage"];


//Vorgehen bei Button Weiter
if(isset($_POST["Bweiter"])){
    //Prüfen, ob Felder befüllt
    if(empty($frage) || empty($_SESSION["aktFB"])){
        header("Location: ../FragenseitenNeu.php?error=leerefelder");
        exit();
    }

    //Prüfen, ob Frage länger als 100 Char
    elseif(strlen($frage)>100){
        header("Location: ../FragenseitenNeu.php?error=FrageZuLang");
        exit();
    }

    else{
        //Prüfung doppelter Titel
        $sqlFrage="SELECT fragenr,titel FROM fragen WHERE fragenr=? AND titel=?;";
        // Initialisieren mit der richtigen Verbindung
        $stmt = mysqli_stmt_init($conn);
        // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
        if (!mysqli_stmt_prepare($stmt, $sqlFrage)) {
            // Wenn ja, dann SQL-Fehler
            header("Location: ../FragenseitenNeu.php?error=sqlerror");
            exit();
        } 
        else {
            // Benutzereingaben Frage
            mysqli_stmt_bind_param($stmt, "ss", $frage, $_SESSION["aktFB"]);
            // Ausführen der Anweisung in der Datenbank
            mysqli_stmt_execute($stmt);
            // Nimmt das Ergebnis aus der Datenbank und speichert es in der Variablen $stmt
            mysqli_stmt_store_result($stmt);
            // Prüft die Anzahl der Ergebnisse der Variable $stmt
            $resultCheck = mysqli_stmt_num_rows($stmt);
            // Wenn größer 0 -> Titel schon vergeben
            if ($resultCheck > 0) {
                header("Location: ../FragebogenNeu.php?error=FrageBereitsVergeben");
            exit();
                }
            }


        //Insert SQL-Befehl Fragebogen
        $sql= "INSERT INTO fragen(fragenr, titel, fragestellung) VALUES(?, ?, ?);";
        //prepared statement erstellen
        $stmt=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../FragebogenNeu.php?error=SQLBefehlFehler");
        }
        else{
            //Verknüpfung Parameter mit Placeholdern
            mysqli_stmt_bind_param($stmt, "sss", $_SESSION["aktSeite"], $_SESSION["aktFB"], $frage);
            //Run Code in DB
            mysqli_stmt_execute($stmt);
        }
    }        
    
    //Hochzählen aktSeite
    $_SESSION["aktSeite"]++;
    //Weiterleitung auf neue Fragenseite
    header("Location: ../FragenseitenNeu.php?Next");
}



//Vorgehen bei Button Abschluss 
if(isset($_POST["Babschluss"])){
    //Prüfen, ob Felder befüllt
    if(empty($frage) || empty($_SESSION["aktFB"])){
        header("Location: ../FragenseitenNeu.php?error=leerefelder");
        exit();
    }

    //Prüfen, ob Frage länger als 100 Char
    elseif(strlen($frage)>100){
        header("Location: ../FragenseitenNeu.php?error=FrageZuLang");
        exit();
    }

    else{
        //Prüfung doppelter Titel
        $sqlFrage="SELECT fragenr,titel FROM fragen WHERE fragenr=? AND titel=?;";
        // Initialisieren mit der richtigen Verbindung
        $stmt = mysqli_stmt_init($conn);
        // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
        if (!mysqli_stmt_prepare($stmt, $sqlFrage)) {
            // Wenn ja, dann SQL-Fehler
            header("Location: ../FragenseitenNeu.php?error=sqlerror");
            exit();
        } 
        else {
            // Benutzereingaben Frage
            mysqli_stmt_bind_param($stmt, "ss", $frage, $_SESSION["aktFB"]);
            // Ausführen der Anweisung in der Datenbank
            mysqli_stmt_execute($stmt);
            // Nimmt das Ergebnis aus der Datenbank und speichert es in der Variablen $stmt
            mysqli_stmt_store_result($stmt);
            // Prüft die Anzahl der Ergebnisse der Variable $stmt
            $resultCheck = mysqli_stmt_num_rows($stmt);
            // Wenn größer 0 -> Titel schon vergeben
            if ($resultCheck > 0) {
                header("Location: ../FragebogenNeu.php?error=FrageBereitsVergeben");
            exit();
                }
            }


        //Insert SQL-Befehl Fragebogen
        $sql= "INSERT INTO fragen(fragenr, titel, fragestellung) VALUES(?, ?, ?);";
        //prepared statement erstellen
        $stmt=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../FragebogenNeu.php?error=SQLBefehlFehler");
        }
        else{
            //Verknüpfung Parameter mit Placeholdern
            mysqli_stmt_bind_param($stmt, "sss", $_SESSION["aktSeite"], $_SESSION["aktFB"], $frage);
            //Run Code in DB
            mysqli_stmt_execute($stmt);
        }
    }        
    
    //aktSeite wieder auf 1 setzen
    $_SESSION["aktSeite"]=1;
    //Weiterleitung auf neue Fragenseite
    header("Location: ../Befrager.php?ErfassungAbgeschlossen");
}
