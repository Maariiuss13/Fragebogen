<?php

//Funktion zur Prüfung, ob Titel bereits in DB vorhanden ist FragebogenNEU
function checkTitelDB($conn, $sql, $titel){
        // Initialisieren mit der richtigen Verbindung
        $stmt = mysqli_stmt_init($conn);
        // Verbindung ausführen und überprüfen, ob SQL-Statement einen Fehler hat
        if (!mysqli_stmt_prepare($stmt, $sql)) {
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


//Funktion zur Ausgabe Fragebogen des Befragers
function echoFbBefrager ($conn, $sql, $befrager){
    // prepared statement erstellt
    $stmt= mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../Befrager.php?error=SQLBefehlFehler");
    }
    else{
        //Verknüpfung Parameter zu Placeholder
        mysqli_stmt_bind_param($stmt, "s", $befrager);
        //Parameter in DB verwenden
        mysqli_stmt_execute($stmt);
        //Daten/Ergebnis aus execute-Fkt in Variable verwenden
        $result= mysqli_stmt_get_result($stmt);
        //Ergebnis ausgeben
        while($row= mysqli_fetch_assoc($result)){
            echo $row['titel']."</br>";
        }
    }
}

//Funktion zur Ausgabe aller kopierten Fragen --> FrageKopieBearbeiten funktioniert nicht!!!!!!!!!!!!!!!!!!!
function echoFragenKopie($conn, $sql, $titelFB){
    // prepared statement erstellt
    $stmt= mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../FrageKopieBearbeiten.php?error=SQLFehler");
        echo "SQL Fehler bei Abfrage Fragebogen";
    }
    else{
        //Verknüpfung Parameter zu Placeholder
        mysqli_stmt_bind_param($stmt, "s", $titelFB);
        //Parameter in DB verwenden
        mysqli_stmt_execute($stmt);
        //Daten/Ergebnis aus execute-Fkt in Variable verwenden
        $result= mysqli_stmt_get_result($stmt);
        //Ergebnis ausgeben
        while($row= mysqli_fetch_assoc($result)){
            echo "<option>".$row['Fragestellung']."</option>";
        }
    } 
}


//Funktion zur Auswahl des Fragebogens zum Bearbeiten
function auswahlFbBefragerBearbeiten($conn, $sql, $befrager){
    // prepared statement erstellt
    $stmt= mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../Befrager.php?error=SQLBefehlFehler");
    }
    else{
        //Verknüpfung Parameter zu Placeholder
        mysqli_stmt_bind_param($stmt, "s", $befrager);
        //Parameter in DB verwenden
        mysqli_stmt_execute($stmt);
        //Daten/Ergebnis aus execute-Fkt in Variable verwenden
        $result= mysqli_stmt_get_result($stmt);
        //Ergebnis ausgeben
        while($row= mysqli_fetch_assoc($result)){
            echo "<option>".$row['titel']."</option>";
        }
    }
}


//Funktion zur Auswahl einer Frage zum Löschen
function auswahlFragen($conn, $sql, $titelFB){
    // prepared statement erstellt
    $stmt= mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../Befrager.php?error=SQLBefehlFehler");
    }
    else{
        //Verknüpfung Parameter zu Placeholder
        mysqli_stmt_bind_param($stmt, "s", $titelFB);
        //Parameter in DB verwenden
        mysqli_stmt_execute($stmt);
        //Daten/Ergebnis aus execute-Fkt in Variable verwenden
        $result= mysqli_stmt_get_result($stmt);
        //Ergebnis ausgeben
        while($row= mysqli_fetch_assoc($result)){
            echo "<option>".$row['Fragestellung']."</option>";
        }
    }
}


//Funktion zum Löschen von Fragebogen mit dazugehörigen Fragen
function deleteFrageboegen($conn, $sql, $titel){
    //prepared statement erstellen
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../FragebogenLoeschen.php?error=SQLBefehlFehler");
        exit();
    }
    else{
    //Verknüpfung Parameter mit Placeholdern
    mysqli_stmt_bind_param($stmt, "s", $titel);
    //Run Code in DB
    mysqli_stmt_execute($stmt);
    }

}

//Funktion zum Löschen von Fragen auf der Seite FragenBearbeiten
function deleteFragen($conn, $sql, $titelFB, $frageNr){
    //prepared statement erstellen
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        //header("Location: ../FragenBearbeiten.php?error=SQLBefehlFehler");
        exit();
    }
    else{
    //Verknüpfung Parameter mit Placeholdern
    mysqli_stmt_bind_param($stmt, "ss", $titelFB, $frageNr);
    //Run Code in DB
    mysqli_stmt_execute($stmt);
    }
}


//Funktion zum Insert eines neuen Fragenbogens
function insertFragebogenNeu($conn, $sql, $titel, $beschreibung, $befrager){
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../dbInsertFragebogen.php?error=SQLBefehlFehler");
    }
    else{
        //Verknüpfung Parameter mit Placeholdern
        mysqli_stmt_bind_param($stmt, "sss", $titel, $beschreibung, $befrager);
        //Run Code in DB
        mysqli_stmt_execute($stmt);
    }
}

//Funktion, um für Insert die FrageNr festzulegen - Rückgabe eines Int, der ein Wert höher als bisherige FrageNr
function defineFrageNr($conn, $sql){
    //Senden Befehl an DB und Ausführen
    $frErg = mysqli_query($conn, $sql);
    //Zuweisung Ergebnis einer Variable
    $anzFr = mysqli_fetch_assoc($frErg);
    //FrageNr definieren
    $frageNr = $anzFr['maxAnz']+1;
    return $frageNr;
}


//Funktion zum Insert Frage bei FragebogenKopie
function insertFrageK($conn, $sql, $frageNr, $titel, $frage){
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
function insertFrageB($conn, $sql, $frageNr, $titel, $frage){
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






