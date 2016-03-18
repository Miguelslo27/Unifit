<?php

$relative = '..';
require '../includes/common.php';

$userStats = saveUser();
$appPlace = 'home';
$appSubPlace = 'register';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadHeader("header");

?>

<?php if(!$userStats['user'] || ($userStats['user'] && isset($_GET['id']))) : ?>

				<?php if(isset($_GET['id'])) : ?>

				<h1><span>Tus datos de usuario</span></h1>
				<h3>Formulario</h3>
				<p>Edita tus datos de usuario con el siguiente formulario.</p>

				<?php else : ?>

				<h1><span>Registro de Usuario</span></h1>
				<h3>Formulario de Registro</h3>
				<p>Completa el siguiente formulario para registrarte.</p>

				<?php endif; ?>

				<?php if(isset($userStats['register_status']) && $userStats['register_status']['status'] == 'ERROR') : ?>

				<div class="error">
					<h3>Algunos de los campos obligatorios no fueron completados correctamente</h3>
					<p>Verifica que campos quedaron vacíos o que información tiene el formato equivocado.</p>
				</div>

				<?php endif; ?>

				<?php if($userStats['status'] == 'DUPLICATE_EMAIL') : ?>

				<div class="error">
					<h3>El email con el que intentas registrarte ya ha sido utilizado por alguien más</h3>
					<p>Si ya estás registrado en el sistema, puedes loguearte con tu nombre de usuario y contraseña <a href="/login/?email=<?php echo $_POST['email'] ?>">aquí</a>.</p>
					<p>Si has olvidado la contraseña, puedes recuperarla <a href="/recuperar-clave/?email=<?php echo $_POST['email'] ?>">aquí</a>.</p>
					<p>Si por el contrario crees que ha habido un error, por favor, notificalo a través de nuestro <a href="/contacto/?email=<?php echo $_POST['email'] ?>">formulario de contacto</a>.</p>
				</div>

				<?php endif; ?>

				<?php if(isset($_POST['guardar']) && $userStats['register_status']['status'] == 'OK') : ?>

				<div class="good_notice">
					<h3>Los cambios se han efectuado con éxito</h3>
				</div>

				<?php endif; ?>

				<form action="/registro/<?php echo (isset($_GET['id']) ? '?id=' . $_GET['id'] : ''); ?>" method="post">

					<?php if(isset($_GET['id'])) : ?>
					<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
					<?php endif; ?>

					<div class="home-block">

						<?php if(isset($_GET['id'])) : ?>
						<h3>Edita tus datos de usuario</h2>
						<?php else : ?>
						<h3>Completa con tus datos de usuario</h2>
						<?php endif; ?>
						
						<div class="left-column">

							<?php if(isset($userStats['register_status']) && $userStats['register_status']['status'] == 'ERROR' && isset($userStats['register_status']['fields_messages']['nombre'])) : ?>
							<span class="error">
							<?php endif; ?>

								<input class="shadow-3" tabindex="1" type="text" placeholder="Ingresa tu nombre (requerido)" required name="nombre" value="<?php echo ($userStats['user'] ? $userStats['user']->nombre : (isset($_POST['guardar']) && $_POST['nombre'] != '' && !isset($userStats['register_status']['fields_messages']['nombre']) ? $_POST['nombre'] : '')); ?>">

							<?php if(isset($userStats['register_status']) && $userStats['register_status']['status'] == 'ERROR' && isset($userStats['register_status']['fields_messages']['nombre'])) : ?>
							</span>
							<?php endif; ?>

							<input class="shadow-3" tabindex="3" type="text" placeholder="Ingresa tu direccion" name="direccion" value="<?php echo ($userStats['user'] ? $userStats['user']->direccion : (isset($_POST['guardar']) && $_POST['direccion'] != '' && !isset($userStats['register_status']['fields_messages']['direccion']) ? $_POST['direccion'] : '')); ?>">
							
							<?php if(isset($userStats['register_status']) && $userStats['register_status']['status'] == 'ERROR' && isset($userStats['register_status']['fields_messages']['celular'])) : ?>
							<span class="error">
							<?php endif; ?>

								<input class="shadow-3" tabindex="5" type="text" placeholder="Ingresa tu celular (requerido)" required name="celular" value="<?php echo ($userStats['user'] ? $userStats['user']->celular : (isset($_POST['guardar']) && $_POST['celular'] != '' && !isset($userStats['register_status']['fields_messages']['celular']) ? $_POST['celular'] : '')); ?>">

							<?php if(isset($userStats['register_status']) && $userStats['register_status']['status'] == 'ERROR' && isset($userStats['register_status']['fields_messages']['celular'])) : ?>
							</span>
							<?php endif; ?>

							<input class="shadow-3" tabindex="7" type="text" placeholder="Ingresa tu departamento" name="departamento" value="<?php echo ($userStats['user'] ? $userStats['user']->departamento : (isset($_POST['guardar']) && $_POST['departamento'] != '' && !isset($userStats['register_status']['fields_messages']['departamento']) ? $_POST['departamento'] : '')); ?>">
						</div>
						<div class="right-column">

							<?php if(isset($userStats['register_status']) && $userStats['register_status']['status'] == 'ERROR' && isset($userStats['register_status']['fields_messages']['apellido'])) : ?>
							<span class="error">
							<?php endif; ?>

								<input class="shadow-3" tabindex="2" type="text" placeholder="Ingresa tu apellido (requerido)" required name="apellido" value="<?php echo ($userStats['user'] ? $userStats['user']->apellido : (isset($_POST['guardar']) && $_POST['apellido'] != '' && !isset($userStats['register_status']['fields_messages']['apellido']) ? $_POST['apellido'] : '')); ?>">

							<?php if(isset($userStats['register_status']) && $userStats['register_status']['status'] == 'ERROR' && isset($userStats['register_status']['fields_messages']['apellido'])) : ?>
							</span>
							<?php endif; ?>

							<input class="shadow-3" tabindex="4" type="text" placeholder="Ingresa tu rut" name="rut" value="<?php echo ($userStats['user'] ? $userStats['user']->rut : (isset($_POST['guardar']) && $_POST['rut'] != '' && !isset($userStats['register_status']['fields_messages']['rut']) ? $_POST['rut'] : '')); ?>">
							<input class="shadow-3" tabindex="6" type="text" placeholder="Ingresa tu telefono" name="telefono" value="<?php echo ($userStats['user'] ? $userStats['user']->telefono : (isset($_POST['guardar']) && $_POST['telefono'] != '' && !isset($userStats['register_status']['fields_messages']['telefono']) ? $_POST['telefono'] : '')); ?>">
							<input class="shadow-3" tabindex="8" type="text" placeholder="Ingresa tu ciudad o localidad" name="ciudad" value="<?php echo ($userStats['user'] ? $userStats['user']->ciudad : (isset($_POST['guardar']) && $_POST['ciudad'] != '' && !isset($userStats['register_status']['fields_messages']['ciudad']) ? $_POST['ciudad'] : '')); ?>">
						</div>
					</div>
					<div class="home-block">

						<?php if(isset($_GET['id'])) : ?>
						<h3>Edita tus datos de acceso</h2>
						<?php else : ?>
						<h3>Completa los datos de acceso</h2>
						<?php endif; ?>

						<div class="left-column">

							<?php if(isset($userStats['register_status']) && $userStats['register_status']['status'] == 'ERROR' && isset($userStats['register_status']['fields_messages']['email'])) : ?>
							<span class="error">
							<?php endif; ?>

								<input class="shadow-3" tabindex="9" type="email" placeholder="<?php echo (isset($userStats['register_status']['fields_messages']['email']) && $userStats['register_status']['fields_messages']['email'] == 'EMAIL_MALFORMED' ? 'Ejemplo: usuario@email.com' : 'Ingresa tu email (requerido)') ?>" required name="email" value="<?php echo ($userStats['user'] ? $userStats['user']->email : (isset($_POST['guardar']) && $_POST['email'] != '' && !isset($userStats['register_status']['fields_messages']['email']) ? $_POST['email'] : '')); ?>">

							<?php if(isset($userStats['register_status']) && $userStats['register_status']['status'] == 'ERROR' && isset($userStats['register_status']['fields_messages']['email'])) : ?>
							</span>
							<?php endif; ?>

							<?php if(isset($userStats['register_status']) && $userStats['register_status']['status'] == 'ERROR' && isset($userStats['register_status']['fields_messages']['pass'])) : ?>
							<span class="error">
							<?php endif; ?>

								<input class="shadow-3" tabindex="11" type="password" placeholder="Ingresa tu contraseña (requerido)" required name="pass" value="">

							<?php if(isset($userStats['register_status']) && $userStats['register_status']['status'] == 'ERROR' && isset($userStats['register_status']['fields_messages']['pass'])) : ?>
							</span>
							<?php endif; ?>

						</div>
						<div class="right-column">

							<?php if(isset($userStats['register_status']) && $userStats['register_status']['status'] == 'ERROR' && isset($userStats['register_status']['fields_messages']['email2'])) : ?>
							<span class="error">
							<?php endif; ?>

								<input class="shadow-3" tabindex="10" type="email" placeholder="Repite tu email (requerido)" required name="email2" value="">

							<?php if(isset($userStats['register_status']) && $userStats['register_status']['status'] == 'ERROR' && isset($userStats['register_status']['fields_messages']['email2'])) : ?>
							</span>
							<?php endif; ?>

							<?php if(isset($userStats['register_status']) && $userStats['register_status']['status'] == 'ERROR' && isset($userStats['register_status']['fields_messages']['pass2'])) : ?>
							<span class="error">
							<?php endif; ?>

								<input class="shadow-3" tabindex="12" type="password" placeholder="Repite tu contraseña (requerido)" required name="pass2" value="">

							<?php if(isset($userStats['register_status']) && $userStats['register_status']['status'] == 'ERROR' && isset($userStats['register_status']['fields_messages']['pass2'])) : ?>
							</span>
							<?php endif; ?>

						</div>
					</div>
					<div class="home-block">
						<div class="left-column">

							<?php if(isset($_GET['id'])) : ?>
							<button type="submit" name="guardar" tabindex="13" class="btn btn-primary width-100 shadow-3">Guardar</button>
							<?php else : ?>
							<button type="submit" name="guardar" tabindex="13" class="btn btn-primary width-100 shadow-3">Registrarme</button>
							<?php endif; ?>

						</div>
						<div class="right-column">
							<button type="reset" tabindex="14" class="btn btn-off width-100 shadow-3">Borrar cambios</button>
						</div>
					</div>
				</form>

				<?php if(!isset($_GET['id'])) : ?>

				<h3>¿Qué beneficios tengo al registrarme?</h3>
				<p>Si te gusta lo que has visto hasta ahora en nuestro sitio, registrarte es
				tu mejor opción, ya que te permitirá ver los precios en el catálogo,
				comprar desde la compodidad de tu computadora, teléfono móvil o
				tablet y recibir en la puerta de tu hogar.</p>
				<p>Además podrás recibir catálogos
				por temporada y noticias con promociones y ofertas.</p>
				<p>Aún te quedan dudas? Lee nuestra <a href="/como-comprar">Ayuda</a> y entérate de
				todos los beneficios de registrarte en el sitio.</p>

				<div class="home-block">
					<h1><span>¿Ya te has registrado?</span></h1>
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
								<a href="/como-comprar/">Ayuda del sitio</a><br>
								<a href="/contacto/">Formulario de Contacto</a><br>
							</p>
						</div>
					</form>
				</div>

				<?php endif; ?>

<?php else : ?>

				<h1><span>¡Ya estás registrado!</span></h1>
				
<?php endif; ?>
<?php

loadFooter("footer");
endDocument();

?>