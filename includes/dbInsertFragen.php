<!-- Autor: Dajena Thoebes, Lukas Ströbele (Cross-Site-Scripting) -->
<?php

include 'dbHandler.php';
include 'functions.php';
session_start();


// Deklaration Variablen
$frage = htmlspecialchars(stripslashes(trim($_POST["frage"])));


//Vorgehen bei Button Weiter oder Abschluss
if((isset($_POST["Bweiter"])) || (isset($_POST["Babschluss"]))){
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
        //Prüfung doppelte Frage (PS FragenNr + Titel)
        $sqlFrage="SELECT fragenr,titel FROM fragen WHERE fragenr=? AND titel=?;";
        $sqlerror= "Location: ../FragenseitenNeu.php?error=sqlerror";
        $error= "Location: ../FragebogenNeu.php?error=FrageBereitsVorhanden";
        checkFrage($conn, $sqlFrage, $frage, $sqlerror, $error);


        //Insert SQL-Befehl Fragebogen
        $sql= "INSERT INTO fragen(fragenr, titel, fragestellung) VALUES(?, ?, ?);";
        $sqlerror="Location: ../FragenseitenNeu.php?error=SQLBefehlFehlerFB";
        $aktSeite=$_SESSION["aktSeite"]; 
        $titelFb=$_SESSION["aktFB"];
        insertFrage($conn, $sql, $aktSeite, $titelFb, $frage, $sqlerror);
    }
}        

//Vorgehen bei Button Weiter
if(isset($_POST["Bweiter"])){
    //Hochzählen aktSeite
    $_SESSION["aktSeite"]++;
    //Weiterleitung auf neue Fragenseite
    header("Location: ../FragenseitenNeu.php?Next");
}


//Vorgehen bei Button Abschluss 
if(isset($_POST["Babschluss"])){
    //aktSeite wieder auf 1 setzen
    $_SESSION["aktSeite"]=1;
    //Weiterleitung auf neue Fragenseite
    header("Location: ../Befrager.php?ErfassungAbgeschlossen");
}
