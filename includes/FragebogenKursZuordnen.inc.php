<?php
// Prüfen, ob der Befrager auf den Button klickt
if (isset($_POST['fragebogenzuordnen'])) {

    // Datenbankverbindung ausführen
    require 'dbHandler.php';

    // Informationsabruf, wenn sich der Benutzer angemeldet hat
    $Kuerzel = $_POST['kurskuerzel'];
    $Titel = $_POST['fragebogentitel'];

    //Fehlerbehandlungen

    // Prüfung, ob Daten in der Tabelle enthalten sind
    $sql = "SELECT * FROM freischaltenfb WHERE Titel='$Titel'";
    // Initialisieren mit der richtigen Verbindung
    $statement = mysqli_stmt_init($conn);
    // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
    if (!mysqli_stmt_prepare($statement, $sql)) {
        // Wenn ja, dann SQL-Fehler
        header("Location: ../KursFragebogenZuordnen.php?error=sqlerror");
        exit();
    } else {
        // Eingegebene Daten in Datenbank einfügen
        $sql = "INSERT INTO freischaltenfb (Titel, Kurs) VALUES ('$Titel', '$Kuerzel')";
        // Initialisieren mit der richtigen Verbindung
        $statement = mysqli_stmt_init($conn);
        // Prüfung auf Übereinstimmung
        if (!mysqli_stmt_prepare($statement, $sql)) {
            // Wenn nicht, Fehlermeldung
            header("Location: ../KursFragebogenZuordnen.php?error=sqlerror");
            exit();
        } else {
            // Benutzereingaben beim Anmeldeversuch
            mysqli_stmt_bind_param($statement, "ss", $Kuerzel, $Titel);
            // Ausführen der Anweisung in der Datenbank
            mysqli_stmt_execute($statement);
            header("Location: ../KursFragebogenZuordnen.php?fragebogenzuordnen=erfolgreich");
            exit();
        }
    }
}
// closing of the statements
mysqli_stmt_close($statement);
// Beendet die Verbindung
mysqli_close($conn);
