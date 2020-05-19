<?php
include 'dbHandler.php';
session_start();


// Deklaration Variablen
$frage = $_POST["fragen"];
$befrager = $_SESSION["session_bname"];


if (isset($_POST["löschenFrage"])) {
    //Delete Frage
    $sql = "DELETE FROM Fragen WHERE Fragestellung = ?;";
    mysqli_stmt_init($conn);
    // prepared statement erstellt
    $stmt= mysqli_stmt_init($conn);
    // prepared statement vorbereiten
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../FragenKopieBearbeiten.php?error=SQLBefehlFehler");
    }
    else{
        //Verknüpfung Parameter zu Placeholder
        mysqli_stmt_bind_param($stmt, "s", $frage);
        //Parameter in DB verwenden
        mysqli_stmt_execute($stmt);
        mysqli_query($conn, $sql);
        //Update Fragennr notwendig? !!!!!!!!!!!!!!!!!!
    }
}


//Aktualisierung FragenBearbeiten-Seite
if (!$sql) {
    echo mysqli_error($sql);
} else {
    header("Location: ../FragenKopieBearbeiten.php?FrageLöschen=erfolgreich");
}
