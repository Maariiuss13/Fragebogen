<!-- Autor: Lukas Ströbele -->
<?php
// Aktiviert eine Session
session_start();
// Löscht alle Werte in den Sessionvariablen 
session_unset();
// Beendet alle Sessions, die auf der aktuellen Webseite ausgeführt werden
session_destroy();
header("Location: ../Startseite.php");
