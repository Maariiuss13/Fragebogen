<?php

//Funktion zur Prüfung, ob Titel bereits in DB vorhanden ist FragebogenNEU
function checkTitelDB($conn, $sql, $titel)
{
    // Initialisieren mit der richtigen Verbindung
    $stmt = mysqli_stmt_init($conn);
    // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Wenn ja, dann SQL-Fehler
        header("Location: ../FragebogenNeu.php?error=sqlerror");
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
            header("Location: ../FragebogenNeu.php?error=TitelBereitsVorhanden");
            exit();
        }
    }
}

//Funktion zur Prüfung, ob Frage bereits vorhanden für FragebogenNEU
function checkFrage($conn, $sql, $frage)
{
    // Initialisieren mit der richtigen Verbindung
    $stmt = mysqli_stmt_init($conn);
    // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Wenn ja, dann SQL-Fehler
        header("Location: ../FragenseitenNeu.php?error=sqlerror");
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
            header("Location: ../FragebogenNeu.php?error=FrageBereitsVorhanden");
            exit();
        }
    }
}


//Funktion zur Ausgabe Fragebogen des Befragers
function echoFbBefrager($conn, $sql, $befrager)
{
    // prepared statement erstellt
    $stmt = mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../Befrager.php?error=SQLBefehlFehler");
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
}

//Funktion zur Ausgabe aller kopierten Fragen --> FrageKopieBearbeiten funktioniert nicht!!!!!!!!!!!!!!!!!!!
function echoFragenKopie($conn, $sql, $titelFB)
{
    // prepared statement erstellt
    $stmt = mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../FrageKopieBearbeiten.php?error=SQLFehler");
        echo "SQL Fehler bei Abfrage Fragebogen";
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
}


//Funktion zur Auswahl des Fragebogens zum Bearbeiten
function auswahlFbBefragerBearbeiten($conn, $sql, $befrager)
{
    // prepared statement erstellt
    $stmt = mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../Befrager.php?error=SQLBefehlFehler");
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
}


//Funktion zur Auswahl einer Frage zum Löschen
function auswahlFragen($conn, $sql, $titelFB)
{
    // prepared statement erstellt
    $stmt = mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../Befrager.php?error=SQLBefehlFehler");
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
}


//Funktion zum Löschen von Fragebogen mit dazugehörigen Fragen
function deleteFrageboegen($conn, $sql, $titel)
{
    //prepared statement erstellen
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../FragebogenLoeschen.php?error=SQLBefehlFehler");
        exit();
    } else {
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "s", $titel);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }
}

//Funktion zum Löschen von Fragen auf der Seite FragenBearbeiten
function deleteFragen($conn, $sql, $titelFB, $frageNr)
{
    //prepared statement erstellen
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        //header("Location: ../FragenBearbeiten.php?error=SQLBefehlFehler");
        exit();
    } else {
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "ss", $titelFB, $frageNr);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }
}

//Funktion zum Update der FrageNr´s nach Löschen einer Frage aus Fragebogen
function updatefragenr($conn, $sql, $titelFB){
    $stmt = mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../FragenKopieBearbeiten.php?error=SQLBefehlFehler");
    } else {
        //Verknüpfung Parameter zu Placeholder
        mysqli_stmt_bind_param($stmt, "s", $titelFB);
        //Parameter in DB verwenden
        mysqli_stmt_execute($stmt);
        //Daten/Ergebnis aus execute-Fkt in Variable verwenden
        $result = mysqli_stmt_get_result($stmt);
        //Ergebnis durchlaufen und Fragenr updaten
        $i=1;
        while ($row = mysqli_fetch_assoc($result)) {
            $frageArr = $row['FrageNr'];
            $sqlUpd = "UPDATE fragen SET frageNr = $i WHERE frageNr= $frageArr AND titel = '$titelFB';";
            if(!mysqli_query($conn, $sqlUpd)){
                echo mysqli_error($conn);
                exit();
            };
            $i++;
        }
         
    }
}


//Funktion zum Insert eines neuen Fragenbogens
function insertFragebogenNeu($conn, $sql, $titel, $beschreibung, $befrager)
{
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../dbInsertFragebogen.php?error=SQLBefehlFehler");
    } else {
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "sss", $titel, $beschreibung, $befrager);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }
}

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



//Funktion zum Insert Fragen bei FragebogenNeu
function insertFrageN($conn, $sql, $frage)
{
    //prepared statement erstellen
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../FragebogenNeu.php?error=SQLBefehlFehler");
    } else {
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "sss", $_SESSION["aktSeite"], $_SESSION["aktFB"], $frage);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }
}

//Funktion zum Insert Frage bei FragebogenKopie
function insertFrageK($conn, $sql, $frageNr, $titel, $frage)
{
    //prepared statement erstellen
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../FragenKopieBearbeiten.php?error=SQLBefehlFehlerFB");
        exit();
    } else {
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "sss", $frageNr, $titel, $frage);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }
}


//Funktion zum Insert Fragen bei FragenBearbeiten
function insertFrageB($conn, $sql, $frageNr, $titel, $frage)
{
    //prepared statement erstellen
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../FragenBearbeiten.php?error=SQLBefehlFehlerFB");
        exit();
    } else {
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "sss", $frageNr, $titel, $frage);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }
}

// Funktion zum Prüfen, ob Kurs bereits in DB vorhanden ist
function checkKurs($conn, $sql, $Kuerzel, $Kurs)
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
        mysqli_stmt_bind_param($statement, "ss", $Kuerzel, $Kurs);
        // Ausführen der Anweisung in der Datenbank
        mysqli_stmt_execute($statement);
        // Nimmt das Ergebnis aus der Datenbank und speichert es in der Variablen $statement
        mysqli_stmt_store_result($statement);
        // Alle Informationen, die durch die SELECT-Anweisung erhalten wurden,
        // werden in der Variable $result gespeichert
        $resultCheck = mysqli_stmt_num_rows($statement);
    }
}

// Funktion zum Einfügen von Kursen in die Datenbank
function insertKurs($conn, $sql, $Kuerzel, $Kurs)
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
        mysqli_stmt_bind_param($statement, "ss", $Kuerzel, $Kurs);
        // Ausführen der Anweisung in der Datenbank
        mysqli_stmt_execute($statement);
        header("Location: ../Kurs.php?kursanlegen=erfolgreich");
        exit();
    }
}

// Funktion die prüft, ob das Passwort übereinstimmt und entsprechend eine Session übergibt
function anmeldenBefrager($conn, $sql, $BName, $Passwort)
{
    // Initialisieren mit der richtigen Verbindung
    $statement = mysqli_stmt_init($conn);
    // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
    if (!mysqli_stmt_prepare($statement, $sql)) {
        // Wenn ja, dann SQL-Fehler
        header("Location: ../Befrageranmeldung.php?error=sqlerror");
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
                header("Location: ../Befrageranmeldung.php?error=falscherbefragernameoderpasswort");
                exit();
                // Wenn ja, Session wird gestartet und Weiterleitung auf die Befragerseite
            } else if ($passwortCheck == true) {
                session_start();
                $_SESSION['session_bname'] = $row['BName'];
                header("Location: ../Befrager.php?anmeldung=erfolgreich");
                exit();
            } else {
                header("Location: ../Befrageranmeldung.php?error=keineübereinstimmung");
                exit();
            }
        } else {
            // Kein Benutzer, der mit den eingegebenen Daten übereinstimmt in der Datenbank
            header("Location: ../Befrageranmeldung.php?error=keinbefrager");
            exit();
        }
    }
}

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
}

// Funktion zum Einfügen der Daten in die Datenbank
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
}

// Funktion, die alle offenen Fragebögen für den Student die in der Datenbank gespeichert sind, anzeigt
function offeneFragebogen($conn, $sql, $mnr)
{
    //Template für prepared statement
    $sql = "SELECT titel from freischaltenfb inner join studenten on studenten.Kurs=freischaltenfb.Kurs where mnr=$mnr AND freischaltenfb.titel NOT IN (SELECT titel from bearbeitenfb where mnr=$mnr)";
    // prepared statement erstellt
    $stmt = mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../Studenten.php?error=SQLBefehlFehler");
    } else {
        //Verknüpfung Parameter zu Placeholder
        mysqli_stmt_bind_param($stmt, "s", $mnr);
        //Parameter in DB verwenden
        mysqli_stmt_execute($stmt);
        //Daten/Ergebnis aus execute-Fkt in Variable verwenden
        $result = mysqli_stmt_get_result($stmt);
        //Ergebnis ausgeben
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option>" . $row['titel'] . "</option>";
        }
    }
}

// Funktion, die alle Fragebögen für den Student, welche in Bearbeitung sind, die in der Datenbank gespeichert sind, anzeigt
function fragebogenInBearbeitung($conn, $sql, $student)
{
    //Template für prepared statement
    $sql = "SELECT titel FROM bearbeitenfb WHERE status = 'B'";
    // prepared statement erstellt
    $stmt = mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../Studenten.php?error=SQLBefehlFehler");
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
}

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
}

//Funktion, die den Status eines Fragebogens auf Fertig setzt
function statusFertig($conn, $sql, $neuerStatus, $FbTitel, $mnr){
    $statement = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($statement, $sql)) {
      header("Location: ../Studenten.php?error=sqlerror");
      exit();
    } else {
      mysqli_stmt_bind_param($statement, "sss", $neuerStatus, $FbTitel, $mnr);
      mysqli_stmt_execute($statement);
    }
}

//WOHER????????????????
function titelFragebogen($conn, $sql, $befrager)
{
    //Abfrage SQL
    $befrager=$_SESSION['session_bname'];
    $sql= "SELECT titel FROM frageboegen WHERE Befrager='$befrager';";
    //Speicherung Ergebnis in Variable
    $result= mysqli_query($conn, $sql);
    //Ausgabe Ergebnis
    while($row= mysqli_fetch_assoc($result)){
    echo "<option>".$row['titel']."</option>";
    }
}

function aktFrageFB($conn, $sql, $titelFB,$anzFr){
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../Fragenseiten.php?error=sqlerror");
    }
    else{
        mysqli_stmt_bind_param($stmt, "ss", $titelFB, $anzFr);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        //Ergebnis ausgeben
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['Fragestellung'];
        }
    }
}
