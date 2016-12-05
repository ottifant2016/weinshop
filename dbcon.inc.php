<?php

function dbconnect() {
    $con = mysqli_connect('192.168.14.51', 'root', '');
    mysqli_set_charset($con, 'utf8');

    $db = mysqli_select_db($con, 'gruppe4');
}

function dbclose() {
    mysqli_close($con);
}
        

