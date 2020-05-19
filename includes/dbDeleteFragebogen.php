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
        $result = mysqli_query($conn, $sql);
        //Speicherung Anzahl Zeilen
        $resultcheck = mysqli_affected_rows($result);
        //Wenn keine Zeile gelöscht, Ausgabe Fehlermeldung
        //Resultcheck funktioniert nicht - immernoch Rückführung auf Befragerseite, auch wenn FB nicht gelöscht!!!!!!!!!!!!!
        if($resultcheck = 0) {
            header("Location: ../FragebogenLoeschen.php?error=BereitsinBearbeitung");
            exit();
        }        
    }
}


//Weiterleitung auf Befrager-Seite
if (!$sql) {
    echo mysqli_error($sql);
}
else {
    header("Location: ../Befrager.php?FragebogenLöschen=erfolgreich");
}
