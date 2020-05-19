<?php
include 'dbHandler.php';
session_start();


// Deklaration Variablen
$titel = $_POST["titelFragebogen"];
$befrager = $_SESSION["session_bname"];


if(isset($_POST["FragebogenLöschen"])){
    //Prüfen, ob Feld befüllt 
    if(empty($titel)){
        header("Location: ../FragebogenLoeschen.php?error=leerefelder");
        exit();
    }
    else{
        //NOCH ALS PREPARED STATEMENT!!!!!!!
        //Delete Fragebogen
        $sql= "DELETE frageboegen, fragen
        FROM frageboegen
        LEFT JOIN fragen on fragen.Titel = frageboegen.Titel
        WHERE frageboegen.Titel='$titel' AND frageboegen.Titel NOT IN (SELECT bearbeitenfb.Titel from bearbeitenfb);";
        mysqli_query($conn, $sql);        
    }
}


//Weiterleitung auf Befrager-Seite
if (!$sql) {
    echo mysqli_error($sql);
}
else {
    header("Location: ../FragebogenLoeschen.php?FragebogenLöschen=erfolgreich");
}
