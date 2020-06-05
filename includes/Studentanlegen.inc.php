<?php
include 'functions.php';
include 'dbHandler.php';
?>

<?php
// neuen Studenten speichern
if (isset($_POST['studentanlegen'])) {

    // Deklaration Variablen
    $MNR = $_POST['mnr'];
    $Kurskuerzel = $_POST['kurs'];

    //Prüfung, ob Felder befüllt 
    if (empty($MNR)) {
        // Fehlercode in URL
        header("Location: ../Kurs.php?error=leerefelder");
        // Stoppt die Ausführung des Skripts
        exit();
    } else {
        // Prüfung doppelter Studenten
        $sql = "SELECT * FROM studenten WHERE MNR='$MNR' OR Kurs='$Kurskuerzel'";
        // Prüfung, ob Student in der Datenbank bereits enthalten ist
        checkStudent($conn, $sql, $MNR, $Kurskuerzel);
        // Wenn größer 0 -> Matrikelnummer schon vergeben
        if ($resultCheck > 0) {
            header("Location: ../Kurs.php?error=matrikelnummerbereitsvergeben");
            exit();
        } else {
            // Insert SQL-Befehl studenten
            $sql = "INSERT INTO studenten (MNR, Kurs) VALUES (?, ?)";
            // Funktion zum Einfügen von Studenten in die Datenbank
            insertStudent($conn, $sql, $MNR, $Kurskuerzel);
        }
    }
    // Statements schließen
    mysqli_stmt_close($statement);
    // Verbindung beenden
    mysqli_close($conn);
}
