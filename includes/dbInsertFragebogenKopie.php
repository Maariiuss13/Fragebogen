<?php
include 'dbHandler.php';
session_start();


// Deklaration Variablen
$titelAlt = $_POST["fbTitelAlt"];
$titelNeu = $_POST["fbTitelNeu"];
$befrager = $_SESSION["session_bname"];

//Deklaration Session-Variablen für Fragenseiten
$_SESSION["alterFB"] = $_POST["fbTitelAlt"];

//Beschreibung kopieren
$sqlBeschr= "SELECT * FROM frageboegen WHERE Titel='$titelAlt';";
//Senden Befehl an DB und Ausführen
$beschrErg= mysqli_query($conn, $sqlBeschr);
//Zuweisung Ergebnis einer Variable
$beschrRow = mysqli_fetch_assoc($beschrErg);

//neuen Fragebogen speichern
if(isset($_POST["speichernFragebogenKopie"])){
    //Prüfen, ob Felder befüllt 
    if(empty($titelNeu)){
        header("Location: ../FragebogenKopieren.php?error=leerefelder");
        exit();
    }
    //Prüfen, ob Titel neu und alt gleich
    elseif($titelAlt==$titelNeu){
        header("Location: ../FragebogenKopieren.php?error=TitelGleich");
        exit();
    }
    //Prüfen, ob Titel länger als 10 Char
    elseif(strlen($titel)>10){
        header("Location: ../FragebogenNeu.php?error=TitelZuLang");
        exit();
    }
    //Prüfen, ob DS schon vorhanden ist, fehlt!!!!!!!!!!!!!!!
    else{
        //Insert SQL-Befehl Fragebogen --> Beschreibung Fehler!!!!!!!!!!!!!!
        $sql= "INSERT INTO frageboegen(titel, beschreibung, befrager) VALUES(?, ?, ?);";
        //prepared statement erstellen
        $stmt=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../dbInsertFragebogen.php?error=SQLBefehlFehler");
        }
        else{
           //Verknüpfung Parameter mit Placeholdern
           mysqli_stmt_bind_param($stmt, "sss", $titelNeu, $beschrRow['Beschreibung'], $befrager);
           //Run Code in DB
           mysqli_stmt_execute($stmt);
        }        
    }    
}

//Weiterleitung auf Fragen-Seite
if (!$sql) {
    echo mysqli_error($sql);
}
else {
    header("Location: ../FragenBearbeiten.php?FragebogenKopieren=erfolgreich");
}