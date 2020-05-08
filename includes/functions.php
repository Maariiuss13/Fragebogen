<?php

//Funktion zur Prüfung, ob Titel bereits in DB vorhanden ist
function checkTitelDB($conn, $sql, $titel){
        // Initialisieren mit der richtigen Verbindung
        $stmt = mysqli_stmt_init($conn);
        // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
        if (!mysqli_stmt_prepare($stmt, $sqlTitel)) {
            // Wenn ja, dann SQL-Fehler
            header("Location: ../FragebogenNeu.php?error=sqlerror");
            exit();
        } 
        else {
            // Benutzereingaben Titel
            mysqli_stmt_bind_param($stmt, "s", $titel);
            // Ausführen der Anweisung in der Datenbank
            mysqli_stmt_execute($stmt);
            // Nimmt das Ergebnis aus der Datenbank und speichert es in der Variablen $stmt
            mysqli_stmt_store_result($stmt);
            // Prüft die Anzahl der Ergebnisse der Variable $stmt
            $resultCheck = mysqli_stmt_num_rows($stmt);
            // Wenn größer 0 -> Titel schon vergeben
            if ($resultCheck > 0) {
                header("Location: ../FragebogenNeu.php?error=TitelBereitsVergeben");
            exit();
            }
        }
    }