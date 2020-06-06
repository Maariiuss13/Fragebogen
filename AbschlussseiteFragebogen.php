<?php include 'includes/header.php';
include 'includes/functions.php';
?>
<?php
$mnr = $_SESSION['session_mnr'];
$FbTitel = $_SESSION["titelFB"];
?>


<link href="Abschlussseitedesign.css" rel="stylesheet">

<section class="abschluss">
    <h1>Vielen Dank für den Abschluss des Fragebogens</h1>
    <?php
    echo "<p> Student: " . $_SESSION['session_mnr'] . "</p><br/>";
    echo "<p> Fragebogen: " . $_SESSION["titelFB"] . "</p><br/>";
    ?>
</section>

<section class="kommentar">
    <p>Wenn Sie noch Anmerkungen haben, können Sie diese hier einfügen:</p>

    <form action="includes/dbInsertKommentar.php" method="POST">
        <label for="text">Kommentar:</label><br />
        <textarea id="text" name="text" cols="35" rows="4"></textarea><br />

        <input type="submit" value="Speichern" name="Speichern" />
    </form>

    <form action="Studenten.php">
        <input type="submit" value="Zurück zur Startseite" name="Studentenseite">
    </form>


</section>

</body>

</html>