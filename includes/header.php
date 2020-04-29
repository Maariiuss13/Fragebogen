<?php
// Aktiviert eine Session
session_start();
// Prüfung, ob eine Sessionvariable belegt ist
// Wenn ja, ist man angemeldet  
if (isset($_SESSION['session_bname']) || isset($_SESSION['session_mnr'])) {
  echo '<p align="center">Sie sind eingeloggt!</p>';
  // Wenn nein, wird der Benutzer auf die Startseite umgeleitet, 
  // da er ansonsten ohne Anmeldung auf diese Seite kommen würde
} else if (isset($_SESSION['bname']) == false || isset($_SESSION['mnr']) == false) {
  header("Location: Startseite.php");
  exit();
}
?>
<?php
include 'includes/dbHandler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <div align="center">
    <table>
      <tr>
        <th><img src="Fragen.jpg" width="100%" height="15%"></th>
      </tr>
      <tr>
        <th align="right">
          <form action="includes/Abmelden.inc.php"><button type="submit" name="abmelden" style="background-color: rgb(255, 175, 2); color: white; width: 100%; padding: 14px 20px; margin: 5px 0; border: 1px solid rgb(0, 0, 0); cursor: pointer;">Abmelden</button></form>
        </th>
      </tr>
    </table>
  </div>
</head>

<body bgcolor="e2e2e2">