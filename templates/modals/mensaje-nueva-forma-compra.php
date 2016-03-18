	<?php
	global $userStats;
	// var_dump($userStats);
	?>
	<style>
	#mensaje-nueva-forma-compra p { font-size: 13px; }
	</style>
	<div class="modal" id="mensaje-nueva-forma-compra">
		<div class="modal-title">
			<h2><?php echo $userStats['user']->nombre ?> ¡Ahora podés comprar Surtido!</h2>
			<a href="#" class="modal-close action-close"><span class="modal-close-left"></span><span class="modal-close-right"></span></a>
			<span class="line-h">&nbsp;</span>
		</div>
		<div class="modal-content cols cols-1">
			<div class="modal-col modal-col-span1 first-col last-col">
				<div class="modal-col-inner">
					<h3>¿De que se trata comprar surtido?</h3>
					<p>Con las nuevas pestañas de comprar pack y comprar surtido, ahora podrás adquirir los productos tanto por pack como surtidos.</p>
					<p>Comprar por pack-  Los packs vienen surtidos de colores y están armados de 3, 4, 5, 6 unidades, dependiendo cual sea la prenda elegida.</p>
					<p>Comprar surtido- te permitirá comprar artículos en la cantidad que elijas, especificando talle y color a elección.</p>
					<p>Las compras también se puedén realizar de forma mixta, por lo que puedes comprar artículos por pack y surtidos en un mismo pedido.</p>
					<p>A continuación una breve guía de cómo comprar por Pack y Surtido.</p>
					<img src="/statics/images/guia.jpg">
				</div>
			</div>
		</div>
	</div>