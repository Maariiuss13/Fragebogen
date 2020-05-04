<?php
// Prüfen, ob der Befrager auf den Button klickt
if (isset($_POST['kursanlegen'])) {

    // Datenbankverbindung ausführen
    require 'dbHandler.php';

    // Informationsabruf, wenn sich der Benutzer angemeldet hat
    $Kurs = $_POST['kursname'];
    $Kuerzel = $_POST['kurskuerzel'];

     //Fehlerbehandlungen

    // Prüfung, ob etwas in die Felder eingetragen wurde
    if (empty($Kurs) || empty($Kuerzel)) {
        // Anzeige eines Fehlercodes in der URL
        header("Location: ../Kurs.php?error=leerefelder");
        // Stoppt die Ausführung des Skripts
        exit();
    } else {
        // Prüfung, ob Daten in der Tabelle enthalten sind
        $sql = "SELECT * FROM kurse WHERE Kuerzel='$Kuerzel'";
        // Initialisieren mit der richtigen Verbindung
        $statement = mysqli_stmt_init($conn);
        // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
        if (!mysqli_stmt_prepare($statement, $sql)) {
            // Wenn ja, dann SQL-Fehler
            header("Location: ../Kurs.php?error=sqlerror");
            exit();
        } else {
            // Benutzereingaben beim Anmeldeversuch
            mysqli_stmt_bind_param($statement, "ss", $Kuerzel, $Kurs);
            // Ausführen der Anweisung in der Datenbank
            mysqli_stmt_execute($statement);
            // Nimmt das Ergebnis aus der Datenbank und speichert es in der Variablen $statement
            mysqli_stmt_store_result($statement);
            // Alle Informationen, die durch die SELECT-Anweisung erhalten wurden,
            // werden in der Variable $result gespeichert
            $resultCheck = mysqli_stmt_num_rows($statement);
            // Wenn größer 0 -> Kursname schon vergeben
            if ($resultCheck > 0) {
                header("Location: ../Kurs.php?error=kursnamebereitsvergeben");
                exit();
            } else {
                // Eingegebene Daten in Datenbank einfügen
                $sql = "INSERT INTO kurse (Kuerzel, KName) VALUES (?, ?)";
                // Initialisieren mit der richtigen Verbindung
                $statement = mysqli_stmt_init($conn);
                // Prüfung auf Übereinstimmung
                if (!mysqli_stmt_prepare($statement, $sql)) {
                    // Wenn nicht, Fehlermeldung
                    header("Location: ../Kurs.php?error=sqlerror");
                    exit();
                } else {
                    // Benutzereingaben beim Anmeldeversuch
                    mysqli_stmt_bind_param($statement, "ss", $Kuerzel, $Kurs);
                    // Ausführen der Anweisung in der Datenbank
                    mysqli_stmt_execute($statement);
                    header("Location: ../Kurs.php?kursanlegen=erfolgreich");
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
