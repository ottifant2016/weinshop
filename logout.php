<?php
    require_once 'dbcon.inc.php';
    require_once 'loginfunctions.inc.php';
    
    session_start();
    
    if (!isLoggedIn()) {
        header('login.html');
    }
?>

<?php
    
    session_destroy();
    
?>

<p>Du wurdest erfolgreich ausgeloggt</p>

<a href ="index.php">Zurück zur Startseite</a>
