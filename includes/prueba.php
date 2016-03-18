<?php

// echo "probando algo";

$lodelospacks = "pack x 158";
$cambiado = str_replace(array("pack x","X","packs x","Packs X","PACKS X"), "", $lodelospacks);
echo $cambiado;

?>