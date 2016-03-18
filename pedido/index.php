<?php

$relative = '..';
require '../includes/common.php';

$userStats = loadUser();
$cartItems = $userStats['cart'] ? obtenerPedido($userStats['cart']->id) : NULL;
$appPlace = 'online-history';
$appSubPlace = 'pedido-actual';

startDocument();
loadSection("header", $userStats);
?>

	<style>
	h1 {
		border: 3px solid #1A1A1A;
	    border-radius: 20px;
	    box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.65);
	    float: left;
	    height: 40px;
	    line-height: 40px;
	    margin-left: 15px;
	    margin-top: 20px;
	    padding-left: 15px;
	}
	h1 .title-icon {
		background: url("/statics/images/iconos.png") no-repeat scroll -88px -9px #FFFFFF;
	    border: 3px solid #000000;
	    border-radius: 35px;
	    box-shadow: 3px 3px 3px rgba(0, 0, 0, 0.65);
	    display: inline-block;
	    height: 60px;
	    left: -30px;
	    position: relative;
	    top: -13px;
	    width: 60px;
	}
	h1 span.title {
		font-size: 24px;
	    font-weight: normal;
	    left: -18px;
	    position: relative;
	    top: -35px;
	}
	</style>
	<div class="body">
		<div class="body-inner">
			<!-- <div class="body-content"> -->
				<!-- <h1>Pedido actual</h1> -->
				<h1><span class="title-icon"></span><span class="title">Pedido actual</span></h1>
				<div style="clear: both;"></div>
				<?php
					if ($userStats['user']) {
				?>
				<div class="admin-cmds">
					<!-- <span class="admin-cmd add-category"><a href="/mis-pedidos">Historial de Pedidos</a></span> -->
				</div>
				<?php
				}
				?>
				<!-- <span class="line-h">&nbsp;</span> -->
				<div class="body-content">
					<?php
					if ($userStats['user']) {

						if ($cartItems) {
						?>
					<h2>Hay <?php echo $cartItems['pedido']->cantidad; ?> artículos en tu pedido, por un total de $ <?php echo $cartItems['pedido']->total; ?>,00</h2>
						<?php
						} else {
						?>
					<h2>No hay artículos en su pedido por el momento</h2>
						<?php
						}
						?>
						<span class="line-h">&nbsp;</span>
					
					<pre style="display: none;">
					<?php
					print_r($cartItems);
					?>
					</pre>

					<table id="pedido-actual" class="carrito" align="center" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<td class="imagen">&nbsp;</td>
								<td class="codigo">Código</td>
								<td class="articulo">Artículo</td>
								<!-- <td class="talles">Talles</td> -->
								<td class="cantidad">Unidades</td>
								<td class="subtotal">Subtotal</td>
								<td class="acciones">Eliminar</td>
							</tr>
						</thead>
						<tbody>
							<?php
							if ($cartItems) {
								foreach ($cartItems['articulos'] as $articulo) {
								?>
								<tr>
									<td class="imagen">
										<img src="<?php echo ($articulo->imagenes_url != '' ? str_replace('{id}', $articulo->id, $articulo->imagenes_url) . 'thumbnail.jpg' : '/statics/images/noimage.jpg') ?>">
									</td>
									<td class="codigo"><?php echo $articulo->codigo; ?></td>
									<td class="articulo">
										<?php echo $articulo->nombre; ?><br /><br />
										<span style="font-size: 13px;">
											<strong>Surtido: </strong><span class="valor-surtido"><?php echo $articulo->surtido == 0 ? 'No' : 'Si'; ?></span> -
											<strong>Talles: </strong><?php echo $articulo->talle; ?>
											<?php
												// if($articulo->adaptable == '1') {
												// 	echo 'Adaptable';
												// }
											?><br />
											<strong>Colores: </strong>
											<?php
											$colorsDir  = '..'.str_replace("{id}", $articulo->id, $articulo->colores_url);
											
											?>
											<!-- PROBANDO COLORES:
											<?php
											var_dump($colorsDir);
											echo "\n";
											var_dump(!is_dir($colorsDir));
											?>
											PROBANDO COLORES -->
											<?php
											if($articulo->colores_url == $articulo->imagenes_url) {
												?>
												<img style="margin: 0 0 -5px;" src="..<?php echo str_replace("{id}", $articulo->id, $articulo->imagenes_url); ?>colors.jpg">
												<?php
											} else {
												if(!is_dir($colorsDir)) {
													?>
													<span>No hay colores</span>
													<?php
												} else {
													$colorsFiles = opendir($colorsDir);
													$colorsList = array();
													if(!$colorsFiles) {
														?>
														<span>No hay colores</span>
														<?php
													} else {
														?>
														<ul style="list-style: none; margin: 0; padding: 0; display: inline-block;">
															<?php
															
															$colores = explode(',', $articulo->color);
															
															foreach($colores AS $color) {
																?>
																<li style="display: inline-block;"><span style="border-radius: 8px; border: 2px solid #ccc; height: 14px; width: 14px; display: inline-block; position: relative; bottom: -3px;"><img src="<? echo $colorsDir.$color.'.jpg?'.$revision; ?>" style="border-radius: 7px;"	></span></li>
																<?php
															}
															
															?>
															
														</ul>
												<?php
													}
												} // END IF readdir $colorsDir
											}
										?></span>
									</td>
									<!-- <td class="talles"><?php echo $articulo->talle; ?></td> -->
									<td class="cantidad"><?php echo $articulo->cantidad; ?></td>
									<td class="subtotal">
										<div class="subtotal-wrapper">
										$ <?php echo $articulo->subtotal; ?>,00
										</div>
									</td>
									<td class="acciones">
										<a alt="Eliminar del pedido" title="Eliminar del pedido" class="acciones-carrito accion-eliminar" data-idpedido="<?php echo $articulo->id_pedido; ?>" data-itemid="<?php echo $articulo->id; ?>" data-pedidoid="<?php echo $cartItems['pedido']->id; ?>" data-precioitem="<?php echo $articulo->subtotal; ?>" data-cantidaditem="1" data-totalpedido="<?php echo $cartItems['pedido']->total; ?>" data-totalitems="<?php echo $cartItems['pedido']->cantidad; ?>">+</a>
									</td>
								</tr>
								<?php
								}
							} else {
							?>
							<tr>
								<td colspan="6" class="no-items">No hay artículos para mostrar. Comience a comprar yendo a <a href="/categorias">Precios | Pedidos</a>.</td>
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
								<td class="total-label" colspan="4">Total</td>
								<td class="total-value" colspan="2">$ <?php echo $cartItems['pedido']->total; ?>,00</td>
							</tr>
						</tfoot>
						<?php
						}
						?>
					</table>
					<div class="cart-cmds">
						<a href="/categorias" class="cart-cmd black btn-style">Seguir Comprando</a>
						<?php
						if ($cartItems) {
						?>
						<a class="cart-cmd black btn-style completar-pedido" data-id="<?php echo $cartItems['pedido']->id; ?>">Finalizar Pedido</a>
						<?php
						}
						?>
						<?php
						if ($cartItems) {
						?>
						<!-- <a class="cart-cmd history grey cancelar-pedido" data-id="<?php echo $cartItems['pedido']->id; ?>">Cancelar Pedido</a> -->
						<?php
						}
						?>
					</div>
					<?php
					} else {
					?>
					<h2>Para Precios | Pedido y acceder a lista de precios por mayor, debes estar registrado</h2>
					<span class="line-h">&nbsp;</span>
					<p></p>
					<a href="/registro" class="btn btn-style black">Registrarme</a>
					<?php
					}
					?>

				<!-- </div> -->
				
<?php

loadSection("footer", $userStats);
endDocument();

?>