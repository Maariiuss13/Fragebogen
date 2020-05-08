<?php 
include 'includes/header.php';
?>
<link href = 'Fragenseitendesign.css' rel = 'stylesheet'>

<?php
//Test Erstaufruf Seite
if ((!isset($_POST["Bzurück"])) && 
    (!isset($_POST["Bweiter"]))){
       $_SESSION["aktSeite"] = 1;
       $_SESSION["anzSeiten"] = 5;
}

//Test Button Weiter gedrückt
if (isset($_POST["Bweiter"])){
       $_SESSION["aktSeite"] ++;
}

//Test Button Zurück gedrückt
if (isset($_POST["Bzurück"])){
       $_SESSION["aktSeite"]--;
}

?>

<section class = 'welcome'>
    <h1>Willkommen auf der Fragenseite!</h1>
    <p>Hier können Sie nacheinander die gewünschten Fragen zu Ihrem Fragebogen eintragen</p>
</section>

<section class = 'questions'>
    <p>Frage: <?php echo $_SESSION["aktSeite"] ?> von <?php echo $_SESSION["anzSeiten"] ?></p>
    </br>
    <form action="FragenseitenNeu.php" method="POST">
        <input class = 'def' type = 'text' value = '' placeholder="Frage eintragen">
        </br>
        </br>
        <input type="submit" value="Zurück" name="Bzurück"
            <?php
                //Deaktivieren Button auf Seite 1 
                if($_SESSION["aktSeite"]<=1){
                    echo "disabled";    
                }
            ?>
        />
        <input type="submit" value="Weiter" name="Bweiter" style="float: right;"
            <?php
                //Deaktivieren Button, wenn akt. Seite = Gesamtanzahl Seiten
                if($_SESSION["aktSeite"]>=$_SESSION["anzSeiten"]){
                    echo "disabled";        
                }
            ?>
         />
        </br>
        </br>
        <input type="submit" value="Abschließen" name="Babschluss" style="float: right;"
            <?php
                //Deaktivieren Button, wenn akt. Seite = Gesamtanzahl Seiten
                if($_SESSION["aktSeite"]!=$_SESSION["anzSeiten"]){
                    echo "disabled";   
                }
            ?>
        />
    </form>


</section>

<script src = './Fragenseite.index.js'></script>
</body>
</html>
