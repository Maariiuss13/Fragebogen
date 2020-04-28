<?php
// Prüfen, ob der Befrager auf den Button klickt
if (isset($_POST['befragerregistrierung'])) {

    // Datenbankverbindung ausführen
    require 'dbHandler.php';

    // Informationsabruf, wenn sich der Benutzer angemeldet hat
    $befragername = $_POST['befragername'];
    $passwort = $_POST['passwort'];
    $passwortWiederholen = $_POST['passwortWiederholen'];

    //Fehlerbehandlungen

    // Prüfung, ob etwas in die Felder eingetragen wurde
    if (empty($befragername) || empty($passwort) || empty($passwortWiederholen)) {
        // Anzeige eines Fehlercodes in der URL
        header("Location: ../Befragerregistrierung.php?error=leerefelder");
        // Stoppt die Ausführung
        exit();
      // Pattern des Befragernamens
    } else if (!preg_match("/^[a-zA-Z0-9ßäöüÄÖÜ]*$/", $befragername)) {
        header("Location: ../Befragerregistrierung.php?error=ungültigerbefragername");
        exit();
      // Fehlerbehandlung bei Ungleichheit des Passwörter  
    } else if ($passwort !== $passwortWiederholen) {
        header("Location: ../Befragerregistrierung.php?error=überprüfepasswörter&befragername=" . $befragername);
        exit();
    } else {
        // Prüfung, ob Daten in der Tabelle enthalten sind
        $sql = "SELECT BName FROM befrager WHERE BName=?";
        // Initialisieren mit der richtigen Verbindung
        $statement = mysqli_stmt_init($conn);
        // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
        if (!mysqli_stmt_prepare($statement, $sql)) {
            // Wenn ja, dann SQL-Fehler
            header("Location: ../Befragerregistrierung.php?error=sqlerror");
            exit();
        } else {
            // Benutzereingaben beim Anmeldeversuch
            mysqli_stmt_bind_param($statement, "s", $befragername);
            // Ausführen der Anweisung in der Datenbank
            mysqli_stmt_execute($statement);
            // Nimmt das Ergebnis aus der Datenbank und speichert es in der Variablen $statement
            mysqli_stmt_store_result($statement);
            // Prüft die Anzahl der Ergebnisse der Variable $statement
            $resultCheck = mysqli_stmt_num_rows($statement);
            // Wenn größer 0 -> Befragername schon vergeben
            if ($resultCheck > 0) {
                header("Location: ../Befragerregistrierung.php?error=befragernamebereitsvergeben");
                exit();
            } else {
                // Eingegebene Daten in Datenbank einfügen
                $sql = "INSERT INTO befrager (BName, Passwort) VALUES (?, ?)";
                // Initialisieren mit der richtigen Verbindung
                $statement = mysqli_stmt_init($conn);
                // check, ob das sql statement do in fact worked together
                if (!mysqli_stmt_prepare($statement, $sql)) {
                    // Wenn nicht, Fehlermeldung
                    header("Location: ../Befragerregistrierung.php?error=sqlerror");
                    exit();
                } else {
                    //Hashing-Operation am Passwort
                    $hashedPasswort = password_hash($passwort, PASSWORD_DEFAULT);
                    // Benutzereingaben beim Anmeldeversuch
                    mysqli_stmt_bind_param($statement, "ss", $befragername, $hashedPasswort);
                    // Ausführen der Anweisung in der Datenbank
                    mysqli_stmt_execute($statement);
                    header("Location: ../Befrageranmeldung.php?anmeldung=erfolgreich");
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