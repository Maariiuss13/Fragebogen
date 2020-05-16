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
    //Prüfen, ob DS schon vorhanden ist, fehlt!!!!!!!!!!!!!!!
    //Prüfen, ob DS zu Befrager gehört, fehlt!!!!!!!!!!!!
    else{
        //Delete Fragebogen
        $sql= "DELETE FROM frageboegen WHERE titel = '$titel';";
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
