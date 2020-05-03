<?php
include 'dbHandler.php';
session_start();


// Deklaration Variablen
$titel = $_POST["titelFragebogen"];
$beschreibung = $_POST["beschreibungFB"];
$befrager = $_SESSION["session_bname"];



if(isset($_POST["speichernFragebogen"])){
    //Prüfen, ob Felder befüllt 
    if(empty($titel) || empty($beschreibung)){
        header("Location: ../FragebogenNeu.php?error=leerefelder");
        exit();
    }
    //Prüfen, ob AnzahlFragen > 0
    elseif(($_POST["anzahlFragen"]<=0)){
        header("Location: ../FragebogenNeu.php?error=AnzahlFragenKleinerGleichNull");
        exit();
    }
    //Prüfen, ob DS schon vorhanden ist, fehlt!!!!!!!!!!!!!!!
    else{
        //Insert Fragebogen
        $sql= "INSERT INTO frageboegen(titel, beschreibung, befrager) VALUES('$titel', '$beschreibung', '$befrager');";
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
