<?php

define('DB_SERVER', 'den1.mysql2.gear.host');
define('DB_USERNAME', 'herbario');
define('DB_PASSWORD', 'Informatica1*');
define('DB_NAME', 'herbario');
 

$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}