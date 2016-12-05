<?php
    require_once 'dbcon.inc.php';
    require_once 'loginfunctions.inc.php';
    
    session_start();
    
?>

<?php

/*
 * Abfrage, die alle Datensätze ermittelt, in denen der Username und gleichzeitig das Passwort aus dem per POST übermittelten Formular auftauchen.
 */
//    $sql = 'select kunden_id from benutzer where username = "'.$_POST['username'].'" AND passwort = "'.$_POST['passwort'].'"'; 
//    

/*
 * Schicke die Abfrage an die Datenbank. Zurück kommt ein Result-Set (alle betroffenen Tabellenzeilen)
 */
//   $res = mysqli_query($con, $sql);
//    

/*
 * Greife Dir den ersten Datensatz (die erste Zeile, also den ersten Datensatz, der die Bedingungen der SELECT-Anweisung erfüllt) aus dem Result-Set.
 */
//    $erg = mysqli_fetch_assoc($res);
//    

/*
 * In unserem Beispiel sollte es drei mögliche Szenarien geben:
 *      
 *      1. Wir finden keinen passenden Datensatz. Dann gibt es den User (die Kombination aus Namen und Passwort) nicht. Folglich ist kein Login möglich.
 * 
 *      2. Wir finden genau!!! einen passenden Datensatz. Grundlage hierfür ist, dass wir vorher ordentlich gearbeitet haben, und der Username wirklich eindeutig ist. 
 * 
 *      3. Wir finden mehrere passende Datensätze. Im Umkehrschluss zu 2. haben wir dann im Vorhinein irgendwo nicht sorgfältig genug gearbeitet.
 * 
 * Hier wird (erstmal) nicht weiter geprüft, ob es mehrere Treffer gibt, sondern einfach der erste Treffer verwendet. Kann man sicherlich schöner machen, aber es funktioniert erstmal.
 */

/*
 * $_Session ist ein globales, assoziatives Array, das durch session_start() erzeugt wird. Darin gespeichert sind neben der Session-ID diverse andere Informationen zur Session.
 * 
 * Bei globalen Arrays lassen sich (wie bei jedem anderen Array auch) Elemente anhängen. Dies machen wir uns zu Nutzen, indem wir dem Array den Schlüssel 'id_kunde' und den Wert 'kunden_id' anhängen, wenn es sich um einen bekannten (berechtigten) Nutzer handelt.
 * 
 * Wenn wir also mit mysql_fetch_assoc genau einen Datensatz gefunden haben, dann hängen wir dem berechtigten Nutzer seine id_kunden an die Session. Darüber wird im weiteren Verlauf von Seite zu Seite übergeben, dass es sich um einen berechtigten Nutzer handelt.
 * 
 * Zusätzlich werden über die id_kunden andere Dinge gesteuert. So wissen wir bspw. wenn ein Kunde Artikel in seinen Warenkorb legt, zu welchem Kunden der Warenkorb gehört.
 */

//    if ($erg['kunden_id'] != '') 
//        $_SESSION['id_kunde'] = $erg['kunden_id'];
//        
/* 
 * Einfach, genial, aber vermutlich nicht ganz einfach zu verstehen.
 * 
 * Egal, was vorher passiert ist, wir werfen den User einfach auf die index.php
 * 
 * Da die Prüflogik, ob ein User eingeloggt ist, oder ob nicht, in jeder einzelnen Seite liegt (jede einzelne Seite prüft, ob im $_SESSION-Array eine Kundennummer existiert), brauchen wir uns überhaupt keine Gedanken mehr zu machen.
 * 
 * War der User berechtigt (also der Login erfolgreich), hat er im $_SESSION-Array eine id_kunde hinterlegt, und ihm wird die index.php angezeigt. War der Login nicht erfolgreich, schickt die index.php den User automatisch (weil im $_SESSION-Array keine id_kunde existiert) wieder zum Anmeldeformular.
 */
//    header('Location: index.php');


/*
 * Der Rest ist nur noch eine Variante, die zeigen sollte, was man über das $_SESSION-Array noch erreichen kann: Persönliche Ansprache des Benutzers. Im Grunde ist das aber nur ein wenig mehr Spielerei als in der obigen Basis-Version.
*/
    $sql = 'select username, kunden_id, nachname, anrede from benutzer join kunde on id_kunde = kunden_id where username = "'.$_POST['username'].'" AND passwort = "'.$_POST['passwort'].'"';

    $res = mysqli_query($con, $sql);
    
    $erg = mysqli_fetch_assoc($res);
    
    if ($erg['username'] != '') {
        $_SESSION['id_kunde'] = $erg['kunden_id'];
        $_SESSION['nachname'] = $erg['nachname']; // hier nur noch als Spielerei für persönliche Begrüßung
        $_SESSION['anrede'] = $erg['anrede']; // hier nur noch als Spielerei für persönliche Begrüßung
    }
    
    header('Location: index.php');
    
?>

