<?php
include 'includes/header.php';
?>


<h2 align="center">Befrager Startseite</h2>

<div> 
    <table>
        <tr>
            <th> Titel </th>
            </tr>
                <!-- Select und echo erstellte Fragebögen vom angemeldeten Befrager -->
                <?php
                    include 'includes/dbHandler.php';
                    //Variable $_SESSION['session_bname'] einfügen
                    $sqlBefrager= "SELECT titel FROM frageboegen WHERE befrager='Daniel';";
                    $resultBefragerFB = mysqli_query($conn, $sqlBefrager);

                    while($row = mysqli_fetch_assoc($resultBefragerFB)){
                    echo "<tr><td>".$row['titel']."</td><tr>";
                    }

                    echo "</table>";
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