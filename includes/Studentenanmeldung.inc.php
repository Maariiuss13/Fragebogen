<!-- Autor: Lukas Ströbele -->
<?php
include 'functions.php';
include 'dbHandler.php';
?>

<?php
// Prüfung - Anmeldebutton gedrückt
if (isset($_POST['studentenanmeldung'])) {

    // Deklaration Variablen
    $MNR = htmlspecialchars(stripslashes(trim($_POST['mnr'])));

    // Prüfung, ob Felder befüllt
    if (empty($MNR)) {
        // Fehlercode in URL
        header("Location: ../Studentenanmeldung.php?error=leeresFeld");
        // Stoppt die Ausführung des Skripts
        exit();
    } else {
        // Template für prepared statement (Prüfung doppelter Matrikelnummern)
        $sql = "SELECT MNR FROM studenten WHERE MNR=$MNR";
        // prepared statement generieren
        $statement = mysqli_stmt_init($conn);
        // prepared statement vorbereiten
        if (!mysqli_stmt_prepare($statement, $sql)) {
            // SQL-Error
            header("Location: ../Studentenanmeldung.php?error=sqlerror");
            exit();
        } else {
            // Funktion, die dem Student eine Session übergibt bei erfolgreicher Anmeldung
            anmeldenStudent($statement);
        }
        // Statements schließen
        mysqli_stmt_close($statement);
        // Verbindung beenden
        mysqli_close($conn);
    }
}
