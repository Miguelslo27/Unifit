<?php

$relative = '..';
require '../includes/common.php';

$userStats = loadUser();
if ($userStats['user']->administrador == 0 ) {

	echo "Acceso restringido!";
	return;

}
// $cartItems = $userStats['cart'] ? obtenerPedido($userStats['cart']->id) : NULL;
$todasLosUsuarios = obtenerUsuarios(isset($_GET['id']) ? $_GET['id'] : null);
$appPlace = 'online-history';
$appSubPlace = 'administrar-usuarios';

startDocument();
loadSection("header", $userStats);

?>

	<div class="body">
		<div class="body-inner">
			<div class="body-content">
				<h1>Administración de Usuarios</h1>
				<span class="line-h"></span>
				<br>
				<a href="descargar-csv.php" class="btn btn-small black"><span class="fa fa-table" style="position: relative; margin-right: 10px; top: 0.5px;"></span>Descargar lista completa en CSV</a>
				<br>
				<br>
				<table cellspacing="0" cellpadding="0">
					<thead>
						<tr>
							<td style="width: 15%">Nombre</td>
							<td style="width: 15%">RUT</td>
							<td style="width: 15%">E-Mail</td>
							<td style="width: 20%">Dirección</td>
							<td style="width: 10%">Teléfonos</td>
							<td style="width: 25%">Ubicación</td>
						</tr>
					</thead>
					<tbody>
						<?php

						foreach($todasLosUsuarios as $usuario) {

						?>

						<tr>
							<td style="border-top: 1px solid; border-left: 1px solid;"><?php echo $usuario->nombre . ' ' . $usuario->apellido; ?></td>
							<td style="border-top: 1px solid;"><?php echo $usuario->rut; ?></td>
							<td style="border-top: 1px solid;"><?php echo $usuario->email; ?></td>
							<td style="border-top: 1px solid;"><?php echo $usuario->direccion; ?></td>
							<td style="border-top: 1px solid;"><?php echo $usuario->telefono; ?><br><?php echo $usuario->celular; ?></td>
							<td style="border-top: 1px solid; border-right: 1px solid;"><?php echo $usuario->ciudad; ?>, <?php echo $usuario->departamento; ?></td>
						</tr>
						<tr>
							<td colspan="6" style="border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">
								<a href="ficha.php?id=<?php echo $usuario->id; ?>" class="btn btn-small black"><span class="fa fa-file-text-o" style="position: relative; margin-right: 10px; top: 0.5px;"></span>Ver ficha</a>
								<a href="descargar-pdf.php?id=<?php echo $usuario->id; ?>" class="btn btn-small black"><span class="fa fa-download" style="position: relative; margin-right: 10px; top: 0.5px;"></span>Descargar ficha</a>
								<!-- <a href="#" class="btn btn-small black"><span class="fa fa-edit" style="position: relative; margin-right: 10px; top: 0.5px;"></span>Editar sus datos</a> -->
							</td>
						</tr>

						<?php

						}

						?>

						<!-- <tr>
							<td style="border-top: 1px solid; border-left: 1px solid;">Fulanito de tal</td>
							<td style="border-top: 1px solid;">11112222</td>
							<td style="border-top: 1px solid;">fulanito@detal.com</td>
							<td style="border-top: 1px solid;">Sin calle pasaje 6</td>
							<td style="border-top: 1px solid;">24023037<br>091066416</td>
							<td style="border-top: 1px solid; border-right: 1px solid;">Departamento, Localidad</td>
						</tr>
						<tr>
							<td colspan="6" style="border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid;">
								<a href="#" class="btn btn-small black"><span class="fa "></span>Ver ficha completa</a>
								<a href="#" class="btn btn-small black"><span class="fa "></span>Descargar ficha completa</a>
								<a href="#" class="btn btn-small black"><span class="fa "></span>Editar sus datos</a>
							</td>
						</tr> -->
					</tbody>
				</table>

				<pre>
				<?php

				// print_r($todasLosUsuarios);

				?>
				</pre>

			</div>
		</div>

<?php

loadSection("footer", $userStats);
endDocument();

?>