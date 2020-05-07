<?php
include 'includes/header.php';
?>


<h2 align="center">Befrager Startseite</h2>

<div> 
<!-- Select und echo erstellte Fragebögen vom angemeldeten Befrager -->
    <h3>Erstellte Fragebögen</h3>
    <?php
        $befrager=$_SESSION['session_bname'];
        //Template für prepared statement
        $sql= "SELECT titel FROM frageboegen WHERE Befrager=?;";
        // prepared statement erstellt
        $stmt= mysqli_stmt_init($conn);
        // prepared statement vorbereiten
        if (!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../Befrager.php?error=SQLBefehlFehler");
        }
        else{
            //Verknüpfung Parameter zu Placeholder
            mysqli_stmt_bind_param($stmt, "s", $befrager);
            //Parameter in DB verwenden
            mysqli_stmt_execute($stmt);
            //Daten/Ergebnis aus execute-Fkt in Variable verwenden
            $result= mysqli_stmt_get_result($stmt);
            //Ergebnis ausgeben
            while($row= mysqli_fetch_assoc($result)){
                echo $row['titel']."</br>";
            }
        }        
    ?>
                
</div>
<br/><br/><br/>

<div>

    <form method='post' action='AuswertungFragebogen.php'> 
        <input type= 'submit' name='auswerten' value='Fragebogen auswerten'/>
    </form> 
    <br/>
    <form method='post' action='FragebogenBearbeiten.php'> 
        <input type= 'submit' name='bearbeiten' value='Fragebogen bearbeiten'/>
    </form>
    <br/>
    <form method='post' action='FragebogenKopieren.php'> 
        <input type= 'submit' name='kopieren' value='Fragebogen kopieren'/>
    </form>
    <br/>
    <form method='post' action='FragebogenLoeschen.php'> 
        <input type= 'submit' name='loeschen' value='Fragebogen löschen'/>
    </form>
    <br/>
    <form method="post" action="FragebogenNeu.php"> 
        <input type= "submit" name="neu" value="Neuen Fragebogen anlegen"/>
     </form>
     <br/>
     <form method="post" action="Kurs.php"> 
        <input type= "submit" name="kurs" value="Neuen Kurs anlegen"/>
     </form>
     <br/>
     <form method="post" action="KursFragebogenZuordnen.php"> 
        <input type= "submit" name="kurs" value="Fragebogen Kursen zuordnen"/>
     </form>


  </div>


</body>
</html>