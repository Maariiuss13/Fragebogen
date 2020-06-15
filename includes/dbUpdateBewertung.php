<!-- Autor: Dajena Thoebes, Lukas Ströbele (Cross-Site-Scripting) -->
<?php
include 'dbHandler.php';
include 'functions.php';
session_start();

// Deklaration Variablen
$bewertung = htmlspecialchars(stripslashes(trim($_POST["bewertung"])));

//Vorgehen bei Button Weiter
if(isset($_POST["Bweiter"])){
    //Prüfen, ob Felder befüllt
    if(empty($bewertung)){
        header("Location: ../Fragenseiten2.php?error=leerefelder");
        exit();
    }

    //Update Bewertungswert Frage
    $sql= "INSERT INTO beantwortenf(mnr, fragenr, titel, bewertungswert) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE bewertungswert = ?;";
    //prepared statement erstellen
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../Fragenseiten2.php?error=SQLBefehlFehler");
        exit();
    }
    else{
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "sssss", $_SESSION["session_mnr"], $_SESSION["aktSeite"], $_SESSION["titelFB"], $bewertung, $bewertung);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }

    //Hochzählen aktSeite
    $_SESSION["aktSeite"]++;
    //Weiterleitung auf neue Fragenseite
    header("Location: ../Fragenseiten2.php?Next");
}

//Vorgehen bei Button Abschluss 
if(isset($_POST["Babschluss"])){
    //Prüfen, ob Felder befüllt
    if(empty($bewertung)){
        header("Location: ../Fragenseiten2.php?error=leerefelder");
        exit();
    }

    //Update Bewertungswert Frage
    $sql= "INSERT INTO beantwortenf(mnr, fragenr, titel, bewertungswert) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE bewertungswert = ?;";
    //prepared statement erstellen
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../Fragenseiten2.php?error=SQLBefehlFehler");
    }
    else{
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "sssss", $_SESSION["session_mnr"], $_SESSION["aktSeite"], $_SESSION["titelFB"], $bewertung, $bewertung);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }

    //Status Fragebbogen auf Status F - fertig setzen
    $titelFB=$_SESSION["titelFB"];
    $mnr = $_SESSION['session_mnr'];
    $neuerStatus='F';
    $sqlSt="UPDATE bearbeitenfb SET Status=? WHERE Titel=? AND MNR=?";
    statusFertig($conn, $sqlSt, $neuerStatus, $titelFB, $mnr);

    //aktSeite wieder auf 1 setzen
    $_SESSION["aktSeite"]=1;
    //Weiterleitung auf Abschlusseite
    header("Location: ../AbschlussseiteFragebogen.php?ErfassungAbgeschlossen");
    $_SESSION["Babschluss"] = htmlspecialchars(stripslashes(trim($_POST["Babschluss"])));
}

