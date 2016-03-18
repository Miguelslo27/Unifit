<?php

$relative = '..';
require '../includes/common.php';

$appPlace    = 'instalacion';
$appSubPlace = 'configuracion-db';

startDocument();
loadSection("header-install");

?>
	<div class="body">
		<div class="body-inner">
			<div class="body-content">
				<h1><span>Instalación</span><span class="subtitle">- Asistente de configuración de eCommerceApp</span></h1>
				<p>El sistema no ha sido instalado en este hosting, por lo que es obligatorio seguir el siguiente asistente de instalación para crear una correcta experiencia de usuario.</p>
				<?php
				if(count($_POST) && ((isset($_POST['db_host']) && trim($_POST['db_host']) == '') || (isset($_POST['db_user']) && trim($_POST['db_user']) == '') || (isset($_POST['db_name']) && trim($_POST['db_name']) == ''))) {
					?>

					<div class="error">
						<h3>Algunos de los campos obligatorios no fueron completados</h3>
						<p>Verifica que campos quedaron vacíos.</p>
					</div>

					<?php
				} elseif(count($_POST)) {
					// check data and save config
					$configStatus = checkConfig($_POST);
					if($configStatus['status'] == 'ok') {
						if(saveConfig($_POST)) {
							header('Location: /instalacion/table-prefix/');
						} else {
							?>

							<div class="error">
								<h3>Hubo un error inesperado al guardar la configuración</h3>
								<p>Este ha sido un error del sistema, chequea con el administrador para averiguar que pudo haber pasado.</p>
							</div>

							<?php
						}
					} else {
						?>

						<div class="error">
							<h3>Los datos ingresados no pudieron ser salvados</h3>
							<p>Chequea que los datos ingresados sean los adecuados y estén correctamente escritos.</p>
						</div>

						<?php
					}
				}
				?>
				<form action="/instalacion/index.php" method="post" id="settings">
					<h3>Paso 1: Host</h3>
					<p>Especifique el host (url o dirección IP) donde se encuentra alojada la base de datos, si se encuentra alojada en este mismo servidor, debe especificar "localhost".</p>
					<?php if(count($_POST) && ((isset($_POST['db_host']) && trim($_POST['db_host']) == ''))) : ?>
					<span class="error">
					<?php endif; ?>
					<input type="text" name="db_host" placeholder="Host de la Base de Datos" class="shadow-3" required>
					<?php if(count($_POST) && ((isset($_POST['db_host']) && trim($_POST['db_host']) == ''))) : ?>
					</span>
					<?php endif; ?>
					<h3>Paso 2: Usuario</h3>
					<p>Especifique el nombre de usuario con el cual conecta con la base de datos.</p>
					<p>Si tiene dudas al respecto, póngase en contacto con el Administrador del sistema</p>
					<?php if(count($_POST) && ((isset($_POST['db_user']) && trim($_POST['db_user']) == ''))) : ?>
					<span class="error">
					<?php endif; ?>
					<input type="text" name="db_user" placeholder="Usuario de la Base de Datos" class="shadow-3" required>
					<?php if(count($_POST) && ((isset($_POST['db_user']) && trim($_POST['db_user']) == ''))) : ?>
					</span>
					<?php endif; ?>
					<h3>Paso 3: Contraseña</h3>
					<p>Especifique la contraseña con la cual conecta con la base de datos</p>
					<input type="password" name="db_pass" placeholder="Contraseña de la Base de Datos" class="shadow-3">
					<h3>Paso 4: Base de datos</h3>
					<p>Especifique el nombre de la base de datos donde se va a instalar eCommerceApp</p>
					<?php if(count($_POST) && ((isset($_POST['db_user']) && trim($_POST['db_user']) == ''))) : ?>
					<span class="error">
					<?php endif; ?>
					<input type="text" name="db_name" placeholder="Nombre de la Base de Datos" class="shadow-3" required>
					<?php if(count($_POST) && ((isset($_POST['db_user']) && trim($_POST['db_user']) == ''))) : ?>
					</span>
					<?php endif; ?>
					<button type="submit" name="save" class="shadow-3">Siguiente</button>
				</form>
			</div>
<?php

loadSection("footer-install");
endDocument();

?>