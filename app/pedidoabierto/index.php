<?php

$relative = '../..';
require '../../includes/common.php';
header('Content-type: application/json');

echo JSON_encode(obtenerPedidoAbierto());

?>