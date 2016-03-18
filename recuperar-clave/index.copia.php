<?php

$relative = '..';
require '../includes/common.php';

$userStats = array('user' => NULL, 'cart' => NULL,  'status' => 'READY_TO_LOGIN');
$appPlace = '';
$appSubPlace = '';
$templatesPath = $GLOBALS['config']['templatesPath'];

$checkEmail = checkEmail($_POST['email']);

startDocument();
loadSection("header", $userStats);

?>

	<style>
	#reset-pass-form .input { float: left; width: 250px; margin-right: 10px; }
	#reset-pass-form .btn { line-height: 20px; }
	#reset-pass-form .form-line.form-commands { text-align: left; }
	.error {
		background: none repeat scroll 0 0 #f8bbb8;
	    border: 1px solid #aa0000;
	    color: #aa0000;
	    padding: 15px;
	}
	.success {
		background: none repeat scroll 0 0 #c0dfbe;
	    border: 1px solid #41973a;
	    color: #2a8123;
	    padding: 15px;
	}
	</style>
	<div class="body">
		<div class="body-inner">
			<div class="body-content">
				
				<h1>Recuperar contraseña</h1>

				<?php
				if(isset($_POST['clave1'])) {

					if(checkClaves($_POST['clave1'], $_POST['clave2'])) {
						?>

						<div class="success">Tu contraseña se ha cambiado con éxito, ya puedes ingresar a Monique.com.uy con tu nueva contraseña.</div>

						<?php
					} else {

						if($_POST['clave1'] != $_POST['clave2']) {
							?>

							<div class="error">Las contraseñas ingresadas son diferentes, debes ingresar dos veces la misma contraseña por seguridad.</div>
							<form action="/recuperar-clave/index.php" method="POST" id="reset-pass-form">
								<div class="form-line">
									<label for="clave1">Contraseña</label>
									<input type="password" class="input" id="clave1" name="clave1">
								</div>
								<div class="form-line">
									<label for="clave2">Repetir Contraseña</label>
									<input type="password" class="input" id="clave2" name="clave2">
								</div>
								<div class="form-line">
									<label for="">&nbsp;</label>
									<button type="submit" name="submit" value="enviar" class="btn black btn-style">Enviar</button>
								<div class="form-line">
							</form>

							<?php
						} else {
							?>

							<div class="error">Hubo un error cambiando tu contraseña, por favor, vuelve a intentarlo más tarde.</div>

							<?php
						}

					}

				} else {
					if(isset($_GET['c'])) {
						// aca lo de recuperar mismo
						if(checkCodigoDeValidacion($_GET['c'])) {
							// muestro el formulario con los campos para una nueva contraseña
							?>
							<form action="/recuperar-clave/index.php" method="POST" id="reset-pass-form">
								<div class="form-line">
									<label for="clave1">Contraseña</label>
									<input type="password" class="input" id="clave1" name="clave1">
								</div>
								<div class="form-line">
									<label for="clave2">Repetir Contraseña</label>
									<input type="password" class="input" id="clave2" name="clave2">
								</div>
								<div class="form-line">
									<label for="">&nbsp;</label>
									<button type="submit" name="submit" value="enviar" class="btn black btn-style">Enviar</button>
								<div class="form-line">
							</form>
							<?php
						} else {
							// muestro un error
							?>
							<div class="error">
								Hubo un error al comprobar el código de validación para cambiar tu contraseña, por favor, intenta más tarde, o vuelve a solicitar la recuperación.
							</div>
							<p>Si has olvidado tu contraseña, sólo debes ingresar el email con el que te has registrado en Monique.com.uy a continuación, de inmediato te será enviado un correo a tu casilla con las instrucciones para la recuperación.</p>
							<form action="/recuperar-clave/index.php" method="POST" id="reset-pass-form">
								<div class="form-line">
									<label for="email">Tu Email</label>
									<input type="text" class="input" id="email" name="email">
									<button type="submit" name="submit" value="enviar" class="btn black btn-style">Enviar</button>
								</div>
							</form>
							<?php
						}
					} else {
						if(isset($_POST['email']) && !$checkEmail) {
						?>
						<div class="error">
							No hemos encontrado ningún usuario registrado con el email que ingresaste, prubea otra vez.
						</div>
						<?php
						} elseif(isset($_POST['email']) && $checkEmail) {
							if(enviarDatosDeRecuperacion($_POST['email'])) {
							?>
							<div class="success">Te hemos enviado un email para recuperar tu contraseña, por favor sigue las instrucciones.</div>
							<?php
							} else {
							?>
							<div class="error">
								Ha habido un error al enviarte las instrucciones, por favor, vuelve a intentarlo más tarde.
							</div>
							<?php
							}
						} 
						if(!isset($_POST['email']) || (isset($_POST['email']) && !$checkEmail)) {
						?>
						<p>Si has olvidado tu contraseña, sólo debes ingresar el email con el que te has registrado en Monique.com.uy a continuación, de inmediato te será enviado un correo a tu casilla con las instrucciones para la recuperación.</p>
						<form action="/recuperar-clave/index.php" method="POST" id="reset-pass-form">
							<div class="form-line">
								<label for="email">Tu Email</label>
								<input type="text" class="input" id="email" name="email">
								<button type="submit" name="submit" value="enviar" class="btn black btn-style">Enviar</button>
							</div>
						</form>
						<?php
						}
					}
				}
				?>

			</div>			
		</div>
	</div>

<?php

loadSection("footer", $userStats);
endDocument();

?>