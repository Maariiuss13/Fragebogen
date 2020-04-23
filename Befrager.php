<!DOCTYPE html>
<?php
include 'includes/header.php';
?>


  <h2 align="center">Befrager Startseite</h2>

  <div> 
      <table> 
          <tr>
              <th> Titel </th>
          </tr>
          <tr>
              <td> Daten  SQL </td>
              <td> 
                  <form method="post" action="AuswertungFragebogen.php"> 
                      <input type= "submit" name="auswerten" value="Auswerten"/>
                  </form>
              </td>
              <td> 
                  <form method="post" action="FragebogenBearbeiten.php"> 
                      <input type= "submit" name="bearbeiten" value="Bearbeiten"/>
                  </form>
              </td>
              <td> 
                  <form method="post" action="FragebogenNeuKopie.php"> 
                      <input type= "submit" name="kopieren" value="Kopieren"/>
                  </form>
              </td>
              <td> 
                  <form method="post" action="Befrager.php"> 
                      <input type= "submit" name="loeschen" value="Löschen"/>
                  </form>
              </td>
          </tr>
      </table>
  </div>
  <br/><br/><br/>
  <div> 
    <form method="post" action="FragebogenNeuKopie.php"> 
        <input type= "submit" name="neu" value="Neuen Fragebogen anlegen"/>
     </form>
     <br/>
     <form method="post" action="Kurs.php"> 
        <input type= "submit" name="kurs" value="Neuen Kurs anlegen"/>
     </form>
     <br/>
     <form method="post" action="Startseite.html"> 
        <input type= "submit" name="abmelden" value="Abmelden"/>
     </form>

  </div>

  

</body>
</html>