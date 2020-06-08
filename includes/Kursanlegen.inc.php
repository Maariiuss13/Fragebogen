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
        // Funktion zum Prüfen, ob Kurs bereits in DB vorhanden ist
        checkKurs($conn, $sql, $Kuerzel, $Kurs);
        // Wenn größer 0 -> Kursname schon vergeben
        if ($resultCheck > 0) {
            header("Location: ../Kurs.php?error=kursnamebereitsvergeben");
            exit();
        } else {
            // Insert SQL-Befehl kurse
            $sql = "INSERT INTO kurse (Kuerzel, KName) VALUES (?, ?)";
            // Funktion zum Einfügen von Kursen in die Datenbank
            insertKurs($conn, $sql, $Kuerzel, $Kurs);
        }
    }
    // Statements schließen
    mysqli_stmt_close($statement);
    // Verbindung beenden
    mysqli_close($conn);
}
