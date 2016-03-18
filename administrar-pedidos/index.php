<?php

$relative = '..';
require '../includes/common.php';

$userStats = loadUser();
if ($userStats['user']->administrador == 0 ) {

	echo "Acceso restringido!";
	return;

}
// $cartItems = $userStats['cart'] ? obtenerPedido($userStats['cart']->id) : NULL;
$todasLasOrdenes = obtenerPedidos(NULL, isset($_GET['estado']) ? $_GET['estado'] : NULL);
$appPlace = 'online-history';
$appSubPlace = 'administrar-pedidos';

startDocument();
loadSection("header", $userStats);
?>

	<div class="body">
		<div class="body-inner">
			<div class="body-content">
				<h1>Administración de Pedidos</h1>
				<div class="admin-cmds">
					<span class="admin-cmd <?php echo !isset($_GET['estado']) ? 'filtro-activo' : ''; ?>"><a href="/administrar-pedidos">Ver Todas</a></span>
					<span class="admin-cmd <?php echo isset($_GET['estado']) && $_GET['estado'] == 5 ? 'filtro-cerrado-activo' : ''; ?>"><a href="/administrar-pedidos?estado=5">Ver Cerradas</a></span>
					<span class="admin-cmd <?php echo isset($_GET['estado']) && $_GET['estado'] == 1 ? 'filtro-pendiente-activo' : ''; ?>"><a href="/administrar-pedidos?estado=1">Ver Pendientes</a></span>
					<span class="admin-cmd <?php echo isset($_GET['estado']) && $_GET['estado'] == 2 ? 'filtro-aprobado-activo' : ''; ?>"><a href="/administrar-pedidos?estado=2">Ver Aprobadas</a></span>
					<span class="admin-cmd <?php echo isset($_GET['estado']) && $_GET['estado'] == 3 ? 'filtro-cancelado-activo' : ''; ?>"><a href="/administrar-pedidos?estado=3">Ver Canceladas</a></span>
					<span class="admin-cmd <?php echo isset($_GET['estado']) && $_GET['estado'] == 4 ? 'filtro-abierto-activo' : ''; ?>"><a href="/administrar-pedidos?estado=4">Ver Abiertas</a></span>
					<span class="admin-cmd"><a href="javascript:document.location.href=document.location.href;">Actualizar la vista</a></span>
				</div>
				<span class="line-h">&nbsp;</span>
				<div class="administracion-ordenes">

				<?php
				if ($todasLasOrdenes) {
					foreach($todasLasOrdenes as $orden) {
				?>

					<div class="orden-info<?php
						switch($orden->estado) {
						
							case 1: // Pendiente
						
							echo ' orden-pendiente';
						
							break;
							case 2: // Aprobado
						
							echo ' orden-aprobada';
						
							break;
							case 3: // Cancelado
						
							echo ' orden-cancelada';
						
							break;
							case 4: // Abierta
						
							echo ' orden-abierta';
						
							break;
						
						}
						?>">
						<div class="usuario-info">
							<div class="usuario-data usuario-nombre">
								<span class="label">Orden a nombre de:</span>
								<span class="value"><?php echo $orden->nombre . ' ' . $orden->apellido; ?></span>
							</div>
							<div class="usuario-data usuario-rut">
								<span class="label">RUT:</span>
								<span class="value"><?php echo $orden->rut; ?></span>
							</div>
							<div class="usuario-data usuario-telefono">
								<span class="label">Telefono de contacto:</span>
								<span class="value"><?php echo $orden->telefono; ?></span>
							</div>
							<div class="usuario-data usuario-email">
								<span class="label">Email de contacto:</span>
								<span class="value"><?php echo $orden->email; ?></span>
							</div>
						</div>
						<div class="order-id"><a href="/detalle?id=<?php echo $orden->id; ?>">Orden <?php echo $orden->id; ?> (<?php
						switch($orden->estado) {
						
							case 1: // Pendiente
						
							echo 'pendiente de aprobación';
						
							break;
							case 2: // Aprobado
						
							echo 'aprobada por el administrador';
						
							break;
							case 3: // Cancelado
						
							echo 'cancelada por el administrador';
						
							break;
							case 4: // Abierta
						
							echo 'aún se encuentra abierta';
						
							break;
						
						}
						?>)</a></div>
						<div class="order-inner">
							<div class="orden-data orden-id"><span class="label">Número de orden: </span><span class="value"><?php echo $orden->id; ?></span></div>
							<div class="orden-data orden-fecha"><span class="label">Fecha de creación: </span><span class="value"><?php echo $orden->fecha; ?></span></div>
							<div class="orden-data orden-cantidad"><span class="label">Cantidad de artículos: </span><span class="value"><?php echo $orden->cantidad; ?></span></div>
							<div class="orden-data orden-total"><span class="label">Total de la orden: </span><span class="value">$ <?php echo $orden->total; ?>,00</span></div>
							<div class="orden-data orden-acciones">
								<?php
								switch ($orden->estado) {

									case 1: // Pendiente
						
									?>
								<a class="btn btn-small black btn-style aprobar" data-id="<?php echo $orden->id; ?>">Aprobar</a>
								<a class="btn btn-small grey btn-style cancelar" data-id="<?php echo $orden->id; ?>">Cancelar</a>
									<?php
								
									break;
									case 2: // Aprobado
								
									?>
								<a class="btn btn-small grey btn-style cancelar" data-id="<?php echo $orden->id; ?>">Cancelar</a>
									<?php
								
									break;
									case 3: // Cancelado
								
									?>
								<a class="btn btn-small purple btn-style pendiente" data-id="<?php echo $orden->id; ?>">Posponer</a>
									<?php
								
									break;
									case 4: // Abierta
								
									?>
								<span class="label">Aun sin finalizado</span>
									<?php
								
									break;

								}
								?>
							</div>
						</div>
					</div>

				<?php
					}
				} else {
					?>
					<p>De momento no hay ordenes que administrar</p>
					<?php
				}
				?>
				</div>
				<?php
// echo '<pre>';
// print_r($todasLasOrdenes);
// echo '</pre>';

loadSection("footer", $userStats);
endDocument();

?>