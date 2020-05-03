<?php
include 'dbHandler.php';
session_start();


// Deklaration Variablen
$titelAlt = $_POST["fbTitelAlt"];
$titelNeu = $_POST["fbTitelNeu"];
$befrager = $_SESSION["session_bname"];

//Beschreibung kopieren
$sqlBeschr= "SELECT beschreibung FROM frageboegen WHERE Titel='$titelAlt';";
$beschreibung= mysqli_query($conn, $sqlBeschr);


if(isset($_POST["speichernFragebogenKopie"])){
    //Prüfen, ob Felder befüllt 
    if(empty($titelNeu)){
        header("Location: ../FragebogenKopieren.php?error=leerefelder");
        exit();
    }
    //Prüfen, ob Titel neu und alt gleich
    elseif($titelAlt==$titelNeu){
        header("Location: ../FragebogenKopieren.php?error=TitelGleich");
        exit();
    }
    //Prüfen, ob DS schon vorhanden ist, fehlt!!!!!!!!!!!!!!!
    else{
        //Insert Fragebogen --> Beschreibung Fehler!!!!!!!!!!!!!!
        $sql= "INSERT INTO frageboegen(titel, beschreibung, befrager) VALUES('$titelNeu', '', '$befrager');";
        mysqli_query($conn, $sql);
    }
     
}

//Weiterleitung auf Fragen-Seite
if (!$sql) {
    echo mysqli_error();
}
else {
    header("Location: ../Fragenseiten.php?FragebogenSpeichern=erfolgreich");
}