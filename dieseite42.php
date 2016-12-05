<?php
    session_start();
    
    require_once 'dbcon.inc.php';
    require_once 'loginfunctions.inc.php';

    if (!isLoggedIn()) {
        header('Location: login.html');
    }
    
?>

<?php
    echo '<p>Hallo ', $_SESSION['anrede'], ' ', $_SESSION['nachname'], '</p>'; 
    
?>    

<p>Die Antwort auf alle Fragen lautet: <b>42</b>
    
<a href ="index.php">Zurück zur Startseite</a>

<a href="logout.php">Logout</a>