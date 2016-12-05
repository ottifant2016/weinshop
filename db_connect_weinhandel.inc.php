<!-- author: Aurelia-Lucilla -->
<?php

$server = '192.168.14.51';
        $user = 'root';
        $password = '';

        
        $con = @mysqli_connect($server,$user,$password);      
        mysqli_set_charset($con, 'utf8');

           
        mysqli_select_db($con, 'gruppe4');
?>

