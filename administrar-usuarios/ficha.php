<?php

$relative = '..';
require '../includes/common.php';

$userStats = loadUser();
if ($userStats['user']->administrador == 0 ) {

	echo "Acceso restringido!";
	return;

}
// $cartItems = $userStats['cart'] ? obtenerPedido($userStats['cart']->id) : NULL;
$usuario = obtenerUsuarios(isset($_GET['id']) ? $_GET['id'] : null);
$appPlace = 'online-history';
$appSubPlace = 'administrar-usuarios';

startDocument();
loadSection("header", $userStats);

?>
