<?php
include 'dbHandler.php';
include 'functions.php';
session_start();

// Deklaration Variablen
$kommentar = htmlspecialchars(stripslashes(trim($_POST["kommentar"])));

if(isset($_POST["kommentarSpeichern"])){
    //Prüfen, ob Felder befüllt
    if(empty($kommentar)){
        header("Location: ../AbschlussseiteFragebogen.php?error=leerefelder");
        exit();
    }

    //Insert SQL-Befehl Fragebogen
    $sql= "UPDATE bearbeitenFB SET Kommentar=? WHERE Titel=? AND MNR=?;";
    //prepared statement erstellen
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../AbschlussseiteFragebogen.php?error=SQLBefehlFehler");
        exit();
    }
    else{
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "sss", $kommentar, $_SESSION["titelFB"], $_SESSION["session_mnr"]);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }
    
    header("Location: ../Studenten.php?KommentarGespeichert");
}


