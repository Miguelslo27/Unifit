<?php

$relative = '..';
require '../includes/common.php';

$userStats = array('user' => NULL, 'cart' => NULL,  'status' => 'READY_TO_LOGIN');
$appPlace = 'home';
$appSubPlace = 'pass-reset';
$templatesPath = $GLOBALS['config']['templatesPath'];

if(isset($_POST['email'])) {
	$checkEmail = checkEmail($_POST['email']);
}

startDocument();
loadHeader("header");

?>
		<?php if(!isset($_POST['email'])) : ?>

			<div class="home-block">
				<h1><span>Recuperación de contraseña</span></h1>
				<div class="left-column">
					<p>Si has olvidado tu contraseña, sólo debes ingresar el email con el que te has registrado a continuación, de inmediato te será enviado un correo a tu casilla con las instrucciones para la recuperación.</p>
				</div>
				<div class="right-column">
					<form action="/recuperar-clave/" method="post">
						<input type="email" name="email" required class="shadow-3" placeholder="Tu email">
						<button type="submit" class="shadow-3">Enviar</button>
					</form>
				</div>
			</div>

		<?php elseif($checkEmail) : ?>

			<?php // if(enviarDatosDeRecuperacion($_POST['email'])) : ?>
			<?php if(true) : ?>


			<div class="home-block">
				<h1><span>El email de recuperación ha sido enviado</span></h1>
				<p>Te hemos enviado un email para recuperar tu contraseña, por favor sigue las instrucciones.</p>
				<p>Por favor, revisa tu casilla de correos para seguir las instrucciones de recuperación, en breve estarás de vuelta con nosotros.</p>
			</div>

			<?php else : ?>

			<div class="home-block">
				<h1><span>El email de recuperacion no ha podido ser enviado</span></h1>
				<p>Ha habido un error al enviarte las instrucciones, por favor, vuelve a intentarlo más tarde.</p>
			</div>

			<?php endif; ?>

		<?php else : ?>

			<div class="home-block">
				<h1><span>Error en el email de recuperación</span></h1>
				<div class="left-column">
					<p>Parece ser que el email que has ingresado para recuperar tu contraseña, no se encuentra registrado en el sistema.</p>
					<p>Por favor, verifica el email ingresado e inténtalo nuevamente.</p>
					<p>Si no te has registrado aún puedes hacerlo <a href="/registro/">aquí</a>.</p>
				</div>
				<div class="right-column">
					<form action="/recuperar-clave/" method="post">
						<input type="email" name="email" required class="shadow-3" placeholder="Tu email" value="<?php echo $_POST['email'] ?>">
						<button type="submit" class="shadow-3">Enviar</button>
					</form>
				</div>
			</div>

		<?php endif; ?>

<?php

loadFooter("footer");
endDocument();

?>