<?php
include 'functions.php';
include 'dbHandler.php';
?>

<?php
// Prüfen, ob der Befrager auf den Button klickt
if (isset($_POST['kursanlegen'])) {

    // Deklaration Variablen
    $Kurs = htmlspecialchars(stripslashes(trim($_POST['kursname'])));
    $Kuerzel = htmlspecialchars(stripslashes(trim($_POST['kurskuerzel'])));

    // Prüfung, ob Felder befüllt 
    if (empty($Kurs) || empty($Kuerzel)) {
        // Fehlercode in URL
        header("Location: ../Kurs.php?error=leerefelderkurs");
        // Stoppt die Ausführung des Skripts
        exit();
    } else {
        // Prüfung, ob doppelte Kursekürzel
        $sql = "SELECT * FROM kurse WHERE Kuerzel='$Kuerzel'";
        $sqlerror="Location: ../Kurs.php?error=sqlerror";
        // Funktion zum Prüfen, ob Kurs bereits in DB vorhanden ist
        checkKurs($conn, $sql, $Kuerzel, $Kurs, $sqlerror);
        // Wenn größer 0 -> Kursname schon vergeben
        if ($resultCheck > 0) {
            header("Location: ../Kurs.php?error=kursnamebereitsvergeben");
            exit();
        } else {
            // Insert SQL-Befehl kurse
            $sql = "INSERT INTO kurse (Kuerzel, KName) VALUES (?, ?)";
            // Funktion zum Einfügen von Kursen in die Datenbank
            $sqlerror="Location: ../Kurs.php?error=sqlerror";
            $mess="Location: ../Kurs.php?kursanlegen=erfolgreich";
            insertKurs($conn, $sql, $Kuerzel, $Kurs, $sqlerror, $mess);
        }
    }
    // Statements schließen
    mysqli_stmt_close($statement);
    // Verbindung beenden
    mysqli_close($conn);
}
