<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title></title>
</head>
<body align="left">
    <table border="1px solid" border-radius:30px;" cellspacing="0" cellpadding="10px" width="600" style="margin-left: auto; margin-right: auto; height:auto; background-color: #ffffff; margin-top: 60px;">
        <tr>
            <td style="border: 1px solid; color:white;background-color: rgb(22,104,142); height: 20px; text-align: center; padding: 10px;"><h1>AVIS IMPORTANT</h1></td>
        </tr>
        <tr>
            <td style="background-color: rgb(22,104,142);">
                <table  style="border: 0; width:100%; cellspacing: 0; cellpadding: 10px; height: auto;background-color: white;margin-left: auto; margin-right: auto;">
			<tr align = "center">
			<td valign="baseline" style="padding: 10px; border: 1px solid;">
				<h2>Rappel de participation à un atelier</h2>
				<label>Date : {{$atelier->DateAtelier}}</label>
				<br>
				<br>
				<label>Nom de l'atelier : {{$atelier->Nom}} </label>
				<br>
                                <br>
				<label>Campus : {{$campus->Nom}} </label>
				<br>
                                <br>
				<label>Local : {{$atelier->Endroit}} </label>
				<br>
                                <br>
				<label>Heure de début : {{$atelier->HeureDebut}} </label>
				<br>
                                <br>
				<label>Durée : {{$atelier->Duree}}</label>
                <br>
                <br>
                <label>Date : {{$atelier->DateAtelier}}</label>
			</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td cellpadding="10px" style="border: 1px solid; color:white; background-color: rgb(22,104,142);cellspacing: 0;  width: 100%; height: auto; text-align: center;">
                <strong>© <?php echo date("Y"); ?> ScripTech – Tous droits réservés</strong>
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid;background-color: rgb(22,104,142); color:white; cellspacing: 0; cellpadding: 10px; width: 100%; height: auto">
                <center>
                    <a href="mailto:scriptech.team@gmail.com" style="color:white">Nous contacter</a>
                </center>
            </td>
        </tr>
    </table>
</body>
</html>