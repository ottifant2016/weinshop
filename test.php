<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Type Title Here</title>
    </head>
    <body>
        <?php
require_once './biblio_weinshop.inc.php';
produkt_warenkorb_legen(79, 2, 1, 21);
produkt_warenkorb_legen(2, 2, 7, 13);
produkt_warenkorb_legen(3, 2, 2, 48);
produkt_warenkorb_legen(42, 2, 10, 98);
produkt_warenkorb_legen(71, 2, 1, 71);
header('Location:warenkorb.php');   
?>
    </body>
</html>
