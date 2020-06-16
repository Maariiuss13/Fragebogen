<!-- Autor: Dajana Thoebes, Lukas Ströbele (Cross-Site-Scripting) -->
<?php
include 'dbHandler.php';
include 'functions.php';
session_start();

// Deklaration Variablen
$bewertung = htmlspecialchars(stripslashes(trim($_POST["bewertung"])));
$mnr = $_SESSION["session_mnr"];
$frageNr = $_SESSION["aktSeite"];
$titelFB = $_SESSION["titelFB"];

//Vorgehen bei Button Weiter oder Abschluss
if ((isset($_POST["Bweiter"])) || (isset($_POST["Babschluss"]))) {
    //Prüfen, ob Felder befüllt
    if (empty($bewertung)) {
        header("Location: ../Fragenseiten2.php?error=leerefelder");
        exit();
    }

    //Update Bewertungswert Frage
    $sql = "INSERT INTO beantwortenf(mnr, fragenr, titel, bewertungswert) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE bewertungswert = ?;";
    updateinsertBewertung($conn, $sql, $mnr, $frageNr, $titelFB, $bewertung);
}

//Vorgehen bei Button Weiter
if (isset($_POST["Bweiter"])) {
    //Hochzählen aktSeite
    $_SESSION["aktSeite"]++;
    //Weiterleitung auf neue Fragenseite
    header("Location: ../Fragenseiten2.php?Next");
}

//Vorgehen bei Button Abschluss 
if (isset($_POST["Babschluss"])) {
    //Status Fragebbogen auf Status F - fertig setzen
    $titelFB = $_SESSION["titelFB"];
    $mnr = $_SESSION['session_mnr'];
    $neuerStatus = 'F';
    $sqlSt = "UPDATE bearbeitenfb SET Status=? WHERE Titel=? AND MNR=?";
    statusFertig($conn, $sqlSt, $neuerStatus, $titelFB, $mnr);

    //aktSeite wieder auf 1 setzen
    $_SESSION["aktSeite"] = 1;
    //Weiterleitung auf Abschlusseite
    header("Location: ../AbschlussseiteFragebogen.php?ErfassungAbgeschlossen");
    $_SESSION["Babschluss"] = htmlspecialchars(stripslashes(trim($_POST["Babschluss"])));
}

// Verbindung beenden
mysqli_close($conn);
