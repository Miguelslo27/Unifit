<?php
$cartItems = $GLOBALS['cartItems'];
$userStats = $GLOBALS['userStats'];
?>
	<div class="modal" id="completar-pedido">
		<div class="modal-title">
			<h2>Completa tu pedido</h2>
			<a href="#" class="modal-close action-close"><span class="modal-close-left"></span><span class="modal-close-right"></span></a>
			<span class="line-h">&nbsp;</span>
		</div>
		<div class="modal-content cols cols-1">
			<div class="modal-col modal-col-span1 first-col last-col">
				<div class="modal-col-inner">
					<h3>Revisa que tu pedido esté en orden</h3>
					<span class="line-h">&nbsp;</span>
					<p></p>

					<p>Debajo se detallan tus datos y tu pedido, por favor, verifica que todo es correcto, también en los datos de entrega, agencia de preferencia y forma de pago.</p>
					<p>
						<strong>Fecha:</strong> <?php echo date('d/m/Y'); ?><br>
						<strong>Nombre:</strong> <?php echo $userStats['user']->nombre . ' ' . $userStats['user']->apellido; ?><br>
						<strong>Dirección:</strong> <?php echo $userStats['user']->direccion . ', ' . $userStats['user']->departamento . ', ' . $userStats['user']->ciudad; ?>
					</p>

					<form action="/" id="form-confirmar-pedido">
						<caption>Pedido</caption>
						<table id="pedido-actual" align="center" cellpadding="0" cellspacing="0">
							<thead>
								<tr>
									<td class="codigo">Código</td>
									<td class="articulo">Artículo</td>
									<!-- <td class="talles">Talles</td> -->
									<td class="cantidad">Cantidad</td>
									<td class="subtotal">Subtotal</td>
								</tr>
							</thead>
							<tbody>
								<?php
								if ($cartItems) {
									foreach ($cartItems['articulos'] as $articulo) {
									?>
									<tr>
										<td class="codigo"><?php echo $articulo->codigo; ?></td>
										<td class="articulo"><?php echo $articulo->nombre; ?></td>
										<!-- <td class="talles"><?php echo $articulo->talle; ?></td> -->
										<td class="cantidad"><?php echo $articulo->cantidad; ?></td>
										<td class="subtotal">$ <?php echo $articulo->subtotal; ?></td>
									</tr>
									<?php
									}
								} else {
								?>
								<tr>
									<td colspan="4" class="no-items">No hay artículos para mostrar. Comience a comprar yendo a <a href="/categorias">Mis Pedidos Online</a>.</td>
								</tr>
								<?php
								}
								?>
							</tbody>
							<?php
							if ($cartItems) {
							?>
							<tfoot>
								<tr>
									<td class="total-label" colspan="3">Total</td>
									<td class="total-value">$ <?php echo $cartItems['pedido']->total; ?></td>
								</tr>
							</tfoot>
							<?php
							}
							?>
						</table>
						<p></p>
						<!-- <div class="form-line">
							<label class="label"><strong>Selecciona forma de entrega</strong></label>
						</div> -->
						
						<div class="form-line">
							<label class="label" for="direccion_de_entrega"><strong>Seleccione lugar de entrega</strong></label>
							<div class="mensaje-de-error" id="mensajes-de-error" style="display: none;">
								<p><strong>Antes de finalizar el pedido, chequee los siguientes datos</strong></p>
								<ul class="datos-de-error">
								</ul>
							</div>
						</div>

						<!-- Envio al interior forumulario completo -->
						<div class="form-line">
							<label class="label">
								<input type="radio" name="envio" id="envio_interior" data-show="envio-interior-form" data-formadepago="show">En el interior
							</label>
						</div>
						<div id="envio-interior-form" class="formulario-oculto">
							
							<!-- Retira en agencia formulario -->
							<div class="form-line">
								<label class="label">
									<input type="radio" name="enviosub" id="envio_interior_retira_agencia" data-show="retira-agencia-interior-form" data-formadepago="show">Retira en Agencia
								</label>
							</div>
							<div id="retira-agencia-interior-form" class="formulario-oculto">
								<div class="form-line">
									<label for="agencia-entrega-interior-input" class="label">Agencia</label>
									<input type="text" class="input" id="agencia-entrega-interior-input" name="agencia-entrega-interior-input">
								</div>
							</div>
							<!-- final de Retira en agencia formulario -->

							<!-- Direccion de entrega formulario -->
							<div class="form-line">
								<label class="label">
									<input type="radio" name="enviosub" id="envio_interior_direccion_entrega" checked="true" data-show="direccion-entrega-interior-form" data-formadepago="show">Dirección de entrega
								</label>
							</div>
							<div id="direccion-entrega-interior-form" class="formulario-oculto">
								<div class="form-line">
									<label for="direccion-entrega-interior-input" class="label">Direccion</label>
									<input type="text" class="input" id="direccion-entrega-interior-input" name="direccion-entrega-interior-input" value="<?php echo $userStats['user']->direccion . ', ' . $userStats['user']->departamento . ', ' . $userStats['user']->ciudad; ?>">
								</div>
								<div class="form-line">
									<label for="agencia-entrega-input" class="label">Agencia</label>
									<input type="text" class="input" id="agencia-entrega-input" name="agencia-entrega-input">
								</div>
							</div>
							<!-- final de Direccion de entrega formulario -->

						</div>
						<!-- final de Envio al interior formulario -->

						<!-- Envio en Montevideo formulario completo -->
						<div class="form-line">
							<label class="label">
								<input type="radio" name="envio" id="envio_montevideo" data-show="envio-montevideo-form">En Montevideo
							</label>
						</div>
						<div id="envio-montevideo-form" class="formulario-oculto">

							<!-- Retira y paga en local formulario -->
							<div class="form-line">
								<label class="label">
									<input type="radio" name="enviosub2" id="envio_montevideo_retira_local" data-show="retira-paga-local">Retira y paga en local Monique
								</label>
							</div>
							<div id="retira-paga-local" class="formulario-oculto">
								<p>Ha especificado que retira y abona en el local de Monique.</p>
								<p>Una vez finalizado el pedido, diríjase con el número del mismo a nuestro local, ubicado en Arenal Grande 2380.</p>
							</div>
							<!-- final de Retira y paga en local formulario -->
							
							<!-- Direccion de entrega formulario -->
							<div class="form-line">
								<label class="label">
									<input type="radio" name="enviosub2" id="envio_montevideo_direccion_entrega" checked="true" data-show="direccion-entrega-montevideo-form" data-formadepago="show">Dirección de entrega
								</label>
							</div>
							<div id="direccion-entrega-montevideo-form" class="formulario-oculto">
								<div class="form-line">
									<label for="direccion-entrega-montevideo-input" class="label">Direccion</label>
									<input type="text" class="input" id="direccion-entrega-montevideo-input" name="direccion-entrega-montevideo-input" value="<?php echo $userStats['user']->direccion . ', ' . $userStats['user']->departamento . ', ' . $userStats['user']->ciudad; ?>">
								</div>
							</div>
							<!-- final de Direccion de entrega formulario -->

						</div>
						<!-- final de Envio en Montevideo formulario -->

						<div class="form-line formulario-oculto" id="forma_de_pago_c">
							<label class="label">Forma de pago</label>
							<label><input type="radio" value="Abitab" name="forma_de_pago" id="forma_de_pago_abitab">Abitab</label>
							<label><input type="radio" value="RedPagos" name="forma_de_pago" id="forma_de_pago_redpagos">RedPagos</label>
							<label><input type="radio" value="BROU" name="forma_de_pago" id="forma_de_pago_brou">BROU</label>
						</div>
						<p></p>
						<div class="form-line form-commands">
							<a href="#" class="btn black btn-style terminar-confirmacion-pedido" data-id="<?php echo $cartItems['pedido']->id; ?>">Enviar Pedido</a>
							<a href="#" class="btn grey btn-style action-close">Cancelar</a>
						</div>
					</form>
					<div class="cargando">Estamos procesando tu pedido.<br>Por favor aguarda un momento...</div>
				</div>
			</div>
		</div>
	</div>