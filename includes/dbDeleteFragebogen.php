<?php
include 'dbHandler.php';
session_start();


// Deklaration Variablen
$titel = $_POST["titelFragebogen"];
$befrager = $_SESSION["session_bname"];


if(isset($_POST["FragebogenLöschen"])){
    //Prüfen, ob Feld befüllt 
    if(empty($titel)){
        header("Location: ../FragebogenNeu.php?error=leerefelder");
        exit();
    }
    else{
        //Delete Fragebogen
        $sql= "DELETE FROM frageboegen fb, fragen f WHERE fb.titel = f.titel AND fb.titel = '$titel';";
        //DELETE fragen, frageboegen from frageboegen inner join fragen on fragen.titel=frageboegen.Titel WHERE frageboegen.titel='AB'; -> Fehlermeldung!!!!!!
        mysqli_query($conn, $sql);
    }
}


//Weiterleitung auf Befrager-Seite
if (!$sql) {
    echo mysqli_error($sql);
}
else {
    header("Location: ../Befrager.php?FragebogenLöschen=erfolgreich");
}
