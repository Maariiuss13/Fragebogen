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
        // Prüfung doppelter Matrikelnummern
        $sql = "SELECT MNR FROM studenten WHERE MNR='$MNR'";
        // Initialisieren mit der richtigen Verbindung
        $statement = mysqli_stmt_init($conn);
        // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
        if (!mysqli_stmt_prepare($statement, $sql)) {
            // Ja - SQL-Fehler
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
