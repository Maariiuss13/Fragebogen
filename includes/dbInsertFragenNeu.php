<?php
include 'dbHandler.php';
session_start();

// Deklaration Variablen
$bewertung = $_POST["bewertung"];

//Vorgehen bei Button Weiter
if(isset($_POST["Bweiter"])){
    //Prüfen, ob Felder befüllt
    if(empty($bewertung) || empty($_SESSION["aktFB"])){
        header("Location: ../Fragenseiten.php?error=leerefelder");
        exit();
    }

    //Hochzählen aktSeite
    $_SESSION["aktSeite"]++;
    //Weiterleitung auf neue Fragenseite
    header("Location: ../Fragenseiten.php?Next");
}

//Vorgehen bei Button Abschluss 
if(isset($_POST["Babschluss"])){
    //Prüfen, ob Felder befüllt
    if(empty($frage) || empty($_SESSION["aktFB"])){
        header("Location: ../Fragenseiten.php?error=leerefelder");
        exit();
    }

    //aktSeite wieder auf 1 setzen
    $_SESSION["aktSeite"]=1;
    //Weiterleitung auf neue Fragenseite
    header("Location: ../Befrager.php?ErfassungAbgeschlossen");
}