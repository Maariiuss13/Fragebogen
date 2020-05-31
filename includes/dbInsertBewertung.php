<?php
include 'dbHandler.php';
session_start();

// Deklaration Variablen
$bewertung = $_POST["bewertung"];

//Vorgehen bei Button Weiter
if(isset($_POST["Bweiter"])){
    //Prüfen, ob Felder befüllt
    if(empty($bewertung)){
        header("Location: ../Fragenseiten.php?error=leerefelder");
        exit();
    }

    //Insert SQL-Befehl Fragebogen
    $sql= "INSERT INTO beantwortenF(MNR, FrageNr, titel, Bewertungswert) VALUES(?, ?, ?, ?);";
    //prepared statement erstellen
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../Fragenseiten.php?error=SQLBefehlFehler");
        exit();
    }
    else{
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "ssss", $_SESSION['session_mnr'], $_SESSION["aktSeite"], $_SESSION["titelFB"], $bewertung);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }

    //Hochzählen aktSeite
    $_SESSION["aktSeite"]++;
    //Weiterleitung auf neue Fragenseite
    header("Location: ../Fragenseiten.php?Next");
}

//Vorgehen bei Button Abschluss 
if(isset($_POST["Babschluss"])){
    //Prüfen, ob Felder befüllt
    if(empty($bewertung)){
        header("Location: ../Fragenseiten.php?error=leerefelder");
        exit();
    }

    //Insert SQL-Befehl Fragebogen
    $sql= "INSERT INTO beantwortenF(MNR, FrageNr, titel, Bewertungswert) VALUES(?, ?, ?, ?);";
    //prepared statement erstellen
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../Fragenseiten.php?error=SQLBefehlFehler");
    }
    else{
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "ssss", $_SESSION['session_mnr'], $_SESSION["aktSeite"], $_SESSION["titelFB"], $bewertung);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }

    //aktSeite wieder auf 1 setzen
    $_SESSION["aktSeite"]=1;
    //Weiterleitung auf neue Fragenseite
    header("Location: ../AbschlussseiteFragebogen.php?ErfassungAbgeschlossen");
}


//Vorgehen bei Button Zurück
if(isset($_POST["Bzurück"])){
    //Runterzählen aktSeite
    $_SESSION["aktSeite"]--;
    //Weiterleitung auf neue Fragenseite
    header("Location: ../Fragenseiten.php?Back");
}

