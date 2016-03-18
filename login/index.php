<?php

$relative = '..';
require '../includes/common.php';

$userStats   = loginUser();
$appPlace    = 'home';
$appSubPlace = 'login';

returnIfLoggedIn($userStats);

startDocument();
loadHeader("header");

?>

				<div class="home-block">
					<h1><span>Ingreso de usuario registrado</span></h1>

					<?php
					if($userStats['status'] == 'ERROR_EMAIL_OR_PASS') {
						?>

						<div class="error">
							<h3>El email o password ingresados son incorrectos</h3>
							<p>Por favor, verifica la información ingresada</p>
						</div>

						<?php
					}
					?>

					<form action="/login/" method="post">
						<div class="left-column">
							<input type="email" name="email" class="shadow-3" placeholder="Tu email" value="<?php echo isset($_GET['email']) ? $_GET['email'] : '' ?>">
							<input type="password" name="pass" class="shadow-3" placeholder="Tu contraseña">
							<button type="submit" name="submit" class="btn btn-primary width-100 shadow-3">Entrar</button>
						</div>
						<div class="right-column">
							<h3>Links útiles</h3>
							<p>
								<a href="/recuperar-clave/">Recuperar contraseña</a><br>
								<a href="/registro/">Registrarme</a><br>
								<a href="/como-comprar/">Ayuda del sitio</a><br>
								<a href="/contacto/">Formulario de Contacto</a><br>
							</p>
						</div>
					</form>
				</div>
				<div class="home-block">
					<h1><span>¿No te has registrado aún?</span></h1>
					<div class="left-column">
						<h3>¿Qué beneficios tengo al registrarme?</h3>
						<p>Si te gusta lo que has visto hasta ahora en nuestro sitio, registrarte es
						tu mejor opción, ya que te permitirá ver los precios en el catálogo,
						comprar desde la compodidad de tu computadora, teléfono móvil o
						tablet y recibir en la puerta de tu hogar.</p>

						<p>Además podrás recibir catálogos
						por temporada y noticias con promociones y ofertas.</p>

						<p>Aún te quedan dudas? Lee nuestra <a href="/como-comprar">Ayuda</a> y entérate de
						todos los beneficios de registrarte en el sitio.</p>
					</div>
					<div class="right-column">
						<form>
							<input type="text" placeholder="Nombre" class="shadow-3">
							<input type="text" placeholder="Apellido" class="shadow-3">
							<input type="email" placeholder="Email" class="shadow-3">
							<label><input type="checkbox"> <span>Deseo recibir catálogo y noticias</span></label>
							<button type="submit" class="shadow-3">REGISTRARME</button>
						</form>
					</div>
				</div>
<?php

loadFooter("footer");
endDocument();

?>