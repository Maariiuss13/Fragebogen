<!-- Autor: Lukas Ströbele -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anmeldung - Questionnaire</title>
    <link href="css/Startseitedesign.css" rel="stylesheet">
</head>

<body bgcolor="e2e2e2">

    <div align="center">
        <table>
            <tr>
                <th><img src="Fragen.jpg" width="100%" height="15%"></th>
            </tr>
        </table>
    </div>

    <div class="container">
        <h1 align="center"><b>Herzlich Willkommen bei Questionnaire!</b></h3>
            <p>Auf dieser Seite können Sie Online-Bewertungsumfragen konfigurieren, durchführen und auswerten.</p>
            <p style="line-height: 150%"><u>Dabei sind folgende Punkte zu beachten</u>:<br>
                a) Jeder Fragebogen erhält einen Titel, welcher nur <b>einmal</b> im System vorhanden sein darf.<br>
                b) Ein Fragebogen kann aus <b>beliebig vielen Fragen</b> bestehen.<br>
                c) Die Verwendung einzelner Fragen in mehreren Fragebögen ist aufgrund ungewünschter Nebeneffekte
                <b>nicht möglich</b>.<br>
                d) Jede Frage kann auf einer Bewertungsskala von 1 bis 5 beantwortet werden.<br>
                e) Bei erstellten Fragebögen können einzelne Fragen gelöscht beziehungsweise hinzugefügt werden.<br>
                f) Bereits erstellte Fragebögen können außerdem kopiert oder gelöscht werden.<br>
                g) Für die Durchführung von Befragungen sind <b>Studenten</b> verantwortlich. Die Befragungen finden
                immer <b>kursweise</b> statt.<br>
                h) Der Ersteller des Fragebogens kann diesen entsprechend für einzelne Kurse freischalten.</p>
    </div>
    <div>
        <table align="right" style="padding-top: 10px">
            <tr>
                <th align="center">
                    <form action="Befrageranmeldung.php"><input type="submit" style="padding: 10px" value="Anmeldung als Befrager"></form>
                </th>
                <th align="center">
                    <form action="Studentenanmeldung.php"><input type="submit" style="padding: 10px" value="Anmeldung als Student"></form>
                </th>
            </tr>
        </table>
    </div>

</body>

</html>