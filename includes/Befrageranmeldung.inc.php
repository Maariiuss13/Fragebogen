<!-- Autor: Lukas Ströbele -->
<?php
include 'functions.php';
include 'dbHandler.php';
?>

<?php
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
        // Prüfung, ob Daten in der Tabelle enthalten sind
        $sql = "SELECT * FROM befrager WHERE BName='$BName'";
        // Funktion die prüft, ob das Passwort übereinstimmt und entsprechend eine Session übergibt
        $sqlerror="Location: ../Befrageranmeldung.php?error=sqlerror";
        $err1="Location: ../Befrageranmeldung.php?error=falscherbefragernameoderpasswort";
        $mess="Location: ../Befrager.php?anmeldung=erfolgreich";
        $err2="Location: ../Befrageranmeldung.php?error=keineübereinstimmung";
        $err3="Location: ../Befrageranmeldung.php?error=keinbefrager";
        anmeldenBefrager($conn, $sql, $BName, $Passwort, $sqlerror, $err1, $mess, $err2, $err3);
    }
    // Statements schließen
    mysqli_stmt_close($statement);
    // Verbindung beenden
    mysqli_close($conn);
}
