<?php
include 'functions.php';
?>

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
        // Stoppt die Ausführung des Skripts
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
        checkBefrager($conn, $sql, $befragername);
            // Wenn größer 0 -> Befragername schon vergeben
            if ($resultCheck > 0) {
                header("Location: ../Befragerregistrierung.php?error=befragernamebereitsvergeben");
                exit();
            } else {
                // Eingegebene Daten in Datenbank einfügen
                $sql = "INSERT INTO befrager (BName, Passwort) VALUES (?, ?)";
                insertBefrager($conn, $sql, $passwort, $befragername);
            }
        }
    // closing of the statements
    mysqli_stmt_close($statement);
    // Beendet die Verbindung
    mysqli_close($conn);
} 
