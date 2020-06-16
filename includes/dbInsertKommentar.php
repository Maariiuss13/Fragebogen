<!-- Autoren: Dajana Thoebes, Marius Müller, Lukas Ströbele (Cross-Site-Scripting) -->
<?php
include 'dbHandler.php';
include 'functions.php';
session_start();

// Deklaration Variablen
$kommentar = htmlspecialchars(stripslashes(trim($_POST["kommentar"])));
$titelFB=$_SESSION["titelFB"];
$mnr=$_SESSION["session_mnr"];

if(isset($_POST["kommentarSpeichern"])){
    //Prüfen, ob Felder befüllt
    if(empty($kommentar)){
        header("Location: ../AbschlussseiteFragebogen.php?error=leerefelder");
        exit();
    }

    //Insert SQL-Befehl Fragebogen
    $sql= "UPDATE bearbeitenFB SET Kommentar=? WHERE Titel=? AND MNR=?;";
    insertKommentar($conn, $sql, $kommentar, $titelFB, $mnr);
    
    header("Location: ../Studenten.php?KommentarGespeichert");
}

// Verbindung beenden
mysqli_close($conn);


