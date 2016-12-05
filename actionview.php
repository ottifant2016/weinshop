<!DOCTYPE html>
<?php

    require_once 'dbcon.inc.php';
    
?>
    
    
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        <h1>Angebote</h1>
        <?php
            $sql = 'select p.id_produkte, p.name as name, p.kurzbeschreibung as kurzbeschr, t.name as typ, l.name as land, r.name as region, w.name as weingut, p.volumen as volumen, p.preis as preis, p.beschreibung as beschreibung from produkte p join typ t on typ_id = id_typ join weingut w on weingut_id = id_weingut join regionen r on region_id = id_region join laender l on land_id = id_land where angebot != "0"';

            $res = mysqli_query($con, $sql);

            while ($erg = mysqli_fetch_assoc($res)) {
                echo '<p>', $erg['name'], '</p>';
                echo '<p>', $erg['kurzbeschr'], '</p>';
                echo '<p>', $erg['typ'], '</p>';
                echo '<p>', $erg['land'], '</p>';
                echo '<p>', $erg['region'], '</p>';
                echo '<p>', $erg['weingut'], '</p>';
                echo '<p>', $erg['volumen'], '</p>';
                echo '<p>', $erg['preis'], '</p>';
                echo '<p>', $erg['beschreibung'], '</p>';
                echo '<img src="images/weinbilder/mittel/blank.jpg" alt="blank">';
            }
        ?>
    </body>
</html>
