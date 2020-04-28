<?php
// Prüfen, ob der Befrager auf den Button klickt
if (isset($_POST['befrageranmeldung'])) {

    // Datenbankverbindung ausführen
    require 'dbHandler.php';

    // Informationsabruf, wenn sich der Benutzer angemeldet hat
    $BName = $_POST['befragername'];
    $Passwort = $_POST['passwort'];

    //Fehlerbehandlungen

    // Prüfung, ob etwas in die Felder eingetragen wurde
    if (empty($BName) || empty($Passwort)) {
        // Anzeige eines Fehlercodes in der URL
        header("Location: ../Befrageranmeldung.php?error=leerefelder");
        // Stoppt die Ausführung
        exit();
    } else {
        // Prüfung, ob Daten in der Tabelle enthalten sind
        $sql = "SELECT * FROM befrager WHERE BName='$BName'";
        // Initialisieren mit der richtigen Verbindung
        $statement = mysqli_stmt_init($conn);
        // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
        if (!mysqli_stmt_prepare($statement, $sql)) {
            // Wenn ja, dann SQL-Fehler
            header("Location: ../Befrageranmeldung.php?error=sqlerror");
            exit();
        } else {
            // Benutzereingaben beim Anmeldeversuch
            mysqli_stmt_bind_param($statement, "ss", $BName, $BName);
            // Ausführen der Anweisung in der Datenbank
            mysqli_stmt_execute($statement);
            // Alle Informationen, die durch die SELECT-Anweisung erhalten wurden,
            // werden in der Variable $result gespeichert
            $result = mysqli_stmt_get_result($statement);
            // Prüfung, ob $result leer ist oder ein Ergebnis liefert
            if ($row = mysqli_fetch_assoc($result)) {
                // Prüft, ob das eingegebene Passwort mit dem aus der Datenbank übereinstimmt
                $passwortCheck = password_verify($Passwort, $row['Passwort']);
                // Wenn nein, Fehlermeldung
                if ($passwortCheck == false) {
                    header("Location: ../Befrageranmeldung.php?error=falscherbefragernameoderpasswort");
                    exit();
                    // Wenn ja, Session wird gestartet und Weiterleitung auf die Befragerseite
                } else if ($passwortCheck == true) {
                    session_start();
                    $_SESSION['session_bname'] = $row['BName'];
                    header("Location: ../Befrager.php?anmeldung=erfolgreich");
                    exit();
                } else {
                    header("Location: ../Befrageranmeldung.php?error=keineübereinstimmung");
                    exit();
                }
            } else {
                // Kein Benutzer, der mit den eingegebenen Daten übereinstimmt in der Datenbank
                header("Location: ../Befrageranmeldung.php?error=keinbefrager");
                exit();
            }
        }
        // Close of the statements
        mysqli_stmt_close($statement);
        // Beendet die Verbindung
        mysqli_close($conn);
    }
}
