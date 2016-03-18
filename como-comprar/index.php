<?php

$relative = '..';
require '../includes/common.php';

$userStats = loadUser();
$appPlace = 'hoy-to-buy';
$appSubPlace = '';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadSection("header", $userStats);

?>

	<style>
	.body-content p {
		font-size: 16px;
		color: #666;
	}
	.body-content ul li {
		color: #666;
	}
	h1 {
		font-size: 28px;
		margin-bottom: 15px;
	}
	.body-content h2 {
		font-size: 18px;
		margin-bottom: 15px;
	}
	.body-content p {
		font-size: 14px;
		margin-bottom: 15px;
	}
	#body .body-inner {
		/*width: 790px;*/
	}
	.como-comprar-wrap {
		box-shadow: -10px 10px 10px rgba(0,0,0,0.45);
    	margin-left: 25px;
	}
	.como-comprar-inn {
		box-shadow: -5px -5px 10px rgba(0, 0, 0, 0.45) inset;
		border: 1px solid #aaa;
	}
	.como-comprar-cont {
		background: url("/statics/images/espiral.png") repeat-y scroll 0 0 rgba(0, 0, 0, 0);
	    left: -30px;
	    margin: 40px 0;
	    padding: 0 100px 0 140px;
	    position: relative;
	    right: 0;
	}
	</style>
	<div class="body">
		<div class="body-inner">
			<div class="como-comprar-wrap">
				<div class="como-comprar-inn">
					<div class="como-comprar-cont">
						<h1><span class="fa fa-shopping-cart" style="font-size: 24px"></span> Guia de compra</h1>
						<!-- <span class="line-h"></span> -->
						<div class="body-content">
							
							<h2>¿Qué debo hacer para comprar en monique.com.uy?</h2>
							<p>Para poder comprar, debes <a href="/registro/">registrarte</a> en Monique.com.uy. Una vez registrado ya puedes comprar dirigiéndote a <a href="/categorias/">Precios | Pedidos</a>, en la barra de navegación superior.</p>
							<p>Ya registrado, podrás volver cuando quieras, e ingresar con tu usuario y contraseña.</p>
							<p>Ingresa, poniendo tu usuario y contraseña y ya podrás realizar pedidos online y acceder a nuestra lista de precios por mayor.</p>
							
							<!-- <span class="line-h"></span> -->
							<br />
							<h2>Se puede comprar por teléfono, email, o solo por la pagina web?</h2>
							<p>Los pedidos se pueden hacer:</p>
							<p>
								<ul>
									<li>Directos desde la pagina web, a través del carrito de compra.</li>
									<li>Telefónicamente al 22003328 / 22098151.</li>
									<li>Enviándonos un mail a moniqueindumentaria@hotmail.com</li>
									<li>Visitarnos a nuestro local mayorista de Arenal Grande 2380 de lunes a viernes de 9 a 18hs y sábados de 9 a 13hs.</li>
								</ul>
							</p>
							
							<!-- <span class="line-h"></span> -->
							<br />
							<h2>Cual es el mínimo para realizar una compra?</h2>
							<p>Las prendas vienen por packs. Los packs vienen surtidos de colores y están armados de 3, 4, 5, 6 unidades, dependiendo cual sea la prenda elegida. La compra mínima para el envio de pedidos, es de $2000 si el pedido es Mixto o sólo Packs, y de $2500 si sólo compra Surtido.</p>
							<br>
							<h2>Ahora también podés comprar surtido.</h2>
							<h3>¿De que se trata comprar surtido?</h3>
							<p>Con las nuevas pestañas de comprar pack y comprar surtido, ahora podrás adquirir los productos tanto por pack como surtidos.</p>
							<p>Comprar por pack-  Los packs vienen surtidos de colores y están armados de 3, 4, 5, 6 unidades, dependiendo cual sea la prenda elegida.</p>
							<p>Comprar surtido- te permitirá comprar artículos en la cantidad que elijas, especificando talle y color a elección.</p>
							<p>Las compras también se puedén realizar de forma mixta, por lo que puedes comprar artículos por pack y surtidos en un mismo pedido.</p>
							<p>A continuación una breve guía de cómo comprar por Pack y Surtido.</p>
							<img src="/statics/images/guia.jpg">
							
							<!-- <span class="line-h"></span> -->
							<br />
							<h2>Cual es la forma de pago?</h2>
							<p>Depositando en nuestra cuenta del Brou / giros por Abitab o Red pagos.</p>
							<p>Una vez realizada la compra, nos pondremos en contacto con Ud para reconfirmar su pedido y coordinar pago y envío.</p>
						
							<!-- <span class="line-h"></span> -->
							<br />
							<h2>¿Cuánto demora en llegar la mercadería una vez confirmada la compra?</h2>
							<p>Una vez recibido el pago, la mercadería será enviada dentro de las 24 hs.</p>
						</div>
					</div>
				</div>

<?php

loadSection("footer", $userStats);
endDocument();

?>