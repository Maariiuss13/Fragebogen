<!-- Autor: Dajana Thoebes, Lukas Ströbele, Marius Müller -->
<?php

// Funktion zum Prüfen, ob Befragername bereits in DB vorhanden ist
function checkBefrager($conn, $sql, $befragername)
{
    // Initialisieren mit der richtigen Verbindung
    $statement = mysqli_stmt_init($conn);
    // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
    if (!mysqli_stmt_prepare($statement, $sql)) {
        // Wenn ja, dann SQL-Fehler
        header("Location: ../Befragerregistrierung.php?error=sqlerror");
        exit();
    } else {
        // Benutzereingaben beim Anmeldeversuch
        mysqli_stmt_bind_param($statement, "s", $befragername);
        // Ausführen der Anweisung in der Datenbank
        mysqli_stmt_execute($statement);
        // Nimmt das Ergebnis aus der Datenbank und speichert es in der Variablen $statement
        mysqli_stmt_store_result($statement);
        // Prüft die Anzahl der Ergebnisse der Variable $statement
        $resultCheck = mysqli_stmt_num_rows($statement);
    }
}

// Funktion die prüft, ob das Passwort übereinstimmt und entsprechend eine Session übergibt
function anmeldenBefrager($conn, $sql, $BName, $Passwort, $mess1, $mess2, $mess3, $mess4, $mess5)
{
    // Initialisieren mit der richtigen Verbindung
    $statement = mysqli_stmt_init($conn);
    // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
    if (!mysqli_stmt_prepare($statement, $sql)) {
        // Wenn ja, dann SQL-Fehler
        header($mess1);
        exit();
    } else {
        // Benutzereingaben beim Anmeldeversuch
        mysqli_stmt_bind_param($statement, "ss", $BName, $BName);
        // Ausführen der Anweisung in der Datenbank
        mysqli_stmt_execute($statement);
        // Alle Informationen, die durch die SELECT-Anweisung erhalten wurden,
        // werden in der Variable $result gespeichert
        $result = mysqli_stmt_get_result($statement);
        // Prüfung, ob $result leer ist oder ein Ergebnis liefert
        if ($row = mysqli_fetch_assoc($result)) {
            // Prüft, ob das eingegebene Passwort mit dem aus der Datenbank übereinstimmt
            $passwortCheck = password_verify($Passwort, $row['Passwort']);
            // Wenn nein, Fehlermeldung
            if ($passwortCheck == false) {
                header($mess2);
                exit();
                // Wenn ja, Session wird gestartet und Weiterleitung auf die Befragerseite
            } else if ($passwortCheck == true) {
                session_start();
                $_SESSION['session_bname'] = $row['BName'];
                header($mess3);
                exit();
            } else {
                header($mess4);
                exit();
            }
        } else {
            // Kein Benutzer, der mit den eingegebenen Daten übereinstimmt in der Datenbank
            header($mess5);
            exit();
        }
    }
    // Statements schließen
    mysqli_stmt_close($statement);
    // Verbindung beenden
    mysqli_close($conn);
}

//Autor: Dajana Thoebes
//Funktion zur Prüfung, ob Titel bereits in DB vorhanden ist
function checkTitelDB($conn, $sql, $titel, $sqlerror, $error)
{
    // Initialisieren mit der richtigen Verbindung
    $stmt = mysqli_stmt_init($conn);
    // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Wenn ja, dann SQL-Fehler
        header($sqlerror);
        exit();
    } else {
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
            header($error);
            exit();
        }
    }
    // Statements schließen
    mysqli_stmt_close($stmt);
}

//Autor: Dajana Thoebes
//Funktion zur Prüfung, ob Frage bereits vorhanden
function checkFrage($conn, $sql, $frage, $sqlerror, $error)
{
    // Initialisieren mit der richtigen Verbindung
    $stmt = mysqli_stmt_init($conn);
    // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Wenn ja, dann SQL-Fehler
        header($sqlerror);
        exit();
    } else {
        // Benutzereingaben Frage
        mysqli_stmt_bind_param($stmt, "ss", $frage, $_SESSION["aktFB"]);
        // Ausführen der Anweisung in der Datenbank
        mysqli_stmt_execute($stmt);
        // Nimmt das Ergebnis aus der Datenbank und speichert es in der Variablen $stmt
        mysqli_stmt_store_result($stmt);
        // Prüft die Anzahl der Ergebnisse der Variable $stmt
        $resultCheck = mysqli_stmt_num_rows($stmt);
        // Wenn größer 0 -> Titel schon vergeben
        if ($resultCheck > 0) {
            header($error);
            exit();
        }
    }
    // Statements schließen
    mysqli_stmt_close($stmt);
}

//Autor: Dajana Thoebes
//Funktion zum Prüfen, ob Titel und Kurs einander zugeordnet sind
function checkFragebogenKursZuordnung($conn, $sql, $titelFB, $kurs)
{
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../Auswertungsseite2.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $titelFB, $kurs);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultcheck = mysqli_stmt_num_rows($stmt);
        if ($resultcheck <= 0) {
            header("Location: Auswertungsseite.php?error=KursFBerror");
            exit;
        }
    }
}

//Autor: Dajana Thoebes
//Funktion zur Ausgabe Fragebogen des Befragers
function echoFbBefrager($conn, $sql, $befrager, $sqlerror)
{
    // prepared statement erstellt
    $stmt = mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header($sqlerror);
    } else {
        //Verknüpfung Parameter zu Placeholder
        mysqli_stmt_bind_param($stmt, "s", $befrager);
        //Parameter in DB verwenden
        mysqli_stmt_execute($stmt);
        //Daten/Ergebnis aus execute-Fkt in Variable verwenden
        $result = mysqli_stmt_get_result($stmt);
        //Ergebnis ausgeben
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['titel'] . "</br>";
        }
    }
    // Statements schließen
    mysqli_stmt_close($stmt);
}

function echoAnzahlTeilnehmer($conn, $sql, $titelFB, $kurs)
{
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../Auswertungsseite2.php?error=SQLBefehlFehler");
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $titelFB, $kurs);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "Anzahl Teilnehmer: " . $row['AnzahlTeiln'] . "</br>";
        }
    }
    mysqli_stmt_close($stmt);
}

function echoKommentare($conn, $sql, $titelFB, $kurs)
{
    // prepared statement erstellt
    $stmt = mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../Auswertungsseite2.php?error=SQLBefehlFehler45");
    } else {
        //Verknüpfung Parameter zu Placeholder
        mysqli_stmt_bind_param($stmt, "ss", $titelFB, $kurs);
        //Parameter in DB verwenden
        mysqli_stmt_execute($stmt);
        //Daten/Ergebnis aus execute-Fkt in Variable verwenden
        $result = mysqli_stmt_get_result($stmt);
        //Ergebnis ausgeben
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row['Kommentar'] . "</td></tr>";
        }
    }
    mysqli_stmt_close($stmt);
}

//Autor: Dajana Thoebes
//Funktion zur Ausgabe von Titeln der Fragebogen des Bearbeiters (zur Auswahl des Fragebogens zum Bearbeiten oder Auswerten)
function auswahlFbBefragerBearbeiten($conn, $sql, $befrager, $sqlerror)
{
    // prepared statement erstellt
    $stmt = mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header($sqlerror);
    } else {
        //Verknüpfung Parameter zu Placeholder
        mysqli_stmt_bind_param($stmt, "s", $befrager);
        //Parameter in DB verwenden
        mysqli_stmt_execute($stmt);
        //Daten/Ergebnis aus execute-Fkt in Variable verwenden
        $result = mysqli_stmt_get_result($stmt);
        //Ergebnis ausgeben
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option>" . $row['titel'] . "</option>";
        }
    }
    // Statements schließen
    mysqli_stmt_close($stmt);
}


//TODO
//Funktion zur Auswahl einer Frage zum Löschen
function auswahlFragen($conn, $sql, $titelFB, $sqlerror)
{
    // prepared statement erstellt
    $stmt = mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header($sqlerror);
    } else {
        //Verknüpfung Parameter zu Placeholder
        mysqli_stmt_bind_param($stmt, "s", $titelFB);
        //Parameter in DB verwenden
        mysqli_stmt_execute($stmt);
        //Daten/Ergebnis aus execute-Fkt in Variable verwenden
        $result = mysqli_stmt_get_result($stmt);
        //Ergebnis ausgeben
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option>" . $row['Fragestellung'] . "</option>";
        }
    }
    // Statements schließen
    mysqli_stmt_close($stmt);
}

//Autor: Dajana Thoebes
//Funktion zum Löschen von Fragebogen mit dazugehörigen Fragen
function deleteFrageboegen($conn, $sql, $titel, $sqlerror)
{
    //prepared statement erstellen
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header($sqlerror);
        exit();
    } else {
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "s", $titel);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }
    // Statements schließen
    mysqli_stmt_close($stmt);
}

//Autor: Dajana Thoebes
//Funktion zum Löschen von Fragen
function deleteFragen($conn, $sql, $titelFB, $frageNr, $sqlerror)
{
    //prepared statement erstellen
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header($sqlerror);
        exit();
    } else {
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "ss", $titelFB, $frageNr);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }
    // Statements schließen
    mysqli_stmt_close($stmt);
}

//Autor: Dajana Thoebes
//Funktion zum Update der FrageNr´s nach Löschen einer Frage aus Fragebogen
function updatefragenr($conn, $sql, $titelFB, $sqlerror)
{
    $stmt = mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header($sqlerror);
    } else {
        //Verknüpfung Parameter zu Placeholder
        mysqli_stmt_bind_param($stmt, "s", $titelFB);
        //Parameter in DB verwenden
        mysqli_stmt_execute($stmt);
        //Daten/Ergebnis aus execute-Fkt in Variable verwenden
        $result = mysqli_stmt_get_result($stmt);
        //Ergebnis durchlaufen und Fragenr updaten
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $frageArr = $row['FrageNr'];
            $sqlUpd = "UPDATE fragen SET frageNr = $i WHERE frageNr= $frageArr AND titel = '$titelFB';";
            if (!mysqli_query($conn, $sqlUpd)) {
                echo mysqli_error($conn);
                exit();
            };
            $i++;
        }
    }
    // Statements schließen
    mysqli_stmt_close($stmt);
}

//Autor: Dajana Thoebes
//Funktion zum Insert eines neuen Fragenbogens
function insertFragebogen($conn, $sql, $titel, $beschreibung, $befrager, $sqlerror)
{
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header($sqlerror);
    } else {
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "sss", $titel, $beschreibung, $befrager);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }
    // Statements schließen
    mysqli_stmt_close($stmt);
}

//Autor: Dajana Thoebes
//Funktion, um für Insert die FrageNr festzulegen - Rückgabe eines Int, der ein Wert höher als bisherige FrageNr
function defineFrageNr($conn, $sql)
{
    //Senden Befehl an DB und Ausführen
    $frErg = mysqli_query($conn, $sql);
    //Zuweisung Ergebnis einer Variable
    $anzFr = mysqli_fetch_assoc($frErg);
    //FrageNr definieren
    $frageNr = $anzFr['maxAnz'] + 1;
    return $frageNr;
}

//Autor: Dajana Thoebes
//Funktion zum Insert Fragen
function insertFrage($conn, $sql, $aktS, $titelFb, $frage, $sqlerror)
{
    //prepared statement erstellen
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header($sqlerror);
    } else {
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "sss", $aktS, $titelFb, $frage);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }
    // Statements schließen
    mysqli_stmt_close($stmt);
}

// Funktion zum Einfügen von Kursen in die Datenbank
function insertKurs($conn, $sql, $Kuerzel, $Kurs, $sqlerror, $mess)
{
    // Initialisieren mit der richtigen Verbindung
    $statement = mysqli_stmt_init($conn);
    // Prüfung auf Übereinstimmung
    if (!mysqli_stmt_prepare($statement, $sql)) {
        // Wenn nicht, Fehlermeldung
        header($sqlerror);
        exit();
    } else {
        // Benutzereingaben beim Anmeldeversuch
        mysqli_stmt_bind_param($statement, "ss", $Kuerzel, $Kurs);
        // Ausführen der Anweisung in der Datenbank
        mysqli_stmt_execute($statement);
        header($mess);
        exit();
    }
    // Statements schließen
    mysqli_stmt_close($statement);
}

// Funktion zum Einfügen von Befragern in die Datenbank
function insertBefrager($conn, $sql, $passwort, $befragername)
{
    // Initialisieren mit der richtigen Verbindung
    $statement = mysqli_stmt_init($conn);
    // Prüfung auf Übereinstimmung
    if (!mysqli_stmt_prepare($statement, $sql)) {
        // Wenn nicht, Fehlermeldung
        header("Location: ../Befragerregistrierung.php?error=sqlerror");
        exit();
    } else {
        //Hashing-Operation am Passwort
        $hashedPasswort = password_hash($passwort, PASSWORD_DEFAULT);
        // Benutzereingaben beim Anmeldeversuch
        mysqli_stmt_bind_param($statement, "ss", $befragername, $hashedPasswort);
        // Ausführen der Anweisung in der Datenbank
        mysqli_stmt_execute($statement);
        header("Location: ../Befrageranmeldung.php?anmeldung=erfolgreich");
        exit();
    }
    // Statements schließen
    mysqli_stmt_close($statement);
}

// Funktion zum Einfügen der Daten in die Datenbank - Zuordnung Fragebogen zu Kurs
function insertZuordnung($conn, $sql, $Kuerzel, $Titel)
{
    // Initialisieren mit der richtigen Verbindung
    $statement = mysqli_stmt_init($conn);
    // Prüfung auf Übereinstimmung
    if (!mysqli_stmt_prepare($statement, $sql)) {
        // Wenn nicht, Fehlermeldung
        header("Location: ../KursFragebogenZuordnen.php?error=sqlerror");
        exit();
    } else {
        // Benutzereingaben beim Anmeldeversuch
        mysqli_stmt_bind_param($statement, "ss", $Kuerzel, $Titel);
        // Ausführen der Anweisung in der Datenbank
        mysqli_stmt_execute($statement);
        header("Location: ../KursFragebogenZuordnen.php?fragebogenzuordnen=erfolgreich");
        exit();
    }
    // Statements schließen
    mysqli_stmt_close($statement);
}


// Prüfung, ob Student in der Datenbank bereits enthalten ist
function checkStudent($conn, $sql, $MNR, $Kurskuerzel)
{
    // Initialisieren mit der richtigen Verbindung
    $statement = mysqli_stmt_init($conn);
    // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
    if (!mysqli_stmt_prepare($statement, $sql)) {
        // Wenn ja, dann SQL-Fehler
        header("Location: ../Kurs.php?error=sqlerror");
        exit();
    } else {
        // Benutzereingaben beim Anmeldeversuch
        mysqli_stmt_bind_param($statement, "ss", $MNR, $Kurskuerzel);
        // Ausführen der Anweisung in der Datenbank
        mysqli_stmt_execute($statement);
        // Nimmt das Ergebnis aus der Datenbank und speichert es in der Variablen $statement
        mysqli_stmt_store_result($statement);
    }
    // Statements schließen
    mysqli_stmt_close($statement);
}


// Funktion zum Einfügen von Studenten in die Datenbank
function insertStudent($conn, $sql, $MNR, $Kurskuerzel)
{
    // Initialisieren mit der richtigen Verbindung
    $statement = mysqli_stmt_init($conn);
    // Prüfung auf Übereinstimmung
    if (!mysqli_stmt_prepare($statement, $sql)) {
        // Wenn nicht, Fehlermeldung
        header("Location: ../Kurs.php?error=sqlerror");
        exit();
    } else {
        // Benutzereingaben beim Anmeldeversuch
        mysqli_stmt_bind_param($statement, "ss", $MNR, $Kurskuerzel);
        // Ausführen der Anweisung in der Datenbank
        mysqli_stmt_execute($statement);
        header("Location: ../Kurs.php?studentanlegen=erfolgreich");
        exit();
    }
    // Statements schließen
    mysqli_stmt_close($statement);
}

// Funktion, die dem Student eine Session übergibt bei erfolgreicher Anmeldung
function anmeldenStudent($statement)
{
    // Benutzereingaben beim Anmeldeversuch
    mysqli_stmt_bind_param($statement, "ss", $MNR, $MNR);
    // Ausführen der Anweisung in der Datenbank
    mysqli_stmt_execute($statement);
    // Alle Informationen, die durch die SELECT-Anweisung erhalten wurden,
    // werden in der Variable $result gespeichert
    $result = mysqli_stmt_get_result($statement);
    // Prüfung, ob $result leer ist oder ein Ergebnis liefert
    if ($row = mysqli_fetch_assoc($result)) {
        // Wenn nein, wird Session aktiviert und Weiterleitung auf Seite Studentenanmeldung
        session_start();
        $_SESSION['session_mnr'] = $row['MNR'];
        header("Location: ../Studenten.php?anmelden=success");
        exit();
    } else {
        // Wenn leer, dann ist Matrikelnummer nicht vorhanden
        header("Location: ../Studentenanmeldung.php?error=matrikelnummernichtvergeben");
        exit();
    }
    // Statements schließen
    mysqli_stmt_close($statement);
}

// Funktion, die alle offenen Fragebögen für den Student die in der Datenbank gespeichert sind, anzeigt
function offeneFragebogen($conn, $sql, $mnr, $sqlerror)
{
    //Template für prepared statement
    $sql = "SELECT titel from freischaltenfb inner join studenten on studenten.Kurs=freischaltenfb.Kurs 
            where mnr=? AND freischaltenfb.titel NOT IN (SELECT titel from bearbeitenfb where mnr=?)";
    // prepared statement erstellt
    $stmt = mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header($sqlerror);
    } else {
        //Verknüpfung Parameter zu Placeholder
        mysqli_stmt_bind_param($stmt, "ss", $mnr, $mnr);
        //Parameter in DB verwenden
        mysqli_stmt_execute($stmt);
        //Daten/Ergebnis aus execute-Fkt in Variable verwenden
        $result = mysqli_stmt_get_result($stmt);
        //Ergebnis ausgeben
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option>" . $row['titel'] . "</option>";
        }
    }
    // Statements schließen
    mysqli_stmt_close($stmt);
}

// Funktion, die alle Fragebögen für den Student, welche in Bearbeitung sind, die in der Datenbank gespeichert sind, anzeigt
function fragebogenInBearbeitung($conn, $sql, $student, $sqlerror)
{
    //Template für prepared statement
    $sql = "SELECT titel FROM bearbeitenfb WHERE status = 'B' AND mnr=?";
    // prepared statement erstellt
    $stmt = mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header($sqlerror);
    } else {
        //Verknüpfung Parameter zu Placeholder
        mysqli_stmt_bind_param($stmt, "s", $student);
        //Parameter in DB verwenden
        mysqli_stmt_execute($stmt);
        //Daten/Ergebnis aus execute-Fkt in Variable verwenden
        $result = mysqli_stmt_get_result($stmt);
        //Ergebnis ausgeben
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option>" . $row['titel'] . "</option>";
        }
    }
    // Statements schließen
    mysqli_stmt_close($stmt);
}


// Funktion, die alle Kurse die in der Datenbank gespeichert sind, anzeigt
function kurse($conn, $sql)
{
    // Echo Erstellte Fragebögen des angemeldeten Befragers
    $befrager = $_SESSION['session_bname'];
    //Template für prepared statement
    $sql = "SELECT Kuerzel FROM kurse";
    // prepared statement erstellt
    $stmt = mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../Studenten.php?error=SQLBefehlFehler");
    } else {
        //Verknüpfung Parameter zu Placeholder
        mysqli_stmt_bind_param($stmt, "s", $befrager);
        //Parameter in DB verwenden
        mysqli_stmt_execute($stmt);
        //Daten/Ergebnis aus execute-Fkt in Variable verwenden
        $result = mysqli_stmt_get_result($stmt);
        //Ergebnis ausgeben
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option>" . $row['Kuerzel'] . "</option>";
        }
    }
    // Statements schließen
    mysqli_stmt_close($stmt);
}

//Autor: Dajana Thoebes
//Funktion, die alle Kurse, welche in freischaltenFB vorhanden sind, anzeigt
function echokursfreischalten($conn, $sql)
{
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option>" . $row['kurs'] . "</option>";
    }
}


// Funktion, die alle Fragebögen die in der Datenbank gespeichert sind, anzeigt
function frageboegen($conn, $sql, $befrager)
{
    // Echo Erstellte Fragebögen des angemeldeten Befragers
    $befrager = $_SESSION['session_bname'];
    //Template für prepared statement
    $sql = "SELECT Titel FROM frageboegen";
    // prepared statement erstellt
    $stmt = mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../Studenten.php?error=SQLBefehlFehler");
    } else {
        //Verknüpfung Parameter zu Placeholder
        mysqli_stmt_bind_param($stmt, "s", $befrager);
        //Parameter in DB verwenden
        mysqli_stmt_execute($stmt);
        //Daten/Ergebnis aus execute-Fkt in Variable verwenden
        $result = mysqli_stmt_get_result($stmt);
        //Ergebnis ausgeben
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option>" . $row['Titel'] . "</option>";
        }
    }
    // Statements schließen
    mysqli_stmt_close($stmt);
}

//Autor: Marius Müller, Dajana Thoebes
// Funktion, die den Status eines Fragebogens auf in Bearbeitung setzt
function statusInBearbeitung($conn, $sql, $FbTitel, $mnr, $neuerStatus)
{
    $statement = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($statement, $sql)) {
        header("Location: ../Studenten.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($statement, "sss", $FbTitel, $mnr, $neuerStatus);
        mysqli_stmt_execute($statement);
    }
    // Statements schließen
    mysqli_stmt_close($statement);
}

//Autor: Marius Müller, Dajana Thoebes
//Funktion, die den Status eines Fragebogens auf Fertig setzt
function statusFertig($conn, $sql, $neuerStatus, $FbTitel, $mnr)
{
    $statement = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($statement, $sql)) {
        header("Location: ../Studenten.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($statement, "sss", $neuerStatus, $FbTitel, $mnr);
        mysqli_stmt_execute($statement);
    }
    // Statements schließen
    mysqli_stmt_close($statement);
}

//Autor: Marius Müller, Dajana Thoebes
function aktFrageFB($conn, $sql, $titelFB, $anzFr, $mnr)
{
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../Fragenseiten.php?error=sqlerror");
    } else {
        mysqli_stmt_bind_param($stmt, "sss", $titelFB, $anzFr, $mnr);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        //Ergebnis ausgeben
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['Fragestellung'];
        }
    }
    // Statements schließen
    mysqli_stmt_close($stmt);
}

//Autor: Dajana Thoebes
//Funktion zur Berechnung der Varianz
function varianzBerechnen($conn, $sql, $titelFB, $kurs, $avg)
{
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: Auswertungsseite2.php?error=SQLBefehlFehler");
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $titelFB, $kurs);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        //Definiere Variable $count - Anzahl der rows im Ergebnis
        $count = mysqli_num_rows($result);

        if ($count <= 0) {
            header("Location: Auswertungsseite2.php?error=keineErgebnisse");
            exit();
        }

        //Varianz berechnen
        $var = 0.0;
        while ($row = mysqli_fetch_assoc($result)) {
            $var += pow($row['Bewertungswert'] - $avg, 2);
        }
        $var = $var / $count;
        return $var;
    }
}

//Autor: Marius Müller, Dajana Thoebes
//Funktion zur Ausgabe der Auswertungsergebnisse
function auswertungFunktion($conn, $sql, $titelFB, $kurs)
{
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: Auswertungsseite2.php?error=SQLBefehlFehler");
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $titelFB, $kurs);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            //Ergebnisse ins Array übergeben
            $auswert["FrageNr"] = $row['FrageNr'];
            $auswert["Minimum"] = $row['min'];
            $auswert["Maximum"] = $row['max'];
            $auswert["Durchschnitt"] = $row['avg'];

            $avg = $auswert["Durchschnitt"];
            $frageNr = $row['FrageNr'];

            //Ergebnisse zur Berechnung Varianz holen
            $sqlbewert = "SELECT * FROM beantwortenf JOIN studenten ON beantwortenf.mnr=studenten.MNR JOIN bearbeitenfb ON beantwortenf.Titel=bearbeitenfb.Titel
              WHERE beantwortenf.titel=? AND Kurs=? AND frageNr=$frageNr AND status='F';";
            //Varianz berechnen
            $var = varianzBerechnen($conn, $sqlbewert, $titelFB, $kurs, $avg);

            //Berechnung Standardabweichung
            $stdabw = sqrt($var);
            $auswert["Standardabweichung"] = $stdabw;

            //Ausgeben der Array-Werte
            echo "<tr><td>" . $auswert['FrageNr'] . "</td>";
            echo "<td>" . $auswert['Durchschnitt'] . "</td>";
            echo "<td>" . $auswert['Minimum'] . "</td>";
            echo "<td>" . $auswert['Maximum'] . "</td>";
            echo "<td>" . $auswert['Standardabweichung'] . "</td> </tr>";
        }
        mysqli_stmt_close($stmt);
    }
}

//Autor: Dajana Thoebes
function aktAntwF($conn, $sql, $mnr, $frageNr, $titelFB)
{
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../Fragenseiten2.php?error=sqlerror");
    } else {
        mysqli_stmt_bind_param($stmt, "sss", $mnr, $frageNr, $titelFB);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            return $row['Bewertungswert'];
        }
    }
    // Statements schließen
    mysqli_stmt_close($stmt);
}


//Autor: Dajana Thoebes
//Funktion zum Insert eines Kommentars
function insertKommentar($conn, $sql, $kommentar, $titelFB, $mnr)
{
    //prepared statement erstellen
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../AbschlussseiteFragebogen.php?error=SQLBefehlFehler");
        exit();
    } else {
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "sss", $kommentar, $titelFB, $mnr);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }
}

//Autor: Dajana Thoebes
//Funktion zum Update einer Bewertung und wenn noch nicht vorhanden, dann Insert
function updateinsertBewertung($conn, $sql, $mnr, $frageNr, $titelFB, $bewertung)
{
    //prepared statement erstellen
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../Fragenseiten2.php?error=SQLBefehlFehler");
        exit();
    } else {
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "sssss", $mnr, $frageNr, $titelFB, $bewertung, $bewertung);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }
    // Statements schließen
    mysqli_stmt_close($stmt);
}
