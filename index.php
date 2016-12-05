<?php
    /*
     * Die dbcon muss hier nicht zwangsläufig eingebunden werden. Da dieser 'Pre-Head' als Grundgerüst für jede neue PHP-Datei des Projektes gedacht ist, steht sie trotzdem drin.
     */
    session_start(); // Start der Session. Oder falls schon eine Sesson existiert: Übertragung der Session auf die zusätzliche Seite.
    
    require_once 'dbcon.inc.php';
    require_once 'loginfunctions.inc.php';

    /*
     * Funktion isLoggedIn (abgelegt in Datei loginfunctions.inc.php). Prinzipiell könnte die Funktion auch Fritzchen heißen, es macht aber Sinn, sich an der allgemeinen Namensgebung zu orientieren. Und Funktionen, die etwas prüfen, bestehen halt in PHP immer aus is+Prüfung (isNumeric, isString, ...)
     */
    
    if (!isLoggedIn()) { 
        header('Location: login.html');
    }
    
?>

<?php
    echo '<p>Hallo ', $_SESSION['anrede'], ' ', $_SESSION['nachname'], '</p>'; 
    
?>    

<a href ="dieseite42.php">Zur Antwort auf alle Fragen</a>

<a href="logout.php">Logout</a>
    
