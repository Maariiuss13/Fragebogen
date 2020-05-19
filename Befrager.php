<?php
include 'includes/header.php';
include 'includes/functions.php';
?>


<h2 align="center">Befrager Startseite</h2>

<div> 
<!-- Select und echo erstellte Fragebogen vom angemeldeten Befrager -->
    <h3>Erstellte Fragebögen</h3>
    <?php
        $befrager=$_SESSION['session_bname'];
        //Template für prepared statement
        $sql= "SELECT titel FROM frageboegen WHERE Befrager=?;";
        //Ausgabe Fragebogen Befrager
        echoFbBefrager ($conn, $sql, $befrager);        
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