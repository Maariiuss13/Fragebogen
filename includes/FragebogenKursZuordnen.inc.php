<!-- Autor: Lukas Ströbele -->
<?php
include 'functions.php';
include 'dbHandler.php';

// Kurs Fragebogen zuordnen
if (isset($_POST['fragebogenzuordnen'])) {

    // Deklaration Variablen
    $Kuerzel = htmlspecialchars(stripslashes(trim($_POST['kurskuerzel'])));
    $Titel = htmlspecialchars(stripslashes(trim($_POST['fragebogentitel'])));

    // Template für prepared statement (Prüfung doppelter Titel)
    $sql = "SELECT * FROM freischaltenfb WHERE Titel=?";
    // prepared statement generieren
    $statement = mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($statement, $sql)) {
        // SQL-Error
        header("Location: ../KursFragebogenZuordnen.php?error=sqlerror");
        exit();
    } else {
        // Insert SQL-Befehl freischaltenfb
        $sql = "INSERT INTO freischaltenfb (Titel, Kurs) VALUES ('$Titel', '$Kuerzel')";
        // Funktion zum Einfügen der Daten in die Datenbank - Zuordnung Fragebogen zu Kurs
        insertZuordnung($conn, $sql, $Kuerzel, $Titel);
    }
    // Statements schließen
    mysqli_stmt_close($statement);
    // Verbindung beenden
    mysqli_close($conn);
}
