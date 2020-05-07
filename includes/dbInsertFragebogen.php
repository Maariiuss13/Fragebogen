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
    //Prüfen, ob Titel länger als 10 Char
    elseif(strlen($titel)>10){
        header("Location: ../FragebogenNeu.php?error=TitelZuLang");
        exit();
    }
    //Prüfen, ob DS schon vorhanden ist, fehlt!!!!!!!!!!!!!!!
    
    else{
        //Insert SQL-Befehl Fragebogen
        $sql= "INSERT INTO frageboegen(titel, beschreibung, befrager) VALUES(?, ?, ?);";
        //prepared statement erstellen
        $stmt=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../dbInsertFragebogen.php?error=SQLBefehlFehler");
        }
        else{
           //Verknüpfung Parameter mit Placeholdern
           mysqli_stmt_bind_param($stmt, "sss", $titel, $beschreibung, $befrager);
           //Run Code in DB
           mysqli_stmt_execute($stmt);
        }
    }
}



//Weiterleitung auf Fragen-Seite
if (!$sql) {
    echo mysqli_error();
}
else {
    header("Location: ../Fragenseiten.php?FragebogenSpeichern=erfolgreich");
}
