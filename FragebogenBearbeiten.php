<!DOCTYPE html>
<?php
include 'includes/header.php';
?>
  

  <h2 align="center">Fragebogen bearbeiten</h2>
  <script type="text/javascript" src="addField.js"></script>

  
  <form action="Befrager.php" method="post">
        <div>
            <label for="titelFragebogen"><b>Titel Fragebogen</b></label>
            <input type="text" placeholder="Titel" name="titelFragebogen" readonly>
            <br/>
            <label for="anzahlFragen"><b>Anzahl Fragen</b></label>
            <input type="number" value="0" name="anzahlFragen" readonly>
        </div>
        <br/> <br/> <br/>
        <div> 
            <h3>Fragen erfassen</h3>
            <table id="frage">
                <tr> 
                    <th>Nr.</th>
                    <th> Beschreibung </th>
                </tr>
                <tr> 
                    <td> 
                        <form> 
                            <input type="text" name="frageNr" size="1" value="1" readonly/>
                        </form>
                    </td>
                    <td>
                        <form> 
                            <input type="text" name="beschreibungF" size="50" readonly/>
                        </form>
                    </td>
                    <td> 
                      <form method="post" action="FragebogenBearbeiten.php"> 
                        <input type= "submit" name="loeschen" value="Löschen"/>
                    </form>
                  </td>
                </tr>
            </table>
            <br/>
            <form method="post"> 
                <input type="button" name="addFrage" onclick="add_Frage();" value="Frage hinzufügen"/>
            </form>
        </div>
        <br/> <br/>
        <div>
            <h3>Fragebogen für folgende Kurse freischalten:</h3>
            <table>
                <tr> 
                    <th>Kürzel</th>
                    <th> Beschreibung </th>
                </tr>
                <tr id="kurs"> 
                    <td> 
                        <form> 
                            <select name="kurse" size="1" readonly>
                                <option>WWI318</option>
                                <option>WWI218</option>
                                <option>WWI118</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form> 
                            <input type="text" name="kursBeschreibung" size="50" readonly/>
                        </form>
                    </td>
                </tr>
            </table>
            <br/>
            <form method="post"> 
                <input type="button" name="addKurs" onclick="add_kurs();" value="Kurs hinzufügen"/>
            </form>
        </div>
        <br/> <br/>
        <div> 
            <input type="submit" name="speichernFragebogen" value="Bearbeitung beenden und Änderungen Fragebogen speichern">
        </div>
    </form>

</body>
</html>