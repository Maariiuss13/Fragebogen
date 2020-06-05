<?php
include 'functions.php';
include 'dbHandler.php';
?>

<?php
// Kurs Fragebogen zuordnen
if (isset($_POST['fragebogenzuordnen'])) {

    // Deklaration Variablen
    $Kuerzel = $_POST['kurskuerzel'];
    $Titel = $_POST['fragebogentitel'];

    // Prüfung doppelter Titel
    $sql = "SELECT * FROM freischaltenfb WHERE Titel='$Titel'";
    // Initialisieren mit der richtigen Verbindung
    $statement = mysqli_stmt_init($conn);
    // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
    if (!mysqli_stmt_prepare($statement, $sql)) {
        // Ja - SQL-Fehler
        header("Location: ../KursFragebogenZuordnen.php?error=sqlerror");
        exit();
    } else {
        // Insert SQL-Befehl freischaltenfb
        $sql = "INSERT INTO freischaltenfb (Titel, Kurs) VALUES ('$Titel', '$Kuerzel')";
        // Funktion zum Einfügen der Daten in die Datenbank
        insertZuordnung($conn, $sql, $Kuerzel, $Titel);
    }
    // Statements schließen
    mysqli_stmt_close($statement);
    // Verbindung beenden
    mysqli_close($conn);
}
