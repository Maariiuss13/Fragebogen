<?php 
include 'includes/header.php';
?>
<link href = 'Fragenseitendesign.css' rel = 'stylesheet'>


<section class = 'welcome'>
    <h1>Willkommen auf der Fragenseite!</h1>
    <p>Hier können Sie nacheinander die gewünschten Fragen zu Ihrem Fragebogen eintragen</p>
    </br>
    <p>
        <?php
            echo "<p> Ersteller: ".$_SESSION['session_bname']."</p><br/>";
            echo "<p> Fragebogen: ".$_SESSION["aktFB"]."</p><br/>";
        ?>
    </p>
</section>

<section class = 'questions'>
    <p>Frage: <?php echo $_SESSION["aktSeite"] ?> von <?php echo $_SESSION["anzFragen"] ?></p>
    </br>
    <form action="includes/dbInsertFragen.php" method="POST">
        <input class = 'def' type = 'text' placeholder="Frage eintragen" name="frage">
        </br>
        </br>
        <!-- Zurück Button hier nicht benötigt
        <input type="submit" value="Zurück" name="Bzurück"
            <?php
                //Deaktivieren Button auf Seite 1 
                if($_SESSION["aktSeite"]<=1){
                    echo "disabled";    
                }
            ?>
        />
         -->
        <input type="submit" value="Weiter" name="Bweiter" style="float: right;"
            <?php
                //Deaktivieren Button, wenn akt. Seite = Gesamtanzahl Seiten
                if($_SESSION["aktSeite"]>=$_SESSION["anzFragen"]){
                    echo "disabled";        
                }
            ?>
         />
        </br>
        </br>
        <input type="submit" value="Abschließen" name="Babschluss" style="float: right;"
            <?php
                //Button solange aktiviert, wie akt. Seite != Gesamtanzahl Seiten
                if($_SESSION["aktSeite"]!=$_SESSION["anzFragen"]){
                    echo "disabled";   
                }
            ?>
        />
    </form>


</section>

</body>
</html>
