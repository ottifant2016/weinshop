<?php
require_once 'biblio_weinshop.inc.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>Weinhandel</title>
<meta charset="utf-8">
<link rel="stylesheet" href="styles/styles.css" media="screen">
<link href="styles/warenkorb.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    
<div id="wrapper">
    <div id="header">
        <img src="images/in_vino_veritas.png" alt="In Vino Veritas">
    </div>
    <div id="navi">
        <ul>
            <li><a href="#">Link 1</a></li>
            <li><a href="#">Link 2</a></li>
            <li><a href="#">Link 3</a></li>
            <li><a href="#">Link 4</a></li>
        </ul>
    </div>
    <div id="main">
        <h1>Warenkorb</h1>
        <form action="menge_aendern.php" method="post">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Typ</th>
                    <th>Land</th>
                    <th>Region</th>
                    <th>Weingut</th>
                    <th>Volumen</th>
                    <th>Menge</th>
                    <th>Preis</th>
                    <th>Gesamt Preis</th>
                    <th>Menge ändern</th>
                    <th>Artikel entfernen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $table = warenkorb_anzeigen(56); //SESSION KUNDEN NUMMER ID!!!
                echo $table;
                ?>
            </tbody>
        </table>
        </form>

        <a class="button" href="warenkorb_leeren_gesamt.php">Warenkorb leeren</a>
        <a class="button" href="warenkorb_speichern.php">Warenkorb bestellen</a>
    </div>
    <div id="footer">Fußzeile</div>
</div>
    
    
</body>
</html>
