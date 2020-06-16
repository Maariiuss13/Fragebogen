<!-- Autor: Dajena Thoebes, Marius Müller, Lukas Ströbele (Cross-Site-Scripting) -->
<?php
include 'dbHandler.php';
include 'functions.php';
session_start();

// Deklaration Variablen
$bewertung = htmlspecialchars(stripslashes(trim($_POST["bewertung"])));

//Vorgehen bei Button Weiter oder Abschluss
if ((isset($_POST["Bweiter"])) || (isset($_POST["Babschluss"]))) {
    //Prüfen, ob Felder befüllt
    if (empty($bewertung)) {
        header("Location: ../Fragenseiten.php?error=leerefelder");
        exit();
    }

    //Insert SQL-Befehl Fragebogen
    $sql = "INSERT INTO beantwortenF(MNR, FrageNr, titel, Bewertungswert) VALUES(?, ?, ?, ?);";
    //prepared statement erstellen
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../Fragenseiten.php?error=SQLBefehlFehler");
        exit();
    } else {
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "ssss", $_SESSION['session_mnr'], $_SESSION["aktSeite"], $_SESSION["titelFB"], $bewertung);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }
}

//Vorgehen bei Button Weiter
if (isset($_POST["Babschluss"])) {
    //Hochzählen aktSeite
    $_SESSION["aktSeite"]++;
    //Weiterleitung auf neue Fragenseite
    header("Location: ../Fragenseiten.php?Next");
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
