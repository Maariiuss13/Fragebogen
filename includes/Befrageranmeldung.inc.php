<!-- Autor: Lukas Ströbele -->
<?php
include 'functions.php';
include 'dbHandler.php';

// Prüfung - Anmeldebutton gedrückt
if (isset($_POST['befrageranmeldung'])) {

    // Deklaration Variablen
    $BName = htmlspecialchars(stripslashes(trim($_POST['befragername'])));
    $Passwort = htmlspecialchars(stripslashes(trim($_POST['passwort'])));

    // Prüfung, ob Felder befüllt
    if (empty($BName) || empty($Passwort)) {
        // Fehlercode in URL
        header("Location: ../Befrageranmeldung.php?error=leerefelder");
        // Stoppt die Ausführung des Skripts
        exit();
    } else {
        // Template für prepared statement
        $sql = "SELECT * FROM befrager WHERE BName=?";
        // Funktion die prüft, ob das Passwort übereinstimmt und entsprechend eine Session übergibt
        $mess1 = "Location: ../Befrageranmeldung.php?error=sqlerror";
        $mess2 = "Location: ../Befrageranmeldung.php?error=falscherbefragernameoderpasswort";
        $mess3 = "Location: ../Befrager.php?anmeldung=erfolgreich";
        $mess4 = "Location: ../Befrageranmeldung.php?error=keineübereinstimmung";
        $mess5 = "Location: ../Befrageranmeldung.php?error=keinbefrager";
        anmeldenBefrager($conn, $sql, $BName, $Passwort, $mess1, $mess2, $mess3, $mess4, $mess5);
    }
}
