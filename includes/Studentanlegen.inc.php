<?php
// Prüfen, ob der Befrager auf den Button klickt
if (isset($_POST['studentanlegen'])) {

    // Datenbankverbindung ausführen
    require 'dbHandler.php';

    // Informationsabruf, wenn sich der Benutzer angemeldet hat
    $MNR = $_POST['mnr'];
    $Kurskuerzel = $_POST['kurs'];

    //Fehlerbehandlungen

    // Prüfung, ob etwas in die Felder eingetragen wurde
    if (empty($MNR) || empty($Kurskuerzel)) {
        // Anzeige eines Fehlercodes in der URL
        header("Location: ../Kurs.php?error=leerefelder");
        // Stoppt die Ausführung des Skripts
        exit();
    } else {
        // Prüfung, ob Daten in der Tabelle enthalten sind
        $sql = "SELECT * FROM studenten WHERE MNR='$MNR' OR Kurs='$Kurskuerzel'";
        // Initialisieren mit der richtigen Verbindung
        $statement = mysqli_stmt_init($conn);
        // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
        if (!mysqli_stmt_prepare($statement, $sql)) {
            // Wenn ja, dann SQL-Fehler
            header("Location: ../Kurs.php?error=sqlerror");
            exit();
        } else {
            // Benutzereingaben beim Anmeldeversuch
            mysqli_stmt_bind_param($statement, "ss", $MNR, $Kurskuerzel);
            // Ausführen der Anweisung in der Datenbank
            mysqli_stmt_execute($statement);
            // Nimmt das Ergebnis aus der Datenbank und speichert es in der Variablen $statement
            mysqli_stmt_store_result($statement);
            // Alle Informationen, die durch die SELECT-Anweisung erhalten wurden,
            // werden in der Variable $result gespeichert
            $resultCheck = mysqli_stmt_num_rows($statement);
            // Wenn größer 0 -> Matrikelnummer schon vergeben
            if ($resultCheck > 0) {
                header("Location: ../Kurs.php?error=matrikelnummerbereitsvergeben");
                exit();
            } else {
                // Eingegebene Daten in Datenbank einfügen
                $sql = "INSERT INTO studenten (MNR, Kurs) VALUES (?, ?)";
                // Initialisieren mit der richtigen Verbindung
                $statement = mysqli_stmt_init($conn);
                // Prüfung auf Übereinstimmung
                if (!mysqli_stmt_prepare($statement, $sql)) {
                    // Wenn nicht, Fehlermeldung
                    header("Location: ../Kurs.php?error=sqlerror");
                    exit();
                } else {
                    // Benutzereingaben beim Anmeldeversuch
                    mysqli_stmt_bind_param($statement, "ss", $MNR, $Kurskuerzel);
                    // Ausführen der Anweisung in der Datenbank
                    mysqli_stmt_execute($statement);
                    header("Location: ../Kurs.php?studentanlegen=erfolgreich");
                    exit();
                }
            }
        }
    }
    // closing of the statements
    mysqli_stmt_close($statement);
    // Beendet die Verbindung
    mysqli_close($conn);
}
