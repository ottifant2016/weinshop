<?php
require_once 'biblio_weinshop.inc.php';
foreach ($_POST as $key => $value) {
    menge_aendern(56, $key, $value);
}
header('Location:warenkorb.php');
