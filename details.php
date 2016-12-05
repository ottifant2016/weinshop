<!DOCTYPE html>
<?php

    
    require_once './biblio_weinshop.inc.php'; //TEST mit lokaler Datenbank
    $con = db_connection();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Detailansicht</h1>
        <?php
        
            $sql = 'select p.id_produkte, p.name as name, p.kurzbeschreibung as kurzbeschr, '
                    . 't.name as typ, l.name as land, r.name as region, '
                    . 'w.name as weingut, p.volumen as volumen, '
                    . 'p.preis as preis, p.beschreibung as beschreibung '
                    . 'from produkte p '
                    . 'join typ t on typ_id = id_typ '
                    . 'join weingut w on weingut_id = id_weingut '
                    . 'join regionen r on region_id = id_region '
                    . 'join laender l on land_id = id_land where '
                    . 'p.id_produkte = '.$_GET['id'];
            
            $res = mysqli_query($con, $sql);
            
            $erg = mysqli_fetch_assoc($res);
            
            echo $erg['name'], '<br>';
            echo $erg['kurzbeschr'], '<br>';
            echo $erg['typ'], '<br>';
            echo $erg['land'], '<br>';
            echo $erg['region'], '<br>';
            echo $erg['weingut'], '<br>';
            echo $erg['volumen'], '<br>';
            echo $erg['preis'], '<br>';
            echo $erg['beschreibung'], '<br>';
            //echo '<img src="weinbilder/gross/'.$_GET['id'].'.png" alt="'.$_GET['id'].'">';
            echo '<img src="images/weinbilder/gross/blank.jpg">';
        ?>
    </body>
</html>
