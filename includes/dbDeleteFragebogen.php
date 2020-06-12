<?php
include 'dbHandler.php';
include 'functions.php';
session_start();


// Deklaration Variablen
$titel = htmlspecialchars(stripslashes(trim($_POST["titelFragebogen"])));
$befrager = $_SESSION["session_bname"];


if(isset($_POST["FragebogenLöschen"])){
    //Prüfen, ob Feld befüllt 
    if(empty($titel)){
        header("Location: ../FragebogenLoeschen.php?error=leerefelder");
        exit();
    }
    else{
        //Delete Fragebogen
        $sql= "DELETE frageboegen, fragen
        FROM frageboegen
        LEFT JOIN fragen on fragen.Titel = frageboegen.Titel
        WHERE frageboegen.Titel= ? AND frageboegen.Titel NOT IN (SELECT bearbeitenfb.Titel from bearbeitenfb);";
        //Löschen des Fragebogens mit Fragen
        $sqlerror="Location: ../FragebogenLoeschen.php?error=SQLBefehlFehler";
        deleteFrageboegen($conn, $sql, $titel, $sqlerror);        
    }
}


//Weiterleitung auf Befrager-Seite
if (!$sql) {
    echo mysqli_error($sql);
}
else {
    header("Location: ../FragebogenLoeschen.php?FragebogenLöschen=erfolgreich");
}
