<?php

$relative = '../../..';
require '../../../includes/common.php';
header('Content-type: application/json');

echo JSON_encode(agregarAlPedido($_GET['id'], $_GET['c'], $_GET['p'], $_GET['t'], $_GET['color']));

?>