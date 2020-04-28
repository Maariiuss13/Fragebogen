<?php
include 'dbHandler.php';

// Deklaration Variablen
$titel= $_POST["titelFragebogen"];
$beschreibung= $_POST["beschreibungFB"];
$beschreibungF= $_POST["beschreibungF"]
// Befrager noch durch Session Variable ersetzen
$befrager= $_POST["nameBefrager"];

//Insert Fragebogen
$sqlFB="INSERT INTO frageboegen (titel, beschreibung, befrager) VALUES ($titel, $beschreibung, $befrager);"; 
mysqli_query($conn, $sqlFB);


//Insert Fragen
$sqlF= "INSERT INTO fragen (titel, fragestellung) VALUES ($titel, $beschreibungF);";
mysqli_query($conn, $sqlF);


//Weiterleitung auf Befrager-Seite
//header("Location: ../Befrager.php?FragebogenSpeichern=erfolgreich");