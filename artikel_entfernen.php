<?php
require_once 'biblio_weinshop.inc.php';

if (isset ($_GET['id'])){
    warenkorb_leeren_einzeln($_GET['id'], 56);
    header('Location: warenkorb.php');
}
 else {
    header('Location: index.html');
}



