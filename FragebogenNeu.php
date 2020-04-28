<!DOCTYPE html>
<?php
include 'includes/header.php';
?>

  <h2 align="center">Neuer Fragebogen</h2>

  <form action="http://vorlesungen.kirchbergnet.de/inhalte/DB-PR/output_posted_vars.php" method="post">
        <div>
            <label for="titelFragebogen"><b>Titel Fragebogen</b></label>
            <input type="text" placeholder="Titel" name="titelFragebogen" required>
            <br/>
            <label for="beschreibungFB"><b>Beschreibung Fragebogen</b></label>
            <input type="text" placeholder="Beschreibung" name="beschreibungFB" required>
            <br/>
            <!-- Befrager soll raus und durch Session-Variable ersetzt werden  includes/dbInsertFragebogen.php-->
            <?php
            $befrager=$_SESSION['session_bname'];
            echo "<label for='nameBefrager'><b>Name Befrager</b></label>
                  <p>".$befrager."</p>";
            ?>
            <br/>
            <label for="anzahlFragen"><b>Anzahl Fragen</b></label>
            <input type="number" value="0" name="anzahlFragen" required>
        </div>
        <br/> <br/> <br/>
        <div> 
            <h3>Fragen erfassen</h3>
            <table>
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
                            <input type="text" name="beschreibungF" size="50" required/>
                        </form>
                    </td>
                </tr>
            </table>
            <br/>
            <form action="FragebogenNeuKopie.php" method="post"> 
                <input type="submit" name="addFrage" value="Frage hinzufügen"/>
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
                <tr> 
                    <td> 
                        <form> 
                            <select name="kurse" size="1" required>
                                <option>WWI318</option>
                                <option>WWI218</option>
                                <option>WWI118</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form> 
                            <input type="text" name="kursBeschreibung" size="50"/>
                        </form>
                    </td>
                </tr>
            </table>
            <br/>
            <form method="post"> 
                <input type="submit" name="addKurs" value="Kurs hinzufügen"/>
            </form>
        </div>
        <br/> <br/>
        <div> 
            <input type="submit" name="speichernFragebogen" value="Bearbeitung beenden und speichern">
        </div>
    </form>


</body>
</html>