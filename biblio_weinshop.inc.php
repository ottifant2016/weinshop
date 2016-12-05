<?php
/**
 * Herstellen und Auswahl der Datenbank
 * @return Link zur Datenbank
 */
function db_connection() {
    $con = mysqli_connect('localhost', 'root', '');
    mysqli_set_charset($con, 'utf8');
    mysqli_select_db($con, 'weinhandel'); // Muss noch geändert werden !!!!
    return $con;
}
/**
 * Schließen der Datenbankverbindung
 * @param type $con Link zur Datenbank
 */
function db_close($con) {
    mysqli_close($con);
}
/**
 * Prüfen und ggf. anlegen eines Warenkorbes
 * @param type $kunde_id über Session
 * @return Warenkorb ID
 */
function pruefen_warenkorb($kunde_id) {
    $con = db_connection();
    $sql_select = "SELECT id_bestellung FROM bestellungen WHERE kunde_id =".$kunde_id." AND status LIKE 'Warenkorb';";
    $res = mysqli_query($con, $sql_select);    
    if (mysqli_affected_rows($con) == 0){
        $sql = "INSERT INTO bestellungen (kunde_id) VALUES (".$kunde_id.");";
        mysqli_query($con, $sql);
        $warenkorb_id = mysqli_insert_id($con);
    }
    else {
        $temp = mysqli_fetch_row($res);
        $warenkorb_id = $temp[0];
    }
    db_close($con);
    return $warenkorb_id;
}

/**
 * Produkt mit entsprechender Warenkorb ID in Warenkporb legen
 * @param type $id_produkt
 * @param type $kunde_id
 * @param type $menge
 * @param type $preis
 */
function produkt_warenkorb_legen($id_produkt,$kunde_id,$menge, $preis) {
    $con = db_connection();
    $warenkorb_id = pruefen_warenkorb($kunde_id);    
    $sql = "INSERT INTO bestellpositionen "
            . "(bestellungen_id,produkt_id, menge, preis) "
            . "VALUES (".$warenkorb_id.",".$id_produkt.",".$menge.",".$preis.");";
    mysqli_query($con, $sql);
    db_close($con);
}
/**
 * Ausgabe des Warenkorbes in einer Tabelle
 * @param type $kunde_id
 */
function warenkorb_anzeigen($kunde_id) {
    $con = db_connection();
    $sql = "SELECT p.id_produkte, p.name, t.name AS typ,l.name AS land,r.name AS region, "
            . "w.name AS weingut ,p.volumen,bp.menge, bp.preis, "
            . "(bp.menge * bp.preis) AS gesamt "
            . "FROM produkte p JOIN typ t ON p.typ_id = t.id_typ "
            . "JOIN weingut w ON p.weingut_id = w.id_weingut "
            . "JOIN regionen r ON w.region_id = r.id_region "
            . "JOIN laender l ON r.land_id = l.id_land "
            . "JOIN bestellpositionen bp ON p.id_produkte = bp.produkt_id "
            . "JOIN bestellungen b ON bp.bestellungen_id = b.id_bestellung "
            . "WHERE b.kunde_id = ".$kunde_id." AND bp.menge > 0 "
            . "AND b.Status LIKE 'Warenkorb';";
    $res = mysqli_query($con, $sql);
    $table = tabelle_warenkorb($res, $kunde_id);
    db_close($con);
    return $table;
}
function tabelle_warenkorb($res, $kunde_id) {
    $table = "";
    while ($row = mysqli_fetch_assoc($res)) {
        $table .= "<tr><td><a href=#>".$row['name']."</a></td>"
        ."<td>".$row['typ']."</td>"
        ."<td>".$row['land']."</td>"
        ."<td>".$row['region']."</td>"
        ."<td>".$row['weingut']."</td>"
        ."<td>".$row['volumen']."</td>"
        .'<td><input class="menge" type="number" name="menge'.$row['id_produkte'].'" min="0" step="1" value="'.$row['menge'].'"></td>'
        ."<td>".$row['preis']."</td>"
        ."<td>".$row['gesamt']."</td>"
        .'<td><a href=artikel_aendern.php?id='.$row['id_produkte'].'>ändern</a></td>'
        .'<td><a href=artikel_entfernen.php?id='.$row['id_produkte'].'>löschen</a></td></tr>';
    }
    $summe = gesamt_preis($kunde_id);
    $table .= '<tr> <td>'.$summe.'</td></tr>';
    return $table;    
}

function warenkorb_leeren_einzeln($produkt_id,$kunde_id) {
    $con = db_connection();
    $sql = 'UPDATE bestellpositionen bp, bestellungen b '
            . 'SET bp.menge = 0 '
            . 'WHERE b.id_bestellung = bp.bestellungen_id AND '
            . 'b.kunde_id = '.$kunde_id.' AND b.`Status` LIKE "Warenkorb" AND '
            . 'bp.produkt_id = '.$produkt_id.';';
    mysqli_query($con, $sql);
    db_close($con);    
}

function warenkorb_leeren_gesamt($kunde_id){
    $con = db_connection();
    $sql = 'UPDATE bestellpositionen bp, bestellungen b '
            . 'SET bp.menge = 0 '
            . 'WHERE b.id_bestellung = bp.bestellungen_id AND '
            . 'b.kunde_id = '.$kunde_id.' AND b.`Status` LIKE "Warenkorb";';
    mysqli_query($con, $sql);
    db_close($con);
}

function warenkorb_speichern($kunde_id) {
    $con = db_connection();
    $sql = 'UPDATE bestellungen SET status = "bestellt" WHERE kunde_id = '.$kunde_id.';';
    mysqli_query($con, $sql);
    db_close($con);
}

function gesamt_preis($kunde_id) {
    $con = db_connection();
    $sql = 'SELECT SUM(bp.preis*bp.menge) FROM bestellpositionen bp '
            . 'JOIN bestellungen b ON bp.bestellungen_id = b.id_bestellung '
            . 'WHERE b.`Status` LIKE "Warenkorb" AND b.kunde_id = '.$kunde_id.';';
    $res = mysqli_query($con, $sql);
    $temp = mysqli_fetch_row($res);
    $summe = $temp[0];
    db_close($con);
    return $summe;
}