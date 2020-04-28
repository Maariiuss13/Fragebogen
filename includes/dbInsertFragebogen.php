<?php
include 'dbHandler.php';
session_start();


// Deklaration Variablen
$titel = $_POST["titelFragebogen"];
$beschreibung = $_POST["beschreibungFB"];
$befrager = $_SESSION["session_befrager"];



if(isset($_POST["speichernFragebogen"])){
    //Prüfen, ob Felder befüllt 
    if(empty($titel) || empty($beschreibung)){
        header("Location: ../FragebogenNeu.php?error=leerefelder");
    }
    //Prüfen, ob AnzahlFragen > 0
    elseif(($_POST["anzahlFragen"]<=0)){
        header("Location: ../FragebogenNeu.php?error=AnzahlFragenKleinerGleichNull");
    }
    //Prüfen, ob DS schon vorhandel fehlt noch
    else{
        //Insert Fragebogen
        //Session-Variable einsetzen???????????
        $sql= "INSERT INTO frageboegen(titel, beschreibung, befrager) VALUES('$titel', '$beschreibung', 'Dajena');";
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
