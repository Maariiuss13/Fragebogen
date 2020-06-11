<?php
include 'functions.php';
include 'dbHandler.php';
?>

<?php
// Neuen Befrager speichern
if (isset($_POST['befragerregistrierung'])) {

    // Deklaration Variablen
    $befragername = htmlspecialchars(stripslashes(trim($_POST['befragername'])));
    $passwort = htmlspecialchars(stripslashes(trim($_POST['passwort'])));
    $passwortWiederholen = htmlspecialchars(stripslashes(trim($_POST['passwortWiederholen'])));

    // Prüfung, ob Felder befüllt
    if (empty($befragername) || empty($passwort) || empty($passwortWiederholen)) {
        // Fehlercode in URL
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
        // Prüfung doppelter Befragernamen
        $sql = "SELECT BName FROM befrager WHERE BName=?";
        // Funktion zum Prüfen, ob Befragername bereits in DB vorhanden ist
        checkBefrager($conn, $sql, $befragername);
            // Wenn größer 0 -> Befragername schon vergeben
            if ($resultCheck > 0) {
                header("Location: ../Befragerregistrierung.php?error=befragernamebereitsvergeben");
                exit();
            } else {
                // Insert SQL-Befehl befrager
                $sql = "INSERT INTO befrager (BName, Passwort) VALUES (?, ?)";
                // Funktion zum Einfügen von Befragern in die Datenbank
                insertBefrager($conn, $sql, $passwort, $befragername);
            }
        }
    // Statements schließen
    mysqli_stmt_close($statement);
    // Verbindung beenden
    mysqli_close($conn);
} 
