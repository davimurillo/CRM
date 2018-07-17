<?php 
$to="+584142456748@vtext.com";
$from="davimurillo@gmail.com";
$mensaje="hola mundo";
$headers="from: $from\n";
mail($to, '', $mensaje, $headers);
?>
