<?php

$relative = '../../..';
require '../../../includes/common.php';
header('Content-type: application/json');

echo JSON_encode(eliminarDelPedido($_GET['id_pedido'], $_GET['ida'], $_GET['idp'], $_GET['precioitem'], $_GET['cantidaditem'], $_GET['totalpedido'], $_GET['totalitems']));

?>