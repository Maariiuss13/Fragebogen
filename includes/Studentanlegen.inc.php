<!-- Autor: Lukas Ströbele -->
<?php
include 'functions.php';
include 'dbHandler.php';
?>

<?php
// neuen Studenten speichern
if (isset($_POST['studentanlegen'])) {

    // Deklaration Variablen
    $MNR = htmlspecialchars(stripslashes(trim($_POST['mnr'])));
    $Kurskuerzel = htmlspecialchars(stripslashes(trim($_POST['kurs'])));

    //Prüfung, ob Felder befüllt 
    if (empty($MNR)) {
        // Fehlercode in URL
        header("Location: ../Kurs.php?error=leerefelderstudent");
        // Stoppt die Ausführung des Skripts
        exit();
    } else {
        // Template für prepared statement (Prüfung doppelter Studenten)
        $sql = "SELECT * FROM studenten WHERE MNR=? AND Kurs=?";
        // prepared statement generieren
        $statement = mysqli_stmt_init($conn);
        // prepared statement vorbereiten
        if (!mysqli_stmt_prepare($statement, $sql)) {
            // SQL-Error
            header("Location: ../Kurs.php?error=sqlerror");
            exit();
        } else {
            // Verknüpfung Parameter zu Placeholder (Benutzereingaben MNR/Kürzel)
            mysqli_stmt_bind_param($statement, "ss", $MNR, $Kurskuerzel);
            // Ausführen der Anweisung in der Datenbank
            mysqli_stmt_execute($statement);
            // Nimmt das Ergebnis aus der Datenbank und speichert es in der Variablen $statement
            mysqli_stmt_store_result($statement);
        }
        // Alle Informationen, die durch die SELECT-Anweisung erhalten wurden,
        // werden in der Variable $result gespeichert
        $resultCheck = mysqli_stmt_num_rows($statement);
        // Wenn größer 0 -> Matrikelnummer schon vergeben
        if ($resultCheck > 0) {
            header("Location: ../Kurs.php?error=matrikelnummerbereitsvergeben");
            exit();
        } else {
            // Insert SQL-Befehl studenten
            $sql = "INSERT INTO studenten (MNR, Kurs) VALUES (?, ?)";
            // Funktion zum Einfügen von Studenten in die Datenbank
            insertStudent($conn, $sql, $MNR, $Kurskuerzel, $sqlerror);
        }
    }
    // Statements schließen
    mysqli_stmt_close($statement);
    // Verbindung beenden
    mysqli_close($conn);
}
