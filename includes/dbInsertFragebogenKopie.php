<?php
include 'dbHandler.php';
session_start();


// Deklaration Variablen
$titelAlt = $_POST["fbTitelAlt"];
$titelNeu = $_POST["fbTitelNeu"];
$befrager = $_SESSION["session_bname"];

//Beschreibung kopieren
$sqlBeschr= "SELECT beschreibung FROM frageboegen WHERE Titel='$titelAlt';";
//$beschreibung= mysqli_query($conn, $sqlBeschr);
$beschreibung= "BeschreibungTest";

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
    //Prüfen, ob Titel länger als 10 Char
    elseif(strlen($titel)>10){
        header("Location: ../FragebogenNeu.php?error=TitelZuLang");
        exit();
    }
    //Prüfen, ob DS schon vorhanden ist, fehlt!!!!!!!!!!!!!!!
    else{
        //Insert SQL-Befehl Fragebogen --> Beschreibung Fehler!!!!!!!!!!!!!!
        $sql= "INSERT INTO frageboegen(titel, beschreibung, befrager) VALUES(?, ?, ?);";
        //prepared statement erstellen
        $stmt=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../dbInsertFragebogen.php?error=SQLBefehlFehler");
        }
        else{
           //Verknüpfung Parameter mit Placeholdern
           mysqli_stmt_bind_param($stmt, "sss", $titelNeu, $beschreibung, $befrager);
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