<?php
$enlace = pg_connect('dbname=apiceslcd host=localhost port=5432 user=root password=usbw' );
$resultado =  pg_query($enlace,$consultaSQL) or die(""); 

?>