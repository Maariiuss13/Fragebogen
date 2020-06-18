<!-- Autor: Lukas Ströbele -->
<?php
include 'functions.php';
include 'dbHandler.php';

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
        // Template für prepared statement (Prüfung, ob doppelte Kursekürzel)
        $sql = "SELECT * FROM kurse WHERE Kuerzel=?";
        $sqlerror = "Location: ../Kurs.php?error=sqlerror";
        // prepared statement generieren
        $statement = mysqli_stmt_init($conn);
        // prepared statement vorbereiten
        if (!mysqli_stmt_prepare($statement, $sql)) {
            // SQL-Fehler
            header($sqlerror);
            exit();
        } else {
            // Verknüpfung Parameter zu Placeholder (Benutzereingaben Kürzel/Kurs)
            mysqli_stmt_bind_param($statement, "ss", $Kuerzel, $Kurs);
            // Ausführen der Anweisung in der Datenbank
            mysqli_stmt_execute($statement);
            // Nimmt das Ergebnis aus der Datenbank und speichert es in der Variablen $statement
            mysqli_stmt_store_result($statement);
            // Alle Informationen, die durch die SELECT-Anweisung erhalten wurden,
            // werden in der Variable $result gespeichert
            $resultCheck = mysqli_stmt_num_rows($statement);
        }
        // Wenn größer 0 -> Kursname schon vergeben
        if ($resultCheck > 0) {
            header("Location: ../Kurs.php?error=kursnamebereitsvergeben");
            exit();
        } else {
            // Insert SQL-Befehl kurse
            $sql = "INSERT INTO kurse (Kuerzel, KName) VALUES (?, ?)";
            // Funktion zum Einfügen von Kursen in die Datenbank
            $sqlerror = "Location: ../Kurs.php?error=sqlerror";
            $mess = "Location: ../Kurs.php?kursanlegen=erfolgreich";
            insertKurs($conn, $sql, $Kuerzel, $Kurs, $sqlerror, $mess);
        }
    }
    // Statements schließen
    mysqli_stmt_close($statement);
    // Verbindung beenden
    mysqli_close($conn);
}
