<!DOCTYPE html>
<?php

    require_once 'dbcon.inc.php';
    
    
    
    
    function getSelectFieldFromTable($defaultWert, $nameDesFeldes, $tableFuerErzeugung, $nameDerSpalteMitDerId, $nameDerSpalteMitDerBezeichnung) {
        global $con;
        
        $sql = '';
        $sql .= 'select '.$nameDerSpalteMitDerId.', '.$nameDerSpalteMitDerBezeichnung.' ';
        $sql .= 'from '.$tableFuerErzeugung ;
       
           
        $res = mysqli_query($con, $sql);
        
        $field = '';
        
        $field = '<select name ="'.$nameDesFeldes.'" size ="3" onchange="this.form.submit()">';
 
        $field .= '<option value="0"'.($defaultWert == 0 ? ' selected' : '').'>Alle</option>';
        
        while ($erg = mysqli_fetch_assoc($res)) {

            $field .= '<option value="'.$erg[$nameDerSpalteMitDerId].'"'.($defaultWert == $erg[$nameDerSpalteMitDerId] ? ' selected' : '').'>'.$erg[$nameDerSpalteMitDerBezeichnung].'</option>';

        }
        
        $field .= '</select>';
 
        return $field;
        
    }
    
    
    
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action='tableview.php' method='Post'>

            <?php
            
                $deftyp = isset($_POST['typ'])? $_POST['typ'] : 0;
                $defland = isset($_POST['land']) ? $_POST['land'] : 0;
                $defregion = isset($_POST['region']) ? $_POST['region'] : 0;
                $defweingut = isset($_POST['weingut']) ? $_POST['weingut'] : 0;
                
                echo getSelectFieldFromTable($deftyp, 'typ', 'typ', 'id_typ', 'name');
                //echo getSelectFieldFromTable($defland, 'land', 'laender', 'id_land', 'name');
                
                $sql = '';
                $sql .= 'select id_land, name from laender';

                $res = mysqli_query($con, $sql);

                $field = '';

                $field = '<select name ="land" size ="3" onchange="this.form.submit()">';

                $field .= '<option value="0"'.($defland == 0 ? ' selected' : '').'>Alle</option>';

                while ($erg = mysqli_fetch_assoc($res)) {

                    $field .= '<option value="'.$erg['id_land'].'"'.($defland == $erg['id_land'] ? ' selected' : '').'>'.$erg['name'].'</option>';

                }

                $field .= '</select>';
                
                echo $field;

                
                if ($defland != 0) {
                    
                    $sql = 'select id_region, r.name as name from regionen r join laender l on r.land_id = l.id_land where r.land_id = "'.$defland.'"' ;
                    
                    $res = mysqli_query($con, $sql);
                    
                    $field = '';

                    $field = '<select name ="region" size ="3" onchange="this.form.submit()">';

                    $field .= '<option value="0"'.($defregion == 0 ? ' selected' : '').'>Alle</option>';

                    while ($erg = mysqli_fetch_assoc($res)) {

                        $field .= '<option value="'.$erg['id_region'].'"'.($defregion == $erg['id_region'] ? ' selected' : '').'>'.$erg['name'].'</option>';

                    }

                    $field .= '</select>';
                    
                    echo $field;
                                        
                }
                
                if ($defregion != 0 and $defland != 0) {
                    
                    $sql = 'select w.id_weingut, w.name as name from regionen r join weingut w on w.region_id = r.id_region join laender l on l.id_land = r.land_id where r.land_id = "'.$defland.'" and w.region_id = "'.$defregion.'"';
                    
                    $res = mysqli_query($con, $sql);
                    
                    if (mysqli_affected_rows($con) > 0) {
                    
                        $field = '';

                        $field = '<select name ="weingut" size ="3" onchange="this.form.submit()">';

                        $field .= '<option value="0"'.($defregion == 0 ? ' selected' : '').'>Alle</option>';

                        while ($erg = mysqli_fetch_assoc($res)) {

                            $field .= '<option value="'.$erg['id_weingut'].'"'.($defweingut == $erg['id_weingut'] ? ' selected' : '').'>'.$erg['name'].'</option>';

                        }

                        $field .= '</select>';
                    
                        echo $field;
                    }
                    else {
                        $defregion = 0;
                    }                    

                    
                        
                    }
            ?>
            <input type="text" name="suchtext">
            <input type="submit" value="suchen">
        </form>
        
            <?php
                $sql = '';
                $sql .= 'select p.id_produkte as id_produkte, p.name as name, p.kurzbeschreibung as kurzbeschr, t.name as typ, l.name as land, r.name as region, w.name as weingut, p.volumen as volumen, p.preis as preis, p.beschreibung as beschreibung from produkte p join typ t on typ_id = id_typ join weingut w on weingut_id = id_weingut join regionen r on region_id = id_region join laender l on land_id = id_land ';
                
                if ($defland == 0) {
                    $defregion = 0;
                    $defweingut = 0;
                }
                
                if ($defregion == 0) {
                    $defweingut = 0;
                }
                
                $where_gesetzt = false;
                
                if ($deftyp+$defland+$defregion+$defweingut != 0) {
                    $sql .= 'where ';
                    $where_gesetzt = true;
                }
                    
                if ($deftyp != 0) {
                    $sql .= 't.id_typ = '.$deftyp.' ';
                    if ($defland+$defregion+$defweingut != 0) $sql .= 'AND ';
                }
                
                if ($defland != 0) {
                    $sql .= 'l.id_land = '.$defland.' ';
                    if ($defregion != 0) $sql .= 'AND ';
                }
                if ($defregion != 0) {
                    $sql .= 'r.id_region = '.$defregion.' ';
                    if ($defweingut != 0) $sql .= 'AND ';
                }
                
                if ($defweingut != 0) $sql .= 'w.id_weingut = '.$defweingut;
                
                if (isset($_POST['suchtext'])) {
                    if ($where_gesetzt == false)
                        $sql .= 'where ';
                    else
                        $sql .= ' and ';
                    
                $sql .= '(p.name like "%'.$_POST['suchtext'].'%" or p.kurzbeschreibung like "%'.$_POST['suchtext'].'%" or t.name like "%'.$_POST['suchtext'].'%" or l.name like "%'.$_POST['suchtext'].'%" or r.name like "%'.$_POST['suchtext'].'%" or w.name like "%'.$_POST['suchtext'].'%" or p.beschreibung like "%'.$_POST['suchtext'].'%")';
                }
                
                //echo $sql;
                
                $res = mysqli_query($con, $sql);
                
                echo '<table>';

                while ($erg = mysqli_fetch_assoc($res)) {
                    echo '<tr>';
                    echo '<td><a href="details.php?id='.$erg['id_produkte'].'">', $erg['name'], '</a></td>';
                    echo '<td>', $erg['kurzbeschr'], '</td>';
                    echo '<td>', $erg['typ'], '</td>';
                    echo '<td>', $erg['land'], '</td>';
                    echo '<td>', $erg['region'], '</td>';
                    echo '<td>', $erg['weingut'], '</td>';
                    echo '<td>', $erg['volumen'], '</td>';
                    echo '<td>', $erg['preis'], '</td>';
                    echo '<td><form action="inWarenkorb.php" method="post">';
                    echo '<input type="text" size="5" name="menge">';
                    echo '<input type="hidden" name="id_produkte" value="'.$erg['id_produkte'].'">';
                    echo '<input type="submit" value="in den Warenkorb">';
                    echo '</form></td>';
                            
                    echo '</tr>';

                }
                echo '</table>';
            ?>
            
        
            
            <?php
            // put your code here
            ?>

    </body>
</html>
