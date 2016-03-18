<?php

$relative = '..';
require '../includes/common.php';

$userStats = loadUser();
$appPlace = 'contact';
$appSubPlace = '';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadHeader("header");

?>
				
					<h1><span>Ponte en contacto con nosotros</span></h1>
					<div class="home-block">
						<div class="left-column">
							<h3>¿Tienes sugerencias, consultas o quizás alguna duda?</h3>
							<p>Aquí encuentras a tu disposición todas las formas de contacto, utiliza la que mejor se adapte a tus necesidades.</p>
							<div class="contact-info">
								<h3>Datos de contacto</h3>
								<ul>
									<li><span class="fa fa-street-view"></span><strong>Dirección:</strong> <em>Arenal Grande 1111 esquina Blandengues</em></li>
									<li><span class="fa fa-phone"></span><strong>Teléfono:</strong> <em>2240 32 32 - 2410 21 21</em></li>
									<li><span class="fa fa-envelope"></span><strong>Correo Electrónico:</strong> <em>info@unifit.com.uy</em></li>
									<li><span class="fa fa-share-alt"></span><strong>Siguenos en Facebook:</strong> <span class="fa fa-facebook-official"></span></li>
								</ul>
							</div>
						</div>
						<div class="right-column">
							<form action="/contacto/index.php" method="POST" id="contact-form">
								<input type="text" class="shadow-3" placeholder="Tu nombre" name="nombre">
								<input type="text" class="shadow-3" placeholder="Tu apellido" name="apellido">
								<input type="text" class="shadow-3" placeholder="Tu email" name="email">
								<input type="text" class="shadow-3" placeholder="¿Sobre que deseas escribir?" name="asunto">
								<textarea class="shadow-3" placeholder="Déjanos tu mensaje" name="mensaje"></textarea>
								<button type="submit" class="shadow-3" name="enviar">Enviar</button>
							</form>
						</div>
					</div>


<?php

loadFooter("footer");
endDocument();

?>