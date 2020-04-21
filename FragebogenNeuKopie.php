<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>neuer Fragebogen</title>
</head>

<body bgcolor="e2e2e2">
  
  <div align="center">
    <table>
        <tr>
            <th><img src="Fragen.jpg" width="100%" height="15%"></th>
        </tr>
    </table>
</div>

  <h2 align="center">Neuer Fragebogen</h2>

  <form action="Befrager.php" method="post">
        <div>
            <label for="titelFragebogen"><b>Titel Fragebogen</b></label>
            <input type="text" placeholder="Titel" name="titelFragebogen" required>
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
            <form method="post"> 
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