<?php
include 'dbHandler.php';
include 'functions.php';
session_start();


// Deklaration Variablen
$frage = $_POST["fragen"];
$befrager = $_SESSION["session_bname"];
$titelFB = $_SESSION["KopieFB"];


if (isset($_POST["löschenFrage"])) {

    $sqlNr= "SELECT * FROM Fragen WHERE Titel = '$titelFB' AND Fragestellung = '$frage'";
    $result = mysqli_query($conn, $sqlNr);
    $row = mysqli_fetch_assoc($result);
    $frageNr = $row['FrageNr'];

    //Delete Frage
    $sql = "DELETE FROM Fragen WHERE Titel = ? AND FrageNr= ?;";
    deleteFragen($conn, $sql, $titelFB, $frageNr);

}


//Aktualisierung FragenBearbeiten-Seite
if (!$sql) {
    echo mysqli_error($sql);
} else {
    header("Location: ../FragenKopieBearbeiten.php?FrageLöschen=erfolgreich");
}
