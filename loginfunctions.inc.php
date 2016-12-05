<?php

    function isLoggedIn() {
        if (isset($_SESSION['id_kunde'])) {
            return true;
        }
        else {
            return false;
        }
                
    }
    
    
?>
